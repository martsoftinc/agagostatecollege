@extends('admin.layout') 

@section('title', 'Notice Board')

@section('content')
<div x-data="noticeBoard()" class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Notice Board</h1>
            <p class="text-sm text-slate-500 mt-1">Create and manage announcements for students & teachers</p>
        </div>
        <button @click="openCreate()"
                class="inline-flex items-center gap-2 px-4 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition shadow-sm">
            <i class="fa-solid fa-plus"></i>
            New Notice
        </button>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div class="rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Title</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Audience</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">SMS</th>
                        <th class="px-4 py-3 text-left font-semibold text-slate-600">Created</th>
                        <th class="px-4 py-3 text-right font-semibold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($notices as $notice)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-800">{{ $notice->title }}</div>
                                <div class="text-xs text-slate-500 mt-0.5 line-clamp-1">{{ \Illuminate\Support\Str::limit(strip_tags($notice->body), 80) }}</div>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap gap-1">
                                    @foreach($notice->target_roles ?? [] as $role)
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-asc-green/10 text-asc-green">{{ ucfirst($role) }}</span>
                                    @endforeach
                                    @foreach($notice->target_classes ?? [] as $class)
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700">{{ $class }}</span>
                                    @endforeach
                                    @foreach($notice->target_programmes ?? [] as $prog)
                                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-sky-50 text-sky-700">{{ $prog }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($notice->send_sms)
                                    <span class="inline-flex items-center gap-1 text-emerald-600 text-xs font-medium">
                                        <i class="fa-solid fa-check"></i> Yes
                                    </span>
                                @else
                                    <span class="text-slate-400 text-xs">No</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-500 text-xs">
                                {{ $notice->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4 py-3 text-right space-x-2">
                                <button @click="openEdit(@js($notice))"
                                        class="text-asc-green hover:text-asc-green-dark text-sm font-medium">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <form action="{{ route('admin.notices.destroy', $notice) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this notice?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 text-sm font-medium">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-12 text-center text-slate-400">
                                No notices yet. Create your first announcement.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($notices->hasPages())
            <div class="px-4 py-3 border-t border-slate-100">
                {{ $notices->links() }}
            </div>
        @endif
    </div>

    {{-- ===================== CREATE / EDIT MODAL ===================== --}}
    <div x-show="modalOpen" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4"
         style="display: none;">
        <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="closeModal()"></div>

        <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto"
             @click.stop>
            <div class="sticky top-0 bg-white border-b border-slate-100 px-6 py-4 flex items-center justify-between rounded-t-2xl z-10">
                <h2 class="text-lg font-bold text-slate-800" x-text="editing ? 'Edit Notice' : 'Create Notice'"></h2>
                <button @click="closeModal()" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <form :action="editing ? `{{ url('admin/notices') }}/${form.id}` : `{{ route('admin.notices.store') }}`"
                  method="POST" class="p-6 space-y-5">
                @csrf
                <template x-if="editing">
                    <input type="hidden" name="_method" value="PUT">
                </template>

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Title</label>
                    <input type="text" name="title" x-model="form.title" required
                           class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green text-sm"
                           placeholder="e.g. Mid-term Examination Schedule">
                </div>

                {{-- Body --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-1.5">Message</label>
                    <textarea name="body" x-model="form.body" rows="5" required
                              class="w-full rounded-xl border-slate-300 focus:border-asc-green focus:ring-asc-green text-sm"
                              placeholder="Write the full notice here..."></textarea>
                </div>

                {{-- Target Roles --}}
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Who should see this?</label>
                    <div class="flex flex-wrap gap-4">
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="target_roles[]" value="student"
                                   x-model="form.target_roles"
                                   class="rounded border-slate-300 text-asc-green focus:ring-asc-green">
                            <span class="text-sm">Students</span>
                        </label>
                        <label class="inline-flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="target_roles[]" value="teacher"
                                   x-model="form.target_roles"
                                   class="rounded border-slate-300 text-asc-green focus:ring-asc-green">
                            <span class="text-sm">Teachers</span>
                        </label>
                    </div>
                </div>

                {{-- Student Class (only when student selected) --}}
                <div x-show="form.target_roles.includes('student')" x-cloak>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Student Class (optional)</label>
                    <div class="flex flex-wrap gap-3">
                        <template x-for="cls in ['SH1','SH2','SH3']" :key="cls">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="target_classes[]" :value="cls"
                                       x-model="form.target_classes"
                                       class="rounded border-slate-300 text-asc-green focus:ring-asc-green">
                                <span class="text-sm" x-text="cls"></span>
                            </label>
                        </template>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Leave empty to target all classes</p>
                </div>

                {{-- Programme (only when student selected) --}}
                <div x-show="form.target_roles.includes('student')" x-cloak>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Programme (optional)</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <template x-for="prog in programmes" :key="prog">
                            <label class="inline-flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="target_programmes[]" :value="prog"
                                       x-model="form.target_programmes"
                                       class="rounded border-slate-300 text-asc-green focus:ring-asc-green">
                                <span class="text-sm" x-text="prog"></span>
                            </label>
                        </template>
                    </div>
                    <p class="text-xs text-slate-400 mt-1">Leave empty to target all programmes</p>
                </div>

                {{-- Send SMS --}}
                <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-200">
                    <input type="checkbox" name="send_sms" value="1" id="send_sms"
                           x-model="form.send_sms"
                           class="rounded border-slate-300 text-asc-green focus:ring-asc-green">
                    <label for="send_sms" class="text-sm font-medium text-slate-700 cursor-pointer">
                        Also send SMS via Mnotify to affected users
                    </label>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" @click="closeModal()"
                            class="px-4 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-100 rounded-xl transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 bg-asc-green text-white text-sm font-semibold rounded-xl hover:bg-asc-green-dark transition">
                        <span x-text="editing ? 'Update Notice' : 'Publish Notice'"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function noticeBoard() {
    return {
        modalOpen: false,
        editing: false,
        programmes: [
            'General Science',
            'Business',
            'General Arts',
            'Visual Arts',
            'Home Economics',
            'Agricultural Science'
        ],
        form: {
            id: null,
            title: '',
            body: '',
            target_roles: [],
            target_classes: [],
            target_programmes: [],
            send_sms: false,
        },

        openCreate() {
            this.editing = false;
            this.form = {
                id: null,
                title: '',
                body: '',
                target_roles: [],
                target_classes: [],
                target_programmes: [],
                send_sms: false,
            };
            this.modalOpen = true;
        },

        openEdit(notice) {
            this.editing = true;
            this.form = {
                id: notice.id,
                title: notice.title,
                body: notice.body,
                target_roles: notice.target_roles || [],
                target_classes: notice.target_classes || [],
                target_programmes: notice.target_programmes || [],
                send_sms: !!notice.send_sms,
            };
            this.modalOpen = true;
        },

        closeModal() {
            this.modalOpen = false;
        }
    }
}
</script>
@endpush
@endsection