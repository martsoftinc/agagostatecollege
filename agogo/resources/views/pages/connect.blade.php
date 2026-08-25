
@extends('layout')

@section('title', 'Connect with Us — Agogo State College')

@section('content')
<!-- ============ CONNECT HERO ============ -->
<section class="bg-forest py-16 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
    <p class="text-sm font-semibold text-lime flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-lime"></span> Social
    </p>
    <h1 class="mt-4 font-extrabold text-3xl sm:text-5xl tracking-tightish text-white leading-tight">
      Connect with us
    </h1>
    <p class="mt-4 text-white/70 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
      Follow campus life on Facebook, TikTok and Instagram — and watch the latest posts below.
    </p>
  </div>
</section>

<!-- ============ CHANNEL LINKS ============ -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-12 sm:py-16">
  <div class="grid sm:grid-cols-3 gap-5 sm:gap-7">
    <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer"
      class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover flex items-center gap-4 group">
      <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center shrink-0 group-hover:bg-lime transition-colors">
        <i data-lucide="facebook" class="w-6 h-6"></i>
      </span>
      <div>
        <h2 class="font-bold text-ink">Facebook</h2>
        <p class="text-sm text-muted">@AgogoStateCollege</p>
        <p class="mt-1 text-xs font-semibold text-forest">Follow →</p>
      </div>
    </a>
    <a href="https://www.tiktok.com/" target="_blank" rel="noopener noreferrer"
      class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover flex items-center gap-4 group">
      <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center shrink-0 group-hover:bg-lime transition-colors">
        <i data-lucide="music-2" class="w-6 h-6"></i>
      </span>
      <div>
        <h2 class="font-bold text-ink">TikTok</h2>
        <p class="text-sm text-muted">@agogostatecollege</p>
        <p class="mt-1 text-xs font-semibold text-forest">Follow →</p>
      </div>
    </a>
    <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer"
      class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-7 card-hover flex items-center gap-4 group">
      <span class="w-12 h-12 rounded-xl bg-lime/30 text-forest flex items-center justify-center shrink-0 group-hover:bg-lime transition-colors">
        <i data-lucide="instagram" class="w-6 h-6"></i>
      </span>
      <div>
        <h2 class="font-bold text-ink">Instagram</h2>
        <p class="text-sm text-muted">@agogostatecollege</p>
        <p class="mt-1 text-xs font-semibold text-forest">Follow →</p>
      </div>
    </a>
  </div>
</section>

<!-- ============ LIVE FEEDS ============ -->
<section class="bg-ivory py-14 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">
    <div class="text-center max-w-2xl mx-auto mb-10 sm:mb-14">
      <p class="text-sm font-semibold text-forest flex items-center justify-center gap-2">
        <span class="w-6 h-px bg-forest"></span> Latest
      </p>
      <h2 class="mt-3 sm:mt-4 font-extrabold text-2xl sm:text-4xl tracking-tightish text-ink">
        From our channels
      </h2>
      <p class="mt-3 sm:mt-4 text-muted text-sm sm:text-base leading-relaxed">
        Live posts and clips from Facebook, TikTok and Instagram.
      </p>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 sm:gap-8">

      <!-- Facebook feed -->
      <article class="bg-white border border-gray-100 rounded-3xl overflow-hidden flex flex-col">
        <div class="flex items-center justify-between px-5 sm:px-6 py-3 sm:py-4 border-b border-gray-100">
          <span class="flex items-center gap-2 font-semibold text-ink text-sm sm:text-base">
            <i data-lucide="facebook" class="w-4 h-4 sm:w-5 sm:h-5 text-forest"></i> Facebook
          </span>
          <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold text-forest hover:underline">Follow</a>
        </div>
        <div class="flex-1 min-h-[420px] bg-ivory">
          {{-- Replace the href with the official school Facebook page URL --}}
          <iframe
            title="Agogo State College on Facebook"
            src="https://www.facebook.com/plugins/page.php?href={{ urlencode('https://www.facebook.com/facebook') }}&tabs=timeline&width=500&height=600&small_header=true&adapt_container_width=true&hide_cover=false&show_facepile=false"
            width="100%"
            height="600"
            style="border:none;overflow:hidden;width:100%;min-height:420px;"
            scrolling="no"
            frameborder="0"
            allowfullscreen="true"
            allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"
            class="w-full">
          </iframe>
        </div>
      </article>

      <!-- TikTok feed -->
      <article class="bg-white border border-gray-100 rounded-3xl overflow-hidden flex flex-col">
        <div class="flex items-center justify-between px-5 sm:px-6 py-3 sm:py-4 border-b border-gray-100">
          <span class="flex items-center gap-2 font-semibold text-ink text-sm sm:text-base">
            <i data-lucide="music-2" class="w-4 h-4 sm:w-5 sm:h-5 text-forest"></i> TikTok
          </span>
          <a href="https://www.tiktok.com/" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold text-forest hover:underline">Follow</a>
        </div>
        <div class="p-3 sm:p-4 flex-1">
          {{-- Official TikTok embed. Replace username after the school account is live. --}}
          <blockquote
            class="tiktok-embed"
            cite="https://www.tiktok.com/@tiktok"
            data-unique-id="tiktok"
            data-embed-type="creator"
            style="max-width:100%;min-width:0;">
            <section>
              <a target="_blank" rel="noopener noreferrer" href="https://www.tiktok.com/@tiktok">@agogostatecollege</a>
            </section>
          </blockquote>
        </div>
      </article>

      <!-- Instagram feed -->
      <article class="bg-white border border-gray-100 rounded-3xl overflow-hidden flex flex-col">
        <div class="flex items-center justify-between px-5 sm:px-6 py-3 sm:py-4 border-b border-gray-100">
          <span class="flex items-center gap-2 font-semibold text-ink text-sm sm:text-base">
            <i data-lucide="instagram" class="w-4 h-4 sm:w-5 sm:h-5 text-forest"></i> Instagram
          </span>
          <a href="https://www.instagram.com/" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold text-forest hover:underline">Follow</a>
        </div>
        <div class="p-3 sm:p-4 flex-1">
          {{-- LightWidget / official embed placeholder. Swap username when the account is ready. --}}
          <iframe
            title="Agogo State College on Instagram"
            src="https://www.instagram.com/instagram/embed"
            class="w-full rounded-2xl bg-ivory"
            style="border:0;min-height:520px;width:100%;"
            loading="lazy"
            allowtransparency="true">
          </iframe>
        </div>
      </article>

    </div>

    <p class="mt-8 text-center text-xs text-muted">
      Feeds load from Facebook, TikTok and Instagram. Update the profile URLs in this page when the official school handles are confirmed.
    </p>
  </div>
</section>
@endsection

@push('scripts')
<script async src="https://www.tiktok.com/embed.js"></script>
@endpush

