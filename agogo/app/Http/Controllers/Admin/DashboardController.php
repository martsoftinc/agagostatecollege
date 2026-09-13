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

            // ===== PROGRAMME BREAKDOWN =====
$programmeBreakdown = User::where('role', 'student')
    ->where('status', 'Active')
    ->select('programme', DB::raw('count(*) as total'))
    ->groupBy('programme')
    ->orderByDesc('total')
    ->get()
    ->map(function ($item) {
        return [
            'name'  => $item->programme ?: 'Not Set',
            'total' => $item->total,
        ];
    });

// ===== HOUSE BREAKDOWN =====
$houseBreakdown = User::where('role', 'student')
    ->where('status', 'Active')
    ->select('house', DB::raw('count(*) as total'))
    ->groupBy('house')
    ->orderByDesc('total')
    ->get()
    ->map(function ($item) {
        return [
            'name'  => $item->house ?: 'Not Set',
            'total' => $item->total,
        ];
    });

    // ===== BOARDING vs DAY + GENDER BREAKDOWN =====
    $boardingGender = User::where('role', 'student')
        ->where('status', 'Active')
        ->select(
            'boarding',
            'gender',
            DB::raw('count(*) as total')
        )
        ->groupBy('boarding', 'gender')
        ->get();

    $boardingGenderStats = [
        'Boarding' => ['Male' => 0, 'Female' => 0],
        'Day'      => ['Male' => 0, 'Female' => 0],
    ];

    foreach ($boardingGender as $row) {
        $boardingKey = ucfirst(strtolower($row->boarding ?? 'Day')); // normalize
        $genderKey   = ucfirst(strtolower($row->gender ?? 'Male'));

        if (!isset($boardingGenderStats[$boardingKey])) {
            $boardingGenderStats[$boardingKey] = ['Male' => 0, 'Female' => 0];
        }
        if (!isset($boardingGenderStats[$boardingKey][$genderKey])) {
            $boardingGenderStats[$boardingKey][$genderKey] = 0;
        }

        $boardingGenderStats[$boardingKey][$genderKey] += $row->total;
    }

    // ===== HOUSE BREAKDOWN BY GENDER =====
    $houseGender = User::where('role', 'student')
        ->where('status', 'Active')
        ->select(
            'house',
            'gender',
            DB::raw('count(*) as total')
        )
        ->groupBy('house', 'gender')
        ->get();

    $houseGenderStats = [];

    foreach ($houseGender as $row) {
        $houseName = $row->house ?: 'Not Set';
        $genderKey = ucfirst(strtolower($row->gender ?? 'Male'));

        if (!isset($houseGenderStats[$houseName])) {
            $houseGenderStats[$houseName] = ['Male' => 0, 'Female' => 0, 'total' => 0];
        }

        $houseGenderStats[$houseName][$genderKey] += $row->total;
        $houseGenderStats[$houseName]['total'] += $row->total;
    }

    // Sort houses by total students (descending)
    uasort($houseGenderStats, fn($a, $b) => $b['total'] <=> $a['total']);

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
            'classBreakdown',
            'programmeBreakdown',      // new
            'houseBreakdown',          // new
            'boardingGenderStats',     // new
            'houseGenderStats'         // new
        ));
    }
}