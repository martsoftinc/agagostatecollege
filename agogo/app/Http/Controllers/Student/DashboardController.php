<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $student = auth()->user();

        $notices = $this->studentNoticesQuery($student)
            ->latest()
            ->take(5)
            ->get();

        return view('student.index', [
            'student' => $student,
            'notices' => $notices,
        ]);
    }

    /**
     * Shared query: notices visible to this student
     */
    public static function studentNoticesQuery($student)
    {
        return Notice::query()
            ->whereJsonContains('target_roles', 'student')
            ->where(function ($q) use ($student) {
                // Class filter (empty = all classes)
                $q->where(function ($q2) use ($student) {
                    $q2->whereNull('target_classes')
                       ->orWhereJsonLength('target_classes', 0)
                       ->orWhereJsonContains('target_classes', $student->class);
                });
            })
            ->where(function ($q) use ($student) {
                // Programme filter (empty = all programmes)
                $q->where(function ($q2) use ($student) {
                    $q2->whereNull('target_programmes')
                       ->orWhereJsonLength('target_programmes', 0)
                       ->orWhereJsonContains('target_programmes', $student->programme);
                });
            });
    }
}