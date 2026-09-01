<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;

class TeacherProfileController extends Controller
{
    /**
     * Show the teacher profile page.
     */
    public function show()
    {
        $user = Auth::user();

        return view('teacher.profile', compact('user'));
    }

    /**
     * Update personal information + profile picture.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        try {
            $validated = $request->validate([
                'first_name'     => ['required', 'string', 'max:100'],
                'last_name'      => ['required', 'string', 'max:100'],
                'other_names'    => ['nullable', 'string', 'max:100'],
                'email'          => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('users')->ignore($user->id),
                ],
                'phone'          => ['nullable', 'string', 'max:20'],
                'qualification'  => ['nullable', 'string', 'max:150'],
                'profile_picture'=> ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // 2MB
            ], [], [
                'first_name'     => 'first name',
                'last_name'      => 'last name',
                'other_names'    => 'other names',
                'profile_picture'=> 'profile picture',
            ]);
        } catch (ValidationException $e) {
            // Use a named error bag so the Blade can show $errors->profileErrors
            throw $e->errorBag('profileErrors');
        }

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture if it exists
            if ($user->profile_picture && Storage::disk('public')->exists($user->profile_picture)) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            $path = $request->file('profile_picture')->store('profile-pictures', 'public');
            $validated['profile_picture'] = $path;
        }

        // Rebuild full_name
        $fullName = trim(
            $validated['first_name'] . ' ' .
            ($validated['other_names'] ? $validated['other_names'] . ' ' : '') .
            $validated['last_name']
        );

        $user->update([
            'first_name'    => $validated['first_name'],
            'last_name'     => $validated['last_name'],
            'other_names'   => $validated['other_names'] ?? null,
            'full_name'     => $fullName,
            'email'         => $validated['email'],
            'phone'         => $validated['phone'] ?? null,
            'qualification' => $validated['qualification'] ?? null,
            'profile_picture' => $validated['profile_picture'] ?? $user->profile_picture,
        ]);

        // Optional: if email changed, mark as unverified
        if ($user->wasChanged('email')) {
            $user->email_verified_at = null;
            $user->save();

            return back()->with([
                'profile_success' => 'Profile updated successfully.',
                'email_changed'   => true,
            ]);
        }

        return back()->with('profile_success', 'Profile updated successfully.');
    }

    /**
     * Update password.
     */
    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        try {
            $request->validate([
                'current_password'      => ['required', 'string'],
                'new_password'          => ['required', 'string', 'min:8', 'confirmed'],
                'new_password_confirmation' => ['required'],
            ], [
                'new_password.confirmed' => 'The new password confirmation does not match.',
            ]);
        } catch (ValidationException $e) {
            throw $e->errorBag('passwordErrors');
        }

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The current password is incorrect.'],
            ])->errorBag('passwordErrors');
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return back()->with('password_success', 'Password updated successfully.');
    }

    /**
     * Toggle Two-Factor Authentication (AJAX).
     */
    public function toggle2FA(Request $request)
    {
        $request->validate([
            'enabled' => ['required', 'boolean'],
        ]);

        $user = Auth::user();

        $user->update([
            'two_factor_enabled' => $request->boolean('enabled'),
            // Optional: clear any pending code when disabling
            'two_factor_code'    => $request->boolean('enabled') ? $user->two_factor_code : null,
            'two_factor_sent_at' => $request->boolean('enabled') ? $user->two_factor_sent_at : null,
        ]);

        return response()->json([
            'success' => true,
            'enabled' => $user->two_factor_enabled,
            'message' => $user->two_factor_enabled
                ? 'Two-factor authentication enabled.'
                : 'Two-factor authentication disabled.',
        ]);
    }
}