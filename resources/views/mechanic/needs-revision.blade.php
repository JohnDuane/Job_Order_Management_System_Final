<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <div class="flex min-h-screen">
            <x-mechanic-sidebar />
            <main class="flex-1 min-w-0 p-8">
                <h1 class="text-2xl font-medium">Needs revision</h1>
                <p class="text-sm text-gray-500 mt-1 mb-6">Review supervisor feedback and resubmit your job orders.</p>
                <div class="space-y-4">
                    @forelse($jobs as $job) @php($approval = $job->approvals->sortByDesc('id')->first())
                    <div class="rounded-xl border border-red-200 p-5">
                        <div class="flex justify-between gap-4">
                            <div>
                                <b>{{ $job->code }}</b>
                                <p class="text-sm mt-1">
                                    {{ $job->customer->first_name }} {{ $job->customer->last_name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $job->vehicle->make }} · {{ $job->vehicle->plate_number }}
                                </p>
                            </div>
                            <span class="h-fit rounded-md bg-red-50 text-red-700 px-2.5 py-1 text-xs"
                                >Needs revision</span
                            >
                        </div>
                        <div class="mt-4 rounded-lg bg-red-50 p-4 text-sm text-red-700">
                            <b>Supervisor remarks:</b> {{ $approval?->remarks ?? 'Please review the job order.' }}
                        </div>
                        <div class="mt-4 flex justify-end">
                            <a
                                href="{{ route('mechanic.job-orders.edit', $job) }}"
                                class="rounded-lg bg-gray-900 text-white px-4 py-2 text-sm"
                                >Revise job order</a
                            >
                        </div>
                    </div>
                    @empty
                    <div class="rounded-xl bg-gray-50 p-10 text-center text-gray-500">
                        No job orders currently need revision.
                    </div>
                    @endforelse
                </div>
            </main>
        </div>
    </div>
</x-app-layout>
