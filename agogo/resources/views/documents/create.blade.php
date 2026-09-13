@extends('teacher.layout')

@section('title', 'Upload Document - Agogo State College')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
  <a href="{{ route('documents.index') }}" class="text-slate-500 hover:text-slate-800 text-sm font-semibold flex items-center space-x-1">
    <i class="fa-solid fa-arrow-left"></i>
    <span>Back</span>
  </a>

  <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-200">
    <h1 class="text-xl font-extrabold text-slate-900 mb-6">Upload New Document</h1>

    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Title *</label>
        <input type="text" name="title" value="{{ old('title') }}" required
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-asc-green focus:border-transparent text-sm">
        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Description</label>
        <textarea name="description" rows="3"
                  class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-asc-green focus:border-transparent text-sm">{{ old('description') }}</textarea>
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">File *</label>
        <input type="file" name="file" required
               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.webp,.gif"
               class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-asc-green file:text-white file:font-semibold hover:file:bg-asc-green-dark">
        <p class="text-xs text-slate-400 mt-1">PDF, Word, Excel, PowerPoint, Images (max 20MB)</p>
        @error('file') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
      </div>

      <div>
        <label class="block text-xs font-bold uppercase tracking-wider text-slate-600 mb-1.5">Visibility *</label>
        <select name="visibility" required
                class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-asc-green focus:border-transparent text-sm">
          <option value="private" {{ old('visibility') === 'private' ? 'selected' : '' }}>Private</option>
          <option value="public" {{ old('visibility') === 'public' ? 'selected' : '' }}>Public</option>
        </select>
      </div>

      <div class="flex justify-end space-x-3 pt-2">
        <a href="{{ route('documents.index') }}"
           class="px-5 py-2.5 rounded-xl text-sm font-semibold text-slate-600 border border-slate-200 hover:bg-slate-50">
          Cancel
        </a>
        <button type="submit"
                class="px-5 py-2.5 rounded-xl text-sm font-bold bg-asc-green text-white hover:opacity-90 transition">
          Upload Document
        </button>
      </div>
    </form>
  </div>
</div>
@endsection