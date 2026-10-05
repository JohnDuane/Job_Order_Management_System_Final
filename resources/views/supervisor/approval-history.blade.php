<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="flex min-h-screen">

            <x-supervisor-sidebar />

            <main class="flex-1 min-w-0 p-8">

                {{-- ========================================================= --}}
                {{-- HEADER --}}
                {{-- ========================================================= --}}

                <div class="mb-6">

                    <h1 class="text-2xl font-medium">
                        Approval history
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        A record of supervisor approval and revision decisions.
                    </p>

                </div>


                {{-- ========================================================= --}}
                {{-- SEARCH + FILTER --}}
                {{-- ========================================================= --}}

                <form
                    method="GET"
                    action="{{ route('supervisor.approval-history') }}"
                    class="mb-6"
                >

                    <div class="flex flex-col lg:flex-row gap-3">

                        {{-- Search --}}
                        <div class="flex-1">

                            <div class="relative">

                                <input
                                    type="text"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search job order or customer..."
                                    class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                                >

                            </div>

                        </div>


                        {{-- Decision Filter --}}
                        <div>

                            <select
                                name="status"
                                class="w-full lg:w-48 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                            >

                                <option value="">
                                    All decisions
                                </option>

                                <option
                                    value="approved"
                                    @selected(request('status') === 'approved')
                                >
                                    Approved
                                </option>

                                <option
                                    value="needs_revision"
                                    @selected(request('status') === 'needs_revision')
                                >
                                    Needs Revision
                                </option>

                            </select>

                        </div>


                        {{-- Sort --}}
                        <div>

                            <select
                                name="sort"
                                class="w-full lg:w-40 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm focus:border-gray-900 focus:ring-1 focus:ring-gray-900"
                            >

                                <option value="latest">
                                    Newest
                                </option>

                                <option
                                    value="oldest"
                                    @selected(request('sort') === 'oldest')
                                >
                                    Oldest
                                </option>

                            </select>

                        </div>


                        {{-- Search --}}
                        <button
                            type="submit"
                            class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800"
                        >
                            Search
                        </button>


                        {{-- Clear --}}
                        @if(request()->hasAny(['search', 'status', 'sort']))

                            <a
                                href="{{ route('supervisor.approval-history') }}"
                                class="rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 text-center"
                            >
                                Clear
                            </a>

                        @endif

                    </div>

                </form>


                {{-- ========================================================= --}}
                {{-- RESULTS INFO --}}
                {{-- ========================================================= --}}

                @if(request('search') || request('status'))

                    <div class="mb-4 text-sm text-gray-500">

                        Showing
                        <span class="font-medium text-gray-900">
                            {{ $approvals->count() }}
                        </span>

                        of

                        <span class="font-medium text-gray-900">
                            {{ $approvals->total() }}
                        </span>

                        approval records.

                    </div>

                @endif


                {{-- ========================================================= --}}
                {{-- TABLE --}}
                {{-- ========================================================= --}}

                <div class="overflow-x-auto rounded-xl border border-gray-200">

                    <table class="w-full text-sm">

                        <thead>

                            <tr class="border-b bg-gray-50 text-left text-gray-500">

                                <th class="p-4">
                                    JO
                                </th>

                                <th class="p-4">
                                    Created By
                                </th>

                                <th class="p-4">
                                    Customer
                                </th>

                                <th class="p-4">
                                    Decision
                                </th>

                                <th class="p-4">
                                    Supervisor
                                </th>

                                <th class="p-4">
                                    Date
                                </th>

                                <th class="p-4 text-center">
                                    Action
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($approvals as $a)

                                @php

                                    $job = $a->jobOrder;

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Status styling
                                    |--------------------------------------------------------------------------
                                    */

                                    if ($job?->status === 'approved') {

                                        $statusClasses =
                                            'bg-green-50 text-green-700 ring-green-600/20';

                                        $statusIcon = 'ti-circle-check';

                                    } elseif ($job?->status === 'needs_revision') {

                                        $statusClasses =
                                            'bg-red-50 text-red-700 ring-red-600/20';

                                        $statusIcon = 'ti-edit';

                                    } elseif ($job?->status === 'pending_approval') {

                                        $statusClasses =
                                            'bg-yellow-50 text-yellow-700 ring-yellow-600/20';

                                        $statusIcon = 'ti-clock';

                                    } elseif ($job?->status === 'assigned') {

                                        $statusClasses =
                                            'bg-blue-50 text-blue-700 ring-blue-600/20';

                                        $statusIcon = 'ti-user-check';

                                    } elseif ($job?->status === 'in_progress') {

                                        $statusClasses =
                                            'bg-purple-50 text-purple-700 ring-purple-600/20';

                                        $statusIcon = 'ti-tool';

                                    } elseif ($job?->status === 'completed') {

                                        $statusClasses =
                                            'bg-green-50 text-green-700 ring-green-600/20';

                                        $statusIcon = 'ti-check';

                                    } else {

                                        $statusClasses =
                                            'bg-gray-100 text-gray-700 ring-gray-500/20';

                                        $statusIcon = 'ti-file';

                                    }

                                @endphp


                                {{-- ================================================= --}}
                                {{-- TABLE ROW --}}
                                {{-- ================================================= --}}

                                <tr
                                    class="border-b last:border-0 hover:bg-gray-50"
                                    x-data="{ viewOpen: false }"
                                >

                                    {{-- Job Order --}}
                                    <td class="p-4 font-medium text-gray-900">

                                        {{ $job?->code ?? 'Unknown JO' }}

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- CREATED BY --}}
                                    {{-- ================================================= --}}

                                    <td class="p-4">

                                        <div class="flex items-center gap-2">

                                            <div
                                                class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gray-100"
                                            >

                                                <i class="ti ti-user text-sm text-gray-500"></i>

                                            </div>

                                            <div class="min-w-0">

                                                <p class="truncate font-medium text-gray-900">

                                                    {{ $job?->creator?->name ?? 'Unknown user' }}

                                                </p>

                                                <p class="text-xs text-gray-400">

                                                    {{ ucfirst($job?->creator?->role ?? 'Unknown') }}

                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- Customer --}}
                                    <td class="p-4">

                                        {{ $job?->customer?->first_name ?? '' }}
                                        {{ $job?->customer?->last_name ?? '' }}

                                    </td>


                                    {{-- Decision --}}
                                    <td class="p-4">

                                        @if($a->status === 'approved')

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700"
                                            >

                                                <i class="ti ti-circle-check"></i>

                                                Approved

                                            </span>

                                        @elseif($a->status === 'needs_revision')

                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700"
                                            >

                                                <i class="ti ti-edit"></i>

                                                Needs Revision

                                            </span>

                                        @else

                                            <span
                                                class="inline-flex rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700"
                                            >

                                                {{ str_replace('_', ' ', ucwords($a->status)) }}

                                            </span>

                                        @endif

                                    </td>


                                    {{-- Supervisor --}}
                                    <td class="p-4">

                                        {{ $a->approvedBy?->name ?? 'Unknown supervisor' }}

                                    </td>


                                    {{-- Date --}}
                                    <td class="p-4">

                                        {{ $a->action_date
                                            ? \Carbon\Carbon::parse($a->action_date)->format('M d, Y')
                                            : '—'
                                        }}

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- VIEW JOB ORDER --}}
                                    {{-- ================================================= --}}

                                    <td class="p-4 text-center">

                                        <button
                                            type="button"
                                            @click="viewOpen = true"
                                            class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50 hover:text-gray-900"
                                        >

                                            <i class="ti ti-eye"></i>

                                            View Job Order

                                        </button>


                                        {{-- ================================================= --}}
                                        {{-- JOB ORDER MODAL --}}
                                        {{-- ================================================= --}}

                                        <template x-teleport="body">

                                            <div
                                                x-show="viewOpen"
                                                x-cloak
                                                x-transition.opacity
                                                @keydown.escape.window="viewOpen = false"
                                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 px-4 py-6 text-left"
                                            >

                                                <div
                                                    x-show="viewOpen"
                                                    x-transition
                                                    @click.outside="viewOpen = false"
                                                    class="flex max-h-[90vh] w-full max-w-3xl flex-col overflow-hidden rounded-2xl bg-white shadow-2xl"
                                                >

                                                    {{-- ========================================= --}}
                                                    {{-- MODAL HEADER --}}
                                                    {{-- ========================================= --}}

                                                    <div
                                                        class="flex shrink-0 items-start justify-between border-b border-gray-100 px-6 py-5"
                                                    >

                                                        <div>

                                                            <div class="flex items-center gap-3">

                                                                <h2 class="text-lg font-semibold text-gray-900">

                                                                    Job order {{ $job->code }}

                                                                </h2>


                                                                <span
                                                                    class="inline-flex items-center gap-1.5 rounded-md px-2.5 py-1 text-xs font-medium ring-1 ring-inset {{ $statusClasses }}"
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
                                                            class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-700"
                                                        >

                                                            <i class="ti ti-x text-xl"></i>

                                                        </button>

                                                    </div>


                                                    {{-- ========================================= --}}
                                                    {{-- MODAL BODY --}}
                                                    {{-- ========================================= --}}

                                                    <div class="min-h-0 flex-1 overflow-y-auto">

                                                        <div class="space-y-6 p-6">


                                                            {{-- ================================= --}}
                                                            {{-- BASIC INFORMATION --}}
                                                            {{-- ================================= --}}

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

                                                                            {{ $job->date_issued
                                                                                ? \Carbon\Carbon::parse($job->date_issued)->format('F d, Y')
                                                                                : '—'
                                                                            }}

                                                                        </p>

                                                                    </div>


                                                                    <div class="rounded-lg bg-gray-50 p-4">

                                                                        <p class="text-xs text-gray-400">
                                                                            Expected completion
                                                                        </p>

                                                                        <p class="mt-1 text-sm font-medium text-gray-900">

                                                                            @if ($job->expected_empl_date)

                                                                                {{ \Carbon\Carbon::parse($job->expected_empl_date)->format('F d, Y') }}

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


                                                            {{-- ================================= --}}
                                                            {{-- CREATED BY --}}
                                                            {{-- ================================= --}}

                                                            <div>

                                                                <h3 class="text-sm font-semibold text-gray-900">
                                                                    Created by
                                                                </h3>


                                                                <div class="mt-3 rounded-xl border border-gray-200 p-4">

                                                                    <div class="flex items-center gap-3">

                                                                        <div
                                                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100"
                                                                        >

                                                                            <i class="ti ti-user text-lg text-gray-500"></i>

                                                                        </div>


                                                                        <div>

                                                                            <p class="text-sm font-medium text-gray-900">

                                                                                {{ $job->creator?->name ?? 'Unknown user' }}

                                                                            </p>


                                                                            <p class="text-xs text-gray-500">

                                                                                {{ ucfirst($job->creator?->role ?? 'Unknown role') }}

                                                                            </p>

                                                                        </div>

                                                                    </div>

                                                                </div>

                                                            </div>


                                                            {{-- ================================= --}}
                                                            {{-- CUSTOMER --}}
                                                            {{-- ================================= --}}

                                                            <div>

                                                                <h3 class="text-sm font-semibold text-gray-900">
                                                                    Customer
                                                                </h3>


                                                                <div class="mt-3 rounded-xl border border-gray-200 p-4">

                                                                    <div class="flex items-center gap-3">

                                                                        <div
                                                                            class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100"
                                                                        >

                                                                            <i class="ti ti-user text-lg text-gray-500"></i>

                                                                        </div>


                                                                        <div>

                                                                            <p class="text-sm font-medium text-gray-900">

                                                                                {{ $job->customer?->first_name }}
                                                                                {{ $job->customer?->last_name }}

                                                                            </p>


                                                                            @if ($job->customer?->email)

                                                                                <p class="text-xs text-gray-500">

                                                                                    {{ $job->customer->email }}

                                                                                </p>

                                                                            @endif


                                                                            @if ($job->customer?->contact_number)

                                                                                <p class="text-xs text-gray-500">

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

                                                                <h3 class="text-sm font-semibold text-gray-900">
                                                                    Vehicle
                                                                </h3>


                                                                <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">

                                                                    <div class="rounded-lg bg-gray-50 p-4">

                                                                        <p class="text-xs text-gray-400">
                                                                            Make
                                                                        </p>

                                                                        <p class="mt-1 text-sm font-medium">
                                                                            {{ $job->vehicle?->make ?: '—' }}
                                                                        </p>

                                                                    </div>


                                                                    <div class="rounded-lg bg-gray-50 p-4">

                                                                        <p class="text-xs text-gray-400">
                                                                            Plate number
                                                                        </p>

                                                                        <p class="mt-1 text-sm font-medium">
                                                                            {{ $job->vehicle?->plate_number ?: '—' }}
                                                                        </p>

                                                                    </div>

                                                                </div>

                                                            </div>


                                                            {{-- ================================= --}}
                                                            {{-- SERVICES --}}
                                                            {{-- ================================= --}}

                                                            <div>

                                                                <h3 class="text-sm font-semibold text-gray-900">
                                                                    Services
                                                                </h3>


                                                                <div class="mt-3 overflow-hidden rounded-xl border border-gray-200">

                                                                    @forelse ($job->services as $service)

                                                                        <div
                                                                            class="flex items-center justify-between gap-4 border-b border-gray-100 px-4 py-3 last:border-0"
                                                                        >

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


                                                                    <div
                                                                        class="flex items-center justify-between border-t border-gray-200 bg-gray-50 px-4 py-3"
                                                                    >

                                                                        <p class="text-sm font-semibold text-gray-900">
                                                                            Total
                                                                        </p>

                                                                        <p class="text-sm font-semibold text-gray-900">

                                                                            ₱{{ number_format($job->total_cost, 2) }}

                                                                        </p>

                                                                    </div>

                                                                </div>

                                                            </div>


                                                            {{-- ================================= --}}
                                                            {{-- PROBLEM --}}
                                                            {{-- ================================= --}}

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


                                                            {{-- ================================= --}}
                                                            {{-- REMARKS --}}
                                                            {{-- ================================= --}}

                                                            <div>

                                                                <h3 class="text-sm font-semibold text-gray-900">
                                                                    Remarks
                                                                </h3>


                                                                <div class="mt-3 rounded-xl border border-gray-200 bg-gray-50 p-4">

                                                                    @if ($job->remarks)

                                                                        <p class="whitespace-pre-line text-sm leading-6 text-gray-700">

                                                                            {{ $job->remarks }}

                                                                        </p>

                                                                    @else

                                                                        <p class="text-sm text-gray-400">
                                                                            No remarks provided.
                                                                        </p>

                                                                    @endif

                                                                </div>

                                                            </div>


                                                            {{-- ================================= --}}
                                                            {{-- ASSIGNED MECHANICS --}}
                                                            {{-- ================================= --}}

                                                            <div>

                                                                <h3 class="text-sm font-semibold text-gray-900">
                                                                    Assigned mechanics
                                                                </h3>


                                                                <div class="mt-3 space-y-2">

                                                                    @forelse ($job->assignments as $assignment)

                                                                        <div
                                                                            class="flex items-center gap-3 rounded-lg border border-gray-200 px-4 py-3"
                                                                        >

                                                                            <div
                                                                                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100"
                                                                            >

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

                                                                        <div
                                                                            class="rounded-lg border border-dashed border-gray-200 px-4 py-4"
                                                                        >

                                                                            <p class="text-sm text-gray-400">

                                                                                No mechanic has been assigned yet.

                                                                            </p>

                                                                        </div>

                                                                    @endforelse

                                                                </div>

                                                            </div>


                                                            {{-- ================================= --}}
                                                            {{-- APPROVAL HISTORY --}}
                                                            {{-- ================================= --}}

                                                            <div>

                                                                <h3 class="text-sm font-semibold text-gray-900">
                                                                    Approval history
                                                                </h3>


                                                                @if ($job->approvals->count())

                                                                    <div class="mt-3 space-y-2">

                                                                        @foreach ($job->approvals->sortByDesc('id') as $approval)

                                                                            <div
                                                                                class="rounded-lg border border-gray-200 p-4"
                                                                            >

                                                                                <div
                                                                                    class="flex items-center justify-between gap-3"
                                                                                >

                                                                                    <span
                                                                                        class="inline-flex rounded-md px-2 py-1 text-xs font-medium
                                                                                        {{ $approval->status === 'approved'
                                                                                            ? 'bg-green-50 text-green-700'
                                                                                            : 'bg-red-50 text-red-700'
                                                                                        }}"
                                                                                    >

                                                                                        {{ str_replace('_', ' ', ucwords($approval->status)) }}

                                                                                    </span>


                                                                                    @if ($approval->action_date)

                                                                                        <span class="text-xs text-gray-400">

                                                                                            {{ \Carbon\Carbon::parse($approval->action_date)->format('M d, Y') }}

                                                                                        </span>

                                                                                    @endif

                                                                                </div>


                                                                                @if ($approval->approvedBy)

                                                                                    <p class="mt-2 text-xs text-gray-500">

                                                                                        Action by:

                                                                                        <span class="font-medium text-gray-700">

                                                                                            {{ $approval->approvedBy->name }}

                                                                                        </span>

                                                                                    </p>

                                                                                @endif


                                                                                @if ($approval->remarks)

                                                                                    <p class="mt-2 text-sm leading-5 text-gray-600">

                                                                                        {{ $approval->remarks }}

                                                                                    </p>

                                                                                @endif

                                                                            </div>

                                                                        @endforeach

                                                                    </div>

                                                                @else

                                                                    <div
                                                                        class="mt-3 rounded-lg border border-dashed border-gray-200 px-4 py-4"
                                                                    >

                                                                        <p class="text-sm text-gray-400">
                                                                            No approval history yet.
                                                                        </p>

                                                                    </div>

                                                                @endif

                                                            </div>

                                                        </div>

                                                    </div>


                                                    {{-- ========================================= --}}
                                                    {{-- MODAL FOOTER --}}
                                                    {{-- ========================================= --}}

                                                    <div
                                                        class="flex shrink-0 justify-end border-t border-gray-100 bg-white px-6 py-4"
                                                    >

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

                                        </template>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="7"
                                        class="p-10 text-center text-gray-500"
                                    >

                                        @if(request('search') || request('status'))

                                            No approval records match your search or filter.

                                        @else

                                            No approval history yet.

                                        @endif

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- ========================================================= --}}
                {{-- PAGINATION --}}
                {{-- ========================================================= --}}

                <div class="mt-5">

                    {{ $approvals->links() }}

                </div>

            </main>

        </div>

    </div>

</x-app-layout>