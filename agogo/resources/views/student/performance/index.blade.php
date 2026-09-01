@extends('student.layout')

@section('title', 'Performance Tracker')

@push('styles')
<style>
  .chart-container {
    position: relative;
    height: 260px;
    width: 100%;
  }
  .chart-container-sm {
    position: relative;
    height: 180px;
    width: 100%;
  }
</style>
@endpush

@section('content')
<div>
  <!-- HEADER -->
  <div class="mb-6">
    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Performance Tracker</h2>
    <p class="text-sm text-slate-500 mt-1">
      Track your progress across all semesters and quickly spot subjects that need attention
    </p>
  </div>

  @if(count($subjectsData) === 0)
    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
      <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fa-solid fa-chart-line text-2xl text-slate-400"></i>
      </div>
      <h3 class="font-bold text-slate-700">No performance data yet</h3>
      <p class="text-sm text-slate-500 mt-1">Your graphs will appear here once scores are recorded.</p>
    </div>
  @else

    <!-- SUMMARY CARDS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
      <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-[11px] font-bold text-slate-500 uppercase">Strongest Subject</p>
        <p class="text-lg font-extrabold text-emerald-700 mt-2 truncate">{{ $strongest['subject']->name ?? '—' }}</p>
        <p class="text-xs text-slate-500 mt-1">Avg {{ $strongest['average'] ?? '—' }}%</p>
      </div>

      <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-[11px] font-bold text-slate-500 uppercase">Weakest Subject</p>
        <p class="text-lg font-extrabold text-rose-700 mt-2 truncate">{{ $weakest['subject']->name ?? '—' }}</p>
        <p class="text-xs text-slate-500 mt-1">Avg {{ $weakest['average'] ?? '—' }}%</p>
      </div>

      <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-[11px] font-bold text-slate-500 uppercase">Improving</p>
        <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $improving }}</p>
        <p class="text-xs text-slate-500 mt-1">Subjects rising</p>
      </div>

      <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-[11px] font-bold text-slate-500 uppercase">Needs Attention</p>
        <p class="text-3xl font-extrabold text-rose-600 mt-2">{{ $fallingShortCount }}</p>
        <p class="text-xs text-slate-500 mt-1">Subjects falling short</p>
      </div>
    </div>

    <!-- ==================== OVERVIEW CHARTS ==================== -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">

      <!-- MULTI-LINE OVERVIEW -->
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h3 class="font-bold text-slate-900 mb-1">All Subjects Over Time</h3>
        <p class="text-xs text-slate-500 mb-4">Line graph showing every subject across semesters</p>
        <div class="chart-container">
          <canvas id="overviewLineChart"></canvas>
        </div>
      </div>

      <!-- BAR CHART - AVERAGE COMPARISON -->
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h3 class="font-bold text-slate-900 mb-1">Average Performance by Subject</h3>
        <p class="text-xs text-slate-500 mb-4">Easy comparison of your overall strength in each subject</p>
        <div class="chart-container">
          <canvas id="averageBarChart"></canvas>
        </div>
      </div>
    </div>

    <!-- ==================== INDIVIDUAL SUBJECT CARDS ==================== -->
    <h3 class="font-bold text-slate-900 text-lg mb-4">Subject Details</h3>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      @foreach($subjectsData as $index => $data)
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden
          {{ $data['is_falling_short'] ? 'ring-2 ring-rose-200' : '' }}">
          
          <div class="p-5 border-b border-slate-100 flex items-start justify-between gap-3">
            <div>
              <h3 class="font-bold text-slate-900">{{ $data['subject']->name }}</h3>
              <div class="flex flex-wrap items-center gap-3 mt-1 text-xs text-slate-500">
                <span>Latest: <strong class="text-slate-800">{{ $data['latest_total'] }}%</strong> ({{ $data['latest_grade'] }})</span>
                <span>Avg: <strong>{{ $data['average'] }}%</strong></span>
              </div>
            </div>

            <div class="flex flex-col items-end gap-1">
              <span class="text-xl font-bold {{ $data['trend_color'] }}">{{ $data['trend_icon'] }}</span>
              
              @if($data['is_falling_short'])
                <span class="px-2.5 py-1 bg-rose-100 text-rose-700 text-[10px] font-bold rounded-full">Needs Attention</span>
              @elseif($data['trend'] === 'improving')
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full">Improving</span>
              @else
                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-full">Stable</span>
              @endif
            </div>
          </div>

          <div class="p-5">
            <div class="chart-container-sm">
              <canvas id="subjectChart{{ $index }}"></canvas>
            </div>
          </div>
        </div>
      @endforeach
    </div>

  @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

  // ========== COLOURS ==========
  const colours = [
    '#0D5C3A', '#F59E0B', '#3B82F6', '#EF4444', '#8B5CF6',
    '#EC4899', '#14B8A6', '#F97316', '#6366F1', '#84CC16'
  ];

  // ========== 1. OVERVIEW MULTI-LINE CHART ==========
  @php
    // Collect all unique semester labels across all subjects
    $allLabels = collect($subjectsData)
      ->flatMap(fn($d) => collect($d['history'])->pluck('label'))
      ->unique()
      ->values();
  @endphp

  const overviewLabels = {!! json_encode($allLabels) !!};

  const overviewDatasets = [
    @foreach($subjectsData as $index => $data)
    {
      label: {!! json_encode($data['subject']->name) !!},
      data: overviewLabels.map(label => {
        const found = {!! json_encode($data['history']) !!}.find(h => h.label === label);
        return found ? found.total : null;
      }),
      borderColor: colours[{{ $index % 10 }}],
      backgroundColor: colours[{{ $index % 10 }}] + '22',
      borderWidth: 2.5,
      pointRadius: 4,
      pointHoverRadius: 6,
      tension: 0.3,
      spanGaps: true
    },
    @endforeach
  ];

  new Chart(document.getElementById('overviewLineChart'), {
    type: 'line',
    data: {
      labels: overviewLabels,
      datasets: overviewDatasets
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: 'bottom',
          labels: { boxWidth: 12, font: { size: 11 } }
        }
      },
      scales: {
        y: {
          min: 0,
          max: 100,
          ticks: { stepSize: 20, font: { size: 11 } },
          grid: { color: '#f1f5f9' }
        },
        x: {
          ticks: { font: { size: 10 }, maxRotation: 45, minRotation: 30 },
          grid: { display: false }
        }
      }
    }
  });

  // ========== 2. BAR CHART - AVERAGE PER SUBJECT ==========
  const barLabels = {!! json_encode(collect($subjectsData)->pluck('subject.name')) !!};
  const barData   = {!! json_encode(collect($subjectsData)->pluck('average')) !!};
  const barColors = barData.map((val, i) => {
    if (val >= 70) return '#059669';      // green
    if (val >= 50) return '#3B82F6';      // blue
    return '#E11D48';                   // red
  });

  new Chart(document.getElementById('averageBarChart'), {
    type: 'bar',
    data: {
      labels: barLabels,
      datasets: [{
        label: 'Average %',
        data: barData,
        backgroundColor: barColors,
        borderRadius: 6,
        borderSkipped: false
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false }
      },
      scales: {
        y: {
          min: 0,
          max: 100,
          ticks: { stepSize: 20, font: { size: 11 } },
          grid: { color: '#f1f5f9' }
        },
        x: {
          ticks: { font: { size: 10 }, maxRotation: 45, minRotation: 30 },
          grid: { display: false }
        }
      }
    }
  });

  // ========== 3. INDIVIDUAL SUBJECT LINE CHARTS ==========
  @foreach($subjectsData as $index => $data)
  (function() {
    const ctx = document.getElementById('subjectChart{{ $index }}');
    if (!ctx) return;

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: {!! json_encode(collect($data['history'])->pluck('label')) !!},
        datasets: [{
          label: 'Total %',
          data: {!! json_encode(collect($data['history'])->pluck('total')) !!},
          borderColor: '{{ $data["is_falling_short"] ? "#e11d48" : ($data["trend"] === "improving" ? "#059669" : "#0D5C3A") }}',
          backgroundColor: '{{ $data["is_falling_short"] ? "rgba(225,29,72,0.08)" : ($data["trend"] === "improving" ? "rgba(5,150,105,0.08)" : "rgba(13,92,58,0.08)") }}',
          borderWidth: 3,
          pointBackgroundColor: '{{ $data["is_falling_short"] ? "#e11d48" : ($data["trend"] === "improving" ? "#059669" : "#0D5C3A") }}',
          pointRadius: 5,
          pointHoverRadius: 7,
          fill: true,
          tension: 0.3
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: {
            min: 0,
            max: 100,
            ticks: { stepSize: 20, font: { size: 10 } },
            grid: { color: '#f1f5f9' }
          },
          x: {
            ticks: { font: { size: 10 }, maxRotation: 40, minRotation: 30 },
            grid: { display: false }
          }
        }
      }
    });
  })();
  @endforeach

});
</script>
@endpush