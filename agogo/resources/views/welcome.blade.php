@extends('layout')

@section('title', 'Agogo State College — Excellence in Character and Learning')

@section('hero')
  <!-- ============ HERO SLIDER ============ -->
  <div class="relative z-20 w-full max-w-full overflow-hidden">
    <div id="heroSlider" class="relative h-[400px] sm:h-[560px] lg:h-[640px] overflow-hidden bg-forest-deep w-full">

      <!-- Slide 1 -->
      <div class="slide active absolute inset-0" data-slide="0">
        <img src="images/1.jfif" alt="Students walking on campus" class="absolute inset-0 w-full h-full object-cover object-top" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-tr from-forest-deep/90 via-forest-deep/40 to-transparent"></div>
        <div class="relative z-10 h-full flex items-end px-4 sm:px-6 lg:px-16 pb-10 sm:pb-16">
          <div class="max-w-xl">
            <span class="inline-block text-lime text-xs font-semibold tracking-widest uppercase mb-3">Welcome to Agogo State College</span>
            <h1 class="text-white font-extrabold text-3xl sm:text-5xl lg:text-[3.2rem] leading-[1.08] tracking-tightish">Shaping character, sharpening minds since 1958.</h1>
            <p class="mt-4 sm:mt-6 text-white/80 max-w-md leading-relaxed text-sm sm:text-base">A boarding senior high school in Agogo, Ashanti Region, committed to academic excellence, discipline and service.</p>
            <a href="#admission" class="mt-6 sm:mt-8 inline-flex items-center gap-2 bg-lime text-forest-deep font-semibold px-6 sm:px-7 py-3 rounded-full hover:bg-lime-soft transition-colors w-fit text-sm sm:text-base">Apply for admission <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
          </div>
        </div>
      </div>

      <!-- Slide 2 -->
      <div class="slide absolute inset-0" data-slide="1">
        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1600&q=80" alt="Students in a classroom" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-tr from-forest-deep/90 via-forest-deep/40 to-transparent"></div>
        <div class="relative z-10 h-full flex items-end px-4 sm:px-6 lg:px-16 pb-10 sm:pb-16">
          <div class="max-w-xl">
            <span class="inline-block text-lime text-xs font-semibold tracking-widest uppercase mb-3">2026/2027 Admission</span>
            <h1 class="text-white font-extrabold text-3xl sm:text-5xl lg:text-[3.2rem] leading-[1.08] tracking-tightish">Applications are now open for Form 1.</h1>
            <p class="mt-4 sm:mt-6 text-white/80 max-w-md leading-relaxed text-sm sm:text-base">Join a community of scholars, athletes and leaders. Places are limited — secure your spot today.</p>
            <a href="#admission" class="mt-6 sm:mt-8 inline-flex items-center gap-2 bg-lime text-forest-deep font-semibold px-6 sm:px-7 py-3 rounded-full hover:bg-lime-soft transition-colors w-fit text-sm sm:text-base">Start your application <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
          </div>
        </div>
      </div>

      <!-- Slide 3 -->
      <div class="slide absolute inset-0" data-slide="2">
        <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=1600&q=80" alt="Science laboratory session" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-tr from-forest-deep/90 via-forest-deep/40 to-transparent"></div>
        <div class="relative z-10 h-full flex items-end px-4 sm:px-6 lg:px-16 pb-10 sm:pb-16">
          <div class="max-w-xl">
            <span class="inline-block text-lime text-xs font-semibold tracking-widest uppercase mb-3">Academics</span>
            <h1 class="text-white font-extrabold text-3xl sm:text-5xl lg:text-[3.2rem] leading-[1.08] tracking-tightish">Six programmes built for every ambition.</h1>
            <p class="mt-4 sm:mt-6 text-white/80 max-w-md leading-relaxed text-sm sm:text-base">From General Science to Agricultural Science, our teachers prepare students for WASSCE and beyond.</p>
            <a href="#programmes" class="mt-6 sm:mt-8 inline-flex items-center gap-2 bg-lime text-forest-deep font-semibold px-6 sm:px-7 py-3 rounded-full hover:bg-lime-soft transition-colors w-fit text-sm sm:text-base">Explore programmes <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
          </div>
        </div>
      </div>

      <!-- Slide 4 -->
      <div class="slide absolute inset-0" data-slide="3">
        <img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=1600&q=80" alt="Students playing sports on the field" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-tr from-forest-deep/90 via-forest-deep/40 to-transparent"></div>
        <div class="relative z-10 h-full flex items-end px-4 sm:px-6 lg:px-16 pb-10 sm:pb-16">
          <div class="max-w-xl">
            <span class="inline-block text-lime text-xs font-semibold tracking-widest uppercase mb-3">Campus life</span>
            <h1 class="text-white font-extrabold text-3xl sm:text-5xl lg:text-[3.2rem] leading-[1.08] tracking-tightish">Sports, clubs and a home away from home.</h1>
            <p class="mt-4 sm:mt-6 text-white/80 max-w-md leading-relaxed text-sm sm:text-base">Our boarding houses, sports fields and societies build well-rounded young men and women.</p>
            <a href="#" class="mt-6 sm:mt-8 inline-flex items-center gap-2 bg-lime text-forest-deep font-semibold px-6 sm:px-7 py-3 rounded-full hover:bg-lime-soft transition-colors w-fit text-sm sm:text-base">See campus life <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
          </div>
        </div>
      </div>

      <!-- Slide 5 -->
      <div class="slide absolute inset-0" data-slide="4">
        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=1600&q=80" alt="Graduating students celebrating" class="absolute inset-0 w-full h-full object-cover" loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-tr from-forest-deep/90 via-forest-deep/40 to-transparent"></div>
        <div class="relative z-10 h-full flex items-end px-4 sm:px-6 lg:px-16 pb-10 sm:pb-16">
          <div class="max-w-xl">
            <span class="inline-block text-lime text-xs font-semibold tracking-widest uppercase mb-3">Our results</span>
            <h1 class="text-white font-extrabold text-3xl sm:text-5xl lg:text-[3.2rem] leading-[1.08] tracking-tightish">A proud record of WASSCE excellence.</h1>
            <p class="mt-4 sm:mt-6 text-white/80 max-w-md leading-relaxed text-sm sm:text-base">Our graduates go on to top universities in Ghana and abroad, year after year.</p>
            <a href="#about" class="mt-6 sm:mt-8 inline-flex items-center gap-2 bg-lime text-forest-deep font-semibold px-6 sm:px-7 py-3 rounded-full hover:bg-lime-soft transition-colors w-fit text-sm sm:text-base">Read our story <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
          </div>
        </div>
      </div>

      <!-- Controls -->
      <button id="prevSlide" aria-label="Previous slide" class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 z-40 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center backdrop-blur"> <i data-lucide="chevron-left" class="w-4 h-4 sm:w-5 sm:h-5"></i> </button>
      <button id="nextSlide" aria-label="Next slide" class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 z-40 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center backdrop-blur"> <i data-lucide="chevron-right" class="w-4 h-4 sm:w-5 sm:h-5"></i> </button>

      <div class="absolute bottom-4 sm:bottom-6 left-1/2 -translate-x-1/2 z-40 flex items-center gap-2" id="sliderDots"></div>
    </div>

    <!-- Stats bar -->
    <div class="relative z-20 -mt-8 sm:-mt-10 mb-8 sm:mb-10 mx-auto max-w-4xl px-4 sm:px-6 bg-white rounded-2xl shadow-xl stats-grid divide-x divide-gray-100">
      <div class="text-center"><p class="text-forest font-extrabold text-xl sm:text-2xl">65+</p><p class="text-muted text-[10px] sm:text-xs mt-1">Years of excellence</p></div>
      <div class="text-center"><p class="text-forest font-extrabold text-xl sm:text-2xl">2,400+</p><p class="text-muted text-[10px] sm:text-xs mt-1">Students</p></div>
      <div class="text-center"><p class="text-forest font-extrabold text-xl sm:text-2xl">6</p><p class="text-muted text-[10px] sm:text-xs mt-1">Programmes</p></div>
      <div class="text-center"><p class="text-forest font-extrabold text-xl sm:text-2xl">120+</p><p class="text-muted text-[10px] sm:text-xs mt-1">Teaching staff</p></div>
    </div>
  </div>
