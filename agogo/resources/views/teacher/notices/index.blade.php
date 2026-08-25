@extends('teacher.layout')

@section('title', 'Announcements - Agogo State College')

@section('content')
<div x-data="noticeViewer()" class="space-y-6">

  {{-- Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-slate-800">Announcements & Updates</h1>
      <p class="text-sm text-slate-500 mt-1">All notices sent to teaching staff</p>
    </div>
    <a href="{{ route('teacher') }}"
       class="inline-flex items-center gap-2 text-sm font-medium text-asc-green hover:underline">
      <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
    </a>
  </div>

  {{-- Notices Grid/List --}}
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="divide-y divide-slate-100">
      @forelse($notices as $notice)
        <div class="p-5 sm:p-6 hover:bg-slate-50/80 transition flex items-start gap-4">
          <div class="w-10 h-10 rounded-xl bg-asc-green/10 text-asc-green flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-bullhorn"></i>
          </div>

          <div class="flex-grow min-w-0">
            <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
              <h3 class="text-base font-bold text-slate-900">{{ $notice->title }}</h3>
              <span class="text-xs text-slate-400 font-medium">
                {{ $notice->created_at->format('d M Y') }}
              </span>
            </div>
            <p class="text-sm text-slate-600 leading-relaxed line-clamp-2">
              {{ \Illuminate\Support\Str::limit(strip_tags($notice->body), 160) }}
            </p>
            <div class="mt-3 flex items-center justify-between">
              <span class="text-xs text-slate-400">
                <i class="fa-regular fa-clock mr-1"></i>
                {{ $notice->created_at->diffForHumans() }}
              </span>

              {{-- VIEW BUTTON --}}
              <button @click="openNotice({{ $notice->id }})"
                      class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-asc-green bg-asc-green/10 hover:bg-asc-green hover:text-white rounded-lg transition">
                <i class="fa-solid fa-eye"></i>
                View
              </button>
            </div>
          </div>
        </div>
      @empty
        <div class="p-12 text-center">
          <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-bullhorn text-2xl"></i>
          </div>
          <p class="text-slate-500 font-medium">No announcements yet</p>
          <p class="text-sm text-slate-400 mt-1">New notices will appear here when published by admin.</p>
        </div>
      @endforelse
    </div>

    @if($notices->hasPages())
      <div class="px-5 py-4 border-t border-slate-100">
        {{ $notices->links() }}
      </div>
    @endif
  </div>

  {{-- ===================== VIEW NOTICE MODAL ===================== --}}
  <div x-show="modalOpen" x-cloak
       class="fixed inset-0 z-50 flex items-center justify-center p-4"
       style="display: none;">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="closeModal()"></div>

    <!-- Modal Card -->
    <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto"
         @click.stop>
      
      <!-- Header -->
      <div class="sticky top-0 bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg bg-asc-green/10 text-asc-green flex items-center justify-center">
            <i class="fa-solid fa-bullhorn"></i>
          </div>
          <h2 class="text-lg font-bold text-slate-800" x-text="notice.title || 'Announcement'"></h2>
        </div>
        <button @click="closeModal()" class="text-slate-400 hover:text-slate-600 p-1">
          <i class="fa-solid fa-xmark text-xl"></i>
        </button>
      </div>

      <!-- Body -->
      <div class="p-6 space-y-4">
        <div class="flex items-center gap-2 text-xs text-slate-400">
          <i class="fa-regular fa-calendar"></i>
          <span x-text="notice.created_at"></span>
          <span class="mx-1">•</span>
          <span x-text="notice.human_date"></span>
        </div>

        <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-line"
             x-text="notice.body">
        </div>
      </div>

      <!-- Footer -->
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
function noticeViewer() {
    return {
        modalOpen: false,
        notice: {
            title: '',
            body: '',
            created_at: '',
            human_date: '',
        },

        async openNotice(id) {
            try {
                const res = await fetch(`/teacher/notices/${id}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!res.ok) throw new Error('Failed to load notice');

                this.notice = await res.json();
                this.modalOpen = true;
            } catch (e) {
                alert('Could not load this announcement. Please try again.');
                console.error(e);
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