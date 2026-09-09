<?php

namespace App\Http\Controllers\HouseMaster;

use App\Http\Controllers\Controller;
use App\Models\DisciplinaryRecord;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DisciplinaryController extends Controller
{
    public function index()
    {
        $records = DisciplinaryRecord::with('student')->latest()->paginate(15);
        return view('housemaster.disciplinary.index', compact('records'));
    }

    public function create()
    {
        $students = User::where('role', 'student')
            ->orderBy('full_name')
            ->get(['id', 'full_name', 'student_id', 'guardian_phone']);

        return view('housemaster.disciplinary.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'     => 'required|exists:users,id',
            'incident_date'  => 'required|date',
            'category'       => 'required|string|max:100',
            'severity'       => 'required|in:low,medium,high',
            'description'    => 'required|string',
            'action_taken'   => 'nullable|string',
            'demerit_points' => 'nullable|integer|min:0',
            'notes'          => 'nullable|string',
            'send_sms'       => 'nullable|boolean',
        ]);

        $record = DisciplinaryRecord::create([
            ...$validated,
            'status'      => 'open',
            'reported_by' => Auth::id(),
        ]);

        if ($request->boolean('send_sms')) {
            $this->sendDisciplinarySms($record);
        }

        return redirect()->route('housemaster.disciplinary.index')
            ->with('success', 'Disciplinary record added successfully.');
    }

    private function sendDisciplinarySms(DisciplinaryRecord $record): void
    {
        $record->loadMissing('student');
        $apiKey   = config('services.mnotify.api_key');
        $senderId = config('services.mnotify.sender_id');

        if (!$apiKey || empty($record->student?->guardian_phone)) return;

        $phone = preg_replace('/\D+/', '', $record->student->guardian_phone);
        if (str_starts_with($phone, '0')) $phone = '233' . substr($phone, 1);

        $studentName = $record->student->full_name ?? $record->student->name;
        $message = "AGOSCO Disciplinary Notice\nStudent: {$studentName}\nDate: " . $record->incident_date->format('d M Y') .
                   "\nCategory: {$record->category}\nSeverity: " . ucfirst($record->severity) .
                   "\nPlease contact the House Master for details.";

        try {
            Http::withHeaders(['Content-Type' => 'application/json'])
                ->post('https://api.mnotify.com/api/sms/quick?key=' . $apiKey, [
                    'recipient' => [$phone],
                    'sender'    => $senderId,
                    'message'   => $message,
                ]);
        } catch (\Throwable $e) {
            Log::error('Disciplinary SMS failed', ['error' => $e->getMessage()]);
        }
    }
}