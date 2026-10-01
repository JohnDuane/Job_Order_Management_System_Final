<x-app-layout>

    <div
        class="min-h-screen bg-white text-gray-900"
        x-data="{
            showConfirmModal: false,
            isSubmitting: false
        }"
    >

        <div class="flex min-h-screen">

            <x-mechanic-sidebar />

            <main class="flex-1 min-w-0 p-8">

                {{-- Header --}}
                <div class="mb-6">

                    <h1 class="text-2xl font-medium">
                        {{ isset($jobOrder) ? 'Revise job order' : 'Create job order' }}
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ isset($jobOrder)
                            ? 'Update the requested details and resubmit for approval.'
                            : 'Create a new job order for a customer vehicle.' }}
                    </p>

                </div>


                {{-- Validation Errors --}}
                @if ($errors->any())

                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

                        <b>Please correct the following:</b>

                        <ul class="mt-1 list-disc pl-5">

                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                {{-- Form --}}
                <form
                    x-ref="jobOrderForm"
                    method="POST"
                    action="{{ isset($jobOrder)
                        ? route('mechanic.job-orders.update', $jobOrder)
                        : route('mechanic.job-orders.store') }}"
                    class="max-w-4xl flex flex-col gap-5"
                    x-data="{
                        customer: '{{ old('cust_id', $jobOrder->cust_id ?? '') }}'
                    }"
                    @submit.prevent="showConfirmModal = true"
                >

                    @csrf

                    @if (isset($jobOrder))
                        @method('PUT')
                    @endif


                    {{-- Customer and Vehicle --}}
                    <div class="bg-white border border-gray-200 rounded-xl p-5">

                        <p class="font-medium">
                            Customer and vehicle
                        </p>

                        <p class="text-xs text-gray-500 mt-1 mb-5">
                            Select the customer and vehicle for this job order.
                        </p>


                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            {{-- Customer --}}
                            <div>

                                <label class="block text-sm font-medium mb-1.5">
                                    Customer
                                </label>

                                <select
                                    name="cust_id"
                                    x-model="customer"
                                    required
                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-2 focus:ring-gray-100"
                                >

                                    <option value="">
                                        Select customer
                                    </option>

                                    @foreach ($customers as $c)

                                        <option value="{{ $c->cust_id }}">
                                            {{ $c->first_name }} {{ $c->last_name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Vehicle --}}
                            <div>

                                <label class="block text-sm font-medium mb-1.5">
                                    Vehicle
                                </label>

                                <select
                                    name="vehicle_id"
                                    required
                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-2 focus:ring-gray-100"
                                >

                                    <option value="">
                                        Select vehicle
                                    </option>

                                    @foreach ($customers as $c)

                                        @foreach ($c->vehicles as $v)

                                            <option
                                                value="{{ $v->vehicle_id }}"
                                                x-show="customer == '{{ $c->cust_id }}'"
                                            >
                                                {{ $v->make }} · {{ $v->plate_number }}
                                            </option>

                                        @endforeach

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>


                    {{-- Service Details --}}
                    <div class="bg-white border border-gray-200 rounded-xl p-5">

                        <p class="font-medium">
                            Service details
                        </p>

                        <p class="text-xs text-gray-500 mt-1 mb-5">
                            Select one or more services and describe the problem.
                        </p>


                        {{-- Services --}}
                        <div class="mb-4">

                            <label class="block text-sm font-medium mb-1.5">
                                Services
                            </label>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">

                                @foreach ($services as $service)

                                    <label
                                        class="flex items-center gap-3 rounded-lg border border-gray-200 p-3 hover:bg-gray-50 cursor-pointer"
                                    >

                                        <input
                                            type="checkbox"
                                            name="service_ids[]"
                                            value="{{ $service->service_id }}"
                                            @checked(
                                                in_array(
                                                    $service->service_id,
                                                    old(
                                                        'service_ids',
                                                        isset($jobOrder)
                                                            ? $jobOrder->services->pluck('service_id')->all()
                                                            : []
                                                    )
                                                )
                                            )
                                            class="rounded border-gray-300 text-gray-900 focus:ring-gray-200"
                                        >

                                        <span class="flex-1 text-sm">
                                            {{ $service->service_name }}
                                        </span>

                                        <span class="text-xs text-gray-500">
                                            ₱{{ number_format($service->price, 2) }}
                                        </span>

                                    </label>

                                @endforeach

                            </div>

                        </div>


                        {{-- Problem Description --}}
                        <div class="mb-4">

                            <label class="block text-sm font-medium mb-1.5">
                                Problem description
                            </label>

                            <textarea
                                name="problem_description"
                                rows="4"
                                required
                                class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg resize-none focus:border-gray-400 focus:ring-2 focus:ring-gray-100"
                                placeholder="Describe the customer's reported vehicle problem..."
                            >{{ old('problem_description', $jobOrder->problem_description ?? '') }}</textarea>

                        </div>


                        {{-- Expected Completion + Remarks --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                            <div>

                                <label class="block text-sm font-medium mb-1.5">
                                    Expected completion
                                </label>

                                <input
                                    type="date"
                                    name="expected_empl_date"
                                    value="{{ old(
                                        'expected_empl_date',
                                        isset($jobOrder) && $jobOrder->expected_empl_date
                                            ? $jobOrder->expected_empl_date->format('Y-m-d')
                                            : ''
                                    ) }}"
                                    min="{{ now()->toDateString() }}"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-2 focus:ring-gray-100"
                                >

                            </div>


                            <div>

                                <label class="block text-sm font-medium mb-1.5">
                                    Remarks
                                </label>

                                <input
                                    name="remarks"
                                    value="{{ old('remarks', $jobOrder->remarks ?? '') }}"
                                    class="w-full px-3 py-2.5 text-sm border border-gray-200 rounded-lg focus:border-gray-400 focus:ring-2 focus:ring-gray-100"
                                    placeholder="Optional remarks"
                                >

                            </div>

                        </div>

                    </div>


                    {{-- Form Actions --}}
                    <div class="flex justify-end gap-2">

                        <a
                            href="{{ route('mechanic.MJO') }}"
                            class="rounded-lg border border-gray-200 px-4 py-2.5 text-sm hover:bg-gray-50 transition"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="rounded-lg bg-gray-900 text-white px-4 py-2.5 text-sm hover:bg-gray-800 transition"
                        >
                            {{ isset($jobOrder)
                                ? 'Resubmit for approval'
                                : 'Submit for approval' }}
                        </button>

                    </div>

                </form>

            </main>

        </div>


        {{-- ========================================================= --}}
        {{-- CONFIRMATION MODAL --}}
        {{-- ========================================================= --}}

        <div
            x-show="showConfirmModal"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center p-4"
            @keydown.escape.window="showConfirmModal = false"
        >

            {{-- Backdrop --}}
            <div
                class="absolute inset-0 bg-black/40 backdrop-blur-[1px]"
                @click="showConfirmModal = false"
            ></div>


            {{-- Modal --}}
            <div
                x-show="showConfirmModal"
                x-transition:enter="ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="relative w-full max-w-md rounded-2xl bg-white shadow-2xl border border-gray-200"
                @click.stop
            >

                {{-- Modal Content --}}
                <div class="p-6">

                    {{-- Icon --}}
                    <div class="flex items-center justify-center mb-4">

                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-red-50">

                            <i class="ti ti-send text-xl text-red-600"></i>

                        </div>

                    </div>


                    {{-- Title --}}
                    <h2 class="text-center text-lg font-medium text-gray-900">

                        {{ isset($jobOrder)
                            ? 'Resubmit job order?'
                            : 'Submit job order?' }}

                    </h2>


                    {{-- Description --}}
                    <p class="mt-2 text-center text-sm leading-6 text-gray-500">

                        {{ isset($jobOrder)
                            ? 'This revised job order will be sent back to the supervisor for approval.'
                            : 'This job order will be submitted to the supervisor for approval.' }}

                    </p>


                    {{-- Notice --}}
                    <div class="mt-4 rounded-lg border border-gray-200 bg-gray-50 px-4 py-3">

                        <div class="flex gap-3">

                            <i class="ti ti-info-circle mt-0.5 text-gray-500"></i>

                            <p class="text-xs leading-5 text-gray-600">
                                Please make sure the customer, vehicle, selected services,
                                and problem description are correct before continuing.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Modal Actions --}}
                <div class="flex items-center justify-end gap-2 border-t border-gray-100 px-6 py-4">

                    {{-- Cancel --}}
                    <button
                        type="button"
                        @click="showConfirmModal = false"
                        :disabled="isSubmitting"
                        class="rounded-lg border border-gray-200 bg-white px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition disabled:opacity-50"
                    >
                        Cancel
                    </button>


                    {{-- Confirm --}}
                    <button
                        type="button"
                        @click="
                            isSubmitting = true;
                            showConfirmModal = false;
                            document.querySelector('form[x-ref=jobOrderForm]').submit();
                        "
                        :disabled="isSubmitting"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm text-white hover:bg-gray-800 transition disabled:cursor-not-allowed disabled:opacity-60"
                    >

                        <template x-if="!isSubmitting">

                            <span class="inline-flex items-center gap-2">

                                <i class="ti ti-check"></i>

                                {{ isset($jobOrder)
                                    ? 'Yes, resubmit'
                                    : 'Yes, submit' }}

                            </span>

                        </template>


                        <template x-if="isSubmitting">

                            <span class="inline-flex items-center gap-2">

                                <i class="ti ti-loader-2 animate-spin"></i>

                                Submitting...

                            </span>

                        </template>

                    </button>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>