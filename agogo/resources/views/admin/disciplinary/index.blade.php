@extends('admin.layout') 
@section('title', 'Disciplinary Records - Admin')

@section('content')
<div x-data="disciplinaryManager()" class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Disciplinary Records</h1>
      <p class="text-sm text-slate-500 mt-1">Log and manage student conduct & misbehaviour</p>
    </div>
    <button @click="openCreate()"
            class="inline-flex items-center gap-2 px-4 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition shadow-sm">
      <i class="fa-solid fa-plus"></i>
      Log New Record
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
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
          @foreach(['open','under_review','resolved'] as $s)
            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst(str_replace('_', ' ', $s)) }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-500 mb-1">Severity</label>
        <select name="severity" class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
          <option value="">All severities</option>
          @foreach(['minor','major','serious'] as $s)
            <option value="{{ $s }}" @selected(request('severity') === $s)>{{ ucfirst($s) }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="block text-xs font-semibold text-slate-500 mb-1">Category</label>
        <select name="category" class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
          <option value="">All categories</option>
          @foreach(['lateness','fighting','insolence','vandalism','uniform','theft','bullying','other'] as $c)
            <option value="{{ $c }}" @selected(request('category') === $c)>{{ ucfirst($c) }}</option>
          @endforeach
        </select>
      </div>
      <div class="flex items-end gap-2">
        <button type="submit"
                class="flex-1 px-4 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition">
          Filter
        </button>
        <a href="{{ route('admin.disciplinary.index') }}"
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
            <th class="px-4 py-3 text-left font-semibold text-slate-600">Date</th>
            <th class="px-4 py-3 text-left font-semibold text-slate-600">Category</th>
            <th class="px-4 py-3 text-left font-semibold text-slate-600">Severity</th>
            <th class="px-4 py-3 text-left font-semibold text-slate-600">Action</th>
            <th class="px-4 py-3 text-left font-semibold text-slate-600">Status</th>
            <th class="px-4 py-3 text-right font-semibold text-slate-600">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          @forelse($records as $record)
            <tr class="hover:bg-slate-50/80">
              <td class="px-4 py-3">
                <div class="font-semibold text-slate-800">{{ $record->student?->name ?? '—' }}</div>
                <div class="text-xs text-slate-500">
                  {{ $record->student?->class }} • {{ $record->student?->index_number ?? '' }}
                </div>
              </td>
              <td class="px-4 py-3 text-slate-600 whitespace-nowrap">
                {{ $record->incident_date->format('d M Y') }}
              </td>
              <td class="px-4 py-3">
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                  {{ ucfirst($record->category) }}
                </span>
              </td>
              <td class="px-4 py-3">
                @php
                  $sevColors = [
                    'minor'   => 'bg-amber-50 text-amber-700',
                    'major'   => 'bg-orange-50 text-orange-700',
                    'serious' => 'bg-rose-50 text-rose-700',
                  ];
                  $sev = $sevColors[$record->severity] ?? 'bg-slate-100 text-slate-600';
                @endphp
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $sev }}">
                  {{ ucfirst($record->severity) }}
                </span>
              </td>
              <td class="px-4 py-3 text-slate-600 text-xs">
                {{ $record->action_taken ? ucfirst(str_replace('_', ' ', $record->action_taken)) : '—' }}
                @if($record->demerit_points > 0)
                  <span class="text-rose-600 font-medium">(+{{ $record->demerit_points }} pts)</span>
                @endif
              </td>
              <td class="px-4 py-3">
                @php
                  $statusColors = [
                    'open'         => 'bg-amber-50 text-amber-700',
                    'under_review' => 'bg-sky-50 text-sky-700',
                    'resolved'     => 'bg-emerald-50 text-emerald-700',
                  ];
                  $st = $statusColors[$record->status] ?? 'bg-slate-100 text-slate-600';
                @endphp
                <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $st }}">
                  {{ ucfirst(str_replace('_', ' ', $record->status)) }}
                </span>
              </td>
              <td class="px-4 py-3 text-right space-x-1">
                <button @click="openEdit(@js($record))"
                        class="inline-flex items-center justify-center w-8 h-8 text-asc-green hover:bg-asc-green/10 rounded-lg transition"
                        title="Edit">
                  <i class="fa-solid fa-pen text-sm"></i>
                </button>

                @if($record->status !== 'resolved')
                  <form action="{{ route('admin.disciplinary.resolve', $record) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit"
                            class="inline-flex items-center justify-center w-8 h-8 text-emerald-600 hover:bg-emerald-50 rounded-lg transition"
                            title="Mark as Resolved"
                            onclick="return confirm('Mark this record as resolved?')">
                      <i class="fa-solid fa-check text-sm"></i>
                    </button>
                  </form>
                @endif

                <form action="{{ route('admin.disciplinary.destroy', $record) }}" method="POST" class="inline"
                      onsubmit="return confirm('Delete this disciplinary record?')">
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
              <td colspan="7" class="px-4 py-12 text-center text-slate-400">
                No disciplinary records found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($records->hasPages())
      <div class="px-4 py-3 border-t border-slate-100">
        {{ $records->links() }}
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
        <h2 class="text-lg font-bold text-slate-800" x-text="editing ? 'Edit Disciplinary Record' : 'Log New Record'"></h2>
        <button @click="closeModal()" class="text-slate-400 hover:text-slate-600">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <form :action="editing ? `{{ url('admin/disciplinary') }}/${form.id}` : `{{ route('admin.disciplinary.store') }}`"
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
                ({{ $student->class }} • {{ $student->index_number ?? 'No index' }})
              </option>
            @endforeach
          </select>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          {{-- Incident date --}}
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Incident Date</label>
            <input type="date" name="incident_date" x-model="form.incident_date" required
                   class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
          </div>

          {{-- Category --}}
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Category</label>
            <select name="category" x-model="form.category" required
                    class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
              <option value="lateness">Lateness</option>
              <option value="fighting">Fighting</option>
              <option value="insolence">Insolence</option>
              <option value="vandalism">Vandalism</option>
              <option value="uniform">Uniform</option>
              <option value="theft">Theft</option>
              <option value="bullying">Bullying</option>
              <option value="other">Other</option>
            </select>
          </div>

          {{-- Severity --}}
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Severity</label>
            <select name="severity" x-model="form.severity" required
                    class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
              <option value="minor">Minor</option>
              <option value="major">Major</option>
              <option value="serious">Serious</option>
            </select>
          </div>
        </div>

        {{-- Description --}}
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Description</label>
          <textarea name="description" x-model="form.description" rows="3" required
                    class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green"
                    placeholder="What happened?"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          {{-- Action taken --}}
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Action Taken</label>
            <select name="action_taken" x-model="form.action_taken"
                    class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
              <option value="">— Select —</option>
              <option value="warning">Warning</option>
              <option value="detention">Detention</option>
              <option value="suspension">Suspension</option>
              <option value="counselling">Counselling</option>
              <option value="fine">Fine</option>
              <option value="parents_called">Parents Called</option>
              <option value="other">Other</option>
            </select>
          </div>

          {{-- Demerit points --}}
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Demerit Points</label>
            <input type="number" name="demerit_points" x-model="form.demerit_points" min="0" max="100"
                   class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green"
                   placeholder="0">
          </div>

          {{-- Status --}}
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1.5">Status</label>
            <select name="status" x-model="form.status"
                    class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green">
              <option value="open">Open</option>
              <option value="under_review">Under Review</option>
              <option value="resolved">Resolved</option>
            </select>
          </div>
        </div>

        {{-- Notes --}}
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Notes (optional)</label>
          <textarea name="notes" x-model="form.notes" rows="2"
                    class="w-full rounded-xl border-slate-300 text-sm focus:border-asc-green focus:ring-asc-green"
                    placeholder="Any extra remarks..."></textarea>
        </div>

        {{-- Notify guardian --}}
        <div class="flex items-start gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
          <input type="checkbox" name="notify_guardian" value="1" id="notify_guardian"
                 x-model="form.notify_guardian"
                 class="mt-0.5 rounded border-slate-300 text-asc-green focus:ring-asc-green">
          <label for="notify_guardian" class="text-sm text-slate-700 cursor-pointer">
            <span class="font-semibold">Notify guardian via SMS</span>
            <span class="block text-xs text-slate-500 mt-0.5">
              Sends to guardian_phone if available, otherwise student’s phone
            </span>
          </label>
        </div>

        <div class="flex justify-end gap-3 pt-2">
          <button type="button" @click="closeModal()"
                  class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-xl transition">
            Cancel
          </button>
          <button type="submit"
                  class="px-5 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition">
            <span x-text="editing ? 'Update Record' : 'Save Record'"></span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
