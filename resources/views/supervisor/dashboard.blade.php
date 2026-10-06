<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="min-h-screen lg:flex">

            <x-supervisor-sidebar />

            <main class="min-w-0 flex-1 flex-col gap-6 p-4 sm:p-6 lg:p-8">

                {{-- Header --}}
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">

                    <div>
                        <h1 class="text-2xl font-medium">
                            Supervisor dashboard
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            Welcome back, {{ auth()->user()->name }}
                        </p>
                    </div>

                    <a
                        href="{{ route('supervisor.pending-approvals') }}"
                        class="inline-flex items-center justify-center gap-2
                               rounded-lg bg-gray-900 px-4 py-2.5
                               text-sm font-medium text-white
                               hover:bg-gray-800 transition"
                    >
                        <i class="ti ti-clipboard-check"></i>
                        Review approvals
                    </a>

                </div>


                {{-- Statistics --}}
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 mb-6">

                    {{-- This Week --}}
                    <div class="bg-gray-50 rounded-lg p-4">

                        <div class="flex items-center justify-between">

                            <p class="text-xs text-gray-500">
                                Jobs this week
                            </p>

                            <i class="ti ti-calendar-week text-gray-400"></i>

                        </div>

                        <p class="text-2xl font-medium mt-2">
                            {{ $jobCountWeek }}
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            Current week
                        </p>

                    </div>


                    {{-- This Month --}}
                    <div class="bg-gray-50 rounded-lg p-4">

                        <div class="flex items-center justify-between">

                            <p class="text-xs text-gray-500">
                                Jobs this month
                            </p>

                            <i class="ti ti-calendar-month text-gray-400"></i>

                        </div>

                        <p class="text-2xl font-medium mt-2">
                            {{ $jobCountMonth }}
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            Current month
                        </p>

                    </div>


                    {{-- This Year --}}
                    <div class="bg-gray-50 rounded-lg p-4">

                        <div class="flex items-center justify-between">

                            <p class="text-xs text-gray-500">
                                Jobs this year
                            </p>

                            <i class="ti ti-calendar-stats text-gray-400"></i>

                        </div>

                        <p class="text-2xl font-medium mt-2">
                            {{ $jobCountYear }}
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            Current year
                        </p>

                    </div>


                    {{-- Pending --}}
                    <div class="bg-gray-50 rounded-lg p-4">

                        <div class="flex items-center justify-between">

                            <p class="text-xs text-gray-500">
                                Pending approvals
                            </p>

                            <i class="ti ti-clock text-gray-400"></i>

                        </div>

                        <p class="text-2xl font-medium mt-2">
                            {{ \App\Models\JobOrder::where('status', 'pending_approval')->count() }}
                        </p>

                        <p class="text-xs text-gray-400 mt-1">
                            Requires review
                        </p>

                    </div>

                </div>


                {{-- Charts --}}
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 mb-6">


                    {{-- Job Order Activity --}}
                    <div class="xl:col-span-2 bg-white border border-gray-200 rounded-xl p-5">

                        <div class="flex items-start justify-between mb-5">

                            <div>
                                <p class="font-medium">
                                    Job order activity
                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Job orders created over the past months
                                </p>
                            </div>

                            <i class="ti ti-chart-line text-gray-400"></i>

                        </div>

                        <div class="h-64">

                            <canvas id="jobActivityChart"></canvas>

                        </div>

                    </div>


                    {{-- Job Status --}}
                    <div class="bg-white border border-gray-200 rounded-xl p-5">

                        <div class="flex items-start justify-between mb-5">

                            <div>
                                <p class="font-medium">
                                    Job status
                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Current job order distribution
                                </p>
                            </div>

                            <i class="ti ti-chart-donut text-gray-400"></i>

                        </div>

                        <div class="h-64 flex items-center justify-center">

                            <canvas id="statusChart"></canvas>

                        </div>

                    </div>

                </div>


                {{-- Bottom Section --}}
                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">


                    {{-- Pending Approvals --}}
                    <div class="xl:col-span-2 bg-white border border-gray-200 rounded-xl overflow-hidden">

                        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">

                            <div>

                                <p class="font-medium">
                                    Pending approvals
                                </p>

                                <p class="text-xs text-gray-500 mt-1">
                                    Job orders waiting for your review
                                </p>

                            </div>

                            <a
                                href="{{ route('supervisor.pending-approvals') }}"
                                class="text-xs text-gray-500 hover:text-gray-900"
                            >
                                View all
                            </a>

                        </div>


                        <div class="p-4 flex flex-col gap-2">

                            @php
                                $pendingJobs = \App\Models\JobOrder::where(
                                    'status',
                                    'pending_approval'
                                )
                                ->take(4)
                                ->get();
                            @endphp


                            @forelse($pendingJobs as $job)

                                <div
                                    class="flex flex-col sm:flex-row sm:items-center
                                           justify-between gap-3
                                           border border-gray-200 rounded-lg
                                           px-4 py-3
                                           hover:bg-gray-50 transition"
                                >

                                    <div class="min-w-0">

                                        <div class="flex items-center gap-2">

                                            <p class="text-sm font-medium">
                                                JO-{{ $job->id }}
                                            </p>

                                            <span
                                                class="bg-amber-50 text-amber-700
                                                       text-xs px-2 py-1 rounded-md"
                                            >
                                                Pending
                                            </span>

                                        </div>

                                        <p class="text-sm mt-1">
                                            {{ $job->customer->name ?? 'Customer' }}
                                        </p>

                                        <p class="text-xs text-gray-500 mt-0.5">
                                            {{ $job->vehicle->make ?? '' }}
                                            {{ $job->vehicle->model ?? '' }}
                                        </p>

                                    </div>


                                    <a
                                        href="{{ route('supervisor.pending-approvals') }}"
                                        class="inline-flex items-center justify-center gap-1.5
                                               rounded-lg border border-gray-200
                                               px-3 py-2 text-xs text-gray-600
                                               hover:bg-white hover:text-gray-900
                                               transition"
                                    >
                                        Review
                                        <i class="ti ti-chevron-right"></i>
                                    </a>

                                </div>

                            @empty

                                <div class="py-10 text-center">

                                    <div
                                        class="mx-auto h-10 w-10 rounded-full
                                               bg-gray-50 flex items-center justify-center"
                                    >
                                        <i class="ti ti-check text-gray-400"></i>
                                    </div>

                                    <p class="text-sm font-medium mt-3">
                                        No pending approvals
                                    </p>

                                    <p class="text-xs text-gray-500 mt-1">
                                        All job orders have been reviewed.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>


                    {{-- Quick Summary --}}
                    <div class="bg-white border border-gray-200 rounded-xl p-5">

                        <div class="mb-5">

                            <p class="font-medium">
                                Quick summary
                            </p>

                            <p class="text-xs text-gray-500 mt-1">
                                Current job order overview
                            </p>

                        </div>


                        <div class="flex flex-col gap-4">


                            {{-- Pending --}}
                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="h-9 w-9 rounded-lg bg-amber-50
                                               flex items-center justify-center"
                                    >
                                        <i class="ti ti-clock text-amber-600"></i>
                                    </div>

                                    <div>

                                        <p class="text-sm font-medium">
                                            Pending
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            Awaiting approval
                                        </p>

                                    </div>

                                </div>

                                <p class="font-medium">
                                    {{ \App\Models\JobOrder::where('status', 'pending_approval')->count() }}
                                </p>

                            </div>


                            {{-- Approved --}}
                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="h-9 w-9 rounded-lg bg-green-50
                                               flex items-center justify-center"
                                    >
                                        <i class="ti ti-circle-check text-green-600"></i>
                                    </div>

                                    <div>

                                        <p class="text-sm font-medium">
                                            Approved
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            Ready for assignment
                                        </p>

                                    </div>

                                </div>

                                <p class="font-medium">
                                    {{ \App\Models\JobOrder::where('status', 'approved')->count() }}
                                </p>

                            </div>


                            {{-- In Progress --}}
                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="h-9 w-9 rounded-lg bg-blue-50
                                               flex items-center justify-center"
                                    >
                                        <i class="ti ti-tool text-blue-600"></i>
                                    </div>

                                    <div>

                                        <p class="text-sm font-medium">
                                            In progress
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            Currently being worked on
                                        </p>

                                    </div>

                                </div>

                                <p class="font-medium">
                                    {{ \App\Models\JobOrder::where('status', 'in_progress')->count() }}
                                </p>

                            </div>


                            {{-- Completed --}}
                            <div class="flex items-center justify-between">

                                <div class="flex items-center gap-3">

                                    <div
                                        class="h-9 w-9 rounded-lg bg-gray-50
                                               flex items-center justify-center"
                                    >
                                        <i class="ti ti-circle-check text-gray-500"></i>
                                    </div>

                                    <div>

                                        <p class="text-sm font-medium">
                                            Completed
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            Finished job orders
                                        </p>

                                    </div>

                                </div>

                                <p class="font-medium">
                                    {{ \App\Models\JobOrder::where('status', 'completed')->count() }}
                                </p>

                            </div>


                        </div>


                        <div class="border-t border-gray-100 mt-5 pt-5">

                            <a
                                href="{{ route('supervisor.pending-approvals') }}"
                                class="w-full inline-flex items-center justify-center gap-2
                                       rounded-lg bg-gray-900 text-white
                                       px-4 py-2.5 text-sm
                                       hover:bg-gray-800 transition"
                            >
                                <i class="ti ti-clipboard-check"></i>
                                Review pending approvals
                            </a>

                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>


    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>

        document.addEventListener('DOMContentLoaded', function () {

            const activityCtx = document.getElementById('jobActivityChart');

            new Chart(activityCtx, {

                type: 'line',

                data: {

                    labels: @json($jobActivityLabels),

                    datasets: [{

                        label: 'Job Orders',

                        data: @json($jobActivityData),

                        borderWidth: 2,

                        tension: 0.35,

                        pointRadius: 4,

                        pointHoverRadius: 6,

                        fill: false

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    plugins: {

                        legend: {
                            display: false
                        },

                        tooltip: {

                            callbacks: {

                                label: function(context) {
                                    return ' ' + context.parsed.y + ' job orders';
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


            /*
             * Job Status Chart
             */

            const statusCtx =
                document.getElementById('statusChart');

            new Chart(statusCtx, {

                type: 'doughnut',

                data: {

                    labels: [
                        'Pending',
                        'Approved',
                        'In progress',
                        'Completed'
                    ],

                    datasets: [{

                        data: [

                            {{ \App\Models\JobOrder::where('status', 'pending_approval')->count() }},

                            {{ \App\Models\JobOrder::where('status', 'approved')->count() }},

                            {{ \App\Models\JobOrder::where('status', 'in_progress')->count() }},

                            {{ \App\Models\JobOrder::where('status', 'completed')->count() }}

                        ],

                        borderWidth: 0

                    }]

                },

                options: {

                    responsive: true,

                    maintainAspectRatio: false,

                    cutout: '70%',

                    plugins: {

                        legend: {

                            position: 'bottom',

                            labels: {

                                usePointStyle: true,

                                padding: 15,

                                font: {
                                    size: 11
                                }

                            }

                        }

                    }

                }

            });

        });

    </script>

</x-app-layout>