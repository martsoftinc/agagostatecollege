<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $search       = $request->query('search');
        $courseFilter = $request->query('course');
        $classFilter  = $request->query('class');
        $statusFilter = $request->query('status');

        $students = Student::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('index_number', 'like', "%{$search}%")
                      ->orWhere('surname', 'like', "%{$search}%")
                      ->orWhere('first_name', 'like', "%{$search}%")
                      ->orWhere('middle_name', 'like', "%{$search}%")
                      ->orWhere('jhs_index_number', 'like', "%{$search}%");
                });
            })
            ->when($courseFilter, function ($query) use ($courseFilter) {
                $query->where('course', $courseFilter);
            })
            ->when($classFilter, function ($query) use ($classFilter) {
                $query->where('class', $classFilter);
            })
            ->when($statusFilter, function ($query) use ($statusFilter) {
                $query->where('status', $statusFilter);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $courses = [
            'General Science',
            'Business',
            'General Arts',
            'Visual Arts',
            'Home Economics',
            'Agricultural Science',
        ];

        // 1. Fetch active class streams grouped by Stream Category (Course)
        $classesByCourse = DB::table('class_streams')
            ->join('school_classes', 'class_streams.school_class_id', '=', 'school_classes.id')
            ->join('streams', 'class_streams.stream_id', '=', 'streams.id')
            ->where('class_streams.is_active', true)
            ->select(
                'streams.category as course',
                DB::raw("CONCAT(school_classes.name, ' ', streams.name) as full_class_name")
            )
            ->orderBy('school_classes.level_order', 'asc')
            ->orderBy('streams.name', 'asc')
            ->get()
            ->groupBy(function ($item) {
                return $item->course ?? 'Uncategorized';
            })
            ->map(function ($items) {
                return $items->pluck('full_class_name')->unique()->values()->all();
            })
            ->toArray();

        // 2. Fallback list of all active class stream names
        $allClasses = DB::table('class_streams')
            ->join('school_classes', 'class_streams.school_class_id', '=', 'school_classes.id')
            ->join('streams', 'class_streams.stream_id', '=', 'streams.id')
            ->where('class_streams.is_active', true)
            ->select(DB::raw("CONCAT(school_classes.name, ' ', streams.name) as full_class_name"))
            ->orderBy('school_classes.level_order', 'asc')
            ->orderBy('streams.name', 'asc')
            ->pluck('full_class_name')
            ->unique()
            ->values()
            ->all();

        $availableClasses = Student::distinct()->pluck('class')->filter()->values();

        return view('admin.students.index', compact(
            'students', 
            'courses',
            'classesByCourse',
            'allClasses',
            'availableClasses', 
            'search', 
            'courseFilter', 
            'classFilter',
            'statusFilter'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'index_number'        => 'nullable|string|max:50|unique:students,index_number',
            'course'              => 'required|string|max:255',
            'class'               => 'required|string|max:255',
            'track'               => ['required', Rule::in(['Green', 'Gold', 'Single Track'])],
            'status'              => ['nullable', Rule::in(['Active', 'Completed', 'Suspended'])],
            'house'               => 'nullable|string|max:255',
            'surname'             => 'required|string|max:255',
            'first_name'          => 'required|string|max:255',
            'middle_name'         => 'nullable|string|max:255',
            'date_of_birth'       => 'required|date',
            'place_of_residence'  => 'nullable|string|max:255',
            'address'             => 'nullable|string',
            'guardian_name'       => 'required|string|max:255',
            'guardian_phone'      => 'required|string|max:20',
            'guardian_occupation' => 'nullable|string|max:255',
            'jhs_previous_school' => 'nullable|string|max:255',
            'jhs_index_number'    => 'nullable|string|max:50',
            'jhs_position_held'   => 'nullable|string|max:255',
            'interests_hobbies'   => 'nullable|string',
            'medical_conditions'  => 'nullable|string',
        ]);

        if (empty($validated['status'])) {
            $validated['status'] = 'Active';
        }

        Student::create($validated);

        return redirect()->back()->with('success', 'Student registered successfully!');
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'index_number'        => ['nullable', 'string', 'max:50', Rule::unique('students', 'index_number')->ignore($student->id)],
            'course'              => 'required|string|max:255',
            'class'               => 'required|string|max:255',
            'track'               => ['required', Rule::in(['Green', 'Gold', 'Single Track'])],
            'status'              => ['required', Rule::in(['Active', 'Completed', 'Suspended'])],
            'house'               => 'nullable|string|max:255',
            'surname'             => 'required|string|max:255',
            'first_name'          => 'required|string|max:255',
            'middle_name'         => 'nullable|string|max:255',
            'date_of_birth'       => 'required|date',
            'place_of_residence'  => 'nullable|string|max:255',
            'address'             => 'nullable|string',
            'guardian_name'       => 'required|string|max:255',
            'guardian_phone'      => 'required|string|max:20',
            'guardian_occupation' => 'nullable|string|max:255',
            'jhs_previous_school' => 'nullable|string|max:255',
            'jhs_index_number'    => 'nullable|string|max:50',
            'jhs_position_held'   => 'nullable|string|max:255',
            'interests_hobbies'   => 'nullable|string',
            'medical_conditions'  => 'nullable|string',
        ]);

        $student->update($validated);

        return redirect()->back()->with('success', 'Student record updated successfully!');
    }

    public function updateStatus(Request $request, Student $student)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['Active', 'Completed', 'Suspended'])],
        ]);

        $student->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', "Student status updated to {$validated['status']} successfully!");
    }

    public function destroy(Student $student)
    {
        $student->delete();
        return redirect()->back()->with('success', 'Student record deleted successfully!');
    }

    public function bulkStatus(Request $request)
    {
        $validated = $request->validate([
            'student_ids'   => 'required|array',
            'student_ids.*' => 'exists:students,id',
            'status'        => ['required', Rule::in(['Active', 'Completed', 'Suspended'])],
        ]);

        $count = Student::whereIn('id', $validated['student_ids'])
            ->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', "{$count} student records updated to {$validated['status']} successfully!");
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'student_ids'   => 'required|array',
            'student_ids.*' => 'exists:students,id',
        ]);

        $count = Student::whereIn('id', $validated['student_ids'])->delete();

        return redirect()->back()->with('success', "{$count} student records deleted successfully!");
    }

    public function batchWassce(Request $request)
    {
        $request->validate([
            'class_to_complete' => 'required|string',
        ]);

        $className = $request->input('class_to_complete');

        // Update all students belonging to the selected class
        $updatedCount = Student::where('class', $className)
            ->update(['status' => 'Completed']);

        return redirect()->back()->with(
            'success', 
            "Successfully marked {$updatedCount} student(s) in '{$className}' as Completed (WASSCE)."
        );
    }

    
}