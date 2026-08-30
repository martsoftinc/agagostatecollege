@extends('admin.layout') 

@section('title', 'Exeat Log - Admin')

@section('content')
<div x-data="exeatManager()" class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Exeat Log</h1>
      <p class="text-sm text-slate-500 mt-1">Log and manage student campus leave</p>
    </div>
    <button @click="openCreate()"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition shadow-sm">
      <i class="fa-solid fa-plus"></i>
      Log New Exeat
    </button>
  </div>

  {{-- Flash --}}
  @if(session('success'))
    <div class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
      {{ session('success') }}
    </div>
  @endif

  {{-- Filters --}}
  <form method="GET" class="bg-white rounded-2xl border border-slate-200 p-4 shadow-sm">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
      <div>
        <label class="block text-xs font-semibold text-slate-500 mb-1">Search student</label>
        <input type="text" name="search" value="{{ request('search') }}"
               placeholder="Name or index number"
               class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-500 mb-1">Status</label>
        <select name="status" class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
          <option value="">All statuses</option>
          @foreach(['pending','approved','out','returned','overdue','rejected','cancelled'] as $s)
            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-500 mb-1">Type</label>
        <select name="type" class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
          <option value="">All types</option>
          @foreach(['day','weekend','emergency','medical','other'] as $t)
            <option value="{{ $t }}" @selected(request('type') === $t)>{{ ucfirst($t) }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex items-end gap-2">
        <button type="submit"
                class="flex-1 px-4 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition">
          Filter
        </button>
        <a href="{{ route('admin.exeats.index') }}"
           class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-xl transition">
          Reset
        </a>
      </div>
    </div>
  </form>

  {{-- Table --}}
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="min-w-full divide-y divide-slate-200 text-sm">
        <thead class="bg-slate-50">
          <tr>
            <th class="px-4 py-3 text-left font-semibold text-slate-600">Student</th>
            <th class="px-4 py-3 text-left font-semibold text-slate-600">Type</th>
            <th class="px-4 py-3 text-left font-semibold text-slate-600">Destination</th>
            <th class="px-4 py-3 text-left font-semibold text-slate-600">Leave → Return</th>
            <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
            <th class="px-4 py-3 text-right font-semibold text-slate-600">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($exeats as $exeat)
            <tr class="hover:bg-slate-50/80">
              <td class="px-4 py-3">
                <div class="font-semibold text-slate-800">{{ $exeat->student?->name ?? '—' }}</div>
                <div class="text-xs text-slate-500">
                  {{ $exeat->student?->class }} • {{ $exeat->student?->index_number ?? '' }}
                </div>
              </td>
              <td class="px-4 py-3">
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                  {{ ucfirst($exeat->type) }}
                </span>
              </td>
              <td class="px-4 py-3 text-slate-700">
                {{ $exeat->destination }}
              </td>
              <td class="px-4 py-3 text-xs text-slate-600">
                <div>{{ $exeat->departure_at->format('d M, H:i') }}</div>
                <div class="text-slate-400">→ {{ $exeat->expected_return_at->format('d M, H:i') }}</div>
                @if($exeat->actual_return_at)
                  <div class="text-emerald-600 mt-0.5">Returned: {{ $exeat->actual_return_at->format('d M, H:i') }}</div>
                @endif
              </td>
              <td class="px-4 py-3">
                @php
                  $statusColors = [
                    'pending'   => 'bg-amber-50 text-amber-700',
                    'approved'  => 'bg-emerald-50 text-emerald-700',
                    'out'       => 'bg-sky-50 text-sky-700',
                    'returned'  => 'bg-slate-100 text-slate-600',
                    'overdue'   => 'bg-rose-50 text-rose-700',
                    'rejected'  => 'bg-rose-50 text-rose-700',
                    'cancelled' => 'bg-slate-100 text-slate-500',
                  ];
                  $color = $statusColors[$exeat->status] ?? 'bg-slate-100 text-slate-600';
                @endphp
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $color }}">
                  {{ ucfirst($exeat->status) }}
                </span>
              </td>
              <td class="px-4 py-3 text-right space-x-1">
                <button @click="openEdit(@js($exeat))"
                        class="inline-flex items-center justify-center w-8 h-8 text-asc-green hover:bg-asc-green/10 rounded-lg transition"
                        title="Edit">
                  <i class="fa-solid fa-pen text-sm"></i>
                </button>

                @if(in_array($exeat->status, ['approved', 'out', 'overdue']))
                  <form action="{{ route('admin.exeats.return', $exeat) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex items-center justify-center w-8 h-8 text-emerald-600 hover:bg-emerald-50 rounded-lg transition"
                            title="Mark as Returned"
                            onclick="return confirm('Mark this student as returned?')">
                      <i class="fa-solid fa-house-circle-check text-sm"></i>
                    </button>
                  </form>
                @endif

                <form action="{{ route('admin.exeats.destroy', $exeat) }}" method="POST" class="inline"
                      onsubmit="return confirm('Delete this exeat record?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="inline-flex items-center justify-center w-8 h-8 text-rose-500 hover:bg-rose-50 rounded-lg transition"
                          title="Delete">
                    <i class="fa-solid fa-trash text-sm"></i>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                No exeat records found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($exeats->hasPages())
      <div class="px-4 py-3 border-t border-slate-100">
        {{ $exeats->links() }}
      </div>
    @endif
  </div>

  {{-- ===================== CREATE / EDIT MODAL ===================== --}}
  <div x-show="modalOpen" x-cloak
       class="fixed inset-0 z-50 flex items-center justify-center p-4"
       style="display: none;">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="closeModal()"></div>

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" @click.stop>
      <div class="sticky top-0 bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
        <h2 class="text-lg font-bold text-slate-800" x-text="editing ? 'Edit Exeat' : 'Log New Exeat'"></h2>
        <button @click="closeModal()" class="text-slate-400 hover:text-slate-600">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <form :action="editing ? `{{ url('admin/exeats') }}/${form.id}` : `{{ route('admin.exeats.store') }}`"
            method="POST" class="p-6 space-y-5">
        @csrf
        <template x-if="editing">
          <input type="hidden" name="_method" value="PUT">
        </template>

        {{-- Student --}}
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Student</label>
          <select name="student_id" x-model="form.student_id" required
                  class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
            <option value="">Select student</option>
            @foreach($students as $student)
              <option value="{{ $student->id }}">
                {{ $student->name }}
                ({{ $student->class }} • {{ $student->student_id ?? 'No index' }})
              </option>
            @endforeach
          </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          {{-- Type --}}
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Type</label>
            <select name="type" x-model="form.type" required
                    class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
              <option value="day">Day</option>
              <option value="weekend">Weekend</option>
              <option value="emergency">Emergency</option>
              <option value="medical">Medical</option>
              <option value="other">Other</option>
            </select>
          </div>

          {{-- Status --}}
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
            <select name="status" x-model="form.status"
                    class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
              <option value="pending">Pending</option>
              <option value="approved">Approved</option>
              <option value="out">Out</option>
              <option value="returned">Returned</option>
              <option value="rejected">Rejected</option>
              <option value="cancelled">Cancelled</option>
            </select>
            <p class="text-xs text-slate-400 mt-1">SMS is sent when status is Approved or Out</p>
          </div>
        </div>

        {{-- Destination --}}
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Destination</label>
          <input type="text" name="destination" x-model="form.destination" required
                 class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green"
                 placeholder="e.g. Home – Kumasi">
        </div>

        {{-- Reason --}}
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Reason</label>
          <textarea name="reason" x-model="form.reason" rows="2" required
                    class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green"
                    placeholder="Why is the student leaving campus?"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          {{-- Departure --}}
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Departure</label>
            <input type="datetime-local" name="departure_at" x-model="form.departure_at" required
                   class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
          </div>

          {{-- Expected Return --}}
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Expected Return</label>
            <input type="datetime-local" name="expected_return_at" x-model="form.expected_return_at" required
                   class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
          </div>
        </div>

        {{-- Guardian contact --}}
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Guardian Contact (optional)</label>
          <input type="text" name="guardian_contact" x-model="form.guardian_contact"
                 class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green"
                 placeholder="e.g. 0244123456">
          <p class="text-xs text-slate-400 mt-1">Will also receive the approval SMS</p>
        </div>

        {{-- Notes --}}
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Notes (optional)</label>
          <textarea name="notes" x-model="form.notes" rows="2"
                    class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green"
                    placeholder="Any extra remarks..."></textarea>
        </div>

        <div class="flex justify-end gap-3 pt-2">
          <button type="button" @click="closeModal()"
                  class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-xl transition">
            Cancel
          </button>
          <button type="submit"
                  class="px-5 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition">
            <span x-text="editing ? 'Update Exeat' : 'Save Exeat'"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
