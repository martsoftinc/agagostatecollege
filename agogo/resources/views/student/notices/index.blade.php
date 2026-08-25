<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Announcements - Student Portal</title>
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
</head>
<body class="bg-asc-bg text-slate-800 font-sans antialiased min-h-screen flex flex-col">

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
      <a href="{{ route('student.dashboard') }}" class="text-sm font-medium text-amber-200 hover:text-white">
        <i class="fa-solid fa-arrow-left mr-1"></i> Dashboard
      </a>
    </div>
  </header>

  <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8" x-data="noticeViewer()">

    <div class="mb-6">
      <h1 class="text-2xl font-bold text-slate-800">Announcements & School Updates</h1>
      <p class="text-sm text-slate-500 mt-1">Notices for {{ $student->class }} • {{ $student->programme }}</p>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="divide-y divide-slate-100">
        @forelse($notices as $notice)
          <div class="p-5 sm:p-6 hover:bg-slate-50/80 transition flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-asc-green/10 text-asc-green flex items-center justify-center flex-shrink-0">
              <i class="fa-solid fa-bullhorn"></i>
            </div>
            <div class="flex-grow min-w-0">
              <div class="flex flex-wrap items-center justify-between gap-2 mb-1">
                <h3 class="text-base font-bold text-slate-900">{{ $notice->title }}</h3>
                <span class="text-xs text-slate-400">{{ $notice->created_at->format('d M Y') }}</span>
              </div>
              <p class="text-sm text-slate-600 leading-relaxed line-clamp-2">
                {{ \Illuminate\Support\Str::limit(strip_tags($notice->body), 160) }}
              </p>
              <div class="mt-3 flex items-center justify-between">
                <span class="text-xs text-slate-400">
                  <i class="fa-regular fa-clock mr-1"></i>
                  {{ $notice->created_at->diffForHumans() }}
                </span>
                <button @click="openNotice({{ $notice->id }})"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-asc-green bg-asc-green/10 hover:bg-asc-green hover:text-white rounded-lg transition">
                  <i class="fa-solid fa-eye"></i> View
                </button>
              </div>
            </div>
          </div>
        @empty
          <div class="p-12 text-center text-slate-400">
            <i class="fa-solid fa-bullhorn text-3xl mb-3 block"></i>
            No announcements yet.
          </div>
        @endforelse
      </div>

      @if($notices->hasPages())
        <div class="px-5 py-4 border-t border-slate-100">
          {{ $notices->links() }}
        </div>
      @endif
    </div>

    {{-- Same Modal --}}
    <div x-show="modalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display:none;">
      <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="closeModal()"></div>
      <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-lg max-h-[90vh] overflow-y-auto" @click.stop>
        <div class="sticky top-0 bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-lg bg-asc-green/10 text-asc-green flex items-center justify-center">
              <i class="fa-solid fa-bullhorn"></i>
            </div>
            <h2 class="text-lg font-bold text-slate-800" x-text="notice.title"></h2>
          </div>
          <button @click="closeModal()" class="text-slate-400 hover:text-slate-600">
            <i class="fa-solid fa-xmark text-xl"></i>
          </button>
        </div>
        <div class="p-6 space-y-4">
          <div class="flex items-center gap-2 text-xs text-slate-400">
            <span x-text="notice.created_at"></span>
            <span>•</span>
            <span x-text="notice.human_date"></span>
          </div>
          <div class="text-sm text-slate-700 leading-relaxed whitespace-pre-line" x-text="notice.body"></div>
        </div>
        <div class="px-6 py-4 border-t border-slate-100 flex justify-end">
          <button @click="closeModal()" class="px-5 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl">
            Close
          </button>
        </div>
      </div>
    </div>
  </main>

  <script>
    function noticeViewer() {
      return {
        modalOpen: false,
        notice: { title: '', body: '', created_at: '', human_date: '' },
        async openNotice(id) {
          try {
            const res = await fetch(`/student/notices/${id}`, {
              headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
            });
            if (!res.ok) throw new Error();
            this.notice = await res.json();
            this.modalOpen = true;
          } catch (e) {
            alert('Could not load this announcement.');
          }
        },
        closeModal() { this.modalOpen = false; }
      }
    }
  </script>
</body>
</html>