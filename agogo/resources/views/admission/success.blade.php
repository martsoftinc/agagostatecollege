@extends('layout')

@section('title', 'Application Successful — Agogo State College')

@section('content')
<section class="bg-forest py-16 sm:py-24 w-full">
  <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-10 text-center">
    <div class="mx-auto mb-6 flex h-16 w-16 sm:h-20 sm:w-20 items-center justify-center rounded-full bg-lime text-forest-deep">
      <i data-lucide="check" class="w-8 h-8 sm:w-10 sm:h-10"></i>
    </div>
    <p class="text-sm font-semibold text-lime flex items-center justify-center gap-2">
      <span class="w-6 h-px bg-lime"></span> Admission
    </p>
    <h1 class="mt-4 font-extrabold text-3xl sm:text-5xl tracking-tightish text-white leading-tight">
      Application successful
    </h1>
    <p class="mt-4 text-white/70 text-sm sm:text-base leading-relaxed max-w-xl mx-auto">
      Your application has been submitted successfully. We will review it and contact you shortly.
    </p>
  </div>
</section>

<section class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-10 -mt-8 sm:-mt-10 pb-14 sm:pb-20 relative z-10">
  <div class="bg-white border border-gray-100 rounded-3xl p-6 sm:p-8 shadow-xl">
    <h2 class="font-bold text-lg text-ink">Application details</h2>
    <dl class="mt-5 space-y-4 text-sm">
      <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 border-b border-gray-50 pb-3">
        <dt class="text-muted">Application reference</dt>
        <dd class="font-semibold text-forest break-all">{{ $admission->payment_reference }}</dd>
      </div>
      <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 border-b border-gray-50 pb-3">
        <dt class="text-muted">Applicant</dt>
        <dd class="font-semibold text-ink">{{ $admission->full_name }}</dd>
      </div>
      <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1 border-b border-gray-50 pb-3">
        <dt class="text-muted">Programme</dt>
        <dd class="font-semibold text-ink">{{ str_replace('_', ' ', ucwords($admission->programme ?? '', '_')) }}</dd>
      </div>
      <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-1">
        <dt class="text-muted">Status</dt>
        <dd>
          <span class="inline-flex items-center gap-1.5 rounded-full bg-lime/30 text-forest text-xs font-semibold px-3 py-1">
            <span class="w-1.5 h-1.5 rounded-full bg-forest"></span>
            Payment confirmed — under review
          </span>
        </dd>
      </div>
    </dl>

    <div class="mt-8 flex flex-col sm:flex-row gap-3">
      <a href="{{ url('/') }}"
        class="inline-flex items-center justify-center gap-2 bg-lime text-forest-deep font-semibold px-6 py-3 rounded-full hover:bg-lime-soft transition-colors text-sm">
        Return to home <i data-lucide="arrow-right" class="w-4 h-4"></i>
      </a>
      <!--<button type="button" onclick="window.print()"
        class="inline-flex items-center justify-center gap-2 bg-forest text-white font-semibold px-6 py-3 rounded-full hover:bg-forest-deep transition-colors text-sm">
        <i data-lucide="printer" class="w-4 h-4"></i> Print confirmation
      </button>-->
    </div>

    <p class="mt-6 text-xs text-muted leading-relaxed">
      Keep your reference number safe. For enquiries, call
      <a href="tel:+233244000000" class="text-forest font-medium hover:underline">+233 24 400 0000</a>
      or email
      <a href="mailto:info@agogostatecollege.edu.gh" class="text-forest font-medium hover:underline">info@agogostatecollege.edu.gh</a>.
    </p>
  </div>
</section>
@endsection

