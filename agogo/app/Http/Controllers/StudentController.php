<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        Log::info('StudentController@index called', [
            'query' => $request->query()
        ]);

        $search       = $request->query('search');
        $courseFilter = $request->query('course');
        $classFilter  = $request->query('class');
        $statusFilter = $request->query('status');

        $students = User::query()
            ->where('role', 'student')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('student_id', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('first_name', 'like', "%{$search}%")
                      ->orWhere('other_names', 'like', "%{$search}%")
                      ->orWhere('guardian_phone', 'like', "%{$search}%")
                      ->orWhere('jhs_index_number', 'like', "%{$search}%");
                });
            })
            ->when($courseFilter, fn ($q) => $q->where('course', $courseFilter))
            ->when($classFilter,  fn ($q) => $q->where('class', $classFilter))
            ->when($statusFilter, fn ($q) => $q->where('status', $statusFilter))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        Log::info('Students fetched', ['count' => $students->total()]);

        $courses = [
            'General Science',
            'Business',
            'General Arts',
            'Visual Arts',
            'Home Economics',
            'Agricultural Science',
        ];
        $classStreams = \App\Models\ClassStream::with(['schoolClass', 'stream'])
            ->where('is_active', true)
            ->get();


        $classesByCourse = DB::table('class_streams')
            ->join('school_classes', 'class_streams.school_class_id', '=', 'school_classes.id')
            ->join('streams', 'class_streams.stream_id', '=', 'streams.id')
            ->where('class_streams.is_active', true)
            ->select(
                'streams.category as course',
                DB::raw("CONCAT(school_classes.name, ' ', streams.name) as full_class_name")
            )
            ->orderBy('school_classes.level_order')
            ->orderBy('streams.name')
            ->get()
            ->groupBy(fn ($item) => $item->course ?? 'Uncategorized')
            ->map(fn ($items) => $items->pluck('full_class_name')->unique()->values()->all())
            ->toArray();

        $allClasses = DB::table('class_streams')
            ->join('school_classes', 'class_streams.school_class_id', '=', 'school_classes.id')
            ->join('streams', 'class_streams.stream_id', '=', 'streams.id')
            ->where('class_streams.is_active', true)
            ->select(DB::raw("CONCAT(school_classes.name, ' ', streams.name) as full_class_name"))
            ->orderBy('school_classes.level_order')
            ->orderBy('streams.name')
            ->pluck('full_class_name')
            ->unique()
            ->values()
            ->all();

        $availableClasses = User::where('role', 'student')
            ->distinct()
            ->pluck('class')
            ->filter()
            ->values();

        return view('admin.students.index', compact(
            'students',
            'courses',
            'classesByCourse',
            'allClasses',
            'availableClasses',
            'search',
            'courseFilter',
            'classFilter',
            'classStreams',
            'statusFilter'
        ));
    }

    public function store(Request $request)
    {
        Log::info('StudentController@store started', [
            'all_input' => $request->except(['profile_picture']),
            'has_file'  => $request->hasFile('profile_picture'),
        ]);

        $course = $request->input('programme');
        
        try {
            $validated = $request->validate([
                'student_id'          => 'nullable|string|max:50|unique:users,student_id',
                'class_stream_id' => 'required|exists:class_streams,id',
                'programme'           => 'required|string|max:255',
                'boarding'           => 'required|string|max:255',
                'class'               => 'required|string|max:255',
                'track'               => ['required', Rule::in(['Green', 'Gold', 'Single Track'])],
                'status'              => ['nullable', Rule::in(['Active', 'Completed', 'Suspended'])],
                'house'               => 'nullable|string|max:255',
                'last_name'           => 'required|string|max:255',
                'first_name'          => 'required|string|max:255',
                'other_names'         => 'nullable|string|max:255',
                'date_of_birth'       => 'required|date',
                'place_of_residence'  => 'nullable|string|max:255',
                'address'             => 'nullable|string',
                'guardian_name'       => 'required|string|max:255',
                'email'               => 'email',
                'guardian_phone'      => 'required|string|max:20',
                'guardian_occupation' => 'nullable|string|max:255',
                'jhs_previous_school' => 'nullable|string|max:255',
                'jhs_index_number'    => 'nullable|string|max:50',
                'jhs_position_held'   => 'nullable|string|max:255',
                'interests_hobbies'   => 'nullable|string',
                'medical_conditions'  => 'nullable|string',
                'profile_picture'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,jfif|max:9048',
              
            ]);

             $validated['course'] = $course;

            Log::info('Validation passed', ['validated_keys' => array_keys($validated)]);

            $validated['role']   = 'student';
            $validated['status'] = $validated['status'] ?? 'Active';

            if ($request->hasFile('profile_picture')) {
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $validated['profile_picture'] = $path;
                Log::info('Profile picture stored', ['path' => $path]);
            }
            
            $student = User::create($validated);

            Log::info('Student created successfully', [
                'id'         => $student->id,
                'student_id' => $student->student_id,
            ]);

            return redirect()->back()->with('success', 'Student registered successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed on store', [
                'errors' => $e->errors(),
                'input'  => $request->except(['profile_picture']),
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Student store failed', [
                'message' => $e->getMessage(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'trace'   => $e->getTraceAsString(),
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to register student: ' . $e->getMessage());
        }
    }

    public function update(Request $request, User $student)
    {
        Log::info('StudentController@update started', [
            'student_id' => $student->id,
            'role'       => $student->role,
        ]);

        abort_unless($student->role === 'student', 404);

        try {
            $validated = $request->validate([
                'student_id'          => [
                    'nullable', 'string', 'max:50',
                    Rule::unique('users', 'student_id')->ignore($student->id),
                ],
                'course'              => 'required|string|max:255',
                'class_stream_id' => 'required|exists:class_streams,id',
                'class'               => 'required|string|max:255',
                'track'               => ['required', Rule::in(['Green', 'Gold', 'Single Track'])],
                'status'              => ['required', Rule::in(['Active', 'Completed', 'Suspended'])],
                'house'               => 'nullable|string|max:255',
                'last_name'           => 'required|string|max:255',
                'first_name'          => 'required|string|max:255',
                'other_names'         => 'nullable|string|max:255',
                'date_of_birth'       => 'required|date',
                'place_of_residence'  => 'nullable|string|max:255',
                'address'             => 'nullable|string',
                'email'             =>   'email|string',
                'guardian_name'       => 'required|string|max:255',
                'guardian_phone'      => 'required|string|max:20',
                'guardian_occupation' => 'nullable|string|max:255',
                'jhs_previous_school' => 'nullable|string|max:255',
                'jhs_index_number'    => 'nullable|string|max:50',
                'jhs_position_held'   => 'nullable|string|max:255',
                'interests_hobbies'   => 'nullable|string',
                'medical_conditions'  => 'nullable|string',
                'profile_picture'     => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            if ($request->hasFile('profile_picture')) {
                if ($student->profile_picture && Storage::disk('public')->exists($student->profile_picture)) {
                    Storage::disk('public')->delete($student->profile_picture);
                }
                $path = $request->file('profile_picture')->store('profile_pictures', 'public');
                $validated['profile_picture'] = $path;
            }

            $student->update($validated);

            Log::info('Student updated', ['id' => $student->id]);

            return redirect()->back()->with('success', 'Student record updated successfully!');
        } catch (\Exception $e) {
            Log::error('Student update failed', [
                'id'      => $student->id,
                'message' => $e->getMessage(),
            ]);
            return redirect()->back()->withInput()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, User $student)
    {
        abort_unless($student->role === 'student', 404);

        $validated = $request->validate([
            'status' => ['required', Rule::in(['Active', 'Completed', 'Suspended'])],
        ]);

        $student->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', "Student status updated to {$validated['status']} successfully!");
    }

    public function destroy(User $student)
    {
        abort_unless($student->role === 'student', 404);

        if ($student->profile_picture && Storage::disk('public')->exists($student->profile_picture)) {
            Storage::disk('public')->delete($student->profile_picture);
        }

        $student->delete();

        return redirect()->back()->with('success', 'Student record deleted successfully!');
    }

    public function bulkStatus(Request $request)
    {
        $validated = $request->validate([
            'student_ids'   => 'required|array',
            'student_ids.*' => 'exists:users,id',
            'status'        => ['required', Rule::in(['Active', 'Completed', 'Suspended'])],
        ]);

        $count = User::where('role', 'student')
            ->whereIn('id', $validated['student_ids'])
            ->update(['status' => $validated['status']]);

        return redirect()->back()->with('success', "{$count} student records updated to {$validated['status']} successfully!");
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'student_ids'   => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        $count = User::where('role', 'student')
            ->whereIn('id', $validated['student_ids'])
            ->delete();

        return redirect()->back()->with('success', "{$count} student records deleted successfully!");
    }

    public function batchWassce(Request $request)
    {
        $request->validate(['class_to_complete' => 'required|string']);

        $className = $request->input('class_to_complete');

        $updatedCount = User::where('role', 'student')
            ->where('class', $className)
            ->update(['status' => 'Completed']);

        return redirect()->back()->with(
            'success',
            "Successfully marked {$updatedCount} student(s) in '{$className}' as Completed (WASSCE)."
        );
    }

    /**
     * Export all filtered students to CSV
     */
    public function export(Request $request): StreamedResponse
    {
        Log::info('StudentController@export started');

        $search       = $request->query('search');
        $courseFilter = $request->query('course');
        $classFilter  = $request->query('class');
        $statusFilter = $request->query('status');

        $students = User::query()
            ->where('role', 'student')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('student_id', 'like', "%{$search}%")
                      ->orWhere('last_name', 'like', "%{$search}%")
                      ->orWhere('first_name', 'like', "%{$search}%")
                      ->orWhere('other_names', 'like', "%{$search}%")
                      ->orWhere('guardian_phone', 'like', "%{$search}%");
                });
            })
            ->when($courseFilter, fn ($q) => $q->where('course', $courseFilter))
            ->when($classFilter,  fn ($q) => $q->where('class', $classFilter))
            ->when($statusFilter, fn ($q) => $q->where('status', $statusFilter))
            ->orderBy('last_name')
            ->get();

        $filename = 'students_export_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $columns = [
            'student_id', 'last_name', 'first_name', 'other_names',
            'course', 'class', 'track', 'status', 'house',
            'date_of_birth', 'place_of_residence', 'address',
            'guardian_name', 'guardian_phone', 'guardian_occupation',
            'jhs_previous_school', 'jhs_index_number', 'jhs_position_held',
            'interests_hobbies', 'medical_conditions',
        ];

        return response()->stream(function () use ($students, $columns) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $columns);

            foreach ($students as $student) {
                $row = [];
                foreach ($columns as $col) {
                    $row[] = $student->{$col} ?? '';
                }
                fputcsv($handle, $row);
            }
            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Import students from CSV
     * Expected headers (case-insensitive):
     * last_name, first_name, other_names, course, class, track, status, house,
     * date_of_birth, place_of_residence, address,
     * guardian_name, guardian_phone, guardian_occupation,
     * jhs_previous_school, jhs_index_number, jhs_position_held,
     * interests_hobbies, medical_conditions
     *
     * student_id is OPTIONAL – auto-generated if missing
     */
    public function import(Request $request)
    {
        Log::info('StudentController@import started');

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:5120', // 5MB
        ]);

        $file = $request->file('csv_file');
        $path = $file->getRealPath();

        $handle = fopen($path, 'r');
        if (!$handle) {
            Log::error('Could not open uploaded CSV');
            return redirect()->back()->with('error', 'Could not read the uploaded file.');
        }

        $header = fgetcsv($handle);
        if (!$header) {
            fclose($handle);
            return redirect()->back()->with('error', 'CSV file is empty or invalid.');
        }

        // Normalize headers to lowercase + underscores
        $header = array_map(function ($h) {
            return strtolower(trim(str_replace([' ', '-'], '_', $h)));
        }, $header);

        Log::info('CSV headers detected', ['headers' => $header]);

        $required = ['last_name', 'first_name', 'course', 'class', 'track', 'guardian_name', 'guardian_phone', 'date_of_birth'];
        foreach ($required as $req) {
            if (!in_array($req, $header)) {
                fclose($handle);
                Log::error('Missing required CSV column', ['missing' => $req]);
                return redirect()->back()->with('error', "CSV is missing required column: {$req}");
            }
        }

        $created = 0;
        $skipped = 0;
        $errors  = [];

        DB::beginTransaction();
        try {
            $rowNumber = 1;
            while (($row = fgetcsv($handle)) !== false) {
                $rowNumber++;

                if (count($row) !== count($header)) {
                    $errors[] = "Row {$rowNumber}: column count mismatch";
                    $skipped++;
                    continue;
                }

                $data = array_combine($header, $row);

                // Skip completely empty rows
                if (empty(array_filter($data))) {
                    continue;
                }

                try {
                    $payload = [
                        'role'                => 'student',
                        'status'              => $data['status'] ?? 'Active',
                        'last_name'           => trim($data['last_name']),
                        'first_name'          => trim($data['first_name']),
                        'other_names'         => trim($data['other_names'] ?? '') ?: null,
                        'course'              => trim($data['course']),
                        'class'               => trim($data['class']),
                        'track'               => trim($data['track'] ?? 'Single Track'),
                        'house'               => trim($data['house'] ?? '') ?: null,
                        'date_of_birth'       => trim($data['date_of_birth']),
                        'place_of_residence'  => trim($data['place_of_residence'] ?? '') ?: null,
                        'address'             => trim($data['address'] ?? '') ?: null,
                        'guardian_name'       => trim($data['guardian_name']),
                        'guardian_phone'      => trim($data['guardian_phone']),
                        'guardian_occupation' => trim($data['guardian_occupation'] ?? '') ?: null,
                        'email'               => trim($data['email'] ?? '') ?: null,
                        'jhs_previous_school' => trim($data['jhs_previous_school'] ?? '') ?: null,
                        'jhs_index_number'    => trim($data['jhs_index_number'] ?? '') ?: null,
                        'jhs_position_held'   => trim($data['jhs_position_held'] ?? '') ?: null,
                        'interests_hobbies'   => trim($data['interests_hobbies'] ?? '') ?: null,
                        'medical_conditions'  => trim($data['medical_conditions'] ?? '') ?: null,
                    ];

                    // Optional student_id from CSV
                    if (!empty(trim($data['student_id'] ?? ''))) {
                        $payload['student_id'] = trim($data['student_id']);
                    }
                    // else: User model boot will auto-generate it

                    User::create($payload);
                    $created++;
                } catch (\Exception $e) {
                    $errors[] = "Row {$rowNumber}: " . $e->getMessage();
                    $skipped++;
                    Log::warning('CSV row failed', [
                        'row'     => $rowNumber,
                        'message' => $e->getMessage(),
                        'data'    => $data,
                    ]);
                }
            }

            DB::commit();
            fclose($handle);

            Log::info('CSV import finished', [
                'created' => $created,
                'skipped' => $skipped,
                'errors'  => $errors,
            ]);

            $message = "Import complete: {$created} student(s) created.";
            if ($skipped > 0) {
                $message .= " {$skipped} row(s) skipped.";
            }

            return redirect()->back()->with('success', $message)
                ->with('import_errors', $errors);
        } catch (\Exception $e) {
            DB::rollBack();
            fclose($handle);
            Log::error('CSV import transaction failed', ['message' => $e->getMessage()]);
            return redirect()->back()->with('error', 'Import failed: ' . $e->getMessage());
        }
    }
}