@endsection

@section('content')
<!-- ============ HEADMISTRESS' WELCOME ============ -->
<section id="about" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-16 sm:py-24 grid lg:grid-cols-2 gap-10 sm:gap-16 items-start">
  <div>
    <img src="https://images.unsplash.com/photo-1580894732444-8ecded7900cd?auto=format&fit=crop&w=700&q=80" alt="Headmistress of Agogo State College" class="w-full h-64 sm:h-[400px] lg:h-[480px] object-cover rounded-[2rem]">
    <a href="#" class="mt-5 inline-flex items-center justify-center gap-2 bg-forest text-white font-semibold px-5 sm:px-6 py-2.5 sm:py-3 rounded-full hover:bg-forest-deep transition-colors text-sm sm:text-base">Profile of our Headmistress <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
  </div>
  <div>
    <p class="text-sm font-semibold text-forest flex items-center gap-2"><span class="w-6 h-px bg-forest"></span> Headmistress' welcome</p>
    <h2 class="mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish leading-tight">A warm welcome to the Agogo State College family.</h2>
    <p class="mt-4 sm:mt-5 text-muted leading-relaxed text-sm sm:text-base">On behalf of the staff, students and management of Agogo State College, I welcome you to our school community. For over six decades, we have nurtured young people into disciplined, confident and knowledgeable citizens ready to serve Ghana and the world.</p>
    <p class="mt-3 sm:mt-4 text-muted leading-relaxed text-sm sm:text-base">Our doors are open to every learner who is willing to work hard, respect others, and pursue excellence. I invite you to explore our programmes, meet our staff, and consider Agogo State College as the place where your child's future begins.</p>
    <p class="mt-5 sm:mt-6 font-semibold text-ink">Mrs. Comfort Asante-Boateng</p>
    <p class="text-sm text-muted">Headmistress, Agogo State College</p>
  </div>
