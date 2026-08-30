@extends('student.layout') 

@section('title', 'My Exeats - Student Portal')

@section('content')
<div x-data="exeatViewer()" class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">My Exeats</h1>
      <p class="text-sm text-slate-500 mt-1">Campus leave records for {{ $student->name }}</p>
    </div>
    <a href="{{ route('student.dashboard') }}"
       class="inline-flex items-center gap-2 text-sm font-medium text-asc-green hover:underline">
      <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>
  </div>

  {{-- List --}}
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="divide-y divide-slate-100">
      @forelse($exeats as $exeat)
        <div class="p-5 sm:p-6 hover:bg-slate-50/80 transition flex flex-col sm:flex-row sm:items-start justify-between gap-4">
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center flex-shrink-0 border border-orange-100">
              <i class="fa-solid fa-person-walking-arrow-right"></i>
            </div>
            <div>
              <div class="flex flex-wrap items-center gap-2 mb-1">
                <h3 class="text-base font-bold text-slate-900">{{ $exeat->destination }}</h3>
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
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $color }}">
                  {{ $exeat->status }}
                </span>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-medium bg-slate-100 text-slate-600">
                  {{ ucfirst($exeat->type) }}
                </span>
              </div>
              <p class="text-sm text-slate-600 leading-relaxed">
                {{ \Illuminate\Support\Str::limit($exeat->reason, 120) }}
              </p>
              <div class="mt-2 flex flex-wrap gap-3 text-xs text-slate-400">
                <span>
                  <i class="fa-regular fa-calendar mr-1"></i>
                  Leave: {{ $exeat->departure_at->format('d M Y, H:i') }}
                </span>
                <span>
                  <i class="fa-regular fa-clock mr-1"></i>
                  Return by: {{ $exeat->expected_return_at->format('d M Y, H:i') }}
                </span>
              </div>
            </div>
          </div>

          <button @click="openExeat({{ $exeat->id }})"
                  class="self-end sm:self-start inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-asc-green bg-asc-green/10 hover:bg-asc-green hover:text-white rounded-lg transition">
            <i class="fa-solid fa-eye"></i>
            View
          </button>
        </div>
      @empty
        <div class="p-12 text-center">
          <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-person-walking-arrow-right text-2xl"></i>
          </div>
          <p class="text-slate-500 font-medium">No exeat records yet</p>
          <p class="text-sm text-slate-400 mt-1">Your campus leave history will appear here.</p>
        </div>
      @endforelse
    </div>

    @if($exeats->hasPages())
      <div class="px-5 py-4 border-t border-slate-100">
        {{ $exeats->links() }}
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
          <div class="w-9 h-9 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
            <i class="fa-solid fa-person-walking-arrow-right"></i>
          </div>
          <h2 class="text-lg font-bold text-slate-800">Exeat Details</h2>
        </div>
        <button @click="closeModal()" class="text-slate-400 hover:text-slate-600">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <div class="p-6 space-y-4">
        <div class="flex flex-wrap gap-2">
          <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700"
                x-text="exeat.status"></span>
          <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-600"
                x-text="exeat.type"></span>
        </div>

        <div>
          <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Destination</p>
          <p class="text-sm font-bold text-slate-800 mt-0.5" x-text="exeat.destination"></p>
        </div>

        <div>
          <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Reason</p>
          <p class="text-sm text-slate-700 mt-0.5 whitespace-pre-line" x-text="exeat.reason"></p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Departure</p>
            <p class="text-sm text-slate-700 mt-0.5" x-text="exeat.departure_at"></p>
          </div>
          <div>
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Expected Return</p>
            <p class="text-sm text-slate-700 mt-0.5" x-text="exeat.expected_return_at"></p>
          </div>
        </div>

        <div x-show="exeat.actual_return_at">
          <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Actual Return</p>
          <p class="text-sm text-emerald-600 font-medium mt-0.5" x-text="exeat.actual_return_at"></p>
        </div>

        <div x-show="exeat.guardian_contact">
          <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Guardian Contact</p>
          <p class="text-sm text-slate-700 mt-0.5" x-text="exeat.guardian_contact"></p>
        </div>

        <div x-show="exeat.notes">
          <p class="text-xs font-semibold text-slate-400 uppercase tracking-wide">Notes</p>
          <p class="text-sm text-slate-700 mt-0.5 whitespace-pre-line" x-text="exeat.notes"></p>
        </div>

        <div class="pt-2 border-t border-slate-100 text-xs text-slate-400 space-y-1">
          <p x-show="exeat.logged_by">Logged by: <span x-text="exeat.logged_by"></span></p>
          <p x-show="exeat.approved_by">Approved by: <span x-text="exeat.approved_by"></span></p>
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
function exeatViewer() {
  return {
    modalOpen: false,
    exeat: {},

    async openExeat(id) {
      try {
        const res = await fetch(`/student/exeats/${id}`, {
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
          }
        });
        if (!res.ok) throw new Error('Failed');
        this.exeat = await res.json();
        this.modalOpen = true;
      } catch (e) {
        alert('Could not load this exeat record.');
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