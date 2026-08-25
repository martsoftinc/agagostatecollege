
@extends('user.layout')

@section('title', 'My Profile')

@push('styles')
<style>
  .section-card {
    background: white;
    border: 1px solid #e2e8f0;
    border-radius: 1.25rem;
    padding: 2rem;
    transition: box-shadow 0.2s ease;
  }
  .dark .section-card { background: #0f172a; border-color: #1e293b; }
  .section-card:hover { box-shadow: 0 4px 24px -4px rgba(0,0,0,0.07); }

  .form-label {
    display: block;
    font-size: 0.78rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: 0.45rem;
  }
  .dark .form-label { color: #94a3b8; }

  .form-input {
    width: 100%;
    padding: 0.7rem 1rem;
    border-radius: 0.75rem;
    border: 1.5px solid #e2e8f0;
    background: #f8fafc;
    font-size: 0.92rem;
    color: #0f172a;
    outline: none;
    transition: border-color 0.18s, box-shadow 0.18s, background 0.18s;
    font-family: 'DM Sans', sans-serif;
  }
  .dark .form-input { background: #1e293b; border-color: #334155; color: #e2e8f0; }
  .form-input:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.12); background: white; }
  .dark .form-input:focus { background: #1e293b; }
  .form-input::placeholder { color: #94a3b8; }
  .form-input.input-error { border-color: #ef4444 !important; box-shadow: 0 0 0 3px rgba(239,68,68,0.1) !important; }

  .field-error {
    font-size: 0.75rem;
    color: #ef4444;
    margin-top: 0.3rem;
    display: flex;
    align-items: center;
    gap: 0.3rem;
  }

  .btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.65rem 1.6rem;
    background: #3b82f6;
    color: white;
    border-radius: 0.75rem;
    font-size: 0.88rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: background 0.18s, transform 0.15s, box-shadow 0.18s;
    font-family: 'DM Sans', sans-serif;
  }
  .btn-primary:hover { background: #2563eb; transform: translateY(-1px); box-shadow: 0 6px 20px -4px rgba(59,130,246,0.4); }
  .btn-primary:active { transform: translateY(0); }
  .btn-primary:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

  /* Flash alerts */
  .alert {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    padding: 0.85rem 1.1rem;
    border-radius: 0.85rem;
    font-size: 0.85rem;
    font-weight: 500;
    margin-bottom: 1.25rem;
    animation: alertIn 0.3s ease;
  }
  @keyframes alertIn { from { opacity: 0; transform: translateY(-6px); } to { opacity: 1; transform: none; } }
  .alert-success { background: #f0fdf4; border: 1.5px solid #bbf7d0; color: #15803d; }
  .dark .alert-success { background: #052e16; border-color: #166534; color: #4ade80; }
  .alert-error { background: #fef2f2; border: 1.5px solid #fecaca; color: #dc2626; }
  .dark .alert-error { background: #450a0a; border-color: #991b1b; color: #f87171; }
  .alert-warn { background: #fffbeb; border: 1.5px solid #fde68a; color: #92400e; }
  .dark .alert-warn { background: #422006; border-color: #854d0e; color: #fbbf24; }

  /* Toggle */
  .toggle-track {
    position: relative; width: 52px; height: 28px;
    border-radius: 999px; background: #cbd5e1;
    cursor: pointer; transition: background 0.25s ease; flex-shrink: 0;
  }
  .toggle-track.on { background: #3b82f6; }
  .toggle-knob {
    position: absolute; top: 3px; left: 3px;
    width: 22px; height: 22px; border-radius: 50%;
    background: white; box-shadow: 0 1px 4px rgba(0,0,0,0.18);
    transition: transform 0.25s cubic-bezier(.4,0,.2,1);
  }
  .toggle-track.on .toggle-knob { transform: translateX(24px); }

  .avatar-ring {
    width: 80px; height: 80px; border-radius: 1.1rem;
    background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%);
    display: flex; align-items: center; justify-content: center;
    font-family: 'Syne', sans-serif; font-size: 1.9rem;
    font-weight: 800; color: white; letter-spacing: -1px;
    box-shadow: 0 8px 20px -4px rgba(99,102,241,0.35); flex-shrink: 0;
  }

  .section-icon { width: 38px; height: 38px; border-radius: 0.7rem; display: flex; align-items: center; justify-content: center; }

  .divider { border: none; border-top: 1px solid #e2e8f0; margin: 1.5rem 0; }
  .dark .divider { border-color: #1e293b; }

  .strength-bar { height: 4px; border-radius: 999px; background: #e2e8f0; overflow: hidden; margin-top: 0.5rem; }
  .dark .strength-bar { background: #1e293b; }
  .strength-fill { height: 100%; border-radius: 999px; width: 0%; transition: width 0.3s ease, background 0.3s ease; }

  .badge-2fa {
    display: inline-flex; align-items: center; gap: 0.3rem;
    font-size: 0.72rem; font-weight: 700; padding: 0.2rem 0.6rem;
    border-radius: 999px; letter-spacing: 0.04em; text-transform: uppercase;
  }
  .badge-2fa.off { background: #fef3c7; color: #92400e; }
  .badge-2fa.on  { background: #dcfce7; color: #166534; }
  .dark .badge-2fa.off { background: #422006; color: #fcd34d; }
  .dark .badge-2fa.on  { background: #052e16; color: #4ade80; }

  .spinner { animation: spin 0.8s linear infinite; }
  @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>
@endpush

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-slide">

  {{-- Page Header --}}
  <div class="mb-2">
    <h1 class="font-syne text-2xl font-extrabold text-slate-900 dark:text-white">My Profile</h1>
    <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Manage your account details and security settings</p>
  </div>

  {{-- ── SECTION 1: Profile Info ── --}}
  <div class="section-card">
    <div class="flex items-center gap-3 mb-6">
      <div class="section-icon bg-blue-50 dark:bg-blue-950">
        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
        </svg>
      </div>
      <div>
        <div class="font-syne text-base font-bold text-slate-900 dark:text-white">Personal Information</div>
        <div class="text-xs text-slate-400">Update your name and email address</div>
      </div>
    </div>

    {{-- Flash messages for profile --}}
    @if(session('profile_success'))
      <div class="alert alert-success">
        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
        <span>{{ session('profile_success') }}</span>
      </div>
      @if(session('email_changed'))
      <div class="alert alert-warn">
        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
        <span>Your email changed — please <a href="{{ route('verification.notice') }}" class="underline font-semibold">verify your new address</a>.</span>
      </div>
      @endif
    @endif

    @if($errors->profileErrors->any())
      <div class="alert alert-error">
        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <ul class="list-disc list-inside space-y-0.5">
          @foreach($errors->profileErrors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Avatar preview --}}
    <div class="flex items-center gap-4 mb-6 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60">
      <div class="avatar-ring" id="avatarInitials">
        {{ strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1)) ?: 'AU' }}
      </div>
      <div>
        <div class="font-syne font-bold text-slate-900 dark:text-white text-lg" id="avatarName">
          {{ $user->full_name ?: ' User' }}
        </div>
        <div class="text-sm text-slate-500 dark:text-slate-400">{{ $user->role ?? 'User' }}</div>
      </div>
    </div>

    <form action="{{ route('user.profile.update') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
          <label class="form-label" for="first_name">First Name</label>
          <input type="text" id="first_name" name="first_name"
            class="form-input {{ $errors->profileErrors->has('first_name') ? 'input-error' : '' }}"
            value="{{ old('first_name', $user->first_name) }}"
            placeholder="e.g. Kofi" autocomplete="given-name"/>
          @error('first_name', 'profileErrors')
            <p class="field-error">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        <div>
          <label class="form-label" for="last_name">Last Name</label>
          <input type="text" id="last_name" name="last_name"
            class="form-input {{ $errors->profileErrors->has('last_name') ? 'input-error' : '' }}"
            value="{{ old('last_name', $user->last_name) }}"
            placeholder="e.g. Mensah" autocomplete="family-name"/>
          @error('last_name', 'profileErrors')
            <p class="field-error">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        <div class="sm:col-span-2">
          <label class="form-label" for="email">Email Address</label>
          <input type="email" id="email" name="email"
            class="form-input {{ $errors->profileErrors->has('email') ? 'input-error' : '' }}"
            value="{{ old('email', $user->email) }}"
            placeholder="e.g. admin@bedency.com" autocomplete="email"/>
          @error('email', 'profileErrors')
            <p class="field-error">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
              {{ $message }}
            </p>
          @enderror
        </div>
      </div>

      <div class="mt-6">
        <button type="submit" class="btn-primary" id="saveProfileBtn">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V7l-4-4Z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 3v4H7V3M12 12a3 3 0 1 0 0 6 3 3 0 0 0 0-6Z"/>
          </svg>
          Save Changes
        </button>
      </div>
    </form>
  </div>

  {{-- ── SECTION 2: Change Password ── --}}
  <div class="section-card">
    <div class="flex items-center gap-3 mb-6">
      <div class="section-icon bg-amber-50 dark:bg-amber-950">
        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25a3 3 0 0 1 3 3m3 0a6 6 0 0 1-7.029 5.912c-.563-.097-1.159.026-1.563.43L10.5 17.25H8.25v2.25H6v2.25H2.25v-2.818c0-.597.237-1.17.659-1.591l6.499-6.499c.404-.404.527-1 .43-1.563A6 6 0 1 1 21.75 8.25Z"/>
        </svg>
      </div>
      <div>
        <div class="font-syne text-base font-bold text-slate-900 dark:text-white">Change Password</div>
        <div class="text-xs text-slate-400">Choose a strong, unique password</div>
      </div>
    </div>

    {{-- Flash messages for password --}}
    @if(session('password_success'))
      <div class="alert alert-success">
        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
        <span>{{ session('password_success') }}</span>
      </div>
    @endif

    @if($errors->passwordErrors->any())
      <div class="alert alert-error">
        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <ul class="list-disc list-inside space-y-0.5">
          @foreach($errors->passwordErrors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('user.profile.password') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="space-y-4">
        <div>
          <label class="form-label" for="current_password">Current Password</label>
          <input type="password" id="current_password" name="current_password"
            class="form-input {{ $errors->passwordErrors->has('current_password') ? 'input-error' : '' }}"
            placeholder="Enter your current password" autocomplete="current-password"/>
          @error('current_password', 'passwordErrors')
            <p class="field-error">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        <hr class="divider">

        <div>
          <label class="form-label" for="new_password">New Password</label>
          <input type="password" id="new_password" name="new_password"
            class="form-input {{ $errors->passwordErrors->has('new_password') ? 'input-error' : '' }}"
            placeholder="Min. 8 characters with uppercase, numbers"
            autocomplete="new-password"
            oninput="checkStrength(this.value)"/>
          <div class="strength-bar">
            <div class="strength-fill" id="strengthFill"></div>
          </div>
          <div class="text-xs mt-1 text-slate-400" id="strengthLabel"></div>
          @error('new_password', 'passwordErrors')
            <p class="field-error mt-1">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        <div>
          <label class="form-label" for="new_password_confirmation">Confirm New Password</label>
          <input type="password" id="new_password_confirmation" name="new_password_confirmation"
            class="form-input {{ $errors->passwordErrors->has('new_password_confirmation') ? 'input-error' : '' }}"
            placeholder="Re-enter new password" autocomplete="new-password"/>
          @error('new_password_confirmation', 'passwordErrors')
            <p class="field-error">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8v4m0 4h.01"/></svg>
              {{ $message }}
            </p>
          @enderror
        </div>
      </div>

      <div class="mt-6">
        <button type="submit" class="btn-primary" style="background:#f59e0b"
          onmouseover="this.style.background='#d97706'" onmouseout="this.style.background='#f59e0b'">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z"/>
          </svg>
          Update Password
        </button>
      </div>
    </form>
  </div>

  {{-- ── SECTION 3: Security / 2FA ── --}}
  <div class="section-card">
    <div class="flex items-center gap-3 mb-6">
      <div class="section-icon bg-emerald-50 dark:bg-emerald-950">
        <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/>
        </svg>
      </div>
      <div>
        <div class="font-syne text-base font-bold text-slate-900 dark:text-white">Security</div>
        <div class="text-xs text-slate-400">Protect your account with extra verification</div>
      </div>
    </div>

    <div class="flex items-center justify-between gap-4 p-4 rounded-xl bg-slate-50 dark:bg-slate-800/60">
      <div class="flex items-start gap-3">
        <div class="mt-0.5 w-9 h-9 rounded-lg bg-white dark:bg-slate-700 border border-slate-200 dark:border-slate-600 flex items-center justify-center shadow-sm flex-shrink-0">
          <svg class="w-5 h-5 text-slate-600 dark:text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 1.5H8.25A2.25 2.25 0 0 0 6 3.75v16.5a2.25 2.25 0 0 0 2.25 2.25h7.5A2.25 2.25 0 0 0 18 20.25V3.75a2.25 2.25 0 0 0-2.25-2.25H13.5m-3 0V3h3V1.5m-3 0h3m-3 8.25h3m-3 3.75h3m-3 3.75h3"/>
          </svg>
        </div>
        <div>
          <div class="flex items-center gap-2">
            <span class="font-semibold text-sm text-slate-800 dark:text-white">Two-Factor Authentication</span>
            <span class="badge-2fa {{ $user->two_factor_enabled ? 'on' : 'off' }}" id="twoFaBadge">
              {{ $user->two_factor_enabled ? 'On' : 'Off' }}
            </span>
          </div>
          <p class="text-xs text-slate-400 mt-0.5 leading-relaxed max-w-xs">
            Add a second layer of security using an authenticator app or SMS code each time you log in.
          </p>
        </div>
      </div>

      <div role="switch" aria-checked="{{ $user->two_factor_enabled ? 'true' : 'false' }}"
           id="twoFaToggle" tabindex="0"
           class="toggle-track {{ $user->two_factor_enabled ? 'on' : '' }}"
           title="Toggle 2FA"
           onclick="toggle2FA()" onkeydown="if(event.key==='Enter'||event.key===' ')toggle2FA()">
        <div class="toggle-knob"></div>
      </div>
    </div>

    <div id="twoFaInfo" class="{{ $user->two_factor_enabled ? '' : 'hidden' }} mt-4 p-4 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/40">
      <div class="flex items-start gap-2">
        <svg class="w-4 h-4 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
        </svg>
        <div>
          <p class="text-xs font-semibold text-emerald-700 dark:text-emerald-300">Two-Factor Authentication is enabled</p>
          <p class="text-xs text-emerald-600 dark:text-emerald-400 mt-0.5">You'll be prompted for a verification code each time you sign in.</p>
        </div>
      </div>
    </div>

    {{-- 2FA toast --}}
    <div id="twoFaToast" class="hidden mt-3 alert"></div>
  </div>

</div>
@endsection

@push('scripts')
<script>
  /* ── Avatar live preview ── */
  const firstEl        = document.getElementById('first_name');
  const lastEl         = document.getElementById('last_name');
  const avatarName     = document.getElementById('avatarName');
  const avatarInitials = document.getElementById('avatarInitials');

  function updateAvatar() {
    const fn  = firstEl?.value.trim() || '';
    const ln  = lastEl?.value.trim()  || '';
    const full = [fn, ln].filter(Boolean).join(' ') || ' User';
    const initials = ((fn[0] || '') + (ln[0] || '')).toUpperCase() || 'AU';
    if (avatarName)     avatarName.textContent     = full;
    if (avatarInitials) avatarInitials.textContent = initials;
  }
  firstEl?.addEventListener('input', updateAvatar);
  lastEl?.addEventListener('input', updateAvatar);

  /* ── Password strength ── */
  function checkStrength(val) {
    const fill  = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    if (!fill || !label) return;

    let score = 0;
    if (val.length >= 8)           score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val))  score++;

    const levels = [
      { pct: '0%',   color: '#e2e8f0', text: '' },
      { pct: '25%',  color: '#ef4444', text: 'Weak' },
      { pct: '50%',  color: '#f97316', text: 'Fair' },
      { pct: '75%',  color: '#eab308', text: 'Good' },
      { pct: '100%', color: '#22c55e', text: 'Strong' },
    ];
    const lv = val.length === 0 ? levels[0] : levels[score];
    fill.style.width      = lv.pct;
    fill.style.background = lv.color;
    label.textContent     = lv.text;
    label.style.color     = lv.color;
  }

  /* ── 2FA Toggle ── */
  let twoFaEnabled = {{ $user->two_factor_enabled ? 'true' : 'false' }};
  const track   = document.getElementById('twoFaToggle');
  const badge   = document.getElementById('twoFaBadge');
  const infoBox = document.getElementById('twoFaInfo');
  const toast   = document.getElementById('twoFaToast');

  function applyToggleState() {
    if (twoFaEnabled) {
      track.classList.add('on');
      track.setAttribute('aria-checked', 'true');
      badge.textContent  = 'On';
      badge.className    = 'badge-2fa on';
      infoBox?.classList.remove('hidden');
    } else {
      track.classList.remove('on');
      track.setAttribute('aria-checked', 'false');
      badge.textContent = 'Off';
      badge.className   = 'badge-2fa off';
      infoBox?.classList.add('hidden');
    }
  }

  function showToast(message, type = 'success') {
    toast.className = `alert alert-${type} mt-3`;
    toast.textContent = message;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3500);
  }

  async function toggle2FA() {
    twoFaEnabled = !twoFaEnabled;
    applyToggleState();
    track.style.pointerEvents = 'none';

    try {
      const res = await fetch('{{ route("user.profile.2fa") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ enabled: twoFaEnabled }),
      });

      if (!res.ok) throw new Error('Server error');

      showToast(
        twoFaEnabled ? '2FA enabled — your account is more secure.' : '2FA disabled.',
        twoFaEnabled ? 'success' : 'warn'
      );
    } catch {
      // Roll back on failure
      twoFaEnabled = !twoFaEnabled;
      applyToggleState();
      showToast('Could not update 2FA. Please try again.', 'error');
    } finally {
      track.style.pointerEvents = '';
    }
  }
</script>
@endpush