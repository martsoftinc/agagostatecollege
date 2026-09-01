@extends('teacher.layout')

@section('title', 'Student Finder - Agogo State College')

@section('content')

  <!-- Header -->
  <section class="bg-gradient-to-r from-asc-green to-asc-green-dark rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-asc-yellow opacity-10 rounded-full blur-2xl -mr-10 -mt-10"></div>
    
    <div class="relative z-10">
      <span class="inline-block px-3 py-1 bg-asc-yellow/20 border border-asc-yellow/30 text-asc-yellow text-xs font-semibold rounded-full mb-2">
        Teacher Tools
      </span>
      <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
        Student Finder
      </h2>
      <p class="text-xs sm:text-sm text-slate-200 mt-1">
        Search and view student information quickly.
      </p>
    </div>
  </section>

  <!-- Search Form -->
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 sm:p-6">
    <form method="GET" action="{{ route('teacher.student-finder') }}" class="space-y-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <!-- Name / Student ID -->
        <div class="lg:col-span-2">
          <label class="block text-xs font-semibold text-slate-600 mb-1.5">Search by Name or Student ID</label>
          <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text" 
                   name="q" 
                   value="{{ request('q') }}"
                   placeholder="e.g. Kwame Mensah or ASC/2024/001"
                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition">
          </div>
        </div>

        <!-- Class -->
        <div>
          <label class="block text-xs font-semibold text-slate-600 mb-1.5">Class</label>
          <select name="class" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition bg-white">
            <option value="">All Classes</option>
            @foreach($classes ?? [] as $class)
              <option value="{{ $class }}" {{ request('class') == $class ? 'selected' : '' }}>
                {{ $class }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Programme / Track -->
        <div>
          <label class="block text-xs font-semibold text-slate-600 mb-1.5">Programme / Track</label>
          <select name="programme" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition bg-white">
            <option value="">All Programmes</option>
            @foreach($programmes ?? [] as $programme)
              <option value="{{ $programme }}" {{ request('programme') == $programme ? 'selected' : '' }}>
                {{ $programme }}
              </option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="flex flex-wrap items-center gap-3 pt-1">
        <button type="submit" 
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition shadow-sm">
          <i class="fa-solid fa-search"></i>
          Search Students
        </button>

        @if(request()->hasAny(['q', 'class', 'programme']))
          <a href="{{ route('teacher.student-finder') }}" 
             class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-slate-600 hover:text-asc-green transition">
            <i class="fa-solid fa-xmark"></i>
            Clear filters
          </a>
        @endif
      </div>
    </form>
  </section>

  <!-- Results -->
  <section>
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-bold text-slate-900 tracking-tight">
        @if(request()->hasAny(['q', 'class', 'programme']))
          Search Results
          <span class="text-sm font-medium text-slate-500 ml-1">({{ $students->total() }} found)</span>
        @else
          Recent Students
        @endif
      </h3>
    </div>

    @if($students->isEmpty())
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-12 text-center">
        <div class="w-16 h-16 mx-auto rounded-full bg-slate-100 flex items-center justify-center text-slate-400 text-2xl mb-4">
          <i class="fa-solid fa-user-slash"></i>
        </div>
        <h4 class="font-bold text-slate-700 mb-1">No students found</h4>
        <p class="text-sm text-slate-500">Try adjusting your search terms or filters.</p>
      </div>
    @else
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 sm:gap-5">
        @foreach($students as $student)
          <div class="bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-asc-green/40 transition overflow-hidden group">
            
            <!-- Card Header -->
            <div class="p-5 flex items-start gap-4">
              <!-- Profile Picture -->
              <div class="flex-shrink-0">
                @if($student->profile_picture)
                  <img src="{{ asset('storage/' . $student->profile_picture) }}" 
                       alt="{{ $student->full_name }}"
                       class="w-16 h-16 rounded-xl object-cover border-2 border-slate-100 group-hover:border-asc-green/30 transition">
                @else
                  <div class="w-16 h-16 rounded-xl bg-asc-green/10 text-asc-green flex items-center justify-center text-xl font-bold border-2 border-slate-100 group-hover:border-asc-green/30 transition">
                    {{ strtoupper(substr($student->full_name ?? 'S', 0, 1)) }}
                  </div>
                @endif
              </div>

              <!-- Name + ID -->
              <div class="flex-grow min-w-0">
                <h4 class="font-bold text-slate-900 text-base leading-tight truncate">
                  {{ $student->full_name }}
                </h4>
                <p class="text-xs font-semibold text-asc-green mt-0.5">
                  {{ $student->student_id ?? '—' }}
                </p>
                <div class="flex flex-wrap gap-1.5 mt-2">
                  @if($student->class)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-slate-100 text-[11px] font-medium text-slate-700">
                      {{ $student->class }}
                    </span>
                  @endif
                  @if($student->boarding)
                    <span class="inline-flex items-center px-2 py-0.5 rounded-md bg-amber-50 text-[11px] font-medium text-amber-700">
                      {{ $student->boarding }}
                    </span>
                  @endif
                </div>
              </div>
            </div>

            <!-- Details -->
            <div class="px-5 pb-5 space-y-2.5 border-t border-slate-100 pt-4">
              
              <div class="grid grid-cols-2 gap-x-3 gap-y-2 text-xs">
                <div>
                  <span class="text-slate-400 font-medium block">Programme</span>
                  <span class="text-slate-800 font-semibold">{{ $student->programme ?? '—' }}</span>
                </div>
                <div>
                  <span class="text-slate-400 font-medium block">Track</span>
                  <span class="text-slate-800 font-semibold">{{ $student->track ?? '—' }}</span>
                </div>
                <div>
                  <span class="text-slate-400 font-medium block">House</span>
                  <span class="text-slate-800 font-semibold">{{ $student->house ?? '—' }}</span>
                </div>
                <div>
                  <span class="text-slate-400 font-medium block">Date of Birth</span>
                  <span class="text-slate-800 font-semibold">
                    {{ $student->date_of_birth ? \Carbon\Carbon::parse($student->date_of_birth)->format('d M Y') : '—' }}
                  </span>
                </div>
              </div>

              <!-- Guardian -->
              <div class="pt-2 border-t border-slate-100">
                <span class="text-slate-400 font-medium text-xs block mb-1">Guardian</span>
                <div class="flex items-center justify-between gap-2">
                  <span class="text-sm font-semibold text-slate-800 truncate">
                    {{ $student->guardian_name ?? '—' }}
                  </span>
                  @if($student->guardian_phone)
                    <a href="tel:{{ $student->guardian_phone }}" 
                       class="inline-flex items-center gap-1.5 text-xs font-semibold text-asc-green hover:underline flex-shrink-0">
                      <i class="fa-solid fa-phone text-[10px]"></i>
                      {{ $student->guardian_phone }}
                    </a>
                  @endif
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      <!-- Pagination -->
      <div class="mt-6">
        {{ $students->withQueryString()->links() }}
      </div>
    @endif
  </section>

@endsection