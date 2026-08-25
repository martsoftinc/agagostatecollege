<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Two-Factor Authentication — Bedency Group</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Fraunces:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; }

    :root[data-theme="dark"] {
      --bg: #0c0e18; --surface: #13151f; --surface2: #1a1d2e;
      --border: #1e2130; --border-focus: #3b5bdb;
      --text: #f1f3fa; --text-sub: #8892b0; --text-muted: #4a5270;
      --accent: #3b5bdb; --accent-light: #7899f6;
      --accent-glow: rgba(59,91,219,0.25); --input-bg: #0f1117;
      --btn-text: #ffffff; --geo-color: rgba(59,91,219,0.07);
      --warn-bg: rgba(234,179,8,0.08); --warn-border: rgba(234,179,8,0.2); --warn-text: #fbbf24;
      --success-bg: rgba(34,197,94,0.08); --success-border: rgba(34,197,94,0.2); --success-text: #4ade80;
      --error-bg: rgba(239,68,68,0.08); --error-border: rgba(239,68,68,0.2); --error-text: #f87171;
    }
    :root[data-theme="light"] {
      --bg: #f0f2fa; --surface: #ffffff; --surface2: #f4f6fb;
      --border: #dde1f0; --border-focus: #3b5bdb;
      --text: #111827; --text-sub: #4b5563; --text-muted: #9ca3af;
      --accent: #3b5bdb; --accent-light: #6480e8;
      --accent-glow: rgba(59,91,219,0.12); --input-bg: #f8f9fd;
      --btn-text: #ffffff; --geo-color: rgba(59,91,219,0.05);
      --warn-bg: rgba(234,179,8,0.08); --warn-border: rgba(234,179,8,0.25); --warn-text: #92400e;
      --success-bg: rgba(34,197,94,0.1); --success-border: rgba(34,197,94,0.3); --success-text: #15803d;
      --error-bg: rgba(239,68,68,0.08); --error-border: rgba(239,68,68,0.2); --error-text: #dc2626;
    }

    html, body { height: 100%; }
    body {
      background: var(--bg); color: var(--text);
      min-height: 100vh; display: flex; align-items: center;
      justify-content: center; position: relative;
      overflow: hidden; transition: background 0.4s, color 0.4s;
    }

    .bg-geo { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
    .geo-circle { position: absolute; border-radius: 50%; border: 1px solid var(--geo-color); transition: border-color 0.4s; }
    .geo-c1 { width: 600px; height: 600px; top: -200px; right: -150px; }
    .geo-c2 { width: 400px; height: 400px; top: -80px; right: 50px; }
    .geo-c3 { width: 800px; height: 800px; bottom: -350px; left: -200px; }
    .geo-c4 { width: 300px; height: 300px; bottom: 80px; left: 40px; }
    .geo-dot { position: absolute; width: 4px; height: 4px; background: var(--accent); border-radius: 50%; opacity: 0.5; }
    .dot1 { top: 18%; right: 22%; } .dot2 { top: 42%; right: 8%; }
    .dot3 { bottom: 25%; left: 18%; } .dot4 { top: 70%; left: 35%; }
    .blob { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.12; transition: opacity 0.4s; }
    [data-theme="light"] .blob { opacity: 0.07; }
    .blob1 { width: 400px; height: 400px; background: #3b5bdb; top: -80px; right: -60px; }
    .blob2 { width: 300px; height: 300px; background: #6480e8; bottom: -60px; left: -40px; }

    .card {
      position: relative; z-index: 1;
      background: var(--surface); border: 1px solid var(--border);
      border-radius: 20px; padding: 44px 40px; width: 100%; max-width: 420px;
      transition: background 0.4s, border-color 0.4s;
      animation: slideUp 0.55s cubic-bezier(0.22,1,0.36,1) both;
    }
    @media (max-width: 480px) { .card { padding: 32px 22px; margin: 16px; border-radius: 16px; } }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Shield badge */
    .shield-badge {
      width: 52px; height: 52px;
      background: var(--accent);
      border-radius: 14px;
      display: flex; align-items: center; justify-content: center;
      margin-bottom: 22px;
      box-shadow: 0 8px 24px var(--accent-glow);
    }

    .heading {
      font-family: 'Fraunces', Georgia, serif;
      font-size: 26px; font-weight: 400; color: var(--text);
      line-height: 1.2; letter-spacing: -0.3px; margin-bottom: 6px;
    }
    .subheading { font-size: 13.5px; color: var(--text-sub); margin-bottom: 28px; line-height: 1.55; }

    /* Masked email chip */
    .email-chip {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      background: var(--surface2);
      border: 1px solid var(--border);
      border-radius: 999px;
      padding: 5px 12px 5px 8px;
      font-size: 13px;
      color: var(--text-sub);
      font-weight: 500;
      margin-bottom: 28px;
    }
    .email-chip-dot {
      width: 7px; height: 7px;
      background: var(--accent);
      border-radius: 50%;
      box-shadow: 0 0 6px var(--accent);
      flex-shrink: 0;
    }

    /* OTP inputs */
    .otp-row { display: flex; gap: 10px; justify-content: center; margin-bottom: 8px; }
    .otp-input {
      width: 52px; height: 58px;
      background: var(--input-bg);
      border: 1.5px solid var(--border);
      border-radius: 12px;
      text-align: center;
      font-size: 22px; font-weight: 700;
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      outline: none;
      caret-color: var(--accent);
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .otp-input:focus { border-color: var(--border-focus); box-shadow: 0 0 0 3px var(--accent-glow); }
    .otp-input.filled { border-color: var(--accent); }
    @media (max-width: 380px) { .otp-input { width: 42px; height: 50px; font-size: 18px; } .otp-row { gap: 7px; } }

    .btn-primary {
      width: 100%; background: var(--accent); color: var(--btn-text);
      border: none; border-radius: 10px; padding: 13px;
      font-size: 14px; font-weight: 600; font-family: 'DM Sans', sans-serif;
      cursor: pointer; letter-spacing: 0.02em;
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
      box-shadow: 0 4px 16px var(--accent-glow);
      display: flex; align-items: center; justify-content: center; gap: 8px;
      margin-top: 6px;
    }
    .btn-primary:hover { background: #2f4dbf; transform: translateY(-1px); }
    .btn-primary:active { transform: translateY(0); }
    .btn-primary:disabled { opacity: 0.5; cursor: not-allowed; transform: none; }

    .divider { display: flex; align-items: center; gap: 12px; margin: 22px 0; color: var(--text-muted); font-size: 12px; }
    .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }

    .resend-row { text-align: center; font-size: 13px; color: var(--text-sub); }
    .resend-row button {
      background: none; border: none; cursor: pointer;
      color: var(--accent-light); font-weight: 600; font-size: 13px;
      font-family: 'DM Sans', sans-serif; padding: 0; transition: opacity 0.2s;
    }
    .resend-row button:hover { opacity: 0.75; }
    .resend-row button:disabled { opacity: 0.4; cursor: not-allowed; }

    .back-link { text-align: center; margin-top: 18px; }
    .back-link a {
      font-size: 12.5px; color: var(--text-muted); text-decoration: none;
      display: inline-flex; align-items: center; gap: 5px; transition: color 0.2s;
    }
    .back-link a:hover { color: var(--text-sub); }

    .alert-box {
      border-radius: 12px; padding: 12px 16px; margin-bottom: 20px;
      display: flex; gap: 12px; align-items: flex-start; font-size: 13px;
    }
    .alert-warn    { background: var(--warn-bg);    border: 1px solid var(--warn-border);    color: var(--warn-text); }
    .alert-success { background: var(--success-bg); border: 1px solid var(--success-border); color: var(--success-text); }
    .alert-error   { background: var(--error-bg);   border: 1px solid var(--error-border);   color: var(--error-text); }
    .alert-icon { flex-shrink: 0; margin-top: 1px; }

    .theme-btn {
      position: fixed; top: 20px; right: 20px; z-index: 10;
      width: 38px; height: 38px; border-radius: 10px;
      background: var(--surface); border: 1px solid var(--border);
      color: var(--text-sub); display: flex; align-items: center;
      justify-content: center; cursor: pointer;
      transition: background 0.3s, border-color 0.3s, color 0.2s;
    }
    .theme-btn:hover { color: var(--text); }
    [data-theme="dark"]  .icon-sun  { display: block; }
    [data-theme="dark"]  .icon-moon { display: none; }
    [data-theme="light"] .icon-sun  { display: none; }
    [data-theme="light"] .icon-moon { display: block; }

    .shake-animation { animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97) both; }
    @keyframes shake {
      10%, 90% { transform: translateX(-1px); }
      20%, 80% { transform: translateX(2px); }
      30%, 50%, 70% { transform: translateX(-3px); }
      40%, 60% { transform: translateX(3px); }
    }
  </style>
</head>
<body>

  <div class="bg-geo">
    <div class="blob blob1"></div><div class="blob blob2"></div>
    <div class="geo-circle geo-c1"></div><div class="geo-circle geo-c2"></div>
    <div class="geo-circle geo-c3"></div><div class="geo-circle geo-c4"></div>
    <div class="geo-dot dot1"></div><div class="geo-dot dot2"></div>
    <div class="geo-dot dot3"></div><div class="geo-dot dot4"></div>
  </div>

  <button class="theme-btn" onclick="toggleTheme()" aria-label="Toggle theme">
    <svg class="icon-sun w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
    <svg class="icon-moon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
  </button>

  <div class="card" id="challenge-card">

    <!-- Shield icon -->
    <div class="shield-badge">
      <svg class="w-6 h-6" fill="none" stroke="white" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6
             11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623
             5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152
             c-3.196 0-6.1-1.248-8.25-3.285Z"/>
      </svg>
    </div>

    <h1 class="heading">Two-factor check</h1>
    <p class="subheading">Enter the 6-digit code we sent to your email address.</p>

    <!-- Masked email chip -->
    <div class="email-chip">
      <span class="email-chip-dot"></span>
      {{ App\Http\Controllers\TwoFactorController::maskEmail(
            \App\Models\User::find(session('2fa_user_id'))?->email ?? ''
         ) }}
    </div>

    {{-- Spam notice --}}
    <div class="alert-box alert-warn">
      <svg class="alert-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/></svg>
      <span>Can't find the email? Check your <strong>Spam</strong> or <strong>Junk</strong> folder.</span>
    </div>

    {{-- Resend success --}}
    @if(session('resend_success'))
    <div class="alert-box alert-success">
      <svg class="alert-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <span>{{ session('resend_success') }}</span>
    </div>
    @endif

    {{-- Resend / rate-limit error --}}
    @if(session('resend_error'))
    <div class="alert-box alert-error">
      <svg class="alert-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <span>{{ session('resend_error') }}</span>
    </div>
    @endif

    {{-- Validation error --}}
    @if($errors->any())
    <div class="alert-box alert-error" id="error-box">
      <svg class="alert-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <span>{{ $errors->first() }}</span>
    </div>
    @endif

    {{-- OTP form --}}
    <form method="POST" action="{{ route('two-factor.verify') }}" id="otp-form">
      @csrf
      <input type="hidden" name="code" id="code-hidden"/>

      <div class="otp-row" id="otp-row">
        <input class="otp-input" type="text" inputmode="numeric" maxlength="1" data-index="0" autocomplete="one-time-code"/>
        <input class="otp-input" type="text" inputmode="numeric" maxlength="1" data-index="1" autocomplete="off"/>
        <input class="otp-input" type="text" inputmode="numeric" maxlength="1" data-index="2" autocomplete="off"/>
        <input class="otp-input" type="text" inputmode="numeric" maxlength="1" data-index="3" autocomplete="off"/>
        <input class="otp-input" type="text" inputmode="numeric" maxlength="1" data-index="4" autocomplete="off"/>
        <input class="otp-input" type="text" inputmode="numeric" maxlength="1" data-index="5" autocomplete="off"/>
      </div>

      <button type="submit" class="btn-primary" id="submit-btn" disabled>
        <svg class="w-4 h-4" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z"/></svg>
        Verify & sign in
      </button>
    </form>

    <div class="divider">or</div>

    <div class="resend-row">
      Didn't receive it?
      <form method="POST" action="{{ route('two-factor.resend') }}" style="display:inline">
        @csrf
        <button type="submit" id="resend-btn">Resend code</button>
      </form>
      <span id="resend-timer" style="color:var(--text-muted); font-size:13px; display:none;"></span>
    </div>

    <div class="back-link">
      <a href="{{ route('login') }}">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Back to login
      </a>
    </div>

  </div>

  <script>
    // Theme
    function toggleTheme() {
      const root = document.documentElement;
      const next = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
      root.setAttribute('data-theme', next);
      localStorage.setItem('bg-theme', next);
    }
    const saved = localStorage.getItem('bg-theme');
    if (saved) document.documentElement.setAttribute('data-theme', saved);

    // OTP inputs
    const inputs    = Array.from(document.querySelectorAll('.otp-input'));
    const hidden    = document.getElementById('code-hidden');
    const submitBtn = document.getElementById('submit-btn');

    function syncHidden() {
      const val = inputs.map(i => i.value).join('');
      hidden.value = val;
      submitBtn.disabled = val.length < 6;
      inputs.forEach(i => i.classList.toggle('filled', i.value !== ''));
    }

    inputs.forEach((input, idx) => {
      input.addEventListener('input', () => {
        input.value = input.value.replace(/\D/g, '').slice(-1);
        if (input.value && idx < 5) inputs[idx + 1].focus();
        syncHidden();
      });
      input.addEventListener('keydown', e => {
        if (e.key === 'Backspace' && !input.value && idx > 0) {
          inputs[idx - 1].focus();
          inputs[idx - 1].value = '';
          syncHidden();
        }
        if (e.key === 'ArrowLeft'  && idx > 0) inputs[idx - 1].focus();
        if (e.key === 'ArrowRight' && idx < 5) inputs[idx + 1].focus();
      });
      input.addEventListener('paste', e => {
        e.preventDefault();
        const pasted = (e.clipboardData || window.clipboardData)
          .getData('text').replace(/\D/g, '').slice(0, 6);
        pasted.split('').forEach((ch, i) => { if (inputs[i]) inputs[i].value = ch; });
        inputs[Math.min(pasted.length, 5)].focus();
        syncHidden();
      });
    });

    inputs[0].focus();

    // Shake on error
    @if($errors->any())
    document.addEventListener('DOMContentLoaded', () => {
      const card = document.getElementById('challenge-card');
      card.classList.add('shake-animation');
      setTimeout(() => card.classList.remove('shake-animation'), 500);
    });
    @endif

    // Resend cooldown
    @if(session('resend_success'))
    startResendCooldown(60);
    @endif

    function startResendCooldown(seconds) {
      const btn   = document.getElementById('resend-btn');
      const timer = document.getElementById('resend-timer');
      btn.disabled = true;
      btn.style.display = 'none';
      timer.style.display = 'inline';
      let remaining = seconds;
      timer.textContent = `Resend in ${remaining}s`;
      const iv = setInterval(() => {
        remaining--;
        timer.textContent = `Resend in ${remaining}s`;
        if (remaining <= 0) {
          clearInterval(iv);
          timer.style.display = 'none';
          btn.style.display = 'inline';
          btn.disabled = false;
        }
      }, 1000);
    }
  </script>
</body>
</html>