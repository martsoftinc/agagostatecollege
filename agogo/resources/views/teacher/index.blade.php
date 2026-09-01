@extends('teacher.layout')

@section('title', 'Teacher Dashboard - Agogo State College')

@section('content')

  <!-- 1. GREETING HEADER -->
  <section class="bg-gradient-to-r from-asc-green to-asc-green-dark rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
    <!-- Gold Accent Background Effect -->
    <div class="absolute top-0 right-0 w-32 h-32 bg-asc-yellow opacity-10 rounded-full blur-2xl -mr-10 -mt-10"></div>
    
    <div class="relative z-10 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
      <div>
        <span class="inline-block px-3 py-1 bg-asc-yellow/20 border border-asc-yellow/30 text-asc-yellow text-xs font-semibold rounded-full mb-2">
          Academic Term {{ date('Y') }}
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
          Welcome, {{ $teacherName ?? 'Michael Asare' }}! 👋
        </h2>
        <p class="text-xs sm:text-sm text-slate-200 mt-1">
          <!--Here is what’s happening across your classes and schedule today. -->
        </p>
      <!--</div>
      <div class="self-start sm:self-center bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-xl border border-white/20 text-xs">
        <i class="fa-regular fa-calendar text-asc-yellow mr-1.5"></i>
        <span class="font-medium">Term 2, Week 6</span>
      </div>-->
    </div>
  </section>

  <!-- 2. GRID TOOLS SECTION -->
  <section>
    <div class="flex items-center justify-between mb-4">
      <h3 class="text-lg font-bold text-slate-900 tracking-tight">Quick Actions & Tools</h3>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 xl:grid-cols-5 gap-3 sm:gap-4">
      
      <!-- Tool 1: Continuous Assessment 
      <a href="#" class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-asc-green transition text-center flex flex-col items-center">
        <div class="w-12 h-12 rounded-xl bg-emerald-50 text-asc-green group-hover:bg-asc-green group-hover:text-asc-yellow transition flex items-center justify-center text-xl mb-3">
          <i class="fa-solid fa-pen-to-square"></i>
        </div>
        <span class="text-xs font-bold text-slate-800 group-hover:text-asc-green transition leading-tight">Continuous Assessment</span>
      </a>-->


      <!-- Tool 2: Terminal Report (NEW) -->
      <a href="{{route('teacher.scores.index')}}" class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-asc-green transition text-center flex flex-col items-center">
        <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 group-hover:bg-asc-green group-hover:text-asc-yellow transition flex items-center justify-center text-xl mb-3">
          <i class="fa-solid fa-file-invoice"></i>
        </div>
        <span class="text-xs font-bold text-slate-800 group-hover:text-asc-green transition leading-tight">Terminal Report</span>
      </a>

       <!--Tool 3: Attendance-->
      <a href="{{ route('teacher.performance.index') }}" class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-asc-green transition text-center flex flex-col items-center">
        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 group-hover:bg-asc-yellow group-hover:text-asc-green-dark transition flex items-center justify-center text-xl mb-3">
          <i class="fa-solid fa-clipboard-user"></i>
        </div>
        <span class="text-xs font-bold text-slate-800 group-hover:text-asc-green transition leading-tight">Performance Tracker</span>
      </a>

      <!-- Tool 4: Lesson Plan -->
      <a href="{{route('lesson-plans.index')}}" class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-asc-green transition text-center flex flex-col items-center">
        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 group-hover:bg-asc-green group-hover:text-asc-yellow transition flex items-center justify-center text-xl mb-3">
          <i class="fa-solid fa-book-open"></i>
        </div>
        <span class="text-xs font-bold text-slate-800 group-hover:text-asc-green transition leading-tight">Lesson Plan</span>
      </a>

      <!-- Tool 5: Student Finder -->
      <a href="{{ route('teacher.student-finder') }}" class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-asc-green transition text-center flex flex-col items-center">
        <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 group-hover:bg-asc-green group-hover:text-asc-yellow transition flex items-center justify-center text-xl mb-3">
          <i class="fa-solid fa-magnifying-glass"></i>
        </div>
        <span class="text-xs font-bold text-slate-800 group-hover:text-asc-green transition leading-tight">Student Finder</span>
      </a>

      <!-- Tool 6: Academic Calendar 
      <a href="#" class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-asc-green transition text-center flex flex-col items-center">
        <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 group-hover:bg-asc-yellow group-hover:text-asc-green-dark transition flex items-center justify-center text-xl mb-3">
          <i class="fa-solid fa-calendar-days"></i>
        </div>
        <span class="text-xs font-bold text-slate-800 group-hover:text-asc-green transition leading-tight">Academic Calendar</span>
      </a>-->

      <!-- Tool 7: Profile -->
      <a href="{{ route('teacher.profile') }}" class="group bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-asc-green transition text-center flex flex-col items-center">
        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 group-hover:bg-asc-green group-hover:text-white transition flex items-center justify-center text-xl mb-3">
          <i class="fa-solid fa-user-gear"></i>
        </div>
        <span class="text-xs font-bold text-slate-800 group-hover:text-asc-green transition leading-tight">My Profile</span>
      </a>

    </div>
  </section>

  {{-- 3. ANNOUNCEMENTS AND UPDATES SECTION --}}
