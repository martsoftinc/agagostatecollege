@extends('teacher.layout')  

@section('title', 'Class Performance Tracker')

@push('styles')
<style>
  .chart-box { position: relative; height: 260px; width: 100%; }
  .chart-box-sm { position: relative; height: 220px; width: 100%; }
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
    <form method="GET" action="{{ route('teacher.performance.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
      
      <!-- Class Dropdown -->
      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Class</label>
        <select name="class_stream_id" id="classSelect" required
                class="w-full px-3 py-2.5 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white"
                onchange="updateSubjects()">
          <option value="">-- Choose Class --</option>
          @foreach($classStreams as $cs)
            <option value="{{ $cs->id }}" {{ $selectedClassStreamId == $cs->id ? 'selected' : '' }}
                    data-subjects='@json($cs->subjects->map(fn($s) => ["id" => $s->id, "name" => $s->name]))'>
              {{ $cs->schoolClass->name }} {{ $cs->stream->name }}
            </option>
          @endforeach
        </select>
      </div>

      <!-- Subject Dropdown -->
      <div>
        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Select Subject</label>
        <select name="subject_id" id="subjectSelect" required
                class="w-full px-3 py-2.5 text-xs border border-slate-200 rounded-xl focus:border-asc-green focus:outline-none bg-white">
          <option value="">-- Choose Subject --</option>
          @if($selectedClassStream)
            @foreach($selectedClassStream->subjects as $subject)
              <option value="{{ $subject->id }}" {{ $selectedSubjectId == $subject->id ? 'selected' : '' }}>
                {{ $subject->name }}
              </option>
            @endforeach
          @endif
        </select>
      </div>

      <div>
        <button type="submit"
                class="w-full py-2.5 bg-asc-green hover:bg-asc-green-dark text-white font-bold text-xs rounded-xl transition">
          View Performance
        </button>
      </div>
    </form>
  </div>

  @if(!$selectedClassStream || !$selectedSubject)
    <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
      <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mx-auto mb-4">
        <i class="fa-solid fa-chart-column text-2xl text-slate-400"></i>
      </div>
      <h3 class="font-bold text-slate-700">Select a Class and Subject</h3>
      <p class="text-sm text-slate-500 mt-1">Choose a class and subject above to view detailed performance analysis.</p>
    </div>
  @else

    <!-- CLASS INFO -->
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
      <div>
        <h3 class="text-lg font-bold text-slate-900">
          {{ $selectedClassStream->schoolClass->name }} {{ $selectedClassStream->stream->name }}
        </h3>
        <p class="text-sm text-slate-500">{{ $selectedSubject->name }}</p>
      </div>
    </div>

    <!-- OVERVIEW CARDS -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
      <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-[11px] font-bold text-slate-500 uppercase">Class Average</p>
        <p class="text-3xl font-extrabold text-slate-900 mt-2">{{ $summary['average'] ?? '—' }}%</p>
        <p class="text-xs text-slate-500 mt-1">Latest semester</p>
      </div>
      <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-[11px] font-bold text-slate-500 uppercase">Highest Score</p>
        <p class="text-3xl font-extrabold text-emerald-600 mt-2">{{ $summary['highest'] ?? '—' }}%</p>
      </div>
      <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-[11px] font-bold text-slate-500 uppercase">Lowest Score</p>
        <p class="text-3xl font-extrabold text-rose-600 mt-2">{{ $summary['lowest'] ?? '—' }}%</p>
      </div>
      <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
        <p class="text-[11px] font-bold text-slate-500 uppercase">Needs Attention</p>
        <p class="text-3xl font-extrabold text-rose-600 mt-2">{{ $summary['needsAttention'] ?? 0 }}</p>
        <p class="text-xs text-slate-500 mt-1">out of {{ $summary['totalStudents'] ?? 0 }} students</p>
      </div>
    </div>

    <!-- CHARTS -->
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
      <!-- Class Average Trend -->
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h3 class="font-bold text-slate-900 mb-1">Class Average Over Time</h3>
        <p class="text-xs text-slate-500 mb-4">How the whole class is performing across semesters</p>
        <div class="chart-box">
          <canvas id="classAverageChart"></canvas>
        </div>
      </div>

      <!-- Grade Distribution -->
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h3 class="font-bold text-slate-900 mb-1">Grade Distribution (Latest)</h3>
        <p class="text-xs text-slate-500 mb-4">Number of students in each grade</p>
        <div class="chart-box">
          <canvas id="gradeDistributionChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Student Comparison Bar Chart -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-8">
      <h3 class="font-bold text-slate-900 mb-1">Student Comparison (Latest Semester)</h3>
      <p class="text-xs text-slate-500 mb-4">Current total scores of all students in this subject</p>
      <div class="chart-box">
        <canvas id="studentComparisonChart"></canvas>
      </div>
    </div>

    <!-- STUDENT PERFORMANCE TABLE -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
      <div class="p-5 border-b border-slate-100 bg-slate-50/50">
        <h3 class="font-bold text-slate-900">Student Performance Details</h3>
        <p class="text-xs text-slate-500 mt-0.5">{{ count($studentsData) }} students</p>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse min-w-[900px]">
          <thead>
            <tr class="bg-slate-100/80 border-b border-slate-200 text-[11px] uppercase font-bold text-slate-500 tracking-wider">
              <th class="py-3 px-5">#</th>
              <th class="py-3 px-5">Student</th>
              <th class="py-3 px-4 text-center">Latest Score</th>
              <th class="py-3 px-4 text-center">Average</th>
              <th class="py-3 px-4 text-center">Trend</th>
              <th class="py-3 px-5">History</th>
              <th class="py-3 px-4 text-center">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100 text-xs">
            @foreach($studentsData as $index => $data)
              <tr class="hover:bg-slate-50/80 {{ $data['is_falling_short'] ? 'bg-rose-50/40' : '' }}">
                <td class="py-3.5 px-5 text-slate-500">{{ $index + 1 }}</td>
                <td class="py-3.5 px-5 font-bold text-slate-900">
                  {{ $data['student']->last_name }} {{ $data['student']->first_name }}
                </td>
                <td class="py-3.5 px-4 text-center">
                  @if($data['latest'])
                    <div class="font-bold">{{ $data['latest']['total'] }}%</div>
                    <span class="px-2 py-0.5 rounded text-[10px] font-bold
                      {{ in_array($data['latest']['grade'], ['A1','B2','B3']) ? 'bg-emerald-100 text-emerald-700' : 
                         (in_array($data['latest']['grade'], ['C4','C5','C6']) ? 'bg-blue-100 text-blue-700' : 'bg-rose-100 text-rose-700') }}">
                      {{ $data['latest']['grade'] }}
                    </span>
                  @else
                    —
                  @endif
                </td>
                <td class="py-3.5 px-4 text-center font-semibold">
                  {{ $data['average'] ?? '—' }}%
                </td>
                <td class="py-3.5 px-4 text-center">
                  <span class="text-lg font-bold {{ $data['trend_color'] }}">{{ $data['trend_icon'] }}</span>
                  <div class="text-[10px] {{ $data['trend_color'] }} capitalize">{{ $data['trend'] }}</div>
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

  @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // Dynamic subject dropdown
  function updateSubjects() {
    const classSelect = document.getElementById('classSelect');
    const subjectSelect = document.getElementById('subjectSelect');
    const selectedOption = classSelect.options[classSelect.selectedIndex];
    
    subjectSelect.innerHTML = '<option value="">-- Choose Subject --</option>';
    
    if (selectedOption && selectedOption.dataset.subjects) {
      const subjects = JSON.parse(selectedOption.dataset.subjects);
      subjects.forEach(sub => {
        const opt = document.createElement('option');
        opt.value = sub.id;
        opt.textContent = sub.name;
        subjectSelect.appendChild(opt);
      });
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    @if($selectedClassStream && $selectedSubject)

    // 1. Class Average Trend (Line)
    new Chart(document.getElementById('classAverageChart'), {
      type: 'line',
      data: {
        labels: {!! json_encode($semesterLabels) !!},
        datasets: [{
          label: 'Class Average %',
          data: {!! json_encode($classAverages) !!},
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

    // 2. Grade Distribution (Bar)
    new Chart(document.getElementById('gradeDistributionChart'), {
      type: 'bar',
      data: {
        labels: {!! json_encode(array_keys($gradeDistribution)) !!},
        datasets: [{
          label: 'Number of Students',
          data: {!! json_encode(array_values($gradeDistribution)) !!},
          backgroundColor: [
            '#059669', '#10b981', '#34d399',
            '#3b82f6', '#60a5fa', '#93c5fd',
            '#f59e0b', '#f97316', '#ef4444'
          ],
          borderRadius: 5
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, ticks: { stepSize: 1 } }
        }
      }
    });

    // 3. Student Comparison (Bar)
    new Chart(document.getElementById('studentComparisonChart'), {
      type: 'bar',
      data: {
        labels: {!! json_encode(collect($latestScores)->pluck('name')) !!},
        datasets: [{
          label: 'Total %',
          data: {!! json_encode(collect($latestScores)->pluck('total')) !!},
          backgroundColor: {!! json_encode(collect($latestScores)->map(function($s) {
            if ($s['total'] >= 70) return '#059669';
            if ($s['total'] >= 50) return '#3b82f6';
            return '#e11d48';
          })) !!},
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

    @endif
  });
</script>
@endpush