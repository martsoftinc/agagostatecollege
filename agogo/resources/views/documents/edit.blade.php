@extends('teacher.layout')

@section('title', 'Edit Document - Agogo State College')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
  <a href="{{ route('documents.show', $document) }}" class="text-slate-500 hover:text-slate-800 text-sm font-semibold flex items-center space-x-1">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>

  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
    <h1 class="text-xl font-extrabold text-slate-900 mb-6">Edit Document</h1>

    <form action="{{ route('documents.update', $document) }}" method="POST" class="space-y-5">
      @csrf
      @method('PUT')

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Title *</label>
        <input type="text" name="title" value="{{ old('title', $document->title) }}" required
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-asc-green focus:border-transparent text-sm">
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Description</label>
        <textarea name="description" rows="3"
                  class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-asc-green focus:border-transparent text-sm">{{ old('description', $document->description) }}</textarea>
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Visibility *</label>
        <select name="visibility" required
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-asc-green focus:border-transparent text-sm">
          <option value="private" {{ old('visibility', $document->visibility) === 'private' ? 'selected' : '' }}>Private</option>
          <option value="public" {{ old('visibility', $document->visibility) === 'public' ? 'selected' : '' }}>Public</option>
        </select>
      </div>

      <div class="bg-slate-50 p-3 rounded-xl text-xs text-slate-500">
        Current file: <strong>{{ $document->original_name }}</strong> ({{ number_format($document->file_size / 1024, 1) }} KB)
        <br>To replace the file, delete this document and upload a new one.
      </div>

      <div class="flex justify-end space-x-3 pt-2">
        <a href="{{ route('documents.show', $document) }}"
           class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50">
          Cancel
        </a>
        <button type="submit"
                class="px-5 py-2.5 rounded-xl text-sm font-bold bg-asc-green text-white hover:opacity-90 transition">
          Update Document
        </button>
      </div>
    </form>
  </div>
</div>
@endsection