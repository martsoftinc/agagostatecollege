@extends('layouts.housemaster')
@section('title', 'House Master Dashboard')

@section('content')
<div class="space-y-8">
  <div>
    <h1 class="text-2xl font-bold text-asc-green-dark">House Master Dashboard</h1>
    <p class="text-slate-500 text-sm mt-1">School-wide overview</p>
  </div>

  <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
      <p class="text-xs font-semibold text-slate-500 uppercase">Total Students</p>
      <p class="mt-2 text-3xl font-bold text-asc-green-dark">{{ $totalStudents }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
      <p class="text-xs font-semibold text-slate-500 uppercase">On Exeat</p>
      <p class="mt-2 text-3xl font-bold text-amber-600">{{ $onExeat }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
      <p class="text-xs font-semibold text-slate-500 uppercase">Overdue Exeat</p>
      <p class="mt-2 text-3xl font-bold text-rose-600">{{ $overdueExeat }}</p>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
      <p class="text-xs font-semibold text-slate-500 uppercase">Open Disciplinary</p>
      <p class="mt-2 text-3xl font-bold text-indigo-600">{{ $openDisciplinary }}</p>
    </div>
  </div>

  <div class="grid grid-cols-2 gap-4">
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-500 uppercase">Male</p>
        <p class="mt-1 text-2xl font-bold text-blue-700">{{ $maleCount }}</p>
      </div>
      <i class="fa-solid fa-mars text-3xl text-blue-200"></i>
    </div>
    <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm flex items-center justify-between">
      <div>
        <p class="text-xs font-semibold text-slate-500 uppercase">Female</p>
        <p class="mt-1 text-2xl font-bold text-pink-600">{{ $femaleCount }}</p>
      </div>
      <i class="fa-solid fa-venus text-3xl text-pink-200"></i>
    </div>
  </div>

  <div class="flex flex-wrap gap-3">
    <a href="{{ route('housemaster.exeat.create') }}" class="inline-flex items-center gap-2 bg-asc-green hover:bg-asc-green-dark text-white font-semibold px-5 py-2.5 rounded-xl transition">
      <i class="fa-solid fa-plus"></i> New Exeat
    </a>
    <a href="{{ route('housemaster.disciplinary.create') }}" class="inline-flex items-center gap-2 bg-asc-yellow hover:bg-asc-yellow-hover text-asc-green-dark font-semibold px-5 py-2.5 rounded-xl transition">
      <i class="fa-solid fa-gavel"></i> New Disciplinary
    </a>
  </div>

  <div class="grid lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
      <div class="px-5 py-4 border-b border-slate-100 font-bold text-asc-green-dark">Recent Exeats</div>
      <div class="divide-y divide-slate-100">
        @forelse($recentExeats as $exeat)
          <div class="px-5 py-3 text-sm">
            <p class="font-semibold">{{ $exeat->student->full_name ?? $exeat->student->name }}</p>
            <p class="text-slate-500">{{ $exeat->destination }} • {{ $exeat->status }}</p>
          </div>
        @empty
          <p class="px-5 py-4 text-slate-400 text-sm">No recent exeats</p>
        @endforelse
      </div>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden">
      <div class="px-5 py-4 border-b border-slate-100 font-bold text-asc-green-dark">Recent Disciplinary</div>
      <div class="divide-y divide-slate-100">
        @forelse($recentDisciplinary as $rec)
          <div class="px-5 py-3 text-sm">
            <p class="font-semibold">{{ $rec->student->full_name ?? $rec->student->name }}</p>
            <p class="text-slate-500">{{ $rec->category }} • {{ ucfirst($rec->severity) }}</p>
          </div>
        @empty
          <p class="px-5 py-4 text-slate-400 text-sm">No recent records</p>
        @endforelse
      </div>
    </div>
  </div>
</div>
@endsection