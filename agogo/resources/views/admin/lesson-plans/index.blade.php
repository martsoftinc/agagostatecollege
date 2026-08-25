@extends('admin.layout')

@section('title', 'Lesson Plans - Admin')

@section('content')
<div class="space-y-6">

  <!-- Header -->
  <div>
    <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Lesson Plans</h1>
    <p class="text-xs sm:text-sm text-slate-500">View and download all teacher lesson plans across the school.</p>
  </div>

  <!-- Search & Filters -->
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-4 sm:p-5">
    <form method="GET" action="{{ route('admin.lesson-plans.index') }}" class="space-y-4">
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">

        <!-- Search -->
        <div class="lg:col-span-2">
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Search</label>
          <div class="relative">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Topic, subject, class...."
                   class="w-full pl-9 pr-3 py-2.5 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
          </div>
        </div>

        <!-- Teacher Filter -->
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Teacher</label>
          <select name="teacher_id"
                  class="w-full py-2.5 px-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
            <option value="">All Teachers</option>
            @foreach($teachers as $teacher)
              <option value="{{ $teacher->id }}" {{ request('teacher_id') == $teacher->id ? 'selected' : '' }}>
                {{ $teacher->name }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Date Filter -->
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Lesson Date</label>
          <input type="date"
                 name="date"
                 value="{{ request('date') }}"
                 class="w-full py-2.5 px-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
      </div>

      <!-- Optional date range (collapsed on mobile) -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">From Date</label>
          <input type="date" name="date_from" value="{{ request('date_from') }}"
                 class="w-full py-2.5 px-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div>
          <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">To Date</label>
          <input type="date" name="date_to" value="{{ request('date_to') }}"
                 class="w-full py-2.5 px-3 rounded-xl border border-slate-300 text-sm focus:ring-2 focus:ring-asc-green focus:outline-none">
        </div>
        <div class="flex items-end gap-2 sm:col-span-2">
          <button type="submit"
                  class="px-5 py-2.5 rounded-xl bg-asc-green hover:bg-asc-green-dark text-white font-semibold text-sm transition shadow-sm">
            <i class="fa-solid fa-filter mr-1"></i> Apply Filters
          </button>
          <a href="{{ route('admin.lesson-plans.index') }}"
             class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-600 font-semibold text-sm hover:bg-slate-50 transition">
            Clear
          </a>
        </div>
      </div>
    </form>
  </div>

  <!-- Results count -->
  <div class="flex items-center justify-between text-xs text-slate-500">
    <span>{{ $lessonPlans->total() }} lesson plan{{ $lessonPlans->total() !== 1 ? 's' : '' }} found</span>
  </div>

  <!-- Table -->
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    @if($lessonPlans->count() > 0)
      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
          <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-bold">
            <tr>
              <th class="px-5 py-3.5">Topic / Subject</th>
              <th class="px-5 py-3.5">Class</th>
              <th class="px-5 py-3.5">Date</th>
              <th class="px-5 py-3.5">Teacher</th>
              <th class="px-5 py-3.5">Visibility</th>
              <th class="px-5 py-3.5 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @foreach($lessonPlans as $plan)
              <tr class="hover:bg-slate-50/80 transition">
                <td class="px-5 py-3.5">
                  <div class="font-bold text-slate-900">{{ $plan->unit_topic }}</div>
                  <div class="text-xs text-slate-500 font-medium">{{ $plan->subject }}</div>
                  @if($plan->sub_topic)
                    <div class="text-[11px] text-slate-400 mt-0.5">{{ $plan->sub_topic }}</div>
                  @endif
                </td>
                <td class="px-5 py-3.5 font-semibold text-slate-700">
                  {{ $plan->class_form }}
                </td>
                <td class="px-5 py-3.5 text-slate-600 whitespace-nowrap">
                  {{ $plan->lesson_date?->format('M d, Y') ?? '—' }}
                </td>
                <td class="px-5 py-3.5 text-xs font-medium text-slate-600">
                  {{ $plan->author?->name ?? 'Unknown' }}
                </td>
                <td class="px-5 py-3.5">
                  @if($plan->visibility === 'public')
                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                      <i class="fa-solid fa-globe text-[10px]"></i>
                      <span>Public</span>
                    </span>
                  @else
                    <span class="inline-flex items-center space-x-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                      <i class="fa-solid fa-lock text-[10px]"></i>
                      <span>Private</span>
                    </span>
                  @endif
                </td>
                <td class="px-5 py-3.5 text-right space-x-1">
                  <a href="{{ route('admin.lesson-plans.show', $plan) }}"
                     class="inline-flex p-2 rounded-lg text-slate-500 hover:text-asc-green hover:bg-slate-100 transition"
                     title="View">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  <a href="{{ route('admin.lesson-plans.pdf', $plan) }}"
                     class="inline-flex p-2 rounded-lg text-slate-500 hover:text-rose-600 hover:bg-slate-100 transition"
                     title="Download PDF">
                    <i class="fa-solid fa-file-pdf"></i>
                  </a>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>

      <div class="p-4 border-t border-slate-100">
        {{ $lessonPlans->links() }}
      </div>
    @else
      <div class="p-12 text-center space-y-3">
        <div class="w-12 h-12 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto text-xl">
          <i class="fa-solid fa-book-open"></i>
        </div>
        <p class="text-slate-600 font-medium">No lesson plans found.</p>
        <p class="text-xs text-slate-400">Try adjusting your search or filters.</p>
      </div>
    @endif
  </div>
</div>
@endsection