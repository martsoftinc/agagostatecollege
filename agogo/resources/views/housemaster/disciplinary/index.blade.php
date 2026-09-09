@extends('layouts.housemaster')
@section('title', 'Disciplinary Records')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
  <h1 class="text-2xl font-bold text-asc-green-dark">Disciplinary Records</h1>
  <a href="{{ route('housemaster.disciplinary.create') }}" class="inline-flex items-center gap-2 bg-asc-green text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-asc-green-dark">
    <i class="fa-solid fa-plus"></i> Add Record
  </a>
</div>

@if(session('success'))
  <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-xl mb-4">{{ session('success') }}</div>
@endif

<div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-slate-50 text-left">
        <tr>
          <th class="px-4 py-3 font-semibold text-slate-600">Student</th>
          <th class="px-4 py-3 font-semibold text-slate-600">Date</th>
          <th class="px-4 py-3 font-semibold text-slate-600">Category</th>
          <th class="px-4 py-3 font-semibold text-slate-600">Severity</th>
          <th class="px-4 py-3 font-semibold text-slate-600">Status</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        @forelse($records as $r)
          <tr class="hover:bg-slate-50">
            <td class="px-4 py-3 font-medium">{{ $r->student->full_name ?? $r->student->name }}</td>
            <td class="px-4 py-3">{{ $r->incident_date->format('d M Y') }}</td>
            <td class="px-4 py-3">{{ $r->category }}</td>
            <td class="px-4 py-3 capitalize">{{ $r->severity }}</td>
            <td class="px-4 py-3">{{ $r->status }}</td>
          </tr>
        @empty
          <tr><td colspan="5" class="px-4 py-10 text-center text-slate-400">No records yet</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div class="mt-4">{{ $records->links() }}</div>
@endsection