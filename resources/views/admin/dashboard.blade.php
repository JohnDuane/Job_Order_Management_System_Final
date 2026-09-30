<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="flex min-h-screen">

            {{-- Sidebar --}}
            <x-admin-sidebar />


            {{-- Main Content --}}
            <main class="flex flex-1 min-w-0 flex-col gap-6 p-8">

                {{-- Header --}}
                <div>

                    <h1 class="text-2xl font-medium">
                        Admin dashboard
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Welcome back, {{ auth()->user()->name }}
                    </p>

                </div>


                {{-- Stats Grid --}}
                <div class="grid grid-cols-2 gap-3 sm:grid-cols-4">

                    {{-- Customers Stat --}}
                    <div class="rounded-lg bg-gray-50 p-4">

                        <p class="text-xs text-gray-500">
                            Customers
                        </p>

                        <p class="mt-1 text-2xl font-medium">
                            {{ $customerCount }}
                        </p>

                    </div>


                    {{-- Vehicles Stat --}}
                    <div class="rounded-lg bg-gray-50 p-4">

                        <p class="text-xs text-gray-500">
                            Vehicles
                        </p>

                        <p class="mt-1 text-2xl font-medium">
                            {{ $vehicleCount }}
                        </p>

                    </div>


                    {{-- Active Staff Stat --}}
                    <div class="rounded-lg bg-gray-50 p-4">

                        <p class="text-xs text-gray-500">
                            Active staff
                        </p>

                        <p class="mt-1 text-2xl font-medium">
                            {{ $staffCount }}
                        </p>

                    </div>


                    {{-- Jobs Month Stat --}}
                    <div class="rounded-lg bg-gray-50 p-4">

                        <p class="text-xs text-gray-500">
                            Jobs this month
                        </p>

                        <p class="mt-1 text-2xl font-medium">
                            {{ $jobCountMonth }}
                        </p>

                    </div>

                </div>


                {{-- Quick Actions --}}
                <div class="flex flex-wrap gap-2">

                    <a
                        href="{{ route('admin.users.addcustomer') }}"
                        class="min-w-[140px] flex-1 rounded-lg border px-4 py-2.5 text-center text-sm"
                    >
                        Add customer
                    </a>


                    <a
                        href="{{ route('admin.users.addvehicles') }}"
                        class="min-w-[140px] flex-1 rounded-lg border px-4 py-2.5 text-center text-sm"
                    >
                        Add vehicle
                    </a>


                    <a
                        href="{{ route('admin.users.create') }}"
                        class="min-w-[140px] flex-1 rounded-lg border px-4 py-2.5 text-center text-sm"
                    >
                        Add staff
                    </a>


                    <a
                        href="{{ route('admin.users.addservices') }}"
                        class="min-w-[140px] flex-1 rounded-lg border px-4 py-2.5 text-center text-sm"
                    >
                        Add service
                    </a>

                </div>


                {{-- Recent Job Orders --}}
                <div class="overflow-hidden rounded-xl border bg-white">

                    <div class="border-b p-5">

                        <p class="font-medium">
                            Recent job orders
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            {{ $jobCountWeek }} this week · {{ $jobCountMonth }} this month · {{ $jobCountYear }} this year
                        </p>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead>

                                <tr class="border-b text-left text-gray-500">

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
                                        Date
                                    </th>

                                    <th class="p-4">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($recentJobs as $job)

                                    <tr class="border-b last:border-0">

                                        <td class="p-4 font-medium">
                                            {{ $job->code }}
                                        </td>

                                        <td class="p-4">
                                            {{ $job->customer->first_name }} {{ $job->customer->last_name }}
                                        </td>

                                        <td class="p-4">
                                            {{ $job->vehicle->make }}
                                        </td>

                                        <td class="p-4">
                                            {{ $job->date_issued->format('M d, Y') }}
                                        </td>

                                        <td class="p-4">
                                            {{ str_replace('_', ' ', ucwords($job->status)) }}
                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="p-8 text-center text-gray-500"
                                        >
                                            No job orders yet.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </main>

        </div>

    </div>

</x-app-layout>