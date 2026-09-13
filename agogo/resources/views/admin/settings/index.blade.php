@extends('admin.layout')

@section('title', 'System Settings - Admin')

@section('content')
<div>
  <!-- HEADER -->
  <div class="mb-6">
    <h2 class="text-2xl font-extrabold text-slate-900">System Settings</h2>
    <p class="text-sm text-slate-500 mt-1">Manage payment and system configurations</p>
  </div>

  @if(session('success'))
    <div class="mb-5 p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-semibold rounded-xl flex items-center gap-2">
      <i class="fa-solid fa-circle-check"></i>
      {{ session('success') }}
    </div>
  @endif

  @if($errors->any())
    <div class="mb-5 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-sm font-semibold rounded-xl">
      <ul class="list-disc list-inside space-y-1">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- LEFT: Settings Form -->
    <div class="lg:col-span-2">
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-100 bg-slate-50">
          <h3 class="font-bold text-slate-800 flex items-center gap-2">
            <i class="fa-solid fa-credit-card text-asc-green"></i>
            Report Payment Settings
          </h3>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" class="p-6 space-y-6">
          @csrf
          @method('PUT')

          <!-- Report Fee -->
          <div>
            <label class="block text-sm font-bold text-slate-700 mb-1.5">
              Terminal Report Fee (GH¢)
            </label>
            <div class="relative max-w-xs">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm font-medium">GH¢</span>
              <input type="number"
                     name="report_fee"
                     step="0.01"
                     min="0"
                     max="1000"
                     value="{{ old('report_fee', $reportFee) }}"
                     class="w-full pl-12 pr-4 py-2.5 border border-slate-200 rounded-xl text-sm focus:border-asc-green focus:ring-2 focus:ring-asc-green/20 outline-none transition"
                     required>
            </div>
            <p class="text-xs text-slate-500 mt-1.5">
              This is the amount students must pay to unlock and download each terminal report.
            </p>
          </div>

          <div class="pt-2">
            <button type="submit"
                    class="px-6 py-2.5 bg-asc-green hover:bg-asc-green-dark text-white text-sm font-bold rounded-xl transition shadow-sm">
              <i class="fa-solid fa-floppy-disk mr-1.5"></i>
              Save Settings
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- RIGHT: Info Card -->
    <div class="space-y-5">
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5">
        <h4 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
          <i class="fa-solid fa-circle-info text-blue-500"></i>
          Current Fee
        </h4>
        <div class="text-3xl font-extrabold text-asc-green">
          GH¢ {{ number_format((float)$reportFee, 2) }}
        </div>
        <p class="text-xs text-slate-500 mt-2">
          Students will see this amount on the “Pay to Unlock” button.
        </p>
      </div>

      <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
        <h4 class="font-bold text-amber-800 mb-2 flex items-center gap-2">
          <i class="fa-solid fa-lightbulb"></i>
          Tip
        </h4>
        <p class="text-xs text-amber-700 leading-relaxed">
          Changing the fee only affects <strong>new</strong> payments. Students who have already paid keep access to their reports.
        </p>
      </div>
    </div>

  </div>
</div>
@endsection