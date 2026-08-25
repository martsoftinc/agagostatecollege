<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agogo State College - Student Portal Login</title>
  
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            asc: {
              green: '#0D5C3A',      /* Primary Forest Green */
              'green-dark': '#083D26',
              yellow: '#F59E0B',     /* Vibrant Gold / Yellow */
              'yellow-hover': '#D97706',
              bg: '#F8FAFC'
            }
          }
        }
      }
    }
  </script>
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-asc-bg text-slate-800 font-sans antialiased min-h-screen flex flex-col justify-between">

  <!-- TOP HEADER DECORATION BAR -->
  <div class="h-2 bg-gradient-to-r from-asc-green via-asc-yellow to-asc-green-dark w-full"></div>

  <!-- MAIN CONTAINER -->
  <main class="flex-grow flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">

      <!-- SCHOOL LOGO & BRANDING HEADER -->
      <div class="text-center mb-8">
        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-asc-green text-asc-yellow border-4 border-asc-yellow shadow-lg mb-4">
          <span class="font-extrabold text-2xl tracking-wider">ASC</span>
        </div>
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight uppercase">
          Agogo State College
        </h1>
        <p class="text-xs sm:text-sm font-semibold text-asc-green mt-1 tracking-wider uppercase">
          Student Portal Authentication
        </p>
      </div>

      <!-- LOGIN CARD -->
      <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden relative">
        <!-- Top Card Color Accent -->
        <div class="h-1.5 bg-asc-yellow w-full"></div>

        <div class="p-6 sm:p-8">
          
          <h2 class="text-xl font-bold text-slate-900 mb-1">Welcome Back!</h2>
          <p class="text-xs text-slate-500 mb-6">Enter your credentials to access your terminal reports and portal.</p>

          <!-- LOGIN FORM -->
          <form action="/login" method="POST" class="space-y-5">
            
            <!-- STUDENT ID INPUT -->
            <div>
              <label for="student_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Student ID / Index Number
              </label>
              <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                  <i class="fa-solid fa-id-card"></i>
                </div>
                <input 
                  type="text" 
                  name="student_id" 
                  id="student_id" 
                  required 
                  placeholder="e.g. ASC-2026-5535" 
                  class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm font-mono placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-asc-green focus:border-transparent uppercase transition"
                >
              </div>
              <div class="mt-2 text-right">
                <a href="#forgot-id" class="text-xs font-semibold text-asc-green hover:text-asc-green-dark hover:underline inline-flex items-center gap-1">
                  <i class="fa-solid fa-circle-question text-[10px]"></i> Forgotten your ID? Click here
                </a>
              </div>
            </div>

            <!-- PIN CODE INPUT -->
            <div>
              <label for="pin" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Security PIN Code
              </label>
              <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                  <i class="fa-solid fa-key"></i>
                </div>
                <input 
                  type="password" 
                  name="pin" 
                  id="pin" 
                  maxlength="6"
                  required 
                  placeholder="••••" 
                  class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm font-mono tracking-widest placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-asc-green focus:border-transparent transition"
                >
              </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <button 
              type="submit" 
              class="w-full bg-asc-green hover:bg-asc-green-dark text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition duration-200 flex items-center justify-center space-x-2 text-sm uppercase tracking-wider mt-2 group"
            >
              <span>Login to Portal</span>
              <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </button>

          </form>

          <!-- FORGOTTEN PIN NOTICE BOX -->
          <div class="mt-6 pt-5 border-t border-slate-100 bg-amber-50 rounded-xl p-3.5 border border-amber-200/80 flex items-start space-x-3">
            <div class="w-6 h-6 rounded-full bg-asc-yellow text-asc-green-dark flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">
              <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            <p class="text-xs text-amber-900 leading-relaxed">
              <span class="font-bold">Forgotten your PIN?</span> Please contact the School Administrator, <span class="font-bold underline text-slate-900">Mr. Nii Armah</span>, at the IT Secretariat for a PIN reset.
            </p>
          </div>

        </div>
      </div>

    </div>
  </main>

  <!-- FOOTER -->
  <footer class="py-4 text-center text-xs text-slate-500">
    <p>&copy; 2026 Agogo State College. All rights reserved.</p>
  </footer>

</body>
</html>