<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Score;
use App\Models\Semester;
use App\Models\AssessmentWeight;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf; // if you use barryvdh/laravel-dompdf

class ReportController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        $semesters = Semester::with('academicYear')
            ->whereHas('scores', function ($q) use ($student) {
                $q->where('student_id', $student->id);
            })
            ->orderByDesc('id')
            ->get();

        return view('student.reports.index', compact('student', 'semesters'));
    }



    /*
        public function show(Semester $semester)
        {
            $student = Auth::user();

            $scores = \App\Models\Score::with('subject')
                ->where('student_id', $student->id)
                ->where('semester_id', $semester->id)
                ->get();

            $totalPoints  = $scores->sum('grade_point');
            $subjectCount = $scores->whereNotNull('grade_point')->count();
            $semesterGpa  = $subjectCount > 0 ? round($totalPoints / $subjectCount, 2) : null;

            $weights = \App\Models\AssessmentWeight::active();

            return view('student.reports.show', [
                'student'     => $student,
                'semester'    => $semester,
                'scores'      => $scores,
                'semesterGpa' => $semesterGpa,
                'weights'     => $weights,
            ]);
        }




   public function download(Semester $semester)
{
    $student = Auth::user();

    $scores = Score::with('subject')
        ->where('student_id', $student->id)
        ->where('semester_id', $semester->id)
        ->get();

    $totalPoints  = $scores->sum('grade_point');
    $subjectCount = $scores->whereNotNull('grade_point')->count();
    $semesterGpa  = $subjectCount > 0 ? round($totalPoints / $subjectCount, 2) : null;

    $weights = \App\Models\AssessmentWeight::active();

    $pdf = Pdf::loadView('student.reports.pdf', compact(
        'student',
        'semester',
        'scores',
        'semesterGpa',
        'weights'
    ))->setPaper('a4');

    $filename = 'Terminal_Report_' . ($student->student_id ?? $student->id) . '_' . str_replace(' ', '_', $semester->name) . '.pdf';

    return $pdf->download($filename);
}*/

public function show(Semester $semester)
{
    $student = Auth::user();

    $scores = Score::with('subject')
        ->where('student_id', $student->id)
        ->where('semester_id', $semester->id)
        ->get();

    // Calculate Semester GPA
    $totalPoints  = $scores->sum('grade_point');
    $subjectCount = $scores->whereNotNull('grade_point')->count();
    $semesterGpa  = $subjectCount > 0 ? round($totalPoints / $subjectCount, 2) : null;

    $weights = AssessmentWeight::active();

    // === SUBJECT POSITIONS ===
    $subjectPositions = $this->calculateSubjectPositions($student, $semester, $scores);

    return view('student.reports.show', compact(
        'student',
        'semester',
        'scores',
        'semesterGpa',
        'weights',
        'subjectPositions'
    ));
}

public function download(Semester $semester)
{
    $student = Auth::user();

    $scores = Score::with('subject')
        ->where('student_id', $student->id)
        ->where('semester_id', $semester->id)
        ->get();

    $totalPoints  = $scores->sum('grade_point');
    $subjectCount = $scores->whereNotNull('grade_point')->count();
    $semesterGpa  = $subjectCount > 0 ? round($totalPoints / $subjectCount, 2) : null;

    $weights = AssessmentWeight::active();

    // === SUBJECT POSITIONS ===
    $subjectPositions = $this->calculateSubjectPositions($student, $semester, $scores);

    $pdf = Pdf::loadView('student.reports.pdf', compact(
        'student',
        'semester',
        'scores',
        'semesterGpa',
        'weights',
        'subjectPositions'
    ))->setPaper('a4');

    $filename = 'Terminal_Report_' . ($student->student_id ?? $student->id) . '_' . str_replace(' ', '_', $semester->name) . '.pdf';

    return $pdf->download($filename);
}

/**
 * Calculate subject positions for the student
 */
private function calculateSubjectPositions($student, $semester, $scores)
{
    $positions = [];

    foreach ($scores as $score) {
        if (is_null($score->total_score)) {
            $positions[$score->subject_id] = null;
            continue;
        }

        // Get all scores for this subject in the same class + semester
        $allScores = Score::where('class_stream_id', $score->class_stream_id)
            ->where('subject_id', $score->subject_id)
            ->where('semester_id', $semester->id)
            ->whereNotNull('total_score')
            ->orderByDesc('total_score')
            ->get();

        $rank = 1;
        $previousScore = null;
        $actualPosition = 1;

        foreach ($allScores as $index => $s) {
            if ($previousScore !== null && $s->total_score < $previousScore) {
                $rank = $index + 1;
            }

            if ($s->student_id === $student->id) {
                $actualPosition = $rank;
                break;
            }

            $previousScore = $s->total_score;
        }

        $totalStudents = $allScores->count();
        $positions[$score->subject_id] = $actualPosition . ' / ' . $totalStudents;
    }

    return $positions;
}
}