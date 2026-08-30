@extends('admin.layout')

@section('title', 'Manage Subjects - ' . $classStream->full_name)

@push('scripts')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
<div x-data="{ deleteModal: false, deleteUrl: '', deleteItemName: '' }">

  <!-- HEADER -->
  <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <div class="flex items-center gap-2 text-xs text-slate-500 mb-1">
        <a href="{{ route('admin.classes.index') }}" class="hover:text-asc-green">Classes & Streams</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span>Manage Subjects</span>
      </div>
      <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        {{ $classStream->schoolClass->name }} {{ $classStream->stream->name }}
      </h2>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Assign and manage subjects for this class combination
      </p>
    </div>
    <a href="{{ route('admin.classes.index') }}"
       class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
      <i class="fa-solid fa-arrow-left"></i> Back to Classes
    </a>
  </section>

  {{-- ALERTS --}}
  @if(session('success'))
    <div class="mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl">
      {{ session('success') }}
    </div>
  @endif
  @if(session('error'))
    <div class="mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-xl">
      {{ session('error') }}
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">

    <!-- ASSIGN NEW SUBJECT -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
      <h3 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Assign Subject</h3>

      @if($availableSubjects->count() > 0)
        <form action="{{ route('admin.class-streams.assign-subject', $classStream->id) }}" method="POST" class="space-y-4">
          @csrf
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Subject</label>
            <select name="subject_id" required
                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
              <option value="">-- Choose Subject --</option>
              @foreach($availableSubjects as $subject)
                <option value="{{ $subject->id }}">
                  {{ $subject->name }} {{ $subject->code ? '('.$subject->code.')' : '' }}
                </option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Subject Teacher</label>
            <select name="teacher_id"
                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
              <option value="">-- Optional --</option>
              @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Type</label>
            <select name="is_core" required
                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
              <option value="1">Core</option>
              <option value="0">Elective</option>
            </select>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Display Order</label>
            <input type="number" name="sort_order" value="0" min="0"
                   class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>

          <button type="submit"
                  class="w-full py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition">
            Assign Subject
          </button>
        </form>
      @else
        <p class="text-xs text-slate-500">All active subjects have already been assigned to this class.</p>
      @endif
    </div>

    <!-- CURRENTLY ASSIGNED SUBJECTS -->
    <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
        <div>
          <h3 class="font-bold text-slate-900 text-base">Assigned Subjects</h3>
          <p class="text-xs text-slate-500">{{ $classStream->subjects->count() }} subject(s)</p>
        </div>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
          <thead>
            <tr class="bg-slate-100/70 border-b border-slate-200 text-[11px] uppercase font-bold text-slate-500 tracking-wider">
              <th class="py-3 px-5">#</th>
              <th class="py-3 px-5">Subject</th>
              <th class="py-3 px-5">Code</th>
              <th class="py-3 px-5">Type</th>
              <th class="py-3 px-5">Teacher</th>
              <th class="py-3 px-5 text-right">Action</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
            @forelse($classStream->subjects as $index => $subject)
              <tr class="hover:bg-slate-50/80 transition">
                <td class="py-3.5 px-5 text-slate-500">{{ $index + 1 }}</td>
                <td class="py-3.5 px-5 font-bold text-slate-900">{{ $subject->name }}</td>
                <td class="py-3.5 px-5">{{ $subject->code ?? '—' }}</td>
                <td class="py-3.5 px-5">
                  <span class="px-2.5 py-1 rounded-md text-[11px] font-semibold
                    {{ $subject->pivot->is_core ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700' }}">
                    {{ $subject->pivot->is_core ? 'Core' : 'Elective' }}
                  </span>
                </td>
                    <td class="py-3.5 px-5">
                        @if($subject->pivot->teacher_id)
                            {{ $teachers->firstWhere('id', $subject->pivot->teacher_id)->name ?? '—' }}
                        @else
                            Not assigned
                        @endif
                    </td>
                <td class="py-3.5 px-5 text-right">
                  <form action="{{ route('admin.class-streams.remove-subject', [$classStream->id, $subject->id]) }}"
                        method="POST"
                        onsubmit="return confirm('Remove this subject from the class?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-2.5 py-1 bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 font-semibold rounded-md transition text-[11px]">
                      <i class="fa-solid fa-trash"></i> Remove
                    </button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="py-10 text-center text-slate-400 text-xs">
                  No subjects assigned yet. Use the form on the left to add subjects.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection