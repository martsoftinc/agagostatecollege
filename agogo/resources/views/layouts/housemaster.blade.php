<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'House Master Portal — Agogo State College')</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            asc: {
              green: '#0D5C3A',
              'green-dark': '#083D26',
              'green-light': '#147A4E',
              yellow: '#F59E0B',
              'yellow-hover': '#D97706',
              'yellow-light': '#FEF3C7',
              bg: '#F8FAFC'
            }
          }
        }
      }
    }
  </script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  @stack('styles')
</head>
<body class="bg-asc-bg text-slate-800 font-sans antialiased min-h-screen flex flex-col lg:flex-row">

  <div id="sidebarBackdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 hidden lg:hidden"></div>

  <aside id="sidebar" class="fixed lg:static inset-y-0 left-0 z-50 w-64 bg-asc-green-dark text-white flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-in-out shadow-xl lg:shadow-none">
    <div>
      <div class="p-5 border-b border-asc-green-light/30 flex items-center justify-between">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 rounded-full bg-asc-yellow text-asc-green-dark border-2 border-white flex items-center justify-center font-extrabold text-sm shadow">ASC</div>
          <div>
            <h1 class="font-extrabold text-sm tracking-wider uppercase text-white leading-tight">Agogo State College</h1>
            <p class="text-[10px] text-asc-yellow tracking-widest font-semibold uppercase">House Master</p>
          </div>
        </div>
        <button onclick="toggleSidebar()" class="lg:hidden text-slate-300 hover:text-white p-1">
          <i class="fa-solid fa-xmark text-lg"></i>
        </button>
      </div>

      <nav class="p-4 space-y-1">
        <a href="{{ route('housemaster.dashboard') }}"
           class="flex items-center space-x-3 px-3.5 py-3 rounded-xl {{ request()->routeIs('housemaster.dashboard') ? 'bg-asc-green text-asc-yellow font-bold' : 'text-slate-200 hover:bg-asc-green hover:text-white font-medium' }} text-sm transition">
          <i class="fa-solid fa-chart-pie w-5 text-center"></i>
          <span>Dashboard</span>
        </a>

        <a href="{{ route('housemaster.disciplinary.index') }}"
           class="flex items-center space-x-3 px-3.5 py-3 rounded-xl {{ request()->routeIs('housemaster.disciplinary.*') ? 'bg-asc-green text-asc-yellow font-bold' : 'text-slate-200 hover:bg-asc-green hover:text-white font-medium' }} text-sm transition">
          <i class="fa-solid fa-gavel w-5 text-center"></i>
          <span>Disciplinary</span>
        </a>

        <a href="{{ route('housemaster.exeat.index') }}"
           class="flex items-center space-x-3 px-3.5 py-3 rounded-xl {{ request()->routeIs('housemaster.exeat.*') ? 'bg-asc-green text-asc-yellow font-bold' : 'text-slate-200 hover:bg-asc-green hover:text-white font-medium' }} text-sm transition">
          <i class="fa-solid fa-person-walking-luggage w-5 text-center"></i>
          <span>Exeat</span>
        </a>
      </nav>
    </div>

    <div class="p-4 border-t border-asc-green-light/30">
      <form method="POST" action="{{ route('admin.logout') }}">
        @csrf
        <button type="submit" class="w-full flex items-center space-x-3 px-3.5 py-2.5 rounded-xl text-rose-300 hover:bg-rose-900/30 font-semibold text-sm transition">
          <i class="fa-solid fa-right-from-bracket w-5 text-center"></i>
          <span>Logout</span>
        </button>
      </form>
    </div>
  </aside>

  <div class="flex-grow flex flex-col min-w-0">
    <header class="bg-asc-green text-white px-4 py-3 flex items-center justify-between lg:hidden shadow-md">
      <div class="flex items-center space-x-3">
        <button onclick="toggleSidebar()" class="p-2 rounded-lg bg-asc-green-dark text-asc-yellow">
          <i class="fa-solid fa-bars text-lg"></i>
        </button>
        <span class="font-extrabold text-sm uppercase tracking-wider">House Master</span>
      </div>
      <div class="w-8 h-8 rounded-full bg-asc-yellow text-asc-green-dark font-bold flex items-center justify-center text-xs">HM</div>
    </header>

    <main class="p-4 sm:p-6 lg:p-8 flex-grow max-w-7xl w-full mx-auto space-y-8">
      @yield('content')
    </main>

    <footer class="py-4 text-center text-xs text-slate-500 border-t border-slate-200 mt-auto bg-white">
      <p>&copy; {{ date('Y') }} Agogo State College. House Master Portal</p>
    </footer>
  </div>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('-translate-x-full');
      document.getElementById('sidebarBackdrop').classList.toggle('hidden');
    }
  </script>
  @stack('scripts')
</body>
</html>