<section x-data="noticeViewer()" class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
   
  <!-- Header -->
  <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
    <div class="flex items-center space-x-2">
      <div class="w-8 h-8 rounded-lg bg-asc-yellow/20 text-asc-yellow-hover flex items-center justify-center text-sm font-bold">
        <i class="fa-solid fa-bullhorn"></i>
      </div>
      <h3 class="font-bold text-slate-900 text-base">Announcements & Updates</h3>
    </div>
    <a href="{{ route('teacher.notices.index') }}" class="text-xs font-bold text-asc-green hover:underline">
      View All
    </a>
  </div>

  <!-- Feed List -->
  <div class="divide-y divide-slate-100">
    @forelse($notices as $notice)
      <div class="p-5 hover:bg-slate-50/80 transition flex items-start space-x-4">
        <div class="w-2.5 h-2.5 rounded-full {{ $loop->first ? 'bg-asc-green' : ($loop->iteration === 2 ? 'bg-asc-yellow' : 'bg-slate-300') }} mt-2 flex-shrink-0"></div>
        
        <div class="flex-grow">
          <div class="flex items-center justify-between flex-wrap gap-2 mb-1">
            <h4 class="text-sm font-bold text-slate-900">{{ $notice->title }}</h4>
            <span class="text-[11px] text-slate-400 font-medium">
              {{ $notice->created_at->diffForHumans() }}
            </span>
          </div>
          <p class="text-xs text-slate-600 leading-relaxed">
            {{ \Illuminate\Support\Str::limit(strip_tags($notice->body), 160) }}
          </p>

          <button @click="openNotice({{ $notice->id }})"
                  class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-asc-green hover:underline">
            <i class="fa-solid fa-eye"></i> Read more
          </button>
        </div>
      </div>
    @empty
      <div class="p-8 text-center text-slate-400 text-sm">
        No announcements at the moment.
      </div>
    @endforelse
  </div>

  {{-- Same Modal as View All page --}}
  <div x-show="modalOpen" x-cloak
       class="fixed inset-0 z-50 flex items-center justify-center p-4"
       style="display: none;">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="closeModal()"></div>

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>
      <div class="sticky top-0 bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg bg-asc-green/10 text-asc-green flex items-center justify-center">
            <i class="fa-solid fa-bullhorn"></i>
          </div>
          <h2 class="text-lg font-bold text-slate-800" x-text="notice.title || 'Announcement'"></h2>
        </div>
        <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 p-1">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <div class="p-6 space-y-4">
        <div class="flex items-center gap-2 text-xs text-slate-400">
          <i class="fa-regular fa-calendar"></i>
          <span x-text="notice.created_at"></span>
          <span class="mx-1">•</span>
          <span x-text="notice.human_date"></span>
        </div>
        <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-line" x-text="notice.body"></div>
      </div>

      <div class="px-6 py-4 border-t border-slate-100 flex justify-end">
        <button @click="closeModal()"
                class="px-5 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition">
          Close
        </button>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
function noticeViewer() {
    return {
        modalOpen: false,
        notice: { title: '', body: '', created_at: '', human_date: '' },

        async openNotice(id) {
            try {
                const res = await fetch(`/teacher/notices/${id}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });
                if (!res.ok) throw new Error('Failed');
                this.notice = await res.json();
                this.modalOpen = true;
            } catch (e) {
                alert('Could not load this announcement.');
            }
        },
        closeModal() {
            this.modalOpen = false;
        }
    }
}
</script>
@endpush

@endsection