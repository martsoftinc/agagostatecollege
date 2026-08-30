@extends('teacher.layout')

@section('title', 'Enter Scores - ' . $subject->name)

@section('content')
<div>
  <!-- HEADER -->
  <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="{{ route('teacher.scores.index') }}" class="hover:text-asc-green">Score Entry</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span>{{ $subject->name }}</span>
      </div>
      <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 tracking-tight">
        {{ $classStream->schoolClass->name }} {{ $classStream->stream->name }}
      </h2>
      <p class="text-xs text-slate-500 mt-1">
        {{ $subject->name }}
        <span class="mx-2">•</span>
        {{ $currentSemester->name }} ({{ $currentSemester->academicYear->name ?? '' }})
      </p>
    </div>

    <div class="flex items-center gap-3">
      @if($weights)
        <div class="text-[11px] bg-slate-100 px-3 py-2 rounded-xl text-slate-600">
          Weights: 
          CW {{ $weights->classwork_percent }}% • 
          Mid {{ $weights->midsem_percent }}% • 
          Exam {{ $weights->exam_percent }}%
        </div>
      @endif
      <a href="{{ route('teacher.scores.index') }}"
         class="px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
        ← Back
      </a>
    </div>
  </section>

  @if(session('success'))
    <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl">
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-xl">
      {{ session('error') }}
    </div>
  @endif

  <form action="{{ route('teacher.scores.store', [$classStream->id, $subject->id]) }}" method="POST">
    @csrf

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
          <thead>
            <tr class="bg-slate-100/80 border-b border-slate-200 text-[11px] uppercase font-bold text-slate-500 tracking-wider">
              <th class="py-3 px-4 sticky left-0 bg-slate-100 z-10">#</th>
              <th class="py-3 px-4 sticky left-10 bg-slate-100 z-10 min-w-[180px]">Student Name</th>
              <th class="py-3 px-3 text-center">Classwork</th>
              <th class="py-3 px-3 text-center">Mid-Sem</th>
              <th class="py-3 px-3 text-center">Exam</th>
              <th class="py-3 px-3 text-center">Total</th>
              <th class="py-3 px-3 text-center">Grade</th>
              <th class="py-3 px-3 text-center">GP</th>
              <th class="py-3 px-3 text-center">Attendance</th>
              <th class="py-3 px-4">Comment</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-xs">
            @foreach($students as $index => $student)
              @php
                $score = $existingScores->get($student->id);
              @endphp
              <tr class="hover:bg-slate-50/80 transition">
                <td class="py-2.5 px-4 text-slate-500 sticky left-0 bg-white">{{ $index + 1 }}</td>
                <td class="py-2.5 px-4 font-semibold text-slate-800 sticky left-10 bg-white">
                  {{ $student->full_name}}
                </td>

                <!-- Classwork -->
                <td class="py-2 px-2">
                  <input type="number" step="0.01" min="0" max="100"
                         name="scores[{{ $student->id }}][classwork]"
                         value="{{ old('scores.'.$student->id.'.classwork', $score->classwork_score ?? '') }}"
                         class="w-20 px-2 py-1.5 text-center border border-slate-200 rounded-lg focus:border-asc-green focus:outline-none text-xs">
                </td>

                <!-- Mid-Sem -->
                <td class="py-2 px-2">
                  <input type="number" step="0.01" min="0" max="100"
                         name="scores[{{ $student->id }}][midsem]"
                         value="{{ old('scores.'.$student->id.'.midsem', $score->midsem_score ?? '') }}"
                         class="w-20 px-2 py-1.5 text-center border border-slate-200 rounded-lg focus:border-asc-green focus:outline-none text-xs">
                </td>

                <!-- Exam -->
                <td class="py-2 px-2">
                  <input type="number" step="0.01" min="0" max="100"
                         name="scores[{{ $student->id }}][exam]"
                         value="{{ old('scores.'.$student->id.'.exam', $score->exam_score ?? '') }}"
                         class="w-20 px-2 py-1.5 text-center border border-slate-200 rounded-lg focus:border-asc-green focus:outline-none text-xs">
                </td>

                <!-- Total (readonly) -->
                <td class="py-2.5 px-3 text-center font-bold text-slate-800">
                  {{ $score->total_score ?? '—' }}
                </td>

                <!-- Grade -->
                <td class="py-2.5 px-3 text-center">
                  @if($score && $score->grade)
                    <span class="px-2 py-0.5 rounded-md text-[11px] font-bold
                      {{ in_array($score->grade, ['A1','B2','B3']) ? 'bg-emerald-100 text-emerald-700' : 
                         (in_array($score->grade, ['C4','C5','C6']) ? 'bg-blue-100 text-blue-700' : 'bg-rose-100 text-rose-700') }}">
                      {{ $score->grade }}
                    </span>
                  @else
                    —
                  @endif
                </td>

                <!-- Grade Point -->
                <td class="py-2.5 px-3 text-center font-semibold">
                  {{ $score->grade_point ?? '—' }}
                </td>

                <!-- Attendance -->
                <td class="py-2 px-2">
                  <input type="number" min="0" max="100"
                         name="scores[{{ $student->id }}][attendance]"
                         value="{{ old('scores.'.$student->id.'.attendance', $score->attendance ?? '') }}"
                         class="w-16 px-2 py-1.5 text-center border border-slate-200 rounded-lg focus:border-asc-green focus:outline-none text-xs"
                         placeholder="Days">
                </td>

                <!-- Comment -->
                <td class="py-2 px-3">
                  <input type="text"
                         name="scores[{{ $student->id }}][comment]"
                         value="{{ old('scores.'.$student->id.'.comment', $score->teacher_comment ?? '') }}"
                         class="w-full min-w-[140px] px-2 py-1.5 border border-slate-200 rounded-lg focus:border-asc-green focus:outline-none text-xs"
                         placeholder="Optional comment">
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <!-- SAVE BUTTON -->
      <div class="p-4 border-t border-slate-100 bg-slate-50 flex justify-between items-center">
        <p class="text-[11px] text-slate-500">
          Total, Grade and Grade Point are calculated automatically after saving.
        </p>
        <button type="submit"
                class="px-6 py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition shadow-sm">
          Save All Scores
        </button>
      </div>
    </div>
  </form>
</div>
@endsection