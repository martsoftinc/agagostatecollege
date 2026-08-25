<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Brainest EduCare — Verify Code</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Fraunces:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; }

    /* ── Theme (perfect match with login design) ── */
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

    /* ── Geometric sophisticated background (identical to login) ── */
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

    /* Accent blur blobs */
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

    /* Main card (same elegance) */
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

    /* Logo mark signature */
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

    /* Form elements exactly like login */
    .field { margin-bottom: 20px; }
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
    .code-input {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 11px 13px;
      font-size: 28px;
      font-weight: 600;
      letter-spacing: 0.3em;
      text-align: center;
      color: var(--text);
      font-family: 'DM Sans', monospace;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.3s;
    }
    .code-input:focus {
      border-color: var(--border-focus);
      box-shadow: 0 0 0 3px var(--accent-glow);
    }
    .code-input::placeholder {
      color: var(--text-muted);
      letter-spacing: 0.2em;
      font-size: 20px;
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

    /* Link styles consistent with login page */
    .action-links {
      display: flex;
      justify-content: center;
      gap: 24px;
      margin-top: 24px;
      font-size: 13px;
    }
    .action-links a, .resend-btn {
      color: var(--accent-light);
      text-decoration: none;
      font-weight: 500;
      transition: opacity 0.2s;
      background: none;
      border: none;
      cursor: pointer;
      font-family: inherit;
      font-size: 13px;
    }
    .action-links a:hover, .resend-btn:hover { opacity: 0.75; text-decoration: underline; }
    .back-link {
      text-align: center;
      margin-top: 20px;
    }
    .back-link a {
      color: var(--text-sub);
      text-decoration: none;
      font-size: 12px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: color 0.2s;
    }
    .back-link a:hover { color: var(--accent-light); }

    /* divider re-use */
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

    /* message boxes */
    .alert-box {
      border-radius: 12px;
      padding: 12px 16px;
      margin-bottom: 24px;
      display: flex;
      gap: 12px;
      align-items: flex-start;
      font-size: 13px;
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

    /* theme toggle (same design) */
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

    /* email hint custom */
    .email-badge {
      background: var(--surface2);
      border-radius: 20px;
      padding: 4px 12px;
      font-size: 12px;
      font-weight: 500;
      display: inline-block;
      margin-top: 6px;
      color: var(--accent-light);
    }
  </style>
</head>
<body>

  <!-- Geometric background identical to login -->
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

  <!-- Theme toggle (preserved) -->
  <button class="theme-btn" onclick="toggleTheme()" title="Toggle theme">
    <svg class="icon-sun w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
    <svg class="icon-moon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
  </button>

  <!-- Main card - verification flow with Brainest EduCare design refinement -->
  <div class="card">
    <div class="logo-wrap">
      <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
      </svg>
    </div>

    <h1 class="heading">Verify your code</h1>
    <p class="subheading">Enter the 6-digit code we sent to your email</p>

    <!-- Alpine component for verification logic -->
    <div x-data="verifyCodeHandler()" x-init="initVerification" x-cloak>
      <!-- success message overlay -->
      <div x-show="successMessage" x-transition:enter="transition ease-out duration-300" class="alert-box alert-success mb-5">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span x-text="successMessage"></span>
      </div>

      <!-- error message -->
      <div x-show="errorMessage" x-transition:enter="transition ease-out duration-200" class="alert-box alert-error mb-5">
        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        <span x-text="errorMessage"></span>
      </div>

      <!-- Email hint area -->
      <div class="text-center mb-6">
        <span class="email-badge" x-text="emailDisplay || 'your registered email'"></span>
        <p class="text-xs mt-2" style="color: var(--text-muted);">Check your inbox for the verification code</p>
      </div>

      <div class="field">
        <label for="verification-code">6-digit code</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7h6m0 0v6m0-6l-8 8-4-4-6 6"/></svg>
          </span>
          <input type="text" id="verification-code" x-model="code" maxlength="6" @input="code = code.replace(/[^0-9]/g, '')" placeholder="000000" class="code-input" autocomplete="off" />
        </div>
      </div>

      <button class="btn-primary" @click="verifyCode" :disabled="isLoading">
        <template x-if="!isLoading">
          <>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            Verify code
          </>
        </template>
        <template x-if="isLoading">
          <div class="flex items-center gap-2">
            <svg class="spinner w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
            Verifying...
          </div>
        </template>
      </button>

      <div class="action-links">
        <button class="resend-btn" @click="resendCode" :disabled="isResending">
          <span x-show="!isResending">↻ Resend code</span>
          <span x-show="isResending">Sending...</span>
        </button>
        <a href="/forgot-password">Start over</a>
      </div>

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
    // Theme handling identical to login page
    function toggleTheme() {
      const root = document.documentElement;
      const newTheme = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-theme', newTheme);
      localStorage.setItem('bg-theme', newTheme);
    }
    const savedTheme = localStorage.getItem('bg-theme');
    if (savedTheme) document.documentElement.setAttribute('data-theme', savedTheme);

    function verifyCodeHandler() {
      return {
        code: '',
        isLoading: false,
        isResending: false,
        errorMessage: '',
        successMessage: '',
        emailDisplay: '',
        
        initVerification() {
          setTimeout(() => {}, 50);
          // Retrieve email stored from forgot password flow
          const storedEmail = localStorage.getItem('reset_email');
          if (storedEmail && storedEmail !== 'undefined') {
            this.emailDisplay = storedEmail;
          } else {
            // fallback: try to fetch from a session endpoint if needed (graceful)
            this.emailDisplay = 'your email';
          }
        },
        
        async verifyCode() {
          if (!this.code || this.code.length !== 6) {
            this.errorMessage = 'Please enter the complete 6-digit verification code.';
            this.triggerCardShake();
            return;
          }
          this.isLoading = true;
          this.errorMessage = '';
          const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
          
          try {
            const response = await fetch('/verify-code', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
              },
              body: JSON.stringify({ code: this.code })
            });
            const data = await response.json();
            if (data.success) {
              this.successMessage = data.message || 'Code verified! Redirecting...';
              // clear stored email to avoid conflict
              localStorage.removeItem('reset_email');
              if (data.redirect) {
                setTimeout(() => { window.location.href = data.redirect; }, 900);
              } else {
                setTimeout(() => { window.location.href = '/reset-password'; }, 900);
              }
            } else {
              this.errorMessage = data.message || 'Invalid verification code. Please try again.';
              if (data.redirect) {
                window.location.href = data.redirect;
              } else {
                this.triggerCardShake();
              }
            }
          } catch (err) {
            console.error('Verification error', err);
            this.errorMessage = 'Network error. Could not verify the code.';
            this.triggerCardShake();
          } finally {
            this.isLoading = false;
          }
        },
        
        async resendCode() {
          this.isResending = true;
          this.errorMessage = '';
          this.successMessage = '';
          const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
          
          try {
            const response = await fetch('/resend-code', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrf,
                'Accept': 'application/json'
              }
            });
            const data = await response.json();
            if (data.success) {
              this.successMessage = data.message || 'New verification code sent to your email.';
              setTimeout(() => { this.successMessage = ''; }, 3500);
            } else {
              if (data.redirect) {
                window.location.href = data.redirect;
              } else {
                this.errorMessage = data.message || 'Unable to resend code. Please try again.';
                this.triggerCardShake();
              }
            }
          } catch (err) {
            this.errorMessage = 'Failed to resend code. Check your connection.';
            this.triggerCardShake();
          } finally {
            this.isResending = false;
          }
        },
        
        triggerCardShake() {
          const card = document.querySelector('.card');
          if (card) {
            card.classList.add('shake-animation');
            setTimeout(() => card.classList.remove('shake-animation'), 500);
          }
        }
      }
    }
  </script>
</body>
</html>