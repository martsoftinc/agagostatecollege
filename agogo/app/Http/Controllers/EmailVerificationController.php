<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\VerificationCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
    /**
     * Show the verification code entry page.
     */
    public function showVerificationForm()
    {
        // Must be logged in but unverified to see this page
        if (auth()->check() && auth()->user()->email_verified_at) {
            return redirect()->route('dashboard');
        }

        if (!auth()->check()) {
            return redirect()->route('login');
        }

        return view('auth.verify-email');
    }

    /**
     * Verify the submitted code.
     */
    public function verify(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'Please enter the 6-digit code.',
            'code.size'     => 'The code must be exactly 6 digits.',
        ]);

        $user = auth()->user();

        // Check rate limit: max 5 attempts per minute per user
        $key = 'verify-email:' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'code' => "Too many attempts. Please wait {$seconds} seconds before trying again.",
            ]);
        }

        // Check code hasn't expired (10 minutes)
        if (!$user->email_verification_code
            || !$user->email_verification_sent_at
            || now()->diffInMinutes($user->email_verification_sent_at) > 10
        ) {
            return back()->withErrors([
                'code' => 'Your code has expired. Please request a new one.',
            ]);
        }

        // Check code matches
        if ($request->code !== $user->email_verification_code) {
            RateLimiter::hit($key, 60);
            return back()->withErrors([
                'code' => 'That code is incorrect. Please check your email and try again.',
            ]);
        }

        // All good — mark verified and clear the code
        $user->update([
            'email_verified_at'            => now(),
            'email_verification_code'      => null,
            'email_verification_sent_at'   => null,
        ]);

        RateLimiter::clear($key);

        return redirect()->route('dashboard')
                         ->with('success', 'Your email has been verified. Welcome aboard!');
    }

    /**
     * Resend a fresh verification code.
     */
    public function resend(Request $request)
    {
        $user = auth()->user();

        if ($user->email_verified_at) {
            return redirect()->route('dashboard');
        }

        // Rate limit resends: max 3 per 5 minutes per user
        $key = 'resend-verify:' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('resend_error',
                "Please wait {$seconds} seconds before requesting another code."
            );
        }

        self::sendCode($user);
        RateLimiter::hit($key, 300);

        return back()->with('resend_success',
            'A new code has been sent to ' . $user->email . '. Check your spam folder too.'
        );
    }

    /**
     * Static helper — generate & send a verification code to a user.
     * Called from RegisterController right after user creation.
     */
    public static function sendCode(User $user): void
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'email_verification_code'    => $code,
            'email_verification_sent_at' => now(),
        ]);

        Mail::to($user->email)
            ->send(new VerificationCode($code, $user->first_name));
    }
}