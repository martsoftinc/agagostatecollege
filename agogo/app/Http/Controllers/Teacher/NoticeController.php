<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * View All notices for teachers
     */
    public function index()
    {
        $notices = Notice::query()
            ->whereJsonContains('target_roles', 'teacher')
            ->latest()
            ->paginate(12);

        return view('teacher.notices.index', compact('notices'));
    }

    /**
     * Return a single notice (used by the modal via AJAX)
     */
    public function show(Notice $notice)
    {
        // Security: only allow notices targeted at teachers
        if (!in_array('teacher', $notice->target_roles ?? [])) {
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