@extends('student.layout')

@section('title', 'Agogo State College - Student Portal')

@section('content')

  <!-- 1. GREETING BANNER -->
  <section class="bg-white rounded-2xl p-6 sm:p-8 shadow-sm border border-slate-200 relative overflow-hidden">
    <div class="absolute top-0 left-0 bottom-0 w-2 bg-asc-green"></div>
    <div class="absolute top-0 left-2 bottom-0 w-1.5 bg-asc-yellow"></div>

    <div class="pl-3 sm:pl-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
      <div>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-asc-green border border-emerald-200 mb-2">
          ● Active Session • {{ date('Y') }} Academic Year
        </span>
        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
          👋 Welcome, <span class="text-asc-green">{{ $student->name }}</span>!
        </h2>
        <p class="text-slate-600 text-sm mt-1">
          {{ $student->class ?? '—' }} • {{ $student->programme ?? '—' }}
        </p>
      </div>

      <div class="flex items-center space-x-2 text-xs font-medium text-slate-500 bg-slate-50 px-3 py-2 rounded-lg border border-slate-200 self-start md:self-center">
        <i class="fa-regular fa-calendar-check text-asc-green text-sm"></i>
        <span>Term 2 Assessment Period</span>
      </div>
    </div>
  </section>

  <!-- 2. SEVEN ACTION CARDS - LIGHT COLOR PER CARD, ONE ROW DESKTOP / TWO ROWS MOBILE -->
  <section class="grid grid-cols-4 lg:grid-cols-7 gap-2.5 sm:gap-4 auto-rows-fr">

    <!-- CARD 1: CHECK TERMINAL REPORT (Light Emerald) -->
    <a href="#terminal-report" class="group bg-emerald-50 hover:bg-emerald-100 text-slate-900 rounded-xl sm:rounded-2xl p-2.5 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 border border-emerald-200 flex flex-col justify-between relative overflow-hidden min-h-[104px] sm:min-h-[190px]">
      <i class="fa-solid fa-file-invoice text-emerald-900/10 text-5xl sm:text-7xl absolute -right-3 -bottom-3 transition-transform group-hover:scale-110"></i>

      <div>
        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-emerald-700 text-white flex items-center justify-center text-xs sm:text-base font-bold shadow mb-1.5 sm:mb-3">
          <i class="fa-solid fa-graduation-cap"></i>
        </div>
        <h3 class="text-[11px] sm:text-base font-bold text-slate-900 group-hover:text-emerald-800 transition leading-snug">Check Terminal Report</h3>
        <p class="hidden sm:block text-emerald-800/80 text-xs mt-1.5 leading-relaxed">
          CA marks, term scores, class position &amp; result slips.
        </p>
      </div>

      <div class="mt-1.5 sm:mt-3 pt-1.5 sm:pt-3 border-t border-emerald-200 flex items-center justify-between text-[8px] sm:text-xs font-bold text-emerald-700 group-hover:text-emerald-900">
        <span>VIEW REPORT</span>
        <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] transition-transform group-hover:translate-x-1"></i>
      </div>
    </a>

    <!-- CARD 2: CHANGE PIN CODE (Light Amber) -->
    <a href="{{route('student.pincode.edit')}}" class="group bg-amber-50 hover:bg-amber-100 text-slate-900 rounded-xl sm:rounded-2xl p-2.5 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 border border-amber-200 flex flex-col justify-between relative overflow-hidden min-h-[104px] sm:min-h-[190px]">
      <i class="fa-solid fa-key text-amber-900/10 text-5xl sm:text-7xl absolute -right-3 -bottom-3 transition-transform group-hover:scale-110"></i>

      <div>
        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-amber-600 text-white flex items-center justify-center text-xs sm:text-base font-bold shadow mb-1.5 sm:mb-3">
          <i class="fa-solid fa-lock"></i>
        </div>
        <h3 class="text-[11px] sm:text-base font-bold text-slate-900 leading-snug">Change PIN Code</h3>
        <p class="hidden sm:block text-amber-800/80 text-xs mt-1.5 leading-relaxed font-medium">
          Update your 4-digit security PIN.
        </p>
      </div>

      <div class="mt-1.5 sm:mt-3 pt-1.5 sm:pt-3 border-t border-amber-200 flex items-center justify-between text-[8px] sm:text-xs font-bold text-amber-700 group-hover:text-amber-900">
        <span>UPDATE PIN</span>
        <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] transition-transform group-hover:translate-x-1"></i>
      </div>
    </a>

    <!-- CARD 3: ACADEMIC CALENDAR (Light Slate) -->
    <a href="#academic-calendar" class="group bg-slate-100 hover:bg-slate-200 text-slate-900 rounded-xl sm:rounded-2xl p-2.5 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 border border-slate-300 flex flex-col justify-between relative overflow-hidden min-h-[104px] sm:min-h-[190px]">
      <i class="fa-solid fa-calendar-days text-slate-900/10 text-5xl sm:text-7xl absolute -right-3 -bottom-3 transition-transform group-hover:scale-110"></i>

      <div>
        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-slate-700 text-amber-300 flex items-center justify-center text-xs sm:text-base font-bold shadow mb-1.5 sm:mb-3">
          <i class="fa-solid fa-calendar-alt"></i>
        </div>
        <h3 class="text-[11px] sm:text-base font-bold text-slate-900 group-hover:text-slate-700 transition leading-snug">Academic Calendar</h3>
        <p class="hidden sm:block text-slate-600 text-xs mt-1.5 leading-relaxed">
          Reopening dates, exams &amp; vacation timelines.
        </p>
      </div>

      <div class="mt-1.5 sm:mt-3 pt-1.5 sm:pt-3 border-t border-slate-300 flex items-center justify-between text-[8px] sm:text-xs font-bold text-slate-700 group-hover:text-slate-900">
        <span>VIEW DATES</span>
        <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] transition-transform group-hover:translate-x-1"></i>
      </div>
    </a>

    <!-- CARD 4: DISCIPLINARY REPORT (Light Red) -->
    <a href="{{route('student.disciplinary.index')}}" class="group bg-red-50 hover:bg-red-100 text-slate-900 rounded-xl sm:rounded-2xl p-2.5 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 border border-red-200 flex flex-col justify-between relative overflow-hidden min-h-[104px] sm:min-h-[190px]">
      <i class="fa-solid fa-gavel text-red-900/10 text-5xl sm:text-7xl absolute -right-3 -bottom-3 transition-transform group-hover:scale-110"></i>

      <div>
        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-red-700 text-white flex items-center justify-center text-xs sm:text-base shadow mb-1.5 sm:mb-3">
          <i class="fa-solid fa-gavel"></i>
        </div>
        <h3 class="text-[11px] sm:text-base font-bold text-slate-900 group-hover:text-red-800 transition leading-snug">Disciplinary Report</h3>
        <p class="hidden sm:block text-red-800/80 text-xs mt-1.5 leading-relaxed">
          Conduct records &amp; demerit points.
        </p>
      </div>

      <div class="mt-1.5 sm:mt-3 pt-1.5 sm:pt-3 border-t border-red-200 flex items-center justify-between text-[8px] sm:text-xs font-bold text-red-700 group-hover:text-red-900">
        <span>VIEW RECORD</span>
        <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] transition-transform group-hover:translate-x-1"></i>
      </div>
    </a>

    <!-- CARD 5: PERFORMANCE TRACKER (Light Blue) -->
    <a href="#performance-tracker" class="group bg-blue-50 hover:bg-blue-100 text-slate-900 rounded-xl sm:rounded-2xl p-2.5 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 border border-blue-200 flex flex-col justify-between relative overflow-hidden min-h-[104px] sm:min-h-[190px]">
      <i class="fa-solid fa-chart-line text-blue-900/10 text-5xl sm:text-7xl absolute -right-3 -bottom-3 transition-transform group-hover:scale-110"></i>

      <div>
        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-blue-700 text-white flex items-center justify-center text-xs sm:text-base shadow mb-1.5 sm:mb-3">
          <i class="fa-solid fa-chart-line"></i>
        </div>
        <h3 class="text-[11px] sm:text-base font-bold text-slate-900 group-hover:text-blue-800 transition leading-snug">Performance Tracker</h3>
        <p class="hidden sm:block text-blue-800/80 text-xs mt-1.5 leading-relaxed">
          Term-on-term scores &amp; position trend.
        </p>
      </div>

      <div class="mt-1.5 sm:mt-3 pt-1.5 sm:pt-3 border-t border-blue-200 flex items-center justify-between text-[8px] sm:text-xs font-bold text-blue-700 group-hover:text-blue-900">
        <span>TRACK PROGRESS</span>
        <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] transition-transform group-hover:translate-x-1"></i>
      </div>
    </a>

    <!-- CARD 6: EXEAT TRACKER (Light Orange) -->
    <a href="{{route('student.exeats.index')}}" class="group bg-orange-50 hover:bg-orange-100 text-slate-900 rounded-xl sm:rounded-2xl p-2.5 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 border border-orange-200 flex flex-col justify-between relative overflow-hidden min-h-[104px] sm:min-h-[190px]">
      <i class="fa-solid fa-person-walking-arrow-right text-orange-900/10 text-5xl sm:text-7xl absolute -right-3 -bottom-3 transition-transform group-hover:scale-110"></i>

      <div>
        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-orange-600 text-white flex items-center justify-center text-xs sm:text-base shadow mb-1.5 sm:mb-3">
          <i class="fa-solid fa-person-walking-arrow-right"></i>
        </div>
        <h3 class="text-[11px] sm:text-base font-bold text-slate-900 group-hover:text-orange-800 transition leading-snug">Exeat Tracker</h3>
        <p class="hidden sm:block text-orange-800/80 text-xs mt-1.5 leading-relaxed">
          Request &amp; track campus leave status.
        </p>
      </div>

      <div class="mt-1.5 sm:mt-3 pt-1.5 sm:pt-3 border-t border-orange-200 flex items-center justify-between text-[8px] sm:text-xs font-bold text-orange-700 group-hover:text-orange-900">
        <span>MANAGE EXEATS</span>
        <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] transition-transform group-hover:translate-x-1"></i>
      </div>
    </a>

    <!-- CARD 7: CONTACT SCHOOL (Light Teal) -->
    <a href="{{route('student.contact')}}" class="group bg-teal-50 hover:bg-teal-100 text-slate-900 rounded-xl sm:rounded-2xl p-2.5 sm:p-5 shadow-sm hover:shadow-lg transition-all duration-300 border border-teal-200 flex flex-col justify-between relative overflow-hidden min-h-[104px] sm:min-h-[190px]">
      <i class="fa-solid fa-phone text-teal-900/10 text-5xl sm:text-7xl absolute -right-3 -bottom-3 transition-transform group-hover:scale-110"></i>

      <div>
        <div class="w-7 h-7 sm:w-10 sm:h-10 rounded-lg sm:rounded-xl bg-teal-700 text-white flex items-center justify-center text-xs sm:text-base shadow mb-1.5 sm:mb-3">
          <i class="fa-solid fa-phone"></i>
        </div>
        <h3 class="text-[11px] sm:text-base font-bold text-slate-900 group-hover:text-teal-800 transition leading-snug">Contact School</h3>
        <p class="hidden sm:block text-teal-800/80 text-xs mt-1.5 leading-relaxed">
          Reach the office, advisor or admin.
        </p>
      </div>

      <div class="mt-1.5 sm:mt-3 pt-1.5 sm:pt-3 border-t border-teal-200 flex items-center justify-between text-[8px] sm:text-xs font-bold text-teal-700 group-hover:text-teal-900">
        <span>GET IN TOUCH</span>
        <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] transition-transform group-hover:translate-x-1"></i>
      </div>
    </a>

  </section>

  <!-- 3. ANNOUNCEMENTS & SCHOOL UPDATES (DYNAMIC) -->
  <section x-data="noticeViewer()" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
      <div class="flex items-center space-x-2">
        <span class="w-3 h-3 rounded-full bg-asc-yellow animate-pulse"></span>
        <h3 class="font-bold text-slate-900 text-base">Announcements & School Updates</h3>
      </div>
      <a href="{{ route('student.notices.index') }}" class="text-xs font-semibold text-asc-green hover:underline">
        View All Notices
      </a>
    </div>

    <div class="divide-y divide-slate-100">
      @forelse($notices as $notice)
        <article class="p-5 sm:p-6 hover:bg-slate-50/80 transition flex flex-col sm:flex-row sm:items-start justify-between gap-4">
          <div class="flex items-start space-x-4">
            <div class="w-10 h-10 rounded-lg bg-emerald-50 text-asc-green flex-shrink-0 flex items-center justify-center text-lg border border-emerald-100 mt-0.5">
              <i class="fa-solid fa-bullhorn"></i>
            </div>
            <div>
              <h4 class="font-bold text-slate-900 text-sm sm:text-base mt-0.5">
                {{ $notice->title }}
              </h4>
              <p class="text-xs sm:text-sm text-slate-600 mt-1 leading-relaxed">
                {{ \Illuminate\Support\Str::limit(strip_tags($notice->body), 160) }}
              </p>
              <button @click="openNotice({{ $notice->id }})"
                      class="mt-2 inline-flex items-center gap-1 text-xs font-semibold text-asc-green hover:underline">
                <i class="fa-solid fa-eye"></i> Read more
              </button>
            </div>
          </div>
          <span class="text-xs font-medium text-slate-400 whitespace-nowrap self-end sm:self-start">
            {{ $notice->created_at->diffForHumans() }}
          </span>
        </article>
      @empty
        <div class="p-8 text-center text-slate-400 text-sm">
          No announcements at the moment.
        </div>
      @endforelse
    </div>

    {{-- MODAL --}}
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

@endsection

@push('scripts')
  <script>
    function noticeViewer() {
      return {
        modalOpen: false,
        notice: { title: '', body: '', created_at: '', human_date: '' },

        async openNotice(id) {
          try {
            const res = await fetch(`/student/notices/${id}`, {
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