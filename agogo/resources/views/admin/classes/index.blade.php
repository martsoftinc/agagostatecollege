@extends('admin.layout')

@section('title', 'Class & Stream Management - Agogo State College')

@push('scripts')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')

<div x-data="{ 
    editClassModal: false, 
    editStreamModal: false, 
    editClassStreamModal: false,
    deleteModal: false,
    deleteUrl: '',
    deleteItemName: '',
    activeClass: { id: '', name: '', code: '', level_order: '' },
    activeStream: { id: '', name: '', category: '' },
    activeClassStream: { id: '', school_class_id: '', stream_id: '', teacher_id: '', capacity: '', is_active: 1 },
    confirmDelete(url, name) {
        this.deleteUrl = url;
        this.deleteItemName = name;
        this.deleteModal = true;
    }
}">

  <!-- HEADER -->
  <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Classes & Streams Setup
      </h2>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Configure class levels, academic streams, and assign active class tutors.
      </p>
    </div>
  </section>

    


  {{-- ALERTS --}}
  @if(session('success'))
    <div class="mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl flex items-center justify-between">
      <span>{{ session('success') }}</span>
      <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
    </div>
  @endif

  @if(session('error'))
    <div class="mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-xl flex items-center justify-between">
      <span>{{ session('error') }}</span>
      <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base"></i>
    </div>
  @endif

  <!-- CREATION FORMS GRID -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">

    <!-- FORM 1: Add Class Level -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
      <div>
        <h3 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">1. Add Class Level</h3>
        <form action="{{ route('admin.classes.store') }}" method="POST" class="space-y-4">
          @csrf
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Class Name</label>
            <input type="text" name="name" placeholder="e.g. SHS 1" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Class Code</label>
            <input type="text" name="code" placeholder="e.g. SHS1" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Level Order</label>
            <input type="number" name="level_order" value="1" min="1" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>
          <button type="submit" class="w-full py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition">
            Save Class Level
          </button>
        </form>
      </div>

      <!-- Quick Edit & Delete Badges for Classes -->
      <div class="mt-6 pt-4 border-t border-slate-100">
        <p class="text-[11px] font-bold text-slate-400 uppercase mb-2">Existing Classes</p>
        <div class="flex flex-wrap gap-1.5">
          @foreach($classes as $c)
            <div class="inline-flex items-center bg-slate-100 rounded-lg overflow-hidden border border-slate-200/60">
              <button 
                type="button"
                @click="activeClass = { id: '{{ $c->id }}', name: '{{ $c->name }}', code: '{{ $c->code }}', level_order: '{{ $c->level_order }}' }; editClassModal = true"
                class="px-2.5 py-1 text-slate-700 hover:bg-slate-200 font-semibold text-xs transition flex items-center gap-1">
                <span>{{ $c->name }}</span>
                <i class="fa-solid fa-pen text-[9px] text-slate-400"></i>
              </button>
              <button 
                type="button"
                @click="confirmDelete('{{ route('admin.classes.destroy', $c->id) }}', 'Class {{ $c->name }}')"
                class="px-1.5 py-1 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border-l border-slate-200 transition">
                <i class="fa-solid fa-trash text-[10px]"></i>
              </button>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- FORM 2: Add Academic Stream -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
      <div>
        <h3 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">2. Add Academic Stream</h3>
        <form action="{{ route('admin.streams.store') }}" method="POST" class="space-y-4">
          @csrf
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Stream Name</label>
            <input type="text" name="name" placeholder="e.g. General Science 1" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Category / Department</label>
            <select name="category" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
              <option value="General Science">General Science</option>
              <option value="Business">Business</option>
              <option value="General Arts">General Arts</option>
              <option value="Visual Arts">Visual Arts</option>
              <option value="Home Economics">Home Economics</option>
              <option value="Agricultural Science">Agricultural Science</option>
            </select>
          </div>
          <button type="submit" class="w-full py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition">
            Save Stream
          </button>
        </form>
      </div>

      <!-- Quick Edit & Delete Badges for Streams -->
      <div class="mt-6 pt-4 border-t border-slate-100">
        <p class="text-[11px] font-bold text-slate-400 uppercase mb-2">Existing Streams</p>
        <div class="flex flex-wrap gap-1.5 max-h-24 overflow-y-auto">
          @foreach($streams as $s)
            <div class="inline-flex items-center bg-slate-100 rounded-lg overflow-hidden border border-slate-200/60">
              <button 
                type="button"
                @click="activeStream = { id: '{{ $s->id }}', name: '{{ $s->name }}', category: '{{ $s->category }}' }; editStreamModal = true"
                class="px-2.5 py-1 text-slate-700 hover:bg-slate-200 font-semibold text-xs transition flex items-center gap-1">
                <span>{{ $s->name }}</span>
                <i class="fa-solid fa-pen text-[9px] text-slate-400"></i>
              </button>
              <button 
                type="button"
                @click="confirmDelete('{{ route('admin.streams.destroy', $s->id) }}', 'Stream {{ $s->name }}')"
                class="px-1.5 py-1 text-slate-400 hover:text-rose-600 hover:bg-rose-50 border-l border-slate-200 transition">
                <i class="fa-solid fa-trash text-[10px]"></i>
              </button>
            </div>
          @endforeach
        </div>
      </div>
    </div>

    <!-- FORM 3: Assign Stream to Class -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
      <h3 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">3. Assign Stream to Class</h3>
      <form action="{{ route('admin.class-streams.assign') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Class Level</label>
          <select name="school_class_id" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            @foreach($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Stream</label>
          <select name="stream_id" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            @foreach($streams as $stream)
              <option value="{{ $stream->id }}">{{ $stream->name }} ({{ $stream->category }})</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Class Tutor</label>
          <select name="teacher_id" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            <option value="">-- Assign Teacher --</option>
            @foreach($teachers as $teacher)
              <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Capacity</label>
          <input type="number" name="capacity" value="60" min="1" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>
        <button type="submit" class="w-full py-2.5 bg-asc-yellow hover:bg-asc-yellow-hover text-asc-green-dark font-extrabold text-xs rounded-xl transition">
          Create Class Combination
        </button>
      </form>
    </div>

  </div>

  <!-- OVERVIEW TABLE -->
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mt-8">
    <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
      <div>
        <h3 class="font-bold text-slate-900 text-base">Active School Classes</h3>
        <p class="text-xs text-slate-500">Live view of configured class & stream assignments</p>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-100/70 border-b border-slate-200 text-[11px] uppercase font-bold text-slate-500 tracking-wider">
            <th class="py-3 px-5">Class Combination</th>
            <th class="py-3 px-5">Category</th>
            <th class="py-3 px-5">Class Tutor</th>
            <th class="py-3 px-5">Enrolled / Capacity</th>
            <th class="py-3 px-5">Status</th>
            <th class="py-3 px-5 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
          @forelse($classStreams as $cs)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="py-3.5 px-5 font-bold text-slate-900">
                {{ $cs->schoolClass->name }} {{ $cs->stream->name }}
              </td>
              <td class="py-3.5 px-5">
                <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold rounded-md text-[11px]">
                  {{ $cs->stream->category ?? 'General' }}
                </span>
              </td>
              <td class="py-3.5 px-5">
                {{ $cs->teacher->name ?? 'Unassigned' }}
              </td>
              <td class="py-3.5 px-5 font-semibold text-slate-900">
                {{ $cs->students_count }} / {{ $cs->capacity }}
              </td>
              <td class="py-3.5 px-5">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $cs->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                  {{ $cs->is_active ? 'Active' : 'Inactive' }}
                </span>
              </td>
              <td class="py-3.5 px-5 text-right flex justify-end items-center gap-1.5">


                <!-- ✅ ADD THIS BUTTON HERE (inside the loop) -->
                <a href="{{ route('admin.class-streams.subjects', $cs->id) }}"
                  class="px-2.5 py-1 bg-blue-50 hover:bg-blue-600 hover:text-white text-blue-700 font-semibold rounded-md transition text-[11px] inline-flex items-center gap-1">
                  <i class="fa-solid fa-book"></i>
                  <span>Subjects</span>
                </a>

                <button 
                  type="button"
                  @click="activeClassStream = { 
                    id: '{{ $cs->id }}', 
                    school_class_id: '{{ $cs->school_class_id }}', 
                    stream_id: '{{ $cs->stream_id }}', 
                    teacher_id: '{{ $cs->teacher_id }}', 
                    capacity: '{{ $cs->capacity }}', 
                    is_active: '{{ $cs->is_active }}' 
                  }; editClassStreamModal = true"
                  class="px-2.5 py-1 bg-slate-100 hover:bg-asc-green hover:text-white text-slate-700 font-semibold rounded-md transition text-[11px] inline-flex items-center gap-1">
                  <i class="fa-solid fa-pen-to-square"></i>
                  <span>Edit</span>
                </button>

                <button 
                  type="button"
                  @click="confirmDelete('{{ route('admin.class-streams.destroy', $cs->id) }}', '{{ $cs->schoolClass->name }} {{ $cs->stream->name }}')"
                  class="px-2.5 py-1 bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 font-semibold rounded-md transition text-[11px] inline-flex items-center gap-1">
                  <i class="fa-solid fa-trash"></i>
                  <span>Delete</span>
                </button>

                
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                No class combinations created yet. Assign streams above.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

  <!-- ========================================================= -->
  <!-- MODAL: DELETE SOFT-CONFIRMATION -->
  <!-- ========================================================= -->
  <div x-show="deleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div @click.away="deleteModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden p-6 text-center">
      <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-lg">
        <i class="fa-solid fa-triangle-exclamation"></i>
      </div>
      <h3 class="font-bold text-slate-900 text-base mb-1">Confirm Deletion</h3>
      <p class="text-xs text-slate-500 mb-6">
        Are you sure you want to delete <strong class="text-slate-800" x-text="deleteItemName"></strong>? This action cannot be undone.
      </p>
      
      <form :action="deleteUrl" method="POST" class="flex items-center gap-3">
        @csrf
        @method('DELETE')
        <button type="button" @click="deleteModal = false" class="w-1/2 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
          Cancel
        </button>
        <button type="submit" class="w-1/2 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
          Delete
        </button>
      </form>
    </div>
  </div>

  <!-- EDIT MODALS (Class, Stream, ClassStream) REMAIN INTACT... -->
  <!-- Edit Class Modal -->
  <div x-show="editClassModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div @click.away="editClassModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
        <h3 class="font-bold text-slate-900 text-sm">Edit Class Level</h3>
        <button @click="editClassModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form :action="'{{ url('admin/classes') }}/' + activeClass.id" method="POST" class="p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Class Name</label>
          <input type="text" name="name" x-model="activeClass.name" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Class Code</label>
          <input type="text" name="code" x-model="activeClass.code" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Level Order</label>
          <input type="number" name="level_order" x-model="activeClass.level_order" min="1" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>
        <div class="flex items-center justify-end gap-2 pt-2">
          <button type="button" @click="editClassModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-asc-green text-white text-xs font-bold rounded-xl">Update Class</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit Stream Modal -->
  <div x-show="editStreamModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div @click.away="editStreamModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
        <h3 class="font-bold text-slate-900 text-sm">Edit Academic Stream</h3>
        <button @click="editStreamModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form :action="'{{ url('admin/streams') }}/' + activeStream.id" method="POST" class="p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Stream Name</label>
          <input type="text" name="name" x-model="activeStream.name" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Category / Department</label>
          <select name="category" x-model="activeStream.category" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            <option value="General Science">General Science</option>
            <option value="Business">Business</option>
            <option value="General Arts">General Arts</option>
            <option value="Visual Arts">Visual Arts</option>
            <option value="Home Economics">Home Economics</option>
            <option value="Agricultural Science">Agricultural Science</option>
          </select>
        </div>
        <div class="flex items-center justify-end gap-2 pt-2">
          <button type="button" @click="editStreamModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-asc-green text-white text-xs font-bold rounded-xl">Update Stream</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Edit ClassStream Modal -->
  <div x-show="editClassStreamModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div @click.away="editClassStreamModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
        <h3 class="font-bold text-slate-900 text-sm">Edit Class Assignment</h3>
        <button @click="editClassStreamModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
      </div>
      <form :action="'{{ url('admin/class-streams') }}/' + activeClassStream.id" method="POST" class="p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Class Level</label>
          <select name="school_class_id" x-model="activeClassStream.school_class_id" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            @foreach($classes as $class)
              <option value="{{ $class->id }}">{{ $class->name }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Stream</label>
          <select name="stream_id" x-model="activeClassStream.stream_id" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            @foreach($streams as $stream)
              <option value="{{ $stream->id }}">{{ $stream->name }} ({{ $stream->category }})</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Class Tutor</label>
          <select name="teacher_id" x-model="activeClassStream.teacher_id" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            <option value="">-- Assign Teacher --</option>
            @foreach($teachers as $teacher)
              <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
            @endforeach
          </select>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Capacity</label>
          <input type="number" name="capacity" x-model="activeClassStream.capacity" min="1" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status</label>
          <select name="is_active" x-model="activeClassStream.is_active" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
          </select>
        </div>
        <div class="flex items-center justify-end gap-2 pt-2">
          <button type="button" @click="editClassStreamModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-asc-yellow text-asc-green-dark text-xs font-extrabold rounded-xl">Update Assignment</button>
        </div>
      </form>
    </div>
  </div>

</div>

@endsection