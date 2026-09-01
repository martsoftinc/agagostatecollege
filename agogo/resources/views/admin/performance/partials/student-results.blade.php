<!-- STUDENT INFO -->
<div class="bg-gradient-to-r from-asc-green to-asc-green-dark text-white rounded-2xl p-5 mb-6">
  <h3 class="text-lg font-bold">
    {{ $selectedStudent->last_name }} {{ $selectedStudent->first_name }} {{ $selectedStudent->other_names }}
  </h3>
  <p class="text-sm text-emerald-100 mt-0.5">
    ID: {{ $selectedStudent->student_id ?? 'N/A' }}
    @if($selectedStudent->classStream)
      • {{ $selectedStudent->classStream->schoolClass->name ?? '' }} {{ $selectedStudent->classStream->stream->name ?? '' }}
    @endif
  </p>
</div>

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
  </div>
  <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
    <p class="text-[11px] font-bold text-slate-500 uppercase">Needs Attention</p>
    <p class="text-3xl font-extrabold text-rose-600 mt-2">{{ $fallingShortCount }}</p>
  </div>
</div>

<!-- OVERVIEW CHARTS -->
<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
    <h3 class="font-bold text-slate-900 mb-1">All Subjects Over Time</h3>
    <p class="text-xs text-slate-500 mb-4">Performance trend across every subject</p>
    <div class="chart-container">
      <canvas id="overviewLineChart"></canvas>
    </div>
  </div>
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
    <h3 class="font-bold text-slate-900 mb-1">Average Performance by Subject</h3>
    <p class="text-xs text-slate-500 mb-4">Comparison of strength across subjects</p>
    <div class="chart-container">
      <canvas id="averageBarChart"></canvas>
    </div>
  </div>
</div>

<!-- SUBJECT CARDS -->
<h3 class="font-bold text-slate-900 text-lg mb-4">Subject Details</h3>
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
  @foreach($subjectsData as $index => $data)
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden
      {{ $data['is_falling_short'] ? 'ring-2 ring-rose-200' : '' }}">
      <div class="p-5 border-b border-slate-100 flex items-start justify-between gap-3">
        <div>
          <h3 class="font-bold text-slate-900">{{ $data['subject']->name }}</h3>
          <div class="flex flex-wrap gap-3 mt-1 text-xs text-slate-500">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
  const colours = ['#0D5C3A','#F59E0B','#3B82F6','#EF4444','#8B5CF6','#EC4899','#14B8A6','#F97316','#6366F1','#84CC16'];

  @php
    $allLabels = collect($subjectsData)->flatMap(fn($d) => collect($d['history'])->pluck('label'))->unique()->values();
  @endphp

  // Overview Line Chart
  new Chart(document.getElementById('overviewLineChart'), {
    type: 'line',
    data: {
      labels: {!! json_encode($allLabels) !!},
      datasets: [
        @foreach($subjectsData as $index => $data)
        {
          label: {!! json_encode($data['subject']->name) !!},
          data: {!! json_encode($allLabels) !!}.map(label => {
            const found = {!! json_encode($data['history']) !!}.find(h => h.label === label);
            return found ? found.total : null;
          }),
          borderColor: colours[{{ $index % 10 }}],
          borderWidth: 2.5,
          pointRadius: 4,
          tension: 0.3,
          spanGaps: true
        },
        @endforeach
      ]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } },
      scales: {
        y: { min: 0, max: 100, ticks: { stepSize: 20 } },
        x: { ticks: { maxRotation: 45, minRotation: 30, font: { size: 10 } } }
      }
    }
  });

  // Average Bar Chart
  const barData = {!! json_encode(collect($subjectsData)->pluck('average')) !!};
  new Chart(document.getElementById('averageBarChart'), {
    type: 'bar',
    data: {
      labels: {!! json_encode(collect($subjectsData)->pluck('subject.name')) !!},
      datasets: [{
        data: barData,
        backgroundColor: barData.map(v => v >= 70 ? '#059669' : (v >= 50 ? '#3B82F6' : '#E11D48')),
        borderRadius: 6
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        y: { min: 0, max: 100, ticks: { stepSize: 20 } },
        x: { ticks: { maxRotation: 45, minRotation: 30, font: { size: 10 } } }
      }
    }
  });

  // Individual Subject Charts
  @foreach($subjectsData as $index => $data)
  new Chart(document.getElementById('subjectChart{{ $index }}'), {
    type: 'line',
    data: {
      labels: {!! json_encode(collect($data['history'])->pluck('label')) !!},
      datasets: [{
        data: {!! json_encode(collect($data['history'])->pluck('total')) !!},
        borderColor: '{{ $data["is_falling_short"] ? "#e11d48" : ($data["trend"] === "improving" ? "#059669" : "#0D5C3A") }}',
        backgroundColor: '{{ $data["is_falling_short"] ? "rgba(225,29,72,0.08)" : "rgba(13,92,58,0.08)" }}',
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
      scales: {
        y: { min: 0, max: 100, ticks: { stepSize: 20, font: { size: 10 } } },
        x: { ticks: { font: { size: 10 }, maxRotation: 40 } }
      }
    }
  });
  @endforeach
});
</script>