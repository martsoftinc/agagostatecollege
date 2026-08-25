@extends('teacher.layout')

@section('title', 'Edit Lesson Plan - ' . $lessonPlan->unit_topic)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
  <!-- Header -->
  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Edit Lesson Plan</h1>
      <p class="text-xs sm:text-sm text-slate-500">{{ $lessonPlan->unit_topic }}</p>
    </div>
    <a href="{{ route('lesson-plans.show', $lessonPlan) }}" class="text-slate-500 hover:text-slate-800 text-sm font-semibold flex items-center space-x-1">
      <i class="fa-solid fa-arrow-left"></i>
      <span>Back</span>
    </a>
  </div>

  @if ($errors->any())
    <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm space-y-1">
      <p class="font-bold">Please correct the following errors:</p>
      <ul class="list-disc list-inside text-xs">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form action="{{ route('lesson-plans.update', $lessonPlan) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @method('PUT')

    <!-- SECTION 1: BASIC INFORMATION -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
      <h2 class="text-base font-bold text-asc-green border-b border-slate-100 pb-2 flex items-center space-x-2">
        <i class="fa-solid fa-circle-info"></i>
        <span>1. Basic Information</span>
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">School Name</label>
          <input type="text" name="school_name" value="{{ old('school_name', $lessonPlan->school_name) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Subject *</label>
          <input type="text" name="subject" value="{{ old('subject', $lessonPlan->subject) }}" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Class / Form *</label>
          <input type="text" name="class_form" value="{{ old('class_form', $lessonPlan->class_form) }}" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Date *</label>
          <input type="date" name="lesson_date" value="{{ old('lesson_date', $lessonPlan->lesson_date?->format('Y-m-d')) }}" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Start Time</label>
          <input type="time" name="start_time" value="{{ old('start_time', $lessonPlan->start_time ? \Carbon\Carbon::parse($lessonPlan->start_time)->format('H:i') : '') }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">End Time</label>
          <input type="time" name="end_time" value="{{ old('end_time', $lessonPlan->end_time ? \Carbon\Carbon::parse($lessonPlan->end_time)->format('H:i') : '') }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Duration (Mins) *</label>
          <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $lessonPlan->duration_minutes) }}" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Class Size</label>
          <input type="number" name="class_size" value="{{ old('class_size', $lessonPlan->class_size) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Unit / Topic *</label>
          <input type="text" name="unit_topic" value="{{ old('unit_topic', $lessonPlan->unit_topic) }}" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div class="md:col-span-3">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Sub-Topic</label>
          <input type="text" name="sub_topic" value="{{ old('sub_topic', $lessonPlan->sub_topic) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
      </div>
    </div>

    <!-- SECTION 2: CURRICULUM -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
      <h2 class="text-base font-bold text-asc-green border-b border-slate-100 pb-2 flex items-center space-x-2">
        <i class="fa-solid fa-graduation-cap"></i>
        <span>2. Curriculum & Instructional Objectives</span>
      </h2>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Content Standard</label>
          <textarea name="content_standard" rows="2" class="w-full rounded-xl border border-slate-300 p-3 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">{{ old('content_standard', $lessonPlan->content_standard) }}</textarea>
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Indicator Code / Text</label>
          <textarea name="indicator_code_or_text" rows="2" class="w-full rounded-xl border border-slate-300 p-3 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">{{ old('indicator_code_or_text', $lessonPlan->indicator_code_or_text) }}</textarea>
        </div>
      </div>

      <div>
        <div class="flex items-center justify-between mb-2">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600">Performance Indicators *</label>
          <button type="button" onclick="addPerformanceIndicator()" class="text-xs font-bold text-asc-green hover:underline">
            <i class="fa-solid fa-plus"></i> Add Objective
          </button>
        </div>
        <div id="indicatorsContainer" class="space-y-2">
          @php $indicators = old('performance_indicators', $lessonPlan->performance_indicators ?? []); @endphp
          @foreach($indicators as $indicator)
            <div class="flex items-center space-x-2">
              <input type="text" name="performance_indicators[]" value="{{ $indicator }}" required class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
              <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 px-2"><i class="fa-solid fa-trash"></i></button>
            </div>
          @endforeach
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Core Competencies (Comma-separated)</label>
          <input type="text" id="core_competencies_input" value="{{ old('core_competencies') ? implode(', ', old('core_competencies')) : implode(', ', $lessonPlan->core_competencies ?? []) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
          <div id="core_competencies_hidden"></div>
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Key Vocabulary (Comma-separated)</label>
          <input type="text" id="key_vocabulary_input" value="{{ old('key_vocabulary') ? implode(', ', old('key_vocabulary')) : implode(', ', $lessonPlan->key_vocabulary ?? []) }}" class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
          <div id="key_vocabulary_hidden"></div>
        </div>
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Teaching & Learning Resources (TLMs)</label>
        <textarea name="teaching_learning_resources" rows="2" class="w-full rounded-xl border border-slate-300 p-3 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">{{ old('teaching_learning_resources', $lessonPlan->teaching_learning_resources) }}</textarea>
      </div>
    </div>

    <!-- SECTION 3: PHASED DELIVERY -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-6">
      <h2 class="text-base font-bold text-asc-green border-b border-slate-100 pb-2 flex items-center space-x-2">
        <i class="fa-solid fa-layer-group"></i>
        <span>3. Phased Instructional Delivery</span>
      </h2>

      @php $p1 = old('phase_1_introduction', $lessonPlan->phase_1_introduction ?? []); @endphp
      <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
        <div class="flex items-center justify-between">
          <h3 class="text-sm font-extrabold text-slate-800 uppercase">Phase 1: Introduction</h3>
          <div class="flex items-center space-x-2">
            <span class="text-xs font-bold text-slate-500">Duration (Mins):</span>
            <input type="number" name="phase_1_introduction[duration]" value="{{ $p1['duration'] ?? 10 }}" required class="w-16 rounded-lg border border-slate-300 px-2 py-1 text-xs text-center focus:ring-2 focus:ring-asc-green focus:outline-none">
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <div>
            <label class="block text-[11px] font-bold text-slate-600 mb-1">Teacher Activity *</label>
            <textarea name="phase_1_introduction[teacher_activity]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none">{{ $p1['teacher_activity'] ?? '' }}</textarea>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-slate-600 mb-1">Student Activity *</label>
            <textarea name="phase_1_introduction[student_activity]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none">{{ $p1['student_activity'] ?? '' }}</textarea>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-slate-600 mb-1">Assessment *</label>
            <textarea name="phase_1_introduction[assessment]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none">{{ $p1['assessment'] ?? '' }}</textarea>
          </div>
        </div>
      </div>

      @php $p2 = old('phase_2_main_body', $lessonPlan->phase_2_main_body ?? [['step' => 1]]); @endphp
      <div class="space-y-3">
        <div class="flex items-center justify-between">
          <h3 class="text-sm font-extrabold text-slate-800 uppercase">Phase 2: Main Body</h3>
          <button type="button" onclick="addMainBodyStep()" class="text-xs font-bold text-asc-green hover:underline">
            <i class="fa-solid fa-plus"></i> Add Step
          </button>
        </div>
        <div id="mainBodyStepsContainer" class="space-y-3">
          @foreach($p2 as $idx => $step)
            <div class="step-card p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
              <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                <span class="text-xs font-bold text-slate-700 uppercase step-title">Step {{ $idx + 1 }}</span>
                <input type="hidden" name="phase_2_main_body[{{ $idx }}][step]" value="{{ $idx + 1 }}">
                @if($idx > 0)
                  <button type="button" onclick="this.closest('.step-card').remove(); reindexSteps();" class="text-rose-500 hover:text-rose-700 text-xs font-bold">Remove</button>
                @endif
              </div>
              <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                <div>
                  <label class="block text-[11px] font-bold text-slate-600 mb-1">Teacher Activity *</label>
                  <textarea name="phase_2_main_body[{{ $idx }}][teacher_activity]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none">{{ $step['teacher_activity'] ?? '' }}</textarea>
                </div>
                <div>
                  <label class="block text-[11px] font-bold text-slate-600 mb-1">Student Activity *</label>
                  <textarea name="phase_2_main_body[{{ $idx }}][student_activity]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none">{{ $step['student_activity'] ?? '' }}</textarea>
                </div>
                <div>
                  <label class="block text-[11px] font-bold text-slate-600 mb-1">Assessment *</label>
                  <textarea name="phase_2_main_body[{{ $idx }}][assessment]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none">{{ $step['assessment'] ?? '' }}</textarea>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>

      @php $p3 = old('phase_3_closure', $lessonPlan->phase_3_closure ?? []); @endphp
      <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
        <div class="flex items-center justify-between">
          <h3 class="text-sm font-extrabold text-slate-800 uppercase">Phase 3: Closure / Plenary</h3>
          <div class="flex items-center space-x-2">
            <span class="text-xs font-bold text-slate-500">Duration (Mins):</span>
            <input type="number" name="phase_3_closure[duration]" value="{{ $p3['duration'] ?? 10 }}" required class="w-16 rounded-lg border border-slate-300 px-2 py-1 text-xs text-center focus:ring-2 focus:ring-asc-green focus:outline-none">
          </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
          <div>
            <label class="block text-[11px] font-bold text-slate-600 mb-1">Teacher Activity *</label>
            <textarea name="phase_3_closure[teacher_activity]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none">{{ $p3['teacher_activity'] ?? '' }}</textarea>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-slate-600 mb-1">Student Activity *</label>
            <textarea name="phase_3_closure[student_activity]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none">{{ $p3['student_activity'] ?? '' }}</textarea>
          </div>
          <div>
            <label class="block text-[11px] font-bold text-slate-600 mb-1">Assessment *</label>
            <textarea name="phase_3_closure[assessment]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none">{{ $p3['assessment'] ?? '' }}</textarea>
          </div>
        </div>
      </div>
    </div>

    <!-- SECTION 4: ASSESSMENT & REFLECTION -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
      <h2 class="text-base font-bold text-asc-green border-b border-slate-100 pb-2 flex items-center space-x-2">
        <i class="fa-solid fa-clipboard-check"></i>
        <span>4. Assessment & Post-Lesson Reflection</span>
      </h2>
      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Evaluative Exercise / Homework</label>
        <textarea name="evaluative_exercise" rows="2" class="w-full rounded-xl border border-slate-300 p-3 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">{{ old('evaluative_exercise', $lessonPlan->evaluative_exercise) }}</textarea>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Strengths</label>
          <textarea name="reflection_strengths" rows="2" class="w-full rounded-xl border border-slate-300 p-3 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">{{ old('reflection_strengths', $lessonPlan->reflection_strengths) }}</textarea>
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Weaknesses / Challenges</label>
          <textarea name="reflection_weaknesses" rows="2" class="w-full rounded-xl border border-slate-300 p-3 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">{{ old('reflection_weaknesses', $lessonPlan->reflection_weaknesses) }}</textarea>
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Remedial Action</label>
          <textarea name="reflection_remedial_action" rows="2" class="w-full rounded-xl border border-slate-300 p-3 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">{{ old('reflection_remedial_action', $lessonPlan->reflection_remedial_action) }}</textarea>
        </div>
      </div>
    </div>

    <!-- SECTION 5: EXTERNAL RESOURCES -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
      <div class="flex items-center justify-between border-b border-slate-100 pb-2">
        <h2 class="text-base font-bold text-asc-green flex items-center space-x-2">
          <i class="fa-solid fa-link"></i>
          <span>5. External Resources</span>
        </h2>
        <button type="button" onclick="addResource()" class="text-xs font-bold text-asc-green hover:underline">
          <i class="fa-solid fa-plus"></i> Add Resource
        </button>
      </div>
      <div id="resourcesContainer" class="space-y-3">
        @php $resources = old('resources', $lessonPlan->resources->toArray()); @endphp
        @foreach($resources as $idx => $res)
          <div class="resource-row p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3">
            <div class="flex items-center justify-between">
              <span class="text-xs font-bold text-slate-600 uppercase">Resource #{{ $idx + 1 }}</span>
              <button type="button" onclick="this.closest('.resource-row').remove()" class="text-rose-500 hover:text-rose-700 text-xs font-bold">
                <i class="fa-solid fa-trash"></i> Remove
              </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
              <div>
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Title *</label>
                <input type="text" name="resources[{{ $idx }}][title]" value="{{ $res['title'] ?? '' }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
              </div>
              <div>
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Type</label>
                <select name="resources[{{ $idx }}][type]" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
                  <option value="youtube" {{ ($res['type'] ?? '') === 'youtube' ? 'selected' : '' }}>YouTube</option>
                  <option value="google_drive" {{ ($res['type'] ?? '') === 'google_drive' ? 'selected' : '' }}>Google Drive</option>
                  <option value="website" {{ ($res['type'] ?? '') === 'website' ? 'selected' : '' }}>Website</option>
                  <option value="document" {{ ($res['type'] ?? '') === 'document' ? 'selected' : '' }}>Document</option>
                  <option value="other" {{ ($res['type'] ?? 'other') === 'other' ? 'selected' : '' }}>Other</option>
                </select>
              </div>
              <div class="md:col-span-2">
                <label class="block text-[11px] font-bold text-slate-600 mb-1">URL *</label>
                <input type="url" name="resources[{{ $idx }}][url]" value="{{ $res['url'] ?? '' }}" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
              </div>
              <div class="md:col-span-2">
                <label class="block text-[11px] font-bold text-slate-600 mb-1">Description</label>
                <input type="text" name="resources[{{ $idx }}][description]" value="{{ $res['description'] ?? '' }}" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </div>

    <!-- SECTION 6: ATTACHMENTS -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
      <h2 class="text-base font-bold text-asc-green border-b border-slate-100 pb-2 flex items-center space-x-2">
        <i class="fa-solid fa-paperclip"></i>
        <span>6. File Attachments</span>
      </h2>

      @if($lessonPlan->attachments->count() > 0)
        <div class="space-y-2 mb-4">
          <p class="text-xs font-bold text-slate-500 uppercase">Current Attachments</p>
          @foreach($lessonPlan->attachments as $file)
            <label class="flex items-center justify-between p-3 rounded-xl border border-slate-200 hover:bg-slate-50 cursor-pointer">
              <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $file->extension === 'pdf' ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }}">
                  <i class="fa-solid {{ $file->extension === 'pdf' ? 'fa-file-pdf' : 'fa-image' }}"></i>
                </div>
                <div>
                  <div class="text-sm font-semibold text-slate-800">{{ $file->original_name }}</div>
                  <div class="text-[11px] text-slate-400">{{ strtoupper($file->extension) }} • {{ number_format($file->file_size / 1024, 1) }} KB</div>
                </div>
              </div>
              <div class="flex items-center space-x-3">
                <a href="{{ Storage::disk($file->disk)->url($file->file_path) }}" target="_blank" class="text-xs text-asc-green hover:underline">View</a>
                <label class="flex items-center space-x-1 text-xs text-rose-600 cursor-pointer">
                  <input type="checkbox" name="delete_attachments[]" value="{{ $file->id }}" class="rounded text-rose-600 focus:ring-rose-500">
                  <span>Delete</span>
                </label>
              </div>
            </label>
          @endforeach
        </div>
      @endif

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1">Upload New Files (PDF / Images)</label>
        <input type="file" name="attachments[]" multiple accept=".pdf,.jpg,.jpeg,.png,.webp,.gif" class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-asc-green file:text-white hover:file:bg-asc-green-dark">
      </div>
    </div>

    <!-- SECTION 7: VISIBILITY -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
      <h2 class="text-base font-bold text-asc-green border-b border-slate-100 pb-2 flex items-center space-x-2">
        <i class="fa-solid fa-lock"></i>
        <span>7. Access Control</span>
      </h2>
      <div class="flex items-center space-x-6">
        <label class="flex items-center space-x-2 cursor-pointer">
          <input type="radio" name="visibility" value="private" {{ old('visibility', $lessonPlan->visibility) === 'private' ? 'checked' : '' }} class="text-asc-green focus:ring-asc-green">
          <span class="text-sm font-semibold text-slate-700">Private</span>
        </label>
        <label class="flex items-center space-x-2 cursor-pointer">
          <input type="radio" name="visibility" value="public" {{ old('visibility', $lessonPlan->visibility) === 'public' ? 'checked' : '' }} class="text-asc-green focus:ring-asc-green">
          <span class="text-sm font-semibold text-slate-700">Public</span>
        </label>
      </div>
    </div>

    <!-- Actions -->
    <div class="flex justify-end space-x-3">
      <a href="{{ route('lesson-plans.show', $lessonPlan) }}" class="px-5 py-2.5 rounded-xl border border-slate-300 font-semibold text-sm text-slate-600 hover:bg-slate-100 transition">Cancel</a>
      <button type="submit" class="px-6 py-2.5 rounded-xl bg-asc-green hover:bg-asc-green-dark text-white font-semibold text-sm shadow transition">
        Update Lesson Plan
      </button>
    </div>
  </form>
