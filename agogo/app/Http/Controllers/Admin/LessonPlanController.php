<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LessonPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class LessonPlanController extends Controller
{
    /**
     * List all lesson plans with search + filters
     */
    public function index(Request $request): View
    {
        $query = LessonPlan::with('author')->latest();

        // Search (topic, subject, sub-topic, school)
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('unit_topic', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('sub_topic', 'like', "%{$search}%")
                  ->orWhere('school_name', 'like', "%{$search}%")
                  ->orWhere('class_form', 'like', "%{$search}%");
            });
        }

        // Filter by teacher
        if ($teacherId = $request->input('teacher_id')) {
            $query->where('user_id', $teacherId);
        }

        // Filter by date (exact day)
        if ($date = $request->input('date')) {
            $query->whereDate('lesson_date', $date);
        }

        // Optional date range
        if ($from = $request->input('date_from')) {
            $query->whereDate('lesson_date', '>=', $from);
        }
        if ($to = $request->input('date_to')) {
            $query->whereDate('lesson_date', '<=', $to);
        }

        $lessonPlans = $query->paginate(20)->withQueryString();

        // Teachers for the filter dropdown
        $teachers = User::whereHas('lessonPlans')
            ->orderBy('name')
            ->get(['id', 'name']);

        return view('admin.lesson-plans.index', compact('lessonPlans', 'teachers'));
    }

    /**
     * View a single lesson plan
     */
    public function show(LessonPlan $lessonPlan): View
    {
        $lessonPlan->load(['author', 'resources', 'attachments', 'sharedWithUsers']);

        return view('admin.lesson-plans.show', compact('lessonPlan'));
    }

    /**
     * Download as PDF
     */
    public function downloadPdf(LessonPlan $lessonPlan)
    {
        $lessonPlan->load(['author', 'resources', 'attachments']);

        $pdf = Pdf::loadView('lesson-plans.pdf', compact('lessonPlan'))
                  ->setPaper('a4', 'portrait');

        $filename = Str::slug($lessonPlan->unit_topic) . '-lesson-plan.pdf';

        return $pdf->download($filename);
    }
}