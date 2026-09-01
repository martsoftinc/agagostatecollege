<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassStream;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // ===== MAIN METRICS =====
        $totalEnrolled = User::where('role', 'student')
            ->where('status', 'Active')
            ->count();

        $totalTeachers = User::where('role', 'teacher')->count();

        $totalClasses = ClassStream::where('is_active', true)->count();

        // Pending admissions (adjust if you have a different table/status)
        $pendingAdmissions = User::where('role', 'student')
            ->where('status', 'Pending')
            ->count();

        // ===== GENDER DISTRIBUTION =====
        $genderStats = User::where('role', 'student')
            ->where('status', 'Active')
            ->select('gender', DB::raw('count(*) as total'))
            ->groupBy('gender')
            ->pluck('total', 'gender');

        $maleStudents   = $genderStats['Male'] ?? $genderStats['male'] ?? 0;
        $femaleStudents = $genderStats['Female'] ?? $genderStats['female'] ?? 0;
        $otherGender    = $totalEnrolled - ($maleStudents + $femaleStudents);

        $boardingStats = User::where('role', 'student')
            ->where('status', 'Active')
            ->select('boarding', DB::raw('count(*) as total'))
            ->groupBy('boarding')
            ->pluck('total', 'boarding');

        $boardingStudents = $boardingStats['Boarding'] ?? $boardingStats['boarding'] ?? 0;
        $dayStudents      = $boardingStats['Day'] ?? $boardingStats['day'] ?? 0;

        // ===== CLASS POPULATION BREAKDOWN =====
        $classBreakdown = ClassStream::with(['schoolClass', 'stream', 'teacher'])
            ->withCount(['students' => function ($q) {
                $q->where('role', 'student')->where('status', 'Active');
            }])
            ->where('is_active', true)
            ->get()
            ->map(function ($cs) {
                // Gender breakdown per class
                $genders = User::where('class_stream_id', $cs->id)
                    ->where('role', 'student')
                    ->where('status', 'Active')
                    ->select('gender', DB::raw('count(*) as total'))
                    ->groupBy('gender')
                    ->pluck('total', 'gender');

                $male   = $genders['Male'] ?? $genders['male'] ?? 0;
                $female = $genders['Female'] ?? $genders['female'] ?? 0;

                $occupancy = $cs->capacity > 0
                    ? round(($cs->students_count / $cs->capacity) * 100)
                    : 0;

                return [
                    'id'            => $cs->id,
                    'name'          => $cs->schoolClass->name . ' ' . $cs->stream->name,
                    'tutor'         => $cs->teacher->name ?? 'Unassigned',
                    'capacity'      => $cs->capacity,
                    'enrolled'      => $cs->students_count,
                    'occupancy'     => $occupancy,
                    'male'          => $male,
                    'female'        => $female,
                ];
            });

        return view('admin.dashboard', compact(
            'totalEnrolled',
            'pendingAdmissions',
            'totalTeachers',
            'totalClasses',
            'maleStudents',
            'femaleStudents',
            'otherGender',
            'boardingStudents',
            'dayStudents',
            'classBreakdown'
        ));
    }
}