</div>

@push('scripts')
<script>
  function addPerformanceIndicator() {
    const container = document.getElementById('indicatorsContainer');
    const div = document.createElement('div');
    div.className = 'flex items-center space-x-2';
    div.innerHTML = `
      <input type="text" name="performance_indicators[]" required placeholder="Objective..." class="w-full rounded-xl border border-slate-300 px-3.5 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
      <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 px-2"><i class="fa-solid fa-trash"></i></button>
    `;
    container.appendChild(div);
  }

  let stepIndex = {{ count(old('phase_2_main_body', $lessonPlan->phase_2_main_body ?? [['step'=>1]])) }};
  function addMainBodyStep() {
    const container = document.getElementById('mainBodyStepsContainer');
    const div = document.createElement('div');
    div.className = 'step-card p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3';
    div.innerHTML = `
      <div class="flex items-center justify-between border-b border-slate-200 pb-2">
        <span class="text-xs font-bold text-slate-700 uppercase step-title">Step ${stepIndex + 1}</span>
        <input type="hidden" name="phase_2_main_body[${stepIndex}][step]" value="${stepIndex + 1}">
        <button type="button" onclick="this.closest('.step-card').remove(); reindexSteps();" class="text-rose-500 hover:text-rose-700 text-xs font-bold">Remove</button>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div>
          <label class="block text-[11px] font-bold text-slate-600 mb-1">Teacher Activity *</label>
          <textarea name="phase_2_main_body[${stepIndex}][teacher_activity]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none"></textarea>
        </div>
        <div>
          <label class="block text-[11px] font-bold text-slate-600 mb-1">Student Activity *</label>
          <textarea name="phase_2_main_body[${stepIndex}][student_activity]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none"></textarea>
        </div>
        <div>
          <label class="block text-[11px] font-bold text-slate-600 mb-1">Assessment *</label>
          <textarea name="phase_2_main_body[${stepIndex}][assessment]" rows="3" required class="w-full rounded-xl border border-slate-300 p-2.5 text-xs focus:ring-2 focus:ring-asc-green focus:outline-none"></textarea>
        </div>
      </div>
    `;
    container.appendChild(div);
    stepIndex++;
  }

  function reindexSteps() {
    const cards = document.querySelectorAll('#mainBodyStepsContainer .step-card');
    cards.forEach((card, idx) => {
      card.querySelector('.step-title').textContent = `Step ${idx + 1}`;
      card.querySelector('input[type="hidden"]').value = idx + 1;
      card.querySelector('input[type="hidden"]').name = `phase_2_main_body[${idx}][step]`;
      const textareas = card.querySelectorAll('textarea');
      textareas[0].name = `phase_2_main_body[${idx}][teacher_activity]`;
      textareas[1].name = `phase_2_main_body[${idx}][student_activity]`;
      textareas[2].name = `phase_2_main_body[${idx}][assessment]`;
    });
    stepIndex = cards.length;
  }

  let resourceIndex = {{ count(old('resources', $lessonPlan->resources->toArray())) }};
  function addResource() {
    const container = document.getElementById('resourcesContainer');
    const div = document.createElement('div');
    div.className = 'resource-row p-4 rounded-xl bg-slate-50 border border-slate-200 space-y-3';
    div.innerHTML = `
      <div class="flex items-center justify-between">
        <span class="text-xs font-bold text-slate-600 uppercase">Resource #${resourceIndex + 1}</span>
        <button type="button" onclick="this.closest('.resource-row').remove()" class="text-rose-500 hover:text-rose-700 text-xs font-bold">
          <i class="fa-solid fa-trash"></i> Remove
        </button>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        <div>
          <label class="block text-[11px] font-bold text-slate-600 mb-1">Title *</label>
          <input type="text" name="resources[${resourceIndex}][title]" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-[11px] font-bold text-slate-600 mb-1">Type</label>
          <select name="resources[${resourceIndex}][type]" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
            <option value="youtube">YouTube</option>
            <option value="google_drive">Google Drive</option>
            <option value="website">Website</option>
            <option value="document">Document</option>
            <option value="other" selected>Other</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label class="block text-[11px] font-bold text-slate-600 mb-1">URL *</label>
          <input type="url" name="resources[${resourceIndex}][url]" required class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div class="md:col-span-2">
          <label class="block text-[11px] font-bold text-slate-600 mb-1">Description</label>
          <input type="text" name="resources[${resourceIndex}][description]" class="w-full rounded-xl border border-slate-300 px-3 py-2 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
      </div>
    `;
    container.appendChild(div);
    resourceIndex++;
  }

  document.querySelector('form').addEventListener('submit', function() {
    const parseCommaInput = (inputId, fieldName) => {
      const val = document.getElementById(inputId).value;
      const hiddenContainer = document.getElementById(inputId.replace('_input', '_hidden'));
      hiddenContainer.innerHTML = '';
      if (val.trim()) {
        val.split(',').forEach(item => {
          if (item.trim()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = `${fieldName}[]`;
            input.value = item.trim();
            hiddenContainer.appendChild(input);
          }
        });
      }
    };
    parseCommaInput('core_competencies_input', 'core_competencies');
    parseCommaInput('key_vocabulary_input', 'key_vocabulary');
  });
</script>
@endpush
@endsection