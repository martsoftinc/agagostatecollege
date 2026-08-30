@extends('teacher.layout')  {{-- Change to teacher layout later if you have one --}}

@section('title', 'My Classes & Subjects - Score Entry')

@section('content')
<div>
  <!-- HEADER -->
  <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Score Entry
      </h2>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Select a class and subject to enter scores
        @if($currentSemester)
          <span class="ml-2 px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[11px] font-bold rounded-full">
            {{ $currentSemester->name }} ({{ $currentSemester->academicYear->name ?? '' }})
          </span>
        @endif
      </p>
    </div>
  </section>

  @if(session('success'))
    <div class="mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl">
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-xl">
      {{ session('error') }}
    </div>
  @endif

  <div class="mt-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
    @forelse($classStreams as $classStream)
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-4 bg-slate-50 border-b border-slate-100">
          <h3 class="font-bold text-slate-900 text-sm">
            {{ $classStream->schoolClass->name }} {{ $classStream->stream->name }}
          </h3>
          <p class="text-[11px] text-slate-500 mt-0.5">{{ $classStream->stream->category }}</p>
        </div>

        <div class="p-4 space-y-2">
          @forelse($classStream->subjects as $subject)
            <a href="{{ route('teacher.scores.enter', [$classStream->id, $subject->id]) }}"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl border border-slate-200 hover:border-asc-green hover:bg-asc-green/5 transition group">
              <div>
                <p class="text-xs font-bold text-slate-800 group-hover:text-asc-green">
                  {{ $subject->name }}
                </p>
                <p class="text-[11px] text-slate-500">
                  {{ $subject->code ?? '' }} • {{ $subject->pivot->is_core ? 'Core' : 'Elective' }}
                </p>
              </div>
              <i class="fa-solid fa-chevron-right text-slate-400 text-xs group-hover:text-asc-green"></i>
            </a>
          @empty
            <p class="text-xs text-slate-400 py-3 text-center">No subjects assigned to you in this class.</p>
          @endforelse
        </div>
      </div>
    @empty
      <div class="col-span-full py-16 text-center">
        <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
          <i class="fa-solid fa-chalkboard-user text-2xl text-slate-400"></i>
        </div>
        <h3 class="font-bold text-slate-700">No classes assigned</h3>
        <p class="text-xs text-slate-500 mt-1">You have not been assigned to any subjects yet.</p>
      </div>
    @endforelse
  </div>
</div>
@endsection