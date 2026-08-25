@extends('admin.layout')

@section('title', 'Admin Dashboard - Agogo State College')

@section('content')

  <!-- 1. GREETING & SUMMARY HEADER -->
  <section class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
    <div>
      <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
        Admin Overview 👋
      </h2>
      <p class="text-xs sm:text-sm text-slate-500 mt-1">
        Agogo State College • Academic Session {{ date('Y') }}
      </p>
    </div>
    <div class="flex items-center gap-3">
      <a href="#" class="px-4 py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i>
        <span>New Admission</span>
      </a>
      <a href="#" class="px-4 py-2.5 bg-white border border-slate-200 text-slate-700 hover:bg-slate-50 font-bold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
        <i class="fa-solid fa-download"></i>
        <span>Export Data</span>
      </a>
    </div>
  </section>

  <!-- 2. AT-A-GLANCE METRICS CARDS -->
  <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
    
    <!-- Card 1: Total Enrolled Students -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Enrolled Students</p>
        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalEnrolled ?? 1280) }}</h3>
        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-600 mt-1">
          <i class="fa-solid fa-arrow-trend-up"></i> +4.2% from last term
        </span>
      </div>
      <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-asc-green flex items-center justify-center text-2xl font-bold">
        <i class="fa-solid fa-user-graduate"></i>
      </div>
    </div>

    <!-- Card 2: Pending Admissions -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pending Admissions</p>
        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $pendingAdmissions ?? 42 }}</h3>
        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-600 mt-1">
          <i class="fa-solid fa-clock"></i> Requires review
        </span>
      </div>
      <div class="w-14 h-14 rounded-2xl bg-amber-50 text-asc-yellow-hover flex items-center justify-center text-2xl font-bold">
        <i class="fa-solid fa-user-plus"></i>
      </div>
    </div>

    <!-- Card 3: Teaching Staff -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Teachers</p>
        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $totalTeachers ?? 64 }}</h3>
        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-slate-500 mt-1">
          <i class="fa-solid fa-circle-check text-emerald-500"></i> Active faculty
        </span>
      </div>
      <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold">
        <i class="fa-solid fa-chalkboard-user"></i>
      </div>
    </div>

    <!-- Card 4: Active Classes -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Active Classes</p>
        <h3 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">{{ $totalClasses ?? 24 }}</h3>
        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-purple-600 mt-1">
          <i class="fa-solid fa-layer-group"></i> SHS 1 to SHS 3
        </span>
      </div>
      <div class="w-14 h-14 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-2xl font-bold">
        <i class="fa-solid fa-school"></i>
      </div>
    </div>

  </section>

  <!-- 3. CLASS & STUDENT BREAKDOWN SECTION -->
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    
    <div class="p-5 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-slate-50/50">
      <div>
        <h3 class="font-bold text-slate-900 text-base">Class Population Breakdown</h3>
        <p class="text-xs text-slate-500">Distribution of enrolled students across classes and streams</p>
      </div>
      <div class="flex items-center gap-2">
        <input type="text" placeholder="Filter class..." class="px-3 py-1.5 text-xs border border-slate-200 rounded-lg focus:outline-none focus:border-asc-green">
      </div>
    </div>

    <!-- Class Breakdown Table -->
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-100/70 border-b border-slate-200 text-[11px] uppercase font-bold text-slate-500 tracking-wider">
            <th class="py-3 px-5">Class Name</th>
            <th class="py-3 px-5">Class Tutor</th>
            <th class="py-3 px-5">Capacity</th>
            <th class="py-3 px-5">Enrolled Students</th>
            <th class="py-3 px-5">Occupancy Rate</th>
            <th class="py-3 px-5 text-right">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
          
          <!-- Row 1 -->
          <tr class="hover:bg-slate-50/80 transition">
            <td class="py-3.5 px-5 font-bold text-slate-900">SHS 1 Science A</td>
            <td class="py-3.5 px-5">Mr. Kwaku Mensah</td>
            <td class="py-3.5 px-5">60</td>
            <td class="py-3.5 px-5 font-semibold text-slate-900">58 Students</td>
            <td class="py-3.5 px-5">
              <div class="flex items-center gap-2">
                <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                  <div class="bg-asc-green h-full rounded-full" style="width: 96%"></div>
                </div>
                <span class="font-bold text-[11px]">96%</span>
              </div>
            </td>
            <td class="py-3.5 px-5 text-right">
              <a href="#" class="px-3 py-1 bg-slate-100 hover:bg-asc-green hover:text-white text-slate-700 font-semibold rounded-md transition text-[11px]">View Class</a>
            </td>
          </tr>

          <!-- Row 2 -->
          <tr class="hover:bg-slate-50/80 transition">
            <td class="py-3.5 px-5 font-bold text-slate-900">SHS 1 Arts B</td>
            <td class="py-3.5 px-5">Mrs. Grace Osei</td>
            <td class="py-3.5 px-5">60</td>
            <td class="py-3.5 px-5 font-semibold text-slate-900">52 Students</td>
            <td class="py-3.5 px-5">
              <div class="flex items-center gap-2">
                <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                  <div class="bg-asc-green h-full rounded-full" style="width: 86%"></div>
                </div>
                <span class="font-bold text-[11px]">86%</span>
              </div>
            </td>
            <td class="py-3.5 px-5 text-right">
              <a href="#" class="px-3 py-1 bg-slate-100 hover:bg-asc-green hover:text-white text-slate-700 font-semibold rounded-md transition text-[11px]">View Class</a>
            </td>
          </tr>

          <!-- Row 3 -->
          <tr class="hover:bg-slate-50/80 transition">
            <td class="py-3.5 px-5 font-bold text-slate-900">SHS 2 Business A</td>
            <td class="py-3.5 px-5">Mr. Michael Asare</td>
            <td class="py-3.5 px-5">55</td>
            <td class="py-3.5 px-5 font-semibold text-slate-900">54 Students</td>
            <td class="py-3.5 px-5">
              <div class="flex items-center gap-2">
                <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                  <div class="bg-asc-green h-full rounded-full" style="width: 98%"></div>
                </div>
                <span class="font-bold text-[11px]">98%</span>
              </div>
            </td>
            <td class="py-3.5 px-5 text-right">
              <a href="#" class="px-3 py-1 bg-slate-100 hover:bg-asc-green hover:text-white text-slate-700 font-semibold rounded-md transition text-[11px]">View Class</a>
            </td>
          </tr>

          <!-- Row 4 -->
          <tr class="hover:bg-slate-50/80 transition">
            <td class="py-3.5 px-5 font-bold text-slate-900">SHS 2 Visual Arts</td>
            <td class="py-3.5 px-5">Ms. Akua Afriyie</td>
            <td class="py-3.5 px-5">45</td>
            <td class="py-3.5 px-5 font-semibold text-slate-900">38 Students</td>
            <td class="py-3.5 px-5">
              <div class="flex items-center gap-2">
                <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                  <div class="bg-asc-yellow h-full rounded-full" style="width: 84%"></div>
                </div>
                <span class="font-bold text-[11px]">84%</span>
              </div>
            </td>
            <td class="py-3.5 px-5 text-right">
              <a href="#" class="px-3 py-1 bg-slate-100 hover:bg-asc-green hover:text-white text-slate-700 font-semibold rounded-md transition text-[11px]">View Class</a>
            </td>
          </tr>

          <!-- Row 5 -->
          <tr class="hover:bg-slate-50/80 transition">
            <td class="py-3.5 px-5 font-bold text-slate-900">SHS 3 Science A</td>
            <td class="py-3.5 px-5">Dr. John Appiah</td>
            <td class="py-3.5 px-5">60</td>
            <td class="py-3.5 px-5 font-semibold text-slate-900">60 Students</td>
            <td class="py-3.5 px-5">
              <div class="flex items-center gap-2">
                <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                  <div class="bg-rose-500 h-full rounded-full" style="width: 100%"></div>
                </div>
                <span class="font-bold text-[11px] text-rose-600">Full</span>
              </div>
            </td>
            <td class="py-3.5 px-5 text-right">
              <a href="#" class="px-3 py-1 bg-slate-100 hover:bg-asc-green hover:text-white text-slate-700 font-semibold rounded-md transition text-[11px]">View Class</a>
            </td>
          </tr>

        </tbody>
      </table>
    </div>

  </section>

@endsection