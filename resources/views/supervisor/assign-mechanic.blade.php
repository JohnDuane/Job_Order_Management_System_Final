<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <div class="flex min-h-screen"><x-supervisor-sidebar />
            <main class="flex-1 min-w-0 p-8">
                <h1 class="text-2xl font-medium">Assign mechanic</h1>
                <p class="text-sm text-gray-500 mt-1 mb-6">Assign approved job orders to one or more mechanics.</p>
                <div class="space-y-4">
                    @forelse($jobs as $job)
                        <div class="rounded-xl border p-5" x-data="{ open: false }">
                            <div class="flex flex-col lg:flex-row lg:justify-between gap-4">
                                <div><b>{{ $job->code }}</b>
                                    <p class="text-sm mt-1">{{ $job->customer->first_name }}
                                        {{ $job->customer->last_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $job->vehicle->make }} ·
                                        {{ $job->vehicle->plate_number }}</p>
                                    <p class="text-xs text-gray-400 mt-1">
                                        {{ str_replace('_', ' ', ucwords($job->status)) }}</p>
                                </div>
                                <div><button type="button" @click="open=true"
                                        class="rounded-lg bg-gray-900 text-white px-4 py-2 text-sm">{{ $job->status === 'assigned' ? 'Reassign' : 'Assign mechanic' }}</button>
                                </div>
                            </div>
                            <div class="mt-3 text-sm text-gray-600">Current:
                                {{ $job->assignments->map(fn($a) => $a->staff?->user?->name)->filter()->join(', ') ?: 'Not assigned' }}
                            </div>
                            <div x-show="open" x-cloak
                                class="fixed inset-0 z-50 bg-black/30 flex items-center justify-center p-4">
                                <form method="POST" action="{{ route('supervisor.job-orders.assign', $job) }}"
                                    class="bg-white rounded-2xl w-full max-w-lg p-6 shadow-xl">@csrf<h3
                                        class="font-semibold text-lg">Assign {{ $job->code }}</h3>
                                    <p class="text-xs text-gray-500 mt-1 mb-4">Select the mechanic(s) responsible for
                                        this job.</p>
                                    <div class="space-y-2 max-h-64 overflow-auto">
                                        @foreach ($mechanics as $m)
                                            <label class="flex items-center gap-3 border rounded-lg p-3"><input
                                                    type="checkbox" name="staff_ids[]" value="{{ $m->staff_id }}"
                                                    @checked($job->assignments->contains('staff_id', $m->staff_id))><span>{{ $m->user->name }}</span></label>
                                        @endforeach
                                    </div>
                                    <textarea name="remarks" class="mt-4 w-full rounded-lg border p-3 text-sm" placeholder="Optional assignment remarks"></textarea>
                                    <div class="mt-4 flex justify-end gap-2"><button type="button" @click="open=false"
                                            class="rounded-lg border px-4 py-2 text-sm">Cancel</button><button
                                            class="rounded-lg bg-gray-900 text-white px-4 py-2 text-sm"
                                            onclick="return confirm('Save this mechanic assignment?')">Save
                                            assignment</button></div>
                                </form>
                            </div>
                    </div>@empty<div class="rounded-xl border border-dashed p-10 text-center text-gray-500">No
                            approved job orders are waiting for assignment.</div>
                    @endforelse
                </div>
                <div class="mt-5">{{ $jobs->links() }}</div>
            </main>
        </div>
    </div>
</x-app-layout>
