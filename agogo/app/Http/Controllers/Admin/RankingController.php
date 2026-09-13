<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use App\Models\ClassStream;
use App\Models\SchoolClass;
use App\Models\Score;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $semesters = Semester::with('academicYear')->orderByDesc('id')->get();

        $schoolClasses = SchoolClass::orderBy('level_order')->get();

        $classStreams = ClassStream::with(['schoolClass', 'stream'])
            ->where('is_active', true)
            ->get()
            ->sortBy(fn ($cs) => $cs->schoolClass->name . ' ' . $cs->stream->name);

        $selectedSemesterId   = $request->get('semester_id');
        $selectedSchoolClassId = $request->get('school_class_id');
        $selectedClassStreamId = $request->get('class_stream_id');

        $rankings = collect();
        $selectedSemester = null;
        $selectedSchoolClass = null;
        $selectedClassStream = null;
        $rankingTitle = null;

        if ($selectedSemesterId) {
            $selectedSemester = Semester::with('academicYear')->find($selectedSemesterId);

            // === OVERALL FORM RANKING (SHS 1, SHS 2, SHS 3...) ===
            if ($selectedSchoolClassId && !$selectedClassStreamId) {
                $selectedSchoolClass = SchoolClass::find($selectedSchoolClassId);
                $rankingTitle = $selectedSchoolClass->name . ' (Entire Form)';

                $rankings = $this->getFormRankings($selectedSemesterId, $selectedSchoolClassId);
            }
            // === SPECIFIC STREAM RANKING ===
            elseif ($selectedClassStreamId) {
                $selectedClassStream = ClassStream::with(['schoolClass', 'stream'])
                    ->find($selectedClassStreamId);

                $rankingTitle = $selectedClassStream->schoolClass->name . ' ' . $selectedClassStream->stream->name;

                $rankings = $this->getStreamRankings($selectedSemesterId, $selectedClassStreamId);
            }
        }

        return view('admin.rankings.index', compact(
            'semesters',
            'schoolClasses',
            'classStreams',
            'selectedSemesterId',
            'selectedSchoolClassId',
            'selectedClassStreamId',
            'selectedSemester',
            'selectedSchoolClass',
            'selectedClassStream',
            'rankings',
            'rankingTitle'
        ));
    }

    public function export(Request $request)
    {
        $request->validate([
            'semester_id' => 'required|exists:semesters,id',
        ]);

        $semester = Semester::with('academicYear')->findOrFail($request->semester_id);

        $schoolClassId = $request->get('school_class_id');
        $classStreamId = $request->get('class_stream_id');

        if ($schoolClassId && !$classStreamId) {
            // Overall Form
            $schoolClass = SchoolClass::findOrFail($schoolClassId);
            $rankings = $this->getFormRankings($request->semester_id, $schoolClassId);
            $title = $schoolClass->name . ' (Entire Form)';
            $filename = 'Form_Ranking_' . str_replace(' ', '_', $schoolClass->name) . '_' .
                        str_replace(' ', '_', $semester->name) . '.pdf';
        } elseif ($classStreamId) {
            // Specific Stream
            $classStream = ClassStream::with(['schoolClass', 'stream'])->findOrFail($classStreamId);
            $rankings = $this->getStreamRankings($request->semester_id, $classStreamId);
            $title = $classStream->schoolClass->name . ' ' . $classStream->stream->name;
            $filename = 'Class_Ranking_' . str_replace(' ', '_', $title) . '_' .
                        str_replace(' ', '_', $semester->name) . '.pdf';
        } else {
            return redirect()->back()->with('error', 'Please select a Form or Class Stream.');
        }

        $pdf = Pdf::loadView('admin.rankings.pdf', compact(
            'semester', 'rankings', 'title'
        ))->setPaper('a4', 'portrait');

        return $pdf->download($filename);
    }

    /**
     * Ranking for a specific Class Stream
     */
    private function getStreamRankings($semesterId, $classStreamId)
    {
        $students = User::where('class_stream_id', $classStreamId)
            ->where('role', 'student')
            ->get();

        return $this->buildRankings($students, $semesterId);
    }

    /**
     * Ranking for entire Form (e.g. all of SHS 1)
     */
    private function getFormRankings($semesterId, $schoolClassId)
    {
        // Get all class_stream_ids that belong to this SchoolClass
        $classStreamIds = ClassStream::where('school_class_id', $schoolClassId)
            ->where('is_active', true)
            ->pluck('id');

        $students = User::whereIn('class_stream_id', $classStreamIds)
            ->where('role', 'student')
            ->get();

        return $this->buildRankings($students, $semesterId);
    }

    /**
     * Shared ranking logic (by total raw score)
     */
    private function buildRankings($students, $semesterId)
    {
        $totals = [];

        foreach ($students as $student) {
            $totalRawScore = Score::where('student_id', $student->id)
                ->where('semester_id', $semesterId)
                ->whereNotNull('total_score')
                ->sum('total_score');

            $subjectCount = Score::where('student_id', $student->id)
                ->where('semester_id', $semesterId)
                ->whereNotNull('total_score')
                ->count();

            if ($subjectCount > 0) {
                $totals[] = [
                    'student'       => $student,
                    'total_score'   => round($totalRawScore, 2),
                    'subject_count' => $subjectCount,
                    'class_stream'  => $student->classStream, // useful for form ranking
                ];
            }
        }

        // Sort by total score descending
        usort($totals, fn ($a, $b) => $b['total_score'] <=> $a['total_score']);

        // Assign ranks (handle ties)
        $rank = 1;
        $previousScore = null;
        $position = 1;

        foreach ($totals as &$row) {
            if ($previousScore !== null && $row['total_score'] < $previousScore) {
                $rank = $position;
            }
            $row['rank'] = $rank;
            $previousScore = $row['total_score'];
            $position++;
        }

        return collect($totals);
    }
}