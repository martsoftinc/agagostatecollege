<!-- CLASS INFO -->
<div class="mb-5">
  <h3 class="text-lg font-bold text-slate-900">
    {{ $selectedClassStream->schoolClass->name }} {{ $selectedClassStream->stream->name }}
  </h3>
  <p class="text-sm text-slate-500">{{ $selectedSubject->name }}</p>
</div>

<!-- SUMMARY CARDS -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
  <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-[11px] font-bold text-slate-500 uppercase">Class Average</p>
    <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ $summary['average'] ?? '—' }}%</p>
  </div>
  <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-[11px] font-bold text-slate-500 uppercase">Highest</p>
    <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $summary['highest'] ?? '—' }}%</p>
  </div>
  <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-[11px] font-bold text-slate-500 uppercase">Lowest</p>
    <p class="text-3xl font-extrabold text-rose-600 mt-2">{{ $summary['lowest'] ?? '—' }}%</p>
  </div>
  <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-[11px] font-bold text-slate-500 uppercase">Needs Attention</p>
    <p class="text-3xl font-extrabold text-rose-600 mt-2">{{ $summary['needsAttention'] ?? 0 }}</p>
    <p class="text-xs text-slate-500 mt-1">out of {{ $summary['totalStudents'] ?? 0 }}</p>
  </div>
</div>

<!-- CHARTS -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
    <h3 class="font-bold text-slate-900 mb-1">Class Average Over Time</h3>
    <div class="chart-container">
      <canvas id="classAverageChart"></canvas>
    </div>
  </div>
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
    <h3 class="font-bold text-slate-900 mb-1">Grade Distribution</h3>
    <div class="chart-container">
      <canvas id="gradeDistributionChart"></canvas>
    </div>
  </div>
</div>

<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-8">
  <h3 class="font-bold text-slate-900 mb-1">Student Comparison (Latest)</h3>
  <div class="chart-container">
    <canvas id="studentComparisonChart"></canvas>
  </div>
</div>

<!-- STUDENT TABLE -->
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
  <div class="p-5 border-b border-slate-100 bg-slate-50/50">
    <h3 class="font-bold text-slate-900">Student Performance Details</h3>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full text-left border-collapse min-w-[900px]">
      <thead>
        <tr class="bg-slate-100/80 text-[11px] uppercase font-bold text-slate-500">
          <th class="py-3 px-5">#</th>
          <th class="py-3 px-5">Student</th>
          <th class="py-3 px-4 text-center">Latest</th>
          <th class="py-3 px-4 text-center">Average</th>
          <th class="py-3 px-4 text-center">Trend</th>
          <th class="py-3 px-5">History</th>
          <th class="py-3 px-4 text-center">Status</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100 text-xs">
        @foreach($studentsData as $index => $data)
          <tr class="hover:bg-slate-50 {{ $data['is_falling_short'] ? 'bg-rose-50/40' : '' }}">
            <td class="py-3.5 px-5 text-slate-500">{{ $index + 1 }}</td>
            <td class="py-3.5 px-5 font-bold">{{ $data['student']->last_name }} {{ $data['student']->first_name }}</td>
            <td class="py-3.5 px-4 text-center">
              @if($data['latest'])
                <div class="font-bold">{{ $data['latest']['total'] }}%</div>
                <span class="px-2 py-0.5 rounded text-[10px] font-bold
                  {{ in_array($data['latest']['grade'], ['A1','B2','B3']) ? 'bg-emerald-100 text-emerald-700' : 
                     (in_array($data['latest']['grade'], ['C4','C5','C6']) ? 'bg-blue-100 text-blue-700' : 'bg-rose-100 text-rose-700') }}">
                  {{ $data['latest']['grade'] }}
                </span>
              @else — @endif
            </td>
            <td class="py-3.5 px-4 text-center font-semibold">{{ $data['average'] ?? '—' }}%</td>
            <td class="py-3.5 px-4 text-center">
              <span class="text-lg font-bold {{ $data['trend_color'] }}">{{ $data['trend_icon'] }}</span>
            </td>
            <td class="py-3.5 px-5">
              <div class="flex flex-wrap gap-1">
                @foreach($data['history'] as $h)
                  <div class="px-2 py-1 bg-slate-100 rounded text-center min-w-[60px]">
                    <div class="text-[9px] text-slate-500">{{ $h['label'] }}</div>
                    <div class="font-bold">{{ $h['total'] }}%</div>
                  </div>
                @endforeach
              </div>
            </td>
            <td class="py-3.5 px-4 text-center">
              @if($data['is_falling_short'])
                <span class="px-2.5 py-1 bg-rose-100 text-rose-700 text-[10px] font-bold rounded-full">Needs Attention</span>
              @elseif($data['trend'] === 'improving')
                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full">Improving</span>
              @else
                <span class="px-2.5 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-full">Stable</span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Class Average Line
  new Chart(document.getElementById('classAverageChart'), {
    type: 'line',
    data: {
      labels: {!! json_encode($semesterLabels) !!},
      datasets: [{
        label: 'Class Average',
        data: {!! json_encode($classAverages) !!},
        borderColor: '#0D5C3A',
        backgroundColor: 'rgba(13,92,58,0.1)',
        borderWidth: 3,
        pointRadius: 5,
        fill: true,
        tension: 0.3
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { y: { min: 0, max: 100 } }
    }
  });

  // Grade Distribution
  new Chart(document.getElementById('gradeDistributionChart'), {
    type: 'bar',
    data: {
      labels: {!! json_encode(array_keys($gradeDistribution)) !!},
      datasets: [{
        data: {!! json_encode(array_values($gradeDistribution)) !!},
        backgroundColor: ['#059669','#10b981','#34d399','#3b82f6','#60a5fa','#93c5fd','#f59e0b','#f97316','#ef4444'],
        borderRadius: 5
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
  });

  // Student Comparison
  new Chart(document.getElementById('studentComparisonChart'), {
    type: 'bar',
    data: {
      labels: {!! json_encode(collect($latestScores)->pluck('name')) !!},
      datasets: [{
        data: {!! json_encode(collect($latestScores)->pluck('total')) !!},
        backgroundColor: {!! json_encode(collect($latestScores)->map(fn($s) => $s['total'] >= 70 ? '#059669' : ($s['total'] >= 50 ? '#3b82f6' : '#e11d48'))) !!},
        borderRadius: 4
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { min: 0, max: 100 },
        x: { ticks: { maxRotation: 60, minRotation: 45, font: { size: 9 } } }
      }
    }
  });
});
</script>