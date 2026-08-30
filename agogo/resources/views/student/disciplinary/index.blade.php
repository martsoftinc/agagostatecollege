@extends('student.layout')

@section('title', 'Disciplinary Report - Student Portal')

@section('content')
<div x-data="disciplinaryViewer()" class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Disciplinary Report</h1>
      <p class="text-sm text-slate-500 mt-1">Conduct records for {{ $student->name }}</p>
    </div>
    <a href="{{ route('student.dashboard') }}"
       class="inline-flex items-center gap-2 text-sm font-medium text-asc-green hover:underline">
      <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>
  </div>

  {{-- Summary card --}}
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 flex flex-wrap items-center gap-6">
    <div class="flex items-center gap-3">
      <div class="w-11 h-11 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
        <i class="fa-solid fa-gavel"></i>
      </div>
      <div>
        <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Total Records</p>
        <p class="text-xl font-bold text-slate-800">{{ $records->total() }}</p>
      </div>
    </div>
    <div class="h-10 w-px bg-slate-200 hidden sm:block"></div>
    <div>
      <p class="text-xs text-slate-400 font-medium uppercase tracking-wide">Total Demerit Points</p>
      <p class="text-xl font-bold {{ $totalDemerits > 0 ? 'text-rose-600' : 'text-slate-800' }}">
        {{ $totalDemerits }}
      </p>
    </div>
  </div>

  {{-- List --}}
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="divide-y divide-slate-100">
      @forelse($records as $record)
        <div class="p-5 sm:p-6 hover:bg-slate-50/80 transition flex flex-col sm:flex-row sm:items-start justify-between gap-4">
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center flex-shrink-0 border border-rose-100">
              <i class="fa-solid fa-gavel"></i>
            </div>
            <div>
              <div class="flex flex-wrap items-center gap-2 mb-1">
                <h3 class="text-base font-bold text-slate-900">{{ ucfirst($record->category) }}</h3>
                @php
                  $sevColors = [
                    'minor'   => 'bg-amber-50 text-amber-700',
                    'major'   => 'bg-orange-50 text-orange-700',
                    'serious' => 'bg-rose-50 text-rose-700',
                  ];
                  $statusColors = [
                    'open'         => 'bg-amber-50 text-amber-700',
                    'under_review' => 'bg-sky-50 text-sky-700',
                    'resolved'     => 'bg-emerald-50 text-emerald-700',
                  ];
                @endphp
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $sevColors[$record->severity] ?? 'bg-slate-100 text-slate-600' }}">
                  {{ $record->severity }}
                </span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold {{ $statusColors[$record->status] ?? 'bg-slate-100 text-slate-600' }}">
                  {{ str_replace('_', ' ', $record->status) }}
                </span>
              </div>
              <p class="text-sm text-slate-600 leading-relaxed">
                {{ \Illuminate\Support\Str::limit($record->description, 140) }}
              </p>
              <div class="mt-2 flex flex-wrap gap-3 text-xs text-slate-400">
                <span>
                  <i class="fa-regular fa-calendar mr-1"></i>
                  {{ $record->incident_date->format('d M Y') }}
                </span>
                @if($record->demerit_points > 0)
                  <span class="text-rose-500 font-medium">
                    +{{ $record->demerit_points }} demerit pts
                  </span>
                @endif
                @if($record->action_taken)
                  <span>
                    Action: {{ ucfirst(str_replace('_', ' ', $record->action_taken)) }}
                  </span>
                @endif
              </div>
            </div>
          </div>

          <button @click="openRecord({{ $record->id }})"
                  class="self-end sm:self-start inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-asc-green bg-asc-green/10 hover:bg-asc-green hover:text-white rounded-lg transition">
            <i class="fa-solid fa-eye"></i>
            View
          </button>
        </div>
      @empty
        <div class="p-12 text-center">
          <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-gavel text-2xl"></i>
          </div>
          <p class="text-slate-500 font-medium">No disciplinary records</p>
          <p class="text-sm text-slate-400 mt-1">Your conduct record is clean so far.</p>
        </div>
      @endforelse
    </div>

    @if($records->hasPages())
      <div class="px-5 py-4 border-t border-slate-100">
        {{ $records->links() }}
      </div>
    @endif
  </div>

  {{-- ===================== VIEW MODAL ===================== --}}
  <div x-show="modalOpen" x-cloak
       class="fixed inset-0 z-50 flex items-center justify-center p-4"
       style="display: none;">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="closeModal()"></div>

    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>
      <div class="sticky top-0 bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center">
            <i class="fa-solid fa-gavel"></i>
          </div>
          <h2 class="text-lg font-bold text-slate-800">Disciplinary Details</h2>
        </div>
        <button @click="closeModal()" class="text-slate-400 hover:text-slate-600">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <div class="p-6 space-y-4">
        <div class="flex flex-wrap gap-2">
          <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700"
                x-text="record.category"></span>
          <span class="px-2.5 py-1 rounded-full text-xs font-bold uppercase bg-orange-50 text-orange-700"
                x-text="record.severity"></span>
          <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700"
                x-text="record.status"></span>
        </div>

        <div>
          <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Incident Date</p>
          <p class="text-sm font-bold text-slate-800 mt-0.5" x-text="record.incident_date"></p>
        </div>

        <div>
          <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Description</p>
          <p class="text-sm text-slate-700 mt-0.5 whitespace-pre-line" x-text="record.description"></p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div x-show="record.action_taken">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Action Taken</p>
            <p class="text-sm text-slate-700 mt-0.5" x-text="record.action_taken"></p>
          </div>
          <div x-show="record.demerit_points > 0">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Demerit Points</p>
            <p class="text-sm font-bold text-rose-600 mt-0.5" x-text="record.demerit_points"></p>
          </div>
        </div>

        <div x-show="record.notes">
          <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Notes</p>
          <p class="text-sm text-slate-700 mt-0.5 whitespace-pre-line" x-text="record.notes"></p>
        </div>

        <div class="pt-2 border-t border-slate-100 text-xs text-slate-400 space-y-1">
          <p x-show="record.reported_by">Reported by: <span x-text="record.reported_by"></span></p>
          <p x-show="record.resolved_at">Resolved: <span x-text="record.resolved_at"></span></p>
        </div>
      </div>

      <div class="px-6 py-4 border-t border-slate-100 flex justify-end">
        <button @click="closeModal()"
                class="px-5 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition">
          Close
        </button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
function disciplinaryViewer() {
  return {
    modalOpen: false,
    record: {},

    async openRecord(id) {
      try {
        const res = await fetch(`/student/disciplinary/${id}`, {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        if (!res.ok) throw new Error('Failed');
        this.record = await res.json();
        this.modalOpen = true;
      } catch (e) {
        alert('Could not load this record.');
      }
    },

    closeModal() {
      this.modalOpen = false;
    }
  }
}
</script>
@endpush
@endsection