</section>

<!-- ============ CALL TO ACTION ============ -->
<section id="admission" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 pb-6">
  <div class="relative bg-forest rounded-[2rem] px-6 sm:px-10 lg:px-14 py-10 sm:py-14 grid lg:grid-cols-2 gap-6 sm:gap-8 items-center overflow-hidden">
    <div class="absolute inset-0 bg-noise opacity-40"></div>
    <div class="relative">
      <h2 class="text-white font-extrabold text-2xl sm:text-4xl tracking-tightish leading-tight">Admission is open for the 2026/2027 academic year.</h2>
      <p class="mt-3 sm:mt-4 text-white/65 max-w-md leading-relaxed text-sm sm:text-base">Places are limited across all six programmes. Begin your application today and join a school with a proud tradition of excellence.</p>
    </div>
    <div class="relative flex flex-col sm:flex-row gap-3 sm:gap-4 justify-start lg:justify-end">
      <a href="#" class="inline-flex items-center justify-center gap-2 bg-lime text-forest-deep font-semibold px-6 sm:px-7 py-3 rounded-full hover:bg-lime-soft transition-colors text-sm sm:text-base">Apply now</a>
      <a href="tel:+233244000000" class="inline-flex items-center justify-center gap-2 bg-white/10 text-white font-semibold px-6 sm:px-7 py-3 rounded-full hover:bg-white/20 transition-colors text-sm sm:text-base"><i data-lucide="phone-call" class="w-4 h-4"></i> +233 24 400 0000</a>
    </div>
  </div>
</section>

<!-- ============ HISTORY / MISSION / VIDEO TOUR ============ -->
<section class="bg-ivory py-16 sm:py-24 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
    <div class="text-center max-w-2xl mx-auto">
      <h2 class="font-extrabold text-2xl sm:text-4xl tracking-tightish">Who we are</h2>
      <p class="mt-3 sm:mt-4 text-muted leading-relaxed text-sm sm:text-base">A legacy built on discipline, faith and academic excellence — and a campus worth seeing for yourself.</p>
    </div>
    <div class="mt-10 sm:mt-14 grid md:grid-cols-3 gap-6 sm:gap-8">
      <article class="bg-white rounded-3xl p-6 sm:p-7 card-hover flex flex-col">
        <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center"><i data-lucide="landmark" class="w-5 h-5"></i></span>
        <h3 class="mt-5 font-bold text-lg sm:text-xl">Our History</h3>
        <p class="mt-2 text-muted text-sm leading-relaxed flex-1">Founded in 1958, Agogo State College began as a small day school and has grown into one of the Ashanti Region's most respected boarding institutions, shaping generations of leaders, professionals and change-makers.</p>
        <a href="#" class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-forest hover:gap-2 transition-all w-fit">Read more <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
      </article>
      <article class="bg-white rounded-3xl p-6 sm:p-7 card-hover flex flex-col">
        <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center"><i data-lucide="target" class="w-5 h-5"></i></span>
        <h3 class="mt-5 font-bold text-lg sm:text-xl">Our Mission &amp; Vision</h3>
        <p class="mt-2 text-muted text-sm leading-relaxed flex-1"><span class="font-semibold text-ink">Mission:</span> To provide quality, values-driven secondary education that develops disciplined, innovative and God-fearing citizens.<br class="hidden sm:block"><br class="hidden sm:block"><span class="font-semibold text-ink">Vision:</span> To be a leading centre of academic and moral excellence in Ghana.</p>
        <a href="#" class="mt-5 inline-flex items-center gap-1 text-sm font-semibold text-forest hover:gap-2 transition-all w-fit">Read more <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
      </article>
      <article class="bg-white rounded-3xl p-4 sm:p-4 card-hover flex flex-col">
        <div class="relative rounded-2xl overflow-hidden video-wrapper">
          <iframe src="https://www.youtube.com/embed/dQw4w9WgXcQ" title="A video tour of Agogo State College campus" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
        <div class="p-2 sm:p-3">
          <h3 class="font-bold text-lg sm:text-xl">Campus Video Tour</h3>
          <p class="mt-2 text-muted text-sm leading-relaxed">Take a walk through our classrooms, laboratories, dormitories and fields — right from your screen.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============ PROGRAMMES ============ -->
