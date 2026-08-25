@extends('layout')

@section('title', 'Contact Us — Agogo State College')

@section('content')
<!-- ============ CONTACT HERO ============ -->
<section class="bg-forest py-16 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
    <p class="text-sm font-semibold text-lime flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-lime"></span> Get in touch
    </p>
    <h1 class="mt-4 font-extrabold text-3xl sm:text-5xl tracking-tightish text-white leading-tight">
      Contact Agogo State College
    </h1>
    <p class="mt-4 text-white/70 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
      Reach us by phone or email. We are happy to assist with admissions, visits, and general enquiries.
    </p>
  </div>
</section>

<!-- ============ CONTACT DETAILS ============ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-14 sm:py-20">
  <div class="grid md:grid-cols-2 gap-6 sm:gap-8 mb-12 sm:mb-16">
    <!-- Phone -->
    <a href="tel:+233244000000" class="bg-white border border-gray-100 rounded-3xl p-7 sm:p-8 card-hover flex items-start gap-5 group">
      <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center shrink-0 group-hover:bg-lime transition-colors">
        <i data-lucide="phone" class="w-5 h-5"></i>
      </span>
      <div>
        <h2 class="font-bold text-lg sm:text-xl text-ink">Phone</h2>
        <p class="mt-1 text-muted text-sm">Call us during office hours</p>
        <p class="mt-3 font-semibold text-forest text-base sm:text-lg">+233 24 400 0000</p>
      </div>
    </a>

    <!-- Email -->
    <a href="mailto:info@agogostatecollege.edu.gh" class="bg-white border border-gray-100 rounded-3xl p-7 sm:p-8 card-hover flex items-start gap-5 group">
      <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center shrink-0 group-hover:bg-lime transition-colors">
        <i data-lucide="mail" class="w-5 h-5"></i>
      </span>
      <div>
        <h2 class="font-bold text-lg sm:text-xl text-ink">Email</h2>
        <p class="mt-1 text-muted text-sm">Send us a message anytime</p>
        <p class="mt-3 font-semibold text-forest text-base sm:text-lg break-all">info@agogostatecollege.edu.gh</p>
      </div>
    </a>
  </div>

  <!-- Address + Map -->
  <div class="bg-ivory rounded-3xl overflow-hidden">
    <div class="p-6 sm:p-8 border-b border-gray-100">
      <div class="flex items-start gap-4">
        <span class="w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center shrink-0">
          <i data-lucide="map-pin" class="w-5 h-5"></i>
        </span>
        <div>
          <h2 class="font-bold text-lg sm:text-xl text-ink">Campus location</h2>
          <p class="mt-1 text-muted text-sm sm:text-base leading-relaxed">
            Agogo State College<br>
            Agogo, Ashanti Region<br>
            Ghana
          </p>
        </div>
      </div>
    </div>
    <div class="w-full h-[320px] sm:h-[420px] lg:h-[480px]">
      <iframe
        title="Agogo State College location map"
        src="https://www.google.com/maps?q=Agogo,+Ashanti+Region,+Ghana&output=embed"
        width="100%"
        height="100%"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"
        class="w-full h-full block">
      </iframe>
    </div>
  </div>
</section>
@endsection