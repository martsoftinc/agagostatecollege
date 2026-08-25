@extends('admin.layout')

@section('title', 'Teacher & Staff Management - Agogo State College')

@push('scripts')
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')

<div x-data="{ 
    editStaffModal: false, 
    deleteModal: false,
    deleteUrl: '',
    deleteItemName: '',
    activeStaff: { id: '', staff_id: '', name: '', email: '', phone: '', role: 'teacher', qualification: '', is_active: 1 },
    confirmDelete(url, name) {
        this.deleteUrl = url;
        this.deleteItemName = name;
        this.deleteModal = true;
    }
}">

  <!-- HEADER -->
  <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Teacher & Staff Management
      </h2>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Manage academic tutors, administrative staff, qualifications, and system access.
      </p>
    </div>
  </section>

  {{-- ALERTS --}}
  @if(session('success'))
    <div class="mt-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold rounded-xl flex items-center justify-between">
      <span>{{ session('success') }}</span>
      <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
    </div>
  @endif

  @if(session('error'))
    <div class="mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-bold rounded-xl flex items-center justify-between">
      <span>{{ session('error') }}</span>
      <i class="fa-solid fa-triangle-exclamation text-rose-600 text-base"></i>
    </div>
  @endif

  @if($errors->any())
    <div class="mt-4 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold rounded-xl">
      <p class="font-bold mb-1">Please fix the following errors:</p>
      <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <!-- TOP SECTION: CREATION FORM & STATS -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">

    <!-- FORM: Add New Staff/Teacher -->
    <div class="lg:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
      <h3 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Register New Teacher or Staff</h3>
      
      <form action="{{ route('admin.staff.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @csrf
        
        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Staff ID / Reg No.</label>
          <input type="text" name="staff_id" value="{{ old('staff_id') }}" placeholder="e.g. ASC/T/2026/012" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Full Name <span class="text-rose-500">*</span></label>
          <input type="text" name="name" value="{{ old('name') }}" placeholder="e.g. Mr. Emmanuel Ampofo" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Address <span class="text-rose-500">*</span></label>
          <input type="email" name="email" value="{{ old('email') }}" placeholder="e.g. teacher@agogostatecollege.edu.gh" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Phone Number</label>
          <input type="text" name="phone" value="{{ old('phone') }}" placeholder="e.g. 0244123456" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">System Role <span class="text-rose-500">*</span></label>
          <select name="role" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
            <option value="teacher" {{ old('role') === 'teacher' ? 'selected' : '' }}>Teacher (Academic Staff)</option>
            <option value="staff" {{ old('role') === 'staff' ? 'selected' : '' }}>Non-Teaching / Admin Staff</option>
          </select>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Qualification / Rank</label>
          <input type="text" name="qualification" value="{{ old('qualification') }}" placeholder="e.g. B.Ed Mathematics, M.Sc" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Account Password <span class="text-rose-500">*</span></label>
          <input type="password" name="password" required placeholder="Minimum 8 characters" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>

        <div class="flex items-center gap-2 pt-6">
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-asc-green"></div>
            <span class="ml-2 text-xs font-bold text-slate-700">Account Active</span>
          </label>
        </div>

        <div class="md:col-span-2 pt-2">
          <button type="submit" class="w-full py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition shadow-sm">
            Save Staff Account
          </button>
        </div>
      </form>
    </div>

    <!-- QUICK STATS / FILTER SUMMARY -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col justify-between">
      <div>
        <h3 class="text-base font-bold text-slate-900 mb-4 border-b border-slate-100 pb-2">Filter Directory</h3>
        
        <div class="space-y-2">
          <a href="{{ route('admin.staff.index') }}" 
             class="flex items-center justify-between p-3 rounded-xl border transition {{ !$roleFilter ? 'bg-asc-green/10 border-asc-green text-asc-green-dark font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            <span class="text-xs">All Staff Members</span>
            <i class="fa-solid fa-users text-xs"></i>
          </a>

          <a href="{{ route('admin.staff.index', ['role' => 'teacher']) }}" 
             class="flex items-center justify-between p-3 rounded-xl border transition {{ $roleFilter === 'teacher' ? 'bg-asc-green/10 border-asc-green text-asc-green-dark font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            <span class="text-xs">Teaching Staff Only</span>
            <i class="fa-solid fa-chalkboard-user text-xs"></i>
          </a>

          <a href="{{ route('admin.staff.index', ['role' => 'staff']) }}" 
             class="flex items-center justify-between p-3 rounded-xl border transition {{ $roleFilter === 'staff' ? 'bg-asc-green/10 border-asc-green text-asc-green-dark font-bold' : 'border-slate-200 text-slate-600 hover:bg-slate-50' }}">
            <span class="text-xs">Non-Teaching Staff</span>
            <i class="fa-solid fa-user-tie text-xs"></i>
          </a>
        </div>
      </div>

      <div class="mt-6 pt-4 border-t border-slate-100 bg-slate-50 p-3 rounded-xl">
        <p class="text-[11px] text-slate-500 leading-relaxed">
          <i class="fa-solid fa-circle-info text-asc-green mr-1"></i>
          Accounts saved here have standard login access. Assigning them to specific class subjects or class tutor roles can be managed in <strong>Classes & Streams</strong>.
        </p>
      </div>
    </div>

  </div>

  <!-- DIRECTORY TABLE -->
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mt-8">
    <div class="p-5 border-b border-slate-100 bg-slate-50/50 flex flex-col sm:flex-row justify-between sm:items-center gap-2">
      <div>
        <h3 class="font-bold text-slate-900 text-base">
          {{ $roleFilter ? ucfirst($roleFilter) . ' Directory' : 'All Staff Directory' }}
        </h3>
        <p class="text-xs text-slate-500">Managing total {{ $staffMembers->total() }} recorded accounts</p>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-100/70 border-b border-slate-200 text-[11px] uppercase font-bold text-slate-500 tracking-wider">
            <th class="py-3 px-5">Staff Member</th>
            <th class="py-3 px-5">Role</th>
            <th class="py-3 px-5">Contact Details</th>
            <th class="py-3 px-5">Qualification</th>
            <th class="py-3 px-5">Status</th>
            <th class="py-3 px-5 text-right">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
          @forelse($staffMembers as $member)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="py-3.5 px-5">
                <div class="flex items-center gap-3">
                  <div class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 font-bold flex items-center justify-center text-xs border border-slate-200">
                    {{ strtoupper(substr($member->name, 0, 2)) }}
                  </div>
                  <div>
                    <p class="font-bold text-slate-900">{{ $member->name }}</p>
                    <p class="text-[11px] text-slate-400">{{ $member->staff_id ?? 'No Staff ID' }}</p>
                  </div>
                </div>
              </td>
              <td class="py-3.5 px-5">
                @if($member->role === 'teacher')
                  <span class="px-2.5 py-1 bg-emerald-50 border border-emerald-200 text-emerald-700 font-semibold rounded-md text-[11px] inline-flex items-center gap-1">
                    <i class="fa-solid fa-chalkboard-user text-[10px]"></i>
                    <span>Teacher</span>
                  </span>
                @else
                  <span class="px-2.5 py-1 bg-blue-50 border border-blue-200 text-blue-700 font-semibold rounded-md text-[11px] inline-flex items-center gap-1">
                    <i class="fa-solid fa-user-tie text-[10px]"></i>
                    <span>Staff</span>
                  </span>
                @endif
              </td>
              <td class="py-3.5 px-5">
                <p class="text-slate-900 font-medium">{{ $member->email }}</p>
                <p class="text-[11px] text-slate-400">{{ $member->phone ?? 'No Phone' }}</p>
              </td>
              <td class="py-3.5 px-5">
                <span class="text-slate-600 font-medium">{{ $member->qualification ?? 'N/A' }}</span>
              </td>
              <td class="py-3.5 px-5">
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $member->is_active ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                  {{ $member->is_active ? 'Active' : 'Disabled' }}
                </span>
              </td>
              <td class="py-3.5 px-5 text-right flex justify-end items-center gap-1.5">
                <button 
                  type="button"
                  @click="activeStaff = { 
                    id: '{{ $member->id }}', 
                    staff_id: '{{ $member->staff_id }}', 
                    name: '{{ addslashes($member->name) }}', 
                    email: '{{ $member->email }}', 
                    phone: '{{ $member->phone }}', 
                    role: '{{ $member->role }}', 
                    qualification: '{{ addslashes($member->qualification) }}', 
                    is_active: '{{ $member->is_active ? 1 : 0 }}' 
                  }; editStaffModal = true"
                  class="px-2.5 py-1 bg-slate-100 hover:bg-asc-green hover:text-white text-slate-700 font-semibold rounded-md transition text-[11px] inline-flex items-center gap-1">
                  <i class="fa-solid fa-pen-to-square"></i>
                  <span>Edit</span>
                </button>

                <button 
                  type="button"
                  @click="confirmDelete('{{ route('admin.staff.destroy', $member->id) }}', '{{ addslashes($member->name) }}')"
                  class="px-2.5 py-1 bg-rose-50 hover:bg-rose-600 hover:text-white text-rose-600 font-semibold rounded-md transition text-[11px] inline-flex items-center gap-1">
                  <i class="fa-solid fa-trash"></i>
                  <span>Delete</span>
                </button>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="py-8 text-center text-slate-400 text-xs">
                No staff members found matching the selected filter.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($staffMembers->hasPages())
      <div class="p-4 border-t border-slate-100">
        {{ $staffMembers->links() }}
      </div>
    @endif
  </section>

  <!-- ========================================================= -->
  <!-- MODAL: EDIT STAFF ACCOUNT -->
  <!-- ========================================================= -->
  <div x-show="editStaffModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div @click.away="editStaffModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-lg overflow-hidden">
      <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between bg-slate-50">
        <h3 class="font-bold text-slate-900 text-sm">Edit Staff Account</h3>
        <button @click="editStaffModal = false" class="text-slate-400 hover:text-slate-600"><i class="fa-solid fa-xmark"></i></button>
      </div>

      <form :action="'{{ url('admin/staff') }}/' + activeStaff.id" method="POST" class="p-6 space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Staff ID</label>
            <input type="text" name="staff_id" x-model="activeStaff.staff_id" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Full Name</label>
            <input type="text" name="name" x-model="activeStaff.name" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email</label>
            <input type="email" name="email" x-model="activeStaff.email" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Phone</label>
            <input type="text" name="phone" x-model="activeStaff.phone" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Role</label>
            <select name="role" x-model="activeStaff.role" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
              <option value="teacher">Teacher (Academic Staff)</option>
              <option value="staff">Non-Teaching / Admin Staff</option>
            </select>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Qualification</label>
            <input type="text" name="qualification" x-model="activeStaff.qualification" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">
            New Password <span class="text-slate-400 font-normal lowercase">(leave blank to keep current)</span>
          </label>
          <input type="password" name="password" placeholder="••••••••" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>

        <div>
          <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Account Status</label>
          <select name="is_active" x-model="activeStaff.is_active" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
            <option value="1">Active</option>
            <option value="0">Disabled / Inactive</option>
          </select>
        </div>

        <div class="flex items-center justify-end gap-2 pt-4 border-t border-slate-100">
          <button type="button" @click="editStaffModal = false" class="px-4 py-2 bg-slate-100 text-slate-600 text-xs font-bold rounded-xl">Cancel</button>
          <button type="submit" class="px-4 py-2 bg-asc-green text-white text-xs font-bold rounded-xl shadow-sm">Update Staff Account</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ========================================================= -->
  <!-- MODAL: DELETE CONFIRMATION -->
  <!-- ========================================================= -->
  <div x-show="deleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 backdrop-blur-sm p-4">
    <div @click.away="deleteModal = false" class="bg-white rounded-2xl shadow-xl w-full max-w-sm overflow-hidden p-6 text-center">
      <div class="w-12 h-12 bg-rose-100 text-rose-600 rounded-full flex items-center justify-center mx-auto mb-4 text-lg">
        <i class="fa-solid fa-triangle-exclamation"></i>
      </div>
      <h3 class="font-bold text-slate-900 text-base mb-1">Delete Account?</h3>
      <p class="text-xs text-slate-500 mb-6">
        Are you sure you want to delete <strong class="text-slate-800" x-text="deleteItemName"></strong>? This will remove their authentication user record.
      </p>
      
      <form :action="deleteUrl" method="POST" class="flex items-center gap-3">
        @csrf
        @method('DELETE')
        <button type="button" @click="deleteModal = false" class="w-1/2 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold rounded-xl transition">
          Cancel
        </button>
        <button type="submit" class="w-1/2 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl transition shadow-sm">
          Delete Account
        </button>
      </form>
    </div>
  </div>

</div>

@endsection