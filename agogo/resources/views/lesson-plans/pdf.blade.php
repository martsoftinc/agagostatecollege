<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>{{ $lessonPlan->unit_topic }} – Lesson Plan</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 11px;
      color: #1e293b;
      line-height: 1.55;
      padding: 24px 28px;
    }
    h1 { font-size: 18px; margin-bottom: 2px; color: #0f172a; }
    h2 {
      font-size: 12px;
      margin-top: 16px;
      margin-bottom: 6px;
      padding-bottom: 3px;
      border-bottom: 1.5px solid #0f766e;
      color: #0f766e;
      text-transform: uppercase;
      letter-spacing: 0.4px;
    }
    h3 { font-size: 11px; margin-top: 10px; margin-bottom: 4px; color: #334155; }
    .meta { font-size: 10px; color: #64748b; margin-bottom: 4px; }
    .badge {
      display: inline-block;
      padding: 2px 7px;
      border-radius: 4px;
      font-size: 9px;
      font-weight: bold;
      background: #fef3c7;
      color: #92400e;
      text-transform: uppercase;
    }
    .grid-4 {
      width: 100%;
      margin: 10px 0 4px;
      border-collapse: collapse;
    }
    .grid-4 td {
      width: 25%;
      padding: 4px 6px 4px 0;
      vertical-align: top;
    }
    .grid-4 .label {
      font-size: 9px;
      font-weight: bold;
      text-transform: uppercase;
      color: #94a3b8;
      display: block;
    }
    .grid-4 .value {
      font-size: 11px;
      font-weight: bold;
      color: #1e293b;
    }
    table.phase {
      width: 100%;
      border-collapse: collapse;
      margin-top: 4px;
      margin-bottom: 8px;
    }
    table.phase th,
    table.phase td {
      border: 1px solid #e2e8f0;
      padding: 6px 8px;
      text-align: left;
      vertical-align: top;
      font-size: 10px;
    }
    table.phase th {
      background: #f1f5f9;
      font-weight: bold;
      color: #475569;
      width: 33.33%;
    }
    ul { margin: 4px 0 6px 16px; padding: 0; }
    li { margin-bottom: 2px; }
    .tag {
      display: inline-block;
      padding: 2px 6px;
      margin: 1px 2px 1px 0;
      border-radius: 10px;
      font-size: 9px;
      background: #f1f5f9;
      color: #334155;
    }
    .tag-vocab {
      background: #fef3c7;
      color: #92400e;
    }
    .section { margin-bottom: 2px; }
    p { margin-bottom: 4px; }
    .footer {
      margin-top: 24px;
      padding-top: 8px;
      border-top: 1px solid #e2e8f0;
      font-size: 9px;
      color: #94a3b8;
      text-align: center;
    }
  </style>
</head>
<body>

  {{-- ══════ HEADER ══════ --}}
  <div style="margin-bottom: 12px;">
    <span class="badge">{{ $lessonPlan->subject }}</span>
    <span class="meta" style="margin-left: 6px;">
      {{ $lessonPlan->class_form }}
      @if($lessonPlan->school_name) • {{ $lessonPlan->school_name }} @endif
    </span>
  </div>

  <h1>{{ $lessonPlan->unit_topic }}</h1>
  @if($lessonPlan->sub_topic)
    <p class="meta" style="font-size: 11px; color: #475569; margin-bottom: 2px;">{{ $lessonPlan->sub_topic }}</p>
  @endif
  <p class="meta">
    Prepared by {{ $lessonPlan->author?->name ?? 'Unknown' }}
    on {{ $lessonPlan->lesson_date ? $lessonPlan->lesson_date->format('d M Y') : $lessonPlan->created_at->format('d M Y') }}
  </p>

  {{-- ══════ META INFO ══════ --}}
  <table class="grid-4">
    <tr>
      <td>
        <span class="label">Duration</span>
        <span class="value">{{ $lessonPlan->duration_minutes ?? 'N/A' }} mins</span>
      </td>
      <td>
        <span class="label">Class Size</span>
        <span class="value">{{ $lessonPlan->class_size ?? 'N/A' }}</span>
      </td>
      <td>
        <span class="label">Time</span>
        <span class="value">
          {{ $lessonPlan->start_time ? \Carbon\Carbon::parse($lessonPlan->start_time)->format('H:i') : '—' }}
          –
          {{ $lessonPlan->end_time ? \Carbon\Carbon::parse($lessonPlan->end_time)->format('H:i') : '—' }}
        </span>
      </td>
      <td>
        <span class="label">Visibility</span>
        <span class="value" style="text-transform: uppercase;">{{ $lessonPlan->visibility }}</span>
      </td>
    </tr>
  </table>

  {{-- ══════ CURRICULUM & OBJECTIVES ══════ --}}
  <h2>Curriculum &amp; Instructional Objectives</h2>

  @if($lessonPlan->content_standard)
    <div class="section">
      <h3>Content Standard</h3>
      <p>{{ $lessonPlan->content_standard }}</p>
    </div>
  @endif

  @if($lessonPlan->indicator_code_or_text)
    <div class="section">
      <h3>Indicator Code / Text</h3>
      <p>{{ $lessonPlan->indicator_code_or_text }}</p>
    </div>
  @endif

  @if($lessonPlan->performance_indicators)
    <div class="section">
      <h3>Performance Indicators (Objectives)</h3>
      <ul>
        @foreach((array) $lessonPlan->performance_indicators as $indicator)
          <li>{{ $indicator }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  @if($lessonPlan->core_competencies)
    <div class="section">
      <h3>Core Competencies</h3>
      <p>
        @foreach((array) $lessonPlan->core_competencies as $comp)
          <span class="tag">{{ $comp }}</span>
        @endforeach
      </p>
    </div>
  @endif

  @if($lessonPlan->key_vocabulary)
    <div class="section">
      <h3>Key Vocabulary</h3>
      <p>
        @foreach((array) $lessonPlan->key_vocabulary as $word)
          <span class="tag tag-vocab">{{ $word }}</span>
        @endforeach
      </p>
    </div>
  @endif

  @if($lessonPlan->teaching_learning_resources)
    <div class="section">
      <h3>Teaching &amp; Learning Resources (TLMs)</h3>
      <p>{{ $lessonPlan->teaching_learning_resources }}</p>
    </div>
  @endif

  {{-- ══════ PHASED INSTRUCTIONAL DELIVERY ══════ --}}
  <h2>Phased Instructional Delivery</h2>

  {{-- Phase 1 --}}
  @php $p1 = $lessonPlan->phase_1_introduction; @endphp
  @if($p1)
    <h3>Phase 1: Introduction ({{ $p1['duration'] ?? '—' }} mins)</h3>
    <table class="phase">
      <thead>
        <tr>
          <th>Teacher Activity</th>
          <th>Student Activity</th>
          <th>Assessment</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $p1['teacher_activity'] ?? '—' }}</td>
          <td>{{ $p1['student_activity'] ?? '—' }}</td>
          <td>{{ $p1['assessment'] ?? '—' }}</td>
        </tr>
      </tbody>
    </table>
  @endif

  {{-- Phase 2 --}}
  @php $p2 = $lessonPlan->phase_2_main_body; @endphp
  @if($p2 && is_array($p2) && count($p2) > 0)
    <h3>Phase 2: Main Body</h3>
    @foreach($p2 as $step)
      <p style="font-size: 10px; font-weight: bold; color: #64748b; margin: 8px 0 2px;">
        Step {{ $step['step'] ?? '' }}
      </p>
      <table class="phase">
        <thead>
          <tr>
            <th>Teacher Activity</th>
            <th>Student Activity</th>
            <th>Assessment</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>{{ $step['teacher_activity'] ?? '—' }}</td>
            <td>{{ $step['student_activity'] ?? '—' }}</td>
            <td>{{ $step['assessment'] ?? '—' }}</td>
          </tr>
        </tbody>
      </table>
    @endforeach
  @endif

  {{-- Phase 3 --}}
  @php $p3 = $lessonPlan->phase_3_closure; @endphp
  @if($p3)
    <h3>Phase 3: Closure / Plenary ({{ $p3['duration'] ?? '—' }} mins)</h3>
    <table class="phase">
      <thead>
        <tr>
          <th>Teacher Activity</th>
          <th>Student Activity</th>
          <th>Assessment</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{ $p3['teacher_activity'] ?? '—' }}</td>
          <td>{{ $p3['student_activity'] ?? '—' }}</td>
          <td>{{ $p3['assessment'] ?? '—' }}</td>
        </tr>
      </tbody>
    </table>
  @endif

  {{-- ══════ ASSESSMENT & REFLECTION ══════ --}}
  @if($lessonPlan->evaluative_exercise || $lessonPlan->reflection_strengths || $lessonPlan->reflection_weaknesses || $lessonPlan->reflection_remedial_action)
    <h2>Assessment &amp; Post-Lesson Reflection</h2>

    @if($lessonPlan->evaluative_exercise)
      <div class="section">
        <h3>Evaluative Exercise / Homework</h3>
        <p>{{ $lessonPlan->evaluative_exercise }}</p>
      </div>
    @endif

    <table class="grid-4" style="margin-top: 8px;">
      <tr>
        @if($lessonPlan->reflection_strengths)
          <td style="width: 33%;">
            <span class="label">Strengths</span>
            <span class="value" style="font-weight: normal; font-size: 10px;">{{ $lessonPlan->reflection_strengths }}</span>
          </td>
        @endif
        @if($lessonPlan->reflection_weaknesses)
          <td style="width: 33%;">
            <span class="label">Weaknesses / Challenges</span>
            <span class="value" style="font-weight: normal; font-size: 10px;">{{ $lessonPlan->reflection_weaknesses }}</span>
          </td>
        @endif
        @if($lessonPlan->reflection_remedial_action)
          <td style="width: 33%;">
            <span class="label">Remedial Action</span>
            <span class="value" style="font-weight: normal; font-size: 10px;">{{ $lessonPlan->reflection_remedial_action }}</span>
          </td>
        @endif
      </tr>
    </table>
  @endif

  {{-- ══════ EXTERNAL RESOURCES ══════ --}}
  @if($lessonPlan->resources->count() > 0)
    <h2>External Resources</h2>
    <ul>
      @foreach($lessonPlan->resources as $resource)
        <li>
          <strong>{{ $resource->title }}</strong>
          @if($resource->type)
            <span class="tag">{{ ucfirst(str_replace('_', ' ', $resource->type)) }}</span>
          @endif
          <br>
          <span style="font-size: 9px; color: #64748b;">{{ $resource->url }}</span>
          @if($resource->description)
            <br><span style="font-size: 9px; color: #94a3b8;">{{ $resource->description }}</span>
          @endif
        </li>
      @endforeach
    </ul>
  @endif

  {{-- ══════ ATTACHMENTS ══════ --}}
  @if($lessonPlan->attachments->count() > 0)
    <h2>File Attachments</h2>
    <ul>
      @foreach($lessonPlan->attachments as $file)
        <li>
          {{ $file->original_name }}
          <span style="font-size: 9px; color: #94a3b8;">
            ({{ strtoupper($file->extension) }} • {{ number_format($file->file_size / 1024, 1) }} KB)
          </span>
        </li>
      @endforeach
    </ul>
  @endif

  {{-- ══════ FOOTER ══════ --}}
  <div class="footer">
    Generated from Agogo State College Lesson Plan System • {{ now()->format('d M Y, H:i') }}
  </div>

</body>
</html>