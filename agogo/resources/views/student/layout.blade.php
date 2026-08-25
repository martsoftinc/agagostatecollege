<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Agogo State College - Student Portal')</title>

  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            asc: {
              green: '#0D5C3A',
              'green-dark': '#083D26',
              yellow: '#F59E0B',
              'yellow-hover': '#D97706',
              bg: '#F8FAFC'
            }
          }
        }
      }
    }
  </script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

  @stack('styles')
</head>
<body class="bg-asc-bg text-slate-800 font-sans antialiased min-h-screen flex flex-col">

  <!-- TOP NAVIGATION HEADER -->
  <header class="bg-asc-green text-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
      <div class="flex items-center space-x-3">
        <div class="w-10 h-10 rounded-full bg-asc-yellow flex items-center justify-center font-bold text-asc-green-dark border-2 border-white text-lg shadow">
          ASC
        </div>
        <div>
          <h1 class="font-bold text-base sm:text-lg leading-tight tracking-wide uppercase">Agogo State College</h1>
          <p class="text-xs text-amber-200 font-medium tracking-wider">Student Portal</p>
        </div>
      </div>

      <div class="flex items-center space-x-4">
        <div class="hidden sm:block text-right">
          <p class="text-xs font-semibold text-white">{{ $student->name }}</p>
          <p class="text-[11px] text-amber-300">Index: {{ $student->index_number ?? 'N/A' }}</p>
        </div>
        <button class="w-9 h-9 rounded-full bg-asc-green-dark flex items-center justify-center border border-amber-400 text-amber-300 hover:text-white transition">
          <i class="fa-solid fa-user text-sm"></i>
        </button>
      </div>
    </div>
  </header>

  <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 space-y-8">
    @yield('content')
  </main>

  <footer class="bg-slate-900 text-slate-400 text-xs py-6 border-t border-slate-800 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
      <div class="flex items-center space-x-2">
        <span class="font-bold text-white">Agogo State College</span>
        <span>• Portal v2.4</span>
      </div>
      <p>&copy; {{ date('Y') }} Agogo State College. All rights reserved.</p>
    </div>
  </footer>

  @stack('scripts')
</body>
</html>