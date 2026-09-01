@extends('admin.layout')

@section('title', 'Admin Dashboard - Agogo State College')

@section('content')

  <!-- 1. GREETING HEADER -->
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
      <a href="{{ route('admin.students.index') }}"
         class="px-4 py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
        <i class="fa-solid fa-plus"></i>
        <span>New Admission</span>
      </a>
    </div>
  </section>

  <!-- 2. METRICS + CHARTS -->
  <section class="grid grid-cols-1 xl:grid-cols-3 gap-6 mt-6">

    <!-- LEFT: 4 METRIC CARDS -->
    <div class="xl:col-span-1 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-1 gap-4">

      <!-- Enrolled Students -->
      <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Enrolled Students</p>
          <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ number_format($totalEnrolled) }}</h3>
        </div>
        <div class="w-11 h-11 rounded-xl bg-emerald-50 text-asc-green flex items-center justify-center text-lg">
          <i class="fa-solid fa-user-graduate"></i>
        </div>
      </div>

      <!-- Pending Admissions -->
      <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Pending Admissions</p>
          <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $pendingAdmissions }}</h3>
        </div>
        <div class="w-11 h-11 rounded-xl bg-amber-50 text-asc-yellow-hover flex items-center justify-center text-lg">
          <i class="fa-solid fa-user-plus"></i>
        </div>
      </div>

      <!-- Total Teachers -->
      <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Total Teachers</p>
          <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalTeachers }}</h3>
        </div>
        <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg">
          <i class="fa-solid fa-chalkboard-user"></i>
        </div>
      </div>

      <!-- Active Classes -->
      <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Active Classes</p>
          <h3 class="text-2xl font-extrabold text-slate-900 mt-1">{{ $totalClasses }}</h3>
        </div>
        <div class="w-11 h-11 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg">
          <i class="fa-solid fa-school"></i>
        </div>
      </div>
    </div>

    <!-- GENDER CHART -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
      <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Gender Distribution</p>
      <p class="text-[11px] text-slate-500 mb-4">Active enrolled students</p>

      <div class="relative" style="height: 190px;">
        <canvas id="genderChart"></canvas>
      </div>

      <div class="flex items-center justify-center gap-5 mt-4 text-xs">
        <div class="flex items-center gap-1.5">
          <span class="w-3 h-3 rounded-full bg-blue-500"></span>
          <span class="text-slate-600">Male: <strong>{{ number_format($maleStudents) }}</strong></span>
        </div>
        <div class="flex items-center gap-1.5">
          <span class="w-3 h-3 rounded-full bg-pink-500"></span>
          <span class="text-slate-600">Female: <strong>{{ number_format($femaleStudents) }}</strong></span>
        </div>
      </div>
    </div>

    <!-- BOARDING vs DAY CHART -->
    <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
      <p class="text-xs font-semibold uppercase tracking-wider text-slate-400 mb-1">Boarding vs Day</p>
      <p class="text-[11px] text-slate-500 mb-4">Student residential status</p>

      <div class="relative" style="height: 190px;">
        <canvas id="boardingChart"></canvas>
      </div>

      <div class="flex items-center justify-center gap-5 mt-4 text-xs">
        <div class="flex items-center gap-1.5">
          <span class="w-3 h-3 rounded-full bg-asc-green"></span>
          <span class="text-slate-600">Boarding: <strong>{{ number_format($boardingStudents) }}</strong></span>
        </div>
        <div class="flex items-center gap-1.5">
          <span class="w-3 h-3 rounded-full bg-asc-yellow"></span>
          <span class="text-slate-600">Day: <strong>{{ number_format($dayStudents) }}</strong></span>
        </div>
      </div>
    </div>
  </section>

  <!-- 3. CLASS POPULATION BREAKDOWN -->
  <section class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden mt-6">
    <div class="p-5 border-b border-slate-100 bg-slate-50/50">
      <h3 class="font-bold text-slate-900 text-base">Class Population Breakdown</h3>
      <p class="text-xs text-slate-500">Distribution of enrolled students across classes and streams</p>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-100/70 border-b border-slate-200 text-[11px] uppercase font-bold text-slate-500 tracking-wider">
            <th class="py-3 px-5">Class Name</th>
            <th class="py-3 px-5">Class Tutor</th>
            <th class="py-3 px-5">Capacity</th>
            <th class="py-3 px-5">Enrolled</th>
            <th class="py-3 px-5">Gender (M / F)</th>
            <th class="py-3 px-5">Occupancy</th>
            <th class="py-3 px-5 text-right">Action</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
          @forelse($classBreakdown as $class)
            <tr class="hover:bg-slate-50/80 transition">
              <td class="py-3.5 px-5 font-bold text-slate-900">{{ $class['name'] }}</td>
              <td class="py-3.5 px-5">{{ $class['tutor'] }}</td>
              <td class="py-3.5 px-5">{{ $class['capacity'] }}</td>
              <td class="py-3.5 px-5 font-semibold text-slate-900">{{ $class['enrolled'] }} Students</td>
              <td class="py-3.5 px-5">
                <span class="text-blue-600 font-semibold">{{ $class['male'] }}M</span>
                <span class="text-slate-400 mx-1">/</span>
                <span class="text-pink-600 font-semibold">{{ $class['female'] }}F</span>
              </td>
              <td class="py-3.5 px-5">
                <div class="flex items-center gap-2">
                  <div class="w-24 bg-slate-200 h-2 rounded-full overflow-hidden">
                    <div class="h-full rounded-full
                      {{ $class['occupancy'] >= 95 ? 'bg-rose-500' : ($class['occupancy'] >= 80 ? 'bg-asc-yellow' : 'bg-asc-green') }}"
                         style="width: {{ min($class['occupancy'], 100) }}%">
                    </div>
                  </div>
                  <span class="font-bold text-[11px] {{ $class['occupancy'] >= 100 ? 'text-rose-600' : '' }}">
                    {{ $class['occupancy'] >= 100 ? 'Full' : $class['occupancy'] . '%' }}
                  </span>
                </div>
              </td>
              <td class="py-3.5 px-5 text-right">
                <a href="{{ route('admin.class-streams.subjects', $class['id']) }}"
                   class="px-3 py-1 bg-slate-100 hover:bg-asc-green hover:text-white text-slate-700 font-semibold rounded-md transition text-[11px]">
                  View Class
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="py-10 text-center text-slate-400">
                No active classes found.
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ===== GENDER CHART =====
  const genderCtx = document.getElementById('genderChart');
  if (genderCtx) {
    new Chart(genderCtx, {
      type: 'doughnut',
      data: {
        labels: ['Male', 'Female'],
        datasets: [{
          data: [{{ $maleStudents }}, {{ $femaleStudents }}],
          backgroundColor: ['#3B82F6', '#EC4899'],
          borderWidth: 0,
          hoverOffset: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: function(context) {
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const value = context.raw;
                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                return `${context.label}: ${value} (${percentage}%)`;
              }
            }
          }
        }
      }
    });
  }

  // ===== BOARDING vs DAY CHART =====
  const boardingCtx = document.getElementById('boardingChart');
  if (boardingCtx) {
    new Chart(boardingCtx, {
      type: 'doughnut',
      data: {
        labels: ['Boarding', 'Day'],
        datasets: [{
          data: [{{ $boardingStudents }}, {{ $dayStudents }}],
          backgroundColor: ['#0D5C3A', '#F59E0B'],
          borderWidth: 0,
          hoverOffset: 6
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '65%',
        plugins: {
          legend: { display: false },
          tooltip: {
            callbacks: {
              label: function(context) {
                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                const value = context.raw;
                const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                return `${context.label}: ${value} (${percentage}%)`;
              }
            }
          }
        }
      }
    });
  }

});
</script>
@endpush