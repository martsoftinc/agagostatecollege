@extends('layout')

@section('title', 'Leadership — Agogo State College')

@section('content')
<!-- ============ LEADERSHIP HERO ============ -->
<section class="bg-forest py-16 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
    <p class="text-sm font-semibold text-lime flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-lime"></span> Leadership
    </p>
    <h1 class="mt-4 font-extrabold text-3xl sm:text-5xl tracking-tightish text-white leading-tight">
      Our school leadership
    </h1>
    <p class="mt-4 text-white/70 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
      Meet the headmistress and the academic leaders guiding each department.
    </p>
  </div>
</section>

<!-- ============ HEADMISTRESS ============ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
  <div class="grid lg:grid-cols-2 gap-10 sm:gap-16 items-center">
    <div>
      <img
        src="{{ asset('images/leaders/matilda.jpeg') }}"
        alt="Mrs. Matilda Gyamera, Headmistress of Agogo State College"
        class="w-full h-64 sm:h-[420px] lg:h-[480px] object-contain rounded-[2rem]"
        loading="lazy"
      >
    </div>
    <div>
      <p class="text-sm font-semibold text-forest flex items-center gap-2">
        <span class="w-6 h-px bg-forest"></span> Head of school
      </p>
      <h2 class="mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish leading-tight text-ink">
        Mrs. Matilda Gyamera
      </h2>
      <p class="mt-2 font-semibold text-forest text-base sm:text-lg">Headmistress</p>
      <p class="mt-5 text-muted leading-relaxed text-sm sm:text-base">
        Mrs. Matilda Gyamera leads Agogo State College with a focus on academic excellence, discipline and the welfare of every student. She oversees teaching, boarding life and partnership with parents through the PTA.
      </p>
      <p class="mt-3 text-muted leading-relaxed text-sm sm:text-base">
        Under her leadership the school continues to prepare young people for WASSCE and for service to Ghana and the world.
      </p>
      <a href="{{ url('/about') }}"
        class="mt-6 sm:mt-8 inline-flex items-center gap-2 bg-forest text-white font-semibold px-6 py-3 rounded-full hover:bg-forest-deep transition-colors text-sm sm:text-base">
        Read more about the school <i data-lucide="arrow-right" class="w-4 h-4"></i>
      </a>
    </div>
  </div>
</section>

