@extends('layout')

@section('title', 'News & Blog — Agogo State College')

@section('content')
<section class="bg-forest py-16 sm:py-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
    <p class="text-lime font-semibold text-sm uppercase tracking-wider mb-3">School News</p>
    <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tightish">
      News & Events
    </h1>
    <p class="mt-4 text-white/70 max-w-2xl mx-auto">
      Stay informed with the latest announcements, achievements and events from Agogo State College.
    </p>
  </div>
</section>

<section class="py-14 sm:py-20 bg-ivory">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10">

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
      @forelse($posts as $post)
        <a href="{{ route('blog.show', $post->slug) }}" class="group block">
          <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 card-hover h-full flex flex-col">
            <div class="relative overflow-hidden">
              @if($post->featured_image)
                <img src="{{ $post->featured_image_url }}"
                     alt="{{ $post->title }}"
                     class="card-img group-hover:scale-105 transition-transform duration-500">
              @else
                <div class="card-img bg-forest/10 flex items-center justify-center">
                  <i data-lucide="newspaper" class="w-12 h-12 text-forest/30"></i>
                </div>
              @endif
              <div class="absolute top-3 left-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-lime text-forest-deep">
                  {{ $post->published_at?->format('d M Y') }}
                </span>
              </div>
            </div>

            <div class="p-5 sm:p-6 flex flex-col flex-1">
              <h2 class="text-lg font-bold text-ink leading-snug group-hover:text-forest transition-colors line-clamp-2">
                {{ $post->title }}
              </h2>
              <p class="mt-2 text-sm text-muted line-clamp-3 flex-1">
                {{ $post->excerpt ?? Str::limit(strip_tags($post->body), 120) }}
              </p>
              <div class="mt-4 flex items-center gap-2 text-sm font-semibold text-forest">
                Read more
                <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
              </div>
            </div>
          </article>
        </a>
      @empty
        <div class="col-span-full text-center py-20 text-muted">
          <i data-lucide="newspaper" class="w-14 h-14 mx-auto mb-4 opacity-40"></i>
          <p class="text-lg font-medium">No posts published yet.</p>
        </div>
      @endforelse
    </div>

    {{-- Pagination --}}
    @if($posts->hasPages())
      <div class="mt-12 flex justify-center">
        {{ $posts->links() }}
      </div>
    @endif
  </div>
</section>
@endsection