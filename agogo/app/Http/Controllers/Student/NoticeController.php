<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index()
    {
        $student = auth()->user();

        $notices = DashboardController::studentNoticesQuery($student)
            ->latest()
            ->paginate(12);

        return view('student.notices.index', compact('notices', 'student'));
    }

    public function show(Notice $notice)
    {
        $student = auth()->user();

        // Security: must be targeted at students
        if (!in_array('student', $notice->target_roles ?? [])) {
            abort(404);
        }

        // Class check
        $classes = $notice->target_classes ?? [];
        if (!empty($classes) && !in_array($student->class, $classes)) {
            abort(404);
        }

        // Programme check
        $programmes = $notice->target_programmes ?? [];
        if (!empty($programmes) && !in_array($student->programme, $programmes)) {
            abort(404);
        }

        return response()->json([
            'id'         => $notice->id,
            'title'      => $notice->title,
            'body'       => $notice->body,
            'created_at' => $notice->created_at->format('d M Y, h:i A'),
            'human_date' => $notice->created_at->diffForHumans(),
        ]);
    }
}