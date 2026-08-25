<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\TwoFactorCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Auth;

class TwoFactorController extends Controller
{
    /**
     * Show the 2FA code entry page.
     * Only accessible when a pending 2FA user ID is stored in the session.
     */
    public function showChallenge()
    {
        if (!Session::has('2fa_user_id')) {
            return redirect()->route('login');
        }

        return view('auth.two-factor-challenge');
    }

    /**
     * Verify the submitted 2FA code and complete the login.
     */
    public function verifyChallenge(Request $request)
    {
        if (!Session::has('2fa_user_id')) {
            return redirect()->route('login');
        }

        $request->validate([
            'code' => ['required', 'string', 'size:6'],
        ], [
            'code.required' => 'Please enter the 6-digit code.',
            'code.size'     => 'The code must be exactly 6 digits.',
        ]);

        $user = User::find(Session::get('2fa_user_id'));

        if (!$user) {
            Session::forget('2fa_user_id');
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please log in again.']);
        }

        // Rate limit: max 5 attempts per minute
        $key = '2fa-attempt:' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->withErrors([
                'code' => "Too many attempts. Please wait {$seconds} seconds before trying again.",
            ]);
        }

        // Check expiry (10 minutes)
        if (!$user->two_factor_code
            || !$user->two_factor_sent_at
            || now()->diffInMinutes($user->two_factor_sent_at) > 10
        ) {
            return back()->withErrors([
                'code' => 'Your code has expired. Please request a new one.',
            ]);
        }

        // Check code matches
        if ($request->code !== $user->two_factor_code) {
            RateLimiter::hit($key, 60);
            return back()->withErrors([
                'code' => 'That code is incorrect. Please check your email and try again.',
            ]);
        }

        // ✅ Code is valid — clear it and complete login
        $user->update([
            'two_factor_code'    => null,
            'two_factor_sent_at' => null,
        ]);

        RateLimiter::clear($key);
        Session::forget('2fa_user_id');

        $remember = Session::pull('2fa_remember', false);
        auth()->login($user, $remember);

        //return redirect()->intended(route(' '));
         // ── No 2FA — log straight in ────────────────────────────────────────
    Auth::login($user, $request->boolean('remember'));

    // ── Role-based redirection (preserved from your original function) ──
    $userRole = $user->role;

    switch ($userRole) {
        case 'admin':
            return redirect()->route('home');
            break;
        case 'user':
            return redirect()->route('dashboard');
            break;
        case 'teacher':
            return redirect()->route('teacher');
            break;
        case 'suspended':
            return redirect()->route('pending');
            break;  
        default:
            return redirect()->route('login');
    }
    }

    /**
     * Resend a fresh 2FA code.
     */
    public function resend(Request $request)
    {
        if (!Session::has('2fa_user_id')) {
            return redirect()->route('login');
        }

        $user = User::find(Session::get('2fa_user_id'));

        if (!$user) {
            return redirect()->route('login');
        }

        // Rate limit resends: max 3 per 5 minutes
        $key = '2fa-resend:' . $user->id;
        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('resend_error',
                "Please wait {$seconds} seconds before requesting another code."
            );
        }

        self::sendCode($user);
        RateLimiter::hit($key, 300);

        return back()->with('resend_success',
            'A new code has been sent to ' . self::maskEmail($user->email) . '. Check your spam folder too.'
        );
    }

    /**
     * Generate a fresh code, save it to the user, and send the email.
     * Called from LoginController after credentials are verified.
     */
    public static function sendCode(User $user): void
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $user->update([
            'two_factor_code'    => $code,
            'two_factor_sent_at' => now(),
        ]);

        Mail::to($user->email)
            ->send(new TwoFactorCode($code, $user->first_name));
    }

    /**
     * Mask email for display e.g. j***@example.com
     */
    public static function maskEmail(string $email): string
    {
        [$local, $domain] = explode('@', $email);
        $masked = substr($local, 0, 1) . str_repeat('*', max(1, strlen($local) - 1));
        return $masked . '@' . $domain;
    }
}