<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $roleFilter = $request->query('role'); // Filter by teacher, staff, or all

        $staffMembers = User::whereIn('role', ['teacher', 'staff'])
            ->when($roleFilter, function ($query) use ($roleFilter) {
                return $query->where('role', $roleFilter);
            })
            ->latest()
            ->paginate(15);

        return view('admin.staff.index', compact('staffMembers', 'roleFilter'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id'      => 'nullable|string|max:50|unique:users,staff_id',
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email',
            'phone'         => 'nullable|string|max:20',
            'role'          => ['required', Rule::in(['teacher', 'staff'])],
            'qualification' => 'nullable|string|max:255',
            'password'      => 'required|string|min:8',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        User::create($validated);

        return redirect()->back()->with('success', ucfirst($validated['role']) . ' added successfully!');
    }

    public function update(Request $request, User $user)
    {
        // Ensure we are updating a teacher or staff member
        if (!in_array($user->role, ['teacher', 'staff'])) {
            return redirect()->back()->with('error', 'Unauthorized user role update.');
        }

        $validated = $request->validate([
            'staff_id'      => ['nullable', 'string', 'max:50', Rule::unique('users', 'staff_id')->ignore($user->id)],
            'name'          => 'required|string|max:255',
            'email'         => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'         => 'nullable|string|max:20',
            'role'          => ['required', Rule::in(['teacher', 'staff'])],
            'qualification' => 'nullable|string|max:255',
            'password'      => 'nullable|string|min:8',
            'is_active'     => 'required|boolean',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->back()->with('success', 'User record updated successfully!');
    }

    public function destroy(User $user)
    {
        if (!in_array($user->role, ['teacher', 'staff'])) {
            return redirect()->back()->with('error', 'Unauthorized user deletion.');
        }

        // Prevent deletion if assigned as a Class Tutor in ClassStreams
        if (\Schema::hasTable('class_streams') && \DB::table('class_streams')->where('teacher_id', $user->id)->exists()) {
            return redirect()->back()->with('error', 'Cannot delete teacher assigned as an active Class Tutor!');
        }

        $user->delete();

        return redirect()->back()->with('success', 'Staff account deleted successfully!');
    }
}