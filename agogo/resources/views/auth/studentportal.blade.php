@extends('layout')

@section('title', 'Student Portal — Agogo State College')

@section('content')
<section class="bg-ivory py-16 sm:py-24 w-full min-h-[70vh] flex items-center">
  <div class="max-w-md mx-auto px-4 sm:px-6 w-full">
    <div id="login-card" class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-10 shadow-sm">

      <div class="flex items-center gap-2 mb-5">
        <span class="w-2 h-2 rounded-full bg-lime"></span>
        <span class="text-xs font-semibold uppercase tracking-widest text-forest">Student portal</span>
      </div>

      <h1 class="font-extrabold text-2xl sm:text-3xl tracking-tightish text-ink">Sign in</h1>
      <p class="mt-2 text-sm text-muted leading-relaxed">
        Enter your student ID and pincode to access your portal.
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

      <form method="POST" action="{{ route('auth.student.login') }}" id="student-login-form" class="mt-8 space-y-5">
        @csrf

        <div>
          <label for="student_id" class="block text-sm font-semibold text-ink mb-1.5">Student ID or Phone Number</label>
          <input
            type="text"
            id="student_id"
            name="student_id"
            value="{{ old('student_id') }}"
            placeholder="e.g. ASC2026001 or 0244123456"
            autocomplete="username"
            required
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition"
          >
          <p class="mt-2 text-xs text-muted">
            Don’t know your student ID?
            <a href="{{ url('/contact') }}" class="font-semibold text-forest hover:underline">Click here</a>
          </p>
        </div>

        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label for="password" class="block text-sm font-semibold text-ink">Pincode</label>
            <a href="{{ route('student.forgot-pincode') }}" class="text-xs font-semibold text-forest hover:underline">Forgot pincode?</a>
          </div>
          <div class="relative">
            <input
              type="password"
              id="password"
              name="password"
              placeholder="••••••"
              autocomplete="current-password"
              required
              maxlength="6"
              class="w-full rounded-xl border border-gray-200 px-4 py-2.5 pr-11 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition"
            >
            <button type="button" id="togglePasswordBtn" class="absolute right-3 top-1/2 -translate-y-1/2 text-muted hover:text-ink" aria-label="Toggle password visibility">
              <i data-lucide="eye" class="w-4 h-4"></i>
            </button>
          </div>
        </div>

        <label class="flex items-center gap-2 cursor-pointer">
          <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
            class="w-4 h-4 rounded border-gray-300 text-forest focus:ring-forest">
          <span class="text-sm text-muted">Keep me signed in</span>
        </label>

        <button type="submit"
          class="w-full inline-flex items-center justify-center gap-2 bg-lime text-forest-deep font-semibold px-6 py-3 rounded-full hover:bg-lime-soft transition-colors text-sm shadow-sm">
          <i data-lucide="log-in" class="w-4 h-4"></i>
          Sign in
        </button>
      </form>

      <div class="mt-8 text-center">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-forest hover:gap-3 transition-all">
          <i data-lucide="arrow-left" class="w-4 h-4"></i>
          Back to homepage
        </a>
      </div>
    </div>
  </div>
</section>
@endsection

@push('scripts')
<script>
  const toggleBtn = document.getElementById('togglePasswordBtn');
  const passwordInput = document.getElementById('password');

  if (toggleBtn && passwordInput) {
    toggleBtn.addEventListener('click', function () {
      const isPassword = passwordInput.type === 'password';
      passwordInput.type = isPassword ? 'text' : 'password';
      toggleBtn.innerHTML = isPassword
        ? '<i data-lucide="eye-off" class="w-4 h-4"></i>'
        : '<i data-lucide="eye" class="w-4 h-4"></i>';
      if (window.lucide) lucide.createIcons();
    });
  }
</script>
@endpush