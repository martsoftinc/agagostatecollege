@extends('admin.layout')

@section('title', 'Class Performance Tracker')

@push('styles')
<style>
  .chart-box { position: relative; height: 260px; width: 100%; }
</style>
@endpush

@section('content')
<div>
  <!-- HEADER -->
  <div class="mb-6">
    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Class Performance Tracker</h2>
    <p class="text-sm text-slate-500 mt-1">Monitor student performance across semesters for the subjects you teach</p>
  </div>

  <!-- FILTERS -->
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
      
      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Class</label>
        <select id="classSelect"
                class="w-full px-3 py-2.5 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
          <option value="">-- Choose Class --</option>
          @foreach($classStreams as $cs)
            <option value="{{ $cs->id }}"
                    {{ $selectedClassStreamId == $cs->id ? 'selected' : '' }}
                    data-subjects='@json($cs->subjects->map(fn($s) => ["id" => $s->id, "name" => $s->name]))'>
              {{ $cs->schoolClass->name }} {{ $cs->stream->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Subject</label>
        <select id="subjectSelect"
                class="w-full px-3 py-2.5 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
          <option value="">-- Choose Subject --</option>
          @if(isset($selectedClassStream) && $selectedClassStream)
            @foreach($selectedClassStream->subjects as $subject)
              <option value="{{ $subject->id }}" {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>
                {{ $subject->name }}
              </option>
            @endforeach
          @endif
        </select>
      </div>

      <div>
        <button type="button" id="loadBtn"
                class="w-full py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition">
          View Performance
        </button>
      </div>
    </div>
  </div>

  <!-- LOADING INDICATOR -->
  <div id="loadingIndicator" class="hidden py-16 text-center">
    <div class="inline-block w-10 h-10 border-4 border-asc-green border-t-transparent rounded-full animate-spin"></div>
    <p class="text-sm text-slate-500 mt-3">Loading performance data...</p>
  </div>

  <!-- RESULTS CONTAINER (AJAX will replace this) -->
  <div id="resultsContainer">
    @include('teacher.performance.partials.results')
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  let charts = {};

  // Destroy old charts before creating new ones
  function destroyCharts() {
    Object.values(charts).forEach(chart => {
      if (chart) chart.destroy();
    });
    charts = {};
  }

  // Render all charts from window.performanceChartData
  function renderCharts() {
    destroyCharts();

    if (!window.performanceChartData) return;

    const data = window.performanceChartData;

    // 1. Class Average Line Chart
    const avgCtx = document.getElementById('classAverageChart');
    if (avgCtx) {
      charts.average = new Chart(avgCtx, {
        type: 'line',
        data: {
          labels: data.semesterLabels,
          datasets: [{
            label: 'Class Average %',
            data: data.classAverages,
            borderColor: '#0D5C3A',
            backgroundColor: 'rgba(13, 92, 58, 0.1)',
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
            y: { min: 0, max: 100, ticks: { stepSize: 20 } },
            x: { ticks: { maxRotation: 45, minRotation: 30, font: { size: 10 } } }
          }
        }
      });
    }

    // 2. Grade Distribution
    const gradeCtx = document.getElementById('gradeDistributionChart');
    if (gradeCtx) {
      charts.grade = new Chart(gradeCtx, {
        type: 'bar',
        data: {
          labels: Object.keys(data.gradeDistribution),
          datasets: [{
            label: 'Students',
            data: Object.values(data.gradeDistribution),
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
    }

    // 3. Student Comparison
    const studentCtx = document.getElementById('studentComparisonChart');
    if (studentCtx && data.latestScores.length) {
      charts.students = new Chart(studentCtx, {
        type: 'bar',
        data: {
          labels: data.latestScores.map(s => s.name),
          datasets: [{
            label: 'Total %',
            data: data.latestScores.map(s => s.total),
            backgroundColor: data.latestScores.map(s => {
              if (s.total >= 70) return '#059669';
              if (s.total >= 50) return '#3b82f6';
              return '#e11d48';
            }),
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
    }
  }

  // Update subject dropdown when class changes
  function updateSubjects() {
    const classSelect = document.getElementById('classSelect');
    const subjectSelect = document.getElementById('subjectSelect');
    const selected = classSelect.options[classSelect.selectedIndex];

    subjectSelect.innerHTML = '<option value="">-- Choose Subject --</option>';

    if (selected && selected.dataset.subjects) {
      const subjects = JSON.parse(selected.dataset.subjects);
      subjects.forEach(sub => {
        const opt = document.createElement('option');
        opt.value = sub.id;
        opt.textContent = sub.name;
        subjectSelect.appendChild(opt);
      });
    }
  }

  // Load performance data via AJAX
  function loadPerformance() {
    const classId = document.getElementById('classSelect').value;
    const subjectId = document.getElementById('subjectSelect').value;

    if (!classId || !subjectId) {
      alert('Please select both Class and Subject');
      return;
    }

    const container = document.getElementById('resultsContainer');
    const loading = document.getElementById('loadingIndicator');

    container.classList.add('hidden');
    loading.classList.remove('hidden');

    fetch(`{{ route('teacher.performance.index') }}?class_stream_id=${classId}&subject_id=${subjectId}`, {
      headers: {
        'X-Requested-With': 'XMLHttpRequest'
      }
    })
    .then(response => response.text())
    .then(html => {
      container.innerHTML = html;
      container.classList.remove('hidden');
      loading.classList.add('hidden');

      // Small delay so canvas elements exist in DOM
      setTimeout(() => {
        renderCharts();
      }, 50);
    })
    .catch(err => {
      console.error(err);
      loading.classList.add('hidden');
      container.classList.remove('hidden');
      container.innerHTML = `<div class="p-8 text-center text-rose-600">Failed to load data. Please try again.</div>`;
    });
  }

  // Event listeners
  document.getElementById('classSelect').addEventListener('change', updateSubjects);
  document.getElementById('loadBtn').addEventListener('click', loadPerformance);

  // Also allow changing subject to auto-load (optional)
  document.getElementById('subjectSelect').addEventListener('change', function() {
    if (this.value && document.getElementById('classSelect').value) {
      loadPerformance();
    }
  });

  // Initial render if data already present
  document.addEventListener('DOMContentLoaded', function() {
    if (window.performanceChartData) {
      renderCharts();
    }
  });
</script>
@endpush