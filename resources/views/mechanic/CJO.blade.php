<x-app-layout>

    <div
        class="min-h-screen bg-white text-gray-900"
        x-data="{
            showConfirmModal: false,
            isSubmitting: false
        }"
    >

        <div class="min-h-screen md:flex">

            <x-mechanic-sidebar />

            <main class="min-w-0 flex-1 flex-col gap-6 p-4 sm:p-6 lg:p-8">

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
                    {{-- ========================================================= --}}
                    {{-- CUSTOMER AND VEHICLE --}}
                    {{-- ========================================================= --}}

                    <div
                        class="bg-white border border-gray-200 rounded-xl p-5"
                        x-data="{
                            customerOpen: false,
                            vehicleOpen: false,

                            customerSearch: '',
                            vehicleSearch: '',

                            customer: '{{ old('cust_id', $jobOrder->cust_id ?? '') }}',
                            vehicle: '{{ old('vehicle_id', $jobOrder->vehicle_id ?? '') }}',

                            customers: @js(
                                $customers->map(function ($c) {
                                    return [
                                        'id' => (string) $c->cust_id,
                                        'name' => $c->first_name . ' ' . $c->last_name,
                                        'vehicles' => $c->vehicles->map(function ($v) {
                                            return [
                                                'id' => (string) $v->vehicle_id,
                                                'make' => $v->make,
                                                'plate' => $v->plate_number,
                                            ];
                                        })->values(),
                                    ];
                                })->values()
                            ),

                            get selectedCustomer() {
                                return this.customers.find(
                                    c => c.id === String(this.customer)
                                );
                            },

                            get selectedVehicle() {
                                if (!this.selectedCustomer) return null;

                                return this.selectedCustomer.vehicles.find(
                                    v => v.id === String(this.vehicle)
                                );
                            },

                            get filteredCustomers() {
                                const search = this.customerSearch.toLowerCase().trim();

                                if (!search) return this.customers;

                                return this.customers.filter(customer =>
                                    customer.name.toLowerCase().includes(search)
                                );
                            },

                            get filteredVehicles() {
                                if (!this.selectedCustomer) return [];

                                const search = this.vehicleSearch.toLowerCase().trim();

                                if (!search) return this.selectedCustomer.vehicles;

                                return this.selectedCustomer.vehicles.filter(vehicle =>
                                    `${vehicle.make} ${vehicle.plate}`
                                        .toLowerCase()
                                        .includes(search)
                                );
                            },

                            selectCustomer(customer) {
                                this.customer = customer.id;

                                // Reset vehicle whenever customer changes
                                this.vehicle = '';
                                this.vehicleSearch = '';

                                this.customerSearch = customer.name;
                                this.customerOpen = false;

                                this.$nextTick(() => {
                                    this.vehicleOpen = true;
                                });
                            },

                            selectVehicle(vehicle) {
                                this.vehicle = vehicle.id;

                                this.vehicleSearch =
                                    `${vehicle.make} · ${vehicle.plate}`;

                                this.vehicleOpen = false;
                            }
                        }"
                    >

                        <p class="font-medium">
                            Customer and vehicle
                        </p>

                        <p class="text-xs text-gray-500 mt-1 mb-5">
                            Search and select the customer and their vehicle for this job order.
                        </p>


                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">


                            {{-- ================================================= --}}
                            {{-- CUSTOMER --}}
                            {{-- ================================================= --}}

                            <div class="relative">

                                <label class="block text-sm font-medium mb-1.5">
                                    Customer
                                </label>

                                {{-- Hidden actual form value --}}
                                <input
                                    type="hidden"
                                    name="cust_id"
                                    x-model="customer"
                                >

                                {{-- Search / Selected Customer --}}
                                <div class="relative">

                                    <i
                                        class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                                    ></i>

                                    <input
                                        type="text"
                                        x-model="customerSearch"
                                        @focus="customerOpen = true"
                                        @click="customerOpen = true"
                                        @input="customerOpen = true"
                                        @keydown.escape="customerOpen = false"
                                        placeholder="Search customer..."
                                        autocomplete="off"
                                        class="w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-9 pr-10 text-sm focus:border-gray-400 focus:ring-2 focus:ring-gray-100"
                                    >

                                    <button
                                        type="button"
                                        x-show="customer"
                                        x-cloak
                                        @click="
                                            customer = '';
                                            customerSearch = '';
                                            vehicle = '';
                                            vehicleSearch = '';
                                        "
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700"
                                    >
                                        <i class="ti ti-x"></i>
                                    </button>

                                    <i
                                        x-show="!customer"
                                        class="ti ti-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                                    ></i>

                                </div>


                                {{-- Customer Dropdown --}}
                                <div
                                    x-show="customerOpen"
                                    x-cloak
                                    @click.outside="customerOpen = false"
                                    x-transition
                                    class="absolute z-40 mt-1 w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg"
                                >

                                    {{-- Results --}}
                                    <div class="max-h-60 overflow-y-auto">

                                        <template x-if="filteredCustomers.length === 0">

                                            <div class="px-4 py-6 text-center">

                                                <i class="ti ti-user-off text-2xl text-gray-300"></i>

                                                <p class="mt-2 text-sm text-gray-500">
                                                    No customers found.
                                                </p>

                                            </div>

                                        </template>


                                        <template
                                            x-for="customerItem in filteredCustomers"
                                            :key="customerItem.id"
                                        >

                                            <button
                                                type="button"
                                                @click="selectCustomer(customerItem)"
                                                class="flex w-full items-center gap-3 px-4 py-3 text-left hover:bg-gray-50 transition"
                                                :class="customer == customerItem.id ? 'bg-gray-50' : ''"
                                            >

                                                {{-- Avatar --}}
                                                <div
                                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-600"
                                                >
                                                    <i class="ti ti-user"></i>
                                                </div>


                                                {{-- Customer Info --}}
                                                <div class="min-w-0 flex-1">

                                                    <p
                                                        class="truncate text-sm font-medium text-gray-900"
                                                        x-text="customerItem.name"
                                                    ></p>

                                                    <p
                                                        class="text-xs text-gray-500"
                                                    >
                                                        <span
                                                            x-text="customerItem.vehicles.length"
                                                        ></span>

                                                        vehicle<span
                                                            x-show="customerItem.vehicles.length !== 1"
                                                        >s</span>
                                                    </p>

                                                </div>


                                                {{-- Selected --}}
                                                <i
                                                    x-show="customer == customerItem.id"
                                                    class="ti ti-check text-gray-700"
                                                ></i>

                                            </button>

                                        </template>

                                    </div>

                                </div>

                            </div>


                            {{-- ================================================= --}}
                            {{-- VEHICLE --}}
                            {{-- ================================================= --}}

                            <div class="relative">

                                <label class="block text-sm font-medium mb-1.5">
                                    Vehicle
                                </label>

                                {{-- Hidden actual form value --}}
                                <input
                                    type="hidden"
                                    name="vehicle_id"
                                    x-model="vehicle"
                                >


                                {{-- Vehicle Search --}}
                                <div class="relative">

                                    <i
                                        class="ti ti-car absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                                    ></i>

                                    <input
                                        type="text"
                                        x-model="vehicleSearch"
                                        @focus="selectedCustomer && (vehicleOpen = true)"
                                        @click="selectedCustomer && (vehicleOpen = true)"
                                        @keydown.escape="vehicleOpen = false"
                                        :disabled="!selectedCustomer"
                                        :placeholder="
                                            selectedCustomer
                                                ? 'Search vehicle or plate...'
                                                : 'Select a customer first'
                                        "
                                        autocomplete="off"
                                        class="w-full rounded-lg border border-gray-200 bg-white py-2.5 pl-9 pr-10 text-sm focus:border-gray-400 focus:ring-2 focus:ring-gray-100 disabled:bg-gray-50 disabled:text-gray-400 disabled:cursor-not-allowed"
                                    >

                                    <button
                                        type="button"
                                        x-show="vehicle"
                                        x-cloak
                                        @click="
                                            vehicle = '';
                                            vehicleSearch = '';
                                        "
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700"
                                    >
                                        <i class="ti ti-x"></i>
                                    </button>

                                    <i
                                        x-show="!vehicle && selectedCustomer"
                                        class="ti ti-chevron-down absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"
                                    ></i>

                                </div>


                                {{-- Vehicle Dropdown --}}
                                <div
                                    x-show="vehicleOpen && selectedCustomer"
                                    x-cloak
                                    @click.outside="vehicleOpen = false"
                                    x-transition
                                    class="absolute z-30 mt-1 w-full overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg"
                                >

                                    <div class="max-h-60 overflow-y-auto">

                                        {{-- No vehicles --}}
                                        <template x-if="filteredVehicles.length === 0">

                                            <div class="px-4 py-6 text-center">

                                                <i class="ti ti-car-off text-2xl text-gray-300"></i>

                                                <p class="mt-2 text-sm text-gray-500">
                                                    No vehicles found.
                                                </p>

                                            </div>

                                        </template>


                                        {{-- Vehicles --}}
                                        <template
                                            x-for="vehicleItem in filteredVehicles"
                                            :key="vehicleItem.id"
                                        >

                                            <button
                                                type="button"
                                                @click="selectVehicle(vehicleItem)"
                                                class="flex w-full items-center gap-3 px-4 py-3 text-left hover:bg-gray-50 transition"
                                                :class="vehicle == vehicleItem.id ? 'bg-gray-50' : ''"
                                            >

                                                {{-- Vehicle Icon --}}
                                                <div
                                                    class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100 text-gray-600"
                                                >
                                                    <i class="ti ti-car"></i>
                                                </div>


                                                {{-- Vehicle Info --}}
                                                <div class="min-w-0 flex-1">

                                                    <p
                                                        class="text-sm font-medium text-gray-900"
                                                        x-text="vehicleItem.make"
                                                    ></p>

                                                    <p
                                                        class="text-xs text-gray-500"
                                                        x-text="vehicleItem.plate"
                                                    ></p>

                                                </div>


                                                {{-- Selected --}}
                                                <i
                                                    x-show="vehicle == vehicleItem.id"
                                                    class="ti ti-check text-gray-700"
                                                ></i>

                                            </button>

                                        </template>

                                    </div>

                                </div>

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