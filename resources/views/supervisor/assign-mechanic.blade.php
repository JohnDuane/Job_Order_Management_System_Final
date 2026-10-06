<x-app-layout>
    <div class="min-h-screen bg-white text-gray-900">
        <div class="min-h-screen md:flex">

            {{-- Sidebar --}}

            <x-supervisor-sidebar />

            <main class="min-w-0 flex-1 flex-col gap-6 p-4 sm:p-6 lg:p-8">

                {{-- Header --}}
                <div class="mb-6">
                    <h1 class="text-2xl font-semibold">
                        Assign Mechanic
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Assign approved job orders to one or more mechanics.
                    </p>
                </div>


                {{-- Success / Error Messages --}}
                @if(session('success'))
                    <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        {{ session('error') }}
                    </div>
                @endif


                {{-- Search and Filters --}}
                <form
                    method="GET"
                    action="{{ route('supervisor.assign-mechanic') }}"
                    class="mb-6"
                >

                    <div class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm">

                        <div class="flex flex-col lg:flex-row gap-3">

                            {{-- Search --}}
                            <div class="flex-1">
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Search
                                </label>

                                <div class="relative">

                                    <svg
                                        class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6.04 6.04a7.5 7.5 0 0 0 10.61 10.61Z"
                                        />
                                    </svg>

                                    <input
                                        type="text"
                                        name="search"
                                        value="{{ request('search') }}"
                                        placeholder="Search job order or customer..."
                                        class="w-full rounded-lg border border-gray-300 pl-9 pr-3 py-2.5 text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                                    >

                                </div>
                            </div>


                            {{-- Status --}}
                            <div class="w-full lg:w-48">
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Status
                                </label>

                                <select
                                    name="status"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                                >
                                    <option value="">
                                        All statuses
                                    </option>

                                    <option
                                        value="approved"
                                        @selected(request('status') === 'approved')
                                    >
                                        Not yet assigned
                                    </option>

                                    <option
                                        value="assigned"
                                        @selected(request('status') === 'assigned')
                                    >
                                        Assigned
                                    </option>

                                </select>
                            </div>


                            {{-- Sort --}}
                            <div class="w-full lg:w-44">
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Sort
                                </label>

                                <select
                                    name="sort"
                                    class="w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                                >
                                    <option
                                        value="newest"
                                        @selected(request('sort', 'newest') === 'newest')
                                    >
                                        Newest first
                                    </option>

                                    <option
                                        value="oldest"
                                        @selected(request('sort') === 'oldest')
                                    >
                                        Oldest first
                                    </option>
                                </select>
                            </div>


                            {{-- Buttons --}}
                            <div class="flex items-end gap-2">

                                <button
                                    type="submit"
                                    class="rounded-lg bg-gray-900 px-5 py-2.5 text-sm font-medium text-white hover:bg-gray-800 transition"
                                >
                                    Search
                                </button>

                                @if(request()->filled('search') || request()->filled('status') || request()->filled('sort'))
                                    <a
                                        href="{{ route('supervisor.assign-mechanic') }}"
                                        class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 transition"
                                    >
                                        Clear
                                    </a>
                                @endif

                            </div>

                        </div>

                    </div>

                </form>


                {{-- Result Count --}}
                <div class="flex items-center justify-between mb-4">

                    <p class="text-sm text-gray-500">
                        Showing
                        <span class="font-medium text-gray-800">
                            {{ $jobs->firstItem() ?? 0 }}
                        </span>

                        to

                        <span class="font-medium text-gray-800">
                            {{ $jobs->lastItem() ?? 0 }}
                        </span>

                        of

                        <span class="font-medium text-gray-800">
                            {{ $jobs->total() }}
                        </span>

                        job orders
                    </p>

                </div>


                {{-- Job Orders --}}
                <div class="space-y-4">

                    @forelse($jobs as $job)

                        <div
                            class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm"
                            x-data="{ open: false }"
                        >

                            <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-4">

                                {{-- Job Information --}}
                                <div class="min-w-0">

                                    <div class="flex flex-wrap items-center gap-2">

                                        <span class="font-semibold text-gray-900">
                                            {{ $job->code }}
                                        </span>

                                        @php
                                            $statusClasses = match($job->status) {
                                                'approved' => 'bg-blue-50 text-blue-700 border-blue-200',
                                                'assigned' => 'bg-purple-50 text-purple-700 border-purple-200',
                                                default => 'bg-gray-50 text-gray-700 border-gray-200',
                                            };
                                        @endphp

                                        <span
                                            class="inline-flex items-center rounded-full border px-2.5 py-1 text-xs font-medium {{ $statusClasses }}"
                                        >
                                            {{ str_replace('_', ' ', ucwords($job->status)) }}
                                        </span>

                                    </div>


                                    <p class="text-sm font-medium text-gray-800 mt-2">
                                        {{ $job->customer->first_name }}
                                        {{ $job->customer->last_name }}
                                    </p>


                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $job->vehicle->make }}
                                        ·
                                        {{ $job->vehicle->model ?? '' }}
                                        ·
                                        {{ $job->vehicle->plate_number }}
                                    </p>


                                    @if($job->services->count())
                                        <p class="text-xs text-gray-500 mt-2">
                                            Services:
                                            {{ $job->services->pluck('service_name')->join(', ') }}
                                        </p>
                                    @endif

                                </div>


                                {{-- Assign Button --}}
                                <div class="shrink-0">

                                    <button
                                        type="button"
                                        @click="open=true"
                                        class="rounded-lg bg-gray-900 text-white px-4 py-2.5 text-sm font-medium hover:bg-gray-800 transition"
                                    >
                                        {{ $job->status === 'assigned' ? 'Reassign' : 'Assign mechanic' }}
                                    </button>

                                </div>

                            </div>


                            {{-- Current Assignment --}}
                            <div class="mt-4 pt-4 border-t border-gray-100">

                                <p class="text-xs text-gray-500">
                                    Current mechanic{{ $job->assignments->count() > 1 ? 's' : '' }}
                                </p>

                                <p class="text-sm text-gray-800 mt-1">

                                    @php
                                        $assignedMechanics = $job->assignments
                                            ->map(fn($a) => $a->staff?->user?->name)
                                            ->filter()
                                            ->join(', ');
                                    @endphp

                                    {{ $assignedMechanics ?: 'Not assigned' }}

                                </p>

                            </div>


                            {{-- Assignment Modal --}}
                            <div
                                x-show="open"
                                x-cloak
                                class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4"
                            >

                                <div
                                    @click.outside="open=false"
                                    class="w-full max-w-lg rounded-2xl bg-white shadow-xl"
                                >

                                    <form
                                        method="POST"
                                        action="{{ route('supervisor.job-orders.assign', $job) }}"
                                    >

                                        @csrf


                                        {{-- Modal Header --}}
                                        <div class="px-6 py-5 border-b border-gray-100">

                                            <h3 class="text-lg font-semibold text-gray-900">
                                                Assign {{ $job->code }}
                                            </h3>

                                            <p class="text-xs text-gray-500 mt-1">
                                                Select the mechanic(s) responsible for this job.
                                            </p>

                                        </div>


                                        {{-- Mechanics --}}
                                        <div class="px-6 py-5">

                                            <div class="space-y-2 max-h-64 overflow-y-auto">

                                                @forelse ($mechanics as $m)

                                                    <label
                                                        class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 cursor-pointer hover:bg-gray-50"
                                                    >

                                                        <input
                                                            type="checkbox"
                                                            name="staff_ids[]"
                                                            value="{{ $m->staff_id }}"
                                                            @checked($job->assignments->contains('staff_id', $m->staff_id))
                                                            class="rounded border-gray-300 text-gray-900 focus:ring-gray-900"
                                                        >

                                                        <div>
                                                            <p class="text-sm font-medium text-gray-800">
                                                                {{ $m->user->name }}
                                                            </p>

                                                            <p class="text-xs text-gray-500">
                                                                Mechanic
                                                            </p>
                                                        </div>

                                                    </label>

                                                @empty

                                                    <div class="rounded-lg bg-gray-50 p-4 text-sm text-gray-500">
                                                        No mechanics are currently available.
                                                    </div>

                                                @endforelse

                                            </div>


                                            {{-- Remarks --}}
                                            <div class="mt-4">

                                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                                    Assignment remarks
                                                </label>

                                                <textarea
                                                    name="remarks"
                                                    rows="3"
                                                    class="w-full rounded-lg border border-gray-300 p-3 text-sm focus:border-gray-500 focus:ring-1 focus:ring-gray-500"
                                                    placeholder="Optional assignment remarks"
                                                ></textarea>

                                            </div>

                                        </div>


                                        {{-- Modal Footer --}}
                                        <div class="flex justify-end gap-2 px-6 py-4 border-t border-gray-100">

                                            <button
                                                type="button"
                                                @click="open=false"
                                                class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                            >
                                                Cancel
                                            </button>

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                                            >
                                                Save assignment
                                            </button>

                                        </div>

                                    </form>

                                </div>

                            </div>

                        </div>

                    @empty

                        {{-- Empty State --}}
                        <div class="rounded-xl border border-dashed border-gray-300 p-12 text-center">

                            <div class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100">

                                <svg
                                    class="h-6 w-6 text-gray-400"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1 0 6.04 6.04a7.5 7.5 0 0 0 10.61 10.61Z"
                                    />
                                </svg>

                            </div>

                            <p class="font-medium text-gray-700">
                                No job orders found
                            </p>

                            <p class="text-sm text-gray-500 mt-1">
                                Try changing your search or filter criteria.
                            </p>

                            @if(request()->filled('search') || request()->filled('status'))

                                <a
                                    href="{{ route('supervisor.assign-mechanic') }}"
                                    class="inline-block mt-4 text-sm font-medium text-gray-900 underline"
                                >
                                    Clear filters
                                </a>

                            @endif

                        </div>

                    @endforelse

                </div>


                {{-- Pagination --}}
                @if($jobs->hasPages())

                    <div class="mt-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">

                        <p class="text-sm text-gray-500">
                            Page {{ $jobs->currentPage() }}
                            of
                            {{ $jobs->lastPage() }}
                        </p>

                        <div>
                            {{ $jobs->links() }}
                        </div>

                    </div>

                @endif

            </main>

        </div>
    </div>
</x-app-layout>