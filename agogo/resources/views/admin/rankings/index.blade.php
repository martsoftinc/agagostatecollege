@extends('admin.layout')

@section('title', 'Class Rankings - Admin')

@section('content')
<div>
  <!-- HEADER -->
  <div class="mb-6">
    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight">Class Rankings</h2>
    <p class="text-sm text-slate-500 mt-1">
      Rank students by total raw score — by specific stream or entire form (SHS 1, SHS 2, SHS 3…)
    </p>
  </div>

  <!-- FILTERS -->
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
    <form method="GET" action="{{ route('admin.rankings.index') }}" class="space-y-4">
      
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Semester -->
        <div>
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">
            Semester <span class="text-rose-500">*</span>
          </label>
          <select name="semester_id" required
                  class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:border-asc-green focus:outline-none">
            <option value="">— Select Semester —</option>
            @foreach($semesters as $semester)
              <option value="{{ $semester->id }}" {{ $selectedSemesterId == $semester->id ? 'selected' : '' }}>
                {{ $semester->name }}
                @if($semester->academicYear) ({{ $semester->academicYear->name }}) @endif
              </option>
            @endforeach
          </select>
        </div>

        <!-- Overall Form (SchoolClass) -->
        <div>
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">
            Overall Form (Optional)
          </label>
          <select name="school_class_id"
                  class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:border-asc-green focus:outline-none">
            <option value="">— All Forms / Select Form —</option>
            @foreach($schoolClasses as $sc)
              <option value="{{ $sc->id }}" {{ $selectedSchoolClassId == $sc->id ? 'selected' : '' }}>
                {{ $sc->name }}
              </option>
            @endforeach
          </select>
          <p class="text-[11px] text-slate-400 mt-1">Select this for entire form ranking (e.g. all of SHS 1)</p>
        </div>

        <!-- Specific Class Stream -->
        <div>
          <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">
            Specific Stream (Optional)
          </label>
          <select name="class_stream_id"
                  class="w-full px-3.5 py-2.5 border border-slate-200 rounded-xl text-sm focus:border-asc-green focus:outline-none">
            <option value="">— All Streams / Select Stream —</option>
            @foreach($classStreams as $cs)
              <option value="{{ $cs->id }}" {{ $selectedClassStreamId == $cs->id ? 'selected' : '' }}>
                {{ $cs->schoolClass->name }} {{ $cs->stream->name }}
              </option>
            @endforeach
          </select>
          <p class="text-[11px] text-slate-400 mt-1">Leave empty if you want entire form ranking</p>
        </div>
      </div>

      <div class="flex justify-end">
        <button type="submit"
                class="px-6 py-2.5 bg-asc-green hover:bg-asc-green-dark text-white text-sm font-bold rounded-xl transition shadow-sm">
          <i class="fa-solid fa-filter mr-1.5"></i>
          View Rankings
        </button>
      </div>
    </form>
  </div>

  <!-- RESULTS -->
  @if($selectedSemester && $rankingTitle)

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      
      <!-- Results Header -->
      <div class="px-5 sm:px-6 py-4 border-b border-slate-100 bg-slate-50/80 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
          <h3 class="font-bold text-slate-900 text-base">{{ $rankingTitle }}</h3>
          <p class="text-xs text-slate-500 mt-0.5">
            {{ $selectedSemester->name }}
            @if($selectedSemester->academicYear)
              • {{ $selectedSemester->academicYear->name }}
            @endif
          </p>
        </div>

        <div class="flex items-center gap-3">
          <span class="text-xs font-semibold text-slate-600 bg-white border border-slate-200 px-3 py-1.5 rounded-lg">
            {{ $rankings->count() }} student{{ $rankings->count() !== 1 ? 's' : '' }}
          </span>

          @if($rankings->isNotEmpty())
            <a href="{{ route('admin.rankings.export', array_filter([
                  'semester_id'      => $selectedSemesterId,
                  'school_class_id'  => $selectedSchoolClassId,
                  'class_stream_id'  => $selectedClassStreamId,
               ])) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white text-xs font-bold rounded-xl transition">
              <i class="fa-solid fa-file-pdf"></i>
              Export PDF
            </a>
          @endif
        </div>
      </div>

      @if($rankings->isEmpty())
        <div class="py-16 px-6 text-center">
          <div class="w-14 h-14 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-ranking-star text-xl text-slate-400"></i>
          </div>
          <h4 class="font-bold text-slate-700">No rankings found</h4>
          <p class="text-sm text-slate-500 mt-1">No scores recorded for the selected filters.</p>
        </div>
      @else
        <div class="overflow-x-auto">
          <table class="w-full text-left min-w-[700px]">
            <thead>
              <tr class="bg-slate-100/70 border-b border-slate-200 text-[11px] uppercase font-bold text-slate-500 tracking-wider">
                <th class="py-3 px-5 w-20 text-center">Rank</th>
                <th class="py-3 px-4">Student Name</th>
                <th class="py-3 px-4">Index Number</th>
                @if(!$selectedClassStreamId)
                  <th class="py-3 px-4">Stream</th>
                @endif
                <th class="py-3 px-4 text-center">Subjects</th>
                <th class="py-3 px-5 text-right">Total Score</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
              @foreach($rankings as $row)
                <tr class="hover:bg-slate-50/70 transition">
                  <td class="py-3.5 px-5 text-center">
                    @if($row['rank'] === 1)
                      <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-amber-100 text-amber-700 font-extrabold text-sm">1</span>
                    @elseif($row['rank'] === 2)
                      <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-slate-200 text-slate-700 font-extrabold text-sm">2</span>
                    @elseif($row['rank'] === 3)
                      <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-orange-100 text-orange-800 font-extrabold text-sm">3</span>
                    @else
                      <span class="font-bold text-slate-600">{{ $row['rank'] }}</span>
                    @endif
                  </td>

                  <td class="py-3.5 px-4 font-semibold text-slate-800">
                    {{ $row['student']->full_name ?? $row['student']->name }}
                  </td>

                  <td class="py-3.5 px-4 text-slate-600 text-xs">
                    {{ $row['student']->index_number ?? '—' }}
                  </td>

                  @if(!$selectedClassStreamId)
                    <td class="py-3.5 px-4 text-xs text-slate-600">
                      {{ $row['class_stream']->stream->name ?? '—' }}
                    </td>
                  @endif

                  <td class="py-3.5 px-4 text-center text-slate-600">
                    {{ $row['subject_count'] }}
                  </td>

                  <td class="py-3.5 px-5 text-right font-bold text-asc-green tabular-nums">
                    {{ number_format($row['total_score'], 2) }}
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </div>

  @else
    <div class="bg-white rounded-2xl border border-slate-200 py-16 px-6 text-center">
      <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fa-solid fa-ranking-star text-2xl text-slate-400"></i>
      </div>
      <h3 class="font-bold text-slate-700 text-lg">Select filters to view rankings</h3>
      <p class="text-sm text-slate-500 mt-1.5 max-w-md mx-auto">
        Choose a semester, then either an <strong>Overall Form</strong> (e.g. SHS 1) or a specific stream.
      </p>
    </div>
  @endif
</div>
@endsection