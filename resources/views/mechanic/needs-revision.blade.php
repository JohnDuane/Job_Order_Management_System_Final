<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="flex min-h-screen">

            <x-mechanic-sidebar />

            <main class="flex-1 min-w-0 p-8">

                {{-- Header --}}
                <div class="mb-6">
                    <h1 class="text-2xl font-medium">
                        Needs Revision
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Review supervisor feedback and resubmit your job orders.
                    </p>
                </div>


                {{-- Search + Sort --}}
                <form
                    method="GET"
                    action="{{ route('mechanic.needs-revision') }}"
                    class="mb-6"
                >

                    <div class="flex flex-col md:flex-row gap-3">

                        {{-- Search --}}
                        <div class="relative flex-1">

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
                                class="w-full rounded-xl border border-gray-200 bg-white pl-10 pr-4 py-3 text-sm
                                       focus:border-gray-400 focus:ring-0"
                            >

                        </div>


                        {{-- Sort --}}
                        <select
                            name="sort"
                            onchange="this.form.submit()"
                            class="rounded-xl border border-gray-200 bg-white px-6 py-3 text-sm
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


                        {{-- Search button --}}
                        <button
                            type="submit"
                            class="rounded-xl bg-gray-900 px-5 py-3 text-sm font-medium text-white
                                   hover:bg-gray-800"
                        >
                            Search
                        </button>


                        {{-- Clear --}}
                        @if(request('search') || request('sort'))
                            <a
                                href="{{ route('mechanic.needs-revision') }}"
                                class="rounded-xl border border-gray-200 px-5 py-3 text-sm font-medium
                                       text-gray-700 hover:bg-gray-50 text-center"
                            >
                                Clear
                            </a>
                        @endif

                    </div>

                </form>


                {{-- Result information --}}
                @if($jobs->total() > 0)

                    <div class="mb-4 flex items-center justify-between">

                        <p class="text-sm text-gray-500">
                            Showing
                            <span class="font-medium text-gray-700">
                                {{ $jobs->firstItem() }}
                            </span>
                            -
                            <span class="font-medium text-gray-700">
                                {{ $jobs->lastItem() }}
                            </span>
                            of
                            <span class="font-medium text-gray-700">
                                {{ $jobs->total() }}
                            </span>
                            job orders
                        </p>

                    </div>

                @endif


                {{-- Job Order Cards --}}
                <div class="space-y-4">

                    @forelse($jobs as $job)

                        @php
                            $approval = $job->approvals->sortByDesc('id')->first();
                        @endphp


                        <div
                            class="rounded-xl border border-red-200 bg-white p-5
                                   shadow-sm hover:shadow-md transition"
                        >

                            {{-- Card Header --}}
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">

                                <div>

                                    <div class="flex items-center gap-3">

                                        <h2 class="font-semibold text-gray-900">
                                            {{ $job->code }}
                                        </h2>

                                        <span
                                            class="rounded-md bg-red-50 px-2.5 py-1
                                                   text-xs font-medium text-red-700"
                                        >
                                            Needs revision
                                        </span>

                                    </div>


                                    <p class="text-sm mt-2 text-gray-700">
                                        {{ $job->customer->first_name }}
                                        {{ $job->customer->last_name }}
                                    </p>


                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $job->vehicle->make }}
                                        ·
                                        {{ $job->vehicle->plate_number }}
                                    </p>

                                </div>

                            </div>


                            {{-- Supervisor Remarks --}}
                            <div
                                class="mt-4 rounded-lg bg-red-50 p-4
                                       text-sm text-red-700"
                            >

                                <div class="font-semibold mb-1">
                                    Supervisor remarks
                                </div>

                                <p>
                                    {{ $approval?->remarks ?? 'Please review the job order.' }}
                                </p>

                            </div>


                            {{-- Action --}}
                            <div class="mt-4 flex justify-end">

                                <a
                                    href="{{ route('mechanic.job-orders.edit', $job) }}"
                                    class="rounded-lg bg-gray-900 px-4 py-2
                                           text-sm font-medium text-white
                                           hover:bg-gray-800"
                                >
                                    Revise Job Order
                                </a>

                            </div>

                        </div>

                    @empty

                        <div
                            class="rounded-xl border border-gray-200
                                   bg-gray-50 p-10 text-center"
                        >

                            <div class="text-sm font-medium text-gray-700">
                                No job orders found.
                            </div>

                            <p class="mt-1 text-sm text-gray-500">
                                @if(request('search'))
                                    Try a different search term.
                                @else
                                    No job orders currently need revision.
                                @endif
                            </p>

                        </div>

                    @endforelse

                </div>


                {{-- Pagination --}}
                @if($jobs->hasPages())

                    <div class="mt-8">

                        {{ $jobs->links() }}

                    </div>

                @endif

            </main>

        </div>

    </div>

</x-app-layout>