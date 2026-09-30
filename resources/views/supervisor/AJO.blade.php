<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <div class="flex min-h-screen"><x-supervisor-sidebar />
            <main class="flex-1 min-w-0 p-8">
                <div class="mb-6">
                    <h1 class="text-2xl font-medium">All job orders</h1>
                    <p class="text-sm text-gray-500 mt-1">Monitor every job order in the system.</p>
                </div>
                <form class="mb-5 flex flex-wrap gap-2"><input name="search" value="{{ request('search') }}"
                        placeholder="Search..." class="w-full max-w-md rounded-lg border px-3 py-2.5 text-sm"><select
                        name="status" class="rounded-lg border px-3 py-2.5 text-sm">
                        <option value="">All statuses</option>
                        @foreach (['pending_approval', 'needs_revision', 'approved', 'assigned', 'in_progress', 'completed'] as $s)
                            <option value="{{ $s }}" @selected(request('status') === $s)>
                                {{ str_replace('_', ' ', ucwords($s)) }}</option>
                        @endforeach
                    </select>
                    <button class="rounded-lg border px-4 text-sm">Filter</button>
                </form>
                <div class="overflow-x-auto rounded-xl border">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b bg-gray-50 text-left text-gray-500">
                                <th class="p-4">JO</th>
                                <th class="p-4">Customer</th>
                                <th class="p-4">Vehicle</th>
                                <th class="p-4">Mechanic</th>
                                <th class="p-4">Date</th>
                                <th class="p-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $job)
                                <tr class="border-b last:border-0">
                                    <td class="p-4 font-medium">{{ $job->code }}</td>
                                    <td class="p-4">{{ $job->customer->first_name }} {{ $job->customer->last_name }}
                                    </td>
                                    <td class="p-4">{{ $job->vehicle->make }}<div class="text-xs text-gray-400">
                                            {{ $job->vehicle->plate_number }}</div>
                                    </td>
                                    <td class="p-4">
                                        {{ $job->assignments->map(fn($a) => $a->staff?->user?->name)->filter()->join(', ') ?: '—' }}
                                    </td>
                                    <td class="p-4">{{ $job->date_issued->format('M d, Y') }}</td>
                                    <td class="p-4"><span
                                            class="rounded-md bg-gray-100 px-2 py-1 text-xs">{{ str_replace('_', ' ', ucwords($job->status)) }}</span>
                                    </td>
                            </tr>@empty<tr>
                                    <td colspan="6" class="p-10 text-center text-gray-500">No job orders found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">{{ $jobs->links() }}</div>
            </main>
        </div>
    </div>
</x-app-layout>
