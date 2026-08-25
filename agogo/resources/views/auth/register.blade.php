<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Create Account — Bedency Group</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Fraunces:ital,wght@0,300;0,400;0,600;1,300;1,400&display=swap" rel="stylesheet"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
    body { font-family: 'DM Sans', sans-serif; }

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
      --select-arrow: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%234a5270' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
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
      --select-arrow: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239ca3af' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
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

    /* ── Geometric background ── */
    .bg-geo { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
    .geo-circle {
      position: absolute; border-radius: 50%;
      border: 1px solid var(--geo-color);
      transition: border-color 0.4s;
    }
    .geo-c1 { width: 600px; height: 600px; top: -200px; right: -150px; }
    .geo-c2 { width: 400px; height: 400px; top: -80px;  right: 50px; }
    .geo-c3 { width: 800px; height: 800px; bottom: -350px; left: -200px; }
    .geo-c4 { width: 300px; height: 300px; bottom: 80px; left: 40px; }
    .geo-dot { position: absolute; width: 4px; height: 4px; background: var(--accent); border-radius: 50%; opacity: 0.5; }
    .dot1 { top: 18%; right: 22%; }
    .dot2 { top: 42%; right: 8%; }
    .dot3 { bottom: 25%; left: 18%; }
    .dot4 { top: 70%; left: 35%; }
    .blob { position: absolute; border-radius: 50%; filter: blur(80px); opacity: 0.12; transition: opacity 0.4s; }
    [data-theme="light"] .blob { opacity: 0.07; }
    .blob1 { width: 400px; height: 400px; background: #3b5bdb; top: -80px; right: -60px; }
    .blob2 { width: 300px; height: 300px; background: #6480e8; bottom: -60px; left: -40px; }

    /* ── Card — taller for register ── */
    .card {
      position: relative; z-index: 1;
      background: var(--surface);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 44px 40px;
      width: 100%;
      max-width: 460px;
      transition: background 0.4s, border-color 0.4s;
      animation: slideUp 0.55s cubic-bezier(0.22,1,0.36,1) both;
      /* allow scrolling on small screens */
      max-height: calc(100vh - 48px);
      overflow-y: auto;
      scrollbar-width: none;
    }
    .card::-webkit-scrollbar { display: none; }
    @media (max-width: 480px) {
      .card { padding: 32px 22px; margin: 16px; border-radius: 16px; }
    }
    @keyframes slideUp {
      from { opacity: 0; transform: translateY(28px); }
      to   { opacity: 1; transform: translateY(0); }
    }

    /* Typography */
    .heading {
      font-family: 'Fraunces', Georgia, serif;
      font-size: 26px; font-weight: 400;
      color: var(--text); line-height: 1.2;
      letter-spacing: -0.3px; margin-bottom: 6px;
    }
    .subheading {
      font-size: 13.5px; color: var(--text-sub);
      margin-bottom: 28px; line-height: 1.5;
    }

    /* Section divider label */
    .section-label {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: var(--text-muted);
      margin: 22px 0 14px;
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .section-label::after {
      content: ''; flex: 1; height: 1px; background: var(--border);
    }

    /* Fields */
    .field { margin-bottom: 16px; }
    .field label {
      display: block;
      font-size: 12px; font-weight: 600;
      letter-spacing: 0.06em; text-transform: uppercase;
      color: var(--text-sub); margin-bottom: 7px;
    }
    .input-wrap { position: relative; }
    .input-icon {
      position: absolute; left: 13px; top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted); pointer-events: none; transition: color 0.2s;
    }
    /* shared input/select base */
    .field input,
    .field select {
      width: 100%;
      background: var(--input-bg);
      border: 1.5px solid var(--border);
      border-radius: 10px;
      padding: 11px 13px 11px 40px;
      font-size: 14px; color: var(--text);
      font-family: 'DM Sans', sans-serif;
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.3s;
    }
    .field input:focus,
    .field select:focus {
      border-color: var(--border-focus);
      box-shadow: 0 0 0 3px var(--accent-glow);
    }
    .field input::placeholder { color: var(--text-muted); }

    /* Select custom styling */
    .field select {
      appearance: none;
      -webkit-appearance: none;
      background-image: var(--select-arrow);
      background-repeat: no-repeat;
      background-position: right 14px center;
      padding-right: 36px;
      cursor: pointer;
    }
    .field select option {
      background: var(--surface);
      color: var(--text);
    }
    /* Empty/placeholder select option */
    .field select.placeholder-shown { color: var(--text-muted); }

    /* Phone input — flag prefix */
    .phone-wrap { position: relative; }
    .phone-prefix {
      position: absolute; left: 40px; top: 50%;
      transform: translateY(-50%);
      font-size: 13px; color: var(--text-sub);
      pointer-events: none; font-weight: 500;
      border-right: 1.5px solid var(--border);
      padding-right: 10px; line-height: 1;
    }
    .phone-input { padding-left: 90px !important; }

    /* Password right-toggle */
    .field input.has-right-icon { padding-right: 42px; }
    .input-icon-right {
      position: absolute; right: 13px; top: 50%;
      transform: translateY(-50%);
      color: var(--text-muted); cursor: pointer;
      background: none; border: none; padding: 0;
      display: flex; align-items: center; transition: color 0.2s;
    }
    .input-icon-right:hover { color: var(--text-sub); }

    /* Two-column grid */
    .field-grid {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 14px;
    }
    @media (max-width: 420px) { .field-grid { grid-template-columns: 1fr; } }

    /* Password strength bar */
    .strength-bar-wrap {
      margin-top: 8px;
      display: flex; gap: 4px;
    }
    .strength-seg {
      flex: 1; height: 3px; border-radius: 99px;
      background: var(--border);
      transition: background 0.3s;
    }
    .strength-seg.active-weak   { background: #ef4444; }
    .strength-seg.active-fair   { background: #f59e0b; }
    .strength-seg.active-good   { background: #3b82f6; }
    .strength-seg.active-strong { background: #22c55e; }
    .strength-label {
      font-size: 11px; color: var(--text-muted);
      margin-top: 5px; text-align: right;
      min-height: 16px;
      transition: color 0.3s;
    }

    /* Button */
    .btn-primary {
      width: 100%; background: var(--accent); color: var(--btn-text);
      border: none; border-radius: 10px; padding: 13px;
      font-size: 14px; font-weight: 600;
      font-family: 'DM Sans', sans-serif; cursor: pointer;
      letter-spacing: 0.02em;
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
      box-shadow: 0 4px 16px var(--accent-glow);
      display: flex; align-items: center; justify-content: center; gap: 8px;
      margin-top: 8px;
    }
    .btn-primary:hover { background: #2f4dbf; transform: translateY(-1px); box-shadow: 0 6px 22px var(--accent-glow); }
    .btn-primary:active { transform: translateY(0); }

    /* Divider */
    .divider { display: flex; align-items: center; gap: 12px; margin: 24px 0; color: var(--text-muted); font-size: 12px; }
    .divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: var(--border); }

    /* Sign-in link */
    .signin-row { text-align: center; font-size: 13px; color: var(--text-sub); }
    .signin-row a { color: var(--accent-light); text-decoration: none; font-weight: 600; transition: opacity 0.2s; }
    .signin-row a:hover { opacity: 0.75; }

    /* Alert */
    .alert-box {
      border-radius: 12px; padding: 12px 16px; margin-bottom: 24px;
      display: flex; gap: 12px; align-items: flex-start; font-size: 13px;
    }
    .alert-error { background: var(--error-bg); border: 1px solid var(--error-border); color: var(--error-text); }
    .alert-icon { flex-shrink: 0; margin-top: 1px; }

    /* Theme toggle */
    .theme-btn {
      position: fixed; top: 20px; right: 20px; z-index: 10;
      width: 38px; height: 38px; border-radius: 10px;
      background: var(--surface); border: 1px solid var(--border);
      color: var(--text-sub); display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: background 0.3s, border-color 0.3s, color 0.2s;
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

  <button class="theme-btn" onclick="toggleTheme()" title="Toggle theme" aria-label="Theme switch">
    <svg class="icon-sun w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707M17.657 17.657l-.707-.707M6.343 6.343l-.707-.707M12 8a4 4 0 100 8 4 4 0 000-8z"/></svg>
    <svg class="icon-moon w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
  </button>

  <div class="card" id="register-card">

    <h1 class="heading">Create account</h1>
    <p class="subheading">Join Bedency Group — fill in your details below</p>

    @if(session('error'))
    <div class="alert-box alert-error">
      <svg class="alert-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <span>{{ session('error') }}</span>
    </div>
    @endif

    @if($errors->any())
    <div class="alert-box alert-error">
      <svg class="alert-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      <ul style="list-style: disc; padding-left: 14px;">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form method="POST" action="#">
      @csrf

      <!-- ── Personal info ── -->
      <div class="section-label">Personal information</div>

      <!-- Full name -->
      <div class="field">
        <label for="full_name">Full name</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          </span>
          <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" placeholder="John Mensah" autocomplete="name" required/>
        </div>
      </div>

      <!-- Nationality + Region side by side -->
      <div class="field-grid">

        <div class="field" style="margin-bottom:0">
          <label for="nationality">Nationality</label>
          <div class="input-wrap">
            <span class="input-icon">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6H13.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/></svg>
            </span>
            <select id="nationality" name="nationality" required>
              <option value="" disabled {{ old('nationality') ? '' : 'selected' }}>Select…</option>
              <option value="Ghanaian"    {{ old('nationality') == 'Ghanaian' ? 'selected' : '' }}>Ghanaian</option>
              <option value="Nigerian"    {{ old('nationality') == 'Nigerian' ? 'selected' : '' }}>Nigerian</option>
              <option value="Ivorian"     {{ old('nationality') == 'Ivorian' ? 'selected' : '' }}>Ivorian</option>
              <option value="Togolese"    {{ old('nationality') == 'Togolese' ? 'selected' : '' }}>Togolese</option>
              <option value="Burkinabe"   {{ old('nationality') == 'Burkinabe' ? 'selected' : '' }}>Burkinabé</option>
              <option value="Senegalese"  {{ old('nationality') == 'Senegalese' ? 'selected' : '' }}>Senegalese</option>
              <option value="American"    {{ old('nationality') == 'American' ? 'selected' : '' }}>American</option>
              <option value="British"     {{ old('nationality') == 'British' ? 'selected' : '' }}>British</option>
              <option value="Other"       {{ old('nationality') == 'Other' ? 'selected' : '' }}>Other</option>
            </select>
          </div>
        </div>

        <div class="field" style="margin-bottom:0">
          <label for="region">Region (Ghana)</label>
          <div class="input-wrap">
            <span class="input-icon">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </span>
            <select id="region" name="region" required>
              <option value="" disabled {{ old('region') ? '' : 'selected' }}>Select…</option>
              <option value="Greater Accra"  {{ old('region') == 'Greater Accra' ? 'selected' : '' }}>Greater Accra</option>
              <option value="Ashanti"        {{ old('region') == 'Ashanti' ? 'selected' : '' }}>Ashanti</option>
              <option value="Western"        {{ old('region') == 'Western' ? 'selected' : '' }}>Western</option>
              <option value="Western North"  {{ old('region') == 'Western North' ? 'selected' : '' }}>Western North</option>
              <option value="Central"        {{ old('region') == 'Central' ? 'selected' : '' }}>Central</option>
              <option value="Eastern"        {{ old('region') == 'Eastern' ? 'selected' : '' }}>Eastern</option>
              <option value="Volta"          {{ old('region') == 'Volta' ? 'selected' : '' }}>Volta</option>
              <option value="Oti"            {{ old('region') == 'Oti' ? 'selected' : '' }}>Oti</option>
              <option value="Northern"       {{ old('region') == 'Northern' ? 'selected' : '' }}>Northern</option>
              <option value="Savannah"       {{ old('region') == 'Savannah' ? 'selected' : '' }}>Savannah</option>
              <option value="North East"     {{ old('region') == 'North East' ? 'selected' : '' }}>North East</option>
              <option value="Upper East"     {{ old('region') == 'Upper East' ? 'selected' : '' }}>Upper East</option>
              <option value="Upper West"     {{ old('region') == 'Upper West' ? 'selected' : '' }}>Upper West</option>
              <option value="Bono"           {{ old('region') == 'Bono' ? 'selected' : '' }}>Bono</option>
              <option value="Bono East"      {{ old('region') == 'Bono East' ? 'selected' : '' }}>Bono East</option>
              <option value="Ahafo"          {{ old('region') == 'Ahafo' ? 'selected' : '' }}>Ahafo</option>
            </select>
          </div>
        </div>

      </div>

      <!-- ── Contact info ── -->
      <div class="section-label">Contact details</div>

      <!-- Phone -->
      <div class="field">
        <label for="phone">Phone number</label>
        <div class="input-wrap phone-wrap">
          <span class="input-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
          </span>
          <span class="phone-prefix">🇬🇭 +233</span>
          <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="24 000 0000" autocomplete="tel" class="phone-input" required/>
        </div>
      </div>

      <!-- Email -->
      <div class="field">
        <label for="email">Email address</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
          </span>
          <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" autocomplete="email" required/>
        </div>
      </div>

      <!-- ── Security ── -->
      <div class="section-label">Security</div>

      <!-- Password -->
      <div class="field">
        <label for="password">Password</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
          </span>
          <input type="password" id="password" name="password" placeholder="••••••••" autocomplete="new-password" class="has-right-icon" required oninput="checkStrength(this.value)"/>
          <button type="button" class="input-icon-right" onclick="togglePassword('password','eye-pw')" aria-label="Toggle password">
            <svg id="eye-pw" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
        <!-- Strength indicator -->
        <div class="strength-bar-wrap">
          <div class="strength-seg" id="seg1"></div>
          <div class="strength-seg" id="seg2"></div>
          <div class="strength-seg" id="seg3"></div>
          <div class="strength-seg" id="seg4"></div>
        </div>
        <div class="strength-label" id="strength-label"></div>
      </div>

      <!-- Confirm password -->
      <div class="field">
        <label for="password_confirmation">Confirm password</label>
        <div class="input-wrap">
          <span class="input-icon">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
          </span>
          <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" autocomplete="new-password" class="has-right-icon" required/>
          <button type="button" class="input-icon-right" onclick="togglePassword('password_confirmation','eye-pc')" aria-label="Toggle confirm password">
            <svg id="eye-pc" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
            </svg>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="white" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
        Create account
      </button>
    </form>

    <div class="divider">or</div>
    <div class="signin-row">
      Already have an account? <a href="{{ route('login') }}">Sign in</a>
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

    // Password visibility toggle
    const eyeOpen  = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>`;
    const eyeClosed = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>`;

    function togglePassword(inputId, iconId) {
      const input = document.getElementById(inputId);
      const icon  = document.getElementById(iconId);
      const show  = input.type === 'password';
      input.type  = show ? 'text' : 'password';
      icon.innerHTML = show ? eyeClosed : eyeOpen;
    }

    // Password strength
    function checkStrength(val) {
      const segs   = [1,2,3,4].map(i => document.getElementById('seg' + i));
      const label  = document.getElementById('strength-label');
      const levels = ['active-weak','active-fair','active-good','active-strong'];
      const labels = ['Weak','Fair','Good','Strong'];
      const colors = ['#ef4444','#f59e0b','#3b82f6','#22c55e'];

      let score = 0;
      if (val.length >= 8)           score++;
      if (/[A-Z]/.test(val))         score++;
      if (/[0-9]/.test(val))         score++;
      if (/[^A-Za-z0-9]/.test(val))  score++;

      segs.forEach((s, i) => {
        s.className = 'strength-seg';
        if (i < score) s.classList.add(levels[score - 1]);
      });

      if (val.length === 0) {
        label.textContent = '';
        label.style.color = '';
      } else {
        label.textContent = labels[score - 1] || 'Too short';
        label.style.color = score > 0 ? colors[score - 1] : 'var(--text-muted)';
      }
    }

    // Shake on server-side errors
    @if($errors->any() || session('error'))
    document.addEventListener('DOMContentLoaded', () => {
      const card = document.getElementById('register-card');
      card.classList.add('shake-animation');
      setTimeout(() => card.classList.remove('shake-animation'), 500);
    });
    @endif
  </script>
</body>
</html>