@extends('teacher.layout')

@section('title', $lessonPlan->unit_topic . ' - Lesson Plan')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
<a href="{{ route('lesson-plans.index')}}" class="text-slate-500 hover:text-slate-800 text-sm font-semibold flex items-center space-x-1">
      <i class="fa-solid fa-arrow-left"></i>
      <span>Back</span>
    </a>
  <!-- Header Card -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row md:items-center justify-between gap-4">
    <div>
      <div class="flex items-center space-x-2 flex-wrap gap-y-1">
        <span class="text-xs font-extrabold uppercase px-2.5 py-1 rounded-md bg-asc-yellow-light text-asc-yellow-hover">
          {{ $lessonPlan->subject }}
        </span>
        <span class="text-xs font-bold text-slate-500">{{ $lessonPlan->class_form }}</span>
        @if($lessonPlan->school_name)
          <span class="text-xs font-bold text-slate-400">• {{ $lessonPlan->school_name }}</span>
        @endif
      </div>
      <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight mt-1">{{ $lessonPlan->unit_topic }}</h1>
      @if($lessonPlan->sub_topic)
        <p class="text-sm text-slate-600 mt-0.5">{{ $lessonPlan->sub_topic }}</p>
      @endif
      <p class="text-xs text-slate-500 mt-1">
        Prepared by {{ $lessonPlan->author?->name ?? 'Unknown' }} on
        {{ $lessonPlan->lesson_date ? \Carbon\Carbon::parse($lessonPlan->lesson_date)->format('M d, Y') : $lessonPlan->created_at->format('M d, Y') }}
      </p>
    </div>
    <div class="flex items-center space-x-2">
      <div class="flex items-center space-x-2">
  {{-- Download PDF – anyone who can view --}}
  <a href="{{ route('lesson-plans.pdf', $lessonPlan) }}"
     class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition flex items-center space-x-1">
    <i class="fa-solid fa-file-pdf"></i>
    <span>Download PDF</span>
  </a>

  {{-- Share – only owner --}}
  @if($lessonPlan->user_id === auth()->id())
    <button onclick="document.getElementById('shareModal').classList.remove('hidden')"
            class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition flex items-center space-x-1">
      <i class="fa-solid fa-share-nodes"></i>
      <span>Share</span>
    </button>
  @endif

  {{-- Edit – owner OR users with edit permission --}}
  @can('update', $lessonPlan)
    <a href="{{ route('lesson-plans.edit', $lessonPlan) }}"
       class="px-3.5 py-2 rounded-xl bg-asc-yellow hover:bg-asc-yellow-hover text-slate-900 font-bold text-xs transition flex items-center space-x-1">
      <i class="fa-solid fa-pen"></i>
      <span>Edit</span>
    </a>
  @endcan
