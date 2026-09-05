@extends('admin.layout') 
@section('title', 'Blog Posts')

@section('content')
<div class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-extrabold text-slate-800">Blog / News</h1>
      <p class="text-sm text-slate-500 mt-1">Manage school news, announcements and blog posts</p>
    </div>
    <a href="{{ route('admin.posts.create') }}"
       class="inline-flex items-center gap-2 bg-asc-green hover:bg-asc-green-dark text-white font-semibold px-5 py-2.5 rounded-xl transition shadow-sm">
      <i class="fa-solid fa-plus"></i>
      New Post
    </a>
  </div>

  {{-- Flash --}}
  @if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl text-sm">
      {{ session('success') }}
    </div>
  @endif

  {{-- Table --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 border-b border-slate-200">
          <tr>
            <th class="text-left px-5 py-3.5 font-semibold text-slate-600">Post</th>
            <th class="text-left px-5 py-3.5 font-semibold text-slate-600 hidden md:table-cell">Author</th>
            <th class="text-left px-5 py-3.5 font-semibold text-slate-600">Status</th>
            <th class="text-left px-5 py-3.5 font-semibold text-slate-600 hidden lg:table-cell">Date</th>
            <th class="text-right px-5 py-3.5 font-semibold text-slate-600">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($posts as $post)
            <tr class="hover:bg-slate-50/70 transition">
              <td class="px-5 py-4">
                <div class="flex items-center gap-3">
                  @if($post->featured_image)
                    <img src="{{ $post->featured_image_url }}"
                         alt=""
                         class="w-14 h-14 rounded-xl object-cover border border-slate-200">
                  @else
                    <div class="w-14 h-14 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400">
                      <i class="fa-solid fa-image"></i>
                    </div>
                  @endif
                  <div>
                    <p class="font-semibold text-slate-800 line-clamp-1">{{ $post->title }}</p>
                    <p class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ $post->excerpt ?? Str::limit(strip_tags($post->body), 60) }}</p>
                  </div>
                </div>
              </td>
              <td class="px-5 py-4 hidden md:table-cell text-slate-600">
                {{ $post->author->name ?? '—' }}
              </td>
              <td class="px-5 py-4">
                @if($post->status === 'published')
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                    Published
                  </span>
                @else
                  <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                    Draft
                  </span>
                @endif
              </td>
              <td class="px-5 py-4 hidden lg:table-cell text-slate-500 text-xs">
                {{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}
              </td>
              <td class="px-5 py-4 text-right">
                <div class="flex items-center justify-end gap-2">
                  <a href="{{ route('admin.posts.edit', $post) }}"
                     class="p-2 rounded-lg text-slate-500 hover:text-asc-green hover:bg-asc-green/10 transition"
                     title="Edit">
                    <i class="fa-solid fa-pen-to-square"></i>
                  </a>
                  <form action="{{ route('admin.posts.destroy', $post) }}" method="POST"
                        onsubmit="return confirm('Move this post to trash?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-rose-50 transition"
                            title="Delete">
                      <i class="fa-solid fa-trash-can"></i>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-5 py-16 text-center text-slate-400">
                <i class="fa-solid fa-newspaper text-4xl mb-3 opacity-40"></i>
                <p class="font-medium">No blog posts yet</p>
                <p class="text-sm mt-1">Create your first post to get started</p>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($posts->hasPages())
      <div class="px-5 py-4 border-t border-slate-100">
        {{ $posts->links() }}
      </div>
    @endif
  </div>
</div>
@endsection