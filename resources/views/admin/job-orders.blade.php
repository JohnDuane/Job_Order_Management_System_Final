<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="min-h-screen lg:flex">

            {{-- Sidebar --}}
            <x-admin-sidebar />

            {{-- Main Content --}}
            <main
                class="min-w-0 flex-1 flex-col gap-6 p-4 sm:p-6 lg:p-8"
                x-data="{
                    viewOpen: false,
                    selectedJob: null
                }"
                @open-job-modal.window="
                    selectedJob = $event.detail.id;
                    viewOpen = true;
                "
            >

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


                    <input
                        type="date"
                        name="date_issued"
                        value="{{ request('date_issued') }}"
                        aria-label="Filter by date issued"
                        class="rounded-lg border px-3 py-2.5 text-sm"
                    />

                    <select
                        name="status"
                        class="rounded-lg border px-3 py-2.5 text-sm"
                    >

                        <option value="">
                            All statuses
                        </option>

                        @foreach ([
                            'pending_approval',
                            'approved',
                            'assigned',
                            'in_progress',
                            'completed',
                            'needs_revision',
                            'rejected'
                        ] as $s)

                            <option
                                value="{{ $s }}"
                                @selected(request('status') === $s)
                            >
                                {{ str_replace('_', ' ', ucwords($s)) }}
                            </option>

                        @endforeach

                    </select>

                    <button
                        type="submit"
                        class="rounded-lg border px-4 py-2 text-sm transition hover:bg-gray-50"
                    >
                        Filter
                    </button>

                </form>


                {{-- ========================================================= --}}
                {{-- JOB ORDERS TABLE --}}
                {{-- ========================================================= --}}

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

                                <th class="p-4 text-right">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse ($jobs as $job)

                                @php

                                    $statusStyles = [

                                        'pending_approval' =>
                                            'bg-yellow-100 text-yellow-700 ring-1 ring-inset ring-yellow-200',

                                        'approved' =>
                                            'bg-blue-100 text-blue-700 ring-1 ring-inset ring-blue-200',

                                        'assigned' =>
                                            'bg-purple-100 text-purple-700 ring-1 ring-inset ring-purple-200',

                                        'in_progress' =>
                                            'bg-orange-100 text-orange-700 ring-1 ring-inset ring-orange-200',

                                        'completed' =>
                                            'bg-green-100 text-green-700 ring-1 ring-inset ring-green-200',

                                        'needs_revision' =>
                                            'bg-red-100 text-red-700 ring-1 ring-inset ring-red-200',

                                        'rejected' =>
                                            'bg-gray-100 text-gray-700 ring-1 ring-inset ring-gray-200',

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

                                    $assignmentRemarks = $job->assignments
                                        ->pluck('remarks')
                                        ->filter()
                                        ->unique()
                                        ->values();

                                @endphp


                                <tr class="border-b last:border-0">

                                    {{-- JO --}}
                                    <td class="p-4 font-medium">
                                        {{ $job->code }}
                                    </td>


                                    {{-- Customer --}}
                                    <td class="p-4">

                                        {{ $job->customer->first_name }}
                                        {{ $job->customer->last_name }}

                                    </td>


                                    {{-- Vehicle --}}
                                    <td class="p-4">

                                        {{ $job->vehicle->make }}

                                        <div class="text-xs text-gray-400">
                                            {{ $job->vehicle->plate_number }}
                                        </div>

                                    </td>


                                    {{-- Mechanic --}}
                                    <td class="p-4">

                                        {{ $job->assignments
                                            ->map(fn ($a) => $a->staff?->user?->name)
                                            ->filter()
                                            ->join(', ')
                                            ?: '—'
                                        }}

                                    </td>


                                    {{-- Date --}}
                                    <td class="p-4">

                                        {{ $job->date_issued->format('M d, Y') }}

                                    </td>


                                    {{-- Status --}}
                                    <td class="p-4">

                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-xs font-medium {{ $statusClass }}"
                                        >

                                            <i class="ti {{ $statusIcon }} text-sm"></i>

                                            {{ str_replace('_', ' ', ucwords($job->status)) }}

                                        </span>

                                    </td>


                                    {{-- Total --}}
                                    <td class="whitespace-nowrap p-4">

                                        ₱{{ number_format($job->total_cost, 2) }}

                                    </td>


                                    {{-- Action --}}
                                    <td class="p-4 text-right">

                                        <button
                                            type="button"
                                            @click="$dispatch('open-job-modal', { id: {{ $job->job_order_id }} })"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-3 py-2 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                                        >

                                            <i class="ti ti-eye text-base"></i>

                                            View

                                        </button>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="8"
                                        class="p-10 text-center text-gray-500"
                                    >
                                        No job orders found.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}
                <div class="mt-5">
                    {{ $jobs->links() }}
                </div>


                {{-- ========================================================= --}}
                {{-- GLOBAL VIEW JOB ORDER MODAL --}}
                {{-- IMPORTANT: OUTSIDE THE TABLE --}}
                {{-- ========================================================= --}}

                <div
                    x-show="viewOpen"
                    x-cloak
                    x-transition.opacity
                    @keydown.escape.window="viewOpen = false"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4 py-6"
                >

                    <div
                        x-show="viewOpen"
                        x-transition
                        @click.outside="viewOpen = false"
                        class="flex max-h-[90vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl"
                    >

                        {{-- ================================================= --}}
                        {{-- MODAL HEADER --}}
                        {{-- ================================================= --}}

                        <div class="flex items-start justify-between border-b border-gray-100 px-6 py-5">

                            <div>

                                @foreach ($jobs as $job)

                                    <div
                                        x-show="selectedJob === {{ $job->job_order_id }}"
                                        x-cloak
                                    >

                                        <div class="flex items-center gap-3">

                                            <h2 class="text-lg font-semibold text-gray-900">
                                                Job order {{ $job->code }}
                                            </h2>

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClass }}"
                                            >

                                                <i class="ti {{ $statusIcon }}"></i>

                                                {{ str_replace('_', ' ', ucwords($job->status)) }}

                                            </span>

                                        </div>

                                        <p class="mt-1 text-sm text-gray-500">
                                            Complete job order details
                                        </p>

                                    </div>

                                @endforeach

                            </div>


                            {{-- Close --}}
                            <button
                                type="button"
                                @click="viewOpen = false"
                                class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                            >

                                <i class="ti ti-x text-xl"></i>

                            </button>

                        </div>


                        {{-- ================================================= --}}
                        {{-- MODAL BODY --}}
                        {{-- ================================================= --}}

                        <div class="overflow-y-auto">

                            @foreach ($jobs as $job)

                                @php

                                    $modalStatusClass =
                                        $statusStyles[$job->status]
                                        ?? 'bg-gray-100 text-gray-700 ring-gray-200';

                                    $modalStatusIcon =
                                        $statusIcons[$job->status]
                                        ?? 'ti-help-circle';

                                    $assignmentRemarks = $job->assignments
                                        ->pluck('remarks')
                                        ->filter()
                                        ->unique()
                                        ->values();

                                @endphp


                                <div
                                    x-show="selectedJob === {{ $job->job_order_id }}"
                                    x-cloak
                                >

                                    <div class="space-y-6 p-6">


                                        {{-- ================================================= --}}
                                        {{-- BASIC INFORMATION --}}
                                        {{-- ================================================= --}}

                                        <div>

                                            <h3 class="text-sm font-semibold text-gray-900">
                                                Job order information
                                            </h3>

                                            <div class="mt-3 grid grid-cols-1 gap-4 sm:grid-cols-2">

                                                <div class="rounded-lg bg-gray-50 p-4">

                                                    <p class="text-xs text-gray-400">
                                                        Job order
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                                        {{ $job->code }}
                                                    </p>

                                                </div>


                                                <div class="rounded-lg bg-gray-50 p-4">

                                                    <p class="text-xs text-gray-400">
                                                        Date issued
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                                        {{ $job->date_issued->format('F d, Y') }}
                                                    </p>

                                                </div>


                                                <div class="rounded-lg bg-gray-50 p-4">

                                                    <p class="text-xs text-gray-400">
                                                        Expected completion
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-gray-900">

                                                        @if ($job->expected_empl_date)

                                                            {{ $job->expected_empl_date->format('F d, Y') }}

                                                        @else

                                                            <span class="text-gray-400">
                                                                Not specified
                                                            </span>

                                                        @endif

                                                    </p>

                                                </div>


                                                <div class="rounded-lg bg-gray-50 p-4">

                                                    <p class="text-xs text-gray-400">
                                                        Total cost
                                                    </p>

                                                    <p class="mt-1 text-sm font-semibold text-gray-900">
                                                        ₱{{ number_format($job->total_cost, 2) }}
                                                    </p>

                                                </div>

                                            </div>

                                        </div>


                                        {{-- ================================================= --}}
                                        {{-- CUSTOMER --}}
                                        {{-- ================================================= --}}

                                        <div>

                                            <h3 class="text-sm font-semibold text-gray-900">
                                                Customer
                                            </h3>

                                            <div class="mt-3 rounded-xl border border-gray-200 p-4">

                                                <div class="flex items-center gap-3">

                                                    <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100">

                                                        <i class="ti ti-user text-lg text-gray-500"></i>

                                                    </div>

                                                    <div>

                                                        <p class="text-sm font-medium text-gray-900">

                                                            {{ $job->customer->first_name }}
                                                            {{ $job->customer->last_name }}

                                                        </p>


                                                        @if ($job->customer->email)

                                                            <p class="text-xs text-gray-500">
                                                                {{ $job->customer->email }}
                                                            </p>

                                                        @endif


                                                        @if ($job->customer->contact_number)

                                                            <p class="text-xs text-gray-500">
                                                                {{ $job->customer->contact_number }}
                                                            </p>

                                                        @endif

                                                    </div>

                                                </div>

                                            </div>

                                        </div>


                                        {{-- ================================================= --}}
                                        {{-- VEHICLE --}}
                                        {{-- ================================================= --}}

                                        <div>

                                            <h3 class="text-sm font-semibold text-gray-900">
                                                Vehicle
                                            </h3>

                                            <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-3">

                                                <div class="rounded-lg bg-gray-50 p-4">

                                                    <p class="text-xs text-gray-400">
                                                        Make
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                                        {{ $job->vehicle->make }}
                                                    </p>

                                                </div>


                                                <div class="rounded-lg bg-gray-50 p-4">

                                                    <p class="text-xs text-gray-400">
                                                        Model
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                                        {{ $job->vehicle->model ?: '—' }}
                                                    </p>

                                                </div>


                                                <div class="rounded-lg bg-gray-50 p-4">

                                                    <p class="text-xs text-gray-400">
                                                        Plate number
                                                    </p>

                                                    <p class="mt-1 text-sm font-medium text-gray-900">
                                                        {{ $job->vehicle->plate_number }}
                                                    </p>

                                                </div>

                                            </div>

                                        </div>


                                        {{-- ================================================= --}}
                                        {{-- SERVICES --}}
                                        {{-- ================================================= --}}

                                        <div>

                                            <h3 class="text-sm font-semibold text-gray-900">
                                                Services
                                            </h3>

                                            <div class="mt-3 overflow-hidden rounded-xl border border-gray-200">

                                                @forelse ($job->services as $service)

                                                    <div class="flex items-center justify-between gap-4 border-b border-gray-100 px-4 py-3 last:border-0">

                                                        <div class="min-w-0">

                                                            <p class="text-sm font-medium text-gray-900">
                                                                {{ $service->service_name }}
                                                            </p>

                                                            @if ($service->job_desc)

                                                                <p class="mt-0.5 text-xs text-gray-500">
                                                                    {{ $service->job_desc }}
                                                                </p>

                                                            @endif

                                                        </div>

                                                        <p class="shrink-0 text-sm font-medium text-gray-900">
                                                            ₱{{ number_format($service->price, 2) }}
                                                        </p>

                                                    </div>

                                                @empty

                                                    <div class="px-4 py-4 text-sm text-gray-500">
                                                        No services listed.
                                                    </div>

                                                @endforelse


                                                <div class="flex items-center justify-between border-t border-gray-200 bg-gray-50 px-4 py-3">

                                                    <p class="text-sm font-semibold text-gray-900">
                                                        Total
                                                    </p>

                                                    <p class="text-sm font-semibold text-gray-900">
                                                        ₱{{ number_format($job->total_cost, 2) }}
                                                    </p>

                                                </div>

                                            </div>

                                        </div>


                                        {{-- ================================================= --}}
                                        {{-- PROBLEM DESCRIPTION --}}
                                        {{-- ================================================= --}}

                                        <div>

                                            <h3 class="text-sm font-semibold text-gray-900">
                                                Problem description
                                            </h3>

                                            <div class="mt-3 rounded-xl border border-gray-200 bg-gray-50 p-4">

                                                <p class="whitespace-pre-line text-sm leading-6 text-gray-700">
                                                    {{ $job->problem_description }}
                                                </p>

                                            </div>

                                        </div>


                                        {{-- ================================================= --}}
                                        {{-- REMARKS --}}
                                        {{-- ================================================= --}}

                                        <div>

                                            <h3 class="text-sm font-semibold text-gray-900">
                                                Remarks
                                            </h3>

                                            <div class="mt-3 space-y-3">

                                                @if ($job->remarks)

                                                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                                                        <p class="text-xs font-medium text-gray-400">
                                                            Job order remarks
                                                        </p>

                                                        <p class="mt-1 whitespace-pre-line text-sm leading-6 text-gray-700">
                                                            {{ $job->remarks }}
                                                        </p>

                                                    </div>

                                                @endif


                                                @if ($assignmentRemarks->count())

                                                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                                                        <p class="text-xs font-medium text-gray-400">
                                                            Supervisor assignment remarks
                                                        </p>

                                                        @foreach ($assignmentRemarks as $remark)

                                                            <p class="mt-1 whitespace-pre-line text-sm leading-6 text-gray-700">
                                                                {{ $remark }}
                                                            </p>

                                                        @endforeach

                                                    </div>

                                                @endif


                                                @if (!$job->remarks && !$assignmentRemarks->count())

                                                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-4">

                                                        <p class="text-sm text-gray-400">
                                                            No remarks provided.
                                                        </p>

                                                    </div>

                                                @endif

                                            </div>

                                        </div>


                                        {{-- ================================================= --}}
                                        {{-- ASSIGNED MECHANICS --}}
                                        {{-- ================================================= --}}

                                        <div>

                                            <h3 class="text-sm font-semibold text-gray-900">
                                                Assigned mechanics
                                            </h3>

                                            <div class="mt-3 space-y-2">

                                                @forelse ($job->assignments as $assignment)

                                                    <div class="flex items-center gap-3 rounded-lg border border-gray-200 px-4 py-3">

                                                        <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100">

                                                            <i class="ti ti-tool text-gray-500"></i>

                                                        </div>

                                                        <div>

                                                            <p class="text-sm font-medium text-gray-900">

                                                                {{ $assignment->staff?->user?->name ?? 'Unknown mechanic' }}

                                                            </p>


                                                            @if ($assignment->assigned_date)

                                                                <p class="text-xs text-gray-500">

                                                                    Assigned
                                                                    {{ \Carbon\Carbon::parse($assignment->assigned_date)->format('M d, Y') }}

                                                                </p>

                                                            @endif

                                                        </div>

                                                    </div>

                                                @empty

                                                    <div class="rounded-lg border border-dashed border-gray-200 px-4 py-4">

                                                        <p class="text-sm text-gray-400">
                                                            No mechanic has been assigned yet.
                                                        </p>

                                                    </div>

                                                @endforelse

                                            </div>

                                        </div>


                                        {{-- ================================================= --}}
                                        {{-- APPROVAL HISTORY --}}
                                        {{-- ================================================= --}}

                                        @if ($job->approvals->count())

                                            <div>

                                                <h3 class="text-sm font-semibold text-gray-900">
                                                    Approval history
                                                </h3>

                                                <div class="mt-3 space-y-2">

                                                    @foreach ($job->approvals->sortByDesc('id') as $approval)

                                                        <div class="rounded-lg border border-gray-200 p-4">

                                                            <div class="flex items-center justify-between gap-3">

                                                                <span class="inline-flex rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700">

                                                                    {{ str_replace('_', ' ', ucwords($approval->status)) }}

                                                                </span>


                                                                @if ($approval->action_date)

                                                                    <span class="text-xs text-gray-400">

                                                                        {{ \Carbon\Carbon::parse($approval->action_date)->format('M d, Y') }}

                                                                    </span>

                                                                @endif

                                                            </div>


                                                            @if ($approval->remarks)

                                                                <p class="mt-2 whitespace-pre-line text-sm text-gray-600">
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

                            @endforeach

                        </div>


                        {{-- ================================================= --}}
                        {{-- MODAL FOOTER --}}
                        {{-- ================================================= --}}

                        <div class="flex justify-end border-t border-gray-100 px-6 py-4">

                            <button
                                type="button"
                                @click="viewOpen = false"
                                class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm font-medium text-gray-700 transition hover:bg-gray-50"
                            >
                                Close
                            </button>

                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>

</x-app-layout>