@extends('admin.layout')

@section('title', 'Student Management')

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush

@section('content')
<div class="p-6" x-data="{ 
    addModalOpen: false,
    editModalOpen: false,
    viewModalOpen: false,
    editStudent: {},
    viewStudent: {},
    classesByCourse: @js($classesByCourse ?? []),
    allClasses: @js($allClasses ?? []),
    
    // Add Form State
    addCourse: '{{ old('course', '') }}',
    addClass: '{{ old('class', '') }}',

    formatDate(dateString) {
        if (!dateString) return '';
        // Ensures YYYY-MM-DD format for HTML date inputs
        return dateString.substring(0, 10);
    },

    openEditModal(student) {
        this.editStudent = { ...student };
        // Clean date format for the HTML5 date picker input
        if (this.editStudent.date_of_birth) {
            this.editStudent.date_of_birth = this.formatDate(this.editStudent.date_of_birth);
        }
        this.editModalOpen = true;
    },

    openViewModal(student) {
        this.viewStudent = { ...student };
        this.viewModalOpen = true;
    },

    get filteredClasses() {
        if (!this.addCourse) return this.allClasses;
        
        if (this.classesByCourse[this.addCourse]) {
            return this.classesByCourse[this.addCourse];
        }

        let matchKey = Object.keys(this.classesByCourse).find(k => 
            this.addCourse.toLowerCase().includes(k.toLowerCase()) || 
            k.toLowerCase().includes(this.addCourse.toLowerCase())
        );

        return matchKey ? this.classesByCourse[matchKey] : this.allClasses;
    },

    onCourseChange() {
        this.addClass = '';
        let available = this.filteredClasses;
        if (available && available.length === 1) {
            this.addClass = available[0];
        }
    }
}">

    <!-- TOP HEADER -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Student Directory</h1>
            <p class="text-xs text-slate-500">Manage student records, class enrollments, and status allocations.</p>
        </div>

        <div class="flex items-center gap-3">
            <!-- ADD NEW STUDENT BUTTON -->
            <button 
                type="button" 
                @click.stop="addModalOpen = true" 
                class="px-4 py-2 text-xs font-semibold text-white bg-asc-green hover:bg-emerald-800 rounded-xl transition shadow-sm flex items-center gap-2 cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add New Student
            </button>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    @if(session('success'))
        <div class="mb-4 p-4 text-xs text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-900">&times;</button>
        </div>
    @endif

    <!-- QUICK WASSCE GRADUATION BANNER -->
    <div class="mb-6 p-4 bg-gradient-to-r from-blue-900 to-indigo-900 text-white rounded-2xl shadow-md flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <div class="p-2.5 bg-white/10 rounded-xl">
                <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-white">Batch Graduation / Mark WASSCE Completed</h3>
                <p class="text-xs text-blue-200">Quickly transition entire final year cohorts or selected classes to Completed status.</p>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.students.batch-wassce') }}" onsubmit="return confirm('Are you sure you want to mark all students in this class as Completed (WASSCE)?')" class="flex items-center gap-2 w-full md:w-auto">
            @csrf
            <select name="class_to_complete" required class="px-3 py-2 text-xs bg-white/10 text-white border border-white/20 rounded-xl focus:outline-none focus:bg-slate-800">
                <option value="" class="text-slate-800">Select Final Class...</option>
                @foreach($allClasses as $c)
                    <option value="{{ $c }}" class="text-slate-800">{{ $c }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2 text-xs font-semibold bg-white text-blue-900 hover:bg-blue-50 rounded-xl transition whitespace-nowrap shadow-sm">
                Mark Class Completed
            </button>
        </form>
    </div>

    <!-- FILTER BAR -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-6">
        <form method="GET" action="{{ route('admin.students.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <div>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search name or index..." class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
            </div>

            <div>
                <select name="course" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
                    <option value="">All Courses</option>
                    @foreach($courses as $c)
                        <option value="{{ $c }}" {{ $courseFilter === $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="class" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
                    <option value="">All Classes</option>
                    @foreach($allClasses as $c)
                        <option value="{{ $c }}" {{ $classFilter === $c ? 'selected' : '' }}>{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <select name="status" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
                    <option value="">All Statuses</option>
                    <option value="Active" {{ $statusFilter === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Completed" {{ $statusFilter === 'Completed' ? 'selected' : '' }}>Completed (WASSCE)</option>
                    <option value="Suspended" {{ $statusFilter === 'Suspended' ? 'selected' : '' }}>Suspended</option>
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button type="submit" class="w-full py-2 text-xs font-semibold text-slate-700 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Filter
                </button>
                <a href="{{ route('admin.students.index') }}" class="py-2 px-3 text-xs text-center text-slate-500 hover:text-slate-700 bg-slate-50 border border-slate-200 rounded-xl transition">
                    Reset
                </a>
            </div>
        </form>
    </div>

    <!-- STUDENTS TABLE -->
    <div class="bg-white border border-slate-100 rounded-2xl shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs text-slate-600">
                <thead class="bg-slate-50 text-slate-500 font-bold uppercase border-b border-slate-100">
                    <tr>
                        <th class="p-3">Index No.</th>
                        <th class="p-3">Full Name</th>
                        <th class="p-3">Course</th>
                        <th class="p-3">Class & Stream</th>
                        <th class="p-3">Status</th>
                        <th class="p-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($students as $student)
                        <tr class="hover:bg-slate-50/50 transition">
                            <td class="p-3 font-semibold text-slate-800">{{ $student->index_number ?? 'N/A' }}</td>
                            <td class="p-3 font-medium text-slate-900">
                                {{ $student->surname }} {{ $student->first_name }} {{ $student->middle_name }}
                            </td>
                            <td class="p-3">{{ $student->course }}</td>
                            <td class="p-3">{{ $student->class }}</td>
                            <td class="p-3">
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-semibold
                                    {{ $student->status === 'Active' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : '' }}
                                    {{ $student->status === 'Completed' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                                    {{ $student->status === 'Suspended' ? 'bg-rose-50 text-rose-700 border border-rose-200' : '' }}">
                                    {{ $student->status === 'Completed' ? 'WASSCE / Completed' : ($student->status ?? 'Active') }}
                                </span>
                            </td>
                            <td class="p-3 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <!-- VIEW STUDENT BUTTON -->
                                    <button 
                                        type="button" 
                                        @click.stop="openViewModal(@js($student))"
                                        title="View Details"
                                        class="p-1.5 text-slate-500 hover:text-blue-600 hover:bg-slate-100 rounded-lg transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>

                                    <!-- EDIT STUDENT BUTTON -->
                                    <button 
                                        type="button" 
                                        @click.stop="openEditModal(@js($student))"
                                        title="Edit Student"
                                        class="p-1.5 text-slate-500 hover:text-asc-green hover:bg-slate-100 rounded-lg transition cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                        </svg>
                                    </button>

                                    <!-- STATUS TOGGLE -->
                                    <form method="POST" action="{{ route('admin.students.update-status', $student->id) }}" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        @if($student->status === 'Completed')
                                            <input type="hidden" name="status" value="Active">
                                            <button type="submit" title="Mark as Active Student" class="px-2 py-1 text-[10px] font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 hover:bg-emerald-100 rounded-lg transition">
                                                Set Active
                                            </button>
                                        @else
                                            <input type="hidden" name="status" value="Completed">
                                            <button type="submit" title="Mark as WASSCE Graduated" class="px-2 py-1 text-[10px] font-medium text-blue-700 bg-blue-50 border border-blue-200 hover:bg-blue-100 rounded-lg transition">
                                                Mark WASSCE
                                            </button>
                                        @endif
                                    </form>

                                    <!-- DELETE ACTION -->
                                    <form method="POST" action="{{ route('admin.students.destroy', $student->id) }}" onsubmit="return confirm('Are you sure you want to delete this record?')" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Delete Student" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-6 text-center text-slate-400">No student records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t border-slate-100">
            {{ $students->links() }}
        </div>
    </div>

    <!-- REGISTER NEW STUDENT MODAL -->
    <div 
        x-show="addModalOpen" 
        x-cloak
        x-on:keydown.escape.window="addModalOpen = false"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="addModalOpen = false"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden p-6 transform transition-all my-8 z-10">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                    <h3 class="text-base font-bold text-slate-800">Register New Student</h3>
                    <button type="button" @click="addModalOpen = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form method="POST" action="{{ route('admin.students.store') }}">
                    @csrf

                    <!-- SECTION 1: PERSONAL DETAILS -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-3 border-b pb-1">1. Personal Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Surname <span class="text-rose-500">*</span></label>
                                <input type="text" name="surname" value="{{ old('surname') }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">First Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="first_name" value="{{ old('first_name') }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Middle Name</label>
                                <input type="text" name="middle_name" value="{{ old('middle_name') }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Date of Birth <span class="text-rose-500">*</span></label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Place of Residence</label>
                                <input type="text" name="place_of_residence" value="{{ old('place_of_residence') }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Full Address</label>
                                <input type="text" name="address" value="{{ old('address') }}" placeholder="Postal/Residential Address" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: ACADEMIC & CLASS ASSIGNMENT -->
<div class="mb-6">
    <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-3 border-b pb-1">2. Academic & Class Assignment</h4>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        <div>
            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Index No.</label>
            <input type="text" name="index_number" value="{{ old('index_number') }}" placeholder="Auto-generated if blank" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-slate-50">
        </div>

        <div>
            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Course <span class="text-rose-500">*</span></label>
            <select 
                name="course" 
                required 
                x-model="addCourse" 
                @change="onCourseChange()"
                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
                <option value="">-- Select Course --</option>
                @foreach($courses as $c)
                    <option value="{{ $c }}">{{ $c }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Class Level & Stream <span class="text-rose-500">*</span></label>
            <select 
                name="class" 
                required 
                x-model="addClass"
                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
                <option value="">-- Select Class & Stream --</option>
                <template x-for="className in filteredClasses" :key="className">
                    <option :value="className" x-text="className"></option>
                </template>
            </select>
        </div>

        <div>
            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Track <span class="text-rose-500">*</span></label>
            <select name="track" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
                <option value="Single Track">Single Track</option>
                <option value="Green">Green</option>
                <option value="Gold">Gold</option>
            </select>
        </div>

        <div>
            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Status</label>
            <select name="status" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
                <option value="Active">Active</option>
                <option value="Completed">Completed (WASSCE)</option>
                <option value="Suspended">Suspended</option>
            </select>
        </div>

        <div>
            <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">House Allocation</label>
            <input type="text" name="house" value="{{ old('house') }}" placeholder="e.g. House 1" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
        </div>
    </div>
</div>

                    <!-- SECTION 3: GUARDIAN DETAILS -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-3 border-b pb-1">3. Guardian Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Guardian Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="guardian_name" value="{{ old('guardian_name') }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Guardian Phone <span class="text-rose-500">*</span></label>
                                <input type="text" name="guardian_phone" value="{{ old('guardian_phone') }}" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Guardian Occupation</label>
                                <input type="text" name="guardian_occupation" value="{{ old('guardian_occupation') }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: PREVIOUS EDUCATION & BACKGROUND -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-3 border-b pb-1">4. Junior High School Background</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Previous JHS School</label>
                                <input type="text" name="jhs_previous_school" value="{{ old('jhs_previous_school') }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">JHS Index Number</label>
                                <input type="text" name="jhs_index_number" value="{{ old('jhs_index_number') }}" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">JHS Position Held</label>
                                <input type="text" name="jhs_position_held" value="{{ old('jhs_position_held') }}" placeholder="e.g. Senior Prefect" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 5: ADDITIONAL NOTES & MEDICAL -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-3 border-b pb-1">5. Special Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Interests & Hobbies</label>
                                <textarea name="interests_hobbies" rows="2" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">{{ old('interests_hobbies') }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Medical Conditions / Allergies</label>
                                <textarea name="medical_conditions" rows="2" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">{{ old('medical_conditions') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT ACTIONS -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="addModalOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 text-xs font-semibold text-white bg-asc-green hover:bg-emerald-800 rounded-xl transition shadow-sm">
                            Save Student Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT STUDENT MODAL -->
    <div 
        x-show="editModalOpen" 
        x-cloak
        x-on:keydown.escape.window="editModalOpen = false"
        class="fixed inset-0 z-50 overflow-y-auto"
        style="display: none;"
    >
        <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="editModalOpen = false"></div>

        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative w-full max-w-4xl bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden p-6 transform transition-all my-8 z-10">
                <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                    <h3 class="text-base font-bold text-slate-800">Edit Student Record</h3>
                    <button type="button" @click="editModalOpen = false" class="text-slate-400 hover:text-slate-600">&times;</button>
                </div>

                <form :action="'{{ url('admin/students') }}/' + editStudent.id" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- SECTION 1: PERSONAL DETAILS -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-3 border-b pb-1">1. Personal Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Surname <span class="text-rose-500">*</span></label>
                                <input type="text" name="surname" x-model="editStudent.surname" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">First Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="first_name" x-model="editStudent.first_name" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Middle Name</label>
                                <input type="text" name="middle_name" x-model="editStudent.middle_name" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Date of Birth <span class="text-rose-500">*</span></label>
                                <input type="date" name="date_of_birth" x-model="editStudent.date_of_birth" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Place of Residence</label>
                                <input type="text" name="place_of_residence" x-model="editStudent.place_of_residence" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Full Address</label>
                                <input type="text" name="address" x-model="editStudent.address" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: ACADEMIC & CLASS ASSIGNMENT -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-3 border-b pb-1">2. Academic & Class Assignment</h4>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Index No.</label>
                                <input type="text" name="index_number" x-model="editStudent.index_number" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Course <span class="text-rose-500">*</span></label>
                                <select 
                                    name="course" 
                                    required 
                                    x-model="editStudent.course"
                                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
                                    <option value="">-- Select Course --</option>
                                    @foreach($courses as $c)
                                        <option value="{{ $c }}">{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Class Level & Stream <span class="text-rose-500">*</span></label>
                                <select 
                                    name="class" 
                                    required 
                                    x-model="editStudent.class"
                                    class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
                                    <option value="">-- Select Class --</option>
                                    @foreach($allClasses as $c)
                                        <option value="{{ $c }}">{{ $c }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Track <span class="text-rose-500">*</span></label>
                                <select name="track" x-model="editStudent.track" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
                                    <option value="Single Track">Single Track</option>
                                    <option value="Green">Green</option>
                                    <option value="Gold">Gold</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Status <span class="text-rose-500">*</span></label>
                                <select name="status" x-model="editStudent.status" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
                                    <option value="Active">Active</option>
                                    <option value="Completed">Completed (WASSCE)</option>
                                    <option value="Suspended">Suspended</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">House</label>
                                <input type="text" name="house" x-model="editStudent.house" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 3: GUARDIAN DETAILS -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-3 border-b pb-1">3. Guardian Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Guardian Name <span class="text-rose-500">*</span></label>
                                <input type="text" name="guardian_name" x-model="editStudent.guardian_name" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Guardian Phone <span class="text-rose-500">*</span></label>
                                <input type="text" name="guardian_phone" x-model="editStudent.guardian_phone" required class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Guardian Occupation</label>
                                <input type="text" name="guardian_occupation" x-model="editStudent.guardian_occupation" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: PREVIOUS EDUCATION & BACKGROUND -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-3 border-b pb-1">4. Junior High School Background</h4>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Previous JHS School</label>
                                <input type="text" name="jhs_previous_school" x-model="editStudent.jhs_previous_school" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">JHS Index Number</label>
                                <input type="text" name="jhs_index_number" x-model="editStudent.jhs_index_number" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">JHS Position Held</label>
                                <input type="text" name="jhs_position_held" x-model="editStudent.jhs_position_held" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 5: SPECIAL INFORMATION -->
                    <div class="mb-6">
                        <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-3 border-b pb-1">5. Special Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Interests & Hobbies</label>
                                <textarea name="interests_hobbies" x-model="editStudent.interests_hobbies" rows="2" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none"></textarea>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-700 uppercase mb-1">Medical Conditions / Allergies</label>
                                <textarea name="medical_conditions" x-model="editStudent.medical_conditions" rows="2" class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- SUBMIT ACTIONS -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100">
                        <button type="button" @click="editModalOpen = false" class="px-4 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                            Cancel
                        </button>
                        <button type="submit" class="px-5 py-2 text-xs font-semibold text-white bg-asc-green hover:bg-emerald-800 rounded-xl transition shadow-sm">
                            Update Student Record
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- VIEW STUDENT INFORMATION MODAL -->
    <div 
    x-show="viewModalOpen" 
    x-cloak
    x-on:keydown.escape.window="viewModalOpen = false"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none;"
>
    <div class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" @click="viewModalOpen = false"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative w-full max-w-3xl bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden p-6 transform transition-all my-8 z-10">
            <!-- HEADER -->
            <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-bold text-sm">
                        <span x-text="(viewStudent.first_name ? viewStudent.first_name[0] : '') + (viewStudent.surname ? viewStudent.surname[0] : '')"></span>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-slate-800" x-text="(viewStudent.surname || '') + ' ' + (viewStudent.first_name || '') + ' ' + (viewStudent.middle_name || '')"></h3>
                        <p class="text-xs text-slate-500">Index No: <span class="font-semibold text-slate-700" x-text="viewStudent.index_number || 'N/A'"></span></p>
                    </div>
                </div>
                <button type="button" @click="viewModalOpen = false" class="text-slate-400 hover:text-slate-600 text-lg">&times;</button>
            </div>

            <div class="space-y-6 max-h-[70vh] overflow-y-auto pr-1">
                <!-- SECTION 1: PERSONAL & ACADEMIC -->
                <div>
                    <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-2 border-b pb-1">1. Academic & Status</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 bg-slate-50 p-3 rounded-xl text-xs">
                        <div>
                            <span class="block text-slate-400 font-medium">Course:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.course || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Class Stream:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.class || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Track:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.track || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Status:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.status || 'Active'"></span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">House:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.house || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Date of Birth:</span>
                            <span class="font-semibold text-slate-800" x-text="formatDate(viewStudent.date_of_birth) || 'N/A'"></span>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: RESIDENTIAL & GUARDIAN -->
                <div>
                    <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-2 border-b pb-1">2. Contact & Guardian Details</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 bg-slate-50 p-3 rounded-xl text-xs">
                        <div>
                            <span class="block text-slate-400 font-medium">Guardian Name:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.guardian_name || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Guardian Phone:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.guardian_phone || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Guardian Occupation:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.guardian_occupation || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Residence:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.place_of_residence || 'N/A'"></span>
                        </div>
                        <div class="col-span-2">
                            <span class="block text-slate-400 font-medium">Full Address:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.address || 'N/A'"></span>
                        </div>
                    </div>
                </div>

                <!-- SECTION 3: JHS BACKGROUND -->
                <div>
                    <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-2 border-b pb-1">3. Junior High School Background</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 bg-slate-50 p-3 rounded-xl text-xs">
                        <div>
                            <span class="block text-slate-400 font-medium">Previous JHS:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.jhs_previous_school || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">JHS Index No:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.jhs_index_number || 'N/A'"></span>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Position Held:</span>
                            <span class="font-semibold text-slate-800" x-text="viewStudent.jhs_position_held || 'N/A'"></span>
                        </div>
                    </div>
                </div>

                <!-- SECTION 4: MEDICAL & NOTES -->
                <div>
                    <h4 class="text-xs font-bold text-asc-green uppercase tracking-wider mb-2 border-b pb-1">4. Special Information</h4>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-3 rounded-xl text-xs">
                        <div>
                            <span class="block text-slate-400 font-medium">Interests & Hobbies:</span>
                            <p class="font-medium text-slate-700 mt-0.5 whitespace-pre-line" x-text="viewStudent.interests_hobbies || 'None recorded'"></p>
                        </div>
                        <div>
                            <span class="block text-slate-400 font-medium">Medical Conditions / Allergies:</span>
                            <p class="font-medium text-slate-700 mt-0.5 whitespace-pre-line" x-text="viewStudent.medical_conditions || 'None recorded'"></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FOOTER -->
            <div class="flex items-center justify-end pt-4 border-t border-slate-100 mt-4">
                <button type="button" @click="viewModalOpen = false" class="px-5 py-2 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
</div>
@endsection