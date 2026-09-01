<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassStream;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;

class PerformanceController extends Controller
{
    public function index(Request $request)
    {
        $mode = $request->get('mode', 'student'); // student | class

        // For student search
        $students = User::where('role', 'student')
            ->orderBy('last_name')
            ->get(['id', 'first_name', 'last_name', 'other_names', 'student_id']);

        // For class selection
        $classStreams = ClassStream::with(['schoolClass', 'stream'])
            ->where('is_active', true)
            ->get();

        $selectedStudentId     = $request->get('student_id');
        $selectedClassStreamId = $request->get('class_stream_id');
        $selectedSubjectId     = $request->get('subject_id');

        $data = [
            'mode'                  => $mode,
            'students'              => $students,
            'classStreams'          => $classStreams,
            'selectedStudentId'     => $selectedStudentId,
            'selectedClassStreamId' => $selectedClassStreamId,
            'selectedSubjectId'     => $selectedSubjectId,
            'selectedStudent'       => null,
            'selectedClassStream'   => null,
            'selectedSubject'       => null,
            'subjectsData'          => [],
            'studentsData'          => [],
            'summary'               => null,
            'strongest'             => null,
            'weakest'               => null,
            'improving'             => 0,
            'declining'             => 0,
            'fallingShortCount'     => 0,
            'semesterLabels'        => [],
            'classAverages'         => [],
            'gradeDistribution'     => [],
            'latestScores'          => [],
        ];

        if ($mode === 'student' && $selectedStudentId) {
            $selectedStudent = User::with('classStream.schoolClass', 'classStream.stream')
                ->find($selectedStudentId);

            if ($selectedStudent) {
                $result = $this->buildStudentPerformance($selectedStudent);
                $data = array_merge($data, $result, [
                    'selectedStudent' => $selectedStudent,
                ]);
            }
        }

        if ($mode === 'class' && $selectedClassStreamId && $selectedSubjectId) {
            $result = $this->buildClassPerformance($selectedClassStreamId, $selectedSubjectId);
            $data = array_merge($data, $result);
        }

        return view('admin.performance.index', $data);
    }

    private function buildStudentPerformance($student)
    {
        // (Keep the exact same buildStudentPerformance method I gave you earlier)
        // ... paste the previous private method here ...
    }

    private function buildClassPerformance($classStreamId, $subjectId)
    {
        $selectedClassStream = ClassStream::with(['schoolClass', 'stream'])->find($classStreamId);
        $selectedSubject     = \App\Models\Subject::find($subjectId);

        $students = User::where('class_stream_id', $classStreamId)
            ->where('role', 'student')
            ->orderBy('last_name')
            ->get();

        $allScores = Score::with(['semester.academicYear'])
            ->where('class_stream_id', $classStreamId)
            ->where('subject_id', $subjectId)
            ->whereNotNull('total_score')
            ->get();

        $semesterLabels = $allScores->map(fn($s) => ($s->semester->academicYear->name ?? '') . ' - ' . $s->semester->name)
            ->unique()->sort()->values()->toArray();

        $classAverages = [];
        foreach ($semesterLabels as $label) {
            $semScores = $allScores->filter(fn($s) => (($s->semester->academicYear->name ?? '') . ' - ' . $s->semester->name) === $label);
            $classAverages[] = $semScores->count() ? round($semScores->avg('total_score'), 1) : null;
        }

        $studentsData = [];
        $latestScores = [];

        foreach ($students as $student) {
            $studentScores = $allScores->where('student_id', $student->id)
                ->sortBy(fn($s) => ($s->semester->academicYear->name ?? '') . $s->semester->number)
                ->values();

            $history = [];
            foreach ($studentScores as $score) {
                $history[] = [
                    'label' => ($score->semester->academicYear->name ?? '') . ' - ' . $score->semester->name,
                    'total' => $score->total_score,
                    'grade' => $score->grade,
                ];
            }

            $latest   = $history[count($history) - 1] ?? null;
            $previous = $history[count($history) - 2] ?? null;

            $trend = 'stable'; $trendIcon = '→'; $trendColor = 'text-slate-500';
            if ($latest && $previous) {
                if ($latest['total'] > $previous['total'] + 2) {
                    $trend = 'improving'; $trendIcon = '↑'; $trendColor = 'text-emerald-600';
                } elseif ($latest['total'] < $previous['total'] - 2) {
                    $trend = 'declining'; $trendIcon = '↓'; $trendColor = 'text-rose-600';
                }
            }

            $isFallingShort = ($latest && in_array($latest['grade'], ['C6','D7','E8','F9'])) || $trend === 'declining';

            $studentsData[] = [
                'student' => $student,
                'history' => $history,
                'latest' => $latest,
                'average' => $studentScores->count() ? round($studentScores->avg('total_score'), 1) : null,
                'trend' => $trend,
                'trend_icon' => $trendIcon,
                'trend_color' => $trendColor,
                'is_falling_short' => $isFallingShort,
            ];

            if ($latest) {
                $latestScores[] = ['name' => $student->last_name . ' ' . $student->first_name, 'total' => $latest['total']];
            }
        }

        usort($studentsData, fn($a, $b) => $a['is_falling_short'] <=> $b['is_falling_short'] ?: ($a['latest']['total'] ?? 0) <=> ($b['latest']['total'] ?? 0));

        $allLatest = collect($studentsData)->pluck('latest.total')->filter();
        $summary = [
            'average' => $allLatest->count() ? round($allLatest->avg(), 1) : null,
            'highest' => $allLatest->max(),
            'lowest' => $allLatest->min(),
            'needsAttention' => collect($studentsData)->where('is_falling_short', true)->count(),
            'totalStudents' => count($studentsData),
        ];

        $gradeDistribution = [];
        foreach (['A1','B2','B3','C4','C5','C6','D7','E8','F9'] as $g) {
            $gradeDistribution[$g] = collect($studentsData)->where('latest.grade', $g)->count();
        }

        return compact(
            'selectedClassStream', 'selectedSubject', 'studentsData', 'summary',
            'semesterLabels', 'classAverages', 'gradeDistribution', 'latestScores'
        );
    }
}