<section id="programmes" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-16 sm:py-24">
  <div class="flex flex-wrap items-end justify-between gap-4 sm:gap-6">
    <div>
      <p class="text-sm font-semibold text-forest flex items-center gap-2"><span class="w-6 h-px bg-forest"></span> Academics</p>
      <h2 class="mt-3 sm:mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish">Our programmes</h2>
    </div>
    <p class="text-muted max-w-md text-sm sm:text-base">Six SHS programmes, each designed to prepare students for WASSCE and the careers that follow.</p>
  </div>
  <div class="mt-10 sm:mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-7">
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center"><i data-lucide="flask-conical" class="w-5 h-5"></i></span>
      <h3 class="mt-5 font-bold text-lg">General Science</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">Physics, Chemistry, Biology and Elective Mathematics for future scientists and engineers.</p>
    </article>
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center"><i data-lucide="briefcase" class="w-5 h-5"></i></span>
      <h3 class="mt-5 font-bold text-lg">Business</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">Accounting, Costing, Business Management and Economics for tomorrow's entrepreneurs.</p>
    </article>
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center"><i data-lucide="scroll-text" class="w-5 h-5"></i></span>
      <h3 class="mt-5 font-bold text-lg">General Arts</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">Literature, Government, History and Geography for well-rounded critical thinkers.</p>
    </article>
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center"><i data-lucide="palette" class="w-5 h-5"></i></span>
      <h3 class="mt-5 font-bold text-lg">Visual Arts</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">Graphic Design, Picture Making and Textiles for creative and expressive students.</p>
    </article>
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center"><i data-lucide="soup" class="w-5 h-5"></i></span>
      <h3 class="mt-5 font-bold text-lg">Home Economics</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">Food &amp; Nutrition, Management in Living, and Clothing &amp; Textiles.</p>
    </article>
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center"><i data-lucide="sprout" class="w-5 h-5"></i></span>
      <h3 class="mt-5 font-bold text-lg">Agricultural Science</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">General Agriculture, Animal Husbandry and Crop Science for future agribusiness leaders.</p>
    </article>
  </div>
</section>

