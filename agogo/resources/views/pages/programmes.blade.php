@extends('layout')

@section('title', 'Our Programmes — Agogo State College')

@section('content')
<!-- ============ PROGRAMMES HERO ============ -->
<section class="bg-forest py-16 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
    <p class="text-sm font-semibold text-lime flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-lime"></span> Academics
    </p>
    <h1 class="mt-4 font-extrabold text-3xl sm:text-5xl tracking-tightish text-white leading-tight">
      Our programmes
    </h1>
    <p class="mt-4 text-white/70 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
      Six SHS programmes, each designed to prepare students for WASSCE and the careers that follow.
    </p>
  </div>
</section>

<!-- ============ PROGRAMMES GRID ============ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-7">

    <!-- General Science -->
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-8 card-hover flex flex-col">
      <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="flask-conical" class="w-6 h-6"></i>
      </span>
      <h2 class="mt-5 font-bold text-xl text-ink">General Science</h2>
      <p class="mt-3 text-muted text-sm leading-relaxed flex-1">
        Physics, Chemistry, Biology and Elective Mathematics for future scientists and engineers.
      </p>
      <ul class="mt-5 space-y-2 text-sm text-ink">
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Physics</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Chemistry</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Biology</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Elective Mathematics</li>
      </ul>
    </article>

    <!-- Business -->
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-8 card-hover flex flex-col">
      <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="briefcase" class="w-6 h-6"></i>
      </span>
      <h2 class="mt-5 font-bold text-xl text-ink">Business</h2>
      <p class="mt-3 text-muted text-sm leading-relaxed flex-1">
        Accounting, Costing, Business Management and Economics for tomorrow's entrepreneurs.
      </p>
      <ul class="mt-5 space-y-2 text-sm text-ink">
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Accounting</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Costing</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Business Management</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Economics</li>
      </ul>
    </article>

    <!-- General Arts -->
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-8 card-hover flex flex-col">
      <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="scroll-text" class="w-6 h-6"></i>
      </span>
      <h2 class="mt-5 font-bold text-xl text-ink">General Arts</h2>
      <p class="mt-3 text-muted text-sm leading-relaxed flex-1">
        Literature, Government, History and Geography for well-rounded critical thinkers.
      </p>
      <ul class="mt-5 space-y-2 text-sm text-ink">
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Literature</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Government</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> History</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Geography</li>
      </ul>
    </article>

    <!-- Visual Arts -->
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-8 card-hover flex flex-col">
      <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="palette" class="w-6 h-6"></i>
      </span>
      <h2 class="mt-5 font-bold text-xl text-ink">Visual Arts</h2>
      <p class="mt-3 text-muted text-sm leading-relaxed flex-1">
        Graphic Design, Picture Making and Textiles for creative and expressive students.
      </p>
      <ul class="mt-5 space-y-2 text-sm text-ink">
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Graphic Design</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Picture Making</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Textiles</li>
      </ul>
    </article>

    <!-- Home Economics -->
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-8 card-hover flex flex-col">
      <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="soup" class="w-6 h-6"></i>
      </span>
      <h2 class="mt-5 font-bold text-xl text-ink">Home Economics</h2>
      <p class="mt-3 text-muted text-sm leading-relaxed flex-1">
        Food &amp; Nutrition, Management in Living, and Clothing &amp; Textiles.
      </p>
      <ul class="mt-5 space-y-2 text-sm text-ink">
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Food &amp; Nutrition</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Management in Living</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Clothing &amp; Textiles</li>
      </ul>
    </article>

    <!-- Agricultural Science -->
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-8 card-hover flex flex-col">
      <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="sprout" class="w-6 h-6"></i>
      </span>
      <h2 class="mt-5 font-bold text-xl text-ink">Agricultural Science</h2>
      <p class="mt-3 text-muted text-sm leading-relaxed flex-1">
        General Agriculture, Animal Husbandry and Crop Science for future agribusiness leaders.
      </p>
      <ul class="mt-5 space-y-2 text-sm text-ink">
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> General Agriculture</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Animal Husbandry</li>
        <li class="flex items-center gap-2"><span class="w-1.5 h-1.5 rounded-full bg-lime shrink-0"></span> Crop Science</li>
      </ul>
    </article>

  </div>

  <!-- CTA -->
  <div class="mt-14 sm:mt-16 relative bg-forest rounded-[2rem] px-6 sm:px-10 lg:px-14 py-10 sm:py-12 grid lg:grid-cols-2 gap-6 items-center overflow-hidden">
    <div class="absolute inset-0 bg-noise opacity-40"></div>
    <div class="relative">
      <h2 class="text-white font-extrabold text-2xl sm:text-3xl tracking-tightish leading-tight">
        Ready to join Agogo State College?
      </h2>
      <p class="mt-3 text-white/65 max-w-md text-sm sm:text-base leading-relaxed">
        Admission is open for the 2026/2027 academic year. Places are limited across all six programmes.
      </p>
    </div>
    <div class="relative flex flex-col sm:flex-row gap-3 sm:gap-4 justify-start lg:justify-end">
      <a href="{{ url('/contact') }}" class="inline-flex items-center justify-center gap-2 bg-lime text-forest-deep font-semibold px-6 sm:px-7 py-3 rounded-full hover:bg-lime-soft transition-colors text-sm sm:text-base">
        Contact admissions
      </a>
      <a href="tel:+233244000000" class="inline-flex items-center justify-center gap-2 bg-white/10 text-white font-semibold px-6 sm:px-7 py-3 rounded-full hover:bg-white/20 transition-colors text-sm sm:text-base">
        <i data-lucide="phone-call" class="w-4 h-4"></i> +233 24 400 0000
      </a>
    </div>
  </div>
</section>
@endsection