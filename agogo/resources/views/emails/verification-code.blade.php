

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Verify your email — Bedency Group</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      background: #f0f2fa;
      padding: 40px 16px;
      color: #111827;
    }
    .wrapper {
      max-width: 520px;
      margin: 0 auto;
    }
    /* Header bar */
    .header {
      background: #0c0e18;
      border-radius: 16px 16px 0 0;
      padding: 32px 40px;
      text-align: center;
    }
    .brand {
      display: inline-flex;
      align-items: center;
      gap: 10px;
    }
    .brand-icon {
      width: 36px; height: 36px;
      background: #3b5bdb;
      border-radius: 10px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    .brand-name {
      font-size: 17px;
      font-weight: 700;
      color: #f1f3fa;
      letter-spacing: -0.2px;
    }
    /* Body card */
    .body-card {
      background: #ffffff;
      padding: 44px 40px 36px;
    }
    .greeting {
      font-size: 22px;
      font-weight: 600;
      color: #111827;
      margin-bottom: 12px;
      letter-spacing: -0.3px;
    }
    .intro {
      font-size: 14.5px;
      color: #4b5563;
      line-height: 1.65;
      margin-bottom: 32px;
    }
    /* Code block */
    .code-label {
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.1em;
      text-transform: uppercase;
      color: #9ca3af;
      margin-bottom: 10px;
    }
    .code-block {
      background: #f0f2fa;
      border: 1.5px solid #dde1f0;
      border-radius: 14px;
      padding: 24px;
      text-align: center;
      margin-bottom: 28px;
    }
    .code-digits {
      font-family: 'DM Mono', 'Courier New', monospace;
      font-size: 38px;
      font-weight: 600;
      letter-spacing: 10px;
      color: #0c0e18;
      /* pad right to compensate for letter-spacing on last char */
      padding-right: 10px;
    }
    .code-expiry {
      font-size: 12px;
      color: #9ca3af;
      margin-top: 10px;
    }
    /* Spam notice */
    .spam-notice {
      background: #fffbeb;
      border: 1.5px solid #fde68a;
      border-radius: 12px;
      padding: 14px 18px;
      display: flex;
      gap: 12px;
      align-items: flex-start;
      margin-bottom: 28px;
    }
    .spam-icon {
      font-size: 18px;
      flex-shrink: 0;
      margin-top: 1px;
    }
    .spam-text {
      font-size: 13px;
      color: #92400e;
      line-height: 1.55;
    }
    .spam-text strong {
      color: #78350f;
    }
    /* Divider */
    .divider {
      height: 1px;
      background: #f3f4f6;
      margin: 28px 0;
    }
    .note {
      font-size: 13px;
      color: #6b7280;
      line-height: 1.6;
    }
    .note a {
      color: #3b5bdb;
      text-decoration: none;
      font-weight: 600;
    }
    /* Footer */
    .footer {
      background: #f8f9fd;
      border: 1px solid #dde1f0;
      border-top: none;
      border-radius: 0 0 16px 16px;
      padding: 24px 40px;
      text-align: center;
    }
    .footer-text {
      font-size: 12px;
      color: #9ca3af;
      line-height: 1.6;
    }
    .footer-text a {
      color: #6b7280;
      text-decoration: none;
    }
  </style>
</head>
<body>
  <div class="wrapper">

    <!-- Header -->
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

    <!-- Body -->
    <div class="body-card">
      <p class="greeting">Hi {{ $firstName }},</p>
      <p class="intro">
        Thanks for signing up. To finish creating your Bedency Group account,
        enter the 6-digit code below on the verification page.
        This code is valid for <strong>10 minutes</strong>.
      </p>

      <p class="code-label">Your verification code</p>
      <div class="code-block">
        <div class="code-digits">{{ $code }}</div>
        <div class="code-expiry">Expires in 10 minutes</div>
      </div>

      <!-- Spam notice -->
      <div class="spam-notice">
        <div class="spam-icon">📬</div>
        <div class="spam-text">
          <strong>Can't find this email?</strong> Check your <strong>Spam</strong> or
          <strong>Junk</strong> folder — it sometimes ends up there.
          Mark it as "Not spam" so future emails reach your inbox.
        </div>
      </div>

      <div class="divider"></div>

      <p class="note">
        If you didn't create a Bedency Group account, you can safely ignore this email —
        no account will be activated without the code.<br><br>
        Need help? Contact us at
        <a href="mailto:support@bedency.com">support@bedency.com</a>
      </p>
    </div>

    <!-- Footer -->
    <div class="footer">
      <p class="footer-text">
        © {{ date('Y') }} Bedency Group. All rights reserved.<br>
        <a href="#">Privacy Policy</a> &nbsp;·&nbsp; <a href="#">Terms of Service</a>
      </p>
    </div>

  </div>
</body>
</html>
EOF