@extends('admin.layout')

@section('title', 'Subjects Management - Agogo State College')

@push('scripts')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
<div x-data="{ 
    editModal: false,
    deleteModal: false,
    deleteUrl: '',
    deleteItemName: '',
    activeSubject: { id: '', name: '', code: '', category: '', is_active: 1 },
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
        Subjects Management
      </h2>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Create and manage all subjects offered in the school.
      </p>
    </div>
  </section>

  {{-- ALERTS --}}
  @if(session('success'))
    <div class="mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl flex items-center justify-between">
      <span>{{ session('success') }}</span>
      <i class="fa-solid fa-circle-check text-emerald-600"></i>
    </div>
  @endif
  @if(session('error'))
    <div class="mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-xl flex items-center justify-between">
      <span>{{ session('error') }}</span>
      <i class="fa-solid fa-triangle-exclamation text-rose-600"></i>
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">

    <!-- ADD SUBJECT FORM -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
      <h3 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Add New Subject</h3>
      <form action="{{ route('admin.subjects.store') }}" method="POST" class="space-y-4">
        @csrf
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Subject Name</label>
          <input type="text" name="name" placeholder="e.g. Core Mathematics" required
                 class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Subject Code</label>
          <input type="text" name="code" placeholder="e.g. CMAT"
                 class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Category</label>
          <select name="category" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            <option value="Core">Core</option>
            <option value="Elective">Elective</option>
          </select>
        </div>
        <button type="submit" class="w-full py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition">
          Save Subject
        </button>
      </form>
    </div>

    <!-- SUBJECTS LIST -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="p-5 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-bold text-slate-900 text-base">All Subjects</h3>
      </div>
      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-slate-100/70 border-b border-slate-200 text-[11px] uppercase font-bold text-slate-500 tracking-wider">
              <th class="py-3 px-5">Subject</th>
              <th class="py-3 px-5">Code</th>
              <th class="py-3 px-5">Category</th>
              <th class="py-3 px-5">Status</th>
              <th class="py-3 px-5 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
            @forelse($subjects as $subject)
              <tr class="hover:bg-slate-50/80 transition">
                <td class="py-3.5 px-5 font-bold text-slate-900">{{ $subject->name }}</td>
                <td class="py-3.5 px-5">{{ $subject->code ?? '—' }}</td>
                <td class="py-3.5 px-5">
                  <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold
                    {{ $subject->category === 'Core' ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                    {{ $subject->category ?? '—' }}
                  </span>
                </td>
                <td class="py-3.5 px-5">
                  <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase
                    {{ $subject->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                    {{ $subject->is_active ? 'Active' : 'Inactive' }}
                  </span>
                </td>
                <td class="py-3.5 px-5 text-right flex justify-end gap-1.5">
                  <button type="button"
                    @click="activeSubject = {
                      id: '{{ $subject->id }}',
                      name: '{{ $subject->name }}',
                      code: '{{ $subject->code }}',
                      category: '{{ $subject->category }}',
                      is_active: '{{ $subject->is_active }}'
                    }; editModal = true"
                    class="px-2.5 py-1 bg-slate-100 hover:bg-asc-green hover:text-white text-slate-700 font-semibold rounded-md transition text-[11px]">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                  </button>
                  <button type="button"
                    @click="confirmDelete('{{ route('admin.subjects.destroy', $subject->id) }}', '{{ $subject->name }}')"
                    class="px-2.5 py-1 bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 font-semibold rounded-md transition text-[11px]">
                    <i class="fa-solid fa-trash"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="py-8 text-center text-slate-400 text-xs">No subjects created yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- EDIT MODAL -->
  <div x-show="editModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div @click.away="editModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-md overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
        <h3 class="font-bold text-slate-900 text-sm">Edit Subject</h3>
        <button @click="editModal = false" class="text-slate-400 hover:text-slate-600">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>
      <form :action="'{{ url('admin/subjects') }}/' + activeSubject.id" method="POST" class="p-6 space-y-4">
        @csrf
        @method('PUT')
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Subject Name</label>
          <input type="text" name="name" x-model="activeSubject.name" required
                 class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Subject Code</label>
          <input type="text" name="code" x-model="activeSubject.code"
                 class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Category</label>
          <select name="category" x-model="activeSubject.category"
                  class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            <option value="Core">Core</option>
            <option value="Elective">Elective</option>
          </select>
        </div>
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Status</label>
          <select name="is_active" x-model="activeSubject.is_active"
                  class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            <option value="1">Active</option>
            <option value="0">Inactive</option>
          </select>
        </div>
        <div class="flex justify-end gap-2 pt-2">
          <button type="button" @click="editModal = false"
                  class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-asc-green text-white text-xs font-bold rounded-xl">Update Subject</button>
        </div>
      </form>
    </div>
  </div>

  <!-- DELETE CONFIRMATION MODAL -->
  <div x-show="deleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div @click.away="deleteModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-sm p-6 text-center">
      <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-lg">
        <i class="fa-solid fa-triangle-exclamation"></i>
      </div>
      <h3 class="font-bold text-slate-900 text-base mb-1">Confirm Deletion</h3>
      <p class="text-xs text-slate-500 mb-6">
        Are you sure you want to delete <strong x-text="deleteItemName"></strong>?
      </p>
      <form :action="deleteUrl" method="POST" class="flex gap-3">
        @csrf
        @method('DELETE')
        <button type="button" @click="deleteModal = false"
                class="w-1/2 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl">Cancel</button>
        <button type="submit" class="w-1/2 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl">Delete</button>
      </form>
    </div>
  </div>

</div>
@endsection