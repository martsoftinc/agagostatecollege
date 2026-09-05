@extends('layout')

@section('title', $post->title . ' — Agogo State College')

@section('content')
{{-- Hero / Featured Image --}}
<section class="bg-forest">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-10 pt-12 sm:pt-16 pb-10">
    <a href="{{ route('blog.index') }}"
       class="inline-flex items-center gap-2 text-white/70 hover:text-lime text-sm font-medium mb-6 transition-colors">
      <i data-lucide="arrow-left" class="w-4 h-4"></i>
      Back to all posts
    </a>

    <p class="text-lime text-sm font-semibold mb-3">
      {{ $post->published_at?->format('d F Y') }}
      @if($post->author)
        · by {{ $post->author->name }}
      @endif
    </p>

    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tightish leading-tight">
      {{ $post->title }}
    </h1>

    @if($post->excerpt)
      <p class="mt-4 text-white/70 text-lg max-w-3xl">
        {{ $post->excerpt }}
      </p>
    @endif
  </div>
</section>

{{-- Featured Image --}}
@if($post->featured_image)
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-10 -mt-6 sm:-mt-8 relative z-10">
    <img src="{{ $post->featured_image_url }}"
         alt="{{ $post->title }}"
         class="w-full rounded-2xl shadow-xl object-cover max-h-[480px]">
  </div>
@endif

{{-- Body Content --}}
<section class="py-12 sm:py-16">
  <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-10">
    <article class="prose prose-lg prose-headings:text-ink prose-a:text-forest prose-img:rounded-xl max-w-none">
      {!! $post->body !!}
    </article>

    {{-- Previous / Next --}}
    <div class="mt-14 pt-10 border-t border-gray-200 flex flex-col sm:flex-row gap-6 justify-between">
      @if($previous)
        <a href="{{ route('blog.show', $previous->slug) }}"
           class="group flex-1 p-5 rounded-2xl border border-gray-200 hover:border-forest/30 hover:bg-forest/5 transition">
          <p class="text-xs font-semibold text-muted uppercase tracking-wider mb-1">Previous</p>
          <p class="font-semibold text-ink group-hover:text-forest line-clamp-2">{{ $previous->title }}</p>
        </a>
      @else
        <div class="flex-1"></div>
      @endif

      @if($next)
        <a href="{{ route('blog.show', $next->slug) }}"
           class="group flex-1 p-5 rounded-2xl border border-gray-200 hover:border-forest/30 hover:bg-forest/5 transition text-right">
          <p class="text-xs font-semibold text-muted uppercase tracking-wider mb-1">Next</p>
          <p class="font-semibold text-ink group-hover:text-forest line-clamp-2">{{ $next->title }}</p>
        </a>
      @endif
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
  /* Make images inside the post body look good */
  .prose img {
    border-radius: 0.75rem;
    margin-top: 1.5rem;
    margin-bottom: 1.5rem;
  }
  .prose p {
    margin-bottom: 1.25rem;
    line-height: 1.75;
  }
</style>
@endpush