function disciplinaryManager() {
  return {
    modalOpen: false,
    editing: false,
    form: {
      id: null,
      student_id: '',
      incident_date: '',
      category: 'lateness',
      severity: 'minor',
      description: '',
      action_taken: '',
      demerit_points: 0,
      status: 'open',
      notes: '',
      notify_guardian: false,
    },

    openCreate() {
      this.editing = false;
      const today = new Date().toISOString().slice(0, 10);
      this.form = {
        id: null,
        student_id: '',
        incident_date: today,
        category: 'lateness',
        severity: 'minor',
        description: '',
        action_taken: '',
        demerit_points: 0,
        status: 'open',
        notes: '',
        notify_guardian: false,
      };
      this.modalOpen = true;
    },

    openEdit(record) {
      this.editing = true;
      this.form = {
        id: record.id,
        student_id: String(record.student_id),
        incident_date: record.incident_date ? record.incident_date.substring(0, 10) : '',
        category: record.category || 'lateness',
        severity: record.severity || 'minor',
        description: record.description || '',
        action_taken: record.action_taken || '',
        demerit_points: record.demerit_points ?? 0,
        status: record.status || 'open',
        notes: record.notes || '',
        notify_guardian: false,
      };
      this.modalOpen = true;
    },

    closeModal() {
      this.modalOpen = false;
    }
  }
}
</script>
@endpush
@endsection