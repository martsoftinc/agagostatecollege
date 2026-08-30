<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\AssessmentWeight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AcademicSetupController extends Controller
{
    public function index()
    {
        $academicYears = AcademicYear::with('semesters')->orderByDesc('name')->get();
        $weights = AssessmentWeight::with('academicYear')->where('is_active', true)->first();
        $allWeights = AssessmentWeight::with('academicYear')->latest()->get();

        return view('admin.academic-setup.index', compact('academicYears', 'weights', 'allWeights'));
    }

    public function storeYear(Request $request)
    {
        $validated = $request->validate([
            'name'       => 'required|string|max:20|unique:academic_years,name',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        DB::transaction(function () use ($validated) {
            // If this is the first year or user wants it current
            $isFirst = AcademicYear::count() === 0;

            $year = AcademicYear::create([
                'name'       => $validated['name'],
                'start_date' => $validated['start_date'] ?? null,
                'end_date'   => $validated['end_date'] ?? null,
                'is_current' => $isFirst,
                'is_active'  => true,
            ]);

            // Auto-create 2 Semesters
            $year->semesters()->createMany([
                [
                    'name'       => 'Semester 1',
                    'number'     => 1,
                    'is_current' => $isFirst,
                    'is_locked'  => false,
                ],
                [
                    'name'       => 'Semester 2',
                    'number'     => 2,
                    'is_current' => false,
                    'is_locked'  => false,
                ],
            ]);

            // Create default weights for this year if none exist
            if (!AssessmentWeight::where('is_active', true)->exists()) {
                AssessmentWeight::create([
                    'academic_year_id'   => $year->id,
                    'classwork_percent'  => 25,
                    'midsem_percent'     => 25,
                    'exam_percent'       => 50,
                    'is_active'          => true,
                ]);
            }
        });

        return redirect()->back()->with('success', 'Academic Year and Semesters created successfully!');
    }

    public function setCurrentYear(AcademicYear $academicYear)
    {
        DB::transaction(function () use ($academicYear) {
            AcademicYear::query()->update(['is_current' => false]);
            $academicYear->update(['is_current' => true]);

            // Also set Semester 1 of this year as current by default
            Semester::query()->update(['is_current' => false]);
            $academicYear->semesters()->where('number', 1)->update(['is_current' => true]);
        });

        return redirect()->back()->with('success', 'Current Academic Year updated!');
    }

    public function setCurrentSemester(Semester $semester)
    {
        DB::transaction(function () use ($semester) {
            Semester::query()->update(['is_current' => false]);
            $semester->update(['is_current' => true]);

            // Make sure the parent year is also current
            AcademicYear::query()->update(['is_current' => false]);
            $semester->academicYear->update(['is_current' => true]);
        });

        return redirect()->back()->with('success', 'Current Semester updated!');
    }

    public function updateWeights(Request $request)
    {
        $validated = $request->validate([
            'classwork_percent' => 'required|numeric|min:0|max:100',
            'midsem_percent'    => 'required|numeric|min:0|max:100',
            'exam_percent'      => 'required|numeric|min:0|max:100',
        ]);

        $total = $validated['classwork_percent'] + $validated['midsem_percent'] + $validated['exam_percent'];

        if (round($total, 2) !== 100.00) {
            return redirect()->back()->with('error', 'The three percentages must add up to exactly 100%. Current total: ' . $total . '%');
        }

        $weights = AssessmentWeight::where('is_active', true)->first();

        if ($weights) {
            $weights->update($validated);
        } else {
            AssessmentWeight::create(array_merge($validated, [
                'is_active' => true,
            ]));
        }

        return redirect()->back()->with('success', 'Assessment weights updated successfully!');
    }

    public function toggleLock(Semester $semester)
    {
        $semester->update(['is_locked' => !$semester->is_locked]);

        $status = $semester->is_locked ? 'locked' : 'unlocked';
        return redirect()->back()->with('success', "Semester has been {$status}!");
    }
}