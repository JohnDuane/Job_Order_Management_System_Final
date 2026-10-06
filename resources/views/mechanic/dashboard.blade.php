<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="min-h-screen lg:flex">

            {{-- Mechanic Sidebar --}}
            <x-mechanic-sidebar />


            {{-- Main Content --}}
            <main class="flex-1 min-w-0 p-6 sm:p-8">

                {{-- ================================================= --}}
                {{-- HEADER --}}
                {{-- ================================================= --}}

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">

                    <div>

                        <h1 class="text-2xl font-medium">
                            Mechanic dashboard
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            Welcome back, {{ auth()->user()->name }}
                        </p>

                    </div>


                    <a
                        href="{{ route('mechanic.CJO') }}"
                        class="inline-flex items-center justify-center gap-2
                               rounded-lg bg-gray-900 px-4 py-2.5
                               text-sm font-medium text-white
                               transition hover:bg-gray-800"
                    >

                        <i class="ti ti-plus"></i>

                        Create job order

                    </a>

                </div>



                {{-- ================================================= --}}
                {{-- STATISTICS --}}
                {{-- ================================================= --}}

                <div class="grid grid-cols-2 gap-3 lg:grid-cols-4 mb-6">


                    {{-- Assigned --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-4">

                        <div class="flex items-center justify-between">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50">

                                <i class="ti ti-clipboard-list text-blue-600"></i>

                            </div>

                            <span class="text-xs text-gray-400">
                                Current
                            </span>

                        </div>


                        <p class="mt-4 text-xs text-gray-500">
                            Assigned
                        </p>

                        <p class="mt-1 text-2xl font-medium">
                            {{ $recentJobs->where('status', 'assigned')->count() }}
                        </p>

                    </div>



                    {{-- In Progress --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-4">

                        <div class="flex items-center justify-between">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50">

                                <i class="ti ti-tool text-amber-600"></i>

                            </div>

                            <span class="text-xs text-gray-400">
                                Current
                            </span>

                        </div>


                        <p class="mt-4 text-xs text-gray-500">
                            In progress
                        </p>

                        <p class="mt-1 text-2xl font-medium">
                            {{ $recentJobs->where('status', 'in_progress')->count() }}
                        </p>

                    </div>



                    {{-- Completed --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-4">

                        <div class="flex items-center justify-between">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-50">

                                <i class="ti ti-circle-check text-green-600"></i>

                            </div>

                            <span class="text-xs text-gray-400">
                                This year
                            </span>

                        </div>


                        <p class="mt-4 text-xs text-gray-500">
                            Completed
                        </p>

                        <p class="mt-1 text-2xl font-medium">
                            {{ $jobCountYear }}
                        </p>

                    </div>



                    {{-- Needs Revision --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-4">

                        <div class="flex items-center justify-between">

                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50">

                                <i class="ti ti-alert-circle text-red-600"></i>

                            </div>

                            <span class="text-xs text-gray-400">
                                Attention
                            </span>

                        </div>


                        <p class="mt-4 text-xs text-gray-500">
                            Needs revision
                        </p>

                        <p class="mt-1 text-2xl font-medium">

                            {{
                                \App\Models\JobOrder::where('created_by', auth()->id())
                                    ->where('status', 'needs_revision')
                                    ->count()
                            }}

                        </p>

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- CHARTS --}}
                {{-- ================================================= --}}

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">


                    {{-- Job Status --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5 lg:col-span-1">

                        <div class="mb-4">

                            <p class="font-medium">
                                Job status
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Current workload
                            </p>

                        </div>


                        <div class="mx-auto h-64 max-w-[280px]">

                            <canvas id="jobStatusChart"></canvas>

                        </div>

                    </div>



                    {{-- Work Activity --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5 lg:col-span-2">

                        <div class="flex items-start justify-between gap-4 mb-4">

                            <div>

                                <p class="font-medium">
                                    Work activity
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Job Order Status Activity
                                </p>

                            </div>


                            <select
                                id="activityPeriod"
                                class="rounded-lg border border-gray-200
                                       bg-white px-3 py-1.5 text-xs
                                       text-gray-600 focus:border-gray-300
                                       focus:outline-none focus:ring-2
                                       focus:ring-gray-100"
                            >

                                <option value="months">
                                    Last 6 months
                                </option>

                                <option value="weeks">
                                    Last 6 weeks
                                </option>

                            </select>

                        </div>


                        <div class="h-64">

                            <canvas id="activityChart"></canvas>

                        </div>

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- RECENT JOB ORDERS + QUICK ACTIONS --}}
                {{-- ================================================= --}}

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">


                    {{-- Recent Jobs --}}
                    <div class="rounded-xl border border-gray-200 bg-white overflow-hidden lg:col-span-2">

                        <div class="flex items-center justify-between border-b border-gray-100 px-5 py-4">

                            <div>

                                <p class="font-medium">
                                    Recent job orders
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Your latest assigned work
                                </p>

                            </div>


                            <a
                                href="{{ route('mechanic.CJO') }}"
                                class="text-xs text-gray-500 hover:text-gray-900"
                            >
                                View all
                            </a>

                        </div>


                        <div class="divide-y divide-gray-100">

                            @forelse($recentJobs->take(5) as $job)

                                <div class="flex items-center justify-between gap-4 px-5 py-4 hover:bg-gray-50 transition">

                                    <div class="min-w-0">

                                        <div class="flex items-center gap-2">

                                            <p class="text-sm font-medium">
                                                JO-{{ $job->id }}
                                            </p>


                                            @if($job->status === 'assigned')

                                                <span class="rounded-md bg-blue-50 px-2 py-1 text-[11px] text-blue-700">
                                                    Assigned
                                                </span>

                                            @elseif($job->status === 'in_progress')

                                                <span class="rounded-md bg-amber-50 px-2 py-1 text-[11px] text-amber-700">
                                                    In progress
                                                </span>

                                            @elseif($job->status === 'completed')

                                                <span class="rounded-md bg-green-50 px-2 py-1 text-[11px] text-green-700">
                                                    Completed
                                                </span>

                                            @elseif($job->status === 'needs_revision')

                                                <span class="rounded-md bg-red-50 px-2 py-1 text-[11px] text-red-700">
                                                    Needs revision
                                                </span>

                                            @else

                                                <span class="rounded-md bg-gray-100 px-2 py-1 text-[11px] text-gray-600">
                                                    {{ ucfirst(str_replace('_', ' ', $job->status)) }}
                                                </span>

                                            @endif

                                        </div>


                                        <p class="mt-1 truncate text-sm text-gray-700">

                                            {{ $job->customer->name ?? 'Customer' }}

                                        </p>


                                        <p class="mt-0.5 truncate text-xs text-gray-500">

                                            {{ $job->vehicle->make ?? '' }}

                                            {{ $job->vehicle->model ?? '' }}

                                            @if(isset($job->service))
                                                · {{ $job->service->name }}
                                            @endif

                                        </p>

                                    </div>


                                    <div class="shrink-0 text-right">

                                        <p class="text-xs text-gray-400">

                                            {{ $job->created_at?->format('M d, Y') }}

                                        </p>


                                        <i class="ti ti-chevron-right mt-1 text-gray-400"></i>

                                    </div>

                                </div>

                            @empty

                                <div class="px-5 py-10 text-center">

                                    <div class="mx-auto flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50">

                                        <i class="ti ti-clipboard-off text-gray-400"></i>

                                    </div>


                                    <p class="mt-3 text-sm font-medium">
                                        No job orders yet
                                    </p>

                                    <p class="mt-1 text-xs text-gray-500">
                                        Assigned job orders will appear here.
                                    </p>

                                </div>

                            @endforelse

                        </div>

                    </div>



                    {{-- Quick Actions --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5">

                        <p class="font-medium">
                            Quick actions
                        </p>

                        <p class="mt-1 text-xs text-gray-500 mb-4">
                            Common mechanic tasks
                        </p>


                        <div class="flex flex-col gap-2">


                            <a
                                href="{{ route('mechanic.CJO') }}"
                                class="group flex items-center gap-3 rounded-lg border border-gray-200 p-3 transition hover:border-gray-300 hover:bg-gray-50"
                            >

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-900">

                                    <i class="ti ti-plus text-sm text-white"></i>

                                </div>


                                <div class="min-w-0 flex-1">

                                    <p class="text-sm font-medium">
                                        Create job order
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Record a new vehicle job
                                    </p>

                                </div>


                                <i class="ti ti-chevron-right text-gray-400"></i>

                            </a>



                            <a
                                href="#"
                                class="group flex items-center gap-3 rounded-lg border border-gray-200 p-3 transition hover:border-gray-300 hover:bg-gray-50"
                            >

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50">

                                    <i class="ti ti-clipboard-list text-sm text-blue-600"></i>

                                </div>


                                <div class="min-w-0 flex-1">

                                    <p class="text-sm font-medium">
                                        Assigned jobs
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        View your current workload
                                    </p>

                                </div>


                                <i class="ti ti-chevron-right text-gray-400"></i>

                            </a>



                            <a
                                href="#"
                                class="group flex items-center gap-3 rounded-lg border border-gray-200 p-3 transition hover:border-gray-300 hover:bg-gray-50"
                            >

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-green-50">

                                    <i class="ti ti-circle-check text-sm text-green-600"></i>

                                </div>


                                <div class="min-w-0 flex-1">

                                    <p class="text-sm font-medium">
                                        Completed jobs
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Review completed work
                                    </p>

                                </div>


                                <i class="ti ti-chevron-right text-gray-400"></i>

                            </a>



                            <a
                                href="#"
                                class="group flex items-center gap-3 rounded-lg border border-gray-200 p-3 transition hover:border-gray-300 hover:bg-gray-50"
                            >

                                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-50">

                                    <i class="ti ti-alert-circle text-sm text-red-600"></i>

                                </div>


                                <div class="min-w-0 flex-1">

                                    <p class="text-sm font-medium">
                                        Needs revision
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        Review returned jobs
                                    </p>

                                </div>


                                <i class="ti ti-chevron-right text-gray-400"></i>

                            </a>

                        </div>

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- TODAY / WORK INFORMATION --}}
                {{-- ================================================= --}}

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">


                    {{-- Today's workload --}}
                    <div class="rounded-xl border border-gray-200 bg-white p-5">

                        <div class="flex items-center justify-between">

                            <div>

                                <p class="font-medium">
                                    Today's workload
                                </p>

                                <p class="mt-1 text-xs text-gray-500">
                                    Current job distribution
                                </p>

                            </div>


                            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-50">

                                <i class="ti ti-calendar text-gray-500"></i>

                            </div>

                        </div>


                        <div class="mt-5 space-y-4">


                            {{-- Assigned --}}
                            <div>

                                <div class="flex items-center justify-between mb-1.5">

                                    <span class="text-xs text-gray-500">
                                        Assigned
                                    </span>

                                    <span class="text-xs font-medium">
                                        {{ $recentJobs->where('status', 'assigned')->count() }}
                                    </span>

                                </div>


                                <div class="h-1.5 overflow-hidden rounded-full bg-gray-100">

                                    <div
                                        class="h-full rounded-full bg-blue-500"
                                        style="width: {{ min($recentJobs->where('status', 'assigned')->count() * 20, 100) }}%"
                                    ></div>

                                </div>

                            </div>



                            {{-- In Progress --}}
                            <div>

                                <div class="flex items-center justify-between mb-1.5">

                                    <span class="text-xs text-gray-500">
                                        In progress
                                    </span>

                                    <span class="text-xs font-medium">
                                        {{ $recentJobs->where('status', 'in_progress')->count() }}
                                    </span>

                                </div>


                                <div class="h-1.5 overflow-hidden rounded-full bg-gray-100">

                                    <div
                                        class="h-full rounded-full bg-amber-500"
                                        style="width: {{ min($recentJobs->where('status', 'in_progress')->count() * 20, 100) }}%"
                                    ></div>

                                </div>

                            </div>



                            {{-- Needs Revision --}}
                            <div>

                                <div class="flex items-center justify-between mb-1.5">

                                    <span class="text-xs text-gray-500">
                                        Needs revision
                                    </span>

                                    <span class="text-xs font-medium">
                                        {{
                                            \App\Models\JobOrder::where('created_by', auth()->id())
                                                ->where('status', 'needs_revision')
                                                ->count()
                                        }}
                                    </span>

                                </div>


                                <div class="h-1.5 overflow-hidden rounded-full bg-gray-100">

                                    <div
                                        class="h-full rounded-full bg-red-500"
                                        style="width: {{ min(
                                            \App\Models\JobOrder::where('created_by', auth()->id())
                                                ->where('status', 'needs_revision')
                                                ->count() * 20,
                                            100
                                        ) }}%"
                                    ></div>

                                </div>

                            </div>

                        </div>

                    </div>



                    {{-- Work reminder --}}
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-5">

                        <div class="flex items-start gap-4">

                            <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-white border border-gray-200">

                                <i class="ti ti-info-circle text-gray-500"></i>

                            </div>


                            <div>

                                <p class="font-medium">
                                    Work reminder
                                </p>

                                <p class="mt-2 text-sm leading-6 text-gray-500">

                                    Make sure vehicle problems, performed services,
                                    and other relevant job details are recorded
                                    before submitting the job order.

                                </p>


                                <div class="mt-4 flex items-center gap-2 text-xs text-gray-500">

                                    <i class="ti ti-check"></i>

                                    Keep job order details updated

                                </div>


                                <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">

                                    <i class="ti ti-check"></i>

                                    Review returned job orders

                                </div>


                                <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">

                                    <i class="ti ti-check"></i>

                                    Submit completed work for review

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>



    {{-- ================================================= --}}
    {{-- CHART.JS --}}
    {{-- ================================================= --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | Job Status Chart
    |--------------------------------------------------------------------------
    */

    const statusCanvas = document.getElementById('jobStatusChart');

    if (statusCanvas) {

        new Chart(statusCanvas, {

            type: 'doughnut',

            data: {

                labels: [
                    'Assigned',
                    'In Progress',
                    'Completed',
                    'Needs Revision'
                ],

                datasets: [{

                    data: [

                        {{ $jobStatusData['assigned'] ?? 0 }},

                        {{ $jobStatusData['in_progress'] ?? 0 }},

                        {{ $jobStatusData['completed'] ?? 0 }},

                        {{ $jobStatusData['needs_revision'] ?? 0 }}

                    ],

                    backgroundColor: [
                        '#3b82f6',
                        '#f59e0b',
                        '#22c55e',
                        '#ef4444'
                    ],

                    borderWidth: 0

                }]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '72%',

                plugins: {

                    legend: {

                        position: 'bottom',

                        labels: {

                            usePointStyle: true,

                            pointStyle: 'circle',

                            padding: 16,

                            font: {
                                size: 11
                            }

                        }

                    }

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | Work Activity Chart
    |--------------------------------------------------------------------------
    */

    const activityCanvas = document.getElementById('activityChart');

    if (activityCanvas) {

        const labels = @json($statusActivityLabels);

        const completedData = @json($completedActivity);

        const pendingData = @json($pendingActivity);

        const revisionData = @json($revisionActivity);


        const monthLabels = @json($activityMonthLabels);

        const monthData = @json($activityMonthData);


        const weekLabels = @json($activityWeekLabels);

        const weekData = @json($activityWeekData);


        const activityChart = new Chart(activityCanvas, {

            type: 'line',

            data: {

                labels: labels,

                datasets: [

                    /*
                    |--------------------------------------------------------------------------
                    | GREEN — COMPLETED
                    |--------------------------------------------------------------------------
                    */

                    {

                        label: 'Completed',

                        data: completedData,

                        borderColor: '#22c55e',

                        backgroundColor: 'rgba(34, 197, 94, 0.08)',

                        borderWidth: 2,

                        tension: 0.35,

                        fill: false,

                        pointRadius: 3,

                        pointHoverRadius: 5

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | YELLOW — PENDING APPROVAL
                    |--------------------------------------------------------------------------
                    */

                    {

                        label: 'Pending approval',

                        data: pendingData,

                        borderColor: '#eab308',

                        backgroundColor: 'rgba(234, 179, 8, 0.08)',

                        borderWidth: 2,

                        tension: 0.35,

                        fill: false,

                        pointRadius: 3,

                        pointHoverRadius: 5

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | RED — REJECTED / NEEDS REVISION
                    |--------------------------------------------------------------------------
                    */

                    {

                        label: 'Rejected / Needs revision',

                        data: revisionData,

                        borderColor: '#ef4444',

                        backgroundColor: 'rgba(239, 68, 68, 0.08)',

                        borderWidth: 2,

                        tension: 0.35,

                        fill: false,

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

                        display: true,

                        position: 'bottom',

                        labels: {

                            usePointStyle: true,

                            pointStyle: 'circle',

                            padding: 16,

                            font: {
                                size: 11
                            }

                        }

                    }

                },


                scales: {

                    x: {

                        grid: {
                            display: false
                        },

                        ticks: {

                            font: {
                                size: 11
                            },

                            color: '#9ca3af'

                        }

                    },


                    y: {

                        beginAtZero: true,

                        ticks: {

                            precision: 0,

                            color: '#9ca3af',

                            font: {
                                size: 11
                            }

                        },

                        grid: {

                            color: '#f3f4f6'

                        }

                    }

                }

            }

        });


        /*
        |--------------------------------------------------------------------------
        | PERIOD SELECTOR
        |--------------------------------------------------------------------------
        */

        const activityPeriod =
            document.getElementById('activityPeriod');


        if (activityPeriod) {

            activityPeriod.addEventListener('change', function () {

                /*
                |--------------------------------------------------------------
                | LAST 6 WEEKS
                |--------------------------------------------------------------
                */

                if (this.value === 'weeks') {

                    activityChart.data.labels = weekLabels;

                    activityChart.data.datasets[0].data = weekData;

                    /*
                    | No weekly pending/revision arrays currently exist
                    | in the controller, so hide those lines.
                    */

                    activityChart.data.datasets[1].data = [];

                    activityChart.data.datasets[2].data = [];


                /*
                |--------------------------------------------------------------
                | LAST 6 MONTHS
                |--------------------------------------------------------------
                */

                } else {

                    activityChart.data.labels = monthLabels;

                    activityChart.data.datasets[0].data = monthData;

                    /*
                    | Restore daily status lines when switching back.
                    */

                    activityChart.data.datasets[1].data = pendingData;

                    activityChart.data.datasets[2].data = revisionData;

                }


                activityChart.update();

            });

        }

    }

});

</script>

</x-app-layout>