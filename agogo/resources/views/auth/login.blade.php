
@extends('layout')

@section('title', 'Admin Login — Agogo State College')

@section('content')
<section class="bg-ivory py-16 sm:py-24 w-full min-h-[70vh] flex items-center">
  <div class="max-w-md mx-auto px-4 sm:px-6 w-full">
    <div id="login-card" class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-10 shadow-sm">

      <div class="flex items-center gap-2 mb-5">
        <span class="w-2 h-2 rounded-full bg-lime"></span>
        <span class="text-xs font-semibold uppercase tracking-widest text-forest">Admin portal</span>
      </div>

      <h1 class="font-extrabold text-2xl sm:text-3xl tracking-tightish text-ink">Welcome back</h1>
      <p class="mt-2 text-sm text-muted leading-relaxed">
        Sign in to access the Agogo State College dashboard.
      </p>

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

      <form method="POST" action="{{ route('login') }}" id="logins-form" class="mt-8 space-y-5">
        @csrf

        <div>
          <label for="login-email" class="block text-sm font-semibold text-ink mb-1.5">Email address</label>
          <input
            type="email"
            id="login-email"
            name="email"
            value="{{ old('email') }}"
            placeholder="admin@agogostatecollege.edu.gh"
            autocomplete="email"
            required
            class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition"
          >
        </div>

        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label for="login-password" class="block text-sm font-semibold text-ink">Password</label>
            <a href="{{ url('/forgot-password') }}" class="text-xs font-semibold text-forest hover:underline">Forgot password?</a>
          </div>
          <div class="relative">
            <input
              type="password"
              id="login-password"
              name="password"
              placeholder="••••••••"
              autocomplete="current-password"
              required
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
  const passwordInput = document.getElementById('login-password');

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

  @if($errors->any() || session('error'))
  document.addEventListener('DOMContentLoaded', function () {
    const card = document.getElementById('login-card');
    if (!card) return;
    card.classList.add('shake-animation');
    setTimeout(function () { card.classList.remove('shake-animation'); }, 500);
  });
  @endif
</script>
<style>
  .shake-animation {
    animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
  }
  @keyframes shake {
    10%, 90% { transform: translateX(-1px); }
    20%, 80% { transform: translateX(2px); }
    30%, 50%, 70% { transform: translateX(-3px); }
    40%, 60% { transform: translateX(3px); }
  }
</style>
@endpush