<!-- ============ ACADEMIC CALENDAR ============ -->
<section id="calendar" class="bg-ivory py-16 sm:py-24 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
    <div class="text-center max-w-2xl mx-auto">
      <p class="text-sm font-semibold text-forest flex items-center justify-center gap-2"><span class="w-6 h-px bg-forest"></span> Calendar</p>
      <h2 class="mt-3 sm:mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish">Academic Calendar 2026/2027</h2>
      <p class="mt-3 sm:mt-4 text-muted leading-relaxed text-sm sm:text-base">Important dates for the upcoming academic year. Stay informed and plan ahead.</p>
    </div>
    <div class="mt-10 sm:mt-14 grid md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
      <div class="bg-white rounded-3xl p-6 sm:p-8 card-hover border-l-4 border-lime">
        <div class="flex items-center gap-3 text-forest">
          <i data-lucide="calendar" class="w-6 h-6"></i>
          <span class="font-bold text-lg">Term 1</span>
        </div>
        <ul class="mt-4 space-y-3 text-sm text-muted">
          <li class="flex justify-between border-b border-gray-50 pb-2"><span>Opening</span><span class="font-medium text-ink">Sept 14, 2026</span></li>
          <li class="flex justify-between border-b border-gray-50 pb-2"><span>Mid-term break</span><span class="font-medium text-ink">Oct 19–23, 2026</span></li>
          <li class="flex justify-between border-b border-gray-50 pb-2"><span>Closing</span><span class="font-medium text-ink">Dec 11, 2026</span></li>
          <li class="flex justify-between"><span>Exams</span><span class="font-medium text-ink">Nov 30 – Dec 4</span></li>
        </ul>
      </div>
      <div class="bg-white rounded-3xl p-6 sm:p-8 card-hover border-l-4 border-lime">
        <div class="flex items-center gap-3 text-forest">
          <i data-lucide="calendar" class="w-6 h-6"></i>
          <span class="font-bold text-lg">Term 2</span>
        </div>
        <ul class="mt-4 space-y-3 text-sm text-muted">
          <li class="flex justify-between border-b border-gray-50 pb-2"><span>Opening</span><span class="font-medium text-ink">Jan 4, 2027</span></li>
          <li class="flex justify-between border-b border-gray-50 pb-2"><span>Mid-term break</span><span class="font-medium text-ink">Feb 15–19, 2027</span></li>
          <li class="flex justify-between border-b border-gray-50 pb-2"><span>Closing</span><span class="font-medium text-ink">Apr 2, 2027</span></li>
          <li class="flex justify-between"><span>Exams</span><span class="font-medium text-ink">Mar 22–26</span></li>
        </ul>
      </div>
      <div class="bg-white rounded-3xl p-6 sm:p-8 card-hover border-l-4 border-lime">
        <div class="flex items-center gap-3 text-forest">
          <i data-lucide="calendar" class="w-6 h-6"></i>
          <span class="font-bold text-lg">Term 3</span>
        </div>
        <ul class="mt-4 space-y-3 text-sm text-muted">
          <li class="flex justify-between border-b border-gray-50 pb-2"><span>Opening</span><span class="font-medium text-ink">Apr 26, 2027</span></li>
          <li class="flex justify-between border-b border-gray-50 pb-2"><span>Mid-term break</span><span class="font-medium text-ink">Jun 7–11, 2027</span></li>
          <li class="flex justify-between border-b border-gray-50 pb-2"><span>Closing</span><span class="font-medium text-ink">Jul 30, 2027</span></li>
          <li class="flex justify-between"><span>Exams</span><span class="font-medium text-ink">Jul 19–23</span></li>
        </ul>
      </div>
    </div>
    <div class="mt-8 text-center">
      <a href="#" class="inline-flex items-center gap-2 text-forest font-semibold hover:gap-3 transition-all text-sm">Download full calendar (PDF) <i data-lucide="download" class="w-4 h-4"></i></a>
    </div>
  </div>
</section>

<!-- ============ LATEST NEWS & EVENTS ============ -->
<section class="bg-white py-16 sm:py-24 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
    <div class="flex flex-wrap items-end justify-between gap-4 sm:gap-6">
      <h2 class="font-extrabold text-2xl sm:text-4xl tracking-tightish">Latest news &amp; events</h2>
      <a href="#" class="inline-flex items-center gap-1 text-sm font-semibold text-forest hover:gap-2 transition-all">View all <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
    </div>
    <div class="mt-10 sm:mt-12 grid md:grid-cols-3 gap-6 sm:gap-8">
      <article class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=500&q=80" alt="Graduation ceremony" class="w-full h-48 object-cover">
        <div class="p-5 sm:p-6">
          <span class="text-xs font-semibold text-forest bg-lime/30 px-3 py-1 rounded-full">Event</span>
          <h3 class="mt-3 font-semibold text-lg leading-snug">65th Speech &amp; Prize-Giving Day set for October</h3>
          <p class="mt-2 text-sm text-muted leading-relaxed">Parents and alumni are invited to celebrate another year of academic achievement on campus.</p>
        </div>
      </article>
      <article class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
        <img src="https://images.unsplash.com/photo-1596496181848-3091d4878b24?auto=format&fit=crop&w=500&q=80" alt="Students in science competition" class="w-full h-48 object-cover">
        <div class="p-5 sm:p-6">
          <span class="text-xs font-semibold text-forest bg-lime/30 px-3 py-1 rounded-full">News</span>
          <h3 class="mt-3 font-semibold text-lg leading-snug">Science club wins regional STEM challenge</h3>
          <p class="mt-2 text-sm text-muted leading-relaxed">Our General Science students placed first in the Ashanti Region inter-schools STEM competition.</p>
        </div>
      </article>
      <article class="bg-white border border-gray-100 rounded-3xl overflow-hidden card-hover">
        <img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?auto=format&fit=crop&w=500&q=80" alt="School sports day" class="w-full h-48 object-cover">
        <div class="p-5 sm:p-6">
          <span class="text-xs font-semibold text-forest bg-lime/30 px-3 py-1 rounded-full">Event</span>
          <h3 class="mt-3 font-semibold text-lg leading-snug">Inter-house sports competition kicks off</h3>
          <p class="mt-2 text-sm text-muted leading-relaxed">The four houses compete for the championship trophy this term on the main sports field.</p>
        </div>
      </article>
    </div>
  </div>
