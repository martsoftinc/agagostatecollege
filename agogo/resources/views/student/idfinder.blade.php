<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agogo State College - Find Student ID</title>
  
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
          Student ID Lookup Portal
        </p>
      </div>

      <!-- LOOKUP CARD -->
      <div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden relative">
        <div class="h-1.5 bg-asc-yellow w-full"></div>

        <div class="p-6 sm:p-8">
          
          <div class="flex items-center space-x-3 mb-6">
            <a href="/login" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition" title="Back to Login">
              <i class="fa-solid fa-arrow-left text-xs"></i>
            </a>
            <div>
              <h2 class="text-xl font-bold text-slate-900 leading-none">Find Your Student ID</h2>
              <p class="text-xs text-slate-500 mt-1">Enter your details below to locate your index number.</p>
            </div>
          </div>

          <!-- SEARCH FORM -->
          <form id="lookupForm" onsubmit="handleFindId(event)" class="space-y-5">
            
            <!-- FIELD 1: STUDENT NAME -->
            <div>
              <label for="student_name" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Student Full Name
              </label>
              <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                  <i class="fa-solid fa-user"></i>
                </div>
                <input 
                  type="text" 
                  id="student_name" 
                  required 
                  placeholder="e.g. Kwame Armah" 
                  class="block w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-asc-green focus:border-transparent transition"
                >
              </div>
            </div>

            <!-- FIELD 2: CLASS SELECT -->
            <div>
              <label for="class" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                Class / Form
              </label>
              <div class="relative rounded-xl shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                  <i class="fa-solid fa-chalkboard-user"></i>
                </div>
                <select 
                  id="class" 
                  required 
                  class="block w-full pl-10 pr-10 py-3 bg-slate-50 border border-slate-300 rounded-xl text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green focus:border-transparent appearance-none transition"
                >
                  <option value="" disabled selected>-- Select Your Class --</option>
                  <optgroup label="Form 1">
                    <option value="Form 1 Science 1">Form 1 Science 1</option>
                    <option value="Form 1 General Arts 1">Form 1 General Arts 1</option>
                    <option value="Form 1 Business">Form 1 Business</option>
                  </optgroup>
                  <optgroup label="Form 2">
                    <option value="Form 2 Science 1">Form 2 Science 1</option>
                    <option value="Form 2 General Arts 1">Form 2 General Arts 1</option>
                    <option value="Form 2 Business">Form 2 Business</option>
                  </optgroup>
                  <optgroup label="Form 3">
                    <option value="Form 3 Science 1">Form 3 Science 1</option>
                    <option value="Form 3 General Arts 1">Form 3 General Arts 1</option>
                    <option value="Form 3 Business">Form 3 Business</option>
                  </optgroup>
                </select>
                <div class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                  <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
              </div>
            </div>

            <!-- SUBMIT BUTTON -->
            <button 
              type="submit" 
              class="w-full bg-asc-green hover:bg-asc-green-dark text-white font-bold py-3.5 px-4 rounded-xl shadow-md hover:shadow-lg transition duration-200 flex items-center justify-center space-x-2 text-sm uppercase tracking-wider mt-2 group"
            >
              <i class="fa-solid fa-magnifying-glass text-xs"></i>
              <span>Find My ID</span>
            </button>

          </form>

          <!-- ADMIN ASSISTANCE NOTICE -->
          <div class="mt-6 pt-5 border-t border-slate-100 bg-amber-50 rounded-xl p-3.5 border border-amber-200/80 flex items-start space-x-3">
            <div class="w-6 h-6 rounded-full bg-asc-yellow text-asc-green-dark flex-shrink-0 flex items-center justify-center text-xs font-bold mt-0.5">
              <i class="fa-solid fa-info"></i>
            </div>
            <p class="text-xs text-amber-900 leading-relaxed">
              Name not showing up? Contact <span class="font-bold underline text-slate-900">Mr. Nii Armah</span> at the IT Secretariat.
            </p>
          </div>

        </div>
      </div>

    </div>
  </main>

  <!-- ========================================================= -->
  <!-- RESULT MODAL WINDOW (POPUP) -->
  <!-- ========================================================= -->
  <div id="resultModal" class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-sm hidden px-4 transition-opacity">
    <div class="bg-white rounded-2xl shadow-2xl border border-slate-200 max-w-sm w-full p-6 text-center relative animate-in fade-in zoom-in duration-200">
      
      <!-- Top Success Icon -->
      <div class="w-16 h-16 rounded-full bg-emerald-100 text-asc-green border-4 border-emerald-200 mx-auto flex items-center justify-center text-2xl mb-4">
        <i class="fa-solid fa-id-badge"></i>
      </div>

      <h3 class="text-xl font-extrabold text-slate-900">Student ID Found!</h3>
      <p class="text-xs text-slate-500 mt-1">Here is your official Agogo State College index number.</p>

      <!-- Student Record Details -->
      <div class="bg-slate-50 rounded-xl p-4 my-5 border border-slate-200 text-left space-y-2">
        <div class="flex justify-between items-center text-xs">
          <span class="text-slate-400 font-medium">Name:</span>
          <span id="modalStudentName" class="font-bold text-slate-800">Kwame Armah</span>
        </div>
        <div class="flex justify-between items-center text-xs">
          <span class="text-slate-400 font-medium">Class:</span>
          <span id="modalStudentClass" class="font-semibold text-slate-700">Form 3 Science 1</span>
        </div>
        
        <!-- ID DISPLAY & COPY BOX -->
        <div class="pt-2 border-t border-slate-200">
          <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Your Student ID</span>
          <div class="flex items-center space-x-2">
            <input 
              type="text" 
              id="modalStudentId" 
              readonly 
              value="ASC-2026-5535" 
              class="block w-full text-center bg-white border-2 border-asc-green text-asc-green font-mono font-extrabold text-lg py-2 rounded-lg focus:outline-none"
            >
            <!-- COPY BUTTON -->
            <button 
              type="button" 
              onclick="copyStudentId()" 
              id="copyBtn"
              class="bg-asc-yellow hover:bg-asc-yellow-hover text-slate-900 font-bold px-3 py-2.5 rounded-lg text-xs flex items-center justify-center space-x-1 transition shadow-sm whitespace-nowrap"
            >
              <i class="fa-regular fa-copy"></i>
              <span id="copyBtnText">Copy</span>
            </button>
          </div>
        </div>
      </div>

      <!-- ACTION BUTTON: GO BACK TO LOGIN -->
      <a 
        href="/login" 
        class="w-full bg-asc-green hover:bg-asc-green-dark text-white font-bold py-3 px-4 rounded-xl shadow-md transition flex items-center justify-center space-x-2 text-sm uppercase tracking-wider"
      >
        <span>Go Back to Login Page</span>
        <i class="fa-solid fa-right-to-bracket text-xs"></i>
      </a>

      <!-- Close Modal Icon (Optional) -->
      <button onclick="closeModal()" class="absolute top-4 right-4 text-slate-400 hover:text-slate-600">
        <i class="fa-solid fa-xmark text-lg"></i>
      </button>

    </div>
  </div>

  <!-- FOOTER -->
  <footer class="py-4 text-center text-xs text-slate-500">
    <p>&copy; 2026 Agogo State College. All rights reserved.</p>
  </footer>

  <!-- JAVASCRIPT FOR MODAL & COPY FUNCTIONALITY -->
  <script>
    function handleFindId(event) {
      event.preventDefault();

      // Read form input values
      const nameInput = document.getElementById('student_name').value;
      const classInput = document.getElementById('class').value;

      // Populate modal data dynamically
      document.getElementById('modalStudentName').textContent = nameInput;
      document.getElementById('modalStudentClass').textContent = classInput;

      // Show Modal
      document.getElementById('resultModal').classList.remove('hidden');
    }

    function closeModal() {
      document.getElementById('resultModal').classList.add('hidden');
    }

    function copyStudentId() {
      const idInput = document.getElementById('modalStudentId');
      
      // Select & Copy to Clipboard
      idInput.select();
      idInput.setSelectionRange(0, 99999); // Mobile compatibility
      navigator.clipboard.writeText(idInput.value);

      // Feedback animation on button
      const copyBtnText = document.getElementById('copyBtnText');
      const copyBtn = document.getElementById('copyBtn');
      
      copyBtnText.textContent = 'Copied!';
      copyBtn.classList.remove('bg-asc-yellow');
      copyBtn.classList.add('bg-emerald-500', 'text-white');

      // Reset button after 2 seconds
      setTimeout(() => {
        copyBtnText.textContent = 'Copy';
        copyBtn.classList.remove('bg-emerald-500', 'text-white');
        copyBtn.classList.add('bg-asc-yellow');
      }, 2000);
    }
  </script>

</body>
</html>