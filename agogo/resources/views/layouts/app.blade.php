<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Agogo State College')</title>

    <!-- Tailwind + custom config -->
    <script src="https://cdn.tailwindcss.com">
    </script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: {
                            DEFAULT: '#0B2362',
                            50: '#eef1f8',
                            100: '#d6ddef',
                            600: '#122a6b',
                            700: '#0B2362',
                            800: '#091b4d',
                            900: '#071539',
                        },
                        gold: '#e6a700',
                        'dark-green': '#1a3c2a',
                    },
                    fontFamily: {
                        sans: ['Avenir Next', 'Avenir', 'Helvetica Neue', 'Arial', 'sans-serif'],
                        serif: ['Georgia', 'ui-serif', 'serif'],
                    },
                },
            },
        }
    </script>
    <style>
        /* floating icons */
        .float-whatsapp {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            z-index: 999;
            background: #25d366;
            color: #fff;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            transition: all 0.2s;
            text-decoration: none;
        }
        .float-whatsapp:hover {
            transform: scale(1.08);
            background: #1ebe5c;
        }
        .float-call {
            position: fixed;
            bottom: 7rem;
            right: 2rem;
            z-index: 999;
            background: #0B2362;
            color: #fff;
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
            transition: all 0.2s;
            text-decoration: none;
        }
        .float-call:hover {
            transform: scale(1.08);
            background: #1a3a7a;
        }

        /* Scroll animations */
        .scroll-section {
            opacity: 0;
            transition: opacity 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94),
                transform 0.9s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            will-change: transform, opacity;
        }
        .scroll-section.visible {
            opacity: 1;
            transform: translate(0, 0) scale(1) rotate(0deg) !important;
        }
        .slide-left {
            transform: translateX(-80px) scale(0.95);
        }
        .slide-right {
            transform: translateX(80px) scale(0.95);
        }
        .slide-up {
            transform: translateY(60px) scale(0.95);
        }
        .slide-down {
            transform: translateY(-60px) scale(0.95);
        }
        .zoom-in {
            transform: scale(0.85);
        }
        .rotate-in {
            transform: rotate(-5deg) scale(0.9);
        }
        .slide-up-scale {
            transform: translateY(70px) scale(0.88);
        }
        .slide-down-scale {
            transform: translateY(-70px) scale(0.88);
        }

        /* Stagger children */
        .stagger-children>* {
            opacity: 0;
            transform: translateY(40px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .stagger-children.visible>*:nth-child(1) {
            transition-delay: 0.05s;
        }
        .stagger-children.visible>*:nth-child(2) {
            transition-delay: 0.15s;
        }
        .stagger-children.visible>*:nth-child(3) {
            transition-delay: 0.25s;
        }
        .stagger-children.visible>*:nth-child(4) {
            transition-delay: 0.35s;
        }
        .stagger-children.visible>* {
            opacity: 1;
            transform: translateY(0);
        }

        .btn-apply {
            background: #dc2626;
            color: #fff;
            font-weight: 700;
            padding: 0.5rem 1.25rem;
            border-radius: 9999px;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            transition: background 0.2s, transform 0.15s;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(220, 38, 38, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .btn-apply:hover {
            background: #b91c1c;
            transform: scale(1.04);
        }
        .menu-phone {
            background: rgba(255, 255, 255, 0.08);
            padding: 0.3rem 1rem;
            border-radius: 40px;
            font-weight: 500;
            font-size: 0.85rem;
            letter-spacing: 0.02em;
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: 0.2s;
            text-decoration: none;
        }
        .menu-phone svg {
            width: 14px;
            height: 14px;
            fill: #e6a700;
        }
        .menu-phone:hover {
            background: rgba(255, 255, 255, 0.15);
            border-color: #e6a700;
        }

        /* Hero slider - full page */
        .hero-slider {
            position: relative;
            overflow: hidden;
            min-height: 100vh;
            background-color: #071539;
        }
        .hero-slide {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            opacity: 0;
            transform: scale(1.1);
            transition: opacity 1.2s ease, transform 1.8s ease;
            will-change: transform, opacity;
            z-index: 1;
            image-rendering: -webkit-optimize-contrast;
            image-rendering: crisp-edges;
        }
        .hero-slide.active {
            opacity: 1;
            transform: scale(1);
            z-index: 2;
        }
        .hero-slide.exit {
            opacity: 0;
            transform: scale(1.05);
            z-index: 3;
        }
        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(7, 21, 57, .55), rgba(7, 21, 57, .85));
            z-index: 4;
        }
        .hero-content {
            position: relative;
            z-index: 5;
            display: flex;
            align-items: center;
            min-height: 100vh;
        }

        /* Hero arrow navigation */
        .hero-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.25s, transform 0.2s, border-color 0.25s;
        }
        .hero-arrow:hover {
            background: #e6a700;
            border-color: #e6a700;
            color: #0B2362;
            transform: translateY(-50%) scale(1.08);
        }
        .hero-arrow-left {
            left: 1.5rem;
        }
        .hero-arrow-right {
            right: 1.5rem;
        }
        @media (min-width: 768px) {
            .hero-arrow-left {
                left: 2.5rem;
            }
            .hero-arrow-right {
                right: 2.5rem;
            }
        }

        /* feature card hover */
        .feature-card {
            transition: transform 0.4s ease, box-shadow 0.4s ease, background-color 0.3s ease, color 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-6px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
        }
        .bg-dark-green {
            background-color: #1a3c2a;
        }

        /* Quick action grid cards */
        .action-card {
            background: white;
            border-radius: 1.5rem;
            padding: 2rem 1.5rem;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            border: 1px solid #eef2f6;
            cursor: pointer;
            text-decoration: none;
            color: #0B2362;
            display: block;
        }
        .action-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border-color: #1a3c2a;
            background: #f8fafc;
        }
        .action-card .icon-wrap {
            background: #1a3c2a;
            color: white;
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            font-size: 1.8rem;
            transition: 0.3s;
        }
        .action-card:hover .icon-wrap {
            background: #e6a700;
            transform: scale(1.05);
        }
        .action-card h3 {
            font-weight: 700;
            font-size: 1.1rem;
            letter-spacing: 0.02em;
            margin-bottom: 0.25rem;
        }
        .action-card p {
            font-size: 0.85rem;
            color: #4b5563;
            margin: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        .feature-arrow {
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-arrow {
            transform: translateX(10px);
        }

        /* transparent header that overlays the hero, solidifies on scroll */
        header#mainHeader {
            background-color: transparent;
            border-bottom: 1px solid transparent;
        }
        header#mainHeader.header-solid {
            background-color: rgba(26, 60, 42, 0.9);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.15);
        }
        #mobile-menu {
            background-color: rgba(26, 60, 42, 0.97) !important;
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }
        .hero-slide {
            min-height: 100vh;
            height: 100vh;
            max-height: 100vh;
        }
        .hero-slider {
            min-height: 100vh;
            height: 100vh;
        }
        .hero-content {
            min-height: 100vh;
            height: 100vh;
        }

        /* extra student life instagram */
        .instagram-embed {
            min-height: 500px;
            background: #fafafa;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #262626;
            font-size: 0.9rem;
        }
        .instagram-embed a {
            color: #0B2362;
            font-weight: 600;
            text-decoration: underline;
        }
    </style>

    @stack('styles')
