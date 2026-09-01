@extends('admin.layout')

@section('title', 'Admissions - Admin Dashboard')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    {{-- Header --}}
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-navy-900">Admissions</h1>
            <p class="mt-1 text-sm text-navy-700">Manage all admission applications</p>
        </div>
        <div class="mt-4 sm:mt-0 flex gap-3">
            <a href="{{ route('admin.admissions.export') }}"
               class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                Export CSV
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4 lg:grid-cols-7">
        <div class="rounded-lg bg-white p-4 shadow">
            <p class="text-sm font-medium text-gray-500">Total</p>
            <p class="mt-1 text-2xl font-semibold text-navy-900">{{ $stats['total'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <p class="text-sm font-medium text-gray-500">Paid</p>
            <p class="mt-1 text-2xl font-semibold text-green-600">{{ $stats['paid'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <p class="text-sm font-medium text-gray-500">Pending Payment</p>
            <p class="mt-1 text-2xl font-semibold text-yellow-600">{{ $stats['pending_payment'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <p class="text-sm font-medium text-gray-500">Failed</p>
            <p class="mt-1 text-2xl font-semibold text-red-600">{{ $stats['failed_payment'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <p class="text-sm font-medium text-gray-500">Reviewed</p>
            <p class="mt-1 text-2xl font-semibold text-blue-600">{{ $stats['reviewed'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <p class="text-sm font-medium text-gray-500">Accepted</p>
            <p class="mt-1 text-2xl font-semibold text-green-700">{{ $stats['accepted'] }}</p>
        </div>
        <div class="rounded-lg bg-white p-4 shadow">
            <p class="text-sm font-medium text-gray-500">Rejected</p>
            <p class="mt-1 text-2xl font-semibold text-red-700">{{ $stats['rejected'] }}</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="mt-6 rounded-lg bg-white p-4 shadow">
        <form method="GET" action="{{ route('admin.admissions.index') }}" class="grid grid-cols-1 gap-4 sm:grid-cols-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Name, index, guardian..."
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring-gold">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Payment Status</label>
                <select name="payment_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring-gold">
                    <option value="all" {{ request('payment_status') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Application Status</label>
                <select name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring-gold">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                    <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="w-full rounded-md bg-gold px-4 py-2 text-sm font-medium text-navy-900 hover:bg-gold/80">
                    Filter
                </button>
                <a href="{{ route('admin.admissions.index') }}"
                   class="rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="mt-6 overflow-hidden rounded-lg bg-white shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Applicant</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Reference</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Previous School</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Payment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Applied</th>
                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($admissions as $admission)
                        <tr class="hover:bg-gray-50">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $admission->full_name }}</div>
                                <div class="text-sm text-gray-500">{{ $admission->parent_guardian_phone }}</div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                {{ $admission->payment_reference }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900">
                                {{ $admission->previous_school }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if($admission->payment_status === 'paid')
                                    <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Paid</span>
                                @elseif($admission->payment_status === 'pending')
                                    <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">Pending</span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Failed</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if($admission->status === 'accepted')
                                    <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Accepted</span>
                                @elseif($admission->status === 'rejected')
                                    <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Rejected</span>
                                @elseif($admission->status === 'reviewed')
                                    <span class="inline-flex rounded-full bg-blue-100 px-2 text-xs font-semibold leading-5 text-blue-800">Reviewed</span>
                                @else
                                    <span class="inline-flex rounded-full bg-gray-100 px-2 text-xs font-semibold leading-5 text-gray-800">Pending</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                {{ $admission->created_at->format('d M Y') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                <a href="{{ route('admin.admissions.show', $admission->id) }}"
                                   class="text-gold hover:text-gold/80">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-sm text-gray-500">
                                No admissions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($admissions->hasPages())
            <div class="border-t border-gray-200 bg-white px-4 py-3">
                {{ $admissions->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection