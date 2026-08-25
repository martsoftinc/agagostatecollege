<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class StudentIdFinderController extends Controller
{
    public function index(Request $request)
    {
        $searched = $request->filled('name') || $request->filled('programme');
        $students = collect();

        if ($searched) {
            $validated = $request->validate([
                'name' => 'required|string|min:2|max:255',
                'programme' => 'required|in:general_science,business,general_arts,visual_arts,home_economics,agricultural_science',
            ]);

            $name = trim($validated['name']);
            $programme = $validated['programme'];

            $students = User::query()
                ->where(function ($query) {
                    $query->where('role', 'student')
                        ->orWhereHas('role', function ($q) {
                            $q->where('name', 'student');
                        });
                })
                ->where(function ($query) use ($programme) {
                    $query->where('programme', $programme)
                        ->orWhere('course', $programme);
                })
                ->where(function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%')
                        ->orWhere('first_name', 'like', '%' . $name . '%')
                        ->orWhere('last_name', 'like', '%' . $name . '%')
                        ->orWhere('surname', 'like', '%' . $name . '%')
                        ->orWhereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(last_name, '')) LIKE ?", ['%' . $name . '%'])
                        ->orWhereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(surname, '')) LIKE ?", ['%' . $name . '%']);
                })
                ->orderBy('name')
                ->limit(20)
                ->get();
        }

        return view('auth.student-id-finder', [
            'students' => $students,
            'searched' => $searched,
            'name' => $request->input('name'),
        ]);
    }
}