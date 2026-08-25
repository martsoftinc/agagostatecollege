<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Brainest EduCare — Reset Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Fraunces:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; }

    /* ── Theme (exact match with Brainest EduCare login) ── */
    :root[data-theme="dark"] {
      --bg:          #0c0e18;
      --surface:     #13151f;
      --surface2:    #1a1d2e;
      --border:      #1e2130;
      --border-focus:#3b5bdb;
      --text:        #f1f3fa;
      --text-sub:    #8892b0;
      --text-muted:  #4a5270;
      --accent:      #3b5bdb;
      --accent-light:#7899f6;
      --accent-glow: rgba(59,91,219,0.25);
      --input-bg:    #0f1117;
      --btn-text:    #ffffff;
      --geo-color:   rgba(59,91,219,0.07);
      --error-bg:    rgba(239,68,68,0.08);
      --error-border: rgba(239,68,68,0.2);
      --error-text:  #f87171;
      --strength-weak:   #ef4444;
      --strength-fair:   #f97316;
      --strength-good:   #eab308;
      --strength-strong: #22c55e;
    }
    :root[data-theme="light"] {
      --bg:          #f0f2fa;
      --surface:     #ffffff;
      --surface2:    #f4f6fb;
      --border:      #dde1f0;
      --border-focus:#3b5bdb;
      --text:        #111827;
      --text-sub:    #4b5563;
      --text-muted:  #9ca3af;
      --accent:      #3b5bdb;
      --accent-light:#6480e8;
      --accent-glow: rgba(59,91,219,0.12);
      --input-bg:    #f8f9fd;
      --btn-text:    #ffffff;
      --geo-color:   rgba(59,91,219,0.05);
      --error-bg:    rgba(239,68,68,0.08);
      --error-border: rgba(239,68,68,0.2);
      --error-text:  #dc2626;
      --strength-weak:   #dc2626;
      --strength-fair:   #ea580c;
      --strength-good:   #ca8a04;
      --strength-strong: #16a34a;
    }

    html, body { height: 100%; }

    body {
      background: var(--bg);
      color: var(--text);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      overflow: hidden;
      transition: background 0.4s, color 0.4s;
    }

    /* ── Geometric background (signature design) ── */
    .bg-geo {
      position: fixed; inset: 0; pointer-events: none; z-index: 0;
      overflow: hidden;
    }
    .geo-circle {
      position: absolute;
      border-radius: 50%;
      border: 1px solid var(--geo-color);
      transition: border-color 0.4s;
    }
    .geo-c1 { width: 600px; height: 600px; top: -200px; right: -150px; border-width: 1px; }
    .geo-c2 { width: 400px; height: 400px; top: -80px;  right: 50px;   border-width: 1px; }
    .geo-c3 { width: 800px; height: 800px; bottom: -350px; left: -200px; border-width: 1px; }
    .geo-c4 { width: 300px; height: 300px; bottom: 80px; left: 40px;    border-width: 1px; }
    .geo-dot {
      position: absolute;
      width: 4px; height: 4px;
      background: var(--accent);
      border-radius: 50%;
      opacity: 0.5;
    }
    .dot1 { top: 18%; right: 22%; }
    .dot2 { top: 42%; right: 8%;  }
    .dot3 { bottom: 25%; left: 18%; }
    .dot4 { top: 70%; left: 35%;  }

    /* Accent blobs */
    .blob {
      position: absolute;
      border-radius: 50%;
      filter: blur(80px);
      opacity: 0.12;
      transition: opacity 0.4s;
    }
    [data-theme="light"] .blob { opacity: 0.07; }
    .blob1 { width: 400px; height: 400px; background: #3b5bdb; top: -80px; right: -60px; }
    .blob2 { width: 300px; height: 300px; background: #6480e8; bottom: -60px; left: -40px; }

    /* Main card (elegant, consistent) */
    .card {
      position: relative; z-index: 1;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 44px 40px;
      width: 100%;
      max-width: 440px;
      transition: background 0.4s, border-color 0.4s;
      animation: slideUp 0.55s cubic-bezier(0.22,1,0.36,1) both;
    }
    @media (max-width: 480px) {
      .card { padding: 32px 22px; margin: 16px; border-radius: 16px; }
    }

    @keyframes slideUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Logo mark */
    .logo-wrap {
      width: 48px; height: 48px;
      background: var(--accent);
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 28px;
      box-shadow: 0 8px 24px var(--accent-glow);
    }

    /* Typography */
    .heading {
      font-family: 'Fraunces', Georgia, serif;
      font-size: 26px;
      font-weight: 400;
      color: var(--text);
      line-height: 1.2;
      letter-spacing: -0.3px;
      margin-bottom: 6px;
    }
    .subheading {
      font-size: 13.5px;
      color: var(--text-sub);
      margin-bottom: 32px;
      line-height: 1.5;
    }

    /* Form fields (login style) */
    .field { margin-bottom: 22px; }
    .field label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      letter-spacing: 0.06em;
      text-transform: uppercase;
      color: var(--text-sub);
      margin-bottom: 7px;
    }
    .input-wrap {
      position: relative;
    }
    .input-icon {
      position: absolute;
      left: 13px; top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      pointer-events: none;
      transition: color 0.2s;
      z-index: 2;
    }
    .field input {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 11px 40px 11px 40px;
      font-size: 14px;
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.3s;
    }
    .field input:focus {
      border-color: var(--border-focus);
      box-shadow: 0 0 0 3px var(--accent-glow);
    }
    .field input::placeholder { color: var(--text-muted); }

    /* Eye toggle inside input */
    .eye-toggle {
      position: absolute;
      right: 12px; top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted);
      cursor: pointer;
      background: none; border: none;
      display: flex;
      align-items: center;
      transition: color 0.2s;
      z-index: 2;
    }
    .eye-toggle:hover { color: var(--text); }

    /* Strength indicator */
    .strength-container {
      display: flex;
      gap: 6px;
      margin-top: 10px;
      margin-bottom: 4px;
    }
    .strength-bar {
      flex: 1;
      height: 4px;
      border-radius: 4px;
      background: var(--border);
      transition: all 0.25s ease;
    }
    .strength-weak { background-color: var(--strength-weak); }
    .strength-fair { background-color: var(--strength-fair); }
    .strength-good { background-color: var(--strength-good); }
    .strength-strong { background-color: var(--strength-strong); }
    .strength-text {
      font-size: 11px;
      font-weight: 500;
      margin-top: 6px;
    }

    /* Buttons */
    .btn-primary {
      width: 100%;
      background: var(--accent);
      color: var(--btn-text);
      border: none;
      border-radius: 10px;
      padding: 13px;
      font-size: 14px;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      letter-spacing: 0.02em;
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
      box-shadow: 0 4px 16px var(--accent-glow);
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }
    .btn-primary:hover {
      background: #2f4dbf;
      transform: translateY(-1px);
      box-shadow: 0 6px 22px var(--accent-glow);
    }
    .btn-primary:active { transform: translateY(0); }
    .btn-primary:disabled { opacity: 0.6; transform: none; cursor: not-allowed; }

    /* Alert / Error box */
    .alert-error {
      background: var(--error-bg);
      border: 1px solid var(--error-border);
      color: var(--error-text);
      border-radius: 12px;
      padding: 12px 16px;
      margin-bottom: 24px;
      display: flex;
      gap: 12px;
      align-items: flex-start;
      font-size: 13px;
    }

    /* Back link */
    .back-link {
      text-align: center;
      margin-top: 24px;
    }
    .back-link a {
      color: var(--text-sub);
      text-decoration: none;
      font-size: 13px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: color 0.2s;
    }
    .back-link a:hover { color: var(--accent-light); }

    /* Divider optional */
    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 20px 0 16px;
      color: var(--text-muted);
      font-size: 12px;
    }
    .divider::before, .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }

    /* Shake animation */
    .shake-animation {
      animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
    }
    @keyframes shake {
      10%, 90% { transform: translateX(-1px); }
      20%, 80% { transform: translateX(2px); }
      30%, 50%, 70% { transform: translateX(-3px); }
      40%, 60% { transform: translateX(3px); }
    }

    .spinner {
      animation: spin 0.8s linear infinite;
    }
    @keyframes spin {
      from { transform: rotate(0deg); }
      to { transform: rotate(360deg); }
    }

    /* Theme toggle (fixed) */
    .theme-btn {
      position: fixed;
      top: 20px; right: 20px;
      z-index: 10;
      width: 38px; height: 38px;
      border-radius: 10px;
      background: var(--surface);
      border: 1px solid var(--border);
      color: var(--text-sub);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer;
      transition: background 0.3s, border-color 0.3s, color 0.2s;
    }
    .theme-btn:hover { color: var(--text); }
    [data-theme="dark"]  .icon-sun  { display: block; }
    [data-theme="dark"]  .icon-moon { display: none; }
    [data-theme="light"] .icon-sun  { display: none; }
    [data-theme="light"] .icon-moon { display: block; }

    /* hint text */
    .hint-text {
      font-size: 11px;
      margin-top: 6px;
      color: var(--text-muted);
    }
  </style>
