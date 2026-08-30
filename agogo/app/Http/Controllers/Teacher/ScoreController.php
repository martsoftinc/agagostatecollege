<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ClassStream;
use App\Models\Score;
use App\Models\Semester;
use App\Models\Subject;
use App\Models\AssessmentWeight;
use App\Models\User;
use App\Helpers\GradeHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ScoreController extends Controller
{
    /**
     * Show classes & subjects the logged-in teacher teaches
     */
    public function index()
    {
        $teacherId = Auth::id();
        $currentSemester = Semester::current();

        // Get all class_streams where this teacher is assigned to at least one subject
        $classStreams = ClassStream::whereHas('subjects', function ($q) use ($teacherId) {
                $q->where('class_stream_subject.teacher_id', $teacherId);
            })
            ->with(['schoolClass', 'stream', 'subjects' => function ($q) use ($teacherId) {
                $q->where('class_stream_subject.teacher_id', $teacherId);
            }])
            ->where('is_active', true)
            ->get();

        return view('teacher.scores.index', compact('classStreams', 'currentSemester'));
    }

    /**
     * Show score entry form for a specific class + subject + semester
     */
    public function enter(ClassStream $classStream, Subject $subject)
    {
        $teacherId = Auth::id();

        // Security: Make sure this teacher actually teaches this subject in this class
        $isAssigned = $classStream->subjects()
            ->where('subject_id', $subject->id)
            ->wherePivot('teacher_id', $teacherId)
            ->exists();

        if (!$isAssigned) {
            abort(403, 'You are not assigned to teach this subject in this class.');
        }

        $currentSemester = Semester::current();

        if (!$currentSemester) {
            return redirect()->route('teacher.scores.index')
                ->with('error', 'No current semester has been set by Admin.');
        }

        if ($currentSemester->is_locked) {
            return redirect()->route('teacher.scores.index')
                ->with('error', 'This semester is locked. Scores can no longer be edited.');
        }

        // Get students in this class
        $students = User::where('class_stream_id', $classStream->id)
            ->where('role', 'student')
            ->orderBy('name')
            ->get();

        // Get existing scores for these students
        $existingScores = Score::where('class_stream_id', $classStream->id)
            ->where('subject_id', $subject->id)
            ->where('semester_id', $currentSemester->id)
            ->get()
            ->keyBy('student_id');

        $weights = AssessmentWeight::active();

        return view('teacher.scores.enter', compact(
            'classStream',
            'subject',
            'students',
            'existingScores',
            'currentSemester',
            'weights'
        ));
    }

    /**
     * Save scores
     */
    public function store(Request $request, ClassStream $classStream, Subject $subject)
    {
        $teacherId = Auth::id();
        $currentSemester = Semester::current();

        // Security check again
        $isAssigned = $classStream->subjects()
            ->where('subject_id', $subject->id)
            ->wherePivot('teacher_id', $teacherId)
            ->exists();

        if (!$isAssigned || !$currentSemester || $currentSemester->is_locked) {
            abort(403);
        }

        $weights = AssessmentWeight::active();

        if (!$weights) {
            return redirect()->back()->with('error', 'Assessment weights have not been set by Admin.');
        }

        $scoresData = $request->input('scores', []);

        DB::transaction(function () use ($scoresData, $classStream, $subject, $currentSemester, $weights) {
            foreach ($scoresData as $studentId => $data) {
                $classwork = $data['classwork'] ?? null;
                $midsem    = $data['midsem'] ?? null;
                $exam      = $data['exam'] ?? null;
                $comment   = $data['comment'] ?? null;
                $attendance = $data['attendance'] ?? null;

                // Only calculate if at least one score is entered
                $total = null;
                $grade = null;
                $point = null;

                if ($classwork !== null || $midsem !== null || $exam !== null) {
                    $cw = (float) ($classwork ?? 0);
                    $ms = (float) ($midsem ?? 0);
                    $ex = (float) ($exam ?? 0);

                    $total = (
                        ($cw * $weights->classwork_percent / 100) +
                        ($ms * $weights->midsem_percent / 100) +
                        ($ex * $weights->exam_percent / 100)
                    );

                    $total = round($total, 2);
                    $gradeInfo = \App\Helpers\GradeHelper::calculate($total);
                    $grade = $gradeInfo['grade'];
                    $point = $gradeInfo['point'];
                }

                Score::updateOrCreate(
                    [
                        'student_id'      => $studentId,
                        'subject_id'      => $subject->id,
                        'semester_id'     => $currentSemester->id,
                    ],
                    [
                        'class_stream_id'  => $classStream->id,
                        'classwork_score'  => $classwork,
                        'midsem_score'     => $midsem,
                        'exam_score'       => $exam,
                        'total_score'      => $total,
                        'grade'            => $grade,
                        'grade_point'      => $point,
                        'teacher_comment'  => $comment,
                        'attendance'       => $attendance,
                    ]
                );
            }
        });

        return redirect()->back()->with('success', 'Scores saved successfully!');
    }
}