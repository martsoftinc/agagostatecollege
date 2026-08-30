@extends('admin.layout')

@section('title', 'Academic Setup - Agogo State College')

@push('scripts')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
<div x-data="{}">

  <!-- HEADER -->
  <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Academic Setup
      </h2>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Manage Academic Years, Semesters and Assessment Weights
      </p>
    </div>
  </section>

  {{-- ALERTS --}}
  @if(session('success'))
    <div class="mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl flex items-center justify-between">
      <span>{{ session('success') }}</span>
      <i class="fa-solid fa-circle-check text-emerald-600"></i>
    </div>
  @endif
  @if(session('error'))
    <div class="mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-xl flex items-center justify-between">
      <span>{{ session('error') }}</span>
      <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
    </div>
  @endif

  <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-6">

    <!-- ====================== LEFT COLUMN ====================== -->
    <div class="space-y-6">

      <!-- CREATE ACADEMIC YEAR -->
      <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">
          Create Academic Year
        </h3>
        <form action="{{ route('admin.academic-setup.store-year') }}" method="POST" class="space-y-4">
          @csrf
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Year Name</label>
            <input type="text" name="name" placeholder="e.g. 2025/2026" required
                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>
          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Start Date</label>
              <input type="date" name="start_date"
                     class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 uppercase mb-1">End Date</label>
              <input type="date" name="end_date"
                     class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            </div>
          </div>
          <button type="submit"
                  class="w-full py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition">
            Create Year + 2 Semesters
          </button>
        </form>
      </div>

      <!-- ASSESSMENT WEIGHTS -->
      <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
        <h3 class="text-base font-bold text-slate-900 mb-1 border-b border-slate-100 pb-2">
          Assessment Weights
        </h3>
        <p class="text-[11px] text-slate-500 mb-4">Must add up to 100%</p>

        <form action="{{ route('admin.academic-setup.update-weights') }}" method="POST" class="space-y-4">
          @csrf
          @method('PUT')

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
              Classwork / Homework (%)
            </label>
            <input type="number" name="classwork_percent" step="0.01" min="0" max="100"
                   value="{{ old('classwork_percent', $weights->classwork_percent ?? 25) }}" required
                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
              Mid-Semester (%)
            </label>
            <input type="number" name="midsem_percent" step="0.01" min="0" max="100"
                   value="{{ old('midsem_percent', $weights->midsem_percent ?? 25) }}" required
                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
              Exam (%)
            </label>
            <input type="number" name="exam_percent" step="0.01" min="0" max="100"
                   value="{{ old('exam_percent', $weights->exam_percent ?? 50) }}" required
                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>

          <button type="submit"
                  class="w-full py-2.5 bg-asc-yellow hover:bg-asc-yellow-hover text-asc-green-dark font-extrabold text-xs rounded-xl transition">
            Update Weights
          </button>
        </form>
      </div>
    </div>

    <!-- ====================== RIGHT COLUMN ====================== -->
    <div class="xl:col-span-2 space-y-6">

      <!-- ACADEMIC YEARS & SEMESTERS -->
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-100 bg-slate-50/50">
          <h3 class="font-bold text-slate-900 text-base">Academic Years & Semesters</h3>
          <p class="text-xs text-slate-500">Set the current year and semester</p>
        </div>

        <div class="divide-y divide-slate-100">
          @forelse($academicYears as $year)
            <div class="p-5">
              <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                <div class="flex items-center gap-3">
                  <h4 class="font-bold text-slate-900 text-sm">{{ $year->name }}</h4>
                  @if($year->is_current)
                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full uppercase">
                      Current Year
                    </span>
                  @endif
                </div>

                @unless($year->is_current)
                  <form action="{{ route('admin.academic-setup.set-current-year', $year->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="px-3 py-1.5 bg-slate-100 hover:bg-asc-green hover:text-white text-slate-700 text-[11px] font-bold rounded-lg transition">
                      Set as Current
                    </button>
                  </form>
                @endunless
              </div>

              <!-- SEMESTERS -->
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach($year->semesters as $semester)
                  <div class="border border-slate-200 rounded-xl p-4 flex flex-col justify-between
                    {{ $semester->is_current ? 'bg-emerald-50/50 border-emerald-200' : 'bg-slate-50/50' }}">
                    
                    <div class="flex items-start justify-between mb-3">
                      <div>
                        <p class="font-bold text-slate-800 text-sm">{{ $semester->name }}</p>
                        <p class="text-[11px] text-slate-500 mt-0.5">
                          {{ $semester->is_locked ? 'Locked' : 'Open for entry' }}
                        </p>
                      </div>
                      <div class="flex flex-col items-end gap-1">
                        @if($semester->is_current)
                          <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full">
                            Current
                          </span>
                        @endif
                        @if($semester->is_locked)
                          <span class="px-2 py-0.5 bg-rose-100 text-rose-700 text-[10px] font-bold rounded-full">
                            Locked
                          </span>
                        @endif
                      </div>
                    </div>

                    <div class="flex items-center gap-2 mt-auto">
                      @unless($semester->is_current)
                        <form action="{{ route('admin.academic-setup.set-current-semester', $semester->id) }}" method="POST">
                          @csrf
                          @method('PATCH')
                          <button type="submit"
                                  class="px-2.5 py-1 bg-white border border-slate-200 hover:bg-asc-green hover:text-white hover:border-asc-green text-slate-600 text-[11px] font-semibold rounded-lg transition">
                            Set Current
                          </button>
                        </form>
                      @endunless

                      <form action="{{ route('admin.academic-setup.toggle-lock', $semester->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="px-2.5 py-1 text-[11px] font-semibold rounded-lg transition
                                  {{ $semester->is_locked 
                                      ? 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' 
                                      : 'bg-rose-50 text-rose-700 hover:bg-rose-100' }}">
                          {{ $semester->is_locked ? 'Unlock' : 'Lock' }}
                        </button>
                      </form>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          @empty
            <div class="p-10 text-center text-slate-400 text-xs">
              No academic years created yet. Create one on the left.
            </div>
          @endforelse
        </div>
      </div>

    </div>
  </div>
</div>
@endsection