function exeatManager() {
  return {
    modalOpen: false,
    editing: false,
    form: {
      id: null,
      student_id: '',
      type: 'day',
      destination: '',
      reason: '',
      departure_at: '',
      expected_return_at: '',
      status: 'approved',
      guardian_contact: '',
      notes: '',
    },

    openCreate() {
      this.editing = false;
      this.form = {
        id: null,
        student_id: '',
        type: 'day',
        destination: '',
        reason: '',
        departure_at: '',
        expected_return_at: '',
        status: 'approved',
        guardian_contact: '',
        notes: '',
      };
      this.modalOpen = true;
    },

    openEdit(exeat) {
      this.editing = true;
      this.form = {
        id: exeat.id,
        student_id: String(exeat.student_id),
        type: exeat.type || 'day',
        destination: exeat.destination || '',
        reason: exeat.reason || '',
        departure_at: this.toLocalInput(exeat.departure_at),
        expected_return_at: this.toLocalInput(exeat.expected_return_at),
        status: exeat.status || 'approved',
        guardian_contact: exeat.guardian_contact || '',
        notes: exeat.notes || '',
      };
      this.modalOpen = true;
    },

    toLocalInput(iso) {
      if (!iso) return '';
      // Convert ISO / Laravel datetime to datetime-local value
      const d = new Date(iso);
      if (isNaN(d.getTime())) return '';
      const pad = n => String(n).padStart(2, '0');
      return `${d.getFullYear()}-${pad(d.getMonth()+1)}-${pad(d.getDate())}T${pad(d.getHours())}:${pad(d.getMinutes())}`;
    },

    closeModal() {
      this.modalOpen = false;
    }
  }
}
</script>
@endpush
@endsection