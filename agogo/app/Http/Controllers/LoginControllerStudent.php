<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\MNotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

class LoginControllerStudent extends Controller
{
   protected $mnotify;

    public function __construct(MNotifyService $mnotify)
    {
        $this->mnotify = $mnotify;
    }

    /**
     * Show the login form
     */
    
    public function showStudentLoginForm()
    {
        return view('auth.studentportal');
    }

    /**
     * Handle the login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|max:255',
            'password' => 'required|string|min:4|max:6',
        ]);

        // Find user by student_id or phone
        $user = User::where('student_id', $request->student_id)
            ->orWhere('phone', $request->student_id)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'student_id' => ['The provided credentials do not match our records.'],
            ]);
        }

        // Check if user has a pincode set
        if (!$user->hasPincode()) {
            throw ValidationException::withMessages([
                'password' => ['You have not set a pincode yet. Please use "Forgot Pincode" to set one.'],
            ]);
        }

        // Verify pincode
        if (!$user->verifyPincode($request->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided pincode is incorrect.'],
            ]);
        }

        // Login the user
        Auth::login($user, $request->boolean('remember'));

        // Regenerate session
        $request->session()->regenerate();

        // Log the login
        Log::info("Student logged in: {$user->student_id}");

        return redirect()->intended('/student/dashboard')
            ->with('success', 'Welcome back, ' . $user->name . '!');
    }

    /**
     * Show forgot pincode form
     */
    public function showForgotPincodeForm()
    {
        return view('student-portal.forgot-pincode');
    }

    /**
     * Handle forgot pincode request
     */
    public function sendPincode(Request $request)
    {
        $request->validate([
            'student_id' => 'required|string|max:255',
        ]);

        // Find user by student_id or phone
        $user = User::where('student_id', $request->student_id)
            ->orWhere('phone', $request->student_id)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'student_id' => ['No student found with this ID or phone number.'],
            ]);
        }

        // Check if user has a phone number
        if (!$user->phone) {
            throw ValidationException::withMessages([
                'student_id' => ['No phone number registered for this student. Please contact the administrator.'],
            ]);
        }

        // Generate new pincode
        $newPincode = User::generatePincode();

        // Update user's pincode
        $user->pincode = $newPincode;
        $user->save();

        // Send SMS with pincode
        $sent = $this->mnotify->sendPincode($user, $newPincode);

        if (!$sent) {
            Log::error("Failed to send pincode to: {$user->phone} for student: {$user->student_id}");
            return back()->with('error', 'Failed to send pincode. Please try again or contact the administrator.');
        }

        Log::info("Pincode sent successfully to: {$user->phone} for student: {$user->student_id}");

        return back()->with('success', 'A new pincode has been sent to your registered phone number.');
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Log::info("Student logged out: {$user->student_id}");

        return redirect('student.login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show dashboard
     */
    public function dashboard()
    {
        $user = Auth::user();
        return view('student-portal.dashboard', compact('user'));
    }

    /**
     * Show change pincode form
     */
    public function showChangePincodeForm()
    {
        return view('student-portal.change-pincode');
    }

    /**
     * Handle change pincode
     */
    public function changePincode(Request $request)
    {
        $request->validate([
            'current_pincode' => 'required|string|max:6',
            'new_pincode' => 'required|string|min:4|max:6|confirmed',
        ]);

        $user = Auth::user();

        // Verify current pincode
        if (!$user->verifyPincode($request->current_pincode)) {
            throw ValidationException::withMessages([
                'current_pincode' => ['The current pincode is incorrect.'],
            ]);
        }

        // Update pincode
        $user->pincode = $request->new_pincode;
        $user->save();

        Log::info("Student changed pincode: {$user->student_id}");

        return redirect()->route('student.dashboard')
            ->with('success', 'Your pincode has been changed successfully.');
    }
}
