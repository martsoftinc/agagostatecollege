@extends('teacher.layout')
@section('title', 'Lesson Plans - Agogo State College')

@section('content')
<div class="space-y-6">
  <!-- Header & Actions -->
  <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-extrabold text-slate-900 tracking-tight">Lesson Plans</h1>
      <p class="text-xs sm:text-sm text-slate-500">Manage, organize, and share your SHS teaching curriculum.</p>
    </div>
    <a href="{{ route('lesson-plans.create') }}" class="inline-flex items-center justify-center space-x-2 bg-asc-green hover:bg-asc-green-dark text-white px-4 py-2.5 rounded-xl font-semibold text-sm transition shadow-sm">
      <i class="fa-solid fa-plus text-asc-yellow"></i>
      <span>Create New Lesson Plan</span>
    </a>
  </div>

  @if(session('success'))
    <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-center space-x-2">
      <i class="fa-solid fa-circle-check text-emerald-600"></i>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  <!-- Lesson Plans Table / Grid -->
  <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
    @if($lessonPlans->count() > 0)
      <div class="overflow-x-auto">
        <table class="w-full text-left text-sm text-slate-600">
          <thead class="bg-slate-50 border-b border-slate-200 text-xs uppercase tracking-wider text-slate-500 font-bold">
            <tr>
              <th class="px-6 py-4">Topic / Subject</th>
              <th class="px-6 py-4">Class</th>
              <th class="px-6 py-4">Date</th>
              <th class="px-6 py-4">Visibility</th>
              <th class="px-6 py-4">Author</th>
              <th class="px-6 py-4 text-right">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-slate-100">
            @foreach($lessonPlans as $plan)
              <tr class="hover:bg-slate-50/80 transition">
                <td class="px-6 py-4">
                  <div class="font-bold text-slate-900">{{ $plan->unit_topic }}</div>
                  <div class="text-xs text-slate-500 font-medium">{{ $plan->subject }}</div>
                </td>
                <td class="px-6 py-4 font-semibold text-slate-700">
                  {{ $plan->class_form }}
                </td>
                <td class="px-6 py-4 text-slate-600">
                  {{ $plan->lesson_date->format('M d, Y') }}
                </td>
                <td class="px-6 py-4">
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
                <td class="px-6 py-4 text-xs font-medium text-slate-600">
                  {{ $plan->user_id === auth()->id() ? 'You' : $plan->author->name }}
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                  <a href="{{ route('lesson-plans.show', $plan) }}" class="p-2 rounded-lg text-slate-500 hover:text-asc-green hover:bg-slate-100 transition" title="View">
                    <i class="fa-solid fa-eye"></i>
                  </a>
                  @can('update', $plan)
                    <a href="{{ route('lesson-plans.edit', $plan) }}" class="p-2 rounded-lg text-slate-500 hover:text-asc-yellow-hover hover:bg-slate-100 transition" title="Edit">
                      <i class="fa-solid fa-pen"></i>
                    </a>
                  @endcan
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
        <a href="{{ route('lesson-plans.create') }}" class="inline-block text-sm text-asc-green hover:underline font-bold">Create your first lesson plan</a>
      </div>
    @endif
  </div>
</div>
@endsection