</section>

<!-- ============ DEPARTMENT HEADS ============ -->
<section id="leadership" class="bg-ivory py-16 sm:py-24 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
    <div class="text-center max-w-2xl mx-auto">
      <p class="text-sm font-semibold text-forest flex items-center justify-center gap-2"><span class="w-6 h-px bg-forest"></span> Leadership</p>
      <h2 class="mt-3 sm:mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish">Our department heads</h2>
      <p class="mt-3 sm:mt-4 text-muted leading-relaxed text-sm sm:text-base">Meet the academic leaders guiding each department toward excellence.</p>
    </div>
    <div class="mt-10 sm:mt-14 grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-7">
      <div class="text-center"><img src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=300&q=80" alt="Head of Academic Affairs" class="w-full h-40 sm:h-52 object-cover rounded-2xl"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mr. Kwame Owusu</h3><p class="text-xs sm:text-sm text-muted">Head of Academic Affairs</p></div>
      <div class="text-center"><img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=300&q=80" alt="Head of General Science" class="w-full h-40 sm:h-52 object-cover rounded-2xl"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mrs. Abena Frimpong</h3><p class="text-xs sm:text-sm text-muted">Head, General Science</p></div>
      <div class="text-center"><img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80" alt="Head of Business" class="w-full h-40 sm:h-52 object-cover rounded-2xl"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mr. Yaw Boateng</h3><p class="text-xs sm:text-sm text-muted">Head, Business</p></div>
      <div class="text-center"><img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=300&q=80" alt="Head of General Arts" class="w-full h-40 sm:h-52 object-cover rounded-2xl"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mrs. Akosua Darko</h3><p class="text-xs sm:text-sm text-muted">Head, General Arts</p></div>
      <div class="text-center"><img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?auto=format&fit=crop&w=300&q=80" alt="Head of Visual Arts" class="w-full h-40 sm:h-52 object-cover rounded-2xl"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mr. Kofi Mensah</h3><p class="text-xs sm:text-sm text-muted">Head, Visual Arts</p></div>
      <div class="text-center"><img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=300&q=80" alt="Head of Home Economics" class="w-full h-40 sm:h-52 object-cover rounded-2xl"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mrs. Efua Sarpong</h3><p class="text-xs sm:text-sm text-muted">Head, Home Economics</p></div>
      <div class="text-center"><img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=300&q=80" alt="Head of Agricultural Science" class="w-full h-40 sm:h-52 object-cover rounded-2xl"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mr. Samuel Antwi</h3><p class="text-xs sm:text-sm text-muted">Head, Agricultural Science</p></div>
      <div class="text-center"><img src="https://images.unsplash.com/photo-1580894732444-8ecded7900cd?auto=format&fit=crop&w=300&q=80" alt="Head of Guidance and Counselling" class="w-full h-40 sm:h-52 object-cover rounded-2xl"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mrs. Grace Appiah</h3><p class="text-xs sm:text-sm text-muted">Head, Guidance &amp; Counselling</p></div>
    </div>
  </div>
</section>

