<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Brainest EduCare — Reset Password</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Fraunces:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; }

    /* ── Theme (same as login) ── */
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
      --success-bg:  rgba(34,197,94,0.08);
      --success-border: rgba(34,197,94,0.2);
      --success-text: #4ade80;
      --error-bg:    rgba(239,68,68,0.08);
      --error-border: rgba(239,68,68,0.2);
      --error-text:  #f87171;
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
      --success-bg:  rgba(34,197,94,0.1);
      --success-border: rgba(34,197,94,0.3);
      --success-text: #15803d;
      --error-bg:    rgba(239,68,68,0.08);
      --error-border: rgba(239,68,68,0.2);
      --error-text:  #dc2626;
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

    /* ── Geometric background (same elegance) ── */
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

    /* ── Card (matches login) ── */
    .card {
      position: relative; z-index: 1;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 44px 40px;
      width: 100%;
      max-width: 420px;
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

    /* Form fields */
    .field { margin-bottom: 18px; }
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
    }
    .field input {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 11px 13px 11px 40px;
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

    /* Divider */
    .divider {
      display: flex; align-items: center; gap: 12px;
      margin: 24px 0;
      color: var(--text-muted);
      font-size: 12px;
    }
    .divider::before, .divider::after {
      content: '';
      flex: 1;
      height: 1px;
      background: var(--border);
    }

    /* Link styles */
    .back-link {
      text-align: center;
      font-size: 13px;
      color: var(--text-sub);
    }
    .back-link a {
      color: var(--accent-light);
      text-decoration: none;
      font-weight: 600;
      transition: opacity 0.2s;
      display: inline-flex;
      align-items: center;
      gap: 6px;
    }
    .back-link a:hover { opacity: 0.75; }

    /* Theme toggle (same position) */
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

    /* custom alert / message boxes */
    .alert-box {
      border-radius: 12px;
      padding: 12px 16px;
      margin-bottom: 24px;
      display: flex;
      gap: 12px;
      align-items: flex-start;
      font-size: 13px;
      backdrop-filter: blur(2px);
    }
    .alert-success {
      background: var(--success-bg);
      border: 1px solid var(--success-border);
      color: var(--success-text);
    }
    .alert-error {
      background: var(--error-bg);
      border: 1px solid var(--error-border);
      color: var(--error-text);
    }
    .alert-icon {
      flex-shrink: 0;
      margin-top: 1px;
    }
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
  </style>
</head>
<body>

  <!-- identical geometric background as login page -->
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
  <button class="theme-btn" onclick="toggleTheme()" title="Toggle theme" aria-label="Theme switch">
    <svg class="icon-sun w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
    <svg class="icon-moon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
  </button>

  <!-- Main card (reset password) with same design language -->
  <div class="card">
    <!-- Logo & branding 
    <div class="logo-wrap">
      <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
      </svg>
    </div>-->

    <h1 class="heading">Reset password</h1>
    <p class="subheading">Request a reset link for your Brainest EduCare account</p>

    <!-- dynamic alpine container for reset flow -->
    <div x-data="forgotPassword()" x-init="init" x-cloak>
      <!-- Success message block (after submission) -->
      <div x-show="submitted && successMessage" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" class="alert-box alert-success">
        <svg class="alert-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <div class="flex-1">
          <p x-text="successMessage"></p>
          <button @click="goToVerify" class="text-xs font-semibold mt-2 underline hover:no-underline" :style="{color: 'var(--accent-light)'}">Continue to verification →</button>
        </div>
      </div>

      <!-- Error display -->
      <div x-show="errorMessage && !submitted" x-transition:enter="transition ease-out duration-200" class="alert-box alert-error">
        <svg class="alert-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span x-text="errorMessage"></span>
      </div>

      <!-- Main form: only visible when not submitted -->
      <form x-show="!submitted" @submit.prevent="sendResetCode" class="mt-2">
        <div class="field">
          <label for="reset-email">Email address</label>
          <div class="input-wrap">
            <span class="input-icon">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </span>
            <input type="email" id="reset-email" x-model="email" placeholder="you@example.com" autocomplete="email" required :disabled="isLoading"/>
          </div>
          <p class="text-xs mt-1" style="color: var(--text-muted);">We'll send a 6-digit verification code to reset your password.</p>
        </div>

        <button type="submit" class="btn-primary" :disabled="isLoading">
          <template x-if="!isLoading">
            <>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
              Send reset code
            </>
          </template>
          <template x-if="isLoading">
            <div class="flex items-center gap-2">
              <svg class="spinner w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
              Sending...
            </div>
          </template>
        </button>
      </form>

      <!-- Divider only if not submitted -->
      <div x-show="!submitted" class="divider">or</div>

      <!-- Back to Login link (always visible), matches login page register-row style -->
      <div x-show="!submitted" class="back-link">
        <a href="{{ route('login') }}">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
          Back to sign in
        </a>
      </div>

      <!-- subtle helper after success too (optional) -->
      <div x-show="submitted" class="mt-6 text-center">
        <a href="{{ route('login') }}" class="text-xs" style="color: var(--accent-light);">← Return to login</a>
      </div>
    </div>
  </div>

  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <script>
    // Theme persistence same as login page
    function toggleTheme() {
      const root = document.documentElement;
      const newTheme = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-theme', newTheme);
      localStorage.setItem('bg-theme', newTheme);
    }
    const savedTheme = localStorage.getItem('bg-theme');
    if (savedTheme) document.documentElement.setAttribute('data-theme', savedTheme);

    // Alpine component for forgot password (uses same endpoint pattern but fully adapted)
    function forgotPassword() {
      return {
        show: false,
        email: '',
        isLoading: false,
        submitted: false,
        successMessage: '',
        errorMessage: '',
        init() {
          setTimeout(() => { this.show = true; }, 50);
          // Retrieve any stored email from previous attempts? optional
        },
        isValidEmail(email) {
          return /^[^\s@]+@([^\s@.,]+\.)+[^\s@.,]{2,}$/.test(email);
        },
        triggerShake() {
          const cardEl = document.querySelector('.card');
          if (cardEl) {
            cardEl.classList.add('shake-animation');
            setTimeout(() => cardEl.classList.remove('shake-animation'), 500);
          }
        },
        async sendResetCode() {
          this.errorMessage = '';
          this.successMessage = '';

          if (!this.email) {
            this.errorMessage = 'Please enter your email address.';
            this.triggerShake();
            return;
          }
          if (!this.isValidEmail(this.email)) {
            this.errorMessage = 'Please enter a valid email address (e.g., name@domain.com).';
            this.triggerShake();
            return;
          }

          this.isLoading = true;
          const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

          try {
            // Replace with your backend endpoint; using typical Laravel route
            // For the purpose of design consistency we call the same route used in the original code
            const response = await fetch('/forgot-password/send-code', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
              },
              body: JSON.stringify({ email: this.email })
            });

            const data = await response.json();

            if (data.success) {
              this.submitted = true;
              this.successMessage = data.message || 'Verification code sent! Check your inbox.';
              // store email for verification step
              localStorage.setItem('reset_email', this.email);
            } else {
              this.errorMessage = data.message || 'Unable to send reset code. Verify email or try again.';
              if (data.redirect) {
                window.location.href = data.redirect;
              } else {
                this.triggerShake();
              }
            }
          } catch (err) {
            console.error('Reset error:', err);
            this.errorMessage = 'Network error. Please check your connection and try again.';
            this.triggerShake();
          } finally {
            this.isLoading = false;
          }
        },
        goToVerify() {
          window.location.href = '/verify-code';
        }
      }
    }
  </script>
  <style>
    /* additional inline overrides for alpine + smooth */
    [x-cloak] { display: none !important; }
    .alert-box svg { stroke: currentColor; }
    .btn-primary svg { stroke: white; }
    [data-theme="light"] .btn-primary svg { stroke: white; }
    .back-link a svg { stroke: currentColor; }
  </style>
</body>
</html>