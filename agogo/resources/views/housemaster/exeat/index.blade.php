@extends('layouts.housemaster')
@section('title', 'Exeat Records')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
  <h1 class="text-2xl font-bold text-asc-green-dark">Exeat Records</h1>
  <a href="{{ route('housemaster.exeat.create') }}" class="inline-flex items-center gap-2 bg-asc-green text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-asc-green-dark">
    <i class="fa-solid fa-plus"></i> New Exeat
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
          <th class="px-4 py-3 font-semibold text-slate-600">Destination</th>
          <th class="px-4 py-3 font-semibold text-slate-600">Departure</th>
          <th class="px-4 py-3 font-semibold text-slate-600">Return By</th>
          <th class="px-4 py-3 font-semibold text-slate-600">Status</th>
          <th class="px-4 py-3 font-semibold text-slate-600"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-slate-100">
        @forelse($exeats as $e)
          <tr class="hover:bg-slate-50">
            <td class="px-4 py-3 font-medium">{{ $e->student->full_name ?? $e->student->name }}</td>
            <td class="px-4 py-3">{{ $e->destination }}</td>
            <td class="px-4 py-3">{{ $e->departure_at->format('d M, H:i') }}</td>
            <td class="px-4 py-3">{{ $e->expected_return_at->format('d M, H:i') }}</td>
            <td class="px-4 py-3 capitalize">{{ $e->status }}</td>
            <td class="px-4 py-3">
              @if(in_array($e->status, ['approved','out']) && is_null($e->actual_return_at))
                <form action="{{ route('housemaster.exeat.return', $e) }}" method="POST" class="inline">
                  @csrf
                  <button class="text-asc-green font-semibold text-xs hover:underline">Mark Returned</button>
                </form>
              @endif
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="px-4 py-10 text-center text-slate-400">No exeats yet</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>
<div class="mt-4">{{ $exeats->links() }}</div>
@endsection