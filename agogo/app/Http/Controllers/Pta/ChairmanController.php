<?php

namespace App\Http\Controllers\Pta;

use App\Http\Controllers\Controller;
use App\Models\PtaMeeting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChairmanController extends Controller
{
    public function dashboard()
    {
        // Always only one record – get the first (or null)
        $meeting = PtaMeeting::first();

        return view('pta.dashboard', compact('meeting'));
    }

    public function updateMeeting(Request $request)
    {
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'nullable|string',
            'meeting_date'  => 'required|date',
            'meeting_time'  => 'required',
            'venue'         => 'required|string|max:255',
        ]);

        // Single record only – update existing or create the first one
        PtaMeeting::updateOrCreate(
            ['id' => PtaMeeting::first()?->id ?? null],
            $validated
        );

        // Alternative cleaner way (recommended):
        // $meeting = PtaMeeting::firstOrNew([]);
        // $meeting->fill($validated)->save();

        return redirect()
            ->route('pta.dashboard')
            ->with('success', 'PTA Meeting announcement updated successfully.');
    }

    public function sendBulkSms(Request $request)
{
    $request->validate([
        'message' => 'required|string|max:320',
    ]);

    $apiKey   = config('services.mnotify.api_key');
    $senderId = config('services.mnotify.sender_id');

    if (!$apiKey) {
        Log::warning('Mnotify API key not configured for PTA bulk SMS');
        return back()->with('error', 'SMS service is not configured. Please contact the administrator.');
    }

    // Get students that have a guardian_phone
    $students = User::where('role', 'student')
        ->whereNotNull('guardian_phone')
        ->where('guardian_phone', '!=', '')
        ->get(['id', 'name', 'guardian_phone']);

    if ($students->isEmpty()) {
        return back()->with('error', 'No students with guardian phone numbers found.');
    }

    // Normalize phone numbers
$phones = $students
    ->pluck('guardian_phone')
    ->filter()
    ->map(fn ($p) => preg_replace('/\D+/', '', $p))
    ->map(function ($p) {
        if (empty($p)) {
            return null;
        }
        if (str_starts_with($p, '0')) {
            return '233' . substr($p, 1);
        }
        if (str_starts_with($p, '233')) {
            return $p;
        }
        // If it doesn't start with 0 or 233, still keep it (might be international)
        return $p;
    })
    ->filter(fn ($p) => !empty($p) && strlen($p) >= 9)
    ->unique()
    ->values()
    ->all();

    if (empty($phones)) {
        Log::warning('No valid phone numbers after normalization for PTA bulk SMS');
        return back()->with('error', 'No valid phone numbers found after formatting.');
    }

    $message = $request->message;

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://api.mnotify.com/api/sms/quick?key=' . $apiKey, [
            'recipient' => $phones,
            'sender'    => $senderId,
            'message'   => $message,
        ]);

        if (!$response->successful()) {
            Log::error('PTA Bulk SMS failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
                'count'  => count($phones),
            ]);

            return back()->with('error', 'Failed to send SMS. Please try again or contact support.');
        }

        Log::info('PTA Bulk SMS sent successfully', [
            'count'  => count($phones),
            'phones' => $phones,
        ]);

        return back()->with('success', 'Bulk SMS successfully sent to ' . count($phones) . ' student(s).');

    } catch (\Throwable $e) {
        Log::error('PTA Bulk SMS exception', [
            'error' => $e->getMessage(),
            'count' => count($phones),
        ]);

        return back()->with('error', 'An unexpected error occurred while sending SMS.');
    }
}
}