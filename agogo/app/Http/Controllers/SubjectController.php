<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::orderBy('name')->get();
        return view('admin.subjects.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'code'     => 'nullable|string|max:20|unique:subjects,code',
            'category' => 'nullable|string|max:50',
        ]);

        Subject::create($validated);

        return redirect()->back()->with('success', 'Subject added successfully!');
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'code'     => 'nullable|string|max:20|unique:subjects,code,' . $subject->id,
            'category' => 'nullable|string|max:50',
            'is_active'=> 'required|boolean',
        ]);

        $subject->update($validated);

        return redirect()->back()->with('success', 'Subject updated successfully!');
    }

    public function destroy(Subject $subject)
    {
        // Optional: prevent delete if already assigned
        if ($subject->classStreams()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete subject that is assigned to classes!');
        }

        $subject->delete();
        return redirect()->back()->with('success', 'Subject deleted successfully!');
    }
}