@extends('admin.layout')

@section('title', 'Create Blog Post')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

  <div class="flex items-center justify-between">
    <div>
      <h1 class="text-2xl font-extrabold text-slate-800">New Blog Post</h1>
      <p class="text-sm text-slate-500 mt-1">Write news or announcements for the school community</p>
    </div>
    <a href="{{ route('admin.posts.index') }}" class="text-sm text-slate-500 hover:text-asc-green">
      ← Back to list
    </a>
  </div>

  <form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data"
        class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8 space-y-6">
    @csrf

    {{-- Title --}}
    <div>
      <label class="block text-sm font-semibold text-slate-700 mb-1.5">Title <span class="text-rose-500">*</span></label>
      <input type="text" name="title" value="{{ old('title') }}" required
             class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30"
             placeholder="Enter post title">
      @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Excerpt --}}
    <div>
      <label class="block text-sm font-semibold text-slate-700 mb-1.5">Excerpt (optional)</label>
      <textarea name="excerpt" rows="2"
                class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30"
                placeholder="Short summary shown on the listing page">{{ old('excerpt') }}</textarea>
    </div>

    {{-- Featured Image --}}
    <div>
      <label class="block text-sm font-semibold text-slate-700 mb-1.5">Featured Image</label>
      <div class="flex items-start gap-4">
        <div id="featured-preview" class="hidden w-32 h-32 rounded-xl overflow-hidden border border-slate-200">
          <img src="" class="w-full h-full object-cover" id="featured-img">
        </div>
        <div class="flex-1">
          <input type="file" name="featured_image" accept="image/*" id="featured_input"
                 class="block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4
                        file:rounded-lg file:border-0 file:text-sm file:font-semibold
                        file:bg-asc-green/10 file:text-asc-green hover:file:bg-asc-green/20">
          <p class="text-xs text-slate-400 mt-1.5">JPG, PNG or WebP. Max 4 MB. Recommended 1200×630px.</p>
        </div>
      </div>
      @error('featured_image') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Body (TinyMCE) --}}
    <div>
      <label class="block text-sm font-semibold text-slate-700 mb-1.5">Content <span class="text-rose-500">*</span></label>
      <textarea name="body" id="body" rows="14">{{ old('body') }}</textarea>
      @error('body') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Status + Publish Date --}}
    <div class="grid sm:grid-cols-2 gap-5">
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30">
          <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
          <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">Publish Date (optional)</label>
        <input type="datetime-local" name="published_at" value="{{ old('published_at') }}"
               class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30">
      </div>
    </div>

    {{-- Actions --}}
    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
      <a href="{{ route('admin.posts.index') }}"
         class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 font-medium transition">
        Cancel
      </a>
      <button type="submit"
              class="px-6 py-2.5 rounded-xl bg-asc-green hover:bg-asc-green-dark text-white font-semibold transition shadow-sm">
        Create Post
      </button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/yyeujrowqm65c8s0mt70zmqybaovbzn7x2e06abi4cps7dui/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  // Featured image preview
  document.getElementById('featured_input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function(ev) {
        document.getElementById('featured-img').src = ev.target.result;
        document.getElementById('featured-preview').classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    }
  });

  tinymce.init({
  selector: '#body',
  apiKey: 'yyeujrowqm65c8s0mt70zmqybaovbzn7x2e06abi4cps7dui',
  height: 480,
  menubar: false,
  plugins: 'lists link image media table code fullscreen preview',
  toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link image media | table | code fullscreen',
  content_style: 'body { font-family: Inter, system-ui, sans-serif; font-size: 15px; }',
  
  // Image upload settings
  images_upload_url: '{{ route("admin.posts.upload-image") }}',
  automatic_uploads: true,
  images_upload_credentials: true,
  file_picker_types: 'image',
  
  // ===== ADD THESE TWO LINES =====
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
  // ===============================

  relative_urls: false,
  remove_script_host: false,
  convert_urls: true,
});
</script>
@endpush