</head>
<body>

  <!-- identical geometric background -->
  <div class="bg-geo">
    <div class="blob blob1"></div>
    <div class="blob blob2"></div>
    <div class="geo-circle geo-c1"></div>
    <div class="geo-circle geo-c2"></div>
    <div class="geo-circle geo-c3"></div>
    <div class="geo-circle geo-c4"></div>
    <div class="geo-dot dot1"></div>
    <div class="geo-dot dot2"></div>
    <div class="geo-dot dot3"></div>
    <div class="geo-dot dot4"></div>
  </div>

  <!-- Theme toggle -->
  <button class="theme-btn" onclick="toggleTheme()" title="Toggle theme">
    <svg class="icon-sun w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
    <svg class="icon-moon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
  </button>

  <!-- Reset password card (Brainest EduCare design) -->
  <div class="card">
    <div class="logo-wrap">
      <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
      </svg>
    </div>

    <h1 class="heading">Create new password</h1>
    <p class="subheading">Set a strong password for your Brainest EduCare account</p>

    <!-- Alpine component for reset flow -->
    <div x-data="resetPasswordHandler()" x-init="initReset" x-cloak>
      <!-- Error message -->
      <div x-show="errorMessage" class="alert-error" x-transition:enter="transition ease-out duration-200">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span x-text="errorMessage"></span>
      </div>

      <!-- New Password field -->
      <div class="field">
        <label for="new-password">New password</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          </span>
          <input :type="showPassword ? 'text' : 'password'" id="new-password" x-model="password" @input="checkPasswordStrength" placeholder="••••••••" autocomplete="new-password" />
          <button type="button" class="eye-toggle" @click="showPassword = !showPassword" tabindex="-1">
            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
            <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
          </button>
        </div>
        <!-- Strength indicator -->
        <div class="strength-container">
          <div class="strength-bar" :class="strengthClass[0]"></div>
          <div class="strength-bar" :class="strengthClass[1]"></div>
          <div class="strength-bar" :class="strengthClass[2]"></div>
          <div class="strength-bar" :class="strengthClass[3]"></div>
        </div>
        <div class="strength-text" :class="strengthColorClass" x-text="strengthLabel"></div>
        <p class="hint-text">Minimum 8 characters, letters & numbers for strong security</p>
      </div>

      <!-- Confirm Password field -->
      <div class="field">
        <label for="confirm-password">Confirm password</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          </span>
          <input :type="showConfirmPassword ? 'text' : 'password'" id="confirm-password" x-model="password_confirmation" placeholder="Confirm new password" autocomplete="new-password" />
          <button type="button" class="eye-toggle" @click="showConfirmPassword = !showConfirmPassword" tabindex="-1">
            <svg x-show="!showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
            <svg x-show="showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
          </button>
        </div>
        <div x-show="password && password_confirmation && password !== password_confirmation" class="text-xs mt-1" style="color: var(--error-text);">
          ⚠ Passwords do not match
        </div>
      </div>

      <button class="btn-primary" @click="submitReset" :disabled="isLoading">
        <template x-if="!isLoading">
          <>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7h6m0 0v6m0-6l-8 8-4-4-6 6"/></svg>
            Reset password
          </>
        </template>
        <template x-if="isLoading">
          <div class="flex items-center gap-2">
            <svg class="spinner w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Resetting...
          </div>
        </template>
      </button>

      <div class="divider"></div>

      <div class="back-link">
        <a href="{{ route('login') }}">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
          Back to sign in
        </a>
      </div>
    </div>
  </div>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    // Theme persistence
    function toggleTheme() {
      const root = document.documentElement;
      const newTheme = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-theme', newTheme);
      localStorage.setItem('bg-theme', newTheme);
    }
    const storedTheme = localStorage.getItem('bg-theme');
    if (storedTheme) document.documentElement.setAttribute('data-theme', storedTheme);

    function resetPasswordHandler() {
      return {
        password: '',
        password_confirmation: '',
        isLoading: false,
        errorMessage: '',
        showPassword: false,
        showConfirmPassword: false,
        strengthScore: 0,
        
        get strengthClass() {
          const s = this.strengthScore;
          return [
            s >= 1 ? 'strength-weak' : '',
            s >= 2 ? 'strength-fair' : '',
            s >= 3 ? 'strength-good' : '',
            s >= 4 ? 'strength-strong' : ''
          ];
        },
        get strengthLabel() {
          const s = this.strengthScore;
          if (s === 0) return 'Password strength';
          if (s === 1) return 'Weak';
          if (s === 2) return 'Fair';
          if (s === 3) return 'Good';
          return 'Strong';
        },
        get strengthColorClass() {
          const s = this.strengthScore;
          if (s === 1) return 'text-red-500';
          if (s === 2) return 'text-orange-500';
          if (s === 3) return 'text-yellow-600';
          if (s === 4) return 'text-green-600';
          return 'text-muted';
        },
        
        checkPasswordStrength() {
          let score = 0;
          const pwd = this.password;
          if (!pwd) { this.strengthScore = 0; return; }
          if (pwd.length >= 8) score++;
          if (pwd.length >= 12) score++;
          if (/[A-Z]/.test(pwd)) score++;
          if (/[0-9]/.test(pwd)) score++;
          if (/[^A-Za-z0-9]/.test(pwd)) score++;
          this.strengthScore = Math.min(4, Math.max(0, score - (pwd.length >= 8 ? 0 : 0)));
          if (pwd.length > 0 && this.strengthScore === 0 && pwd.length >= 8) this.strengthScore = 1;
        },
        
        initReset() {
          // optional session check
          fetch('/check-reset-session', {
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '' }
          }).then(res => res.json()).then(data => {
            if (!data.valid) window.location.href = '/forgot-password';
          }).catch(() => {});
        },
        
        async submitReset() {
          this.errorMessage = '';
          if (!this.password) {
            this.errorMessage = 'Please enter a new password.';
            this.triggerCardShake();
            return;
          }
          if (this.password.length < 8) {
            this.errorMessage = 'Password must be at least 8 characters.';
            this.triggerCardShake();
            return;
          }
          if (this.password !== this.password_confirmation) {
            this.errorMessage = 'Password confirmation does not match.';
            this.triggerCardShake();
            return;
          }
          this.isLoading = true;
          const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
          try {
            const response = await fetch('/reset-password', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
              },
              body: JSON.stringify({
                password: this.password,
                password_confirmation: this.password_confirmation
              })
            });
            const data = await response.json();
            if (data.success) {
              localStorage.removeItem('reset_email');
              window.location.href = data.redirect || '/login';
            } else {
              if (data.redirect) window.location.href = data.redirect;
              else {
                this.errorMessage = data.message || 'Unable to reset password. Please try again.';
                this.triggerCardShake();
              }
            }
          } catch (err) {
            this.errorMessage = 'Network error. Could not reset password.';
            this.triggerCardShake();
          } finally {
            this.isLoading = false;
          }
        },
        
        triggerCardShake() {
          const card = document.querySelector('.card');
          if (card) {
            card.classList.add('shake-animation');
            setTimeout(() => card.classList.remove('shake-animation'), 500);
          }
        }
      };
    }
  </script>
</body>
</html>