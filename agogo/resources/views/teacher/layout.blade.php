<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Agogo State College - Teacher Portal')</title>
 
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            asc: {
              green: '#0D5C3A',         /* Primary Forest Green */
              'green-dark': '#083D26',
              'green-light': '#147A4E',
              yellow: '#F59E0B',        /* Vibrant Gold / Yellow */
              'yellow-hover': '#D97706',
              'yellow-light': '#FEF3C7',
              bg: '#F8FAFC'
            }
          }
        }
      }
    }
  </script>
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  @stack('styles')
</head>
<body class="bg-asc-bg text-slate-800 font-sans antialiased min-h-screen flex flex-col lg:flex-row">

  <!-- ========================================================= -->
  <!-- LEFT SIDEBAR MENU (Desktop & Mobile Overlay) -->
  <!-- ========================================================= -->
  
  <!-- Mobile Overlay Backdrop -->
  <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden"></div>

  <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-asc-green-dark text-white flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out shadow-xl lg:shadow-none">
    
    <div>
      <!-- BRANDING & LOGO HEADER -->
<div class="p-5 border-b border-asc-green-light/30 flex items-center justify-between">
    <div class="flex items-center space-x-3">

        <!-- Logo -->
        <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-asc-yellow shadow bg-white flex-shrink-0">
            <img src="{{ asset('images/logo.jpg') }}"
                 alt="Agogo State College Logo"
                 class="w-full h-full object-cover">
        </div>

        <div>
            <h1 class="font-extrabold text-sm tracking-wider uppercase text-white leading-tight">
                Agogo State
            </h1>
            <p class="text-[10px] text-asc-yellow tracking-widest font-semibold uppercase">
                College Teachers Portal
            </p>
        </div>

    </div>

    

        <!-- Close button for mobile -->
        <button onclick="toggleSidebar()" class="lg:hidden text-slate-300 hover:text-white p-1">
          <i class="fa-solid fa-xmark text-lg"></i>
        </button>
      </div>

      <!-- NAVIGATION LINKS -->
      <nav class="p-4 space-y-1">
        <a href="{{ route('teacher') }}" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl {{ request()->routeIs('teacher') ? 'bg-asc-green text-asc-yellow font-bold' : 'text-slate-200 hover:bg-asc-green hover:text-white font-medium' }} text-sm transition">
          <i class="fa-solid fa-house w-5 text-center"></i>
          <span>Dashboard</span>
        </a>

        <a href="{{ route('teacher.scores.index') }}" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl {{ request()->routeIs('teacher.scores.index') ? 'bg-asc-green text-asc-yellow font-bold' : 'text-slate-200 hover:bg-asc-green hover:text-white font-medium' }} text-sm transition">
                <i class="fa-solid fa-house w-5 text-center"></i>
                <span>Terminal Report</span>
          </a>

         <!--
        <a href="{{ route('teacher.student-finder') }}" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl text-slate-200 hover:bg-asc-green hover:text-white font-medium text-sm transition">
          <i class="fa-solid fa-clipboard-user w-5 text-center"></i>
          <span>Attendance</span>
        </a>
        -->
        
        <a href="{{ route('lesson-plans.index') }}" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl {{ request()->routeIs('lesson-plans.index') ? 'bg-asc-green text-asc-yellow font-bold' : 'text-slate-200 hover:bg-asc-green hover:text-white font-medium' }} text-sm transition">
          <i class="fa-solid fa-house w-5 text-center"></i>
          <span>Lesson Plans</span>
        </a>

      <a href="{{ route('teacher.student-finder') }}" 
        class="flex items-center space-x-3 px-3.5 py-3 rounded-xl {{ request()->routeIs('teacher.student-finder') ? 'bg-asc-green text-asc-yellow font-bold' : 'text-slate-200 hover:bg-asc-green hover:text-white font-medium' }} text-sm transition">
        <i class="fa-solid fa-magnifying-glass w-5 text-center"></i>
        <span>Student Finder</span>
      </a>

      

        <a href="{{ route('teacher.notices.index') }}"
        class="flex items-center space-x-3 px-3.5 py-3 rounded-xl
          {{ request()->routeIs('teacher.notices.*') ? 'bg-asc-green text-asc-yellow font-bold' : 'text-slate-200 hover:bg-asc-green hover:text-white font-medium' }}
          text-sm transition">
        <i class="fa-solid fa-bullhorn w-5 text-center"></i>
        <span>Announcements</span>
      </a>

        <a href="{{ route('teacher.profile') }}" class="flex items-center space-x-3 px-3.5 py-3 rounded-xl {{ request()->routeIs('teacher.profile') ? 'bg-asc-green text-asc-yellow font-bold' : 'text-slate-200 hover:bg-asc-green hover:text-white font-medium' }} text-sm transition">
          <i class="fa-solid fa-house w-5 text-center"></i>
          <span>Profile</span>
        </a>
      </nav>
    </div>

    <!-- LOGOUT FORM / BUTTON -->
    <div class="p-4 border-t border-asc-green-light/30">
      <form method="POST" action="{{ route('admin.logout')}}">
        @csrf
        <button type="submit" class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-rose-300 hover:bg-rose-900/30 font-semibold text-sm transition">
          <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
          <span>Logout</span>
        </button>
      </form>
    </div>

  </aside>

  <!-- ========================================================= -->
  <!-- MAIN CONTENT WRAPPER -->
  <!-- ========================================================= -->
  <div class="flex-grow flex flex-col min-w-0">

    <!-- TOP MOBILE NAVBAR -->
    <header class="bg-asc-green text-white px-4 py-3 flex items-center justify-between lg:hidden shadow-md">
      <div class="flex items-center space-x-3">
        <button onclick="toggleSidebar()" class="p-2 rounded-lg bg-asc-green-dark text-asc-yellow focus:outline-none">
          <i class="fa-solid fa-bars text-lg"></i>
        </button>
        <span class="font-extrabold text-sm uppercase tracking-wider">Agogo State College</span>
      </div>
      <div class="w-8 h-8 rounded-full bg-asc-yellow text-asc-green-dark font-bold flex items-center justify-center text-xs">
        MA
      </div>
    </header>

    <!-- MAIN PAGE CONTENT -->
    <main class="p-4 sm:p-6 lg:p-8 flex-grow max-w-7xl w-full mx-auto space-y-8">
      @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="py-4 text-center text-xs text-slate-500 border-t border-slate-200 mt-auto bg-white">
      <p>&copy; {{ date('Y') }} Agogo State College. All rights reserved.</p>
    </footer>

  </div>

  <!-- JAVASCRIPT FOR SIDEBAR TOGGLE -->
  <script>
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      const backdrop = document.getElementById('sidebarBackdrop');
      
      sidebar.classList.toggle('-translate-x-full');
      backdrop.classList.toggle('hidden');
    }
  </script>

  @stack('scripts')
</body>
</html>