<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Score;
use Illuminate\Support\Facades\Auth;

class PerformanceController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        // Get all scores with relationships
        $allScores = Score::with(['subject', 'semester.academicYear'])
            ->where('student_id', $student->id)
            ->whereNotNull('total_score')
            ->get();

        // Group by subject
        $subjectsData = [];

        foreach ($allScores->groupBy('subject_id') as $subjectId => $scores) {
            $subject = $scores->first()->subject;

            // Sort by academic year + semester number
            $sorted = $scores->sortBy(function ($score) {
                return ($score->semester->academicYear->name ?? '') . '-' . ($score->semester->number ?? 0);
            })->values();

            $history = [];
            foreach ($sorted as $score) {
                $history[] = [
                    'semester'     => $score->semester->name,
                    'year'         => $score->semester->academicYear->name ?? '',
                    'total'        => $score->total_score,
                    'grade'        => $score->grade,
                    'grade_point'  => $score->grade_point,
                    'label'        => ($score->semester->academicYear->name ?? '') . ' - ' . $score->semester->name,
                ];
            }

            // Calculate average
            $average = round($sorted->avg('total_score'), 1);
            $avgGradePoint = round($sorted->avg('grade_point'), 2);

            // Determine trend
            $trend = 'stable';
            $trendIcon = '→';
            $trendColor = 'text-slate-500';

            if (count($history) >= 2) {
                $latest = $history[count($history) - 1]['total'];
                $previous = $history[count($history) - 2]['total'];

                if ($latest > $previous + 2) {
                    $trend = 'improving';
                    $trendIcon = '↑';
                    $trendColor = 'text-emerald-600';
                } elseif ($latest < $previous - 2) {
                    $trend = 'declining';
                    $trendIcon = '↓';
                    $trendColor = 'text-rose-600';
                }
            }

            // Falling short?
            $latestGrade = $history[count($history) - 1]['grade'] ?? null;
            $isFallingShort = false;

            if (in_array($latestGrade, ['C6', 'D7', 'E8', 'F9'])) {
                $isFallingShort = true;
            }
            if ($trend === 'declining') {
                $isFallingShort = true;
            }

            $subjectsData[] = [
                'subject'         => $subject,
                'history'         => $history,
                'average'         => $average,
                'avg_grade_point' => $avgGradePoint,
                'trend'           => $trend,
                'trend_icon'      => $trendIcon,
                'trend_color'     => $trendColor,
                'is_falling_short'=> $isFallingShort,
                'latest_total'    => $history[count($history) - 1]['total'] ?? null,
                'latest_grade'    => $latestGrade,
            ];
        }

        // Sort subjects: Falling short first, then by average ascending
        usort($subjectsData, function ($a, $b) {
            if ($a['is_falling_short'] && !$b['is_falling_short']) return -1;
            if (!$a['is_falling_short'] && $b['is_falling_short']) return 1;
            return $a['average'] <=> $b['average'];
        });

        // Summary
        $strongest = collect($subjectsData)->sortByDesc('avg_grade_point')->first();
        $weakest   = collect($subjectsData)->sortBy('avg_grade_point')->first();
        $improving = collect($subjectsData)->where('trend', 'improving')->count();
        $declining = collect($subjectsData)->where('trend', 'declining')->count();
        $fallingShortCount = collect($subjectsData)->where('is_falling_short', true)->count();

        return view('student.performance.index', compact(
            'student',
            'subjectsData',
            'strongest',
            'weakest',
            'improving',
            'declining',
            'fallingShortCount'
        ));
    }
}