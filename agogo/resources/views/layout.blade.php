<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0" />
  <title>@yield('title', 'Agogo State College — Excellence in Character and Learning')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['Plus Jakarta Sans', 'sans-serif'] },
          colors: {
            forest: { DEFAULT: '#0F3836', deep: '#062E2B' },
            lime: { DEFAULT: '#D4F54C', soft: '#CEF141' },
            ivory: '#F8F9FA',
            ink: '#111827',
            muted: '#6B7280',
          },
          letterSpacing: { tightish: '-0.02em' }
        }
      }
    }
  </script>
  <style>
    /* RESET & BASE */
    * { margin: 0; padding: 0; box-sizing: border-box; }
    html { scroll-behavior: smooth; overflow-x: hidden; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: #111827;
      background: #ffffff;
      overflow-x: hidden;
      width: 100%;
      max-width: 100vw;
    }
    img, video, iframe { max-width: 100%; height: auto; display: block; }
    .dashed-line {
      background-image: repeating-linear-gradient(90deg, #D1D5DB 0, #D1D5DB 6px, transparent 6px, transparent 14px);
      height: 2px;
    }
    .star-badge {
      clip-path: polygon(50% 0%, 61% 35%, 98% 35%, 68% 57%, 79% 91%, 50% 70%, 21% 91%, 32% 57%, 2% 35%, 39% 35%);
    }
    .bg-noise {
      background-image: radial-gradient(circle, rgba(255,255,255,0.06) 1px, transparent 1px);
      background-size: 18px 18px;
    }
    .card-hover { transition: transform .25s ease, box-shadow .25s ease; }
    .card-hover:hover { transform: translateY(-6px); box-shadow: 0 20px 40px -12px rgba(15,56,54,0.18); }
    ::selection { background: #D4F54C; color: #0F3836; }
    :focus-visible { outline: 2px solid #0F3836; outline-offset: 3px; }

    /* Hero slider */
    .slide { opacity: 0; transition: opacity 1s ease; position: absolute; inset: 0; }
    .slide.active { opacity: 1; z-index: 5; }
    .slide-dot { transition: all .3s ease; }
    .slide-dot.active { width: 26px; background: #D4F54C; }

    /* Fix for mobile whitespace: ensure all containers respect viewport width */
    .max-w-7xl, .max-w-4xl, .max-w-3xl, .max-w-2xl, .max-w-xl, .max-w-md {
      width: 100%;
      max-width: 100%;
    }
    .px-6, .px-8, .px-10, .px-14 { padding-left: 1.25rem; padding-right: 1.25rem; }
    @media (min-width: 640px) {
      .px-6 { padding-left: 1.5rem; padding-right: 1.5rem; }
    }
    @media (min-width: 1024px) {
      .px-10 { padding-left: 2.5rem; padding-right: 2.5rem; }
    }

    /* Stats bar */
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(2, 1fr);
      gap: 0;
    }
    @media (min-width: 640px) {
      .stats-grid { grid-template-columns: repeat(4, 1fr); }
    }
    .stats-grid > div { padding: 1.25rem 0.5rem; }
    @media (min-width: 480px) {
      .stats-grid > div { padding: 1.5rem 1rem; }
    }

    .card-img { width: 100%; height: 12rem; object-fit: cover; }
    @media (min-width: 640px) { .card-img { height: 14rem; } }

    .video-wrapper { aspect-ratio: 16 / 9; width: 100%; }
    .video-wrapper iframe { width: 100% !important; height: 100% !important; }

    #mobileMenu {
      width: 100%;
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: 999;
      background: #062E2B;
      transform: translateY(-110%);
      transition: transform 0.4s cubic-bezier(0.23, 1, 0.32, 1);
      overflow-y: auto;
      padding-top: 5rem;
    }
    #mobileMenu.open {
      transform: translateY(0);
    }
    #mobileMenu ul {
      padding: 1.5rem 2rem;
      display: flex;
      flex-direction: column;
      gap: 1.25rem;
    }
    #mobileMenu ul li a {
      color: rgba(255,255,255,0.9);
      font-size: 1.25rem;
      font-weight: 600;
      display: block;
      padding: 0.5rem 0;
      border-bottom: 1px solid rgba(255,255,255,0.08);
      transition: color 0.2s;
    }
    #mobileMenu ul li a:hover { color: #D4F54C; }
    .menu-close-btn {
      position: absolute;
      top: 1.5rem;
      right: 1.5rem;
      color: white;
      font-size: 2rem;
      background: none;
      border: none;
      cursor: pointer;
      opacity: 0.8;
      transition: opacity 0.2s;
    }
    .menu-close-btn:hover { opacity: 1; }

    /* Popup overlay */
    .popup-overlay {
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.6);
      backdrop-filter: blur(4px);
      z-index: 1000;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 1rem;
    }
    .popup-overlay.active { display: flex; }
    .popup-card {
      background: white;
      max-width: 400px;
      width: 100%;
      border-radius: 2rem;
      padding: 2rem 1.5rem;
      box-shadow: 0 30px 60px rgba(0,0,0,0.3);
      animation: popIn 0.3s ease;
    }
    @keyframes popIn {
      from { transform: scale(0.9); opacity: 0; }
      to { transform: scale(1); opacity: 1; }
    }
    .popup-card h3 { font-size: 1.5rem; font-weight: 800; color: #0F3836; margin-bottom: 0.5rem; }
    .popup-card p { color: #6B7280; margin-bottom: 1.5rem; font-size: 0.95rem; }
    .popup-btn {
      display: block;
      width: 100%;
      padding: 0.85rem;
      border-radius: 50px;
      font-weight: 600;
      border: none;
      cursor: pointer;
      transition: background 0.2s;
      text-align: center;
      margin-bottom: 0.75rem;
    }
    .popup-btn.primary { background: #D4F54C; color: #062E2B; }
    .popup-btn.primary:hover { background: #CEF141; }
    .popup-btn.secondary { background: #f0f2f5; color: #111827; }
    .popup-btn.secondary:hover { background: #e5e7eb; }
    .popup-close {
      background: none;
      border: none;
      font-size: 1.5rem;
      color: #9CA3AF;
      cursor: pointer;
      float: right;
      transition: color 0.2s;
    }
    .popup-close:hover { color: #111827; }

    section, footer, header { max-width: 100vw; overflow-x: hidden; }
    .slide img { object-fit: cover; width: 100%; height: 100%; }
    header { overflow: hidden; }
    #heroSlider { width: 100%; max-width: 100vw; overflow: hidden; }
  </style>
  @stack('styles')
</head>
<body>

<!-- ============ HEADER / NAV ============ -->
<header class="relative bg-forest overflow-hidden w-full">
  <nav class="relative z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 flex items-center justify-between py-6 w-full">
    <a href="{{ url('/') }}" class="flex items-center gap-3 text-white font-extrabold text-xl tracking-tightish whitespace-nowrap">
      <span class="w-10 h-10 rounded-full bg-lime text-forest-deep flex items-center justify-center font-extrabold text-base shrink-0">ASC</span>
      <span class="hidden xs:inline">Agogo State College</span>
      <span class="xs:hidden">ASC</span>
    </a>
    <div class="flex items-center gap-3 sm:gap-4">
      <!-- Mobile Portal button (visible on mobile) -->
      <button id="portalBtnMobile" class="xl:hidden inline-flex items-center gap-1.5 bg-lime text-forest-deep font-semibold text-sm px-4 py-2 rounded-full hover:bg-lime-soft transition-colors shadow-sm">
        <i data-lucide="log-in" class="w-4 h-4"></i> Portal
      </button>
      <!-- Mobile menu toggle -->
      <button class="xl:hidden text-white ml-1" aria-label="Open menu" id="menuToggle">
        <i data-lucide="menu" class="w-6 h-6"></i>
      </button>
    </div>
    <!-- Desktop nav: Portal button now at the end of the menu -->
    <ul class="hidden xl:flex items-center gap-7 text-white/85 font-medium text-sm">
      <li><a href="{{ url('/') }}" class="hover:text-lime transition-colors">Home</a></li>
      <li><a href="{{route('about')}}" class="hover:text-lime transition-colors">About</a></li>
      <li><a href="{{route('admission.index')}}" class="hover:text-lime transition-colors">Admission</a></li>
      <li><a href="{{route('programmes')}}" class="hover:text-lime transition-colors">Programmes</a></li>
      <li><a href="{{route('calender')}}" class="hover:text-lime transition-colors">Calendar</a></li>
      <li><a href="{{route('leadership')}}" class="hover:text-lime transition-colors">Leadership</a></li>
      <li><a href="{{route('pta')}}" class="hover:text-lime transition-colors">PTA</a></li>
      <li><a href="{{route('connect')}}" class="hover:text-lime transition-colors">Connect</a></li>
      <li><a href="{{route('contact')}}" class="hover:text-lime transition-colors">Contact</a></li>
      <li>
        <button id="portalBtnDesktop" class="inline-flex items-center gap-1.5 bg-lime text-forest-deep font-semibold text-sm px-5 py-2.5 rounded-full hover:bg-lime-soft transition-colors shadow-sm">
          <i data-lucide="log-in" class="w-4 h-4"></i> Portal
        </button>
      </li>
    </ul>
  </nav>

  <!-- ========== FULL-SCREEN MOBILE MENU ========== -->
  <div id="mobileMenu" class="xl:hidden">
    <button class="menu-close-btn" id="closeMenuBtn" aria-label="Close menu">✕</button>
    <ul>
      <li><a href="{{ url('/') }}" class="hover:text-lime transition-colors">Home</a></li>
      <li><a href="{{route('about')}}" class="hover:text-lime transition-colors">About</a></li>
      <li><a href="{{route('admission.index')}}" class="hover:text-lime transition-colors">Admission</a></li>
      <li><a href="{{route('programmes')}}" class="hover:text-lime transition-colors">Programmes</a></li>
      <li><a href="{{route('calender')}}" class="hover:text-lime transition-colors">Calendar</a></li>
      <li><a href="{{route('leadership')}}" class="hover:text-lime transition-colors">Leadership</a></li>
      <li><a href="{{route('pta')}}" class="hover:text-lime transition-colors">PTA</a></li>
      <li><a href="{{route('connect')}}" class="hover:text-lime transition-colors">Connect</a></li>
      <li><a href="{{route('contact')}}" class="hover:text-lime transition-colors">Contact</a></li>
      <li><a href="#portal" class="hover:text-lime transition-colors">Portal</a></li>
    </ul>
  </div>

  @yield('hero')
</header>

<!-- ============ PORTAL POPUP ============ -->
<div class="popup-overlay" id="portalPopup">
  <div class="popup-card">
    <button class="popup-close" id="closePopupBtn">✕</button>
    <h3>🔐 Portal Login</h3>
    <p>Choose your login type to access the portal.</p>
    <button class="popup-btn primary" id="studentLoginBtn">👨‍🎓 Student Portal</button>
    <button class="popup-btn secondary" id="teacherLoginBtn">👩‍🏫 Teacher / Admin Portal</button>
    <button class="popup-btn secondary" style="background:transparent; color:#6B7280; font-size:0.85rem; margin-top:0.25rem;" id="closePopupBtn2">Cancel</button>
  </div>
</div>

@yield('content')

<!-- ============ FOOTER ============ -->
<footer id="contact" class="bg-forest-deep mt-8 sm:mt-10 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-12 sm:py-16 grid sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-10">
    <div>
      <a href="{{ url('/') }}" class="flex items-center gap-3 text-white font-extrabold text-xl"><span class="w-9 h-9 rounded-full bg-lime text-forest-deep flex items-center justify-center font-extrabold text-sm shrink-0">ASC</span> Agogo State College</a>
      <p class="mt-3 sm:mt-4 text-white/55 text-sm leading-relaxed max-w-xs">A boarding senior high school in Agogo, Ashanti Region, dedicated to academic excellence and strong character since 1958.</p>
      <form class="mt-4 sm:mt-6 flex items-center bg-white/10 rounded-full p-1 max-w-xs" onsubmit="event.preventDefault()">
        <input type="email" placeholder="Enter your email" class="bg-transparent px-3 sm:px-4 py-2 text-sm text-white placeholder-white/40 outline-none flex-1 min-w-0" aria-label="Email address">
        <button type="submit" class="w-8 h-8 sm:w-9 sm:h-9 shrink-0 rounded-full bg-lime text-forest-deep flex items-center justify-center hover:bg-lime-soft transition-colors" aria-label="Subscribe"><i data-lucide="arrow-right" class="w-3 h-3 sm:w-4 sm:h-4"></i></button>
      </form>
    </div>
    <div>
      <h4 class="text-white font-semibold">Programmes</h4>
      <ul class="mt-4 sm:mt-5 space-y-2 sm:space-y-3 text-sm text-white/55">
        <li><a href="{{route('programmes')}}" class="hover:text-lime transition-colors">General Science</a></li>
        <li><a href="{{route('programmes')}}" class="hover:text-lime transition-colors">Business</a></li>
        <li><a href="{{route('programmes')}}" class="hover:text-lime transition-colors">General Arts</a></li>
        <li><a href="{{route('programmes')}}" class="hover:text-lime transition-colors">Visual Arts</a></li>
        <li><a href="{{route('programmes')}}" class="hover:text-lime transition-colors">Home Economics</a></li>
        <li><a href="{{route('programmes')}}" class="hover:text-lime transition-colors">Agricultural Science</a></li>
      </ul>
    </div>
    <div>
      <h4 class="text-white font-semibold">School</h4>
      <ul class="mt-4 sm:mt-5 space-y-2 sm:space-y-3 text-sm text-white/55">
        <li><a href="{{route('about')}}" class="hover:text-lime transition-colors">About us</a></li>
        <li><a href="{{route('admission.index')}}" class="hover:text-lime transition-colors">Admission</a></li>
        <li><a href="{{route('calender')}}" class="hover:text-lime transition-colors">Calendar</a></li>
        <li><a href="{{route('leadership')}}" class="hover:text-lime transition-colors">Leadership</a></li>
        <li><a href="{{route('pta')}}" class="hover:text-lime transition-colors">PTA</a></li>
        <li><a href="#portal" class="hover:text-lime transition-colors">Portal</a></li>
      </ul>
    </div>
    <div>
      <h4 class="text-white font-semibold">Need help?</h4>
      <ul class="mt-4 sm:mt-5 space-y-2 sm:space-y-3 text-sm text-white/55">
        <li>Call us directly:</li>
        <li class="text-white font-medium">+233 24 400 0000</li>
        <li>Need support?</li>
        <li class="text-white font-medium break-all">info@agogostatecollege.edu.gh</li>
      </ul>
    </div>
  </div>
  <div class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 py-5 sm:py-6 flex flex-wrap items-center justify-between gap-3 sm:gap-4 text-xs text-white/40">
      <p>&copy; 2026 Agogo State College. All rights reserved.</p>
      <ul class="flex flex-wrap gap-3 sm:gap-6">
        <li><a href="{{ url('/') }}" class="hover:text-lime transition-colors">Home</a></li>
        <li><a href="{{route('about')}}" class="hover:text-lime transition-colors">About</a></li>
        <li><a href="{{route('admission.index')}}" class="hover:text-lime transition-colors">Admission</a></li>
        <li><a href="{{route('programmes')}}" class="hover:text-lime transition-colors">Programmes</a></li>
        <li><a href="{{route('calender')}}" class="hover:text-lime transition-colors">Calendar</a></li>
        <li><a href="{{route('leadership')}}" class="hover:text-lime transition-colors">Leadership</a></li>
        <li><a href="{{route('pta')}}" class="hover:text-lime transition-colors">PTA</a></li>
        <li><a href="{{route('connect')}}" class="hover:text-lime transition-colors">Connect</a></li>
        <li><a href="#portal" class="hover:text-lime transition-colors">Portal</a></li>
      </ul>
    </div>
  </div>
</footer>

<script>
  lucide.createIcons();

  // Mobile menu toggle (full screen with animation)
  const menuToggle = document.getElementById('menuToggle');
  const mobileMenu = document.getElementById('mobileMenu');
  const closeMenuBtn = document.getElementById('closeMenuBtn');

  function openMenu() {
    mobileMenu.classList.add('open');
    document.body.style.overflow = 'hidden';
  }
  function closeMenu() {
    mobileMenu.classList.remove('open');
    document.body.style.overflow = '';
  }
  menuToggle.addEventListener('click', openMenu);
  closeMenuBtn.addEventListener('click', closeMenu);
  mobileMenu.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', closeMenu);
  });

  // Portal Popup - unified for both desktop and mobile buttons
  const portalPopup = document.getElementById('portalPopup');
  const closePopupBtn = document.getElementById('closePopupBtn');
  const closePopupBtn2 = document.getElementById('closePopupBtn2');

  function openPopup() { portalPopup.classList.add('active'); document.body.style.overflow = 'hidden'; }
  function closePopup() { portalPopup.classList.remove('active'); document.body.style.overflow = ''; }

  document.getElementById('portalBtnDesktop').addEventListener('click', openPopup);
  document.getElementById('portalBtnMobile').addEventListener('click', openPopup);
  closePopupBtn.addEventListener('click', closePopup);
  closePopupBtn2.addEventListener('click', closePopup);
  portalPopup.addEventListener('click', (e) => {
    if (e.target === portalPopup) closePopup();
  });

  document.getElementById('studentLoginBtn').addEventListener('click', () => {
    alert('🔐 Redirecting to Student Portal...');
    closePopup();
  });
  document.getElementById('teacherLoginBtn').addEventListener('click', () => {
    alert('🔐 Redirecting to Teacher/Admin Portal...');
    closePopup();
  });
</script>
@stack('scripts')
</body>
</html>