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
          Weights: Mid Sem 40% • Exam 60%
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
              <th class="py-3 px-3 text-center">Mid-Sem <span class="text-slate-400 font-normal">(max 40)</span></th>
              <th class="py-3 px-3 text-center">Exam <span class="text-slate-400 font-normal">(max 60)</span></th>
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
              <tr class="hover:bg-slate-50/80 transition score-row">
                <td class="py-2.5 px-4 text-slate-500 sticky left-0 bg-white">{{ $index + 1 }}</td>
                <td class="py-2.5 px-4 font-semibold text-slate-800 sticky left-10 bg-white">
                  {{ $student->full_name }}
                </td>

                <!-- Mid-Sem (max 40) -->
                <td class="py-2 px-2">
                  <input type="number" 
                         step="0.01" 
                         min="0" 
                         max="40"
                         name="scores[{{ $student->id }}][midsem]"
                         value="{{ old('scores.'.$student->id.'.midsem', $score->midsem_score ?? '') }}"
                         class="midsem-input w-20 px-2 py-1.5 text-center border border-slate-200 rounded-lg focus:border-asc-green focus:outline-none text-xs"
                         data-student="{{ $student->id }}"
                         placeholder="">
                </td>

                <!-- Exam (max 60) -->
                <td class="py-2 px-2">
                  <input type="number" 
                         step="0.01" 
                         min="0" 
                         max="60"
                         name="scores[{{ $student->id }}][exam]"
                         value="{{ old('scores.'.$student->id.'.exam', $score->exam_score ?? '') }}"
                         class="exam-input w-20 px-2 py-1.5 text-center border border-slate-200 rounded-lg focus:border-asc-green focus:outline-none text-xs"
                         data-student="{{ $student->id }}"
                         placeholder="">
                </td>

                <!-- Total (auto-calculated) -->
                <td class="py-2 px-2 text-center">
                  <input type="text" 
                         readonly
                         class="total-display w-20 px-2 py-1.5 text-center border border-slate-200 rounded-lg bg-slate-50 text-xs font-bold text-slate-800"
                         value="{{ $score->total_score ?? '' }}"
                         data-student="{{ $student->id }}"
                         placeholder="—">
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
                  <input type="number" 
                         min="0" 
                         max="100"
                         name="scores[{{ $student->id }}][attendance]"
                         value="{{ old('scores.'.$student->id.'.attendance', $score->attendance ?? '') }}"
                         class="w-16 px-2 py-1.5 text-center border border-slate-200 rounded-lg focus:border-asc-green focus:outline-none text-xs"
                         placeholder="">
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
          Mid-Sem max 40 • Exam max 60 • Total = Mid + Exam (max 100). Grade & GP calculated after saving.
        </p>
        <button type="submit"
                class="px-6 py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition shadow-sm">
          Save All Scores
        </button>
      </div>
    </div>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

  function calculateTotal(studentId) {
    const midsemInput = document.querySelector(`.midsem-input[data-student="${studentId}"]`);
    const examInput   = document.querySelector(`.exam-input[data-student="${studentId}"]`);
    const totalInput  = document.querySelector(`.total-display[data-student="${studentId}"]`);

    if (!midsemInput || !examInput || !totalInput) return;

    const midsemVal = midsemInput.value.trim();
    const examVal   = examInput.value.trim();

    // If both empty → leave total empty
    if (midsemVal === '' && examVal === '') {
      totalInput.value = '';
      return;
    }

    const midsem = parseFloat(midsemVal) || 0;
    const exam   = parseFloat(examVal) || 0;

    let total = midsem + exam;

    // Cap at 100
    if (total > 100) total = 100;

    totalInput.value = Number.isInteger(total) ? total : total.toFixed(2);
  }

  // Enforce max values while typing
  function enforceMax(input, max) {
    input.addEventListener('input', function () {
      if (this.value !== '' && parseFloat(this.value) > max) {
        this.value = max;
      }
      calculateTotal(this.dataset.student);
    });
  }

  // Attach to all inputs
  document.querySelectorAll('.midsem-input').forEach(input => {
    enforceMax(input, 40);
    // Run once on load for existing scores
    calculateTotal(input.dataset.student);
  });

  document.querySelectorAll('.exam-input').forEach(input => {
    enforceMax(input, 60);
    calculateTotal(input.dataset.student);
  });
});
</script>
@endsection