
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
        src="https://scontent.facc6-1.fna.fbcdn.net/v/t39.30808-6/468908155_18035816873366738_6237712593345399938_n.jpg?stp=dst-jpg_tt6&cstp=mx1440x960&ctp=s1440x960&_nc_cat=102&ccb=1-7&_nc_sid=127cfc&_nc_eui2=AeHJJROcPjEMh5zNnthfPFxGIkuBnV50IpMiS4GdXnQik7036zV0-RmHPACIkypC7eaGHfKZEeRJ0eeCQ6tknKkx&_nc_ohc=eUu_fg16V9YQ7kNvwGjgOcS&_nc_oc=Adpn-umZOq7Qc_gJqBQmWka21S8EUKaaSDfIYdikS3KsCWppVECkEPmp-XhsHBONEV8&_nc_zt=23&_nc_ht=scontent.facc6-1.fna&_nc_gid=WVcwkJXUJ9QJphtxXrEBlQ&_nc_ss=7b2a8&oh=00_AQKgxzDmt1shbF2ga3gVUJgQFcEPO5N7KBDHX_eYiPgQDg&oe=6A9C6BE0"
        alt="Mrs. Comfort Asante-Boateng, Headmistress of Agogo State College"
        class="w-full h-64 sm:h-[420px] lg:h-[480px] object-cover rounded-[2rem]"
        loading="lazy"
      >
    </div>
    <div>
      <p class="text-sm font-semibold text-forest flex items-center gap-2">
        <span class="w-6 h-px bg-forest"></span> Head of school
      </p>
      <h2 class="mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish leading-tight text-ink">
        Mrs. Comfort Asante-Boateng
      </h2>
      <p class="mt-2 font-semibold text-forest text-base sm:text-lg">Headmistress</p>
      <p class="mt-5 text-muted leading-relaxed text-sm sm:text-base">
        Mrs. Asante-Boateng leads Agogo State College with a focus on academic excellence, discipline and the welfare of every student. She oversees teaching, boarding life and partnership with parents through the PTA.
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

<!-- ============ DEPARTMENT HEADS ============ -->
<section class="bg-ivory py-14 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
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
        <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=400&q=80" alt="Head of Academic Affairs" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
        <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mr. Kwame Owusu</h3>
        <p class="text-xs sm:text-sm text-muted">Head of Academic Affairs</p>
      </div>
      <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
        <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=400&q=80" alt="Head of General Science" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
        <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mrs. Abena Frimpong</h3>
        <p class="text-xs sm:text-sm text-muted">Head, General Science</p>
      </div>
      <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=400&q=80" alt="Head of Business" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
        <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mr. Yaw Boateng</h3>
        <p class="text-xs sm:text-sm text-muted">Head, Business</p>
      </div>
      <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=400&q=80" alt="Head of General Arts" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
        <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mrs. Akosua Darko</h3>
        <p class="text-xs sm:text-sm text-muted">Head, General Arts</p>
      </div>
      <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
        <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?auto=format&fit=crop&w=400&q=80" alt="Head of Visual Arts" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
        <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mr. Kofi Mensah</h3>
        <p class="text-xs sm:text-sm text-muted">Head, Visual Arts</p>
      </div>
      <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=400&q=80" alt="Head of Home Economics" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
        <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mrs. Efua Sarpong</h3>
        <p class="text-xs sm:text-sm text-muted">Head, Home Economics</p>
      </div>
      <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
        <img src="https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?auto=format&fit=crop&w=400&q=80" alt="Head of Agricultural Science" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
        <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mr. Samuel Antwi</h3>
        <p class="text-xs sm:text-sm text-muted">Head, Agricultural Science</p>
      </div>
      <div class="text-center bg-white rounded-3xl p-4 sm:p-5 border border-gray-100 card-hover">
        <img src="https://images.unsplash.com/photo-1580894732444-8ecded7900cd?auto=format&fit=crop&w=400&q=80" alt="Head of Guidance and Counselling" class="w-full h-40 sm:h-52 object-cover rounded-2xl" loading="lazy">
        <h3 class="mt-3 sm:mt-4 font-semibold text-sm sm:text-base text-ink">Mrs. Grace Appiah</h3>
        <p class="text-xs sm:text-sm text-muted">Head, Guidance &amp; Counselling</p>
      </div>
    </div>
  </div>
</section>
@endsection