<!-- ============ PTA EXECUTIVES ============ -->
<section id="pta" class="bg-white py-16 sm:py-24 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
    <div class="text-center max-w-2xl mx-auto">
      <p class="text-sm font-semibold text-forest flex items-center justify-center gap-2"><span class="w-6 h-px bg-forest"></span> PTA</p>
      <h2 class="mt-3 sm:mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish">PTA executives</h2>
      <p class="mt-3 sm:mt-4 text-muted leading-relaxed text-sm sm:text-base">Parents and teachers working hand-in-hand for the good of every student.</p>
    </div>
    <div class="mt-10 sm:mt-14 grid sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-7">
      <div class="bg-ivory rounded-3xl p-5 sm:p-6 text-center card-hover"><img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=300&q=80" alt="PTA Chairman" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-full mx-auto"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mr. Emmanuel Ofori</h3><p class="text-xs sm:text-sm text-muted">PTA Chairman</p></div>
      <div class="bg-ivory rounded-3xl p-5 sm:p-6 text-center card-hover"><img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?auto=format&fit=crop&w=300&q=80" alt="PTA Vice Chairperson" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-full mx-auto"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mrs. Linda Asare</h3><p class="text-xs sm:text-sm text-muted">Vice Chairperson</p></div>
      <div class="bg-ivory rounded-3xl p-5 sm:p-6 text-center card-hover"><img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80" alt="PTA Secretary" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-full mx-auto"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mr. Daniel Kusi</h3><p class="text-xs sm:text-sm text-muted">Secretary</p></div>
      <div class="bg-ivory rounded-3xl p-5 sm:p-6 text-center card-hover"><img src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=300&q=80" alt="PTA Treasurer" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-full mx-auto"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mrs. Patricia Adjei</h3><p class="text-xs sm:text-sm text-muted">Treasurer</p></div>
      <div class="bg-ivory rounded-3xl p-5 sm:p-6 text-center card-hover"><img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=300&q=80" alt="PTA Financial Secretary" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-full mx-auto"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mr. Isaac Gyamfi</h3><p class="text-xs sm:text-sm text-muted">Financial Secretary</p></div>
      <div class="bg-ivory rounded-3xl p-5 sm:p-6 text-center card-hover"><img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=300&q=80" alt="PTA Public Relations Officer" class="w-20 h-20 sm:w-24 sm:h-24 object-cover rounded-full mx-auto"><h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base">Mrs. Joyce Amankwah</h3><p class="text-xs sm:text-sm text-muted">Public Relations Officer</p></div>
    </div>
  </div>
</section>

