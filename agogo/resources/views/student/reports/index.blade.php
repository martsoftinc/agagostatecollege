@extends('student.layout')

@section('title', 'My Terminal Reports')

@section('content')
<div>
  <div class="mb-6">
    <h2 class="text-2xl font-extrabold text-slate-900">Terminal Reports</h2>
    <p class="text-sm text-slate-500 mt-1">View and download your official semester reports</p>
  </div>

  @if($semesters->isEmpty())
    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
      <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fa-solid fa-file-lines text-2xl text-slate-400"></i>
      </div>
      <h3 class="font-bold text-slate-700">No reports available yet</h3>
      <p class="text-sm text-slate-500 mt-1">Your terminal reports will appear here once scores are published.</p>
    </div>
  @else
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
      @foreach($semesters as $semester)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition overflow-hidden">
          <div class="p-5">
            <div class="flex items-start justify-between mb-3">
              <div>
                <h3 class="font-bold text-slate-900">{{ $semester->name }}</h3>
                <p class="text-xs text-slate-500 mt-0.5">{{ $semester->academicYear->name ?? '' }}</p>
              </div>
              @if($semester->is_current)
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full">Current</span>
              @endif
            </div>

            <div class="flex items-center gap-3 mt-5">
              <a href="{{ route('student.reports.show', $semester->id) }}"
                 class="flex-1 text-center px-4 py-2.5 bg-asc-green hover:bg-asc-green-dark text-white text-xs font-bold rounded-xl transition">
                View Report
              </a>
              <a href="{{ route('student.reports.download', $semester->id) }}"
                 class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition"
                 title="Download PDF">
                <i class="fa-solid fa-download"></i>
              </a>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  @endif
</div>
@endsection