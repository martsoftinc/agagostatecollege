<?php

namespace App\Http\Controllers\HouseMaster;

use App\Http\Controllers\Controller;
use App\Models\Exeat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ExeatController extends Controller
{
    public function index()
    {
        $exeats = Exeat::with('student')->latest()->paginate(15);
        return view('housemaster.exeat.index', compact('exeats'));
    }

    public function create()
    {
        $students = User::where('role', 'student')
            ->orderBy('full_name')
            ->get(['id', 'full_name', 'student_id', 'guardian_phone']);

        return view('housemaster.exeat.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'         => 'required|exists:users,id',
            'type'               => 'required|string|max:50',
            'destination'        => 'required|string|max:255',
            'reason'             => 'required|string',
            'departure_at'       => 'required|date',
            'expected_return_at' => 'required|date|after:departure_at',
            'guardian_contact'   => 'nullable|string|max:20',
            'notes'              => 'nullable|string',
            'send_sms'           => 'nullable|boolean',
        ]);

        $exeat = Exeat::create([
            ...$validated,
            'status'      => 'approved',
            'logged_by'   => Auth::id(),
            'approved_by' => Auth::id(),
        ]);

        if ($request->boolean('send_sms')) {
            $this->sendExeatSms($exeat);
        }

        return redirect()->route('housemaster.exeat.index')
            ->with('success', 'Exeat recorded successfully.');
    }

    public function markReturned(Exeat $exeat)
    {
        $exeat->markAsReturned();
        return back()->with('success', 'Student marked as returned.');
    }

    private function sendExeatSms(Exeat $exeat): void
    {
        $exeat->loadMissing('student');
        $apiKey   = config('services.mnotify.api_key');
        $senderId = config('services.mnotify.sender_id');

        if (!$apiKey) return;

        $phones = collect([
            $exeat->student?->guardian_phone,
            $exeat->guardian_contact,
        ])
            ->filter()
            ->map(fn ($p) => preg_replace('/\D+/', '', $p))
            ->map(function ($p) {
                if (str_starts_with($p, '0')) return '233' . substr($p, 1);
                if (str_starts_with($p, '233')) return $p;
                return $p;
            })
            ->filter(fn ($p) => !empty($p) && strlen($p) >= 9)
            ->unique()
            ->values()
            ->all();

        if (empty($phones)) return;

        $studentName = $exeat->student->full_name ?? $exeat->student->name ?? 'Student';
        $message = "AGOSCO Exeat Approved\nStudent: {$studentName}\nDestination: {$exeat->destination}\n" .
                   "Leave: " . $exeat->departure_at->format('d M Y, h:i A') . "\n" .
                   "Return by: " . $exeat->expected_return_at->format('d M Y, h:i A') . "\n" .
                   "Type: " . ucfirst($exeat->type);

        try {
            Http::withHeaders(['Content-Type' => 'application/json'])
                ->post('https://api.mnotify.com/api/sms/quick?key=' . $apiKey, [
                    'recipient' => $phones,
                    'sender'    => $senderId,
                    'message'   => $message,
                ]);
        } catch (\Throwable $e) {
            Log::error('Exeat SMS failed', ['error' => $e->getMessage()]);
        }
    }
}