<?php

namespace App\Http\Controllers;

use App\Models\LessonPlan;
use App\Models\LessonPlanResource;
use App\Models\LessonPlanAttachment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;


class LessonPlanController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request): View
    {
        $user = $request->user();

        $lessonPlans = LessonPlan::with('author')
            ->accessibleBy($user->id)
            ->latest()
            ->paginate(15);

        return view('lesson-plans.index', compact('lessonPlans'));
    }





    public function create(): View
    {
        return view('lesson-plans.create');
    }

        public function store(Request $request): RedirectResponse
        {
            $validated = $this->validateLessonPlan($request);

            // Remove relationship / file fields before creating the lesson plan
            $lessonPlanData = collect($validated)->except([
                'resources',
                'attachments',
                'delete_attachments',
            ])->toArray();

            $lessonPlan = $request->user()->lessonPlans()->create($lessonPlanData);

            // Save external resources
            $this->syncResources($lessonPlan, $request->input('resources', []));

            // Save file attachments
            $this->storeAttachments($lessonPlan, $request->file('attachments', []));

            return redirect()->route('lesson-plans.show', $lessonPlan)
                ->with('success', 'Lesson plan created successfully.');
        }





    public function show(LessonPlan $lessonPlan): View
    {
        $this->authorize('view', $lessonPlan);

        $lessonPlan->load(['author', 'sharedWithUsers', 'resources', 'attachments']);

        $availableTeachers = auth()->id() === $lessonPlan->user_id
            ? User::where('id', '!=', auth()->id())->select('id', 'name', 'email')->get()
            : collect();

        return view('lesson-plans.show', compact('lessonPlan', 'availableTeachers'));
    }

    public function edit(LessonPlan $lessonPlan): View
    {
        $this->authorize('update', $lessonPlan);

        $lessonPlan->load(['resources', 'attachments']);

        return view('lesson-plans.edit', compact('lessonPlan'));
    }





    public function update(Request $request, LessonPlan $lessonPlan): RedirectResponse
    {
        $this->authorize('update', $lessonPlan);

        $validated = $this->validateLessonPlan($request);

        // Remove relationship / file fields before updating
        $lessonPlanData = collect($validated)->except([
            'resources',
            'attachments',
            'delete_attachments',
        ])->toArray();

        $lessonPlan->update($lessonPlanData);

        // Sync external resources
        $this->syncResources($lessonPlan, $request->input('resources', []));

        // Delete selected attachments
        if ($request->filled('delete_attachments')) {
            $this->deleteAttachments($lessonPlan, $request->input('delete_attachments', []));
        }

        // Upload new attachments
        $this->storeAttachments($lessonPlan, $request->file('attachments', []));

        return redirect()->route('lesson-plans.show', $lessonPlan)
            ->with('success', 'Lesson plan updated successfully.');
    }








    public function destroy(LessonPlan $lessonPlan): RedirectResponse
    {
        $this->authorize('delete', $lessonPlan);

        // Delete physical files
        foreach ($lessonPlan->attachments as $attachment) {
            Storage::disk($attachment->disk)->delete($attachment->file_path);
        }

        $lessonPlan->delete();

        return redirect()->route('lesson-plans.index')
            ->with('success', 'Lesson plan deleted successfully.');
    }



    

        public function share(Request $request, LessonPlan $lessonPlan): RedirectResponse
        {
            if ($request->user()->id !== $lessonPlan->user_id) {
                abort(403, 'Only the author can share this lesson plan.');
            }

            $validated = $request->validate([
                'users' => 'nullable|array',
                'users.*.user_id' => 'required|exists:users,id',
                'users.*.permission' => 'required|in:view,edit',
            ]);

            $syncData = [];

            if (!empty($validated['users'])) {
                foreach ($validated['users'] as $entry) {
                    // Only keep entries that were actually checked
                    if (!empty($entry['user_id'])) {
                        $syncData[$entry['user_id']] = [
                            'permission' => $entry['permission'] ?? 'view',
                        ];
                    }
                }
            }

            $lessonPlan->sharedWithUsers()->sync($syncData);

            return back()->with('success', 'Sharing permissions updated successfully.');
        }
    // ────────────────────────────────────────────────
    // Private helpers
    // ────────────────────────────────────────────────

    private function validateLessonPlan(Request $request): array
    {
        return $request->validate([
            'school_name' => 'nullable|string|max:255',
            'subject' => 'required|string|max:255',
            'class_form' => 'required|string|max:100',
            'lesson_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'duration_minutes' => 'required|integer|min:1',
            'class_size' => 'nullable|integer|min:1',
            'unit_topic' => 'required|string|max:255',
            'sub_topic' => 'nullable|string|max:255',

            'content_standard' => 'nullable|string',
            'indicator_code_or_text' => 'nullable|string|max:255',
            'performance_indicators' => 'required|array|min:1',
            'performance_indicators.*' => 'required|string',
            'core_competencies' => 'nullable|array',
            'key_vocabulary' => 'nullable|array',
            'teaching_learning_resources' => 'nullable|string',

            'phase_1_introduction' => 'required|array',
            'phase_1_introduction.duration' => 'required|integer',
            'phase_1_introduction.teacher_activity' => 'required|string',
            'phase_1_introduction.student_activity' => 'required|string',
            'phase_1_introduction.assessment' => 'required|string',

            'phase_2_main_body' => 'required|array|min:1',
            'phase_2_main_body.*.step' => 'required|integer',
            'phase_2_main_body.*.teacher_activity' => 'required|string',
            'phase_2_main_body.*.student_activity' => 'required|string',
            'phase_2_main_body.*.assessment' => 'required|string',

            'phase_3_closure' => 'required|array',
            'phase_3_closure.duration' => 'required|integer',
            'phase_3_closure.teacher_activity' => 'required|string',
            'phase_3_closure.student_activity' => 'required|string',
            'phase_3_closure.assessment' => 'required|string',

            'evaluative_exercise' => 'nullable|string',
            'reflection_strengths' => 'nullable|string',
            'reflection_weaknesses' => 'nullable|string',
            'reflection_remedial_action' => 'nullable|string',
            'visibility' => 'required|in:private,public',

            // Resources
            'resources' => 'nullable|array',
            'resources.*.title' => 'required_with:resources.*.url|string|max:255',
            'resources.*.url' => 'required_with:resources.*.title|url|max:500',
            'resources.*.type' => 'nullable|in:youtube,google_drive,website,document,other',
            'resources.*.description' => 'nullable|string|max:500',

            // Attachments (PDF + images only)
            'attachments' => 'nullable|array',
            'attachments.*' => 'file|mimes:pdf,jpg,jpeg,png,webp,gif|max:10240', // 10MB
            'delete_attachments' => 'nullable|array',
            'delete_attachments.*' => 'integer|exists:lesson_plan_attachments,id',
        ]);
    }

    private function syncResources(LessonPlan $lessonPlan, array $resources): void
    {
        // Delete existing resources and recreate (simple & reliable)
        $lessonPlan->resources()->delete();

        foreach ($resources as $index => $resource) {
            if (empty($resource['title']) || empty($resource['url'])) {
                continue;
            }

            $lessonPlan->resources()->create([
                'title' => $resource['title'],
                'url' => $resource['url'],
                'type' => $resource['type'] ?? 'other',
                'description' => $resource['description'] ?? null,
                'sort_order' => $index,
            ]);
        }
    }

    private function storeAttachments(LessonPlan $lessonPlan, array $files): void
    {
        foreach ($files as $index => $file) {
            if (!$file || !$file->isValid()) {
                continue;
            }

            $path = $file->store('lesson-plans/attachments/' . $lessonPlan->id, 'public');

            $lessonPlan->attachments()->create([
                'original_name' => $file->getClientOriginalName(),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'extension' => strtolower($file->getClientOriginalExtension()),
                'file_size' => $file->getSize(),
                'disk' => 'public',
                'sort_order' => $index,
            ]);
        }
    }

    private function deleteAttachments(LessonPlan $lessonPlan, array $ids): void
    {
        $attachments = $lessonPlan->attachments()->whereIn('id', $ids)->get();

        foreach ($attachments as $attachment) {
            Storage::disk($attachment->disk)->delete($attachment->file_path);
            $attachment->delete();
        }
    }

    public function downloadPdf(LessonPlan $lessonPlan)
    {
        $this->authorize('view', $lessonPlan);

        $lessonPlan->load(['author', 'resources', 'attachments']);

        $pdf = Pdf::loadView('lesson-plans.pdf', compact('lessonPlan'))
                ->setPaper('a4', 'portrait');

        $filename = Str::slug($lessonPlan->unit_topic) . '-lesson-plan.pdf';

        return $pdf->download($filename);
    }   

}