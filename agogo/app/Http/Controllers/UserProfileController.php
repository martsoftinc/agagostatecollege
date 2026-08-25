<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class UserProfileController extends Controller
{
    /**
     * Show the profile page.
     */
    public function show()
    {
        return view('user.profile', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * Update name and email.
     * Uses the 'profileErrors' error bag so it doesn't bleed into the password form.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validateWithBag('profileErrors', [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ], [
            'first_name.required' => 'Please enter your first name.',
            'last_name.required'  => 'Please enter your last name.',
            'email.required'      => 'Please enter your email address.',
            'email.email'         => 'Please enter a valid email address.',
            'email.unique'        => 'This email address is already in use by another account.',
        ]);

        $emailChanged = $user->email !== $validated['email'];

        $user->update([
            'first_name'        => $validated['first_name'],
            'last_name'         => $validated['last_name'],
            'full_name'         => $validated['first_name'] . ' ' . $validated['last_name'],
            'email'             => $validated['email'],
            'email_verified_at' => $emailChanged ? null : $user->email_verified_at,
        ]);

        return back()
            ->with('profile_success', 'Profile updated successfully.')
            ->with('email_changed', $emailChanged);
    }

    /**
     * Update password.
     * Uses the 'passwordErrors' error bag so it doesn't bleed into the profile form.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validateWithBag('passwordErrors', [
            'current_password'          => ['required', 'string'],
            'new_password'              => ['required', 'confirmed', Password::min(8)
                                                ->mixedCase()
                                                ->numbers()
                                                ->uncompromised()],
            'new_password_confirmation' => ['required'],
        ], [
            'current_password.required'          => 'Please enter your current password.',
            'new_password.required'              => 'Please enter a new password.',
            'new_password.confirmed'             => 'The new passwords do not match.',
            'new_password_confirmation.required' => 'Please confirm your new password.',
            'new_password.min'                   => 'Your new password must be at least 8 characters.',
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => 'Your current password is incorrect.',
            ])->errorBag('passwordErrors');
        }

        // Prevent reuse of current password
        if (Hash::check($request->new_password, $user->password)) {
            throw ValidationException::withMessages([
                'new_password' => 'Your new password must be different from your current password.',
            ])->errorBag('passwordErrors');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('password_success', 'Password updated successfully.');
    }

    /**
     * Toggle 2FA — called via fetch() from the blade JS.
     */
    public function toggle2FA(Request $request)
    {
        $request->validate([
            'enabled' => ['required', 'boolean'],
        ]);

        Auth::user()->update([
            'two_factor_enabled' => $request->boolean('enabled'),
        ]);

        return response()->json([
            'success' => true,
            'enabled' => $request->boolean('enabled'),
        ]);
    }
}