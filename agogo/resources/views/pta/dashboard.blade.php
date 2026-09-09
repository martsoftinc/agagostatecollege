@extends('layouts.pta')

@section('title', 'PTA Chairman Dashboard')

@section('content')
<div class="space-y-8">

  <!-- Page Header -->
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h1 class="text-2xl font-bold text-asc-green-dark">PTA Chairman Dashboard</h1>
      <p class="text-slate-500 text-sm mt-1">Manage meeting announcements and send bulk SMS to students</p>
    </div>
  </div>

  <!-- Flash Messages -->
  @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl flex items-center gap-3">
      <i class="fa-solid fa-circle-check"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if(session('error'))
    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center gap-3">
      <i class="fa-solid fa-circle-exclamation"></i>
      <span>{{ session('error') }}</span>
    </div>
  @endif

  <!-- ===================== MEETING ANNOUNCEMENT ===================== -->
  <div id="meeting" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="bg-asc-green px-6 py-4 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-asc-yellow text-asc-green-dark flex items-center justify-center">
          <i class="fa-solid fa-bullhorn"></i>
        </div>
        <div>
          <h2 class="text-white font-bold text-lg">PTA Meeting Announcement</h2>
          <p class="text-asc-yellow text-xs">Only one announcement is kept – saving replaces the previous one</p>
        </div>
      </div>
    </div>

    <form action="{{ route('pta.meeting.update') }}" method="POST" class="p-6 space-y-5">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Title -->
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Title <span class="text-rose-500">*</span></label>
          <input type="text" name="title" value="{{ old('title', $meeting->title ?? '') }}"
                 class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30 shadow-sm"
                 placeholder="e.g. First Term PTA Meeting" required>
          @error('title') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Description -->
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Description</label>
          <textarea name="description" rows="4"
                    class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30 shadow-sm"
                    placeholder="Agenda, important notes, dress code...">{{ old('description', $meeting->description ?? '') }}</textarea>
          @error('description') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Date -->
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Date <span class="text-rose-500">*</span></label>
          <input type="date" name="meeting_date"
                 value="{{ old('meeting_date', optional($meeting?->meeting_date)->format('Y-m-d')) }}"
                 class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30 shadow-sm" required>
          @error('meeting_date') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Time -->
        <div>
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Time <span class="text-rose-500">*</span></label>
          <input type="time" name="meeting_time"
                 value="{{ old('meeting_time', $meeting->meeting_time ?? '') }}"
                 class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30 shadow-sm" required>
          @error('meeting_time') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <!-- Venue -->
        <div class="md:col-span-2">
          <label class="block text-sm font-semibold text-slate-700 mb-1.5">Venue <span class="text-rose-500">*</span></label>
          <input type="text" name="venue" value="{{ old('venue', $meeting->venue ?? '') }}"
                 class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30 shadow-sm"
                 placeholder="e.g. School Assembly Hall" required>
          @error('venue') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="flex justify-end pt-2">
        <button type="submit"
                class="inline-flex items-center gap-2 bg-asc-green hover:bg-asc-green-dark text-white font-semibold px-6 py-2.5 rounded-xl transition shadow-sm">
          <i class="fa-solid fa-floppy-disk"></i>
          {{ $meeting ? 'Update Announcement' : 'Create Announcement' }}
        </button>
      </div>
    </form>
  </div>

  <!-- ===================== BULK SMS ===================== -->
  <div id="sms" class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    <div class="bg-asc-green px-6 py-4 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-xl bg-asc-yellow text-asc-green-dark flex items-center justify-center">
          <i class="fa-solid fa-sms"></i>
        </div>
        <div>
          <h2 class="text-white font-bold text-lg">Send Bulk SMS</h2>
          <p class="text-asc-yellow text-xs">Message will be sent to all users with role = "student"</p>
        </div>
      </div>
    </div>

    <form action="{{ route('pta.sms.bulk') }}" method="POST" class="p-6 space-y-5"
          onsubmit="return confirm('Send this SMS to all students?')">
      @csrf

      <div>
        <label class="block text-sm font-semibold text-slate-700 mb-1.5">
          Message <span class="text-rose-500">*</span>
          <span class="text-slate-400 font-normal text-xs ml-2">(max 160 characters)</span>
        </label>
        <textarea name="message" rows="4" maxlength="160" required
                  class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green/30 shadow-sm"
                  placeholder="Dear Parent, PTA meeting will be held on...">{{ old('message') }}</textarea>
        <div class="flex justify-between mt-1">
          @error('message') <p class="text-rose-500 text-xs">{{ $message }}</p> @enderror
          <p class="text-xs text-slate-400 ml-auto"><span id="charCount">0</span>/160</p>
        </div>
      </div>

      <div class="flex justify-end">
        <button type="submit"
                class="inline-flex items-center gap-2 bg-asc-yellow hover:bg-asc-yellow-hover text-asc-green-dark font-bold px-6 py-2.5 rounded-xl transition shadow-sm">
          <i class="fa-solid fa-paper-plane"></i>
          Send Bulk SMS to Students
        </button>
      </div>
    </form>
  </div>

</div>
@endsection

@push('scripts')
<script>
  const textarea = document.querySelector('textarea[name="message"]');
  const counter  = document.getElementById('charCount');
  if (textarea && counter) {
    counter.textContent = textarea.value.length;
    textarea.addEventListener('input', () => {
      counter.textContent = textarea.value.length;
    });
  }
</script>
@endpush