<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentFinderController extends Controller
{
   public function studentFinder(Request $request)
{
    $query = User::query()
        ->where('role', 'student')
        ->where('is_active', true) // optional, remove if you want inactive too
        ->select([
            'id',
            'full_name',
            'student_id',
            'profile_picture',
            'date_of_birth',
            'track',
            'programme',
            'boarding',
            'house',
            'class',
            'guardian_name',
            'guardian_phone',
        ]);

    // Search by name or student_id
    if ($request->filled('q')) {
        $search = $request->q;
        $query->where(function ($q) use ($search) {
            $q->where('full_name', 'like', "%{$search}%")
              ->orWhere('student_id', 'like', "%{$search}%")
              ->orWhere('first_name', 'like', "%{$search}%")
              ->orWhere('last_name', 'like', "%{$search}%");
        });
    }

    // Filter by class
    if ($request->filled('class')) {
        $query->where('class', $request->class);
    }

    // Filter by programme
    if ($request->filled('programme')) {
        $query->where('programme', $request->programme);
    }

    $students = $query->orderBy('full_name')->paginate(12);

    // For the filter dropdowns
    $classes = User::where('role', 'student')
        ->whereNotNull('class')
        ->distinct()
        ->orderBy('class')
        ->pluck('class');

    $programmes = User::where('role', 'student')
        ->whereNotNull('programme')
        ->distinct()
        ->orderBy('programme')
        ->pluck('programme');

    return view('teacher.student-finder', compact('students', 'classes', 'programmes'));
}
}
