<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <div class="flex min-h-screen"><x-supervisor-sidebar />
            <main class="flex-1 min-w-0 p-8">
                <div class="mb-6">
                    <h1 class="text-2xl font-medium">Pending approvals</h1>
                    <p class="text-sm text-gray-500 mt-1">Review job orders submitted by mechanics.</p>
                </div>
                <form class="mb-5 flex gap-2"><input name="search" value="{{ request('search') }}"
                        placeholder="Search job orders..."
                        class="w-full max-w-md rounded-lg border border-gray-200 px-3 py-2.5 text-sm"><button
                        class="rounded-lg border px-4 text-sm">Search</button></form>
                <div class="space-y-4">
                    @forelse($jobs as $job)
                        <div class="rounded-xl border border-gray-200 p-5">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                <div>
                                    <div class="flex gap-2 items-center"><b>{{ $job->code }}</b><span
                                            class="rounded-md bg-yellow-50 text-yellow-700 px-2 py-1 text-xs">Pending
                                            approval</span></div>
                                    <p class="text-sm mt-1">{{ $job->customer->first_name }}
                                        {{ $job->customer->last_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $job->vehicle->make }} ·
                                        {{ $job->vehicle->plate_number }}</p>
                                    <p class="text-xs text-gray-400 mt-1">Submitted
                                        {{ $job->date_issued->format('M d, Y') }} by {{ $job->creator->name }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <form method="POST" action="{{ route('supervisor.job-orders.approve', $job) }}">
                                        @csrf<input type="hidden" name="remarks" value="Approved by supervisor"><button
                                            class="rounded-lg bg-green-600 text-white px-3 py-2 text-sm"
                                            onclick="return confirm('Approve this job order?')">Approve</button></form>
                                    <form method="POST" action="{{ route('supervisor.job-orders.reject', $job) }}"
                                        x-data="{ open: false, remarks: '' }"><input type="hidden" name="remarks"
                                            x-ref="remarks"><button type="button" @click="open=true"
                                            class="rounded-lg bg-red-600 text-white px-3 py-2 text-sm">Needs
                                            revision</button>
                                        <div x-show="open" x-cloak
                                            class="fixed inset-0 z-50 bg-black/30 flex items-center justify-center p-4">
                                            <div class="bg-white rounded-xl p-5 w-full max-w-md">
                                                <h3 class="font-semibold">Return for revision</h3>
                                                <textarea x-model="remarks" x-ref="text" required rows="4" class="mt-3 w-full rounded-lg border p-3 text-sm"
                                                    placeholder="Explain what the mechanic must fix..."></textarea>
                                                <div class="mt-4 flex justify-end gap-2"><button type="button"
                                                        @click="open=false"
                                                        class="rounded-lg border px-4 py-2 text-sm">Cancel</button><button
                                                        type="submit"
                                                        @click="if(!remarks.trim()){ $event.preventDefault(); alert('Please provide a reason.'); } else { $refs.remarks.value=remarks; }"
                                                        class="rounded-lg bg-red-600 text-white px-4 py-2 text-sm">Return</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="mt-4 border-t pt-3 text-sm text-gray-600"><b>Services:</b>
                                {{ $job->services->pluck('service_name')->join(', ') }} · <b>Total:</b>
                                ₱{{ number_format($job->total_cost, 2) }}<br><b>Problem:</b>
                                {{ $job->problem_description }}</div>
                    </div>@empty<div class="rounded-xl border border-dashed p-10 text-center text-gray-500">No
                            pending job orders.</div>
                    @endforelse
                </div>
                <div class="mt-5">{{ $jobs->links() }}</div>
            </main>
        </div>
    </div>
</x-app-layout>
