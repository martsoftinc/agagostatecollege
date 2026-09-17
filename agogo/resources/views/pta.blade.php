@extends('layout')

@section('title', 'PTA — Agogo State College')

@section('content')
<!-- ============ PTA HERO ============ -->
<section class="bg-forest py-16 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
    <p class="text-sm font-semibold text-lime flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-lime"></span> Parent Teacher Association
    </p>
    <h1 class="mt-4 font-extrabold text-3xl sm:text-5xl tracking-tightish text-white leading-tight">
      PTA
    </h1>
    <p class="mt-4 text-white/70 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
      Parents and teachers working hand-in-hand for the good of every student.
    </p>
  </div>
</section>

<!-- ============ PTA MEMBERS ============ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
  <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
    <p class="text-sm font-semibold text-forest flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-forest"></span> Leadership
    </p>
    <h2 class="mt-3 sm:mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish text-ink">
      PTA executives
    </h2>
    <p class="mt-3 sm:mt-4 text-muted text-sm sm:text-base leading-relaxed">
      Meet the parents guiding the association this term.
    </p>
  </div>
  <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap7">
    <div class="bg-white border border-gray-100 rounded-3xl p-6 text-center card-hover">
      <img
        src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=300&q=80"
        alt="PTA Chairman"
        class="w-24 h-24 sm:w-28 sm:h-28 object-cover rounded-full mx-auto"
        loading="lazy"
      >
      <h3 class="mt-4 font-semibold text-base sm:text-lg text-ink">Mr. Emmanuel Ofori</h3>
      <p class="text-sm text-forest font-medium mt-1">Chairman</p>
    </div>
    
    
    <div class="bg-white border border-gray-100 rounded-3xl p-6 text-center card-hover">
      <img
        src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=300&q=80"
        alt="PTA Treasurer"
        class="w-24 h-24 sm:w-28 sm:h-28 object-cover rounded-full mx-auto"
        loading="lazy"
      >
      <h3 class="mt-4 font-semibold text-base sm:text-lg text-ink">Mrs. Patricia Adjei</h3>
      <p class="text-sm text-forest font-medium mt-1">Treasurer</p>
    </div>
  </div>
</section>

<!-- ============ NEXT MEETING ============ -->
<section class="bg-ivory py-14 sm:py-20 w-full">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-10">

    @if($meeting)
      <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-10 card-hover border-l-4 border-l-lime">
        <p class="text-sm font-semibold text-forest flex items-center gap-2">
          <i data-lucide="calendar" class="w-5 h-5"></i>
          Next PTA meeting
        </p>

        <h2 class="mt-4 font-extrabold text-2xl sm:text-3xl tracking-tightish text-ink leading-tight">
          {{ $meeting->title }}
        </h2>

        @if($meeting->description)
          <p class="mt-3 text-muted text-sm sm:text-base leading-relaxed">
            {{ $meeting->description }}
          </p>
        @endif

        <div class="mt-6 grid sm:grid-cols-2 gap-4">
          <!-- Date -->
          <div class="flex items-start gap-3">
            <span class="w-10 h-10 rounded-xl bg-lime/30 text-forest flex items-center justify-center shrink-0">
              <i data-lucide="calendar-days" class="w-5 h-5"></i>
            </span>
            <div>
              <p class="text-xs text-muted uppercase tracking-wide font-semibold">Date</p>
              <p class="mt-0.5 font-semibold text-ink">
                {{ $meeting->meeting_date->format('l, d F Y') }}
              </p>
            </div>
          </div>

          <!-- Time -->
          <div class="flex items-start gap-3">
            <span class="w-10 h-10 rounded-xl bg-lime/30 text-forest flex items-center justify-center shrink-0">
              <i data-lucide="clock" class="w-5 h-5"></i>
            </span>
            <div>
              <p class="text-xs text-muted uppercase tracking-wide font-semibold">Time</p>
              <p class="mt-0.5 font-semibold text-ink">
                {{ \Carbon\Carbon::parse($meeting->meeting_time)->format('h:i A') }}
              </p>
            </div>
          </div>

          <!-- Venue -->
          <div class="flex items-start gap-3 sm:col-span-2">
            <span class="w-10 h-10 rounded-xl bg-lime/30 text-forest flex items-center justify-center shrink-0">
              <i data-lucide="map-pin" class="w-5 h-5"></i>
            </span>
            <div>
              <p class="text-xs text-muted uppercase tracking-wide font-semibold">Venue</p>
              <p class="mt-0.5 font-semibold text-ink">
                {{ $meeting->venue }}
              </p>
            </div>
          </div>
        </div>

        <div class="mt-8 flex flex-col sm:flex-row gap-3">
          <a href="{{ url('/contact') }}"
            class="inline-flex items-center justify-center gap-2 bg-lime text-forest-deep font-semibold px-6 py-3 rounded-full hover:bg-lime-soft transition-colors text-sm">
            Contact the school
          </a>
          <a href="tel:+233244000000"
            class="inline-flex items-center justify-center gap-2 bg-forest text-white font-semibold px-6 py-3 rounded-full hover:bg-forest-deep transition-colors text-sm">
            <i data-lucide="phone-call" class="w-4 h-4"></i> +233 24 400 0000
          </a>
        </div>
      </div>

    @else
      {{-- No meeting created yet --}}
      <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-10 text-center">
        <p class="text-muted text-sm sm:text-base">
          No PTA meeting has been scheduled yet. Please check back later.
        </p>
      </div>
    @endif

  </div>
</section>
@endsection
