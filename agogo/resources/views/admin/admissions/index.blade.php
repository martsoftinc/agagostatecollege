@extends('layouts.admin')

@section('title', 'Admission Details - Admin Dashboard')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-semibold text-navy-900">Admission Details</h1>
            <p class="mt-2 text-sm text-navy-700">Reference: {{ $admission->payment_reference }}</p>
        </div>
        <div class="mt-4 sm:mt-0">
            <a href="{{ route('admin.admissions.index') }}" class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">
                Back to List
            </a>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-8 lg:grid-cols-3">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Personal Information -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Personal Information</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->full_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->date_of_birth->format('F d, Y') }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Address</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->address }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Place of Residence</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->place_of_residence }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Parent/Guardian Information -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Parent/Guardian Information</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->parent_guardian_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Telephone</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->parent_guardian_phone }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500">Occupation</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->parent_guardian_occupation }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Previous School Information -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Previous School Information</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">School Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->previous_school }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Index Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->index_number }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Position Held</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->position_held ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Additional Information</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Interests/Hobbies</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->interests_hobbies ?? 'None specified' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Medical Conditions</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $admission->medical_conditions ?? 'None specified' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Status Update -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Application Status</h3>
                </div>
                <div class="px-6 py-4">
                    <form action="{{ route('admin.admissions.update', $admission->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Update Status</label>
                            <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gold focus:ring-gold">
                                <option value="pending" {{ $admission->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="reviewed" {{ $admission->status == 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                                <option value="accepted" {{ $admission->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="rejected" {{ $admission->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                        </div>
                        <button type="submit" class="mt-4 w-full rounded-md bg-gold px-4 py-2 text-sm font-medium text-navy-900 hover:bg-gold/80">
                            Update Status
                        </button>
                    </form>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Payment Information</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="space-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Amount</dt>
                            <dd class="text-sm text-gray-900">GH₵ {{ number_format($admission->amount_paid, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Reference</dt>
                            <dd class="text-sm text-gray-900">{{ $admission->payment_reference }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd>
                                @if($admission->payment_status == 'paid')
                                    <span class="inline-flex rounded-full bg-green-100 px-2 text-xs font-semibold leading-5 text-green-800">Paid</span>
                                @elseif($admission->payment_status == 'pending')
                                    <span class="inline-flex rounded-full bg-yellow-100 px-2 text-xs font-semibold leading-5 text-yellow-800">Pending</span>
                                @else
                                    <span class="inline-flex rounded-full bg-red-100 px-2 text-xs font-semibold leading-5 text-red-800">Failed</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Applied On</dt>
                            <dd class="text-sm text-gray-900">{{ $admission->created_at->format('F d, Y H:i A') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Actions -->
            <div class="overflow-hidden rounded-lg bg-white shadow">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h3 class="text-lg font-medium text-gray-900">Actions</h3>
                </div>
                <div class="px-6 py-4 space-y-2">
                    <form action="{{ route('admin.admissions.destroy', $admission->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to delete this admission record?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700">
                            Delete Record
                        </button>
                    </form>
                    <button onclick="window.print()" class="w-full rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Print Details
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection