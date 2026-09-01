@extends('layout')

@section('title', 'About Us — Agogo State College')

@section('content')
<!-- ============ ABOUT HERO ============ -->
<section class="bg-forest py-16 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
    <p class="text-sm font-semibold text-lime flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-lime"></span> Who we are
    </p>
    <h1 class="mt-4 font-extrabold text-3xl sm:text-5xl tracking-tightish text-white leading-tight">
      About Agogo State College
    </h1>
    <p class="mt-4 text-white/70 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
      A legacy built on discipline, faith and academic excellence since 1958.
    </p>
  </div>
</section>

<!-- ============ HISTORY ============ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
  <div class="grid lg:grid-cols-2 gap-10 sm:gap-16 items-center">
    <div>
      <p class="text-sm font-semibold text-forest flex items-center gap-2">
        <span class="w-6 h-px bg-forest"></span> Our story
      </p>
      <h2 class="mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish leading-tight text-ink">
        A proud history since 1958
      </h2>
      <p class="mt-4 sm:mt-5 text-muted leading-relaxed text-sm sm:text-base">
        Founded in 1958, Agogo State College began as a small day school with a clear purpose: to educate and form young people of character. Over more than six decades, it has grown into one of the Ashanti Region's most respected boarding senior high schools.
      </p>
      <p class="mt-3 sm:mt-4 text-muted leading-relaxed text-sm sm:text-base">
        Generations of leaders, professionals and change-makers have passed through our gates. Today we remain committed to the same ideals — academic excellence, discipline, service and faith — while preparing students for WASSCE and life beyond the classroom.
      </p>
      <div class="mt-6 sm:mt-8 flex flex-wrap gap-6 sm:gap-10">
        <div>
          <p class="text-forest font-extrabold text-2xl sm:text-3xl">65+</p>
          <p class="text-muted text-xs sm:text-sm mt-1">Years of excellence</p>
        </div>
        <div>
          <p class="text-forest font-extrabold text-2xl sm:text-3xl">2,400+</p>
          <p class="text-muted text-xs sm:text-sm mt-1">Students</p>
        </div>
        <div>
          <p class="text-forest font-extrabold text-2xl sm:text-3xl">120+</p>
          <p class="text-muted text-xs sm:text-sm mt-1">Teaching staff</p>
        </div>
      </div>
    </div>
    <div>
      <img
        src="https://scontent.facc6-1.fna.fbcdn.net/v/t39.30808-6/469569531_886609433678394_1892076476991391087_n.jpg?stp=dst-jpg_tt6&cstp=mx1440x1084&ctp=s1440x1084&_nc_cat=105&ccb=1-7&_nc_sid=3a1ebe&_nc_eui2=AeFJg_4crS62S3o_MiRcj4GBf6sA3nTJjdN_qwDedMmN0zapdhOlCdzMZNFUHdA2W6WJZGQWfXCS1YNvHJoGDW-k&_nc_ohc=qvjLpzjr6-MQ7kNvwGVdtAS&_nc_oc=Ado14wud3FKf3kXccoZBJFAXpOxfjLPO5wZ4wRXrAEphsjB3NxVVzI-JatW3lfqbyss&_nc_zt=23&_nc_ht=scontent.facc6-1.fna&_nc_gid=yUalrY2xeDSBWh-29ApmGw&_nc_ss=7b2a8&oh=00_AQJudo_3iXL4GMmqZlkHH9pYKU9JVm8vQNscrixp_XD5nQ&oe=6A9C6B50"
        alt="Agogo State College campus and students"
        class="w-full h-64 sm:h-[400px] lg:h-[440px] object-cover rounded-[2rem]"
        loading="lazy"
      >
    </div>
  </div>
</section>

<!-- ============ MISSION & VISION ============ -->
<section class="bg-ivory py-14 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
    <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
      <p class="text-sm font-semibold text-forest flex items-center justify-center gap-2">
        <span class="w-6 h-px bg-forest"></span> Purpose
      </p>
      <h2 class="mt-3 sm:mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish text-ink">
        Mission &amp; Vision
      </h2>
    </div>
    <div class="grid md:grid-cols-2 gap-6 sm:gap-8">
      <article class="bg-white rounded-3xl p-7 sm:p-9 card-hover border border-gray-100">
        <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
          <i data-lucide="target" class="w-6 h-6"></i>
        </span>
        <h3 class="mt-5 font-bold text-xl text-ink">Our Mission</h3>
        <p class="mt-3 text-muted text-sm sm:text-base leading-relaxed">
          To provide quality, values-driven secondary education that develops disciplined, innovative and God-fearing citizens ready to serve Ghana and the world.
        </p>
      </article>
      <article class="bg-white rounded-3xl p-7 sm:p-9 card-hover border border-gray-100">
        <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
          <i data-lucide="eye" class="w-6 h-6"></i>
        </span>
        <h3 class="mt-5 font-bold text-xl text-ink">Our Vision</h3>
        <p class="mt-3 text-muted text-sm sm:text-base leading-relaxed">
          To be a leading centre of academic and moral excellence in Ghana — a school where character and learning grow together.
        </p>
      </article>
    </div>
  </div>
</section>

<!-- ============ CORE VALUES ============ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
  <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
    <p class="text-sm font-semibold text-forest flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-forest"></span> What we stand for
    </p>
    <h2 class="mt-3 sm:mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish text-ink">
      Our core values
    </h2>
    <p class="mt-3 sm:mt-4 text-muted text-sm sm:text-base leading-relaxed">
      These principles guide every student, teacher and member of our school community.
    </p>
  </div>
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-7">
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="award" class="w-5 h-5"></i>
      </span>
      <h3 class="mt-5 font-bold text-lg text-ink">Excellence</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">
        We pursue the highest standards in academics, character and every area of school life.
      </p>
    </article>
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="shield" class="w-5 h-5"></i>
      </span>
      <h3 class="mt-5 font-bold text-lg text-ink">Discipline</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">
        Self-control, respect for rules and personal responsibility shape our daily life on campus.
      </p>
    </article>
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="heart" class="w-5 h-5"></i>
      </span>
      <h3 class="mt-5 font-bold text-lg text-ink">Integrity</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">
        Honesty and fairness guide our words, work and relationships with one another.
      </p>
    </article>
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="hand-heart" class="w-5 h-5"></i>
      </span>
      <h3 class="mt-5 font-bold text-lg text-ink">Service</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">
        We learn to put others first and to use our gifts for the good of the community and nation.
      </p>
    </article>
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="book-open" class="w-5 h-5"></i>
      </span>
      <h3 class="mt-5 font-bold text-lg text-ink">Faith</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">
        God-fearing values underpin our education and the formation of the whole person.
      </p>
    </article>
    <article class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover">
      <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
        <i data-lucide="users" class="w-5 h-5"></i>
      </span>
      <h3 class="mt-5 font-bold text-lg text-ink">Community</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed">
        Students, staff, parents and alumni work together as one Agogo State College family.
      </p>
    </article>
  </div>
</section>

<!-- ============ HEADMISTRESS ============ -->
<section class="bg-ivory py-14 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
    <div class="grid lg:grid-cols-2 gap-10 sm:gap-16 items-start">
      <div>
        <img
          src="https://scontent.facc6-1.fna.fbcdn.net/v/t39.30808-6/468908155_18035816873366738_6237712593345399938_n.jpg?stp=dst-jpg_tt6&cstp=mx1440x960&ctp=s1440x960&_nc_cat=102&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeHJJROcPjEMh5zNnthfPFxGIkuBnV50IpMiS4GdXnQik7036zV0-RmHPACIkypC7eaGHfKZEeRJ0eeCQ6tknKkx&_nc_ohc=eUu_fg16V9YQ7kNvwGjgOcS&_nc_oc=Adpn-umZOq7Qc_gJqBQmWka21S8EUKaaSDfIYdikS3KsCWppVECkEPmp-XhsHBONEV8&_nc_zt=23&_nc_ht=scontent.facc6-1.fna&_nc_gid=WVcwkJXUJ9QJphtxXrEBlQ&_nc_ss=7b2a8&oh=00_AQKgxzDmt1shbF2ga3gVUJgQFcEPO5N7KBDHX_eYiPgQDg&oe=6A9C6BE0"
          alt="Mrs. Comfort Asante-Boateng, Headmistress of Agogo State College"
          class="w-full h-64 sm:h-[400px] lg:h-[480px] object-cover rounded-[2rem]"
          loading="lazy"
        >
      </div>
      <div>
        <p class="text-sm font-semibold text-forest flex items-center gap-2">
          <span class="w-6 h-px bg-forest"></span> Leadership
        </p>
        <h2 class="mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish leading-tight text-ink">
          Meet our Headmistress
        </h2>
        <p class="mt-2 font-semibold text-forest text-base sm:text-lg">
          Mrs. Comfort Asante-Boateng
        </p>
        <p class="text-sm text-muted">Headmistress, Agogo State College</p>
        <p class="mt-5 sm:mt-6 text-muted leading-relaxed text-sm sm:text-base">
          On behalf of the staff, students and management of Agogo State College, I welcome you to our school community. For over six decades, we have nurtured young people into disciplined, confident and knowledgeable citizens ready to serve Ghana and the world.
        </p>
        <p class="mt-3 sm:mt-4 text-muted leading-relaxed text-sm sm:text-base">
          Our doors are open to every learner who is willing to work hard, respect others, and pursue excellence. I invite you to explore our programmes, meet our staff, and consider Agogo State College as the place where your child's future begins.
        </p>
        <p class="mt-5 sm:mt-6 text-muted leading-relaxed text-sm sm:text-base">
          Under her leadership, the college continues to strengthen academic performance, boarding welfare and partnership with parents through the PTA, while upholding the values that have defined the school since 1958.
        </p>
        <a
          href="{{ url('/contact') }}"
          class="mt-6 sm:mt-8 inline-flex items-center gap-2 bg-forest text-white font-semibold px-6 py-3 rounded-full hover:bg-forest-deep transition-colors text-sm sm:text-base"
        >
          Get in touch <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </a>
      </div>
    </div>
  </div>
</section>
@endsection