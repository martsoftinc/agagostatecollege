<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your login code — Bedency Group</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: #f0f2fa;
      padding: 40px 16px;
      color: #111827;
    }
    .wrapper { max-width: 520px; margin: 0 auto; }

    .header {
      background: #0c0e18;
      border-radius: 16px 16px 0 0;
      padding: 32px 40px;
      text-align: center;
    }
    .brand { display: inline-flex; align-items: center; gap: 10px; }
    .brand-icon {
      width: 36px; height: 36px; background: #3b5bdb;
      border-radius: 10px; display: inline-flex;
      align-items: center; justify-content: center;
    }
    .brand-name { font-size: 17px; font-weight: 700; color: #f1f3fa; letter-spacing: -0.2px; }

    .body-card { background: #ffffff; padding: 44px 40px 36px; }

    /* Security shield banner */
    .shield-banner {
      display: flex;
      align-items: center;
      gap: 14px;
      background: #eff6ff;
      border: 1.5px solid #bfdbfe;
      border-radius: 14px;
      padding: 16px 20px;
      margin-bottom: 28px;
    }
    .shield-icon {
      width: 42px; height: 42px;
      background: #3b5bdb;
      border-radius: 11px;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .shield-title { font-size: 14px; font-weight: 700; color: #1e3a8a; }
    .shield-sub   { font-size: 12px; color: #3b82f6; margin-top: 2px; }

    .greeting  { font-size: 22px; font-weight: 600; color: #111827; margin-bottom: 10px; letter-spacing: -0.3px; }
    .intro     { font-size: 14.5px; color: #4b5563; line-height: 1.65; margin-bottom: 30px; }

    .code-label { font-size: 11px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase; color: #9ca3af; margin-bottom: 10px; }

    .code-block {
      background: #f8fafc;
      border: 1.5px solid #e2e8f0;
      border-radius: 16px;
      padding: 28px 24px 20px;
      text-align: center;
      margin-bottom: 28px;
      position: relative;
    }
    .code-digits {
      font-family: 'DM Mono', 'Courier New', monospace;
      font-size: 42px;
      font-weight: 700;
      letter-spacing: 12px;
      color: #0c0e18;
      padding-right: 12px; /* compensate for letter-spacing on last char */
    }
    .code-expiry {
      font-size: 12px;
      color: #9ca3af;
      margin-top: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
    }
    .expiry-dot {
      width: 6px; height: 6px;
      background: #f59e0b;
      border-radius: 50%;
      display: inline-block;
    }

    /* Warning notice */
    .warn-notice {
      background: #fffbeb;
      border: 1.5px solid #fde68a;
      border-radius: 12px;
      padding: 14px 18px;
      display: flex;
      gap: 12px;
      align-items: flex-start;
      margin-bottom: 28px;
    }
    .warn-emoji { font-size: 18px; flex-shrink: 0; margin-top: 1px; }
    .warn-text  { font-size: 13px; color: #92400e; line-height: 1.55; }
    .warn-text strong { color: #78350f; }

    .divider { height: 1px; background: #f3f4f6; margin: 28px 0; }

    .note   { font-size: 13px; color: #6b7280; line-height: 1.6; }
    .note a { color: #3b5bdb; text-decoration: none; font-weight: 600; }

    .footer {
      background: #f8f9fd;
      border: 1px solid #dde1f0;
      border-top: none;
      border-radius: 0 0 16px 16px;
      padding: 24px 40px;
      text-align: center;
    }
    .footer-text { font-size: 12px; color: #9ca3af; line-height: 1.6; }
    .footer-text a { color: #6b7280; text-decoration: none; }
  </style>
</head>
<body>
  <div class="wrapper">

    <div class="header">
      <div class="brand">
        <div class="brand-icon">
          <svg width="18" height="18" fill="none" stroke="white" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
          </svg>
        </div>
        <span class="brand-name">Bedency Group</span>
      </div>
    </div>

    <div class="body-card">

      <!-- Security banner -->
      <div class="shield-banner">
        <div class="shield-icon">
          <svg width="20" height="20" fill="none" stroke="white" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6
                 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623
                 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152
                 c-3.196 0-6.1-1.248-8.25-3.285Z"/>
          </svg>
        </div>
        <div>
          <div class="shield-title">Two-Factor Authentication</div>
          <div class="shield-sub">Sign-in verification for your account</div>
        </div>
      </div>

      <p class="greeting">Hi {{ $firstName }},</p>
      <p class="intro">
        A sign-in was attempted on your Bedency Group account.
        Enter the code below to complete the login. If this wasn't you,
        <strong style="color:#111827">ignore this email</strong> — your account remains safe.
      </p>

      <p class="code-label">Your one-time login code</p>
      <div class="code-block">
        <div class="code-digits">{{ $code }}</div>
        <div class="code-expiry">
          <span class="expiry-dot"></span>
          Expires in 10 minutes
        </div>
      </div>

      <!-- Spam / delivery notice -->
      <div class="warn-notice">
        <div class="warn-emoji">📬</div>
        <div class="warn-text">
          <strong>Can't find this email?</strong> Check your <strong>Spam</strong> or
          <strong>Junk</strong> folder. Mark it as "Not spam" so future codes reach your inbox instantly.
        </div>
      </div>

      <div class="divider"></div>

      <p class="note">
        This code can only be used once and expires in 10 minutes.
        Never share it with anyone — Bedency Group staff will never ask for your code.<br><br>
        Questions? Contact <a href="mailto:support@bedency.com">support@bedency.com</a>
      </p>
    </div>

    <div class="footer">
      <p class="footer-text">
        © {{ date('Y') }} Bedency Group. All rights reserved.<br>
        <a href="#">Privacy Policy</a> &nbsp;·&nbsp; <a href="#">Terms of Service</a>
      </p>
    </div>

  </div>
</body>
</html>