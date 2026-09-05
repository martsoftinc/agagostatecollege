@extends('admin.layout')

@section('title', 'Edit Blog Post')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-extrabold text-slate-800">Edit Post</h1>
      <p class="text-sm text-slate-500 mt-1">{{ $post->title }}</p>
    </div>
    <a href="{{ route('admin.posts.index') }}" class="text-sm text-slate-500 hover:text-asc-green">
      ← Back to list
    </a>
  </div>

  <form action="{{ route('admin.posts.update', $post) }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8 space-y-6">
    @csrf
    @method('PUT')

    {{-- Title --}}
    <div>
      <label class="block text-sm font-semibold text-slate-700 mb-1.5">Title <span class="text-rose-500">*</span></label>
      <input type="text" name="title" value="{{ old('title', $post->title) }}" required
             class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30">
      @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Excerpt --}}
    <div>
      <label class="block text-sm font-semibold text-slate-700 mb-1.5">Excerpt</label>
      <textarea name="excerpt" rows="2"
                class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30">{{ old('excerpt', $post->excerpt) }}</textarea>
    </div>

    {{-- Featured Image --}}
    <div>
      <label class="block text-sm font-semibold text-slate-700 mb-1.5">Featured Image</label>
      <div class="flex items-start gap-4">
        @if($post->featured_image)
          <div class="relative">
            <img src="{{ $post->featured_image_url }}" class="w-32 h-32 rounded-xl object-cover border border-slate-200">
            <label class="absolute -top-2 -right-2 bg-rose-500 text-white w-6 h-6 rounded-full flex items-center justify-center cursor-pointer text-xs shadow">
              <input type="checkbox" name="remove_featured" value="1" class="sr-only" onchange="this.form.submit()">
              <i class="fa-solid fa-xmark"></i>
            </label>
          </div>
        @endif
        <div class="flex-1">
          <input type="file" name="featured_image" accept="image/*"
                 class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0 file:text-sm file:font-semibold
                        file:bg-asc-green/10 file:text-asc-green hover:file:bg-asc-green/20">
          <p class="text-xs text-slate-400 mt-1.5">Leave empty to keep current image</p>
        </div>
      </div>
    </div>

    {{-- Body --}}
    <div>
      <label class="block text-sm font-semibold text-slate-700 mb-1.5">Content <span class="text-rose-500">*</span></label>
      <textarea name="body" id="body" rows="14">{{ old('body', $post->body) }}</textarea>
    </div>

    {{-- Status --}}
    <div class="grid sm:grid-cols-2 gap-5">
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30">
          <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Publish Date</label>
        <input type="datetime-local" name="published_at"
               value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}"
               class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30">
      </div>
    </div>

    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
      <a href="{{ route('admin.posts.index') }}"
         class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 font-medium transition">
        Cancel
      </a>
      <button type="submit"
              class="px-6 py-2.5 rounded-xl bg-asc-green hover:bg-asc-green-dark text-white font-semibold transition shadow-sm">
        Update Post
      </button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/yyeujrowqm65c8s0mt70zmqybaovbzn7x2e06abi4cps7dui/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  tinymce.init({
    selector: '#body',
    apiKey: 'yyeujrowqm65c8s0mt70zmqybaovbzn7x2e06abi4cps7dui',
    height: 480,
    menubar: false,
    plugins: 'lists link image media table code fullscreen preview',
    toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | table | code fullscreen',
    content_style: 'body { font-family: Inter, system-ui, sans-serif; font-size: 15px; }',
    
    images_upload_url: '{{ route("admin.posts.upload-image") }}',
    automatic_uploads: true,
    images_upload_credentials: true,
    file_picker_types: 'image',

    // CSRF-safe image upload handler
    images_upload_handler: function (blobInfo, progress) {
      return new Promise(function (resolve, reject) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("admin.posts.upload-image") }}');
        
        // Send CSRF token
        xhr.setRequestHeader('X-CSRF-TOKEN', document.querySelector('meta[name="csrf-token"]').content);
        
        xhr.onload = function () {
          if (xhr.status === 403) {
            reject({ message: 'HTTP Error: ' + xhr.status, remove: true });
            return;
          }
          if (xhr.status < 200 || xhr.status >= 300) {
            reject('HTTP Error: ' + xhr.status);
            return;
          }
          const json = JSON.parse(xhr.responseText);
          if (!json || typeof json.location !== 'string') {
            reject('Invalid JSON: ' + xhr.responseText);
            return;
          }
          resolve(json.location);
        };
        
        xhr.onerror = function () {
          reject('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
        };
        
        const formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        
        xhr.send(formData);
      });
    },

    relative_urls: false,
    remove_script_host: false,
    convert_urls: true,
  });
</script>
@endpush