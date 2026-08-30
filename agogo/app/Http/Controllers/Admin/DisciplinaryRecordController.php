<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DisciplinaryRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DisciplinaryRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = DisciplinaryRecord::with(['student', 'reporter'])
            ->latest('incident_date');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('severity')) {
            $query->where('severity', $request->severity);
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%");
            });
        }

        $records = $query->paginate(15)->withQueryString();

        $students = User::where('role', 'student')
            ->orderBy('name')
            ->get(['id', 'name', 'class', 'programme', 'student_id', 'phone', 'guardian_phone']);

        return view('admin.disciplinary.index', compact('records', 'students'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['reported_by'] = auth()->id();

        if (($data['status'] ?? null) === 'resolved') {
            $data['resolved_at'] = now();
        }

        $record = DisciplinaryRecord::create($data);

        // Optional guardian SMS
        if ($request->boolean('notify_guardian')) {
            $this->sendGuardianSms($record);
        }

        return redirect()
            ->route('admin.disciplinary.index')
            ->with('success', 'Disciplinary record logged successfully.');
    }

    public function update(Request $request, DisciplinaryRecord $disciplinary)
    {
        $data = $this->validated($request);

        if (($data['status'] ?? null) === 'resolved' && !$disciplinary->resolved_at) {
            $data['resolved_at'] = now();
        }

        if (($data['status'] ?? null) !== 'resolved') {
            $data['resolved_at'] = null;
        }

        $disciplinary->update($data);

        // Optional guardian SMS on update (only if checkbox checked)
        if ($request->boolean('notify_guardian')) {
            $this->sendGuardianSms($disciplinary->fresh());
        }

        return redirect()
            ->route('admin.disciplinary.index')
            ->with('success', 'Disciplinary record updated successfully.');
    }

    public function destroy(DisciplinaryRecord $disciplinary)
    {
        $disciplinary->delete();

        return redirect()
            ->route('admin.disciplinary.index')
            ->with('success', 'Disciplinary record deleted successfully.');
    }

    public function markResolved(DisciplinaryRecord $disciplinary)
    {
        $disciplinary->markResolved();

        return redirect()
            ->route('admin.disciplinary.index')
            ->with('success', 'Record marked as resolved.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'student_id'      => 'required|exists:users,id',
            'incident_date'   => 'required|date',
            'category'        => 'required|in:lateness,fighting,insolence,vandalism,uniform,theft,bullying,other',
            'severity'        => 'required|in:minor,major,serious',
            'description'     => 'required|string',
            'action_taken'    => 'nullable|in:warning,detention,suspension,counselling,fine,parents_called,other',
            'demerit_points'  => 'nullable|integer|min:0|max:100',
            'status'          => 'nullable|in:open,under_review,resolved',
            'notes'           => 'nullable|string',
        ]);
    }

    /**
     * Notify guardian via Mnotify SMS
     * Prefers guardian_phone, falls back to phone on the student user
     */
    private function sendGuardianSms(DisciplinaryRecord $record): void
    {
        $record->loadMissing('student');

        $apiKey   = config('services.mnotify.api_key');
        $senderId = config('services.mnotify.sender_id');

        if (!$apiKey) {
            Log::warning('Mnotify API key not configured for disciplinary SMS');
            return;
        }

        $student = $record->student;
        if (!$student) {
            return;
        }

        // Prefer guardian_phone, then phone
        $rawPhone = $student->guardian_phone ?: $student->phone;

        if (!$rawPhone) {
            Log::warning('No guardian/student phone for disciplinary SMS', [
                'record_id'  => $record->id,
                'student_id' => $student->id,
            ]);
            return;
        }

        $phone = preg_replace('/\D+/', '', $rawPhone);
        if (str_starts_with($phone, '0')) {
            $phone = '233' . substr($phone, 1);
        }

        $message = "AGOSCO Disciplinary Notice\n"
            . "Student: {$student->name}\n"
            . "Date: " . $record->incident_date->format('d M Y') . "\n"
            . "Category: " . ucfirst($record->category) . " ({$record->severity})\n"
            . "Action: " . ($record->action_taken ? ucfirst(str_replace('_', ' ', $record->action_taken)) : 'Pending') . "\n"
            . "Please contact the school for details.";

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://api.mnotify.com/api/sms/quick?key=' . $apiKey, [
                'recipient' => [$phone],
                'sender'    => $senderId,
                'message'   => $message,
            ]);

            if (!$response->successful()) {
                Log::error('Disciplinary SMS failed', [
                    'record_id' => $record->id,
                    'status'    => $response->status(),
                    'body'      => $response->body(),
                ]);
            } else {
                Log::info('Disciplinary SMS sent to guardian', [
                    'record_id' => $record->id,
                    'phone'     => $phone,
                ]);
            }
        } catch (\Throwable $e) {
            Log::error('Disciplinary SMS exception', [
                'record_id' => $record->id,
                'error'     => $e->getMessage(),
            ]);
        }
    }
}