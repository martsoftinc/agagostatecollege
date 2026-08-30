@extends('student.layout') {{-- or whatever your layout file is named --}}

@section('title', 'Contact Us - Agogo State College')

@section('content')
<div class="space-y-8">
    <a href="{{ route('student.dashboard')}}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-600 hover:text-asc-green transition">
  <i class="fa-solid fa-arrow-left"></i>
  Back
</a>

  {{-- Page Header --}}
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
      <h2 class="text-2xl sm:text-3xl font-bold text-asc-green tracking-tight">
        Contact Us
      </h2>
      <p class="mt-1 text-slate-600 text-sm sm:text-base">
        Get in touch with Agogo State College administration and support offices.
      </p>
    </div>
    <div class="flex items-center gap-2 text-sm text-slate-500">
      <i class="fa-solid fa-location-dot text-asc-yellow"></i>
      <span>Agogo, Ashanti Region</span>
    </div>
  </div>

  {{-- Main Contact Cards --}}
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    {{-- Address Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
      <div class="w-12 h-12 rounded-xl bg-asc-green/10 flex items-center justify-center mb-4">
        <i class="fa-solid fa-map-location-dot text-asc-green text-xl"></i>
      </div>
      <h3 class="font-bold text-lg text-slate-800 mb-2">Campus Address</h3>
      <p class="text-slate-600 text-sm leading-relaxed">
        Agogo State College<br>
        Agogo-Mpraeso Road<br>
        Agogo, Asante Akim North<br>
        Ashanti Region, Ghana
      </p>
      <p class="mt-3 text-xs text-slate-500 font-medium">
        Plus Code: RW3F+9MQ
      </p>
    </div>

    {{-- Phone Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
      <div class="w-12 h-12 rounded-xl bg-asc-yellow/20 flex items-center justify-center mb-4">
        <i class="fa-solid fa-phone text-asc-yellow text-xl"></i>
      </div>
      <h3 class="font-bold text-lg text-slate-800 mb-2">Phone Numbers</h3>
      <div class="space-y-2 text-sm">
        <a href="tel:+233204630371" class="flex items-center gap-2 text-slate-700 hover:text-asc-green transition">
          <i class="fa-solid fa-mobile-screen-button text-slate-400 w-4"></i>
          +233 20 463 0371
        </a>
        <a href="tel:+233249404372" class="flex items-center gap-2 text-slate-700 hover:text-asc-green transition">
          <i class="fa-solid fa-mobile-screen-button text-slate-400 w-4"></i>
          +233 24 940 4372
        </a>
      </div>
      <p class="mt-4 text-xs text-slate-500">
        Available during school hours (Mon–Fri)
      </p>
    </div>

    {{-- Email Card --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6 hover:shadow-md transition">
      <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center mb-4">
        <i class="fa-solid fa-envelope text-blue-600 text-xl"></i>
      </div>
      <h3 class="font-bold text-lg text-slate-800 mb-2">Email</h3>
      <div class="space-y-2 text-sm">
        <a href="mailto:info@agogostatecollege.com" class="flex items-center gap-2 text-slate-700 hover:text-asc-green transition break-all">
          <i class="fa-solid fa-at text-slate-400 w-4"></i>
          info@agogostatecollege.com
        </a>
        <a href="mailto:agogostatecollegeshs@ges.gov.gh" class="flex items-center gap-2 text-slate-700 hover:text-asc-green transition break-all">
          <i class="fa-solid fa-at text-slate-400 w-4"></i>
          agogostatecollegeshs@ges.gov.gh
        </a>
      </div>
    </div>
  </div>

  {{-- Additional Info Section --}}
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Office Hours --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
      <div class="flex items-center gap-3 mb-5">
        <div class="w-10 h-10 rounded-lg bg-asc-green flex items-center justify-center">
          <i class="fa-solid fa-clock text-white"></i>
        </div>
        <h3 class="font-bold text-lg text-slate-800">Office Hours</h3>
      </div>
      <div class="space-y-3 text-sm">
        <div class="flex justify-between items-center py-2 border-b border-slate-100">
          <span class="text-slate-600">Monday – Friday</span>
          <span class="font-semibold text-slate-800">8:00 AM – 4:00 PM</span>
        </div>
        <div class="flex justify-between items-center py-2 border-b border-slate-100">
          <span class="text-slate-600">Saturday</span>
          <span class="font-semibold text-slate-800">9:00 AM – 12:00 PM</span>
        </div>
        <div class="flex justify-between items-center py-2">
          <span class="text-slate-600">Sunday & Public Holidays</span>
          <span class="font-semibold text-red-600">Closed</span>
        </div>
      </div>
    </div>

    {{-- Quick Links / Departments --}}
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
      <div class="flex items-center gap-3 mb-5">
        <div class="w-10 h-10 rounded-lg bg-asc-yellow flex items-center justify-center">
          <i class="fa-solid fa-building text-asc-green-dark"></i>
        </div>
        <h3 class="font-bold text-lg text-slate-800">Key Offices</h3>
      </div>
      <ul class="space-y-3 text-sm">
        <li class="flex items-start gap-3">
          <i class="fa-solid fa-user-tie text-asc-green mt-0.5"></i>
          <div>
            <p class="font-medium text-slate-800">Administration / Head’s Office</p>
            <p class="text-slate-500 text-xs">General enquiries & official matters</p>
          </div>
        </li>
        <li class="flex items-start gap-3">
          <i class="fa-solid fa-graduation-cap text-asc-green mt-0.5"></i>
          <div>
            <p class="font-medium text-slate-800">Academic Office</p>
            <p class="text-slate-500 text-xs">Results, transcripts & academic records</p>
          </div>
        </li>
        <li class="flex items-start gap-3">
          <i class="fa-solid fa-users text-asc-green mt-0.5"></i>
          <div>
            <p class="font-medium text-slate-800">Student Affairs / SRC</p>
            <p class="text-slate-500 text-xs">Student welfare & activities</p>
          </div>
        </li>
        <li class="flex items-start gap-3">
          <i class="fa-solid fa-heart-pulse text-asc-green mt-0.5"></i>
          <div>
            <p class="font-medium text-slate-800">Sick Bay / Health Unit</p>
            <p class="text-slate-500 text-xs">Medical support for students</p>
          </div>
        </li>
      </ul>
    </div>
  </div>

  {{-- Map / Location Note --}}
  <div class="bg-gradient-to-r from-asc-green to-asc-green-dark rounded-2xl p-6 sm:p-8 text-white">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-6">
      <div>
        <h3 class="text-xl font-bold mb-2">Visit Our Campus</h3>
        <p class="text-amber-100 text-sm max-w-xl">
          Agogo State College is located along the Agogo–Mpraeso Road in the Asante Akim North District of the Ashanti Region. We welcome parents, guardians, and visitors during official hours.
        </p>
      </div>
      <div class="flex-shrink-0">
        <a href="https://www.google.com/maps/search/?api=1&query=Agogo+State+College+Agogo" 
           target="_blank" 
           rel="noopener noreferrer"
           class="inline-flex items-center gap-2 bg-asc-yellow hover:bg-asc-yellow-hover text-asc-green-dark font-semibold px-5 py-3 rounded-xl transition shadow-lg">
          <i class="fa-solid fa-map"></i>
          Open in Maps
        </a>
      </div>
    </div>
  </div>

  {{-- Motto Banner --}}
  <div class="text-center py-4">
    <p class="text-sm text-slate-500 italic">
      “Nisi Dominus Frustra” — <span class="font-medium text-asc-green">With God All Things Are Possible</span>
    </p>
  </div>

</div>
@endsection