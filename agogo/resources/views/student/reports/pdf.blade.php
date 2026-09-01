<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Terminal Report - {{ $student->last_name }} {{ $student->first_name }}</title>
  <style>
    @page { margin: 15mm 12mm; }
    body {
      font-family: DejaVu Sans, sans-serif;
      font-size: 10.5px;
      color: #1e293b;
      line-height: 1.35;
    }
    .header-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
    .logo-box {
      width: 58px; height: 58px;
      background: #0D5C3A; color: #fff;
      text-align: center; line-height: 58px;
      font-weight: bold; font-size: 18px;
      border: 3px solid #F59E0B; border-radius: 50%;
    }
    .school-name { font-size: 15px; font-weight: bold; margin: 0; letter-spacing: 0.3px; }
    .school-details { font-size: 8.5px; color: #64748b; margin: 1px 0 0 0; }
    .student-name { font-size: 12px; font-weight: bold; margin: 0; }
    .student-meta { font-size: 8.5px; color: #64748b; margin: 1px 0; }
    .title-section { text-align: center; margin: 14px 0 10px 0; }
    .title { font-size: 13px; font-weight: bold; letter-spacing: 1.5px; text-transform: uppercase; margin: 0; }
    .stars { color: #F59E0B; font-size: 13px; letter-spacing: 3px; margin: 3px 0; }
    .semester-info { font-size: 10px; font-weight: 600; color: #475569; }

    table.results { width: 100%; border-collapse: collapse; margin-top: 8px; }
    table.results th {
      background: #1e293b; color: #fff;
      font-size: 9px; font-weight: bold;
      padding: 6px 4px; text-align: center;
    }
    table.results th:first-child { text-align: left; padding-left: 8px; }
    table.results td {
      padding: 5px 4px; border-bottom: 1px solid #e2e8f0;
      text-align: center; font-size: 9.5px;
    }
    table.results td:first-child { text-align: left; padding-left: 8px; font-weight: 600; }

    .grade-good { background: #d1fae5; color: #065f46; padding: 1px 5px; border-radius: 3px; font-weight: bold; }
    .grade-credit { background: #dbeafe; color: #1e40af; padding: 1px 5px; border-radius: 3px; font-weight: bold; }
    .grade-pass { background: #fee2e2; color: #991b1b; padding: 1px 5px; border-radius: 3px; font-weight: bold; }

    .weights-box {
      background: #f0fdf4; border: 1px solid #bbf7d0;
      padding: 7px 10px; margin: 10px 0 6px 0;
      font-size: 9px; border-radius: 4px;
    }
    .summary-table { width: 100%; margin-top: 12px; border-collapse: collapse; }
    .summary-table td {
      width: 33.33%; background: #f8fafc; border: 1px solid #e2e8f0;
      padding: 8px; text-align: center;
    }
    .summary-label { font-size: 8px; color: #64748b; margin: 0; }
    .summary-value { font-size: 15px; font-weight: bold; margin: 3px 0 0 0; }

    .comments-section { margin-top: 14px; }
    .comments-section h4 { font-size: 10px; margin: 0 0 6px 0; }
    .comment-item {
      font-size: 9px; margin-bottom: 4px;
      padding-bottom: 3px; border-bottom: 1px dashed #e2e8f0;
    }

    .interpretation { margin-top: 14px; }
    .interpretation h4 { font-size: 10px; margin: 0 0 5px 0; }
    .interpretation table { width: 100%; border-collapse: collapse; font-size: 8.5px; }
    .interpretation th { background: #f1f5f9; color: #334155; padding: 4px; text-align: left; }
    .interpretation td { padding: 3px 5px; border-bottom: 1px solid #e2e8f0; }

    .signature-area { margin-top: 25px; width: 100%; }
    .signature-box {
      display: inline-block; width: 30%; text-align: center;
      margin-right: 4%; vertical-align: top;
    }
    .signature-line {
      border-top: 1px solid #64748b; margin-top: 35px;
      padding-top: 4px; font-size: 8.5px; color: #475569;
    }
    .footer {
      margin-top: 18px; text-align: center;
      font-size: 8px; color: #94a3b8;
      border-top: 1px solid #e2e8f0; padding-top: 6px;
    }
  </style>
</head>
<body>

  <!-- HEADER -->
  <table class="header-table">
    <tr>
      <td width="62%" valign="top">
        <table>
          <tr>
            <td width="70"><div class="logo-box">ASC</div></td>
            <td>
              <p class="school-name">AGOGO STATE COLLEGE</p>
              <p class="school-details">P.O. BOX 25, AGOGO ASHANTI - AKIM</p>
              <p class="school-details">Tel: 0244973082 • agogostatec@gmail.com</p>
            </td>
          </tr>
        </table>
      </td>
      <td width="38%" valign="top" align="right">
        <p class="student-name">{{ strtoupper($student->last_name ?? '') }} {{ $student->first_name ?? '' }} {{ $student->other_names ?? '' }}</p>
        <p class="student-meta">Study Area: {{ $student->programme ?? 'N/A' }}</p>
        <p class="student-meta">Student ID: {{ $student->student_id ?? 'N/A' }}</p>
        <p class="student-meta">Class: {{ $student->classStream->full_name ?? $student->class ?? 'N/A' }}</p>
      </td>
    </tr>
  </table>

  <!-- TITLE -->
  <div class="title-section">
    <p class="title">Official Terminal Report</p>
    <div class="stars">★★★</div>
    <p class="semester-info">{{ $semester->name }} &nbsp;•&nbsp; {{ $semester->academicYear->name ?? '' }}</p>
  </div>

  <!-- ASSESSMENT WEIGHTS -->
  @if($weights)
  <div class="weights-box">
    <strong>Assessment Weights:</strong>
    Classwork / Homework: <strong>{{ $weights->classwork_percent }}%</strong> &nbsp;|&nbsp;
    Mid-Semester: <strong>{{ $weights->midsem_percent }}%</strong> &nbsp;|&nbsp;
    End-of-Semester Exam: <strong>{{ $weights->exam_percent }}%</strong>
  </div>
  @endif

  <!-- RESULTS TABLE -->
  <table class="results">
    <thead>
      <tr>
        <th style="width:26%">Subject</th>
        <th>Classwork</th>
        <th>Mid-Sem</th>
        <th>Exam</th>
        <th>Total %</th>
        <th>Grade</th>
        <th>GP</th>
        <!--th>Position</th>
        <--<th>Attendance</th>-->
      </tr>
    </thead>
    <tbody>
      @foreach($scores as $score)
        <tr>
          <td>{{ $score->subject->name ?? '—' }}</td>
          <td>{{ $score->classwork_score ?? '—' }}</td>
          <td>{{ $score->midsem_score ?? '—' }}</td>
          <td>{{ $score->exam_score ?? '—' }}</td>
          <td><strong>{{ $score->total_score ?? '—' }}</strong></td>
          <td>
            @php
              $gClass = 'grade-pass';
              if (in_array($score->grade, ['A1','B2','B3'])) $gClass = 'grade-good';
              elseif (in_array($score->grade, ['C4','C5','C6'])) $gClass = 'grade-credit';
            @endphp
            <span class="{{ $gClass }}">{{ $score->grade ?? '—' }}</span>
          </td>
          <td>{{ $score->grade_point ?? '—' }}</td>
          <!--<td>{{ $score->attendance ?? '—' }}</td>-->
          <td>{{ $subjectPositions[$score->subject_id] ?? '—' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <!-- SUMMARY -->
  <table class="summary-table">
    <tr>
      <td>
        <p class="summary-label">Semester GPA</p>
        <p class="summary-value">{{ $semesterGpa ?? '—' }}</p>
      </td>
      <td>
        <p class="summary-label">Subjects Taken</p>
        <p class="summary-value">{{ $scores->count() }}</p>
      </td>
      <td>
        <p class="summary-label">Class</p>
        <p class="summary-value" style="font-size:11px;">{{ $student->classStream->full_name ?? $student->class ?? 'N/A' }}</p>
      </td>
    </tr>
  </table>

  <!-- TEACHER COMMENTS -->
  @php
    $comments = $scores->filter(fn($s) => !empty($s->teacher_comment));
  @endphp
  @if($comments->count() > 0)
  <div class="comments-section">
    <h4>Teacher Comments</h4>
    @foreach($comments as $score)
      <div class="comment-item">
        <strong>{{ $score->subject->name }}:</strong> {{ $score->teacher_comment }}
      </div>
    @endforeach
  </div>
  @endif

  <!-- GRADE INTERPRETATION -->
  <div class="interpretation">
    <h4>GRADE INTERPRETATION</h4>
    <table>
      <thead>
        <tr>
          <th>Grade</th>
          <th>Points</th>
          <th>Score Range</th>
          <th>Interpretation</th>
        </tr>
      </thead>
      <tbody>
        <tr><td>A1</td><td>4.0</td><td>80 – 100</td><td>Excellent</td></tr>
        <tr><td>B2</td><td>3.5</td><td>70 – 79</td><td>Very Good</td></tr>
        <tr><td>B3</td><td>3.0</td><td>60 – 69</td><td>Good</td></tr>
        <tr><td>C4</td><td>2.5</td><td>55 – 59</td><td>Credit</td></tr>
        <tr><td>C5</td><td>2.0</td><td>50 – 54</td><td>Credit</td></tr>
        <tr><td>C6</td><td>1.5</td><td>45 – 49</td><td>Credit</td></tr>
        <tr><td>D7</td><td>1.0</td><td>40 – 44</td><td>Pass</td></tr>
        <tr><td>E8</td><td>0.5</td><td>35 – 39</td><td>Pass</td></tr>
        <tr><td>F9</td><td>0.0</td><td>0 – 34</td><td>Fail</td></tr>
      </tbody>
    </table>
  </div>

  <!-- SIGNATURE AREA -->
  <div class="signature-area">
    <div class="signature-box">
      <div class="signature-line">Class Teacher’s Signature</div>
    </div>
    <div class="signature-box">
      <div class="signature-line">Form Master / Mistress</div>
    </div>
    <div class="signature-box" style="margin-right:0;">
      <div class="signature-line">Headmaster / Assistant Head</div>
    </div>
  </div>

  <div class="footer">
    This is a computer-generated terminal report from Agogo State College Student Portal.<br>
    Generated on {{ now()->format('d M Y • h:i A') }}
  </div>

</body>
</html>