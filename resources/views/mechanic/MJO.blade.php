<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <div class="flex min-h-screen"><x-mechanic-sidebar />
            <main class="flex-1 min-w-0 p-8">
                <div class="flex items-start justify-between mb-6">
                    <div>
                        <h1 class="text-2xl font-medium">My job orders</h1>
                        <p class="text-sm text-gray-500 mt-1">Track job orders assigned to you.</p>
                    </div><a href="{{ route('mechanic.CJO') }}"
                        class="rounded-lg bg-gray-900 text-white px-4 py-2.5 text-sm">Create job order</a>
                </div>
                <form class="mb-5 flex gap-2"><input name="search" value="{{ request('search') }}"
                        placeholder="Search customer, vehicle, plate..."
                        class="w-full max-w-md rounded-lg border border-gray-200 px-3 py-2.5 text-sm"><select
                        name="status" onchange="this.form.submit()"
                        class="rounded-lg border border-gray-200 px-3 py-2.5 text-sm">
                        <option value="">All statuses</option>
                        @foreach (['pending_approval' => 'Pending approval', 'approved' => 'Approved', 'assigned' => 'Assigned', 'in_progress' => 'In progress', 'completed' => 'Completed', 'needs_revision' => 'Needs revision'] as $key => $label)
                            <option value="{{ $key }}" @selected(request('status') === $key)>{{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <button class="rounded-lg border px-4 text-sm">Search</button>
                </form>
                <div class="space-y-3">
                    @forelse($jobs as $job)
                        <div class="rounded-xl border border-gray-200 p-5">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <div>
                                    <div class="flex items-center gap-2"><b>{{ $job->code }}</b><span
                                            class="rounded-md bg-gray-100 px-2 py-1 text-xs">{{ str_replace('_', ' ', ucwords($job->status)) }}</span>
                                    </div>
                                    <p class="mt-1 text-sm">{{ $job->customer->first_name }}
                                        {{ $job->customer->last_name }}</p>
                                    <p class="text-xs text-gray-500">{{ $job->vehicle->make }} ·
                                        {{ $job->vehicle->plate_number }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ $job->date_issued->format('M d, Y') }} ·
                                        ₱{{ number_format($job->total_cost, 2) }}</p>
                                </div>
                                <div class="flex gap-2">
                                    @if ($job->status === 'assigned')
                                        <form method="POST" action="{{ route('mechanic.job-orders.start', $job) }}">
                                            @csrf<button class="rounded-lg bg-gray-900 text-white px-3 py-2 text-sm"
                                                onclick="return confirm('Start this job order?')">Start</button></form>
                                    @elseif($job->status === 'in_progress')
                                        <form method="POST" action="{{ route('mechanic.job-orders.complete', $job) }}">
                                            @csrf<button class="rounded-lg bg-green-600 text-white px-3 py-2 text-sm"
                                                onclick="return confirm('Mark this job order as completed?')">Complete</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 border-t pt-3 text-sm text-gray-600"><b>Services:</b>
                                {{ $job->services->pluck('service_name')->join(', ') }}<br><b>Problem:</b>
                                {{ $job->problem_description }}</div>
                    </div>@empty<div class="rounded-xl border border-dashed p-10 text-center text-gray-500">No job
                            orders found.</div>
                    @endforelse
                </div>
                <div class="mt-5">{{ $jobs->links() }}</div>
            </main>
        </div>
    </div>
</x-app-layout>