</head>
<body class="font-sans text-navy-900 antialiased">

    <!-- ============ HEADER — transparent overlay, solidifies on scroll ============ -->
    <header id="mainHeader" class="fixed top-0 inset-x-0 z-50 transition-all duration-300">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" alt="Charles Dale" class="h-12 w-auto" onerror="this.src='https://charlesdaleschool.com/wp-content/uploads/2024/02/Image-1.png'">
            </a>
            <nav class="hidden lg:block">
                <ul class="flex items-center gap-6 text-sm font-bold uppercase tracking-wide text-white">
                    <li class="group relative py-6"><a href="#about" class="flex items-center gap-1 hover:text-gold">About <span class="text-xs">▾</span></a>
                        <div class="invisible absolute left-1/2 top-full w-64 -translate-x-1/2 rounded-b-lg bg-white/90 backdrop-blur-sm p-4 text-navy opacity-0 shadow-xl transition group-hover:visible group-hover:opacity-100">
                            <ul class="space-y-2 text-xs font-semibold normal-case">
                                <li><a href="#" class="hover:text-gold">Welcome from the Head</a></li>
                                <li><a href="#" class="hover:text-gold">Our Story, Vision &amp; Mission</a></li>
                                <li><a href="#" class="hover:text-gold">Calendar</a></li>
                                <li><a href="#" class="hover:text-gold">Virtual Tour</a></li>
                                <li><a href="#" class="hover:text-gold">School Policies</a></li>
                                <li><a href="#" class="hover:text-gold">Contact &amp; Directions</a></li>
                                <li><a href="#" class="hover:text-gold">Achievements</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="group relative py-6"><a href="#admission" class="flex items-center gap-1 hover:text-gold">Admission <span class="text-xs">▾</span></a>
                        <div class="invisible absolute left-1/2 top-full w-64 -translate-x-1/2 rounded-b-lg bg-white/90 backdrop-blur-sm p-4 text-navy opacity-0 shadow-xl transition group-hover:visible group-hover:opacity-100">
                            <ul class="space-y-2 text-xs font-semibold normal-case">
                                <li><a href="#" class="hover:text-gold">Apply to CDMIS</a></li>
                                <li><a href="#" class="hover:text-gold">Admission Procedure</a></li>
                                <li><a href="#" class="hover:text-gold">Entrance Examination</a></li>
                                <li><a href="#" class="hover:text-gold">FAQ</a></li>
                                <li><a href="#" class="hover:text-gold">Scholarships</a></li>
                                <li><a href="#" class="hover:text-gold">Boarding</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="group relative py-6"><a href="#academics" class="flex items-center gap-1 hover:text-gold">Academics <span class="text-xs">▾</span></a>
                        <div class="invisible absolute left-1/2 top-full w-64 -translate-x-1/2 rounded-b-lg bg-white/90 backdrop-blur-sm p-4 text-navy opacity-0 shadow-xl transition group-hover:visible group-hover:opacity-100">
                            <ul class="space-y-2 text-xs font-semibold normal-case">
                                <li><a href="#" class="hover:text-gold">Curriculum &amp; Methods</a></li>
                                <li><a href="#" class="hover:text-gold">Academic Facilities</a></li>
                                <li><a href="#" class="hover:text-gold">Library</a></li>
                                <li><a href="#" class="hover:text-gold">E-Learning Portal</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="group relative py-6"><a href="#student-life" class="flex items-center gap-1 hover:text-gold">Student Life <span class="text-xs">▾</span></a>
                        <div class="invisible absolute left-1/2 top-full w-72 -translate-x-1/2 rounded-b-lg bg-white/90 backdrop-blur-sm p-4 text-navy opacity-0 shadow-xl transition group-hover:visible group-hover:opacity-100">
                            <ul class="space-y-2 text-xs font-semibold normal-case">
                                <li><a href="#" class="hover:text-gold">Visual Arts</a></li>
                                <li><a href="#" class="hover:text-gold">Sports</a></li>
                                <li><a href="#" class="hover:text-gold">Garment Making</a></li>
                                <li><a href="#" class="hover:text-gold">Music</a></li>
                                <li><a href="#" class="hover:text-gold">Photography</a></li>
                                <li><a href="#" class="hover:text-gold">Electrical Installation</a></li>
                                <li><a href="#" class="hover:text-gold">Food &amp; Nutrition</a></li>
                                <li><a href="#" class="hover:text-gold">Vocational Activities</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="flex items-center gap-3">
                <a href="tel:+233509627497" class="menu-phone hidden sm:inline-flex">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor">
                        <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                    </svg>
                    +233 509 627 497
                </a>
                <a href="#" class="btn-apply">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor">
                        <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                    </svg>
                    Apply Now
                </a>
                <button class="text-white lg:hidden" aria-label="Open menu" onclick="document.getElementById('mobile-menu').classList.toggle('hidden')">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
        <div id="mobile-menu" class="hidden border-t border-white/10 lg:hidden">
            <ul class="space-y-1 px-4 py-4 text-sm font-bold uppercase text-white">
                <li><a href="#about" class="block py-2 hover:text-gold">About</a></li>
                <li><a href="#admission" class="block py-2 hover:text-gold">Admission</a></li>
                <li><a href="#academics" class="block py-2 hover:text-gold">Academics</a></li>
                <li><a href="#student-life" class="block py-2 hover:text-gold">Student Life</a></li>
                <li class="pt-2 text-sm font-normal"><a href="tel:+233509627497" class="inline-flex items-center gap-2 text-gold">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>+233 509 627 497</a></li>
                <li class="pt-1"><a href="#" class="inline-block rounded-full bg-red-600 px-6 py-2 text-xs font-bold uppercase text-white hover:bg-red-700">
                        <svg class="inline mr-1 w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
                        </svg>Apply Now</a></li>
            </ul>
        </div>
    </header>

    <!-- ============ FLOATING WHATSAPP + CALL ============ 
    <a href="https://wa.me/233509627497" target="_blank" class="float-whatsapp" aria-label="WhatsApp">
        <svg viewBox="0 0 24 24" fill="white">
            <path d="M12.032 21.965c-1.912 0-3.705-.5-5.267-1.438l-5.765 1.672 1.782-5.544c-1.035-1.64-1.576-3.5-1.576-5.428 0-5.864 4.77-10.635 10.635-10.635s10.635 4.77 10.635 10.635-4.77 10.635-10.635 10.635zm0-19.27c-4.756 0-8.635 3.879-8.635 8.635 0 1.853.586 3.574 1.586 4.98l-1.007 3.147 3.288-.957c1.362.816 2.958 1.298 4.718 1.298 4.756 0 8.635-3.879 8.635-8.635s-3.879-8.635-8.635-8.635zm4.962 10.765c-.137-.068-.81-.4-1.167-.444s-.577-.065-.82.065-.472.4-.578.478-.267.178-.5.067c-.233-.111-.984-.363-1.875-1.158-.693-.618-1.16-1.38-1.296-1.613-.137-.233-.015-.359.103-.475.106-.106.233-.267.35-.4.117-.133.156-.222.233-.378.078-.156.039-.289-.02-.4-.058-.111-.5-1.205-.685-1.65-.178-.427-.367-.356-.5-.356-.133 0-.267-.022-.4-.022-.156 0-.4.056-.611.267-.211.211-.8.778-.8 1.9s.822 2.2.934 2.356c.111.156 1.6 2.467 3.889 3.311 1.956.72 2.356.578 2.778.544.378-.033 1.2-.489 1.378-.956.178-.467.178-.867.133-.956-.044-.089-.156-.133-.289-.2z"/>
        </svg>
    </a>
    <a href="tel:+233509627497" class="float-call" aria-label="Call">
        <svg viewBox="0 0 24 24" fill="white">
            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
        </svg>
    </a>-->

    <!-- ============ MAIN CONTENT ============ -->
    @yield('content')

    <!-- ============ FOOTER dark green ============ -->
    <footer class="bg-dark-green pt-16 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-12 border-b border-white/10 pb-12 lg:grid-cols-4">
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="Charles Dale logo" class="h-12 w-auto bg-white/0" onerror="this.src='https://charlesdaleschool.com/wp-content/uploads/2024/02/Image-1.png'">
                    <p class="mt-4 text-sm text-white/70">12 Army Range Road, Off Eneka/Igwuruta Road<br>P.O. Box 2737, PH, Rivers State, Nigeria</p>
                    <p class="mt-3 text-sm text-white/70"><a href="mailto:info@charlesdaleschool.com" class="underline hover:text-gold">info@charlesdaleschool.com</a></p>
                    <p class="mt-1 text-sm text-white/70">+234 (0)806 487 8929, 0814 131 0235</p>
                    <p class="mt-2 text-sm text-white/70 flex items-center gap-2">
                        <svg viewBox="0 0 24 24" width="14" height="14" fill="#e6a700">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>+233 509 627 497
                    </p>
                </div>
                <div>
                    <h4 class="text-sm font-bold uppercase tracking-wide">Useful Links</h4>
                    <ul class="mt-4 space-y-2 text-sm text-white/70">
                        <li><a href="#" class="hover:text-gold">Home</a></li>
                        <li><a href="#" class="hover:text-gold">About Us</a></li>
                        <li><a href="#" class="hover:text-gold">Facilities</a></li>
                        <li><a href="#" class="hover:text-gold">Apply</a></li>
                        <li><a href="#" class="hover:text-gold">Admission</a></li>
                        <li><a href="#" class="hover:text-gold">Scholarships</a></li>
                    </ul>
                </div>
                <div class="lg:col-span-2">
                    <h4 class="text-sm font-bold uppercase tracking-wide">Stay up to date with the latest news</h4>
                    <form class="mt-4 flex max-w-md gap-2" action="#" method="POST">
                        @csrf
                        <input type="email" name="email" placeholder="Your email address" class="w-full rounded-full border border-white/20 bg-transparent px-4 py-2 text-sm text-white placeholder-white/50 focus:border-gold focus:outline-none" required>
                        <button type="submit" class="shrink-0 rounded-full bg-gold px-5 py-2 text-sm font-bold uppercase text-navy-900 hover:bg-white">Subscribe</button>
                    </form>
                    <h4 class="mt-8 text-sm font-bold uppercase tracking-wide">Powered by</h4>
                    <img src="https://charlesdaleschool.com/wp-content/uploads/2024/02/Educare-Logo-copy@2x1.png" alt="Educare" class="mt-3 h-12 w-auto">
                </div>
            </div>
            <div class="flex flex-col items-center justify-between gap-4 py-6 text-xs text-white/60 sm:flex-row">
                <p>© {{ date('Y') }} Agogo State College</p>
                <a href="#" class="hover:text-gold">Contact us</a>
                <p class="border-l border-white/30 pl-4">Privacy policy</p>
            </div>
        </div>
    </footer>

    <!-- ============ SOCIAL EMBED SDKS ============ -->
    <script async src="https://www.tiktok.com/embed.js"></script>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v19.0"></script>

    <!-- ============ SCRIPTS ============ -->
    <script>
        (function() {
            const slides = document.querySelectorAll('.hero-slide');
            const prevBtn = document.getElementById('heroPrev');
            const nextBtn = document.getElementById('heroNext');
            let current = 0,
                interval;

            function goTo(index) {
                if (index === current) return;
                const wrapped = (index + slides.length) % slides.length;
                slides.forEach(s => s.classList.remove('active', 'exit'));
                slides[current].classList.add('exit');
                setTimeout(() => slides[current].classList.remove('exit'), 300);
                current = wrapped;
                slides[current].classList.add('active');
            }

            function nextSlide() { goTo((current + 1) % slides.length); }

            function prevSlide() { goTo((current - 1 + slides.length) % slides.length); }

            function resetInterval() {
                clearInterval(interval);
                interval = setInterval(nextSlide, 5000);
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function() { nextSlide();
                    resetInterval(); });
            }
            if (prevBtn) {
                prevBtn.addEventListener('click', function() { prevSlide();
                    resetInterval(); });
            }

            interval = setInterval(nextSlide, 5000);
            const hero = document.getElementById('heroSlider');
            if (hero) {
                hero.addEventListener('mouseenter', () => clearInterval(interval));
                hero.addEventListener('mouseleave', () => { interval = setInterval(nextSlide, 5000); });
            }
            // ensure first slide is active
            if (slides.length > 0) goTo(0);
        })();

        (function() {
            const sections = document.querySelectorAll('.scroll-section');
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
            }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
            sections.forEach(section => observer.observe(section));

            const staggerContainers = document.querySelectorAll('.stagger-children');
            const staggerObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => { if (entry.isIntersecting) entry.target.classList.add('visible'); });
            }, { threshold: 0.15, rootMargin: '0px 0px -40px 0px' });
            staggerContainers.forEach(container => staggerObserver.observe(container));
        })();

        (function() {
            // Solidify the transparent header once the user scrolls past the hero
            const header = document.getElementById('mainHeader');

            function updateHeader() {
                if (window.scrollY > window.innerHeight - 100) {
                    header.classList.add('header-solid');
                } else {
                    header.classList.remove('header-solid');
                }
            }
            window.addEventListener('scroll', updateHeader, { passive: true });
            updateHeader();
        })();
    </script>

    @stack('scripts')

</body>
</html>