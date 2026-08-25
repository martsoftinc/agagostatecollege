<?php

namespace App\Http\Controllers;


use App\Models\SchoolClass;
use App\Models\Stream;
use App\Models\ClassStream;
use App\Models\User;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::orderBy('level_order')->get();
        $streams = Stream::orderBy('name')->get();
        
        $classStreams = ClassStream::with(['schoolClass', 'stream', 'teacher'])
            ->withCount('students')
            ->get();

        $teachers = User::where('role', 'teacher')->get();

        return view('admin.classes.index', compact('classes', 'streams', 'classStreams', 'teachers'));
    }

    public function storeClass(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:20|unique:school_classes,code',
            'level_order' => 'required|integer|min:1',
        ]);

        SchoolClass::create($validated);

        return redirect()->back()->with('success', 'Class Level added successfully!');
    }

    public function updateClass(Request $request, SchoolClass $schoolClass)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'code' => 'required|string|max:20|unique:school_classes,code,' . $schoolClass->id,
            'level_order' => 'required|integer|min:1',
        ]);

        $schoolClass->update($validated);

        return redirect()->back()->with('success', 'Class Level updated successfully!');
    }

    public function storeStream(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'nullable|string|max:50',
        ]);

        Stream::create($validated);

        return redirect()->back()->with('success', 'Stream added successfully!');
    }

    public function updateStream(Request $request, Stream $stream)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'nullable|string|max:50',
        ]);

        $stream->update($validated);

        return redirect()->back()->with('success', 'Stream updated successfully!');
    }

    public function assignStream(Request $request)
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'stream_id' => 'required|exists:streams,id',
            'teacher_id' => 'nullable|exists:users,id',
            'capacity' => 'required|integer|min:1',
        ]);

        ClassStream::updateOrCreate(
            [
                'school_class_id' => $validated['school_class_id'],
                'stream_id' => $validated['stream_id'],
            ],
            [
                'teacher_id' => $validated['teacher_id'] ?? null,
                'capacity' => $validated['capacity'],
            ]
        );

        return redirect()->back()->with('success', 'Class & Stream combo mapped successfully!');
    }

    public function updateClassStream(Request $request, ClassStream $classStream)
    {
        $validated = $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
            'stream_id' => 'required|exists:streams,id',
            'teacher_id' => 'nullable|exists:users,id',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'required|boolean',
        ]);

        $classStream->update($validated);

        return redirect()->back()->with('success', 'Class assignment updated successfully!');
    }

    public function destroyClass(SchoolClass $schoolClass)
    {
        // Prevent deleting class level if assigned to active streams
        if ($schoolClass->classStreams()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete class level while streams are linked to it!');
        }

        $schoolClass->delete();
        return redirect()->back()->with('success', 'Class level deleted successfully!');
    }

    public function destroyStream(Stream $stream)
    {
        // Prevent deleting stream if assigned to classes
        if ($stream->schoolClasses()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete stream while it is assigned to class levels!');
        }

        $stream->delete();
        return redirect()->back()->with('success', 'Stream deleted successfully!');
    }

    public function destroyClassStream(ClassStream $classStream)
    {
        // Prevent deleting combination if students are enrolled
        if ($classStream->students()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete combination with enrolled students!');
        }

        $classStream->delete();
        return redirect()->back()->with('success', 'Class combination removed successfully!');
    }
}