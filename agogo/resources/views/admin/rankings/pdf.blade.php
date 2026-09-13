<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Ranking Report</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #1e293b; }
    .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0D5C3A; padding-bottom: 12px; }
    .header h1 { margin: 0; font-size: 16px; color: #0D5C3A; text-transform: uppercase; }
    .header p { margin: 3px 0 0; font-size: 11px; color: #64748b; }
    .meta { margin-bottom: 15px; font-size: 11px; }
    table { width: 100%; border-collapse: collapse; }
    th { background: #0D5C3A; color: white; padding: 7px 8px; text-align: left; font-size: 10px; text-transform: uppercase; }
    td { padding: 6px 8px; border-bottom: 1px solid #e2e8f0; font-size: 10px; }
    tr:nth-child(even) { background: #f8fafc; }
    .rank { font-weight: bold; text-align: center; width: 45px; }
    .total { font-weight: bold; text-align: right; color: #0D5C3A; }
    .footer { margin-top: 25px; text-align: center; font-size: 9px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 8px; }
  </style>
</head>
<body>
  <div class="header">
    <h1>Agogo State College</h1>
    <p>Student Ranking Report</p>
  </div>

  <div class="meta">
    <strong>Ranking:</strong> {{ $title }} <br>
    <strong>Semester:</strong> {{ $semester->name }}
    @if($semester->academicYear) ({{ $semester->academicYear->name }}) @endif <br>
    <strong>Total Students:</strong> {{ $rankings->count() }} <br>
    <strong>Generated:</strong> {{ now()->format('d M Y, h:i A') }}
  </div>

  <table>
    <thead>
      <tr>
        <th class="rank">Rank</th>
        <th>Student Name</th>
        <th>Index Number</th>
        <th>Stream</th>
        <th style="text-align:center">Subjects</th>
        <th style="text-align:right">Total Score</th>
      </tr>
    </thead>
    <tbody>
      @foreach($rankings as $row)
        <tr>
          <td class="rank">{{ $row['rank'] }}</td>
          <td>{{ $row['student']->full_name ?? $row['student']->name }}</td>
          <td>{{ $row['student']->index_number ?? '—' }}</td>
          <td>{{ $row['class_stream']->stream->name ?? '—' }}</td>
          <td style="text-align:center">{{ $row['subject_count'] }}</td>
          <td class="total">{{ number_format($row['total_score'], 2) }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>

  <div class="footer">
    Agogo State College • Official Ranking Report • {{ now()->format('d M Y') }}
  </div>
</body>
</html>