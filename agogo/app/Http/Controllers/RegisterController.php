<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'full_name'    => ['required', 'string', 'max:255'],
            'phone'        => ['required', 'string', 'max:20', 'unique:users,phone'],
            'region'       => ['required', 'string', 'max:100'],
            'nationality'  => ['required', 'string', 'max:100'],
            'email'        => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password'     => ['required', 'confirmed', Password::min(8)
                                    ->mixedCase()
                                    ->numbers()
                                    ->uncompromised()],
        ], [
            'full_name.required'   => 'Please enter your full name.',
            'full_name.max'        => 'Your name must not exceed 255 characters.',
            'phone.required'       => 'Please enter your phone number.',
            'phone.unique'         => 'This phone number is already registered.',
            'region.required'      => 'Please select your region.',
            'nationality.required' => 'Please select your nationality.',
            'email.required'       => 'Please enter your email address.',
            'email.email'          => 'Please enter a valid email address.',
            'email.unique'         => 'This email address is already registered.',
            'password.required'    => 'Please enter a password.',
            'password.confirmed'   => 'Your passwords do not match.',
        ]);
        $role ="user";
        $user = User::create([
            'full_name'   => $validated['full_name'],
            'phone'       => $validated['phone'],
            'region'      => $validated['region'],
            'nationality' => $validated['nationality'],
            'email'       => $validated['email'],
            'role'       => $role,
            'password'    => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        // Generate and email the verification code
        EmailVerificationController::sendCode($user);

        return redirect()->route('verification.notice');
    }
}