<!-- ============ HEADMASTERS ============ -->
<section class="bg-ivory py-14 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
    <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
      <p class="text-sm font-semibold text-forest flex items-center justify-center gap-2">
        <span class="w-6 h-px bg-forest"></span> Senior Leadership
      </p>
      <h2 class="mt-3 sm:mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish text-ink">
        Headmasters
      </h2>
      <p class="mt-3 sm:mt-4 text-muted text-sm sm:text-base leading-relaxed">
        Supporting the Headmistress in the day-to-day running of the school.
      </p>
    </div>

    <div class="grid md:grid-cols-2 gap-8 sm:gap-10 max-w-5xl mx-auto">
      <!-- Headmaster 1 -->
      <div class="bg-white rounded-3xl border border-gray-100 p-6 sm:p-8 card-hover flex flex-col sm:flex-row gap-6 items-center sm:items-start text-center sm:text-left">
        <img
          src="{{ asset('images/leaders/assis3.jpeg') }}"
          alt="Mr. Kwesi Mensah"
          class="w-32 h-32 sm:w-36 sm:h-36 object-cover rounded-2xl shrink-0"
          loading="lazy"
        >
        <div>
          <h3 class="font-extrabold text-xl sm:text-2xl text-ink">Mr. William Berko </h3>
          <p class="mt-1 font-semibold text-forest">Assistant headmaster, administration </p>
          <p class="mt-3 text-muted text-sm sm:text-base leading-relaxed">
            Responsible for student discipline, boarding affairs and general administration. Works closely with House Masters to maintain a safe and orderly campus.
          </p>
        </div>
      </div>

      <!-- Headmaster 2 -->
      <div class="bg-white rounded-3xl border border-gray-100 p-6 sm:p-8 card-hover flex flex-col sm:flex-row gap-6 items-center sm:items-start text-center sm:text-left">
        <img
          src="{{ asset('images/leaders/assis2.jpeg') }}"
          alt="Mr. Isaac Osei"
          class="w-32 h-32 sm:w-36 sm:h-36 object-cover rounded-2xl shrink-0"
          loading="lazy"
        >
        <div>
          <h3 class="font-extrabold text-xl sm:text-2xl text-ink">Rev. Nicholas Marfo Budu</h3>
          <p class="mt-1 font-semibold text-forest">Assistant headmaster, academic </p>
          <p class="mt-3 text-muted text-sm sm:text-base leading-relaxed">
            Oversees academic coordination and staff welfare. Supports the Headmistress in curriculum delivery and teacher development programmes.
          </p>
        </div>
      </div>

      <!-- Headmaster 3 -->
      <div class="bg-white rounded-3xl border border-gray-100 p-6 sm:p-8 card-hover flex flex-col sm:flex-row gap-6 items-center sm:items-start text-center sm:text-left">
        <img
          src="{{ asset('images/leaders/assis1.jpeg') }}"
          alt="Mr. Isaac Osei"
          class="w-32 h-32 sm:w-36 sm:h-36 object-contain rounded-2xl shrink-0"
          loading="lazy"
        >
        <div>
          <h3 class="font-extrabold text-xl sm:text-2xl text-ink">Mr Kwame Siaw Kyei-Baffour</h3>
          <p class="mt-1 font-semibold text-forest">Assistant headmaster, domestic </p>
          <p class="mt-3 text-muted text-sm sm:text-base leading-relaxed">
            Oversees academic coordination and staff welfare. Supports the Headmistress in curriculum delivery and teacher development programmes.
          </p>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ============ DEPARTMENT HEADS ============ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
  <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
    <p class="text-sm font-semibold text-forest flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-forest"></span> Academics
    </p>
    <h2 class="mt-3 sm:mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish text-ink">
      Heads of department
    </h2>
    <p class="mt-3 sm:mt-4 text-muted text-sm sm:text-base leading-relaxed">
      The academic leaders guiding each department toward excellence.
    </p>
  </div>

  <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-7">
    <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
      <img src="{{ asset('images/leaders/vincent.jpeg') }}" alt="Head of Academic Affairs" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
      <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mr. VINCENT OSEI BOFFAH</h3>
      <p class="text-xs sm:text-sm text-muted">Mathematics Department HOD</p>
    </div>
    <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
      <img src="{{ asset('images/leaders/abu.jpeg') }}" alt="Head of General Science" class="w-full h-40 sm:h-52 object-contain rounded-2xl" loading="lazy">
      <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mr. ABU RAFIQ</h3>
      <p class="text-xs sm:text-sm text-muted">General Art Department HOD</p>
    </div>
    <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
      <img src="{{ asset('images/leaders/theresa.jpeg') }}" alt="Head of Business" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
      <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mrs. Theresa Oswell Mensah</h3>
      <p class="text-xs sm:text-sm text-muted">Home Economics Department </p>
    </div>
    <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
      <img src="{{ asset('images/leaders/anthony.jpeg') }}" alt="Head of General Arts" class="w-full h-40 sm:h-52 object-contain rounded-2xl" loading="lazy">
      <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mr. Anthony Abbey</h3>
      <p class="text-xs sm:text-sm text-muted">General Science Department HOD</p>
    </div>
    <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
      <img src="{{ asset('images/leaders/george.jpeg') }}" alt="Head of Visual Arts" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
      <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mr. George Botchway</h3>
      <p class="text-xs sm:text-sm text-muted">Business Department HOD</p>
    </div>
    <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
      <img src="{{ asset('images/leaders/stephen.jpeg') }}" alt="Head of Home Economics" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
      <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mr. Stephen Agyeman Bediako</h3>
      <p class="text-xs sm:text-sm text-muted">Languages Department- HOD</p>
    </div>
    <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
      <img src="{{ asset('images/leaders/sly.jpeg') }}" alt="Head of Agricultural Science" class="w-full h-40 sm:h-52 object-contain rounded-2xl" loading="lazy">
      <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mr. Sylvester Maama</h3>
      <p class="text-xs sm:text-sm text-muted">Visual Art Department - HOD</p>
    </div>
    <!--
    <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
      <img src="https://images.unsplash.com/photo-1580894732444-8ecded7900cd?auto=format&fit=crop&w=400&q=80" alt="Head of Guidance and Counselling" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
      <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mrs. Grace Appiah</h3>
      <p class="text-xs sm:text-sm text-muted">Head, Guidance &amp; Counselling</p>
    </div> -->
  </div>
</section>
@endsection