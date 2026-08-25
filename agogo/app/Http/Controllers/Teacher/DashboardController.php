<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $teacher = auth()->user();

        // Latest notices meant for teachers (show 5 on dashboard)
        $notices = Notice::query()
            ->whereJsonContains('target_roles', 'teacher')
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.index', [   // change to your actual view path if different
            'teacherName' => $teacher->name,
            'notices'     => $notices,
        ]);
    }
}