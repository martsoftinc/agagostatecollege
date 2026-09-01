<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Adjust view path as needed
    }


     public function showLoginForm()
    {
        return view('auth.login'); // Adjust view path as needed
    }




    /*

    public function login(Request $request) 
    {
        
        $request->validate([
        'email' => 'required|email',
        'password' => 'required'
        ]);
        $credentials = $request->only('email','password');
       
        if (Auth::attempt($credentials)) 
        {

            $userRole = Auth::user()->role;

        switch ($userRole) {
            case 'admin':
                return redirect()->route('home');
                break;
            case 'user':
                return redirect()->route('home');
                break;
            case 'suspended':
                return redirect()->route('pending');
                break  ;  
            // Add more cases for other roles as needed
            default:
                return redirect()->route('login');
        }
            
           
        }
        return back()->withErrors(['loginError' => 'Invalid username or password.']); 
        
        }


*/

                public function login(Request $request)
{
    $request->validate([
        'email'    => ['required', 'email'],
        'password' => ['required', 'string'],
    ], [
        'email.required'    => 'Please enter your email address.',
        'email.email'       => 'Please enter a valid email address.',
        'password.required' => 'Please enter your password.',
    ]);

    // Global login rate limit: 5 attempts per minute per IP+email
    $throttleKey = Str::lower($request->email) . '|' . $request->ip();
    if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
        $seconds = RateLimiter::availableIn($throttleKey);
        throw ValidationException::withMessages([
            'email' => "Too many login attempts. Please wait {$seconds} seconds.",
        ]);
    }

    // Attempt authentication WITHOUT logging in yet
    if (!Auth::validate(['email' => $request->email, 'password' => $request->password])) {
        RateLimiter::hit($throttleKey, 60);
        throw ValidationException::withMessages([
            'email' => 'These credentials do not match our records.',
        ]);
    }

    RateLimiter::clear($throttleKey);

    $user = \App\Models\User::where('email', $request->email)->first();

    // ── 2FA branch ─────────────────────────────────────────────────────
    if ($user->two_factor_enabled) {
        // Store pending user in session; do NOT call Auth::login() yet
        Session::put('2fa_user_id', $user->id);
        Session::put('2fa_remember', $request->boolean('remember'));

        // Generate and email the code
        TwoFactorController::sendCode($user);

        return redirect()->route('two-factor.challenge');
    }

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











    public function logout(Request $request)
    {
        $user = Auth::user();
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        //Log::info("Student logged out: {$user->student_id}");

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }

}
