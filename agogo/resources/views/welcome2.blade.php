<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>LearnAxis — Leading educational platforms available online</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['Plus Jakarta Sans', 'sans-serif'],
        },
        colors: {
          forest: {
            DEFAULT: '#0F3836',
            deep: '#062E2B',
          },
          lime: {
            DEFAULT: '#D4F54C',
            soft: '#CEF141',
          },
          ivory: '#F8F9FA',
          ink: '#111827',
          muted: '#6B7280',
        },
        letterSpacing: {
          tightish: '-0.02em',
        }
      }
    }
  }
</script>
<style>
  html { scroll-behavior: smooth; }
  body { font-family: 'Plus Jakarta Sans', sans-serif; color: #111827; }
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
</style>
</head>
<body class="bg-white text-ink antialiased">

<!-- ============ HEADER / HERO ============ -->
<header class="relative bg-forest overflow-hidden">
  <div class="absolute inset-0 bg-noise pointer-events-none"></div>
  <!-- Nav -->
  <nav class="relative z-20 max-w-7xl mx-auto px-6 lg:px-10 flex items-center justify-between py-6">
    <a href="#" class="text-white font-extrabold text-2xl tracking-tightish">LearnAxis</a>
    <ul class="hidden lg:flex items-center gap-9 text-white/85 font-medium text-sm">
      <li><a href="#" class="hover:text-lime transition-colors">Home</a></li>
      <li><a href="#courses" class="hover:text-lime transition-colors">Courses</a></li>
      <li><a href="#instructors" class="hover:text-lime transition-colors">Instructors</a></li>
      <li><a href="#testimonials" class="hover:text-lime transition-colors">Testimonials</a></li>
      <li><a href="#blog" class="hover:text-lime transition-colors">Blog</a></li>
    </ul>
    <a href="#contact" class="hidden sm:inline-flex items-center gap-2 text-white font-medium text-sm hover:text-lime transition-colors">
      Contact Us <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
    </a>
    <button class="lg:hidden text-white" aria-label="Open menu">
      <i data-lucide="menu" class="w-6 h-6"></i>
    </button>
  </nav>

  <!-- Hero content -->
  <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-10 pt-8 pb-20 grid lg:grid-cols-2 gap-12 items-center">
    <div>
      <h1 class="text-white font-extrabold text-4xl sm:text-5xl lg:text-[3.4rem] leading-[1.08] tracking-tightish max-w-xl">
        Leading educational platforms available online
      </h1>
      <p class="mt-6 text-white/70 max-w-md leading-relaxed">
        Online courses from the world's leading experts. Join 17 million learners today and build skills that move your career forward.
      </p>
      <a href="#courses" class="mt-8 inline-flex items-center gap-2 bg-lime text-forest-deep font-semibold px-7 py-3.5 rounded-full hover:bg-lime-soft transition-colors">
        Get started
        <i data-lucide="arrow-right" class="w-4 h-4"></i>
      </a>

      <div class="mt-14 grid grid-cols-3 gap-6 max-w-md">
        <div class="border-t-2 border-lime pt-3">
          <p class="text-white font-extrabold text-2xl sm:text-3xl">270+</p>
          <p class="text-white/55 text-sm mt-1">Expert tutors</p>
        </div>
        <div class="border-t-2 border-lime pt-3">
          <p class="text-white font-extrabold text-2xl sm:text-3xl">5550+</p>
          <p class="text-white/55 text-sm mt-1">Online courses</p>
        </div>
        <div class="border-t-2 border-lime pt-3">
          <p class="text-white font-extrabold text-2xl sm:text-3xl">330+</p>
          <p class="text-white/55 text-sm mt-1">5-star reviews</p>
        </div>
      </div>
    </div>

    <div class="relative flex justify-center lg:justify-end">
      <div class="relative w-full max-w-sm">
        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=700&q=80"
             alt="Smiling instructor holding a laptop"
             class="w-full h-[440px] object-cover rounded-[2rem]">
        <!-- floating badges -->
        <div class="absolute -top-6 -left-8 w-14 h-14 bg-orange-400/90 rounded-2xl rotate-12 flex items-center justify-center shadow-lg">
          <i data-lucide="sparkles" class="w-6 h-6 text-white"></i>
        </div>
        <div class="absolute top-14 -right-8 w-14 h-14 bg-lime rounded-2xl -rotate-6 flex items-center justify-center shadow-lg">
          <i data-lucide="check-circle" class="w-6 h-6 text-forest-deep"></i>
        </div>
        <div class="absolute bottom-8 -left-10 w-14 h-14 bg-emerald-400 rounded-2xl rotate-6 flex items-center justify-center shadow-lg">
          <i data-lucide="badge-check" class="w-6 h-6 text-white"></i>
        </div>
      </div>
    </div>
  </div>
</header>

<!-- ============ TRUSTED BRANDS ============ -->
<section class="bg-ivory border-b border-gray-100">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 py-10 flex flex-wrap items-center justify-between gap-8">
    <span class="flex items-center gap-2 text-xl font-bold text-gray-400">
      <i data-lucide="chrome" class="w-5 h-5"></i> Google
    </span>
    <span class="flex items-center gap-2 text-xl font-bold text-gray-400">
      <i data-lucide="trello" class="w-5 h-5"></i> Trello
    </span>
    <span class="flex items-center gap-2 text-xl font-bold text-gray-400">
      <i data-lucide="grid-3x3" class="w-5 h-5"></i> monday.com
    </span>
    <span class="flex items-center gap-2 text-xl font-bold text-gray-400">
      <i data-lucide="file-text" class="w-5 h-5"></i> Notion
    </span>
    <span class="flex items-center gap-2 text-xl font-bold text-gray-400">
      <i data-lucide="slack" class="w-5 h-5"></i> Slack
    </span>
  </div>
</section>

<!-- ============ HOW IT WORKS ============ -->
<section class="max-w-7xl mx-auto px-6 lg:px-10 py-24">
  <div class="text-center max-w-2xl mx-auto">
    <h2 class="font-extrabold text-3xl md:text-4xl tracking-tightish">Your Online Learning Journey Made Easy</h2>
    <p class="mt-4 text-muted leading-relaxed">
      From picking the right course to graduating with new skills — three simple steps stand between you and your next milestone.
    </p>
  </div>

  <div class="mt-16 grid md:grid-cols-3 gap-10 relative">
    <div class="hidden md:block absolute top-6 left-[16.6%] right-[16.6%] dashed-line"></div>

    <div class="relative text-center md:text-left">
      <div class="mx-auto md:mx-0 w-12 h-12 rounded-full bg-forest text-white font-bold flex items-center justify-center relative z-10">01</div>
      <h3 class="mt-5 font-bold text-xl">Choose Your Course</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed max-w-xs mx-auto md:mx-0">Browse hundreds of expert-led courses and find the one that matches your goals.</p>
    </div>
    <div class="relative text-center md:text-left">
      <div class="mx-auto md:mx-0 w-12 h-12 rounded-full bg-forest text-white font-bold flex items-center justify-center relative z-10">02</div>
      <h3 class="mt-5 font-bold text-xl">Sign Up and Pay</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed max-w-xs mx-auto md:mx-0">Create an account and check out securely in under a minute.</p>
    </div>
    <div class="relative text-center md:text-left">
      <div class="mx-auto md:mx-0 w-12 h-12 rounded-full bg-forest text-white font-bold flex items-center justify-center relative z-10">03</div>
      <h3 class="mt-5 font-bold text-xl">Learn and Engage</h3>
      <p class="mt-2 text-muted text-sm leading-relaxed max-w-xs mx-auto md:mx-0">Study at your own pace with live sessions, projects, and instructor feedback.</p>
    </div>
  </div>
</section>

<!-- ============ POPULAR COURSES ============ -->
<section id="courses" class="bg-ivory py-24">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <div class="flex flex-wrap items-end justify-between gap-6">
      <h2 class="font-extrabold text-3xl md:text-4xl tracking-tightish">Popular courses</h2>
      <ul class="flex flex-wrap gap-2 text-sm font-medium">
        <li><button class="px-4 py-2 rounded-full bg-forest text-white">All</button></li>
        <li><button class="px-4 py-2 rounded-full text-muted hover:bg-white transition-colors">Development</button></li>
        <li><button class="px-4 py-2 rounded-full text-muted hover:bg-white transition-colors">Business</button></li>
        <li><button class="px-4 py-2 rounded-full text-muted hover:bg-white transition-colors">Design</button></li>
        <li><button class="px-4 py-2 rounded-full text-muted hover:bg-white transition-colors">Marketing</button></li>
      </ul>
    </div>

    <div class="mt-12 grid sm:grid-cols-2 lg:grid-cols-3 gap-7">

      <!-- Course card template x6 -->
      <article class="bg-white rounded-3xl p-4 card-hover">
        <div class="relative">
          <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?auto=format&fit=crop&w=500&q=80" alt="Student studying with a laptop" class="w-full h-48 object-cover rounded-2xl">
          <div class="star-badge absolute -top-3 -right-3 w-14 h-14 bg-lime flex items-center justify-center text-forest-deep font-bold text-xs">$60</div>
        </div>
        <div class="mt-4">
          <p class="text-xs font-semibold text-forest">Expert Instructor · Fatema Ilha</p>
          <h3 class="mt-1 font-semibold text-lg leading-snug">Essentials of business accounting and taxation</h3>
          <div class="mt-2 flex items-center gap-1 text-sm text-amber-500">
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <span class="text-muted ml-1">(18 Reviews)</span>
          </div>
          <div class="mt-3 flex items-center justify-between text-sm text-muted pt-3 border-t border-gray-100">
            <span class="flex items-center gap-1"><i data-lucide="book-open" class="w-4 h-4"></i> 14 Lessons</span>
            <span class="flex items-center gap-1"><i data-lucide="users" class="w-4 h-4"></i> 48 students</span>
          </div>
        </div>
      </article>

      <article class="bg-white rounded-3xl p-4 card-hover">
        <div class="relative">
          <img src="https://images.unsplash.com/photo-1580519542036-c47de6196ba5?auto=format&fit=crop&w=500&q=80" alt="Card payment terminal for finance course" class="w-full h-48 object-cover rounded-2xl">
          <div class="star-badge absolute -top-3 -right-3 w-14 h-14 bg-lime flex items-center justify-center text-forest-deep font-bold text-xs">$60</div>
        </div>
        <div class="mt-4">
          <p class="text-xs font-semibold text-forest">Finance · Leonel Money</p>
          <h3 class="mt-1 font-semibold text-lg leading-snug">Foundations of financial management and planning</h3>
          <div class="mt-2 flex items-center gap-1 text-sm text-amber-500">
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <span class="text-muted ml-1">(37 Reviews)</span>
          </div>
          <div class="mt-3 flex items-center justify-between text-sm text-muted pt-3 border-t border-gray-100">
            <span class="flex items-center gap-1"><i data-lucide="book-open" class="w-4 h-4"></i> 25 Lessons</span>
            <span class="flex items-center gap-1"><i data-lucide="users" class="w-4 h-4"></i> 35 students</span>
          </div>
        </div>
      </article>

      <article class="bg-white rounded-3xl p-4 card-hover">
        <div class="relative">
          <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=500&q=80" alt="Designer working on app design" class="w-full h-48 object-cover rounded-2xl">
          <div class="star-badge absolute -top-3 -right-3 w-14 h-14 bg-lime flex items-center justify-center text-forest-deep font-bold text-xs">$60</div>
        </div>
        <div class="mt-4">
          <p class="text-xs font-semibold text-forest">Design · Abrar Islam</p>
          <h3 class="mt-1 font-semibold text-lg leading-snug">Fundamentals of app design and development</h3>
          <div class="mt-2 flex items-center gap-1 text-sm text-amber-500">
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <span class="text-muted ml-1">(59 Reviews)</span>
          </div>
          <div class="mt-3 flex items-center justify-between text-sm text-muted pt-3 border-t border-gray-100">
            <span class="flex items-center gap-1"><i data-lucide="book-open" class="w-4 h-4"></i> 22 Lessons</span>
            <span class="flex items-center gap-1"><i data-lucide="users" class="w-4 h-4"></i> 68 students</span>
          </div>
        </div>
      </article>

      <article class="bg-white rounded-3xl p-4 card-hover">
        <div class="relative">
          <img src="https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=500&q=80" alt="Medicine student in lab" class="w-full h-48 object-cover rounded-2xl">
          <div class="star-badge absolute -top-3 -right-3 w-14 h-14 bg-lime flex items-center justify-center text-forest-deep font-bold text-xs">$60</div>
        </div>
        <div class="mt-4">
          <p class="text-xs font-semibold text-forest">Medicine · Habiba Akter</p>
          <h3 class="mt-1 font-semibold text-lg leading-snug">Methods of genetic testing and sequencing</h3>
          <div class="mt-2 flex items-center gap-1 text-sm text-amber-500">
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <span class="text-muted ml-1">(18 Reviews)</span>
          </div>
          <div class="mt-3 flex items-center justify-between text-sm text-muted pt-3 border-t border-gray-100">
            <span class="flex items-center gap-1"><i data-lucide="book-open" class="w-4 h-4"></i> 14 Lessons</span>
            <span class="flex items-center gap-1"><i data-lucide="users" class="w-4 h-4"></i> 50 students</span>
          </div>
        </div>
      </article>

      <article class="bg-white rounded-3xl p-4 card-hover">
        <div class="relative">
          <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=500&q=80" alt="Designer with glasses smiling" class="w-full h-48 object-cover rounded-2xl">
          <div class="star-badge absolute -top-3 -right-3 w-14 h-14 bg-lime flex items-center justify-center text-forest-deep font-bold text-xs">$60</div>
        </div>
        <div class="mt-4">
          <p class="text-xs font-semibold text-forest">Design · Anjum Sumi</p>
          <h3 class="mt-1 font-semibold text-lg leading-snug">Introduction to designing websites and visual content</h3>
          <div class="mt-2 flex items-center gap-1 text-sm text-amber-500">
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <span class="text-muted ml-1">(37 Reviews)</span>
          </div>
          <div class="mt-3 flex items-center justify-between text-sm text-muted pt-3 border-t border-gray-100">
            <span class="flex items-center gap-1"><i data-lucide="book-open" class="w-4 h-4"></i> 28 Lessons</span>
            <span class="flex items-center gap-1"><i data-lucide="users" class="w-4 h-4"></i> 42 students</span>
          </div>
        </div>
      </article>

      <article class="bg-white rounded-3xl p-4 card-hover">
        <div class="relative">
          <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?auto=format&fit=crop&w=500&q=80" alt="Business handshake" class="w-full h-48 object-cover rounded-2xl">
          <div class="star-badge absolute -top-3 -right-3 w-14 h-14 bg-lime flex items-center justify-center text-forest-deep font-bold text-xs">$60</div>
        </div>
        <div class="mt-4">
          <p class="text-xs font-semibold text-forest">Business · Leonel Money</p>
          <h3 class="mt-1 font-semibold text-lg leading-snug">Expand your English vocabulary and proficiency</h3>
          <div class="mt-2 flex items-center gap-1 text-sm text-amber-500">
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <i data-lucide="star" class="w-4 h-4 fill-amber-400"></i>
            <span class="text-muted ml-1">(59 Reviews)</span>
          </div>
          <div class="mt-3 flex items-center justify-between text-sm text-muted pt-3 border-t border-gray-100">
            <span class="flex items-center gap-1"><i data-lucide="book-open" class="w-4 h-4"></i> 22 Lessons</span>
            <span class="flex items-center gap-1"><i data-lucide="users" class="w-4 h-4"></i> 72 students</span>
          </div>
        </div>
      </article>

    </div>
  </div>
</section>

<!-- ============ PREMIER FEATURES ============ -->
<section id="instructors" class="max-w-7xl mx-auto px-6 lg:px-10 py-24 grid lg:grid-cols-2 gap-16 items-center">
  <div class="relative bg-forest rounded-[2rem] p-8 overflow-hidden">
    <div class="absolute inset-0 bg-noise"></div>
    <div class="relative flex items-center gap-3 mb-3">
      <span class="w-3 h-3 rounded-full bg-red-400"></span>
      <span class="w-3 h-3 rounded-full bg-amber-300"></span>
      <span class="w-3 h-3 rounded-full bg-lime"></span>
    </div>
    <div class="relative grid grid-cols-2 gap-4">
      <div class="relative">
        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=300&q=80" alt="Instructor on a video call" class="w-full h-32 object-cover rounded-xl">
        <span class="absolute bottom-2 left-2 bg-black/50 text-white text-[10px] px-2 py-0.5 rounded-full">Instructor</span>
      </div>
      <div>
        <img src="https://images.unsplash.com/photo-1531123897727-8f129e1688ce?auto=format&fit=crop&w=300&q=80" alt="Student on a video call wearing headphones" class="w-full h-32 object-cover rounded-xl">
      </div>
      <div>
        <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80" alt="Student on a video call" class="w-full h-32 object-cover rounded-xl">
      </div>
      <div class="relative">
        <img src="https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=300&q=80" alt="Instructor smiling on a video call" class="w-full h-32 object-cover rounded-xl">
        <span class="absolute bottom-2 left-2 bg-black/50 text-white text-[10px] px-2 py-0.5 rounded-full">Instructor</span>
      </div>
    </div>
    <div class="relative mt-5 flex items-center gap-3">
      <button class="flex items-center gap-2 bg-emerald-500 text-white text-sm font-semibold px-4 py-2 rounded-full">
        <i data-lucide="phone" class="w-4 h-4"></i> Accept
      </button>
      <button class="flex items-center gap-2 bg-rose-500 text-white text-sm font-semibold px-4 py-2 rounded-full">
        <i data-lucide="phone-off" class="w-4 h-4"></i> Decline
      </button>
    </div>
  </div>

  <div>
    <h2 class="font-extrabold text-3xl md:text-4xl tracking-tightish leading-tight">Offering premier online learning opportunities.</h2>
    <p class="mt-4 text-muted leading-relaxed">Live, face-to-face classes designed to feel like a real classroom — wherever you happen to be.</p>

    <ul class="mt-9 space-y-7">
      <li class="flex gap-4">
        <span class="shrink-0 w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
          <i data-lucide="layout-grid" class="w-5 h-5"></i>
        </span>
        <div>
          <h3 class="font-semibold">Dedicated podium space</h3>
          <p class="text-muted text-sm mt-1">Teachers don't get lost in the grid view and have a dedicated podium space.</p>
        </div>
      </li>
      <li class="flex gap-4">
        <span class="shrink-0 w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
          <i data-lucide="mic" class="w-5 h-5"></i>
        </span>
        <div>
          <h3 class="font-semibold">Front-row presenting</h3>
          <p class="text-muted text-sm mt-1">TAs and presenters can be moved to the front of the class in a click.</p>
        </div>
      </li>
      <li class="flex gap-4">
        <span class="shrink-0 w-11 h-11 rounded-xl bg-lime/30 text-forest flex items-center justify-center">
          <i data-lucide="users-round" class="w-5 h-5"></i>
        </span>
        <div>
          <h3 class="font-semibold">A full view of the room</h3>
          <p class="text-muted text-sm mt-1">Teachers can easily see all students and class data at one time.</p>
        </div>
      </li>
    </ul>
  </div>
</section>

<!-- Marquee strip -->
<div class="bg-forest py-6 overflow-hidden">
  <p class="whitespace-nowrap text-white/10 font-extrabold text-6xl tracking-tight">
    Amazing learning courses &nbsp;•&nbsp; Amazing learning courses &nbsp;•&nbsp; Amazing learning courses &nbsp;•
  </p>
</div>

<!-- ============ TESTIMONIAL / SOCIAL PROOF ============ -->
<section id="testimonials" class="max-w-7xl mx-auto px-6 lg:px-10 py-24 grid lg:grid-cols-2 gap-16 items-center">
  <div>
    <p class="text-sm font-semibold text-forest flex items-center gap-2">
      <span class="w-6 h-px bg-forest"></span> Students feedback
    </p>
    <h2 class="mt-4 font-extrabold text-3xl md:text-4xl tracking-tightish leading-tight">Trusted by genius people.</h2>
    <p class="mt-4 text-muted leading-relaxed max-w-md">
      LearnAxis has more than 100k positive ratings from users around the world. Students and teachers alike have been helped greatly by the platform.
    </p>

    <div class="mt-10 grid grid-cols-3 gap-6">
      <div>
        <p class="font-extrabold text-3xl sm:text-4xl">95%</p>
        <p class="text-muted text-sm mt-2 leading-snug">Students who complete their course successfully</p>
      </div>
      <div>
        <p class="font-extrabold text-3xl sm:text-4xl">1M+</p>
        <p class="text-muted text-sm mt-2 leading-snug">Positive user ratings worldwide</p>
      </div>
      <div>
        <p class="font-extrabold text-3xl sm:text-4xl">10K</p>
        <p class="text-muted text-sm mt-2 leading-snug">Trusted by thousands of learners and educators</p>
      </div>
    </div>
  </div>

  <div class="relative max-w-sm mx-auto lg:mx-0">
    <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=600&q=80" alt="Student reading in a library" class="w-full h-[420px] object-cover rounded-[2rem]">
    <div class="absolute -bottom-8 -left-8 bg-white rounded-2xl shadow-xl p-5 w-64 border-l-4 border-lime">
      <p class="text-sm text-ink leading-relaxed">"Thank you so much for your help — it's exactly what I've been looking for. You won't regret it, it really saves me time and effort."</p>
      <div class="mt-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <img src="https://images.unsplash.com/photo-1544717297-fa95b6ee9643?auto=format&fit=crop&w=80&q=80" alt="Emiliya Cart" class="w-8 h-8 rounded-full object-cover">
          <div>
            <p class="text-xs font-semibold">Emiliya Cart</p>
            <p class="text-[11px] text-muted">12 Reviews</p>
          </div>
        </div>
        <div class="flex text-amber-400">
          <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400"></i>
          <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400"></i>
          <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400"></i>
          <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400"></i>
          <i data-lucide="star" class="w-3.5 h-3.5 fill-amber-400"></i>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ============ LATEST ARTICLES ============ -->
<section id="blog" class="bg-ivory py-24">
  <div class="max-w-7xl mx-auto px-6 lg:px-10">
    <h2 class="font-extrabold text-3xl md:text-4xl tracking-tightish">Latest articles</h2>

    <div class="mt-12 grid md:grid-cols-3 gap-8">
      <article>
        <img src="https://images.unsplash.com/photo-1592478411213-6153e4ebc07d?auto=format&fit=crop&w=500&q=80" alt="Person using VR headset for training" class="w-full h-52 object-cover rounded-2xl">
        <div class="mt-4 flex items-center gap-2">
          <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=60&q=80" alt="Imran Khan" class="w-6 h-6 rounded-full object-cover">
          <span class="text-xs text-muted">By Imran Khan</span>
        </div>
        <h3 class="mt-3 font-semibold text-lg leading-snug">How to evaluate the effective of training programs.</h3>
        <p class="mt-2 text-sm text-muted leading-relaxed">Lorem ipsum has been industry standard dummy text ever...</p>
        <a href="#" class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-forest hover:gap-2 transition-all">Read More <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
      </article>

      <article>
        <img src="https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=500&q=80" alt="Woman looking out over scenic view" class="w-full h-52 object-cover rounded-2xl">
        <div class="mt-4 flex items-center gap-2">
          <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?auto=format&fit=crop&w=60&q=80" alt="Abrar Islam" class="w-6 h-6 rounded-full object-cover">
          <span class="text-xs text-muted">By Abrar Islam</span>
        </div>
        <h3 class="mt-3 font-semibold text-lg leading-snug">Experience the breathtaking views & perspectives.</h3>
        <p class="mt-2 text-sm text-muted leading-relaxed">Lorem ipsum has been industry standard dummy text ever...</p>
        <a href="#" class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-forest hover:gap-2 transition-all">Read More <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
      </article>

      <article>
        <img src="https://images.unsplash.com/photo-1600880292203-757bb62b4baf?auto=format&fit=crop&w=500&q=80" alt="Man working in cozy home office" class="w-full h-52 object-cover rounded-2xl">
        <div class="mt-4 flex items-center gap-2">
          <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=60&q=80" alt="Sayem Sumon" class="w-6 h-6 rounded-full object-cover">
          <span class="text-xs text-muted">By Sayem Sumon</span>
        </div>
        <h3 class="mt-3 font-semibold text-lg leading-snug">Build up healthy habits & strong peaceful life.</h3>
        <p class="mt-2 text-sm text-muted leading-relaxed">Lorem ipsum has been industry standard dummy text ever...</p>
        <a href="#" class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-forest hover:gap-2 transition-all">Read More <i data-lucide="arrow-right" class="w-4 h-4"></i></a>
      </article>
    </div>

    <div class="mt-14 flex items-center justify-center gap-2 text-sm font-medium">
      <button class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-muted hover:bg-white transition-colors" aria-label="Previous page"><i data-lucide="chevron-left" class="w-4 h-4"></i></button>
      <button class="w-9 h-9 rounded-full bg-forest text-white flex items-center justify-center">01</button>
      <button class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center hover:bg-white transition-colors">02</button>
      <button class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center hover:bg-white transition-colors">03</button>
      <button class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center hover:bg-white transition-colors">04</button>
      <button class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-muted hover:bg-white transition-colors" aria-label="Next page"><i data-lucide="chevron-right" class="w-4 h-4"></i></button>
    </div>
  </div>
</section>

<!-- ============ CTA BANNER ============ -->
<section class="max-w-7xl mx-auto px-6 lg:px-10 py-6">
  <div class="relative bg-lime/25 rounded-[2rem] px-8 sm:px-14 py-14 grid lg:grid-cols-2 gap-8 items-center overflow-hidden">
    <div class="absolute inset-0 bg-noise opacity-40"></div>
    <div class="relative">
      <h2 class="font-extrabold text-3xl md:text-4xl tracking-tightish leading-tight">Admission is open for the next year batch.</h2>
      <p class="mt-4 text-muted max-w-md leading-relaxed">Enrollment is now open for the upcoming year's batch. Join us to secure your spot and start your journey toward growth and success.</p>
    </div>
    <div class="relative flex flex-col sm:flex-row gap-4 justify-start lg:justify-end">
      <a href="#courses" class="inline-flex items-center justify-center gap-2 bg-lime text-forest-deep font-semibold px-7 py-3.5 rounded-full hover:bg-white transition-colors">
        Get started now
      </a>
      <a href="tel:+1234567890" class="inline-flex items-center justify-center gap-2 bg-forest text-white font-semibold px-7 py-3.5 rounded-full hover:bg-forest-deep transition-colors">
        <i data-lucide="phone-call" class="w-4 h-4"></i> +1234567890
      </a>
    </div>
  </div>
</section>

<!-- ============ FOOTER ============ -->
<footer id="contact" class="bg-forest-deep mt-10">
  <div class="max-w-7xl mx-auto px-6 lg:px-10 py-16 grid sm:grid-cols-2 lg:grid-cols-4 gap-10">
    <div>
      <a href="#" class="text-white font-extrabold text-2xl">LearnAxis</a>
      <p class="mt-4 text-white/55 text-sm leading-relaxed max-w-xs">We are providing high-quality courses for about ten years, helping learners build real skills.</p>
      <form class="mt-6 flex items-center bg-white/10 rounded-full p-1 max-w-xs" onsubmit="event.preventDefault()">
        <input type="email" placeholder="Enter your email" class="bg-transparent px-4 py-2 text-sm text-white placeholder-white/40 outline-none flex-1" aria-label="Email address">
        <button type="submit" class="w-9 h-9 shrink-0 rounded-full bg-lime text-forest-deep flex items-center justify-center hover:bg-lime-soft transition-colors" aria-label="Subscribe">
          <i data-lucide="arrow-right" class="w-4 h-4"></i>
        </button>
      </form>
    </div>

    <div>
      <h4 class="text-white font-semibold">Popular Courses</h4>
      <ul class="mt-5 space-y-3 text-sm text-white/55">
        <li><a href="#" class="hover:text-lime transition-colors">Business finance</a></li>
        <li><a href="#" class="hover:text-lime transition-colors">Advanced design</a></li>
        <li><a href="#" class="hover:text-lime transition-colors">Web development</a></li>
        <li><a href="#" class="hover:text-lime transition-colors">Data visualization</a></li>
      </ul>
    </div>

    <div>
      <h4 class="text-white font-semibold">Support</h4>
      <ul class="mt-5 space-y-3 text-sm text-white/55">
        <li><a href="#" class="hover:text-lime transition-colors">Help center</a></li>
        <li><a href="#" class="hover:text-lime transition-colors">Account information</a></li>
        <li><a href="#" class="hover:text-lime transition-colors">About</a></li>
        <li><a href="#" class="hover:text-lime transition-colors">Contact us</a></li>
      </ul>
    </div>

    <div>
      <h4 class="text-white font-semibold">Need help?</h4>
      <ul class="mt-5 space-y-3 text-sm text-white/55">
        <li>Call us directly:</li>
        <li class="text-white font-medium">+1234567890</li>
        <li>Need support?</li>
        <li class="text-white font-medium">Help@domain.com</li>
      </ul>
    </div>
  </div>

  <div class="border-t border-white/10">
    <div class="max-w-7xl mx-auto px-6 lg:px-10 py-6 flex flex-wrap items-center justify-between gap-4 text-xs text-white/40">
      <p>&copy; 2026 LearnAxis. All rights reserved.</p>
      <ul class="flex gap-6">
        <li><a href="#" class="hover:text-lime transition-colors">Home</a></li>
        <li><a href="#courses" class="hover:text-lime transition-colors">Courses</a></li>
        <li><a href="#instructors" class="hover:text-lime transition-colors">Instructors</a></li>
        <li><a href="#testimonials" class="hover:text-lime transition-colors">Testimonial</a></li>
        <li><a href="#blog" class="hover:text-lime transition-colors">Blog</a></li>
      </ul>
    </div>
  </div>
</footer>

<script>lucide.createIcons();</script>
</body>
</html>