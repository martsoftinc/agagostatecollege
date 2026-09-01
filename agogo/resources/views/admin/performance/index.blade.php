@extends('admin.layout')

@section('title', 'Performance Tracker - Admin')

@push('styles')
<style>
  .chart-container { position: relative; height: 270px; width: 100%; }
  .chart-container-sm { position: relative; height: 190px; width: 100%; }
</style>
<!-- Tom Select for nice searchable dropdown -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
@endpush

@section('content')
<div>
  <!-- HEADER -->
  <div class="mb-6">
    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Performance Tracker</h2>
    <p class="text-sm text-slate-500 mt-1">Track individual students or entire class performance</p>
  </div>

  <!-- MODE SWITCHER -->
  <div class="flex gap-2 mb-6">
    <a href="{{ route('admin.performance.index', ['mode' => 'student']) }}"
       class="px-5 py-2.5 text-xs font-bold rounded-xl transition
         {{ $mode === 'student' ? 'bg-asc-green text-white' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
      <i class="fa-solid fa-user mr-1.5"></i> Individual Student
    </a>
    <a href="{{ route('admin.performance.index', ['mode' => 'class']) }}"
       class="px-5 py-2.5 text-xs font-bold rounded-xl transition
         {{ $mode === 'class' ? 'bg-asc-green text-white' : 'bg-white border border-slate-200 text-slate-700 hover:bg-slate-50' }}">
      <i class="fa-solid fa-users mr-1.5"></i> Entire Class
    </a>
  </div>

  <!-- ==================== INDIVIDUAL STUDENT MODE ==================== -->
  @if($mode === 'student')
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
      <form method="GET" action="{{ route('admin.performance.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
        <input type="hidden" name="mode" value="student">
        <div class="flex-1 w-full">
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Search Student</label>
          <select name="student_id" id="studentSelect" required
                  class="w-full text-xs">
            <option value="">Type to search student...</option>
            @foreach($students as $student)
              <option value="{{ $student->id }}" {{ $selectedStudentId == $student->id ? 'selected' : '' }}>
                {{ $student->last_name }} {{ $student->first_name }} {{ $student->other_names }}
                ({{ $student->student_id ?? 'No ID' }})
              </option>
            @endforeach
          </select>
        </div>
        <button type="submit" class="px-6 py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition">
          View Performance
        </button>
      </form>
    </div>

    @if(!$selectedStudent)
      <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fa-solid fa-user-graduate text-2xl text-slate-400"></i>
        </div>
        <h3 class="font-bold text-slate-700 text-lg">Search for a Student</h3>
        <p class="text-sm text-slate-500 mt-1">Start typing a name or student ID above.</p>
      </div>
    @elseif(count($subjectsData) === 0)
      <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
        <h3 class="font-bold text-slate-700">No scores recorded</h3>
        <p class="text-sm text-slate-500 mt-1">This student has no performance data yet.</p>
      </div>
    @else
      <!-- Student Info + Summary + Charts (same as previous student version) -->
      @include('admin.performance.partials.student-results')
    @endif
  @endif

  <!-- ==================== ENTIRE CLASS MODE ==================== -->
  @if($mode === 'class')
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
      <form method="GET" action="{{ route('admin.performance.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        <input type="hidden" name="mode" value="class">

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Class</label>
          <select name="class_stream_id" id="classSelect" required
                  class="w-full px-3 py-2.5 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white"
                  onchange="this.form.submit()">
            <option value="">-- Choose Class --</option>
            @foreach($classStreams as $cs)
              <option value="{{ $cs->id }}" {{ $selectedClassStreamId == $cs->id ? 'selected' : '' }}>
                {{ $cs->schoolClass->name }} {{ $cs->stream->name }}
              </option>
            @endforeach
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Subject</label>
          <select name="subject_id" required
                  class="w-full px-3 py-2.5 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
            <option value="">-- Choose Subject --</option>
            @if($selectedClassStreamId)
              @php
                $subjects = \App\Models\ClassStream::find($selectedClassStreamId)?->subjects ?? collect();
              @endphp
              @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>
                  {{ $subject->name }}
                </option>
              @endforeach
            @endif
          </select>
        </div>

        <button type="submit" class="py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition">
          View Class Performance
        </button>
      </form>
    </div>

    @if(!$selectedClassStream || !$selectedSubject)
      <div class="bg-white rounded-2xl border border-slate-200 p-16 text-center">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fa-solid fa-users text-2xl text-slate-400"></i>
        </div>
        <h3 class="font-bold text-slate-700 text-lg">Select Class & Subject</h3>
        <p class="text-sm text-slate-500 mt-1">Choose a class and subject to view the full class performance.</p>
      </div>
    @else
      @include('admin.performance.partials.class-results')
    @endif
  @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Searchable student dropdown
  new TomSelect('#studentSelect', {
    create: false,
    sortField: { field: 'text', direction: 'asc' },
    placeholder: 'Type student name or ID...'
  });
</script>

{{-- Charts will be loaded inside the partials --}}
@endpush