<!-- ============ CONNECT WITH US ============ -->
<section id="connect" class="bg-ivory py-16 sm:py-24 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
    <div class="text-center max-w-2xl mx-auto">
      <p class="text-sm font-semibold text-forest flex items-center justify-center gap-2"><span class="w-6 h-px bg-forest"></span> Social</p>
      <h2 class="mt-3 sm:mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish">Connect with us</h2>
      <p class="mt-3 sm:mt-4 text-muted leading-relaxed text-sm sm:text-base">Follow our journey and stay updated on campus life across our social channels.</p>
    </div>
    <div class="mt-10 sm:mt-14 grid md:grid-cols-3 gap-6 sm:gap-8">
      <!-- Facebook -->
      <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
        <div class="flex items-center justify-between px-5 sm:px-6 py-3 sm:py-4 border-b border-gray-100"><span class="flex items-center gap-2 font-semibold text-ink text-sm sm:text-base"><i data-lucide="facebook" class="w-4 h-4 sm:w-5 sm:h-5 text-forest"></i> Facebook</span><a href="#" class="text-xs font-semibold text-forest hover:underline">Follow</a></div>
        <div class="p-3 sm:p-4 space-y-3 sm:space-y-4">
          <div class="rounded-2xl overflow-hidden"><img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=500&q=80" alt="Facebook post: graduation day" class="w-full h-40 object-cover"><p class="text-sm text-muted p-2 sm:p-3">Congratulations to our graduating class! Proud of every one of you. 🎓</p></div>
          <div class="rounded-2xl overflow-hidden"><img src="https://images.unsplash.com/photo-1571260899304-425eee4c7efc?auto=format&fit=crop&w=500&q=80" alt="Facebook post: sports day" class="w-full h-40 object-cover"><p class="text-sm text-muted p-2 sm:p-3">Inter-house sports competition was a huge success this weekend.</p></div>
        </div>
      </div>
      <!-- TikTok -->
      <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
        <div class="flex items-center justify-between px-5 sm:px-6 py-3 sm:py-4 border-b border-gray-100"><span class="flex items-center gap-2 font-semibold text-ink text-sm sm:text-base"><i data-lucide="music-2" class="w-4 h-4 sm:w-5 sm:h-5 text-forest"></i> TikTok</span><a href="#" class="text-xs font-semibold text-forest hover:underline">Follow</a></div>
        <div class="p-3 sm:p-4 grid grid-cols-2 gap-2 sm:gap-3">
          <div class="relative rounded-2xl overflow-hidden aspect-[9/16]"><img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=300&q=80" alt="TikTok clip" class="w-full h-full object-cover"><span class="absolute bottom-2 left-2 bg-black/50 text-white text-[10px] px-2 py-0.5 rounded-full flex items-center gap-1"><i data-lucide="play" class="w-3 h-3"></i> 12.4k</span></div>
          <div class="relative rounded-2xl overflow-hidden aspect-[9/16]"><img src="https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=300&q=80" alt="TikTok clip" class="w-full h-full object-cover"><span class="absolute bottom-2 left-2 bg-black/50 text-white text-[10px] px-2 py-0.5 rounded-full flex items-center gap-1"><i data-lucide="play" class="w-3 h-3"></i> 8.1k</span></div>
          <div class="relative rounded-2xl overflow-hidden aspect-[9/16]"><img src="https://images.unsplash.com/photo-1596496181848-3091d4878b24?auto=format&fit=crop&w=300&q=80" alt="TikTok clip" class="w-full h-full object-cover"><span class="absolute bottom-2 left-2 bg-black/50 text-white text-[10px] px-2 py-0.5 rounded-full flex items-center gap-1"><i data-lucide="play" class="w-3 h-3"></i> 5.6k</span></div>
          <div class="relative rounded-2xl overflow-hidden aspect-[9/16]"><img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=300&q=80" alt="TikTok clip" class="w-full h-full object-cover"><span class="absolute bottom-2 left-2 bg-black/50 text-white text-[10px] px-2 py-0.5 rounded-full flex items-center gap-1"><i data-lucide="play" class="w-3 h-3"></i> 3.2k</span></div>
        </div>
      </div>
      <!-- Instagram -->
      <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
        <div class="flex items-center justify-between px-5 sm:px-6 py-3 sm:py-4 border-b border-gray-100"><span class="flex items-center gap-2 font-semibold text-ink text-sm sm:text-base"><i data-lucide="instagram" class="w-4 h-4 sm:w-5 sm:h-5 text-forest"></i> Instagram</span><a href="#" class="text-xs font-semibold text-forest hover:underline">Follow</a></div>
        <div class="p-3 sm:p-4 grid grid-cols-2 gap-2 sm:gap-3">
          <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=300&q=80" alt="Instagram post" class="w-full h-24 sm:h-28 object-cover rounded-2xl">
          <img src="https://images.unsplash.com/photo-1544717297-fa95b6ee9643?auto=format&fit=crop&w=300&q=80" alt="Instagram post" class="w-full h-24 sm:h-28 object-cover rounded-2xl">
          <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=300&q=80" alt="Instagram post" class="w-full h-24 sm:h-28 object-cover rounded-2xl">
          <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=300&q=80" alt="Instagram post" class="w-full h-24 sm:h-28 object-cover rounded-2xl">
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  // Hero slider
  const slides = document.querySelectorAll('.slide');
  const dotsContainer = document.getElementById('sliderDots');
  let current = 0;
  let autoTimer;

  if (slides.length && dotsContainer) {
    slides.forEach((_, i) => {
      const dot = document.createElement('button');
      dot.className = 'slide-dot w-2.5 h-2.5 rounded-full bg-white/40';
      dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
      dot.addEventListener('click', () => goTo(i));
      dotsContainer.appendChild(dot);
    });
    const dots = document.querySelectorAll('.slide-dot');

    function render() {
      slides.forEach((s, i) => s.classList.toggle('active', i === current));
      dots.forEach((d, i) => d.classList.toggle('active', i === current));
    }

    function goTo(i) {
      current = (i + slides.length) % slides.length;
      render();
      resetTimer();
    }

    function next() { goTo(current + 1); }
    function prev() { goTo(current - 1); }

    function resetTimer() {
      clearInterval(autoTimer);
      autoTimer = setInterval(next, 6000);
    }

    document.getElementById('nextSlide')?.addEventListener('click', next);
    document.getElementById('prevSlide')?.addEventListener('click', prev);

    render();
    resetTimer();
  }
</script>
@endpush