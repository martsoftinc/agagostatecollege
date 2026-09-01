@extends('student.layout')

@section('title', 'Terminal Report - ' . $semester->name)

@section('content')
<div class="max-w-4xl mx-auto">

  <!-- Action Bar -->
  <div class="flex items-center justify-between mb-6">
    <a href="{{ route('student.reports.index') }}" class="text-sm text-slate-600 hover:text-asc-green font-medium">
      ← Back to Reports
    </a>
    <a href="{{ route('student.reports.download', $semester->id) }}"
       class="inline-flex items-center gap-2 px-5 py-2.5 bg-asc-green hover:bg-asc-green-dark text-white text-xs font-bold rounded-xl transition shadow-sm">
      <i class="fa-solid fa-download"></i>
      Download PDF
    </a>
  </div>

  <!-- REPORT CARD -->
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

    <!-- HEADER -->
    <div class="p-6 sm:p-8 border-b border-slate-100">
      <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6">
        <!-- School Info -->
        <div class="flex items-start gap-4">
          <div class="w-16 h-16 rounded-full bg-asc-green flex items-center justify-center text-white font-extrabold text-xl border-4 border-asc-yellow shadow">
            ASC
          </div>
          <div>
            <h1 class="text-lg font-extrabold text-slate-900 tracking-wide">AGOGO STATE COLLEGE</h1>
            <p class="text-xs text-slate-500 mt-1">P.O. BOX 25, AGOGO ASHANTI - AKIM</p>
            <p class="text-xs text-slate-500">Tel: 0244973082 • agogostatec@gmail.com</p>
          </div>
        </div>

        <!-- Student Photo + Info -->
        <div class="flex items-center gap-4">
          <div class="text-right">
            <h2 class="font-bold text-slate-900 text-base">{{ $student->last_name }} {{ $student->first_name }} {{ $student->other_names }}</h2>
            <p class="text-xs text-slate-500 mt-1">Study Area: {{ $student->programme ?? 'N/A' }}</p>
            <p class="text-xs text-slate-500">Year of Admission: {{ $student->year_of_admission ?? 'N/A' }}</p>
            <p class="text-xs text-slate-500">Student ID: {{ $student->student_id ?? 'N/A' }}</p>
          </div>
          <img src="{{ $student->profile_picture_url ?? asset('images/default-avatar.png') }}"
               class="w-20 h-20 rounded-lg object-cover border-2 border-slate-200 shadow-sm"
               alt="Student Photo">
        </div>
      </div>

      <div class="mt-6 text-center">
        <h3 class="text-base font-extrabold text-slate-800 tracking-widest uppercase">Official Terminal Report</h3>
        <div class="flex items-center justify-center gap-2 mt-1">
          <div class="h-px w-16 bg-slate-300"></div>
          <span class="text-asc-yellow text-lg">★★★</span>
          <div class="h-px w-16 bg-slate-300"></div>
        </div>
        <p class="text-sm font-semibold text-slate-600 mt-2">
          {{ $semester->name }} • {{ $semester->academicYear->name ?? '' }}
        </p>
      </div>
    </div>

    <!-- RESULTS TABLE -->
    <div class="p-6 sm:p-8">
      <div class="overflow-x-auto">
        <table class="w-full text-sm border-collapse">
          <thead>
            <tr class="bg-slate-800 text-white">
              <th class="py-3 px-4 text-left font-bold">Subject</th>
              <th class="py-3 px-3 text-center font-bold">Classwork</th>
              <th class="py-3 px-3 text-center font-bold">Mid-Sem</th>
              <th class="py-3 px-3 text-center font-bold">Exam</th>
              <th class="py-3 px-3 text-center font-bold">Total %</th>
              <th class="py-3 px-3 text-center font-bold">Grade</th>
              <th class="py-3 px-3 text-center font-bold">GP</th>
              <th class="py-3 px-3 text-center font-bold">Position</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-200">
            @forelse($scores as $score)
              <tr class="hover:bg-slate-50">
                <td class="py-3 px-4 font-semibold text-slate-800">{{ $score->subject->name }}</td>
                <td class="py-3 px-3 text-center">{{ $score->classwork_score ?? '—' }}</td>
                <td class="py-3 px-3 text-center">{{ $score->midsem_score ?? '—' }}</td>
                <td class="py-3 px-3 text-center">{{ $score->exam_score ?? '—' }}</td>
                <td class="py-3 px-3 text-center font-bold">{{ $score->total_score ?? '—' }}</td>
                <td class="py-3 px-3 text-center">
                  <span class="inline-block px-2.5 py-0.5 rounded font-bold text-xs
                    {{ in_array($score->grade, ['A1','B2','B3']) ? 'bg-emerald-100 text-emerald-800' : 
                       (in_array($score->grade, ['C4','C5','C6']) ? 'bg-blue-100 text-blue-800' : 'bg-rose-100 text-rose-800') }}">
                    {{ $score->grade ?? '—' }}
                  </span>
                </td>
                <td class="py-3 px-3 text-center font-semibold">{{ $score->grade_point ?? '—' }}</td>
                <td class="py-3 px-3 text-center font-semibold text-slate-700">
                  {{ $subjectPositions[$score->subject_id] ?? '—' }}
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="py-10 text-center text-slate-400">No scores recorded for this semester.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- SUMMARY -->
      <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
          <p class="text-xs text-slate-500 font-medium">Semester GPA</p>
          <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $semesterGpa ?? '—' }}</p>
        </div>
        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
          <p class="text-xs text-slate-500 font-medium">Subjects Taken</p>
          <p class="text-2xl font-extrabold text-slate-900 mt-1">{{ $scores->count() }}</p>
        </div>
        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
          <p class="text-xs text-slate-500 font-medium">Class</p>
          <p class="text-sm font-bold text-slate-900 mt-1">
            {{ $student->classStream->full_name ?? $student->class ?? 'N/A' }}
          </p>
        </div>
      </div>

      <!-- GRADE INTERPRETATION -->
      <div class="mt-8">
        <h4 class="text-sm font-bold text-slate-800 mb-3">Grade Interpretation</h4>
        <div class="overflow-x-auto">
          <table class="w-full text-xs border border-slate-200 rounded-lg overflow-hidden">
            <thead class="bg-slate-100">
              <tr>
                <th class="py-2 px-3 text-left">Grade</th>
                <th class="py-2 px-3 text-center">Points</th>
                <th class="py-2 px-3 text-center">Score Range</th>
                <th class="py-2 px-3 text-left">Interpretation</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
              <tr><td class="py-1.5 px-3 font-semibold">A1</td><td class="py-1.5 px-3 text-center">4.0</td><td class="py-1.5 px-3 text-center">80 - 100</td><td class="py-1.5 px-3">Excellent</td></tr>
              <tr><td class="py-1.5 px-3 font-semibold">B2</td><td class="py-1.5 px-3 text-center">3.5</td><td class="py-1.5 px-3 text-center">70 - 79</td><td class="py-1.5 px-3">Very Good</td></tr>
              <tr><td class="py-1.5 px-3 font-semibold">B3</td><td class="py-1.5 px-3 text-center">3.0</td><td class="py-1.5 px-3 text-center">60 - 69</td><td class="py-1.5 px-3">Good</td></tr>
              <tr><td class="py-1.5 px-3 font-semibold">C4</td><td class="py-1.5 px-3 text-center">2.5</td><td class="py-1.5 px-3 text-center">55 - 59</td><td class="py-1.5 px-3">Credit</td></tr>
              <tr><td class="py-1.5 px-3 font-semibold">C5</td><td class="py-1.5 px-3 text-center">2.0</td><td class="py-1.5 px-3 text-center">50 - 54</td><td class="py-1.5 px-3">Credit</td></tr>
              <tr><td class="py-1.5 px-3 font-semibold">C6</td><td class="py-1.5 px-3 text-center">1.5</td><td class="py-1.5 px-3 text-center">45 - 49</td><td class="py-1.5 px-3">Credit</td></tr>
              <tr><td class="py-1.5 px-3 font-semibold">D7</td><td class="py-1.5 px-3 text-center">1.0</td><td class="py-1.5 px-3 text-center">40 - 44</td><td class="py-1.5 px-3">Pass</td></tr>
              <tr><td class="py-1.5 px-3 font-semibold">E8</td><td class="py-1.5 px-3 text-center">0.5</td><td class="py-1.5 px-3 text-center">35 - 39</td><td class="py-1.5 px-3">Pass</td></tr>
              <tr><td class="py-1.5 px-3 font-semibold">F9</td><td class="py-1.5 px-3 text-center">0.0</td><td class="py-1.5 px-3 text-center">0 - 34</td><td class="py-1.5 px-3">Fail</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- FOOTER -->
    <div class="px-6 sm:px-8 py-4 bg-slate-50 border-t border-slate-100 text-center text-xs text-slate-500">
      This is a computer-generated terminal report from Agogo State College Student Portal.
    </div>
  </div>
</div>
@endsection