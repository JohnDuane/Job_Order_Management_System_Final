<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="flex min-h-screen">

            {{-- Sidebar --}}
            <x-mechanic-sidebar />


            {{-- Main Content --}}
            <main class="flex-1 min-w-0 p-8">

                {{-- ========================================================= --}}
                {{-- HEADER --}}
                {{-- ========================================================= --}}

                <div class="flex items-start justify-between mb-6">

                    <div>

                        <h1 class="text-2xl font-medium">
                            My job orders
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            Track job orders assigned to you.
                        </p>

                    </div>


                    <a
                        href="{{ route('mechanic.CJO') }}"
                        class="inline-flex items-center gap-2 rounded-lg
                               bg-gray-900 px-4 py-2.5 text-sm
                               font-medium text-white
                               transition hover:bg-gray-800"
                    >
                        <i class="ti ti-plus"></i>
                        Create job order
                    </a>

                </div>


                {{-- ========================================================= --}}
                {{-- SEARCH & FILTER --}}
                {{-- ========================================================= --}}

                <form
                    method="GET"
                    class="mb-5 flex flex-col gap-2 sm:flex-row"
                >

                    <input
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search customer, vehicle, plate..."
                        class="w-full max-w-md rounded-lg
                               border border-gray-200
                               px-3 py-2.5 text-sm
                               focus:border-gray-400
                               focus:outline-none
                               focus:ring-2 focus:ring-gray-100"
                    >


                    <select
                        name="status"
                        onchange="this.form.submit()"
                        class="rounded-lg border border-gray-200
                               px-3 py-2.5 text-sm
                               focus:border-gray-400
                               focus:outline-none
                               focus:ring-2 focus:ring-gray-100"
                    >

                        <option value="">
                            All statuses
                        </option>

                        @foreach ([
                            'pending_approval' => 'Pending approval',
                            'approved' => 'Approved',
                            'assigned' => 'Assigned',
                            'in_progress' => 'In progress',
                            'completed' => 'Completed',
                            'needs_revision' => 'Needs revision'
                        ] as $key => $label)

                            <option
                                value="{{ $key }}"
                                @selected(request('status') === $key)
                            >
                                {{ $label }}
                            </option>

                        @endforeach

                    </select>


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center
                               gap-2 rounded-lg border border-gray-200
                               px-4 py-2.5 text-sm text-gray-700
                               transition hover:bg-gray-50"
                    >
                        <i class="ti ti-search"></i>
                        Search
                    </button>

                </form>


                {{-- ========================================================= --}}
                {{-- JOB ORDERS --}}
                {{-- ========================================================= --}}

                <div class="space-y-3">

                    @forelse($jobs as $job)

                        {{-- ================================================= --}}
                        {{-- JOB ORDER CARD --}}
                        {{-- ================================================= --}}

                        <div
                            x-data="{ viewOpen: false }"
                            class="rounded-xl border border-gray-200
                                   bg-white p-5
                                   transition hover:border-gray-300"
                        >

                            <div
                                class="flex flex-col gap-4
                                       sm:flex-row sm:items-center
                                       sm:justify-between"
                            >

                                {{-- Job Information --}}
                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <b class="text-gray-900">
                                            {{ $job->code }}
                                        </b>


                                        {{-- Status --}}
                                        @php

                                            $statusStyles = [

                                                'pending_approval' =>
                                                    'bg-yellow-100 text-yellow-700 ring-yellow-200',

                                                'approved' =>
                                                    'bg-blue-100 text-blue-700 ring-blue-200',

                                                'assigned' =>
                                                    'bg-purple-100 text-purple-700 ring-purple-200',

                                                'in_progress' =>
                                                    'bg-orange-100 text-orange-700 ring-orange-200',

                                                'completed' =>
                                                    'bg-green-100 text-green-700 ring-green-200',

                                                'needs_revision' =>
                                                    'bg-red-100 text-red-700 ring-red-200',

                                                'rejected' =>
                                                    'bg-gray-100 text-gray-700 ring-gray-200',

                                            ];

                                            $statusIcons = [

                                                'pending_approval' => 'ti-clock',

                                                'approved' => 'ti-check',

                                                'assigned' => 'ti-user-check',

                                                'in_progress' => 'ti-tool',

                                                'completed' => 'ti-circle-check',

                                                'needs_revision' => 'ti-alert-circle',

                                                'rejected' => 'ti-x',

                                            ];

                                            $statusClass =
                                                $statusStyles[$job->status]
                                                ?? 'bg-gray-100 text-gray-700 ring-gray-200';

                                            $statusIcon =
                                                $statusIcons[$job->status]
                                                ?? 'ti-help-circle';

                                        @endphp


                                        <span
                                            class="inline-flex items-center gap-1.5
                                                   rounded-md px-2.5 py-1
                                                   text-xs font-medium
                                                   ring-1 ring-inset
                                                   {{ $statusClass }}"
                                        >

                                            <i class="ti {{ $statusIcon }}"></i>

                                            {{ str_replace('_', ' ', ucwords($job->status)) }}

                                        </span>

                                    </div>


                                    <p class="mt-1 text-sm font-medium text-gray-800">

                                        {{ $job->customer->first_name }}
                                        {{ $job->customer->last_name }}

                                    </p>


                                    <p class="text-xs text-gray-500">

                                        {{ $job->vehicle->make }}

                                        @if ($job->vehicle->model)
                                            {{ $job->vehicle->model }}
                                        @endif

                                        ·

                                        {{ $job->vehicle->plate_number }}

                                    </p>


                                    <p class="mt-1 text-xs text-gray-400">

                                        {{ $job->date_issued->format('M d, Y') }}

                                        ·

                                        ₱{{ number_format($job->total_cost, 2) }}

                                    </p>

                                </div>


                                {{-- ================================================= --}}
                                {{-- ACTIONS --}}
                                {{-- ================================================= --}}

                                <div class="flex flex-wrap items-center gap-2">

                                    {{-- View --}}
                                    <button
                                        type="button"
                                        @click="viewOpen = true"
                                        class="inline-flex items-center gap-1.5
                                               rounded-lg border border-gray-200
                                               px-3 py-2 text-sm
                                               text-gray-700
                                               transition hover:bg-gray-50"
                                    >

                                        <i class="ti ti-eye"></i>

                                        View job order

                                    </button>


                                    {{-- Start --}}
                                    @if ($job->status === 'assigned')

                                        <form
                                            method="POST"
                                            action="{{ route('mechanic.job-orders.start', $job) }}"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5
                                                       rounded-lg bg-gray-900
                                                       px-3 py-2 text-sm
                                                       font-medium text-white
                                                       transition hover:bg-gray-800"
                                                onclick="return confirm('Start this job order?')"
                                            >

                                                <i class="ti ti-player-play"></i>

                                                Start

                                            </button>

                                        </form>

                                    @elseif($job->status === 'in_progress')

                                        <form
                                            method="POST"
                                            action="{{ route('mechanic.job-orders.complete', $job) }}"
                                        >

                                            @csrf

                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5
                                                       rounded-lg bg-green-600
                                                       px-3 py-2 text-sm
                                                       font-medium text-white
                                                       transition hover:bg-green-700"
                                                onclick="return confirm('Mark this job order as completed?')"
                                            >

                                                <i class="ti ti-circle-check"></i>

                                                Complete

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- SHORT SUMMARY --}}
                            {{-- ================================================= --}}

                            <div
                                class="mt-4 border-t border-gray-100
                                       pt-3 text-sm text-gray-600"
                            >

                                <div>

                                    <span class="font-medium text-gray-700">
                                        Services:
                                    </span>

                                    {{ $job->services->pluck('service_name')->join(', ') ?: 'No services listed.' }}

                                </div>


                                <div class="mt-1">

                                    <span class="font-medium text-gray-700">
                                        Problem:
                                    </span>

                                    {{ $job->problem_description }}

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- VIEW JOB ORDER MODAL --}}
                            {{-- ================================================= --}}

                            <div
                                x-show="viewOpen"
                                x-cloak
                                x-transition.opacity
                                @keydown.escape.window="viewOpen = false"
                                class="fixed inset-0 z-50 flex items-center
                                       justify-center bg-black/50 px-4 py-6"
                            >

                                <div
                                    x-show="viewOpen"
                                    x-transition
                                    @click.outside="viewOpen = false"
                                    class="flex max-h-[90vh] w-full max-w-3xl
                                           flex-col overflow-hidden
                                           rounded-2xl bg-white shadow-2xl"
                                >

                                    {{-- ========================================= --}}
                                    {{-- MODAL HEADER --}}
                                    {{-- ========================================= --}}

                                    <div
                                        class="flex items-start justify-between
                                               border-b border-gray-100
                                               px-6 py-5"
                                    >

                                        <div>

                                            <div class="flex items-center gap-3">

                                                <h2
                                                    class="text-lg font-semibold
                                                           text-gray-900"
                                                >
                                                    Job order {{ $job->code }}
                                                </h2>


                                                <span
                                                    class="inline-flex items-center
                                                           gap-1.5 rounded-md
                                                           px-2.5 py-1 text-xs
                                                           font-medium ring-1
                                                           ring-inset
                                                           {{ $statusClass }}"
                                                >

                                                    <i class="ti {{ $statusIcon }}"></i>

                                                    {{ str_replace('_', ' ', ucwords($job->status)) }}

                                                </span>

                                            </div>


                                            <p class="mt-1 text-sm text-gray-500">
                                                Complete job order details
                                            </p>

                                        </div>


                                        <button
                                            type="button"
                                            @click="viewOpen = false"
                                            class="rounded-lg p-1.5
                                                   text-gray-400
                                                   transition hover:bg-gray-100
                                                   hover:text-gray-700"
                                        >

                                            <i class="ti ti-x text-xl"></i>

                                        </button>

                                    </div>


                                    {{-- ========================================= --}}
                                    {{-- MODAL BODY --}}
                                    {{-- ========================================= --}}

                                    <div class="overflow-y-auto">

                                        <div class="p-6 space-y-6">


                                            {{-- ================================= --}}
                                            {{-- BASIC INFORMATION --}}
                                            {{-- ================================= --}}

                                            <div>

                                                <h3
                                                    class="text-sm font-semibold
                                                           text-gray-900"
                                                >
                                                    Job order information
                                                </h3>


                                                <div
                                                    class="mt-3 grid grid-cols-1
                                                           gap-4 sm:grid-cols-2"
                                                >

                                                    <div
                                                        class="rounded-lg bg-gray-50
                                                               p-4"
                                                    >

                                                        <p
                                                            class="text-xs
                                                                   text-gray-400"
                                                        >
                                                            Job order
                                                        </p>

                                                        <p
                                                            class="mt-1 text-sm
                                                                   font-medium
                                                                   text-gray-900"
                                                        >
                                                            {{ $job->code }}
                                                        </p>

                                                    </div>


                                                    <div
                                                        class="rounded-lg bg-gray-50
                                                               p-4"
                                                    >

                                                        <p
                                                            class="text-xs
                                                                   text-gray-400"
                                                        >
                                                            Date issued
                                                        </p>

                                                        <p
                                                            class="mt-1 text-sm
                                                                   font-medium
                                                                   text-gray-900"
                                                        >
                                                            {{ $job->date_issued->format('F d, Y') }}
                                                        </p>

                                                    </div>


                                                    <div
                                                        class="rounded-lg bg-gray-50
                                                               p-4"
                                                    >

                                                        <p
                                                            class="text-xs
                                                                   text-gray-400"
                                                        >
                                                            Expected completion
                                                        </p>

                                                        <p
                                                            class="mt-1 text-sm
                                                                   font-medium
                                                                   text-gray-900"
                                                        >

                                                            @if ($job->expected_empl_date)

                                                                {{ $job->expected_empl_date->format('F d, Y') }}

                                                            @else

                                                                <span class="text-gray-400">
                                                                    Not specified
                                                                </span>

                                                            @endif

                                                        </p>

                                                    </div>


                                                    <div
                                                        class="rounded-lg bg-gray-50
                                                               p-4"
                                                    >

                                                        <p
                                                            class="text-xs
                                                                   text-gray-400"
                                                        >
                                                            Total cost
                                                        </p>

                                                        <p
                                                            class="mt-1 text-sm
                                                                   font-semibold
                                                                   text-gray-900"
                                                        >
                                                            ₱{{ number_format($job->total_cost, 2) }}
                                                        </p>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- ================================= --}}
                                            {{-- CUSTOMER --}}
                                            {{-- ================================= --}}

                                            <div>

                                                <h3
                                                    class="text-sm font-semibold
                                                           text-gray-900"
                                                >
                                                    Customer
                                                </h3>


                                                <div
                                                    class="mt-3 rounded-xl
                                                           border border-gray-200
                                                           p-4"
                                                >

                                                    <div
                                                        class="flex items-center
                                                               gap-3"
                                                    >

                                                        <div
                                                            class="flex h-10 w-10
                                                                   shrink-0
                                                                   items-center
                                                                   justify-center
                                                                   rounded-full
                                                                   bg-gray-100"
                                                        >

                                                            <i
                                                                class="ti ti-user
                                                                       text-lg
                                                                       text-gray-500"
                                                            ></i>

                                                        </div>


                                                        <div>

                                                            <p
                                                                class="text-sm
                                                                       font-medium
                                                                       text-gray-900"
                                                            >

                                                                {{ $job->customer->first_name }}
                                                                {{ $job->customer->last_name }}

                                                            </p>


                                                            @if ($job->customer->email)

                                                                <p
                                                                    class="text-xs
                                                                           text-gray-500"
                                                                >
                                                                    {{ $job->customer->email }}
                                                                </p>

                                                            @endif

                                                            @if ($job->customer->contact_number)

                                                                <p
                                                                    class="text-xs
                                                                           text-gray-500"
                                                                >
                                                                    {{ $job->customer->contact_number }}
                                                                </p>

                                                            @endif

                                                        </div>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- ================================= --}}
                                            {{-- VEHICLE --}}
                                            {{-- ================================= --}}

                                            <div>

                                                <h3
                                                    class="text-sm font-semibold
                                                           text-gray-900"
                                                >
                                                    Vehicle
                                                </h3>


                                                <div
                                                    class="mt-3 grid grid-cols-1
                                                           gap-3 sm:grid-cols-3"
                                                >

                                                    <div
                                                        class="rounded-lg bg-gray-50
                                                               p-4"
                                                    >

                                                        <p class="text-xs text-gray-400">
                                                            Make
                                                        </p>

                                                        <p
                                                            class="mt-1 text-sm
                                                                   font-medium"
                                                        >
                                                            {{ $job->vehicle->make }}
                                                        </p>

                                                    </div>


                                                    <div
                                                        class="rounded-lg bg-gray-50
                                                               p-4"
                                                    >

                                                        <p class="text-xs text-gray-400">
                                                            Model
                                                        </p>

                                                        <p
                                                            class="mt-1 text-sm
                                                                   font-medium"
                                                        >
                                                            {{ $job->vehicle->model ?: '—' }}
                                                        </p>

                                                    </div>


                                                    <div
                                                        class="rounded-lg bg-gray-50
                                                               p-4"
                                                    >

                                                        <p class="text-xs text-gray-400">
                                                            Plate number
                                                        </p>

                                                        <p
                                                            class="mt-1 text-sm
                                                                   font-medium"
                                                        >
                                                            {{ $job->vehicle->plate_number }}
                                                        </p>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- ================================= --}}
                                            {{-- SERVICES --}}
                                            {{-- ================================= --}}

                                            <div>

                                                <h3
                                                    class="text-sm font-semibold
                                                           text-gray-900"
                                                >
                                                    Services
                                                </h3>


                                                <div
                                                    class="mt-3 overflow-hidden
                                                           rounded-xl border
                                                           border-gray-200"
                                                >

                                                    @forelse ($job->services as $service)

                                                        <div
                                                            class="flex items-center
                                                                   justify-between
                                                                   gap-4 border-b
                                                                   border-gray-100
                                                                   px-4 py-3
                                                                   last:border-0"
                                                        >

                                                            <div class="min-w-0">

                                                                <p
                                                                    class="text-sm
                                                                           font-medium
                                                                           text-gray-900"
                                                                >
                                                                    {{ $service->service_name }}
                                                                </p>


                                                                @if ($service->job_desc)

                                                                    <p
                                                                        class="mt-0.5
                                                                               text-xs
                                                                               text-gray-500"
                                                                    >
                                                                        {{ $service->job_desc }}
                                                                    </p>

                                                                @endif

                                                            </div>


                                                            <p
                                                                class="shrink-0
                                                                       text-sm
                                                                       font-medium
                                                                       text-gray-900"
                                                            >
                                                                ₱{{ number_format($service->price, 2) }}
                                                            </p>

                                                        </div>

                                                    @empty

                                                        <div
                                                            class="px-4 py-4
                                                                   text-sm
                                                                   text-gray-500"
                                                        >
                                                            No services listed.
                                                        </div>

                                                    @endforelse


                                                    {{-- Service Total --}}

                                                    <div
                                                        class="flex items-center
                                                               justify-between
                                                               border-t
                                                               border-gray-200
                                                               bg-gray-50
                                                               px-4 py-3"
                                                    >

                                                        <p
                                                            class="text-sm
                                                                   font-semibold
                                                                   text-gray-900"
                                                        >
                                                            Total
                                                        </p>


                                                        <p
                                                            class="text-sm
                                                                   font-semibold
                                                                   text-gray-900"
                                                        >
                                                            ₱{{ number_format($job->total_cost, 2) }}
                                                        </p>

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- ================================= --}}
                                            {{-- PROBLEM --}}
                                            {{-- ================================= --}}

                                            <div>

                                                <h3
                                                    class="text-sm font-semibold
                                                           text-gray-900"
                                                >
                                                    Problem description
                                                </h3>


                                                <div
                                                    class="mt-3 rounded-xl
                                                           border border-gray-200
                                                           bg-gray-50 p-4"
                                                >

                                                    <p
                                                        class="whitespace-pre-line
                                                               text-sm leading-6
                                                               text-gray-700"
                                                    >
                                                        {{ $job->problem_description }}
                                                    </p>

                                                </div>

                                            </div>


                                            {{-- ================================= --}}
                                            {{-- REMARKS --}}
                                            {{-- ================================= --}}

                                            <div>

                                                <h3
                                                    class="text-sm font-semibold
                                                           text-gray-900"
                                                >
                                                    Remarks
                                                </h3>


                                                <div
                                                    class="mt-3 rounded-xl
                                                           border border-gray-200
                                                           bg-gray-50 p-4"
                                                >

                                                    @if ($job->remarks)

                                                        <p
                                                            class="whitespace-pre-line
                                                                   text-sm leading-6
                                                                   text-gray-700"
                                                        >
                                                            {{ $job->remarks }}
                                                        </p>

                                                    @else

                                                        <p
                                                            class="text-sm
                                                                   text-gray-400"
                                                        >
                                                            No remarks provided.
                                                        </p>

                                                    @endif

                                                </div>

                                            </div>


                                            {{-- ================================= --}}
                                            {{-- ASSIGNED MECHANICS --}}
                                            {{-- ================================= --}}

                                            <div>

                                                <h3
                                                    class="text-sm font-semibold
                                                           text-gray-900"
                                                >
                                                    Assigned mechanics
                                                </h3>


                                                <div class="mt-3 space-y-2">

                                                    @forelse ($job->assignments as $assignment)

                                                        <div
                                                            class="flex items-center
                                                                   gap-3 rounded-lg
                                                                   border
                                                                   border-gray-200
                                                                   px-4 py-3"
                                                        >

                                                            <div
                                                                class="flex h-9 w-9
                                                                       shrink-0
                                                                       items-center
                                                                       justify-center
                                                                       rounded-full
                                                                       bg-gray-100"
                                                            >

                                                                <i
                                                                    class="ti ti-tool
                                                                           text-gray-500"
                                                                ></i>

                                                            </div>


                                                            <div>

                                                                <p
                                                                    class="text-sm
                                                                           font-medium
                                                                           text-gray-900"
                                                                >

                                                                    {{ $assignment->staff?->user?->name ?? 'Unknown mechanic' }}

                                                                </p>


                                                                @if ($assignment->assigned_date)

                                                                    <p
                                                                        class="text-xs
                                                                               text-gray-500"
                                                                    >
                                                                        Assigned
                                                                        {{ \Carbon\Carbon::parse($assignment->assigned_date)->format('M d, Y') }}
                                                                    </p>

                                                                @endif

                                                            </div>

                                                        </div>

                                                    @empty

                                                        <div
                                                            class="rounded-lg
                                                                   border
                                                                   border-dashed
                                                                   border-gray-200
                                                                   px-4 py-4"
                                                        >

                                                            <p
                                                                class="text-sm
                                                                       text-gray-400"
                                                            >
                                                                No mechanic has been
                                                                assigned yet.
                                                            </p>

                                                        </div>

                                                    @endforelse

                                                </div>

                                            </div>


                                            {{-- ================================= --}}
                                            {{-- APPROVAL HISTORY --}}
                                            {{-- ================================= --}}

                                            @if ($job->approvals->count())

                                                <div>

                                                    <h3
                                                        class="text-sm font-semibold
                                                               text-gray-900"
                                                    >
                                                        Approval history
                                                    </h3>


                                                    <div
                                                        class="mt-3 space-y-2"
                                                    >

                                                        @foreach ($job->approvals->sortByDesc('id') as $approval)

                                                            <div
                                                                class="rounded-lg
                                                                       border
                                                                       border-gray-200
                                                                       p-4"
                                                            >

                                                                <div
                                                                    class="flex
                                                                           items-center
                                                                           justify-between
                                                                           gap-3"
                                                                >

                                                                    <span
                                                                        class="inline-flex
                                                                               rounded-md
                                                                               bg-gray-100
                                                                               px-2
                                                                               py-1
                                                                               text-xs
                                                                               font-medium"
                                                                    >

                                                                        {{ str_replace('_', ' ', ucwords($approval->status)) }}

                                                                    </span>


                                                                    @if ($approval->action_date)

                                                                        <span
                                                                            class="text-xs
                                                                                   text-gray-400"
                                                                        >
                                                                            {{ \Carbon\Carbon::parse($approval->action_date)->format('M d, Y') }}
                                                                        </span>

                                                                    @endif

                                                                </div>


                                                                @if ($approval->remarks)

                                                                    <p
                                                                        class="mt-2
                                                                               whitespace-pre-line
                                                                               text-sm
                                                                               text-gray-600"
                                                                    >
                                                                        {{ $approval->remarks }}
                                                                    </p>

                                                                @endif

                                                            </div>

                                                        @endforeach

                                                    </div>

                                                </div>

                                            @endif

                                        </div>

                                    </div>


                                    {{-- ========================================= --}}
                                    {{-- MODAL FOOTER --}}
                                    {{-- ========================================= --}}

                                    <div
                                        class="flex justify-end
                                               border-t border-gray-100
                                               px-6 py-4"
                                    >

                                        <button
                                            type="button"
                                            @click="viewOpen = false"
                                            class="rounded-lg border
                                                   border-gray-200
                                                   px-4 py-2.5 text-sm
                                                   font-medium text-gray-700
                                                   transition hover:bg-gray-50"
                                        >
                                            Close
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @empty

                        <div
                            class="rounded-xl border border-dashed
                                   border-gray-200 p-10 text-center
                                   text-gray-500"
                        >

                            <div
                                class="mx-auto flex h-12 w-12
                                       items-center justify-center
                                       rounded-full bg-gray-50"
                            >

                                <i class="ti ti-clipboard-off text-xl text-gray-400"></i>

                            </div>


                            <p class="mt-3 text-sm font-medium text-gray-700">
                                No job orders found
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                There are currently no job orders matching
                                your search.
                            </p>

                        </div>

                    @endforelse

                </div>


                {{-- ========================================================= --}}
                {{-- PAGINATION --}}
                {{-- ========================================================= --}}

                <div class="mt-5">
                    {{ $jobs->links() }}
                </div>

            </main>

        </div>

    </div>

</x-app-layout>