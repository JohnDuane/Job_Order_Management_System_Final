<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="min-h-screen lg:flex">

            {{-- Sidebar --}}
            <x-admin-sidebar />


            {{-- Main Content --}}
            <main class="min-w-0 flex-1 flex-col gap-6 p-4 sm:p-6 lg:p-8">

                {{-- Header --}}
                <div class="mb-6">

                    <h1 class="text-2xl font-medium">
                        Job orders
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        View and monitor all job orders.
                    </p>

                </div>


                {{-- Search & Filters --}}
                <form class="mb-5 flex flex-wrap gap-2">

                    <input
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search customer, vehicle, plate..."
                        class="w-full max-w-md rounded-lg border px-3 py-2.5 text-sm"
                    >


                    <select
                        name="status"
                        class="rounded-lg border px-3 py-2.5 text-sm"
                    >

                        <option value="">
                            All statuses
                        </option>

                        @foreach (['pending_approval', 'approved', 'assigned'] as $s)

                            <option
                                value="{{ $s }}"
                                @selected(request('status') === $s)
                            >
                                {{ str_replace('_', ' ', ucwords($s)) }}
                            </option>

                        @endforeach

                    </select>


                    <button class="rounded-lg border px-4 text-sm">
                        Filter
                    </button>

                </form>


                {{-- Job Orders Table --}}
                <div class="overflow-x-auto rounded-xl border">

                    <table class="w-full text-sm">

                        <thead>

                            <tr class="border-b bg-gray-50 text-left text-gray-500">

                                <th class="p-4">
                                    JO
                                </th>

                                <th class="p-4">
                                    Customer
                                </th>

                                <th class="p-4">
                                    Vehicle
                                </th>

                                <th class="p-4">
                                    Mechanic
                                </th>

                                <th class="p-4">
                                    Date
                                </th>

                                <th class="p-4">
                                    Status
                                </th>

                                <th class="p-4">
                                    Total
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($jobs as $job)

                                <tr class="border-b last:border-0">

                                    <td class="p-4 font-medium">
                                        {{ $job->code }}
                                    </td>


                                    <td class="p-4">
                                        {{ $job->customer->first_name }} {{ $job->customer->last_name }}
                                    </td>


                                    <td class="p-4">

                                        {{ $job->vehicle->make }}

                                        <div class="text-xs text-gray-400">
                                            {{ $job->vehicle->plate_number }}
                                        </div>

                                    </td>


                                    <td class="p-4">
                                        {{ $job->assignments->map(fn($a) => $a->staff?->user?->name)->filter()->join(', ') ?: '—' }}
                                    </td>


                                    <td class="p-4">
                                        {{ $job->date_issued->format('M d, Y') }}
                                    </td>


                                    <td class="p-4">

                                        @php
                                            $statusStyles = [
                                                'pending_approval' => 'bg-yellow-100 text-yellow-700 ring-1 ring-inset ring-yellow-200',
                                                'approved'         => 'bg-blue-100 text-blue-700 ring-1 ring-inset ring-blue-200',
                                                'assigned'         => 'bg-purple-100 text-purple-700 ring-1 ring-inset ring-purple-200',
                                                'in_progress'      => 'bg-orange-100 text-orange-700 ring-1 ring-inset ring-orange-200',
                                                'completed'        => 'bg-green-100 text-green-700 ring-1 ring-inset ring-green-200',
                                                'needs_revision'   => 'bg-red-100 text-red-700 ring-1 ring-inset ring-red-200',
                                                'rejected'         => 'bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-200',
                                            ];

                                            $statusIcons = [
                                                'pending_approval' => 'ti-clock',
                                                'approved'         => 'ti-check',
                                                'assigned'         => 'ti-user-check',
                                                'in_progress'      => 'ti-tool',
                                                'completed'        => 'ti-circle-check',
                                                'needs_revision'   => 'ti-alert-circle',
                                                'rejected'         => 'ti-x',
                                            ];

                                            $statusClass = $statusStyles[$job->status] ?? 'bg-gray-100 text-gray-700 ring-gray-200';
                                            $statusIcon = $statusIcons[$job->status] ?? 'ti-help-circle';
                                        @endphp

                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-xs font-medium {{ $statusClass }}"
                                        >
                                            <i class="ti {{ $statusIcon }} text-sm"></i>

                                            {{ str_replace('_', ' ', ucwords($job->status)) }}
                                        </span>

                                    </td>


                                    <td class="p-4">
                                        ₱{{ number_format($job->total_cost, 2) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="p-10 text-center text-gray-500"
                                    >
                                        No job orders found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Pagination Links --}}
                <div class="mt-5">
                    {{ $jobs->links() }}
                </div>

            </main>

        </div>

    </div>

</x-app-layout>