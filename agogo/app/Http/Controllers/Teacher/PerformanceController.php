<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassStream;
use App\Models\Score;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerformanceController extends Controller
{
    public function index(Request $request)
{
    $teacherId = Auth::id();

    $classStreams = ClassStream::whereHas('subjects', function ($q) use ($teacherId) {
            $q->where('class_stream_subject.teacher_id', $teacherId);
        })
        ->with(['schoolClass', 'stream', 'subjects' => function ($q) use ($teacherId) {
            $q->where('class_stream_subject.teacher_id', $teacherId);
        }])
        ->where('is_active', true)
        ->get();

    $selectedClassStreamId = $request->get('class_stream_id');
    $selectedSubjectId     = $request->get('subject_id');

    $data = $this->buildPerformanceData($selectedClassStreamId, $selectedSubjectId, $teacherId);

    // If AJAX request → return only the results partial
    if ($request->ajax()) {
        return view('teacher.performance.partials.results', $data);
    }

    return view('teacher.performance.index', array_merge($data, [
        'classStreams' => $classStreams,
        'selectedClassStreamId' => $selectedClassStreamId,
        'selectedSubjectId' => $selectedSubjectId,
    ]));
}

/**
 * Build all the performance data
 */
private function buildPerformanceData($classStreamId, $subjectId, $teacherId)
{
    $selectedClassStream = null;
    $selectedSubject     = null;
    $studentsData        = [];
    $summary             = null;
    $semesterLabels      = [];
    $classAverages       = [];
    $gradeDistribution   = [];
    $latestScores        = [];

    if ($classStreamId && $subjectId) {
        $selectedClassStream = ClassStream::with(['schoolClass', 'stream'])->find($classStreamId);
        $selectedSubject     = Subject::find($subjectId);

        $isAssigned = $selectedClassStream && $selectedClassStream->subjects()
            ->where('subject_id', $subjectId)
            ->wherePivot('teacher_id', $teacherId)
            ->exists();

        if ($isAssigned) {
            $students = User::where('class_stream_id', $classStreamId)
                ->where('role', 'student')
                ->orderBy('last_name')
                ->get();

            $allScores = Score::with(['semester.academicYear'])
                ->where('class_stream_id', $classStreamId)
                ->where('subject_id', $subjectId)
                ->whereNotNull('total_score')
                ->get();

            $semesterLabels = $allScores->map(function ($s) {
                return ($s->semester->academicYear->name ?? '') . ' - ' . $s->semester->name;
            })->unique()->sort()->values()->toArray();

            foreach ($semesterLabels as $label) {
                $semScores = $allScores->filter(function ($s) use ($label) {
                    $l = ($s->semester->academicYear->name ?? '') . ' - ' . $s->semester->name;
                    return $l === $label;
                });
                $classAverages[] = $semScores->count() > 0 ? round($semScores->avg('total_score'), 1) : null;
            }

            foreach ($students as $student) {
                $studentScores = $allScores->where('student_id', $student->id)
                    ->sortBy(fn($s) => ($s->semester->academicYear->name ?? '') . $s->semester->number)
                    ->values();

                $history = [];
                foreach ($studentScores as $score) {
                    $history[] = [
                        'label'       => ($score->semester->academicYear->name ?? '') . ' - ' . $score->semester->name,
                        'total'       => $score->total_score,
                        'grade'       => $score->grade,
                        'grade_point' => $score->grade_point,
                    ];
                }

                $latest   = $history[count($history) - 1] ?? null;
                $previous = $history[count($history) - 2] ?? null;

                $trend = 'stable';
                $trendIcon = '→';
                $trendColor = 'text-slate-500';

                if ($latest && $previous) {
                    if ($latest['total'] > $previous['total'] + 2) {
                        $trend = 'improving'; $trendIcon = '↑'; $trendColor = 'text-emerald-600';
                    } elseif ($latest['total'] < $previous['total'] - 2) {
                        $trend = 'declining'; $trendIcon = '↓'; $trendColor = 'text-rose-600';
                    }
                }

                $isFallingShort = false;
                if ($latest && in_array($latest['grade'], ['C6', 'D7', 'E8', 'F9'])) {
                    $isFallingShort = true;
                }
                if ($trend === 'declining') $isFallingShort = true;

                $studentsData[] = [
                    'student'          => $student,
                    'history'          => $history,
                    'latest'           => $latest,
                    'average'          => $studentScores->count() > 0 ? round($studentScores->avg('total_score'), 1) : null,
                    'trend'            => $trend,
                    'trend_icon'       => $trendIcon,
                    'trend_color'      => $trendColor,
                    'is_falling_short' => $isFallingShort,
                ];

                if ($latest) {
                    $latestScores[] = [
                        'name'  => $student->last_name . ' ' . $student->first_name,
                        'total' => $latest['total'],
                    ];
                }
            }

            usort($studentsData, function ($a, $b) {
                if ($a['is_falling_short'] && !$b['is_falling_short']) return -1;
                if (!$a['is_falling_short'] && $b['is_falling_short']) return 1;
                return ($a['latest']['total'] ?? 0) <=> ($b['latest']['total'] ?? 0);
            });

            $allLatest = collect($studentsData)->pluck('latest.total')->filter();
            $summary = [
                'average'        => $allLatest->count() ? round($allLatest->avg(), 1) : null,
                'highest'        => $allLatest->count() ? $allLatest->max() : null,
                'lowest'         => $allLatest->count() ? $allLatest->min() : null,
                'needsAttention' => collect($studentsData)->where('is_falling_short', true)->count(),
                'totalStudents'  => count($studentsData),
            ];

            $grades = ['A1','B2','B3','C4','C5','C6','D7','E8','F9'];
            foreach ($grades as $g) {
                $gradeDistribution[$g] = collect($studentsData)
                    ->filter(fn($s) => ($s['latest']['grade'] ?? null) === $g)
                    ->count();
            }
        }
    }

    return compact(
        'selectedClassStream',
        'selectedSubject',
        'studentsData',
        'summary',
        'semesterLabels',
        'classAverages',
        'gradeDistribution',
        'latestScores'
    );
}
}