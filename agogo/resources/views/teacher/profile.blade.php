@extends('teacher.layout')

@section('title', 'My Profile - Agogo State College')

@section('content')

  <!-- Page Header -->
  <section class="bg-gradient-to-r from-asc-green to-asc-green-dark rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-asc-yellow opacity-10 rounded-full blur-2xl -mr-10 -mt-10"></div>
    
    <div class="relative z-10">
      <span class="inline-block px-3 py-1 bg-asc-yellow/20 border border-asc-yellow/30 text-asc-yellow text-xs font-semibold rounded-full mb-2">
        Account Settings
      </span>
      <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">
        My Profile
      </h2>
      <p class="text-xs sm:text-sm text-slate-200 mt-1">
        Manage your personal information and security settings
      </p>
    </div>
  </section>

  <div class="max-w-3xl space-y-6">

    <!-- ═══════════════════════════════════════════ -->
    <!-- SECTION 1: Personal Information            -->
    <!-- ═══════════════════════════════════════════ -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      
      <!-- Card Header -->
      <div class="p-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
        <div class="w-9 h-9 rounded-lg bg-asc-green/10 text-asc-green flex items-center justify-center">
          <i class="fa-solid fa-user text-sm"></i>
        </div>
        <div>
          <h3 class="font-bold text-slate-900 text-base">Personal Information</h3>
          <p class="text-xs text-slate-500">Update your name, contact details and professional info</p>
        </div>
      </div>

      <div class="p-5 sm:p-6">

        {{-- Success / Error flashes --}}
        @if(session('profile_success'))
          <div class="mb-5 flex items-start gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
            <i class="fa-solid fa-circle-check mt-0.5 text-emerald-600"></i>
            <span>{{ session('profile_success') }}</span>
          </div>
        @endif

        @if($errors->profileErrors->any())
          <div class="mb-5 flex items-start gap-3 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <i class="fa-solid fa-circle-exclamation mt-0.5 text-rose-600"></i>
            <ul class="list-disc list-inside space-y-0.5">
              @foreach($errors->profileErrors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        {{-- Avatar Preview --}}
        <div class="flex items-center gap-4 mb-6 p-4 rounded-xl bg-slate-50 border border-slate-100">
          @if($user->profile_picture)
            <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                 alt="{{ $user->full_name }}"
                 class="w-16 h-16 rounded-xl object-cover border-2 border-white shadow-sm">
          @else
            <div class="w-16 h-16 rounded-xl bg-asc-green text-asc-yellow flex items-center justify-center text-xl font-extrabold shadow-sm">
              {{ strtoupper(substr($user->first_name ?? 'T', 0, 1) . substr($user->last_name ?? '', 0, 1)) }}
            </div>
          @endif
          <div>
            <div class="font-bold text-slate-900 text-lg">{{ $user->full_name ?? 'Teacher' }}</div>
            <div class="text-sm text-slate-500">
              {{ $user->rank ?? 'Teacher' }}
              @if($user->staff_id)
                <span class="mx-1.5 text-slate-300">•</span>
                <span class="font-medium text-asc-green">{{ $user->staff_id }}</span>
              @endif
            </div>
          </div>
        </div>

        <form action="{{ route('teacher.profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

            <!-- First Name -->
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1.5" for="first_name">First Name</label>
              <input type="text" id="first_name" name="first_name"
                     value="{{ old('first_name', $user->first_name) }}"
                     class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition {{ $errors->profileErrors->has('first_name') ? 'border-rose-400' : '' }}"
                     placeholder="e.g. Michael">
              @error('first_name', 'profileErrors')
                <p class="mt-1 text-xs text-rose-600 flex items-center gap-1">
                  <i class="fa-solid fa-circle-exclamation text-[10px]"></i> {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Last Name -->
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1.5" for="last_name">Last Name</label>
              <input type="text" id="last_name" name="last_name"
                     value="{{ old('last_name', $user->last_name) }}"
                     class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition {{ $errors->profileErrors->has('last_name') ? 'border-rose-400' : '' }}"
                     placeholder="e.g. Asare">
              @error('last_name', 'profileErrors')
                <p class="mt-1 text-xs text-rose-600 flex items-center gap-1">
                  <i class="fa-solid fa-circle-exclamation text-[10px]"></i> {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Other Names -->
            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-slate-600 mb-1.5" for="other_names">Other Names <span class="text-slate-400 font-normal">(optional)</span></label>
              <input type="text" id="other_names" name="other_names"
                     value="{{ old('other_names', $user->other_names) }}"
                     class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition"
                     placeholder="e.g. Kofi">
            </div>

            <!-- Email -->
            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-slate-600 mb-1.5" for="email">Email Address</label>
              <input type="email" id="email" name="email"
                     value="{{ old('email', $user->email) }}"
                     class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition {{ $errors->profileErrors->has('email') ? 'border-rose-400' : '' }}"
                     placeholder="e.g. teacher@agogostatecollege.edu.gh">
              @error('email', 'profileErrors')
                <p class="mt-1 text-xs text-rose-600 flex items-center gap-1">
                  <i class="fa-solid fa-circle-exclamation text-[10px]"></i> {{ $message }}
                </p>
              @enderror
            </div>

            <!-- Phone -->
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1.5" for="phone">Phone Number</label>
              <input type="text" id="phone" name="phone"
                     value="{{ old('phone', $user->phone) }}"
                     class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition"
                     placeholder="e.g. 024XXXXXXX">
            </div>

            <!-- Qualification -->
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1.5" for="qualification">Qualification</label>
              <input type="text" id="qualification" name="qualification"
                     value="{{ old('qualification', $user->qualification) }}"
                     class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition"
                     placeholder="e.g. B.Ed Mathematics">
            </div>

            <!-- Staff ID (read-only) -->
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1.5">Staff ID</label>
              <input type="text" value="{{ $user->staff_id ?? '—' }}" disabled
                     class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-500 cursor-not-allowed">
            </div>

            <!-- Rank (read-only) -->
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1.5">Rank</label>
              <input type="text" value="{{ $user->rank ?? 'Teacher' }}" disabled
                     class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 bg-slate-50 text-sm text-slate-500 cursor-not-allowed">
            </div>

            <!-- Profile Picture -->
            <div class="sm:col-span-2">
              <label class="block text-xs font-semibold text-slate-600 mb-1.5" for="profile_picture">Profile Picture</label>
              <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                     class="w-full text-sm text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-asc-green/10 file:text-asc-green hover:file:bg-asc-green/20 transition">
              <p class="mt-1 text-[11px] text-slate-400">JPG, PNG or WEBP. Max 2MB.</p>
            </div>
          </div>

          <div class="mt-6 flex items-center gap-3">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition shadow-sm">
              <i class="fa-solid fa-floppy-disk"></i>
              Save Changes
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ═══════════════════════════════════════════ -->
    <!-- SECTION 2: Change Password                 -->
    <!-- ═══════════════════════════════════════════ -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      
      <div class="p-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
        <div class="w-9 h-9 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
          <i class="fa-solid fa-key text-sm"></i>
        </div>
        <div>
          <h3 class="font-bold text-slate-900 text-base">Change Password</h3>
          <p class="text-xs text-slate-500">Choose a strong, unique password</p>
        </div>
      </div>

      <div class="p-5 sm:p-6">

        @if(session('password_success'))
          <div class="mb-5 flex items-start gap-3 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm">
            <i class="fa-solid fa-circle-check mt-0.5 text-emerald-600"></i>
            <span>{{ session('password_success') }}</span>
          </div>
        @endif

        @if($errors->passwordErrors->any())
          <div class="mb-5 flex items-start gap-3 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm">
            <i class="fa-solid fa-circle-exclamation mt-0.5 text-rose-600"></i>
            <ul class="list-disc list-inside space-y-0.5">
              @foreach($errors->passwordErrors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('teacher.profile.password') }}" method="POST">
          @csrf
          @method('PUT')

          <div class="space-y-4">
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1.5" for="current_password">Current Password</label>
              <input type="password" id="current_password" name="current_password"
                     class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition {{ $errors->passwordErrors->has('current_password') ? 'border-rose-400' : '' }}"
                     placeholder="Enter your current password" autocomplete="current-password">
              @error('current_password', 'passwordErrors')
                <p class="mt-1 text-xs text-rose-600 flex items-center gap-1">
                  <i class="fa-solid fa-circle-exclamation text-[10px]"></i> {{ $message }}
                </p>
              @enderror
            </div>

            <hr class="border-slate-100">

            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1.5" for="new_password">New Password</label>
              <input type="password" id="new_password" name="new_password"
                     class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition {{ $errors->passwordErrors->has('new_password') ? 'border-rose-400' : '' }}"
                     placeholder="Min. 8 characters" autocomplete="new-password"
                     oninput="checkStrength(this.value)">
              
              <!-- Strength bar -->
              <div class="mt-2 h-1.5 rounded-full bg-slate-100 overflow-hidden">
                <div id="strengthFill" class="h-full rounded-full transition-all duration-300" style="width:0%"></div>
              </div>
              <p id="strengthLabel" class="mt-1 text-xs text-slate-400"></p>

              @error('new_password', 'passwordErrors')
                <p class="mt-1 text-xs text-rose-600 flex items-center gap-1">
                  <i class="fa-solid fa-circle-exclamation text-[10px]"></i> {{ $message }}
                </p>
              @enderror
            </div>

            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1.5" for="new_password_confirmation">Confirm New Password</label>
              <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                     class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 text-sm focus:outline-none focus:ring-2 focus:ring-asc-green/30 focus:border-asc-green transition"
                     placeholder="Re-enter new password" autocomplete="new-password">
            </div>
          </div>

          <div class="mt-6">
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-asc-yellow text-asc-green-dark text-sm font-semibold rounded-xl hover:bg-asc-yellow-hover transition shadow-sm">
              <i class="fa-solid fa-lock"></i>
              Update Password
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- ═══════════════════════════════════════════ -->
    <!-- SECTION 3: Security / 2FA                  -->
    <!-- ═══════════════════════════════════════════ -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      
      <div class="p-5 border-b border-slate-100 flex items-center gap-3 bg-slate-50/50">
        <div class="w-9 h-9 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center">
          <i class="fa-solid fa-shield-halved text-sm"></i>
        </div>
        <div>
          <h3 class="font-bold text-slate-900 text-base">Security</h3>
          <p class="text-xs text-slate-500">Protect your account with extra verification</p>
        </div>
      </div>

      <div class="p-5 sm:p-6">
        <div class="flex items-center justify-between gap-4 p-4 rounded-xl bg-slate-50 border border-slate-100">
          <div class="flex items-start gap-3">
            <div class="mt-0.5 w-9 h-9 rounded-lg bg-white border border-slate-200 flex items-center justify-center shadow-sm flex-shrink-0">
              <i class="fa-solid fa-mobile-screen text-slate-600"></i>
            </div>
            <div>
              <div class="flex items-center gap-2 flex-wrap">
                <span class="font-semibold text-sm text-slate-800">Two-Factor Authentication</span>
                <span id="twoFaBadge" 
                      class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide
                             {{ $user->two_factor_enabled ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                  {{ $user->two_factor_enabled ? 'On' : 'Off' }}
                </span>
              </div>
              <p class="text-xs text-slate-500 mt-0.5 leading-relaxed max-w-xs">
                Require a verification code each time you sign in.
              </p>
            </div>
          </div>

          <!-- Toggle -->
          <button type="button" id="twoFaToggle"
                  onclick="toggle2FA()"
                  class="relative w-12 h-7 rounded-full transition-colors duration-200 focus:outline-none
                         {{ $user->two_factor_enabled ? 'bg-asc-green' : 'bg-slate-300' }}">
            <span id="twoFaKnob"
                  class="absolute top-0.5 left-0.5 w-6 h-6 bg-white rounded-full shadow transition-transform duration-200
                         {{ $user->two_factor_enabled ? 'translate-x-5' : 'translate-x-0' }}"></span>
          </button>
        </div>

        <div id="twoFaInfo" class="{{ $user->two_factor_enabled ? '' : 'hidden' }} mt-4 p-4 rounded-xl border border-emerald-200 bg-emerald-50">
          <div class="flex items-start gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600 mt-0.5"></i>
            <div>
              <p class="text-xs font-semibold text-emerald-800">Two-Factor Authentication is enabled</p>
              <p class="text-xs text-emerald-700 mt-0.5">You’ll be prompted for a verification code each time you sign in.</p>
            </div>
          </div>
        </div>

        <div id="twoFaToast" class="hidden mt-3"></div>
      </div>
    </div>

  </div>
@endsection

@push('scripts')
<script>
  /* Password strength meter */
  function checkStrength(val) {
    const fill  = document.getElementById('strengthFill');
    const label = document.getElementById('strengthLabel');
    if (!fill || !label) return;

    let score = 0;
    if (val.length >= 8)           score++;
    if (/[A-Z]/.test(val))         score++;
    if (/[0-9]/.test(val))         score++;
    if (/[^A-Za-z0-9]/.test(val))  score++;

    const levels = [
      { pct: '0%',   color: '#e2e8f0', text: '' },
      { pct: '25%',  color: '#ef4444', text: 'Weak' },
      { pct: '50%',  color: '#f97316', text: 'Fair' },
      { pct: '75%',  color: '#eab308', text: 'Good' },
      { pct: '100%', color: '#22c55e', text: 'Strong' },
    ];
    const lv = val.length === 0 ? levels[0] : levels[score];
    fill.style.width      = lv.pct;
    fill.style.background = lv.color;
    label.textContent     = lv.text;
    label.style.color     = lv.color;
  }

  /* 2FA Toggle */
  let twoFaEnabled = {{ $user->two_factor_enabled ? 'true' : 'false' }};
  const track   = document.getElementById('twoFaToggle');
  const knob    = document.getElementById('twoFaKnob');
  const badge   = document.getElementById('twoFaBadge');
  const infoBox = document.getElementById('twoFaInfo');
  const toast   = document.getElementById('twoFaToast');

  function applyToggleState() {
    if (twoFaEnabled) {
      track.classList.remove('bg-slate-300');
      track.classList.add('bg-asc-green');
      knob.classList.add('translate-x-5');
      badge.textContent = 'On';
      badge.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-emerald-100 text-emerald-700';
      infoBox?.classList.remove('hidden');
    } else {
      track.classList.remove('bg-asc-green');
      track.classList.add('bg-slate-300');
      knob.classList.remove('translate-x-5');
      badge.textContent = 'Off';
      badge.className = 'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide bg-amber-100 text-amber-700';
      infoBox?.classList.add('hidden');
    }
  }

  function showToast(message, type = 'success') {
    const colors = {
      success: 'bg-emerald-50 border-emerald-200 text-emerald-800',
      warn:    'bg-amber-50 border-amber-200 text-amber-800',
      error:   'bg-rose-50 border-rose-200 text-rose-800',
    };
    toast.className = `flex items-start gap-3 p-4 rounded-xl border text-sm ${colors[type] || colors.success}`;
    toast.innerHTML = `<i class="fa-solid fa-circle-info mt-0.5"></i><span>${message}</span>`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3500);
  }

  async function toggle2FA() {
    twoFaEnabled = !twoFaEnabled;
    applyToggleState();
    track.style.pointerEvents = 'none';

    try {
      const res = await fetch('{{ route("teacher.profile.2fa") }}', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ enabled: twoFaEnabled }),
      });

      if (!res.ok) throw new Error('Server error');

      showToast(
        twoFaEnabled ? '2FA enabled — your account is more secure.' : '2FA disabled.',
        twoFaEnabled ? 'success' : 'warn'
      );
    } catch {
      twoFaEnabled = !twoFaEnabled;
      applyToggleState();
      showToast('Could not update 2FA. Please try again.', 'error');
    } finally {
      track.style.pointerEvents = '';
    }
  }
</script>
@endpush