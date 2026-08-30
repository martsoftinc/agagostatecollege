<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exeat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExeatController extends Controller
{
    public function index(Request $request)
    {
        $query = Exeat::with(['student', 'logger', 'approver'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        $exeats = $query->paginate(15)->withQueryString();

        $students = User::where('role', 'student')
            ->orderBy('name')
            ->get(['id', 'name', 'class', 'programme', 'student_id', 'phone']);

        return view('admin.exeats.index', compact('exeats', 'students'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['logged_by'] = auth()->id();
        $data['status'] = $data['status'] ?? 'approved';

        if (in_array($data['status'], ['approved', 'out'])) {
            $data['approved_by'] = auth()->id();
        }

        $exeat = Exeat::create($data);

        // Send SMS when approved
        if (in_array($exeat->status, ['approved', 'out'])) {
            $this->sendApprovalSms($exeat);
        }

        return redirect()
            ->route('admin.exeats.index')
            ->with('success', 'Exeat logged successfully.');
    }

    public function update(Request $request, Exeat $exeat)
    {
        $oldStatus = $exeat->status;
        $data = $this->validated($request);

        if (($data['status'] ?? null) === 'returned' && empty($data['actual_return_at'])) {
            $data['actual_return_at'] = now();
        }

        // Track who approved it
        if (
            in_array($data['status'] ?? null, ['approved', 'out']) &&
            !in_array($oldStatus, ['approved', 'out'])
        ) {
            $data['approved_by'] = auth()->id();
        }

        $exeat->update($data);

        // Send SMS only when status changes TO approved/out
        if (
            in_array($exeat->status, ['approved', 'out']) &&
            !in_array($oldStatus, ['approved', 'out'])
        ) {
            $this->sendApprovalSms($exeat);
        }

        return redirect()
            ->route('admin.exeats.index')
            ->with('success', 'Exeat updated successfully.');
    }

    public function destroy(Exeat $exeat)
    {
        $exeat->delete();

        return redirect()
            ->route('admin.exeats.index')
            ->with('success', 'Exeat deleted successfully.');
    }

    public function markReturned(Exeat $exeat)
    {
        $exeat->markAsReturned();

        return redirect()
            ->route('admin.exeats.index')
            ->with('success', 'Student marked as returned.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'student_id'         => 'required|exists:users,id',
            'type'               => 'required|in:day,weekend,emergency,medical,other',
            'destination'        => 'required|string|max:255',
            'reason'             => 'required|string',
            'departure_at'       => 'required|date',
            'expected_return_at' => 'required|date|after:departure_at',
            'actual_return_at'   => 'nullable|date',
            'status'             => 'nullable|in:pending,approved,rejected,out,returned,overdue,cancelled',
            'guardian_contact'   => 'nullable|string|max:20',
            'notes'              => 'nullable|string',
        ]);
    }

    /**
     * Send SMS via Mnotify when exeat is approved
     */
    private function sendApprovalSms(Exeat $exeat): void
    {
        $exeat->loadMissing('student');

        $apiKey   = config('services.mnotify.api_key');
        $senderId = config('services.mnotify.sender_id');

        if (!$apiKey) {
            Log::warning('Mnotify API key not configured for exeat SMS');
            return;
        }

        $phones = collect([
            $exeat->student?->phone,
            $exeat->guardian_contact,
        ])
            ->filter()
            ->map(fn ($p) => preg_replace('/\D+/', '', $p))
            ->map(function ($p) {
                if (str_starts_with($p, '0')) {
                    return '233' . substr($p, 1);
                }
                if (str_starts_with($p, '233')) {
                    return $p;
                }
                return $p;
            })
            ->unique()
            ->values()
            ->all();

        if (empty($phones)) {
            Log::warning('No phone numbers for exeat SMS', ['exeat_id' => $exeat->id]);
            return;
        }

        $studentName = $exeat->student?->name ?? 'Student';
        $departure   = $exeat->departure_at->format('d M Y, h:i A');
        $return      = $exeat->expected_return_at->format('d M Y, h:i A');

        $message = "AGOSCO Exeat Approved\n"
            . "Student: {$studentName}\n"
            . "Destination: {$exeat->destination}\n"
            . "Leave: {$departure}\n"
            . "Return by: {$return}\n"
            . "Type: " . ucfirst($exeat->type);

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://api.mnotify.com/api/sms/quick?key=' . $apiKey, [
                'recipient' => $phones,
                'sender'    => $senderId,
                'message'   => $message,
            ]);

            if (!$response->successful()) {
                Log::error('Exeat SMS failed', [
                    'exeat_id' => $exeat->id,
                    'status'   => $response->status(),
                    'body'     => $response->body(),
                ]);
            } else {
                Log::info('Exeat SMS sent', [
                    'exeat_id' => $exeat->id,
                    'phones'   => $phones,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Exeat SMS exception', [
                'exeat_id' => $exeat->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }
}