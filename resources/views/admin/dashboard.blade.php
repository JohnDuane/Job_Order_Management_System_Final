<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="flex min-h-screen">

            {{-- Sidebar --}}
            <x-admin-sidebar />


            {{-- Main Content --}}
            <main class="flex flex-1 min-w-0 flex-col gap-6 p-6 sm:p-8">

                {{-- Header --}}
                <div class="flex flex-col gap-1 sm:flex-row sm:items-end sm:justify-between">

                    <div>
                        <h1 class="text-2xl font-medium">
                            Admin dashboard
                        </h1>

                        <p class="mt-1 text-sm text-gray-500">
                            Welcome back, {{ auth()->user()->name }}
                        </p>
                    </div>

                    <p class="text-xs text-gray-400">
                        Overview of your shop
                    </p>

                </div>


                {{-- Main Statistics --}}
                <div class="grid grid-cols-2 gap-3 lg:grid-cols-4">

                    {{-- Customers --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5">

                        <div class="flex items-center justify-between">

                            <p class="text-sm text-gray-500">
                                Customers
                            </p>

                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50">
                                <i class="ti ti-users text-gray-500"></i>
                            </div>

                        </div>

                        <p class="mt-3 text-2xl font-medium">
                            {{ $customerCount }}
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Registered customers
                        </p>

                    </div>


                    {{-- Vehicles --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5">

                        <div class="flex items-center justify-between">

                            <p class="text-sm text-gray-500">
                                Vehicles
                            </p>

                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50">
                                <i class="ti ti-car text-gray-500"></i>
                            </div>

                        </div>

                        <p class="mt-3 text-2xl font-medium">
                            {{ $vehicleCount }}
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Registered vehicles
                        </p>

                    </div>


                    {{-- Staff --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5">

                        <div class="flex items-center justify-between">

                            <p class="text-sm text-gray-500">
                                Active staff
                            </p>

                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50">
                                <i class="ti ti-users-group text-gray-500"></i>
                            </div>

                        </div>

                        <p class="mt-3 text-2xl font-medium">
                            {{ $staffCount }}
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            Active staff accounts
                        </p>

                    </div>


                    {{-- Jobs --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5">

                        <div class="flex items-center justify-between">

                            <p class="text-sm text-gray-500">
                                Jobs this month
                            </p>

                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-50">
                                <i class="ti ti-clipboard-list text-gray-500"></i>
                            </div>

                        </div>

                        <p class="mt-3 text-2xl font-medium">
                            {{ $jobCountMonth }}
                        </p>

                        <p class="mt-1 text-xs text-gray-400">
                            {{ $jobCountWeek }} created this week
                        </p>

                    </div>

                </div>


                {{-- Quick Actions --}}
                <div>

                    <div class="mb-3">

                        <p class="font-medium">
                            Quick actions
                        </p>

                        <p class="mt-1 text-xs text-gray-500">
                            Common administrative tasks
                        </p>

                    </div>


                    <div class="grid grid-cols-2 gap-2 lg:grid-cols-4">

                        <a
                            href="{{ route('admin.users.addcustomer') }}"
                            class="group flex items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3.5 transition hover:border-gray-300 hover:bg-gray-50"
                        >

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-50">
                                <i class="ti ti-user-plus text-gray-600"></i>
                            </div>

                            <div>
                                <p class="text-sm font-medium">
                                    Add customer
                                </p>

                                <p class="text-xs text-gray-400">
                                    Create a customer
                                </p>
                            </div>

                        </a>


                        <a
                            href="{{ route('admin.users.addvehicles') }}"
                            class="group flex items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3.5 transition hover:border-gray-300 hover:bg-gray-50"
                        >

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-50">
                                <i class="ti ti-car text-gray-600"></i>
                            </div>

                            <div>
                                <p class="text-sm font-medium">
                                    Add vehicle
                                </p>

                                <p class="text-xs text-gray-400">
                                    Register a vehicle
                                </p>
                            </div>

                        </a>


                        <a
                            href="{{ route('admin.users.create') }}"
                            class="group flex items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3.5 transition hover:border-gray-300 hover:bg-gray-50"
                        >

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-50">
                                <i class="ti ti-user-check text-gray-600"></i>
                            </div>

                            <div>
                                <p class="text-sm font-medium">
                                    Add staff
                                </p>

                                <p class="text-xs text-gray-400">
                                    Create staff account
                                </p>
                            </div>

                        </a>


                        <a
                            href="{{ route('admin.users.addservices') }}"
                            class="group flex items-center gap-3 rounded-xl border border-gray-200 bg-white px-4 py-3.5 transition hover:border-gray-300 hover:bg-gray-50"
                        >

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-50">
                                <i class="ti ti-tool text-gray-600"></i>
                            </div>

                            <div>
                                <p class="text-sm font-medium">
                                    Add service
                                </p>

                                <p class="text-xs text-gray-400">
                                    Create a service
                                </p>
                            </div>

                        </a>

                    </div>

                </div>


                {{-- Dashboard Analytics --}}
                <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">


                    {{-- Job Activity --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5 xl:col-span-2">

                        <div class="flex items-start justify-between">

                            <div>

                                <p class="font-medium">
                                    Job order activity
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Job orders created over the selected period
                                </p>

                            </div>

                            <div class="flex items-center gap-2">

                                <span class="h-2 w-2 rounded-full bg-gray-900"></span>

                                <span class="text-xs text-gray-500">
                                    Job orders
                                </span>

                            </div>

                        </div>


                        <div class="mt-6 h-64">

                            <canvas id="jobActivityChart"></canvas>

                        </div>

                    </div>


                    {{-- Job Status --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5">

                        <div>

                            <p class="font-medium">
                                Job order status
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Current job order distribution
                            </p>

                        </div>


                        <div class="mt-6 flex h-48 items-center justify-center">

                            <div class="relative h-40 w-40">

                                <canvas id="jobStatusChart"></canvas>

                            </div>

                        </div>


                        <div class="mt-5 space-y-3">

                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-2">

                                    <span class="h-2 w-2 rounded-full bg-amber-400"></span>

                                    <span class="text-xs text-gray-600">
                                        Pending
                                    </span>

                                </div>

                                <span class="text-xs font-medium">
                                    {{ $recentJobs->where('status', 'pending_approval')->count() }}
                                </span>

                            </div>


                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-2">

                                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>

                                    <span class="text-xs text-gray-600">
                                        In progress
                                    </span>

                                </div>

                                <span class="text-xs font-medium">
                                    {{ $recentJobs->where('status', 'in_progress')->count() }}
                                </span>

                            </div>


                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-2">

                                    <span class="h-2 w-2 rounded-full bg-green-500"></span>

                                    <span class="text-xs text-gray-600">
                                        Completed
                                    </span>

                                </div>

                                <span class="text-xs font-medium">
                                    {{ $recentJobs->where('status', 'completed')->count() }}
                                </span>

                            </div>


                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-2">

                                    <span class="h-2 w-2 rounded-full bg-red-500"></span>

                                    <span class="text-xs text-gray-600">
                                        Rejected
                                    </span>

                                </div>

                                <span class="text-xs font-medium">
                                    {{ $recentJobs->where('status', 'rejected')->count() }}
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Recent Job Orders --}}
                <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">

                    <div class="flex flex-col gap-3 border-b border-gray-100 p-5 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <p class="font-medium">
                                Recent job orders
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                {{ $jobCountWeek }} this week
                                ·
                                {{ $jobCountMonth }} this month
                                ·
                                {{ $jobCountYear }} this year
                            </p>

                        </div>


                        <a
                            href="#"
                            class="inline-flex items-center gap-1 text-xs text-gray-500 hover:text-gray-900"
                        >
                            View all
                            <i class="ti ti-arrow-right"></i>
                        </a>

                    </div>


                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead>

                                <tr class="border-b border-gray-100 text-left text-gray-500">

                                    <th class="px-5 py-3 font-normal">
                                        JO
                                    </th>

                                    <th class="px-5 py-3 font-normal">
                                        Customer
                                    </th>

                                    <th class="px-5 py-3 font-normal">
                                        Vehicle
                                    </th>

                                    <th class="px-5 py-3 font-normal">
                                        Date
                                    </th>

                                    <th class="px-5 py-3 font-normal">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse ($recentJobs as $job)

                                    <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50">

                                        <td class="px-5 py-3.5 font-medium">
                                            {{ $job->code }}
                                        </td>

                                        <td class="px-5 py-3.5">
                                            {{ $job->customer->first_name }}
                                            {{ $job->customer->last_name }}
                                        </td>

                                        <td class="px-5 py-3.5">
                                            {{ $job->vehicle->make }}
                                        </td>

                                        <td class="px-5 py-3.5 text-gray-600">
                                            {{ $job->date_issued->format('M d, Y') }}
                                        </td>

                                        <td class="px-5 py-3.5">

                                            @php

                                                $statusClasses = [

                                                    'pending_approval'
                                                        => 'bg-amber-50 text-amber-700',

                                                    'approved'
                                                        => 'bg-green-50 text-green-700',

                                                    'assigned'
                                                        => 'bg-blue-50 text-blue-700',

                                                    'in_progress'
                                                        => 'bg-blue-50 text-blue-700',

                                                    'completed'
                                                        => 'bg-green-50 text-green-700',

                                                    'rejected'
                                                        => 'bg-red-50 text-red-700',

                                                    'needs_revision'
                                                        => 'bg-orange-50 text-orange-700',

                                                ];

                                                $statusClass =
                                                    $statusClasses[$job->status]
                                                    ?? 'bg-gray-100 text-gray-600';

                                            @endphp


                                            <span
                                                class="{{ $statusClass }} inline-flex rounded-md px-2.5 py-1 text-xs"
                                            >
                                                {{ str_replace('_', ' ', ucwords($job->status)) }}
                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="p-8 text-center text-sm text-gray-500"
                                        >
                                            No job orders yet.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>


                {{-- System Summary --}}
                <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">

                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                        <div class="flex items-center gap-2">

                            <i class="ti ti-users text-gray-500"></i>

                            <p class="text-sm font-medium">
                                Customer records
                            </p>

                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            {{ $customerCount }} registered customers are currently in the system.
                        </p>

                    </div>


                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                        <div class="flex items-center gap-2">

                            <i class="ti ti-car text-gray-500"></i>

                            <p class="text-sm font-medium">
                                Vehicle records
                            </p>

                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            {{ $vehicleCount }} vehicles are currently registered.
                        </p>

                    </div>


                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                        <div class="flex items-center gap-2">

                            <i class="ti ti-user-cog text-gray-500"></i>

                            <p class="text-sm font-medium">
                                Staff accounts
                            </p>

                        </div>

                        <p class="mt-2 text-xs text-gray-500">
                            {{ $staffCount }} active staff members are currently registered.
                        </p>

                    </div>

                </div>

            </main>

        </div>

    </div>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        /*
        |--------------------------------------------------------------------------
        | Job Activity Chart
        |--------------------------------------------------------------------------
        */

        const activityCanvas = document.getElementById('jobActivityChart');

        if (activityCanvas) {

            new Chart(activityCanvas, {

                type: 'line',

                data: {

                    labels: @json($jobActivityLabels),

                    datasets: [

                        {
                            label: 'Job orders',

                            data: @json($jobActivityData),

                            borderColor: '#111827',

                            backgroundColor: 'rgba(17, 24, 39, 0.05)',

                            borderWidth: 2,

                            fill: true,

                            tension: 0.35,

                            pointRadius: 3,

                            pointHoverRadius: 5
                        }

                    ]
                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },

                    plugins: {

                        legend: {
                            display: false
                        },

                        tooltip: {

                            callbacks: {

                                label: function (context) {

                                    const count = context.raw;

                                    return count === 1
                                        ? ' 1 job order'
                                        : ' ' + count + ' job orders';

                                }

                            }

                        }

                    },

                    scales: {

                        y: {

                            beginAtZero: true,

                            ticks: {
                                precision: 0
                            },

                            grid: {
                                color: '#f3f4f6'
                            }

                        },

                        x: {

                            grid: {
                                display: false
                            }

                        }

                    }

                }

            });

        }


        /*
        |--------------------------------------------------------------------------
        | Job Status Chart
        |--------------------------------------------------------------------------
        */

        const statusCanvas = document.getElementById('jobStatusChart');

        if (statusCanvas) {

            const statusData = @json($jobStatusData);

            new Chart(statusCanvas, {

                type: 'doughnut',

                data: {

                    labels: [
                        'Pending approval',
                        'Approved',
                        'Assigned',
                        'In progress',
                        'Completed',
                        'Needs revision'
                    ],

                    datasets: [

                        {

                            data: [
                                statusData.pending_approval,
                                statusData.approved,
                                statusData.assigned,
                                statusData.in_progress,
                                statusData.completed,
                                statusData.needs_revision
                            ],

                            backgroundColor: [
                                '#fbbf24',
                                '#6366f1',
                                '#8b5cf6',
                                '#3b82f6',
                                '#22c55e',
                                '#ef4444'
                            ],

                            borderWidth: 0,

                            cutout: '72%'

                        }

                    ]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {
                            display: false
                        }

                    }

                }

            });

        }

    });
    </script>

</x-app-layout>