<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class PincodeController extends Controller
{
    /**
     * Show the change pincode form
     */
    public function edit()
    {
        return view('student.pincode.edit');
    }

    /**
     * Update the user's pincode
     */
    public function update(Request $request)
        {
            $request->validate([
                'current_pincode' => ['required', 'digits_between:4,6'],
                'pincode'         => ['required', 'digits_between:4,6', 'confirmed'],
            ], [
                'current_pincode.required'       => 'Please enter your current pincode.',
                'current_pincode.digits_between' => 'Current pincode must be between 4 and 6 digits.',
                'pincode.required'               => 'Please enter a new pincode.',
                'pincode.digits_between'         => 'New pincode must be between 4 and 6 digits.',
                'pincode.confirmed'              => 'New pincode confirmation does not match.',
            ]);

            $user = Auth::user();

            // Verify current pincode
            if (!Hash::check($request->current_pincode, $user->pincode)) {
                throw ValidationException::withMessages([
                    'current_pincode' => 'The current pincode is incorrect.',
                ]);
            }

            // Just pass the plain value — the mutator will hash it
            $user->update([
                'pincode' => $request->pincode,
            ]);

            return redirect()
                ->route('student.pincode.edit')
                ->with('success', 'Your pincode has been changed successfully.');
        }
}