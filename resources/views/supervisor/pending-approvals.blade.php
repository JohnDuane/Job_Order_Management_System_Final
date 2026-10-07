<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="min-h-screen md:flex">

            <x-supervisor-sidebar />

            <main class="min-w-0 flex-1 flex-col gap-6 p-4 sm:p-6 lg:p-8">

                <div class="mb-6">
                    <h1 class="text-2xl font-medium">Pending approvals</h1>
                    <p class="text-sm text-gray-500 mt-1">Review job orders submitted by mechanics.</p>
                </div>

                    {{-- Search + Filter --}}
                <form
                    method="GET"
                    action="{{ route('supervisor.pending-approvals') }}"
                    class="mb-6"
                >
                    <div class="flex flex-col md:flex-row gap-3">

                        {{-- Search --}}
                        <div class="relative flex-1 max-w-xl">

                            <svg
                                class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"
                                />
                            </svg>

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search job order, customer, plate number, or vehicle..."
                                class="w-full rounded-xl border border-gray-200 bg-white
                                    pl-10 pr-4 py-3 text-sm
                                    focus:border-gray-400 focus:ring-0"
                            >

                        </div>


                        {{-- Search Button --}}
                        <button
                            type="submit"
                            class="rounded-xl bg-gray-900 px-5 py-3
                                text-sm font-medium text-white
                                hover:bg-gray-800 transition"
                        >
                            Search
                        </button>


                        {{-- Filter --}}
                        <select
                            name="sort"
                            onchange="this.form.submit()"
                            class="rounded-xl border border-gray-200 bg-white
                                px-7 py-3 text-sm
                                focus:border-gray-400 focus:ring-0"
                        >

                            <option
                                value="newest"
                                {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}
                            >
                                Newest 
                            </option>

                            <option
                                value="oldest"
                                {{ request('sort') === 'oldest' ? 'selected' : '' }}
                            >
                                Oldest
                            </option>

                        </select>


                        {{-- Clear --}}
                        @if(request('search') || request('sort'))
                            <a
                                href="{{ route('supervisor.pending-approvals') }}"
                                class="rounded-xl border border-gray-200
                                    bg-white px-5 py-3
                                    text-sm font-medium text-gray-700
                                    hover:bg-gray-50 transition
                                    text-center"
                            >
                                Clear
                            </a>
                        @endif

                    </div>
                </form>
                <div class="space-y-4">
                    @forelse($jobs as $job)

                        @php
                            $statusClass = match ($job->status) {
                                'pending_approval' => 'bg-yellow-50 text-yellow-700 ring-yellow-600/20',
                                'approved' => 'bg-green-50 text-green-700 ring-green-600/20',
                                'assigned' => 'bg-blue-50 text-blue-700 ring-blue-600/20',
                                'in_progress' => 'bg-indigo-50 text-indigo-700 ring-indigo-600/20',
                                'completed' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
                                'needs_revision' => 'bg-red-50 text-red-700 ring-red-600/20',
                                default => 'bg-gray-50 text-gray-700 ring-gray-600/20',
                            };

                            $statusIcon = match ($job->status) {
                                'pending_approval' => 'ti-clock',
                                'approved' => 'ti-check',
                                'assigned' => 'ti-user-check',
                                'in_progress' => 'ti-loader',
                                'completed' => 'ti-circle-check',
                                'needs_revision' => 'ti-alert-circle',
                                default => 'ti-info-circle',
                            };
                        @endphp

                        <div
                            x-data="{ viewOpen: false }"
                            class="rounded-xl border border-gray-200 p-5"
                        >

                            {{-- ========================================= --}}
                            {{-- JOB ORDER CARD --}}
                            {{-- ========================================= --}}

                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

                                <div>

                                    <div class="flex flex-wrap items-center gap-2">

                                        <b class="text-gray-900">
                                            {{ $job->code }}
                                        </b>

                                        <span
                                            class="inline-flex items-center gap-1.5 rounded-md
                                                bg-yellow-50 px-2 py-1 text-xs
                                                font-medium text-yellow-700"
                                        >
                                            <i class="ti ti-clock"></i>
                                            Pending approval
                                        </span>

                                    </div>

                                    <p class="mt-1 text-sm text-gray-900">
                                        {{ $job->customer->first_name }}
                                        {{ $job->customer->last_name }}
                                    </p>

                                    <p class="text-xs text-gray-500">
                                        {{ $job->vehicle->make }}
                                        @if($job->vehicle->model)
                                            · {{ $job->vehicle->model }}
                                        @endif
                                        · {{ $job->vehicle->plate_number }}
                                    </p>

                                    <p class="mt-1 text-xs text-gray-400">
                                        Submitted
                                        {{ $job->date_issued->format('M d, Y') }}
                                        by
                                        {{ $job->creator->name }}
                                    </p>

                                </div>


                                {{-- ========================================= --}}
                                {{-- ACTIONS --}}
                                {{-- ========================================= --}}

                                <div class="flex flex-wrap gap-2">

                                    {{-- VIEW --}}
                                    <button
                                        type="button"
                                        @click="viewOpen = true"
                                        class="inline-flex items-center gap-1.5 rounded-lg
                                            border border-gray-200 bg-white px-3 py-2
                                            text-sm font-medium text-gray-700
                                            transition hover:bg-gray-50"
                                    >
                                        <i class="ti ti-eye"></i>
                                        View
                                    </button>


                                    {{-- APPROVE --}}
                                    <div
                                        x-data="{ open: false }"
                                    >
                                        <button
                                            type="button"
                                            @click="open = true"
                                            class="inline-flex items-center gap-1.5 rounded-lg
                                                bg-green-600 px-3 py-2 text-sm
                                                font-medium text-white
                                                transition hover:bg-green-700"
                                        >
                                            <i class="ti ti-check"></i>
                                            Approve
                                        </button>

                                        {{-- APPROVE CONFIRMATION MODAL --}}
                                        <div
                                            x-show="open"
                                            x-cloak
                                            x-transition.opacity
                                            class="fixed inset-0 z-[70] flex items-center justify-center bg-black/40 p-4"
                                        >

                                            <div
                                                x-show="open"
                                                x-transition
                                                @click.outside="open = false"
                                                class="w-full max-w-md rounded-2xl bg-white shadow-2xl"
                                            >

                                                {{-- Header --}}
                                                <div class="flex items-center justify-between border-b border-gray-100 px-6 py-5">

                                                    <div>
                                                        <h3 class="text-lg font-semibold text-gray-900">
                                                            Approve job order
                                                        </h3>

                                                        <p class="mt-1 text-sm text-gray-500">
                                                            Are you sure you want to approve
                                                            <span class="font-medium text-gray-700">
                                                                {{ $job->code }}
                                                            </span>?
                                                        </p>
                                                    </div>

                                                    <button
                                                        type="button"
                                                        @click="open = false"
                                                        class="rounded-lg p-1.5 text-gray-400
                                                            hover:bg-gray-100 hover:text-gray-700"
                                                    >
                                                        <i class="ti ti-x text-xl"></i>
                                                    </button>

                                                </div>

                                                {{-- Body --}}
                                                <div class="px-6 py-5">

                                                    <div class="flex gap-3 rounded-xl bg-green-50 p-4">

                                                        <div
                                                            class="flex h-10 w-10 shrink-0 items-center justify-center
                                                                rounded-full bg-green-100"
                                                        >
                                                            <i class="ti ti-check text-xl text-green-600"></i>
                                                        </div>

                                                        <div>
                                                            <p class="text-sm font-medium text-green-800">
                                                                Ready for approval
                                                            </p>

                                                            <p class="mt-1 text-sm leading-5 text-green-700">
                                                                Approving this job order will allow it to be assigned
                                                                to a mechanic.
                                                            </p>
                                                        </div>

                                                    </div>

                                                </div>

                                                {{-- Footer --}}
                                                <div class="flex justify-end gap-2 border-t border-gray-100 px-6 py-4">

                                                    <button
                                                        type="button"
                                                        @click="open = false"
                                                        class="rounded-lg border border-gray-200
                                                            px-4 py-2.5 text-sm font-medium
                                                            text-gray-700 hover:bg-gray-50"
                                                    >
                                                        Cancel
                                                    </button>

                                                    <form
                                                        method="POST"
                                                        action="{{ route('supervisor.job-orders.approve', $job) }}"
                                                    >
                                                        @csrf

                                                        <input
                                                            type="hidden"
                                                            name="remarks"
                                                            value="Approved by supervisor"
                                                        >

                                                        <button
                                                            type="submit"
                                                            class="rounded-lg bg-green-600
                                                                px-4 py-2.5 text-sm font-medium
                                                                text-white hover:bg-green-700"
                                                        >
                                                            Approve job order
                                                        </button>
                                                    </form>

                                                </div>

                                            </div>

                                        </div>
                                    </div>


                                    {{-- NEEDS REVISION --}}
                                    <form
                                        method="POST"
                                        action="{{ route('supervisor.job-orders.reject', $job) }}"
                                        x-data="{
                                            open: false,
                                            remarks: '',
                                            error: false,

                                            submitForm(event) {
                                                if (!this.remarks.trim()) {
                                                    event.preventDefault();

                                                    this.error = true;

                                                    this.$nextTick(() => {
                                                        this.$refs.text.focus();
                                                    });

                                                    return;
                                                }

                                                this.$refs.remarks.value = this.remarks;
                                            }
                                        }"
                                    >
                                        @csrf

                                        <input
                                            type="hidden"
                                            name="remarks"
                                            x-ref="remarks"
                                        >

                                        <button
                                            type="button"
                                            @click="open = true; error = false; remarks = ''"
                                            class="inline-flex items-center gap-1.5 rounded-lg
                                                bg-red-600 px-3 py-2 text-sm
                                                font-medium text-white
                                                transition hover:bg-red-700"
                                        >
                                            <i class="ti ti-edit"></i>
                                            Needs revision
                                        </button>


                                        {{-- REVISION MODAL --}}
                                        <div
                                            x-show="open"
                                            x-cloak
                                            class="fixed inset-0 z-[60] flex items-center
                                                justify-center bg-black/30 p-4"
                                        >

                                            <div
                                                @click.outside="open = false"
                                                class="w-full max-w-md rounded-xl bg-white p-5 shadow-xl"
                                            >

                                                <h3 class="font-semibold text-gray-900">
                                                    Return for revision
                                                </h3>

                                                <p class="mt-1 text-sm text-gray-500">
                                                    Please provide a reason for returning this job order.
                                                </p>

                                                <div class="mt-4">

                                                    <textarea
                                                        x-model="remarks"
                                                        x-ref="text"
                                                        rows="4"
                                                        @input="error = false"
                                                        :class="error
                                                            ? 'border-red-500 focus:border-red-500 focus:ring-red-500'
                                                            : 'border-gray-200 focus:border-gray-400 focus:ring-0'"
                                                        class="w-full rounded-lg border p-3 text-sm
                                                            focus:ring-1 transition"
                                                        placeholder="Explain what the mechanic must fix..."
                                                    ></textarea>

                                                    <p
                                                        x-show="error"
                                                        x-cloak
                                                        class="mt-1.5 text-sm text-red-600"
                                                    >
                                                        Please provide a reason.
                                                    </p>

                                                </div>

                                                <div class="mt-4 flex justify-end gap-2">

                                                    <button
                                                        type="button"
                                                        @click="open = false"
                                                        class="rounded-lg border border-gray-200
                                                            px-4 py-2 text-sm text-gray-700
                                                            hover:bg-gray-50"
                                                    >
                                                        Cancel
                                                    </button>

                                                    <button
                                                        type="submit"
                                                        @click="submitForm($event)"
                                                        class="rounded-lg bg-red-600 px-4 py-2
                                                            text-sm text-white hover:bg-red-700"
                                                    >
                                                        Return
                                                    </button>

                                                </div>

                                            </div>

                                        </div>

                                    </form>

                                </div>

                            </div>


                            {{-- ========================================= --}}
                            {{-- CARD SUMMARY --}}
                            {{-- ========================================= --}}

                            <div class="mt-4 border-t pt-3 text-sm text-gray-600">

                                <b>Services:</b>
                                {{ $job->services->pluck('service_name')->join(', ') }}

                                <span class="mx-1 text-gray-300">·</span>

                                <b>Total:</b>
                                ₱{{ number_format($job->total_cost, 2) }}

                                <br>

                                <b>Problem:</b>
                                {{ $job->problem_description }}

                            </div>


                            {{-- ========================================================= --}}
                            {{-- VIEW JOB ORDER MODAL --}}
                            {{-- ========================================================= --}}

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
                                        flex-col overflow-hidden rounded-2xl
                                        bg-white shadow-2xl"
                                >

                                    {{-- ========================================= --}}
                                    {{-- MODAL HEADER --}}
                                    {{-- ========================================= --}}

                                    <div
                                        class="flex items-start justify-between
                                            border-b border-gray-100 px-6 py-5"
                                    >

                                        <div>

                                            <div class="flex flex-wrap items-center gap-3">

                                                <h2 class="text-lg font-semibold text-gray-900">
                                                    Job order {{ $job->code }}
                                                </h2>

                                                <span
                                                    class="inline-flex items-center gap-1.5
                                                        rounded-md px-2.5 py-1 text-xs
                                                        font-medium ring-1 ring-inset
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
                                            class="rounded-lg p-1.5 text-gray-400
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


                                            {{-- ================================= --}}
                                            {{-- CUSTOMER --}}
                                            {{-- ================================= --}}

                                            <div>

                                                <h3 class="text-sm font-semibold text-gray-900">
                                                    Customer
                                                </h3>

                                                <div
                                                    class="mt-3 rounded-xl border
                                                        border-gray-200 p-4"
                                                >

                                                    <div class="flex items-center gap-3">

                                                        <div
                                                            class="flex h-10 w-10 shrink-0
                                                                items-center justify-center
                                                                rounded-full bg-gray-100"
                                                        >
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


                                            {{-- ================================= --}}
                                            {{-- VEHICLE --}}
                                            {{-- ================================= --}}

                                            <div>

                                                <h3 class="text-sm font-semibold text-gray-900">
                                                    Vehicle
                                                </h3>

                                                <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-3">

                                                    <div class="rounded-lg bg-gray-50 p-4">

                                                        <p class="text-xs text-gray-400">
                                                            Make
                                                        </p>

                                                        <p class="mt-1 text-sm font-medium">
                                                            {{ $job->vehicle->make }}
                                                        </p>

                                                    </div>


                                                    <div class="rounded-lg bg-gray-50 p-4">

                                                        <p class="text-xs text-gray-400">
                                                            Model
                                                        </p>

                                                        <p class="mt-1 text-sm font-medium">
                                                            {{ $job->vehicle->model ?: '—' }}
                                                        </p>

                                                    </div>


                                                    <div class="rounded-lg bg-gray-50 p-4">

                                                        <p class="text-xs text-gray-400">
                                                            Plate number
                                                        </p>

                                                        <p class="mt-1 text-sm font-medium">
                                                            {{ $job->vehicle->plate_number }}
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

                                                <div
                                                    class="mt-3 overflow-hidden rounded-xl
                                                        border border-gray-200"
                                                >

                                                    @forelse ($job->services as $service)

                                                        <div
                                                            class="flex items-center justify-between
                                                                gap-4 border-b border-gray-100
                                                                px-4 py-3 last:border-0"
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
                                                        class="flex items-center justify-between
                                                            border-t border-gray-200
                                                            bg-gray-50 px-4 py-3"
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
                                            {{-- PROBLEM DESCRIPTION --}}
                                            {{-- ================================= --}}

                                            <div>

                                                <h3 class="text-sm font-semibold text-gray-900">
                                                    Problem description
                                                </h3>

                                                <div
                                                    class="mt-3 rounded-xl border
                                                        border-gray-200 bg-gray-50 p-4"
                                                >

                                                    <p
                                                        class="whitespace-pre-line
                                                            text-sm leading-6 text-gray-700"
                                                    >
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

                                                <div class="mt-3 space-y-3">

                                                    @php
                                                        $assignmentRemarks = $job->assignments
                                                            ->pluck('remarks')
                                                            ->filter()
                                                            ->unique()
                                                            ->values();
                                                    @endphp


                                                    @if ($job->remarks)

                                                        <div
                                                            class="rounded-xl border border-gray-200
                                                                bg-gray-50 p-4"
                                                        >

                                                            <p class="text-xs font-medium text-gray-400">
                                                                Job order remarks
                                                            </p>

                                                            <p
                                                                class="mt-1 whitespace-pre-line
                                                                    text-sm leading-6 text-gray-700"
                                                            >
                                                                {{ $job->remarks }}
                                                            </p>

                                                        </div>

                                                    @endif


                                                    @if ($assignmentRemarks->count())

                                                        <div
                                                            class="rounded-xl border border-gray-200
                                                                bg-gray-50 p-4"
                                                        >

                                                            <p class="text-xs font-medium text-gray-400">
                                                                Supervisor assignment remarks
                                                            </p>

                                                            @foreach ($assignmentRemarks as $remark)

                                                                <p
                                                                    class="mt-1 whitespace-pre-line
                                                                        text-sm leading-6 text-gray-700"
                                                                >
                                                                    {{ $remark }}
                                                                </p>

                                                            @endforeach

                                                        </div>

                                                    @endif


                                                    @if (!$job->remarks && !$assignmentRemarks->count())

                                                        <div
                                                            class="rounded-xl border border-gray-200
                                                                bg-gray-50 p-4"
                                                        >
                                                            <p class="text-sm text-gray-400">
                                                                No remarks provided.
                                                            </p>
                                                        </div>

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
                                                            class="flex items-center gap-3
                                                                rounded-lg border border-gray-200
                                                                px-4 py-3"
                                                        >

                                                            <div
                                                                class="flex h-9 w-9 shrink-0
                                                                    items-center justify-center
                                                                    rounded-full bg-gray-100"
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
                                                            class="rounded-lg border border-dashed
                                                                border-gray-200 px-4 py-4"
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

                                            @if ($job->approvals->count())

                                                <div>

                                                    <h3 class="text-sm font-semibold text-gray-900">
                                                        Approval history
                                                    </h3>

                                                    <div class="mt-3 space-y-2">

                                                        @foreach ($job->approvals->sortByDesc('id') as $approval)

                                                            <div
                                                                class="rounded-lg border
                                                                    border-gray-200 p-4"
                                                            >

                                                                <div
                                                                    class="flex items-center
                                                                        justify-between gap-3"
                                                                >

                                                                    <span
                                                                        class="inline-flex rounded-md
                                                                            bg-gray-100 px-2 py-1
                                                                            text-xs font-medium"
                                                                    >
                                                                        {{ str_replace('_', ' ', ucwords($approval->status)) }}
                                                                    </span>

                                                                    @if ($approval->action_date)

                                                                        <span class="text-xs text-gray-400">
                                                                            {{ \Carbon\Carbon::parse($approval->action_date)->format('M d, Y') }}
                                                                        </span>

                                                                    @endif

                                                                </div>


                                                                @if ($approval->remarks)

                                                                    <p
                                                                        class="mt-2 whitespace-pre-line
                                                                            text-sm text-gray-600"
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
                                        class="flex justify-end border-t
                                            border-gray-100 px-6 py-4"
                                    >

                                        <button
                                            type="button"
                                            @click="viewOpen = false"
                                            class="rounded-lg border border-gray-200
                                                px-4 py-2.5 text-sm font-medium
                                                text-gray-700 transition hover:bg-gray-50"
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
                                p-10 text-center text-gray-500"
                        >
                            No pending job orders.
                        </div>

                    @endforelse
                </div>
                <div class="mt-5">{{ $jobs->links() }}</div>


                {{-- ========================================================= --}}
                {{-- APPROVAL SUCCESS / ASSIGN MECHANIC MODAL --}}
                {{-- ========================================================= --}}

                <div
                    x-data="{
                        open: {{ session()->has('approval_success') ? 'true' : 'false' }}
                    }"
                    x-show="open"
                    x-cloak
                    x-transition.opacity
                    @keydown.escape.window="open = false"
                    class="fixed inset-0 z-[80] flex items-center justify-center bg-black/40 p-4"
                >

                    <div
                        x-show="open"
                        x-transition
                        @click.outside="open = false"
                        class="w-full max-w-md rounded-2xl bg-white shadow-2xl"
                    >

                        {{-- HEADER --}}
                        <div class="flex items-start justify-between border-b border-gray-100 px-6 py-5">

                            <div class="flex items-center gap-3">

                                <div
                                    class="flex h-11 w-11 shrink-0 items-center justify-center
                                        rounded-full bg-green-100"
                                >
                                    <i class="ti ti-check text-2xl text-green-600"></i>
                                </div>

                                <div>

                                    <h3 class="text-lg font-semibold text-gray-900">
                                        Job order approved
                                    </h3>

                                    @if(session('approval_success'))
                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ session('approval_success.code') }}
                                            has been approved successfully.
                                        </p>
                                    @endif

                                </div>

                            </div>

                            <button
                                type="button"
                                @click="open = false"
                                class="rounded-lg p-1.5 text-gray-400
                                    transition hover:bg-gray-100 hover:text-gray-700"
                            >
                                <i class="ti ti-x text-xl"></i>
                            </button>

                        </div>


                        {{-- BODY --}}
                        <div class="px-6 py-6">

                            <div class="rounded-xl bg-gray-50 p-4">

                                <div class="flex items-start gap-3">

                                    <i class="ti ti-user-plus mt-0.5 text-xl text-gray-500"></i>

                                    <div>

                                        <p class="text-sm font-medium text-gray-900">
                                            Would you like to assign a mechanic?
                                        </p>

                                        <p class="mt-1 text-sm leading-5 text-gray-500">
                                            This approved job order is now ready to be assigned
                                            to a mechanic.
                                        </p>

                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- FOOTER --}}
                        <div class="flex justify-end gap-2 border-t border-gray-100 px-6 py-4">

                            <button
                                type="button"
                                @click="open = false"
                                class="rounded-lg border border-gray-200
                                    px-4 py-2.5 text-sm font-medium
                                    text-gray-700 transition hover:bg-gray-50"
                            >
                                Not now
                            </button>


                            @if(session('approval_success'))

                                <a
                                    href="{{ route(
                                        'supervisor.assign-mechanic',
                                        ['job_order_id' => session('approval_success.job_order_id')]
                                    ) }}"
                                    class="inline-flex items-center gap-1.5
                                        rounded-lg bg-gray-900
                                        px-4 py-2.5 text-sm font-medium
                                        text-white transition hover:bg-gray-800"
                                >
                                    <i class="ti ti-user-plus"></i>
                                    Assign mechanic
                                </a>

                            @endif

                        </div>

                    </div>

                </div>






            </main>
        </div>
    </div>
</x-app-layout>
