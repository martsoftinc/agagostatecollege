@extends('layouts.housemaster')
@section('title', 'Add Disciplinary Record')

@section('content')
<div class="max-w-3xl mx-auto">
  <h1 class="text-2xl font-bold text-asc-green-dark mb-6">Add Disciplinary Record</h1>

  <form action="{{ route('housemaster.disciplinary.store') }}" method="POST" class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 space-y-6 shadow-sm">
    @csrf

    <!-- Searchable Student -->
    <div x-data="studentSelect(@js($students))" class="relative">
      <label class="block text-sm font-bold text-slate-700 mb-2">Student <span class="text-rose-500">*</span></label>
      <input type="hidden" name="student_id" x-model="selectedId" required>

      <div class="relative">
        <input type="text" x-model="search" @focus="open = true" @click.away="open = false"
               placeholder="Type student name or ID to search..."
               class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-sm focus:border-asc-green focus:ring-2 focus:ring-asc-green/20 outline-none transition">
        <i class="fa-solid fa-magnifying-glass absolute right-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
      </div>

      <div x-show="selectedName" class="mt-3 flex items-center justify-between bg-asc-green/10 border border-asc-green/30 rounded-xl px-4 py-2.5">
        <span class="text-sm font-semibold text-asc-green-dark" x-text="selectedName"></span>
        <button type="button" @click="clear()" class="text-rose-500 hover:text-rose-700"><i class="fa-solid fa-xmark"></i></button>
      </div>

      <div x-show="open && filtered.length" class="absolute z-50 mt-1 w-full max-h-64 overflow-y-auto bg-white border-2 border-slate-200 rounded-xl shadow-lg" style="display:none;">
        <template x-for="student in filtered" :key="student.id">
          <button type="button" @click="select(student)"
                  class="w-full text-left px-4 py-3 hover:bg-asc-green/10 text-sm border-b border-slate-100 last:border-0">
            <span class="font-medium" x-text="student.full_name"></span>
            <span class="text-slate-500 text-xs ml-2" x-text="'(' + (student.student_id || '') + ')'"></span>
          </button>
        </template>
      </div>
      <p x-show="open && search.length > 0 && filtered.length === 0" class="mt-2 text-sm text-rose-500">No student found</p>
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
      <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">Incident Date <span class="text-rose-500">*</span></label>
        <input type="date" name="incident_date" value="{{ old('incident_date', date('Y-m-d')) }}" required
               class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-sm focus:border-asc-green focus:ring-2 focus:ring-asc-green/20 outline-none">
      </div>
      <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">Category <span class="text-rose-500">*</span></label>
        <input type="text" name="category" value="{{ old('category') }}" required placeholder="e.g. Lateness, Fighting"
               class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-sm focus:border-asc-green focus:ring-2 focus:ring-asc-green/20 outline-none">
      </div>
    </div>

    <div class="grid sm:grid-cols-2 gap-5">
      <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">Severity <span class="text-rose-500">*</span></label>
        <select name="severity" required class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-sm focus:border-asc-green focus:ring-2 focus:ring-asc-green/20 outline-none">
          <option value="low">Low</option>
          <option value="medium">Medium</option>
          <option value="high">High</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-bold text-slate-700 mb-2">Demerit Points</label>
        <input type="number" name="demerit_points" min="0" value="{{ old('demerit_points', 0) }}"
               class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-sm focus:border-asc-green focus:ring-2 focus:ring-asc-green/20 outline-none">
      </div>
    </div>

    <div>
      <label class="block text-sm font-bold text-slate-700 mb-2">Description <span class="text-rose-500">*</span></label>
      <textarea name="description" rows="3" required
                class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-sm focus:border-asc-green focus:ring-2 focus:ring-asc-green/20 outline-none">{{ old('description') }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-bold text-slate-700 mb-2">Action Taken</label>
      <textarea name="action_taken" rows="2"
                class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-sm focus:border-asc-green focus:ring-2 focus:ring-asc-green/20 outline-none">{{ old('action_taken') }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-bold text-slate-700 mb-2">Notes</label>
      <textarea name="notes" rows="2"
                class="w-full rounded-xl border-2 border-slate-300 bg-white px-4 py-3 text-sm focus:border-asc-green focus:ring-2 focus:ring-asc-green/20 outline-none">{{ old('notes') }}</textarea>
    </div>

    <div class="flex items-center gap-3 bg-slate-50 rounded-xl px-4 py-3">
      <input type="checkbox" name="send_sms" value="1" id="send_sms" class="w-5 h-5 rounded border-2 border-slate-300 text-asc-green focus:ring-asc-green">
      <label for="send_sms" class="text-sm font-semibold text-slate-700">Send SMS notification to guardian</label>
    </div>

    <div class="flex justify-end gap-3 pt-2">
      <a href="{{ route('housemaster.disciplinary.index') }}" class="px-5 py-2.5 rounded-xl border-2 border-slate-300 text-slate-600 font-medium hover:bg-slate-50">Cancel</a>
      <button type="submit" class="bg-asc-green hover:bg-asc-green-dark text-white font-semibold px-6 py-2.5 rounded-xl shadow-sm">
        Save Record
      </button>
    </div>
  </form>
</div>
@endsection

@push('scripts')
<script>
function studentSelect(students) {
  return {
    students: students || [],
    search: '',
    open: false,
    selectedId: '',
    selectedName: '',
    get filtered() {
      if (!this.search) return this.students.slice(0, 40);
      const q = this.search.toLowerCase();
      return this.students.filter(s =>
        (s.full_name || '').toLowerCase().includes(q) ||
        (s.student_id || '').toLowerCase().includes(q)
      ).slice(0, 50);
    },
    select(student) {
      this.selectedId = student.id;
      this.selectedName = student.full_name + ' (' + (student.student_id || '') + ')';
      this.search = '';
      this.open = false;
    },
    clear() {
      this.selectedId = '';
      this.selectedName = '';
      this.search = '';
    }
  }
}
</script>
@endpush