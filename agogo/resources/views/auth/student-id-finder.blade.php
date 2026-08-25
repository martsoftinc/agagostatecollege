@extends('layout')

@section('title', 'Find your Student ID — Agogo State College')

@section('content')
<section class="bg-forest py-16 sm:py-20 w-full">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
    <p class="text-sm font-semibold text-lime flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-lime"></span> Student portal
    </p>
    <h1 class="mt-4 font-extrabold text-3xl sm:text-5xl tracking-tightish text-white leading-tight">
      Find your student ID
    </h1>
    <p class="mt-4 text-white/70 max-w-xl mx-auto text-sm sm:text-base leading-relaxed">
      Enter your name and programme. We will search registered students and show matching IDs.
    </p>
  </div>
</section>

<section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-10 py-12 sm:py-16">
  <form method="GET" action="{{ url('/student-id-finder') }}" class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-10 shadow-sm space-y-5">
    <div>
      <label for="name" class="block text-sm font-semibold text-ink mb-1.5">Full name <span class="text-red-500">*</span></label>
      <input
        type="text"
        name="name"
        id="name"
        value="{{ old('name', $name ?? request('name')) }}"
        required
        placeholder="e.g. Ama Mensah"
        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink placeholder:text-muted/60 focus:border-forest focus:ring-1 focus:ring-forest outline-none transition"
      >
      @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
      <label for="programme" class="block text-sm font-semibold text-ink mb-1.5">Programme <span class="text-red-500">*</span></label>
      <select
        name="programme"
        id="programme"
        required
        class="w-full rounded-xl border border-gray-200 px-4 py-2.5 text-sm text-ink focus:border-forest focus:ring-1 focus:ring-forest outline-none transition bg-white"
      >
        <option value="" disabled {{ request('programme') ? '' : 'selected' }}>Select programme</option>
        @php
          $programmes = [
            'general_science' => 'General Science',
            'business' => 'Business',
            'general_arts' => 'General Arts',
            'visual_arts' => 'Visual Arts',
            'home_economics' => 'Home Economics',
            'agricultural_science' => 'Agricultural Science',
          ];
        @endphp
        @foreach ($programmes as $value => $label)
          <option value="{{ $value }}" {{ request('programme') === $value ? 'selected' : '' }}>{{ $label }}</option>
        @endforeach
      </select>
      @error('programme')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
    </div>

    <button type="submit"
      class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-lime text-forest-deep font-semibold px-7 py-3 rounded-full hover:bg-lime-soft transition-colors text-sm">
      <i data-lucide="search" class="w-4 h-4"></i>
      Search
    </button>
  </form>

  @if (isset($searched) && $searched)
    <div class="mt-8">
      @if ($students->isEmpty())
        <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-8 text-center">
          <p class="font-semibold text-ink">No matching student found</p>
          <p class="mt-2 text-sm text-muted">Check the spelling of your name and the programme, then try again. If you still cannot find your ID, contact the school.</p>
          <a href="{{ url('/contact') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-forest hover:underline">
            Contact the school <i data-lucide="arrow-right" class="w-4 h-4"></i>
          </a>
        </div>
      @else
        <div class="bg-white border border-gray-100 rounded-3xl overflow-hidden">
          <div class="px-6 py-4 border-b border-gray-100">
            <h2 class="font-bold text-ink">{{ $students->count() }} {{ Str::plural('result', $students->count()) }}</h2>
          </div>
          <ul class="divide-y divide-gray-50">
            @foreach ($students as $student)
              <li class="px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
                <div>
                  <p class="font-semibold text-ink">{{ $student->name }}</p>
                  <p class="text-xs text-muted mt-0.5">
                    {{ str_replace('_', ' ', ucwords($student->programme ?? $student->course ?? '', '_')) }}
                  </p>
                </div>
                <p class="font-semibold text-forest text-sm">
                  ID: {{ $student->student_id ?? $student->index_number ?? '—' }}
                </p>
              </li>
            @endforeach
          </ul>
        </div>
        <p class="mt-4 text-center">
          <a href="{{ url('/student-portal') }}" class="text-sm font-semibold text-forest hover:underline">
            Go to student portal →
          </a>
        </p>
      @endif
    </div>
  @endif
</section>
@endsection