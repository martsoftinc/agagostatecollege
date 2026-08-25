<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
  <title>Bedncy – Admin Portal | @yield('title', 'Dashboard')</title>
  
  @yield('meta')
  
  <script>
    // Apply dark mode BEFORE page renders to avoid flash
    (function() {
      const saved = localStorage.getItem('darkMode');
      if (saved === 'true') document.documentElement.classList.add('dark');
    })();
  </script>
  
  <!-- Tailwind CSS with dark mode class strategy -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' }
  </script>
  
  <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  
  <style>
    body {
      font-family: 'DM Sans', sans-serif;
      transition: background-color 0.25s ease, color 0.2s ease;
    }
    .font-syne { font-family: 'Syne', sans-serif; }
    .stars { color: #f59e0b; letter-spacing: 1px; }
    .sidebar-scroll::-webkit-scrollbar { width: 4px; }
    .sidebar-scroll::-webkit-scrollbar-track { background: #1e293b; }
    .sidebar-scroll::-webkit-scrollbar-thumb { background: #475569; border-radius: 10px; }
    @keyframes fadeSlide {
      from { opacity: 0; transform: translateY(6px); }
      to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-slide { animation: fadeSlide 0.2s ease-out; }
    .admin-table th { text-align: left; padding: 0.75rem 1rem; background: #f1f5f9; }
    .dark .admin-table th { background: #1e293b; }
    .admin-table td { padding: 0.75rem 1rem; border-bottom: 1px solid #e2e8f0; }
    .dark .admin-table td { border-bottom-color: #334155; }
    .status-badge { @apply px-2 py-0.5 rounded-full text-xs font-semibold; }
    .stat-card {
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
      transform: translateY(-2px);
      box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    }

    

  </style>
  
  @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-slate-900 text-slate-900 dark:text-slate-100">

  <!-- MOBILE MENU BUTTON -->
  <button id="mobileMenuButton" class="lg:hidden fixed top-4 left-4 z-50 p-2.5 rounded-xl bg-white dark:bg-slate-800 shadow-lg border border-gray-200 dark:border-slate-700 transition-all duration-200 hover:scale-105 focus:outline-none" aria-label="Toggle menu">
    <svg id="menuIconOpen" class="w-5 h-5 text-slate-700 dark:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
    <svg id="menuIconClose" class="w-5 h-5 text-slate-700 dark:text-white hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
  </button>

  <!-- ======================== SIDEBAR (ADMIN PORTAL) ======================== -->
  <aside id="sidebar" class="fixed top-0 left-0 z-40 h-full w-72 bg-slate-900 dark:bg-black border-r border-slate-800 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col shadow-2xl">
    <div class="px-6 pt-8 pb-6 border-b border-slate-800">
      <div class="flex items-center justify-between">
        <div>
          <span class="font-syne text-2xl font-extrabold text-white tracking-tight">Bed<span class="text-blue-400">ncy</span></span>
          <div class="text-xs text-slate-400 mt-1">Admin Portal</div>
        </div>
      </div>
    </div>

    <div class="flex-1 overflow-y-auto py-4 sidebar-scroll">
      <div class="px-3 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-500">Core</div>
      <nav class="space-y-1 px-3">
        <a href=" " class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-slate-800 text-white' : '' }}" data-page="dashboard">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
          Dashboard
        </a>


        <a href="/admin/profile" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all text-sm font-medium">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5"/></svg>
          Profile
        </a>


        <a href=" " class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all text-sm font-medium" data-page="userManagement">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          User Management
        </a>
        <a href=" " class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all text-sm font-medium" data-page="courseBuilder">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/></svg>
          Course Builder
        </a>
        <a href="" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all text-sm font-medium" data-page="jobApplications">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875c-.621 0-1.125-.504-1.125-1.125v-4.25m16.5 0a2.25 2.25 0 0 0-2.25-2.25H18.75V8.25A2.25 2.25 0 0 0 16.5 6H7.5a2.25 2.25 0 0 0-2.25 2.25v3.65m16.5 0a2.25 2.25 0 0 1-2.25 2.25H4.875a2.25 2.25 0 0 1-2.25-2.25m13.5-5.25V8.25a.75.75 0 0 0-.75-.75h-9a.75.75 0 0 0-.75.75v3.65"></path>
          </svg>
          Job Assistance
        </a>

        <a href="" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all text-sm font-medium" data-page="consultancy">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
          </svg>
          Consultancy
        </a>

        <a href="" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all text-sm font-medium" data-page="mincorm">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m13.81 4.414L18 12.375m-6-1.875v11.25m-6-11.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H12" />
          <path stroke-linecap="round" stroke-linejoin="round" d="m15 5.25-3-3m0 0-3 3m3-3v11.25" />
        </svg>
        Mincorm (Mining Cert)
      </a>

        <a href="/transactions" class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all text-sm font-medium" data-page="transactions">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 8h6M6 12h12M8 16h8M4 4h16a2 2 0 012 2v12a2 2 0 01-2 2H4a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>
          Transactions
        </a>
      </nav>
      <!--
      <div class="px-3 pt-6 pb-2 text-[11px] font-bold uppercase tracking-wider text-slate-500">Management</div>
      <nav class="space-y-1 px-3">
        <a href="" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all text-sm" data-page="maintenance">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11.42 15.17L17.25 21A2.652 2.652 0 0021 17.25l-5.877-5.877M11.42 15.17l-2.83 2.83a2 2 0 01-2.828 0L4.5 16.5l2.83-2.83M11.42 15.17l2.83-2.83m-2.83 2.83L6.33 9.33M15.17 11.42l-2.83-2.83m0 0L9.33 5.5a2 2 0 00-2.828 0L4.5 7.33l2.83 2.83m0 0l2.83-2.83"/></svg>
          Maintenance
        </a>
        <a href="" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-slate-800 hover:text-white transition-all text-sm" data-page="progressReport">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2zm0 0V9a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v10m-6 0a2 2 0 0 0 2 2h2a2 2 0 0 0 2-2m0 0V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2z"/></svg>
          Progress Report
        </a>
      </nav>-->
    </div>

    <div class="p-4 border-t border-slate-800">
      <a href="{{ route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-slate-300 hover:bg-red-900/30 hover:text-red-300 transition-all">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9"/></svg>
        Log Out
      </a>
      <form id="logout-form" action="{{ route('logout')}}" method="POST" class="hidden">
        @csrf
      </form>
    </div>
  </aside>

  <!-- ======================== MAIN CONTENT ======================== -->
  <main class="lg:ml-72 min-h-screen transition-all duration-300">
    <header class="sticky top-0 z-30 bg-white/80 dark:bg-slate-900/80 backdrop-blur-lg border-b border-gray-200 dark:border-slate-800 px-4 sm:px-8 py-3 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div class="lg:hidden w-10"></div>
        <div class="relative hidden sm:block">
          <input type="text" id="searchInput" placeholder="Search..." class="w-64 md:w-80 pl-10 pr-4 py-2.5 rounded-xl bg-gray-100 dark:bg-slate-800 border-none text-sm focus:ring-2 focus:ring-blue-500 outline-none transition">
          <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
        </div>
      </div>
      <div class="flex items-center gap-3 sm:gap-5">
        <button id="darkModeToggle" class="p-2 rounded-xl bg-gray-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-gray-200 dark:hover:bg-slate-700 transition" aria-label="Toggle dark mode">
          <svg id="sunIcon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
          <svg id="moonIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/></svg>
        </button>
        <div class="flex items-center gap-2">
          <div class="text-right hidden xs:block">
            <div class="text-sm font-bold">{{ Auth::user()->name ?? 'Admin User' }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400">{{ Auth::user()->role ?? 'Super Admin' }}</div>
          </div>
          <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-600 to-blue-600 flex items-center justify-center text-white font-bold shadow-md">
            {{ strtoupper(substr(Auth::user()->name ?? 'AU', 0, 2)) }}
          </div>
        </div>
      </div>
    </header>

    <div class="p-4 sm:p-6 md:p-8">
      @yield('content')
    </div>
  </main>

  <script>
    // Dark mode logic
    const darkToggleBtn = document.getElementById('darkModeToggle');
    const sunIcon = document.getElementById('sunIcon');
    const moonIcon = document.getElementById('moonIcon');
    
    function updateDarkIcons(isDark) { 
      if(isDark){ 
        sunIcon?.classList.remove('hidden'); 
        moonIcon?.classList.add('hidden'); 
      } else { 
        sunIcon?.classList.add('hidden'); 
        moonIcon?.classList.remove('hidden'); 
      } 
    }
    
    function setDarkMode(isDark) { 
      if(isDark) document.documentElement.classList.add('dark'); 
      else document.documentElement.classList.remove('dark'); 
      localStorage.setItem('darkMode', isDark); 
      updateDarkIcons(isDark); 
    }
    
    const savedDark = localStorage.getItem('darkMode') === 'true';
    setDarkMode(savedDark);
    
    if (darkToggleBtn) {
      darkToggleBtn.addEventListener('click', () => setDarkMode(!document.documentElement.classList.contains('dark')));
    }

    // Mobile menu toggle
    const sidebar = document.getElementById('sidebar');
    const menuBtn = document.getElementById('mobileMenuButton');
    const iconOpen = document.getElementById('menuIconOpen');
    const iconClose = document.getElementById('menuIconClose');
    let sidebarOpen = false;
    
    function openSidebar() { 
      sidebar?.classList.remove('-translate-x-full'); 
      iconOpen?.classList.add('hidden'); 
      iconClose?.classList.remove('hidden'); 
      sidebarOpen = true; 
    }
    
    function closeSidebarFull() { 
      sidebar?.classList.add('-translate-x-full'); 
      iconOpen?.classList.remove('hidden'); 
      iconClose?.classList.add('hidden'); 
      sidebarOpen = false; 
    }
    
    if (menuBtn) {
      menuBtn.addEventListener('click', (e) => { 
        e.stopPropagation(); 
        sidebarOpen ? closeSidebarFull() : openSidebar(); 
      });
    }
    
    document.addEventListener('click', (e) => { 
      if (window.innerWidth < 1024 && sidebarOpen && sidebar && !sidebar.contains(e.target) && menuBtn && !menuBtn.contains(e.target)) {
        closeSidebarFull();
      }
    });

    // Simple search functionality
    const searchInput = document.getElementById('searchInput');
    if(searchInput) {
      searchInput.addEventListener('input', function(e) {
        const searchTerm = e.target.value.toLowerCase();
        // You can implement search logic here based on current page
        console.log('Searching for:', searchTerm);
      });
    }
  </script>
  
  @stack('scripts')
</body>
</html>