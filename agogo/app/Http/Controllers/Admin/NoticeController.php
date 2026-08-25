<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NoticeMail;
use App\Models\Notice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::with('creator')->latest()->paginate(15);

        return view('admin.notices.index', compact('notices'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['created_by'] = auth()->id();

        $notice = Notice::create($data);

        $this->dispatchNotifications($notice);

        return redirect()
            ->route('admin.notices.index')
            ->with('success', 'Notice created and notifications sent successfully.');
    }

    public function update(Request $request, Notice $notice)
    {
        $data = $this->validated($request);

        $notice->update($data);

        // Optional: re-send on edit (comment out if you don't want this)
        // $this->dispatchNotifications($notice);

        return redirect()
            ->route('admin.notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();

        return redirect()
            ->route('admin.notices.index')
            ->with('success', 'Notice deleted successfully.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title'               => 'required|string|max:255',
            'body'                => 'required|string',
            'target_roles'        => 'nullable|array',
            'target_roles.*'      => 'in:student,teacher',
            'target_classes'      => 'nullable|array',
            'target_classes.*'    => 'in:SH1,SH2,SH3',
            'target_programmes'   => 'nullable|array',
            'target_programmes.*' => 'in:General Science,Business,General Arts,Visual Arts,Home Economics,Agricultural Science',
            'send_sms'            => 'sometimes|boolean',
        ]) + [
            'send_sms' => $request->boolean('send_sms'),
        ];
    }

    private function dispatchNotifications(Notice $notice): void
    {
        $users = $this->resolveRecipients($notice);

        if ($users->isEmpty()) {
            return;
        }

        // Email
        foreach ($users as $user) {
            if ($user->email) {
                try {
                    Mail::to($user->email)->queue(new NoticeMail($notice));
                } catch (\Throwable $e) {
                    Log::error('Notice email failed', [
                        'user_id' => $user->id,
                        'error'   => $e->getMessage(),
                    ]);
                }
            }
        }

        // Optional SMS via Mnotify
        if ($notice->send_sms) {
            $this->sendMnotifySms($users, $notice);
        }
    }

    private function resolveRecipients(Notice $notice)
    {
        $query = User::query();

        $roles = $notice->target_roles ?? [];
        $classes = $notice->target_classes ?? [];
        $programmes = $notice->target_programmes ?? [];

        if (empty($roles)) {
            // No roles selected → no one
            return collect();
        }

        $query->whereIn('role', $roles);

        // Class filter only applies to students
        if (in_array('student', $roles) && !empty($classes)) {
            $query->where(function ($q) use ($classes, $roles) {
                $q->where(function ($q2) use ($classes) {
                    $q2->where('role', 'student')
                       ->whereIn('class', $classes);
                });

                // Teachers are not filtered by class
                if (in_array('teacher', $roles)) {
                    $q->orWhere('role', 'teacher');
                }
            });
        }

        // Programme filter only applies to students
        if (in_array('student', $roles) && !empty($programmes)) {
            $query->where(function ($q) use ($programmes, $roles) {
                $q->where(function ($q2) use ($programmes) {
                    $q2->where('role', 'student')
                       ->whereIn('programme', $programmes);
                });

                if (in_array('teacher', $roles)) {
                    $q->orWhere('role', 'teacher');
                }
            });
        }

        return $query->get(['id', 'name', 'email', 'phone', 'role', 'class', 'programme']);
    }

    private function sendMnotifySms($users, Notice $notice): void
{
    $apiKey   = config('services.mnotify.key');
    $senderId = config('services.mnotify.sender_id', 'ASC');

    if (!$apiKey) {
        Log::warning('Mnotify API key not configured');
        return;
    }

    $phones = $users
        ->pluck('phone')
        ->filter()
        ->map(fn ($p) => preg_replace('/\D+/', '', $p))
        ->map(function ($p) {
            // Normalize Ghana numbers to 233...
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
        return;
    }

    $message = $notice->title . "\n\n" . \Illuminate\Support\Str::limit(strip_tags($notice->body), 140);

    try {
        // Send as JSON so recipient is a proper array
        $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post('https://api.mnotify.com/api/sms/quick?key=' . $apiKey, [
                'recipient' => $phones,   // ← must be an array
                'sender'    => $senderId,
                'message'   => $message,
            ]);

        if (!$response->successful()) {
            Log::error('Mnotify SMS failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
        } else {
            Log::info('Mnotify SMS sent successfully', [
                'recipients_count' => count($phones),
                'response' => $response->json(),
            ]);
        }
    } catch (\Throwable $e) {
        Log::error('Mnotify SMS exception', ['error' => $e->getMessage()]);
    }
}
}