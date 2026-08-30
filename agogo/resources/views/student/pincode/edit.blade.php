@extends('student.layout')

@section('title', 'Change Pincode - Agogo State College')

@section('content')
<div class="max-w-lg mx-auto space-y-6">

  {{-- Back Button --}}
  <div>
    <a href="{{ url()->previous() }}" 
       class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-asc-green transition group">
      <i class="fa-solid fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
      <span>Back</span>
    </a>
  </div>

  {{-- Header --}}
  <div>
    <h2 class="text-2xl font-bold text-asc-green">Change Pincode</h2>
    <p class="mt-1 text-sm text-slate-600">
      Enter your current pincode and choose a new one (4–6 digits).
    </p>
  </div>

  {{-- Success Message --}}
  @if (session('success'))
    <div class="rounded-xl bg-green-50 border border-green-200 text-green-800 px-4 py-3 text-sm flex items-center gap-2">
      <i class="fa-solid fa-circle-check"></i>
      {{ session('success') }}
    </div>
  @endif

  {{-- Form Card --}}
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 sm:p-8">
    <form action="{{ route('pincode.update') }}" method="POST" class="space-y-5">
      @csrf
      @method('PUT')

      {{-- Current Pincode --}}
      <div>
        <label for="current_pincode" class="block text-sm font-medium text-slate-700 mb-1.5">
          Current Pincode
        </label>
        <input 
          type="password" 
          name="current_pincode" 
          id="current_pincode"
          inputmode="numeric"
          pattern="[0-9]*"
          maxlength="6"
          class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-asc-green focus:border-asc-green outline-none transition @error('current_pincode') border-red-500 @enderror"
          placeholder="Enter current pincode"
          required
        >
        @error('current_pincode')
          <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- New Pincode --}}
      <div>
        <label for="pincode" class="block text-sm font-medium text-slate-700 mb-1.5">
          New Pincode
        </label>
        <input 
          type="password" 
          name="pincode" 
          id="pincode"
          inputmode="numeric"
          pattern="[0-9]*"
          maxlength="6"
          class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-asc-green focus:border-asc-green outline-none transition @error('pincode') border-red-500 @enderror"
          placeholder="4–6 digits"
          required
        >
        @error('pincode')
          <p class="mt-1.5 text-xs text-red-600">{{ $message }}</p>
        @enderror
      </div>

      {{-- Confirm New Pincode --}}
      <div>
        <label for="pincode_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">
          Confirm New Pincode
        </label>
        <input 
          type="password" 
          name="pincode_confirmation" 
          id="pincode_confirmation"
          inputmode="numeric"
          pattern="[0-9]*"
          maxlength="6"
          class="w-full rounded-xl border border-slate-300 px-4 py-2.5 text-sm focus:ring-2 focus:ring-asc-green focus:border-asc-green outline-none transition"
          placeholder="Re-enter new pincode"
          required
        >
      </div>

      {{-- Submit --}}
      <button 
        type="submit"
        class="w-full bg-asc-green hover:bg-asc-green-dark text-white font-semibold py-2.5 rounded-xl transition shadow-sm flex items-center justify-center gap-2"
      >
        <i class="fa-solid fa-key"></i>
        Change Pincode
      </button>
    </form>
  </div>

</div>
@endsection