</div>
    </div>
  </div>

  <!-- Meta Info -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
      <div>
        <span class="block text-slate-400 font-bold uppercase">Duration</span>
        <span class="font-bold text-slate-800">{{ $lessonPlan->duration_minutes ?? 'N/A' }} Mins</span>
      </div>
      <div>
        <span class="block text-slate-400 font-bold uppercase">Class Size</span>
        <span class="font-bold text-slate-800">{{ $lessonPlan->class_size ?? 'N/A' }}</span>
      </div>
      <div>
        <span class="block text-slate-400 font-bold uppercase">Time</span>
        <span class="font-bold text-slate-800">
          {{ $lessonPlan->start_time ? \Carbon\Carbon::parse($lessonPlan->start_time)->format('H:i') : '—' }}
          –
          {{ $lessonPlan->end_time ? \Carbon\Carbon::parse($lessonPlan->end_time)->format('H:i') : '—' }}
        </span>
      </div>
      <div>
        <span class="block text-slate-400 font-bold uppercase">Visibility</span>
        <span class="font-bold uppercase {{ $lessonPlan->visibility === 'public' ? 'text-emerald-600' : 'text-amber-600' }}">
          {{ $lessonPlan->visibility }}
        </span>
      </div>
    </div>
  </div>


  @if($lessonPlan->user_id === auth()->id() && $lessonPlan->sharedWithUsers->count() > 0)
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
    <h2 class="text-sm font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2 mb-4">
      Shared With
    </h2>
    <div class="flex flex-wrap gap-2">
      @foreach($lessonPlan->sharedWithUsers as $teacher)
        <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-slate-100 text-xs font-semibold text-slate-700">
          <i class="fa-solid fa-user text-slate-400"></i>
          <span>{{ $teacher->name }}</span>
          <span class="px-1.5 py-0.5 rounded text-[10px] uppercase
            {{ $teacher->pivot->permission === 'edit' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
            {{ $teacher->pivot->permission }}
          </span>
        </div>
      @endforeach
    </div>
  </div>
@endif

  <!-- Curriculum & Objectives -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
    <h2 class="text-sm font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2">Curriculum & Objectives</h2>

    @if($lessonPlan->content_standard)
      <div>
        <h3 class="text-xs font-bold text-slate-500 uppercase mb-1">Content Standard</h3>
        <p class="text-sm text-slate-700">{{ $lessonPlan->content_standard }}</p>
      </div>
    @endif

    @if($lessonPlan->indicator_code_or_text)
      <div>
        <h3 class="text-xs font-bold text-slate-500 uppercase mb-1">Indicator</h3>
        <p class="text-sm text-slate-700">{{ $lessonPlan->indicator_code_or_text }}</p>
      </div>
    @endif

    @if($lessonPlan->performance_indicators)
      <div>
        <h3 class="text-xs font-bold text-slate-500 uppercase mb-1">Performance Indicators</h3>
        <ul class="list-disc list-inside text-sm text-slate-700 space-y-1">
          @foreach((array)$lessonPlan->performance_indicators as $indicator)
            <li>{{ $indicator }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if($lessonPlan->core_competencies)
      <div>
        <h3 class="text-xs font-bold text-slate-500 uppercase mb-1">Core Competencies</h3>
        <div class="flex flex-wrap gap-2">
          @foreach((array)$lessonPlan->core_competencies as $comp)
            <span class="px-2.5 py-1 rounded-full bg-slate-100 text-xs font-semibold text-slate-700">{{ $comp }}</span>
          @endforeach
        </div>
      </div>
    @endif

    @if($lessonPlan->key_vocabulary)
      <div>
        <h3 class="text-xs font-bold text-slate-500 uppercase mb-1">Key Vocabulary</h3>
        <div class="flex flex-wrap gap-2">
          @foreach((array)$lessonPlan->key_vocabulary as $word)
            <span class="px-2.5 py-1 rounded-full bg-asc-yellow-light text-xs font-semibold text-asc-yellow-hover">{{ $word }}</span>
          @endforeach
        </div>
      </div>
    @endif

    @if($lessonPlan->teaching_learning_resources)
      <div>
        <h3 class="text-xs font-bold text-slate-500 uppercase mb-1">Teaching & Learning Resources (TLMs)</h3>
        <p class="text-sm text-slate-700">{{ $lessonPlan->teaching_learning_resources }}</p>
      </div>
    @endif
  </div>

  <!-- Phased Delivery -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-5">
    <h2 class="text-sm font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2">Phased Instructional Delivery</h2>

    <!-- Phase 1 -->
    @php $p1 = $lessonPlan->phase_1_introduction; @endphp
    @if($p1)
      <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-sm font-bold text-slate-800">Phase 1: Introduction</h3>
          <span class="text-xs font-semibold text-slate-500">{{ $p1['duration'] ?? '—' }} mins</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
          <div>
            <span class="block font-bold text-slate-500 mb-1">Teacher Activity</span>
            <p class="text-slate-700 whitespace-pre-line">{{ $p1['teacher_activity'] ?? '—' }}</p>
          </div>
          <div>
            <span class="block font-bold text-slate-500 mb-1">Student Activity</span>
            <p class="text-slate-700 whitespace-pre-line">{{ $p1['student_activity'] ?? '—' }}</p>
          </div>
          <div>
            <span class="block font-bold text-slate-500 mb-1">Assessment</span>
            <p class="text-slate-700 whitespace-pre-line">{{ $p1['assessment'] ?? '—' }}</p>
          </div>
        </div>
      </div>
    @endif

    <!-- Phase 2 -->
    @php $p2 = $lessonPlan->phase_2_main_body; @endphp
    @if($p2 && is_array($p2))
      <div class="space-y-3">
        <h3 class="text-sm font-bold text-slate-800">Phase 2: Main Body</h3>
        @foreach($p2 as $step)
          <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
            <div class="text-xs font-bold text-slate-600 uppercase mb-2">Step {{ $step['step'] ?? '' }}</div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
              <div>
                <span class="block font-bold text-slate-500 mb-1">Teacher Activity</span>
                <p class="text-slate-700 whitespace-pre-line">{{ $step['teacher_activity'] ?? '—' }}</p>
              </div>
              <div>
                <span class="block font-bold text-slate-500 mb-1">Student Activity</span>
                <p class="text-slate-700 whitespace-pre-line">{{ $step['student_activity'] ?? '—' }}</p>
              </div>
              <div>
                <span class="block font-bold text-slate-500 mb-1">Assessment</span>
                <p class="text-slate-700 whitespace-pre-line">{{ $step['assessment'] ?? '—' }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif

    <!-- Phase 3 -->
    @php $p3 = $lessonPlan->phase_3_closure; @endphp
    @if($p3)
      <div class="p-4 rounded-xl bg-slate-50 border border-slate-200">
        <div class="flex items-center justify-between mb-3">
          <h3 class="text-sm font-bold text-slate-800">Phase 3: Closure / Plenary</h3>
          <span class="text-xs font-semibold text-slate-500">{{ $p3['duration'] ?? '—' }} mins</span>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
          <div>
            <span class="block font-bold text-slate-500 mb-1">Teacher Activity</span>
            <p class="text-slate-700 whitespace-pre-line">{{ $p3['teacher_activity'] ?? '—' }}</p>
          </div>
          <div>
            <span class="block font-bold text-slate-500 mb-1">Student Activity</span>
            <p class="text-slate-700 whitespace-pre-line">{{ $p3['student_activity'] ?? '—' }}</p>
          </div>
          <div>
            <span class="block font-bold text-slate-500 mb-1">Assessment</span>
            <p class="text-slate-700 whitespace-pre-line">{{ $p3['assessment'] ?? '—' }}</p>
          </div>
        </div>
      </div>
    @endif
  </div>

  <!-- Assessment & Reflection -->
  @if($lessonPlan->evaluative_exercise || $lessonPlan->reflection_strengths || $lessonPlan->reflection_weaknesses || $lessonPlan->reflection_remedial_action)
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
      <h2 class="text-sm font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2">Assessment & Reflection</h2>

      @if($lessonPlan->evaluative_exercise)
        <div>
          <h3 class="text-xs font-bold text-slate-500 uppercase mb-1">Evaluative Exercise / Homework</h3>
          <p class="text-sm text-slate-700 whitespace-pre-line">{{ $lessonPlan->evaluative_exercise }}</p>
        </div>
      @endif

      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @if($lessonPlan->reflection_strengths)
          <div>
            <h3 class="text-xs font-bold text-slate-500 uppercase mb-1">Strengths</h3>
            <p class="text-sm text-slate-700 whitespace-pre-line">{{ $lessonPlan->reflection_strengths }}</p>
          </div>
        @endif
        @if($lessonPlan->reflection_weaknesses)
          <div>
            <h3 class="text-xs font-bold text-slate-500 uppercase mb-1">Weaknesses</h3>
            <p class="text-sm text-slate-700 whitespace-pre-line">{{ $lessonPlan->reflection_weaknesses }}</p>
          </div>
        @endif
        @if($lessonPlan->reflection_remedial_action)
          <div>
            <h3 class="text-xs font-bold text-slate-500 uppercase mb-1">Remedial Action</h3>
            <p class="text-sm text-slate-700 whitespace-pre-line">{{ $lessonPlan->reflection_remedial_action }}</p>
          </div>
        @endif
      </div>
    </div>
  @endif

  <!-- External Resources -->
  @if($lessonPlan->resources->count() > 0)
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
      <h2 class="text-sm font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2">External Resources</h2>
      <div class="space-y-3">
        @foreach($lessonPlan->resources as $resource)
          <a href="{{ $resource->url }}" target="_blank" rel="noopener" class="flex items-start space-x-3 p-3 rounded-xl border border-slate-200 hover:border-asc-green hover:bg-slate-50 transition group">
            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0
              @if($resource->type === 'youtube') bg-red-100 text-red-600
              @elseif($resource->type === 'google_drive') bg-blue-100 text-blue-600
              @else bg-slate-100 text-slate-600 @endif">
              @if($resource->type === 'youtube')
                <i class="fa-brands fa-youtube"></i>
              @elseif($resource->type === 'google_drive')
                <i class="fa-brands fa-google-drive"></i>
              @else
                <i class="fa-solid fa-link"></i>
              @endif
            </div>
            <div class="min-w-0 flex-1">
              <div class="text-sm font-semibold text-slate-800 group-hover:text-asc-green truncate">{{ $resource->title }}</div>
              @if($resource->description)
                <p class="text-xs text-slate-500 mt-0.5">{{ $resource->description }}</p>
              @endif
              <p class="text-[11px] text-slate-400 mt-0.5 truncate">{{ $resource->url }}</p>
            </div>
            <i class="fa-solid fa-arrow-up-right-from-square text-slate-300 group-hover:text-asc-green text-xs mt-1"></i>
          </a>
        @endforeach
      </div>
    </div>
  @endif

  <!-- File Attachments -->
  @if($lessonPlan->attachments->count() > 0)
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200 space-y-4">
      <h2 class="text-sm font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2">Attachments</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        @foreach($lessonPlan->attachments as $file)
          <a href="{{ Storage::disk($file->disk)->url($file->file_path) }}" target="_blank" class="flex items-center space-x-3 p-3 rounded-xl border border-slate-200 hover:border-asc-green hover:bg-slate-50 transition group">
            <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0
              @if($file->extension === 'pdf') bg-red-100 text-red-600
              @else bg-emerald-100 text-emerald-600 @endif">
              @if($file->extension === 'pdf')
                <i class="fa-solid fa-file-pdf text-lg"></i>
              @else
                <i class="fa-solid fa-image text-lg"></i>
              @endif
            </div>
            <div class="min-w-0 flex-1">
              <div class="text-sm font-semibold text-slate-800 group-hover:text-asc-green truncate">{{ $file->original_name }}</div>
              <p class="text-[11px] text-slate-400">{{ strtoupper($file->extension) }} • {{ number_format($file->file_size / 1024, 1) }} KB</p>
            </div>
            <i class="fa-solid fa-download text-slate-300 group-hover:text-asc-green text-xs"></i>
          </a>
        @endforeach
      </div>
    </div>
  @endif

  <!-- Share Modal -->
  @if($lessonPlan->user_id === auth()->id())
<div id="shareModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-xl">
    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
      <h3 class="font-bold text-slate-900 text-base">Share Private Lesson Plan</h3>
      <button type="button" onclick="document.getElementById('shareModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <form action="{{ route('lesson-plans.share', $lessonPlan) }}" method="POST" class="space-y-4">
      @csrf

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">
          Select Teachers
        </label>
        <div class="max-h-56 overflow-y-auto space-y-2 border border-slate-200 p-2 rounded-xl">
          @forelse($availableTeachers as $teacher)
            @php
              $alreadyShared = $lessonPlan->sharedWithUsers->contains('id', $teacher->id);
              $currentPermission = $alreadyShared
                  ? $lessonPlan->sharedWithUsers->firstWhere('id', $teacher->id)->pivot->permission
                  : 'view';
            @endphp
            <div class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50">
              <label class="flex items-center space-x-2 cursor-pointer flex-1">
                <input type="checkbox"
                       name="users[{{ $teacher->id }}][user_id]"
                       value="{{ $teacher->id }}"
                       {{ $alreadyShared ? 'checked' : '' }}
                       class="rounded text-asc-green focus:ring-asc-green">
                <span class="text-xs font-semibold text-slate-700">{{ $teacher->name }}</span>
              </label>
              <select name="users[{{ $teacher->id }}][permission]"
                      class="text-xs border border-slate-200 rounded-lg px-2 py-1 focus:ring-asc-green">
                <option value="view" {{ $currentPermission === 'view' ? 'selected' : '' }}>View</option>
                <option value="edit" {{ $currentPermission === 'edit' ? 'selected' : '' }}>Edit</option>
              </select>
            </div>
          @empty
            <p class="text-xs text-slate-400 p-2">No other teachers available.</p>
          @endforelse
        </div>
      </div>

      <div class="flex justify-end space-x-2 pt-2">
        <button type="button" onclick="document.getElementById('shareModal').classList.add('hidden')"
                class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 border border-slate-200">
          Cancel
        </button>
        <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-asc-green text-white hover:opacity-90 transition">
          Save Permissions
        </button>
      </div>
    </form>
  </div>
</div>
@endif


</div>
@endsection