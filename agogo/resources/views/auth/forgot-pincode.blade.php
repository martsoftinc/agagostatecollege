@extends('layout')

@section('title', 'Forgot Pincode — Agogo State College')

@section('content')
<section class="bg-ivory py-16 sm:py-24 w-full min-h-[70vh] flex items-center">
  <div class="max-w-md mx-auto px-4 sm:px-6 w-full">
    <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-10 shadow-sm">

      <div class="flex items-center gap-2 mb-5">
        <span class="w-2 h-2 rounded-full bg-lime"></span>
        <span class="text-xs font-semibold uppercase tracking-widest text-forest">Reset Pincode</span>
      </div>

      <h1 class="font-extrabold text-2xl sm:text-3xl tracking-tightish text-ink">Forgot Pincode?</h1>
      <p class="mt-2 text-sm text-muted leading-relaxed">
        Enter your Student ID or registered phone number. We'll send a new pincode to your phone.
      </p>

      @if(session('success'))
        <div class="mt-6 rounded-2xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700 flex items-start gap-3">
          <i data-lucide="check-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if(session('error'))
        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700 flex items-start gap-3">
          <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 mt-0.5"></i>
          <span>{{ session('error') }}</span>
        </div>
      @endif

      @if($errors->any())
        <div class="mt-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
          <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form method="POST" action="{{ route('student.forgot-pincode') }}" class="mt-8 space-y-5">
        @csrf

        <div>
          <label for="student_id" class="block text-sm font-semibold text-ink mb-1.5">Student ID or Phone Number</label>
          <input
            type="text"
            id="student_id"
            name="student_id"
            value="{{ old('student_id') }}"
            placeholder="e.g. ASC2026001 or 0244123456"
            required
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition"
          >
          <p class="mt-2 text-xs text-muted">
            We'll send a new pincode to your registered phone number.
          </p>
        </div>

        <button type="submit"
          class="w-full inline-flex items-center justify-center gap-2 bg-lime text-forest-deep font-semibold px-6 py-3 rounded-full hover:bg-lime-soft transition-colors text-sm shadow-sm">
          <i data-lucide="send" class="w-4 h-4"></i>
          Send New Pincode
        </button>
      </form>

      <div class="mt-8 text-center space-y-3">
        <a href="{{ route('student.login') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-forest hover:gap-3 transition-all">
          <i data-lucide="arrow-left" class="w-4 h-4"></i>
          Back to Login
        </a>
      </div>

      <div class="mt-6 p-4 bg-amber-50 rounded-2xl border border-amber-200">
        <div class="flex items-start gap-3">
          <i data-lucide="info" class="w-5 h-5 text-amber-600 shrink-0 mt-0.5"></i>
          <p class="text-xs text-amber-800">
            <span class="font-bold">Note:</span> A new 6-digit pincode will be sent to your registered phone number. 
            If you don't receive it within 5 minutes, please contact the IT Secretariat.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection