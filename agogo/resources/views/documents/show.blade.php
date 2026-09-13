@extends('teacher.layout')

@section('title', $document->title . ' - Document')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
  <a href="{{ route('documents.index') }}" class="text-slate-500 hover:text-slate-800 text-sm font-semibold flex items-center space-x-1">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>

  <!-- Header Card -->
  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
    <div class="flex flex-col md:flex-row md:items-start justify-between gap-4">
      <div>
        <div class="flex items-center space-x-2 mb-2">
          <span class="text-xs font-extrabold uppercase px-2.5 py-1 rounded-md bg-slate-100 text-slate-700">
            {{ strtoupper($document->extension) }}
          </span>
          <span class="text-xs font-bold {{ $document->visibility === 'public' ? 'text-emerald-600' : 'text-amber-600' }}">
            {{ ucfirst($document->visibility) }}
          </span>
        </div>
        <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">{{ $document->title }}</h1>
        @if($document->description)
          <p class="text-sm text-slate-600 mt-2">{{ $document->description }}</p>
        @endif
        <p class="text-xs text-slate-500 mt-2">
          Uploaded by {{ $document->author?->name ?? 'Unknown' }} on {{ $document->created_at->format('M d, Y') }}
          • {{ number_format($document->file_size / 1024, 1) }} KB
        </p>
      </div>

      <div class="flex items-center space-x-2 flex-shrink-0">
        <a href="{{ route('documents.download', $document) }}"
           class="px-4 py-2 rounded-xl bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs transition flex items-center space-x-1.5">
          <i class="fa-solid fa-download"></i>
          <span>Download</span>
        </a>

        @if($document->user_id === auth()->id())
          <button onclick="document.getElementById('shareModal').classList.remove('hidden')"
                  class="px-3.5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs transition flex items-center space-x-1">
            <i class="fa-solid fa-share-nodes"></i>
            <span>Share</span>
          </button>
        @endif

        @can('update', $document)
          <a href="{{ route('documents.edit', $document) }}"
             class="px-3.5 py-2 rounded-xl bg-asc-yellow hover:bg-asc-yellow-hover text-slate-900 font-bold text-xs transition flex items-center space-x-1">
            <i class="fa-solid fa-pen"></i>
            <span>Edit</span>
          </a>
        @endcan
      </div>
    </div>
  </div>

  <!-- Shared With -->
  @if($document->user_id === auth()->id() && $document->sharedWithUsers->count() > 0)
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
      <h2 class="text-sm font-extrabold uppercase tracking-wider text-slate-400 border-b border-slate-100 pb-2 mb-4">
        Shared With
      </h2>
      <div class="flex flex-wrap gap-2">
        @foreach($document->sharedWithUsers as $teacher)
          <div class="inline-flex items-center space-x-2 px-3 py-1.5 rounded-full bg-slate-100 text-xs font-semibold text-slate-700">
            <i class="fa-solid fa-user text-slate-400"></i>
            <span>{{ $teacher->name }}</span>
            <span class="px-1.5 py-0.5 rounded text-[10px] uppercase
              {{ $teacher->pivot->permission === 'download' ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-200 text-slate-600' }}">
              {{ $teacher->pivot->permission }}
            </span>
          </div>
        @endforeach
      </div>
    </div>
  @endif

  <!-- Share Modal -->
  @if($document->user_id === auth()->id())
  <div id="shareModal" class="fixed inset-0 z-50 bg-slate-900/50 backdrop-blur-sm hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 space-y-4 shadow-xl">
      <div class="flex items-center justify-between border-b border-slate-100 pb-3">
        <h3 class="font-bold text-slate-900 text-base">Share Document</h3>
        <button type="button" onclick="document.getElementById('shareModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <form action="{{ route('documents.share', $document) }}" method="POST" class="space-y-4">
        @csrf

        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-2">Select Teachers</label>
          <div class="max-h-56 overflow-y-auto space-y-2 border border-slate-200 p-2 rounded-xl">
            @forelse($availableTeachers as $teacher)
              @php
                $alreadyShared = $document->sharedWithUsers->contains('id', $teacher->id);
                $currentPermission = $alreadyShared
                    ? $document->sharedWithUsers->firstWhere('id', $teacher->id)->pivot->permission
                    : 'download';
              @endphp
              <div class="flex items-center justify-between p-2 rounded-lg hover:bg-slate-50">
                <label class="flex items-center space-x-2 cursor-pointer flex-1">
                  <input type="checkbox"
                         name="users[{{ $teacher->id }}][user_id]"
                         value="{{ $teacher->id }}"
                         {{ $alreadyShared ? 'checked' : '' }}
                         class="rounded text-asc-green focus:ring-asc-green">
                  <span class="text-xs font-semibold text-slate-700">{{ $teacher->name }}</span>
                </label>
                <select name="users[{{ $teacher->id }}][permission]"
                        class="text-xs border border-slate-200 rounded-lg px-2 py-1 focus:ring-asc-green">
                  <option value="view" {{ $currentPermission === 'view' ? 'selected' : '' }}>View</option>
                  <option value="download" {{ $currentPermission === 'download' ? 'selected' : '' }}>Download</option>
                </select>
              </div>
            @empty
              <p class="text-xs text-slate-400 p-2">No other teachers available.</p>
            @endforelse
          </div>
        </div>

        <div class="flex justify-end space-x-2 pt-2">
          <button type="button" onclick="document.getElementById('shareModal').classList.add('hidden')"
                  class="px-4 py-2 rounded-xl text-xs font-semibold text-slate-600 border border-slate-200">
            Cancel
          </button>
          <button type="submit" class="px-4 py-2 rounded-xl text-xs font-bold bg-asc-green text-white hover:opacity-90 transition">
            Save Permissions
          </button>
        </div>
      </form>
    </div>
  </div>
  @endif
</div>
@endsection