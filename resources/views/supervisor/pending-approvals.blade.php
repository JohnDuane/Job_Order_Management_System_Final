<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="min-h-screen lg:flex">

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
                    <div class="rounded-xl border border-gray-200 p-5">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                            <div>
                                <div class="flex gap-2 items-center">
                                    <b>{{ $job->code }}</b>
                                        <span class="rounded-md bg-yellow-50 text-yellow-700 px-2 py-1 text-xs">
                                            Pending approval
                                        </span>
                                </div>
                                <p class="text-sm mt-1">
                                    {{ $job->customer->first_name }} {{ $job->customer->last_name }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    {{ $job->vehicle->make }} · {{ $job->vehicle->plate_number }}
                                </p>
                                <p class="text-xs text-gray-400 mt-1">
                                    Submitted {{ $job->date_issued->format('M d, Y') }} by {{ $job->creator->name }}
                                </p>
                            </div>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('supervisor.job-orders.approve', $job) }}">
                                    @csrf<input type="hidden" name="remarks" value="Approved by supervisor" /><button
                                        class="rounded-lg bg-green-600 text-white px-3 py-2 text-sm"
                                        onclick="return confirm('Approve this job order?')"
                                    >
                                        Approve
                                    </button>
                                </form>

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
                                    />

                                    <button
                                        type="button"
                                        @click="open = true; error = false; remarks = ''"
                                        class="rounded-lg bg-red-600 text-white px-3 py-2 text-sm
                                            hover:bg-red-700 transition"
                                    >
                                        Needs revision
                                    </button>

                                    {{-- Modal --}}
                                    <div
                                        x-show="open"
                                        x-cloak
                                        class="fixed inset-0 z-50 bg-black/30 flex items-center justify-center p-4"
                                    >

                                        <div
                                            @click.outside="open = false"
                                            class="bg-white rounded-xl p-5 w-full max-w-md shadow-lg"
                                        >

                                            <h3 class="font-semibold text-gray-900">
                                                Return for revision
                                            </h3>

                                            <p class="text-sm text-gray-500 mt-1">
                                                Please provide a reason for returning this job order.
                                            </p>

                                            {{-- Remarks --}}
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

                                                {{-- Validation message --}}
                                                <p
                                                    x-show="error"
                                                    x-cloak
                                                    class="mt-1.5 text-sm text-red-600"
                                                >
                                                    Please provide a reason.
                                                </p>

                                            </div>

                                            {{-- Actions --}}
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
                                                    class="rounded-lg bg-red-600 text-white
                                                        px-4 py-2 text-sm
                                                        hover:bg-red-700 transition"
                                                >
                                                    Return
                                                </button>

                                            </div>

                                        </div>

                                    </div>

                                </form>
                            </div>
                        </div>
                        <div class="mt-4 border-t pt-3 text-sm text-gray-600">
                            <b>Services:</b> {{ $job->services->pluck('service_name')->join(', ') }} · <b>Total:</b> ₱{{
                            number_format($job->total_cost, 2) }}<br /><b>Problem:</b> {{ $job->problem_description }}
                        </div>
                    </div>
                    @empty
                    <div class="rounded-xl border border-dashed p-10 text-center text-gray-500">
                        No pending job orders.
                    </div>
                    @endforelse
                </div>
                <div class="mt-5">{{ $jobs->links() }}</div>
            </main>
        </div>
    </div>
</x-app-layout>
