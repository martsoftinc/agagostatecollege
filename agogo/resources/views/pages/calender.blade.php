
@extends('layout')

@section('title', 'Academic Calendar 2026/2027 — Agogo State College')

@section('content')
<!-- ============ CALENDAR HERO ============ -->
<section class="bg-forest py-16 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
    <p class="text-sm font-semibold text-lime flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-lime"></span> Calendar
    </p>
    <h1 class="mt-4 font-extrabold text-3xl sm:text-5xl tracking-tightish text-white leading-tight">
      Academic Calendar 2026/2027
    </h1>
    <p class="mt-4 text-white/70 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
      Important dates for the upcoming academic year. Stay informed and plan ahead.
    </p>
  </div>
</section>

<!-- ============ TERMS ============ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
  <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">

    <!-- Term 1 -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 card-hover border border-gray-100 border-l-4 border-l-lime">
      <div class="flex items-center gap-3 text-forest">
        <span class="w-11 h-11 rounded-xl bg-lime/30 flex items-center justify-center">
          <i data-lucide="calendar" class="w-5 h-5"></i>
        </span>
        <div>
          <span class="font-bold text-lg text-ink">Term 1</span>
          <p class="text-xs text-muted">September – December 2026</p>
        </div>
      </div>
      <ul class="mt-6 space-y-3 text-sm text-muted">
        <li class="flex justify-between gap-3 border-b border-gray-50 pb-2">
          <span>Opening</span>
          <span class="font-medium text-ink text-right">Sept 14, 2026</span>
        </li>
        <li class="flex justify-between gap-3 border-b border-gray-50 pb-2">
          <span>Mid-term break</span>
          <span class="font-medium text-ink text-right">Oct 19–23, 2026</span>
        </li>
        <li class="flex justify-between gap-3 border-b border-gray-50 pb-2">
          <span>Exams</span>
          <span class="font-medium text-ink text-right">Nov 30 – Dec 4</span>
        </li>
        <li class="flex justify-between gap-3">
          <span>Closing</span>
          <span class="font-medium text-ink text-right">Dec 11, 2026</span>
        </li>
      </ul>
    </div>

    <!-- Term 2 -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 card-hover border border-gray-100 border-l-4 border-l-lime">
      <div class="flex items-center gap-3 text-forest">
        <span class="w-11 h-11 rounded-xl bg-lime/30 flex items-center justify-center">
          <i data-lucide="calendar" class="w-5 h-5"></i>
        </span>
        <div>
          <span class="font-bold text-lg text-ink">Term 2</span>
          <p class="text-xs text-muted">January – April 2027</p>
        </div>
      </div>
      <ul class="mt-6 space-y-3 text-sm text-muted">
        <li class="flex justify-between gap-3 border-b border-gray-50 pb-2">
          <span>Opening</span>
          <span class="font-medium text-ink text-right">Jan 4, 2027</span>
        </li>
        <li class="flex justify-between gap-3 border-b border-gray-50 pb-2">
          <span>Mid-term break</span>
          <span class="font-medium text-ink text-right">Feb 15–19, 2027</span>
        </li>
        <li class="flex justify-between gap-3 border-b border-gray-50 pb-2">
          <span>Exams</span>
          <span class="font-medium text-ink text-right">Mar 22–26</span>
        </li>
        <li class="flex justify-between gap-3">
          <span>Closing</span>
          <span class="font-medium text-ink text-right">Apr 2, 2027</span>
        </li>
      </ul>
    </div>

    <!-- Term 3 -->
    <div class="bg-white rounded-3xl p-6 sm:p-8 card-hover border border-gray-100 border-l-4 border-l-lime">
      <div class="flex items-center gap-3 text-forest">
        <span class="w-11 h-11 rounded-xl bg-lime/30 flex items-center justify-center">
          <i data-lucide="calendar" class="w-5 h-5"></i>
        </span>
        <div>
          <span class="font-bold text-lg text-ink">Term 3</span>
          <p class="text-xs text-muted">April – July 2027</p>
        </div>
      </div>
      <ul class="mt-6 space-y-3 text-sm text-muted">
        <li class="flex justify-between gap-3 border-b border-gray-50 pb-2">
          <span>Opening</span>
          <span class="font-medium text-ink text-right">Apr 26, 2027</span>
        </li>
        <li class="flex justify-between gap-3 border-b border-gray-50 pb-2">
          <span>Mid-term break</span>
          <span class="font-medium text-ink text-right">Jun 7–11, 2027</span>
        </li>
        <li class="flex justify-between gap-3 border-b border-gray-50 pb-2">
          <span>Exams</span>
          <span class="font-medium text-ink text-right">Jul 19–23</span>
        </li>
        <li class="flex justify-between gap-3">
          <span>Closing</span>
          <span class="font-medium text-ink text-right">Jul 30, 2027</span>
        </li>
      </ul>
    </div>

  </div>

  <!-- Key dates note -->
  <div class="mt-12 sm:mt-14 bg-ivory rounded-3xl p-6 sm:p-8 max-w-3xl mx-auto">
    <h2 class="font-bold text-lg text-ink flex items-center gap-2">
      <i data-lucide="info" class="w-5 h-5 text-forest"></i>
      Please note
    </h2>
    <ul class="mt-4 space-y-2 text-sm text-muted leading-relaxed">
      <li>Dates may be adjusted by the Ghana Education Service or school management. Parents will be notified of any changes.</li>
      <li>Students are expected to report on the opening day of each term unless otherwise advised.</li>
      <li>For the full printable calendar or enquiries, contact the school office.</li>
    </ul>
    <div class="mt-6 flex flex-col sm:flex-row gap-3">
      <a href="#"
        class="inline-flex items-center justify-center gap-2 bg-lime text-forest-deep font-semibold px-6 py-3 rounded-full hover:bg-lime-soft transition-colors text-sm">
        <i data-lucide="download" class="w-4 h-4"></i> Download full calendar (PDF)
      </a>
      <a href="{{ url('/contact') }}"
        class="inline-flex items-center justify-center gap-2 bg-forest text-white font-semibold px-6 py-3 rounded-full hover:bg-forest-deep transition-colors text-sm">
        Contact the school
      </a>
    </div>
  </div>
</section>
@endsection
