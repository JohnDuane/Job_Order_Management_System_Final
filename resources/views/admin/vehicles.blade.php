<x-app-layout>

    <div
        class="min-h-screen bg-white text-gray-900"
        x-data="vehicleTable()"
    >

        <div class="min-h-screen lg:flex">

            {{-- Admin Sidebar --}}
            <x-admin-sidebar />


            {{-- Main Content --}}
            <main class="min-w-0 flex-1 flex-col gap-6 p-4 sm:p-6 lg:p-8">

                {{-- Header --}}
                <div class="mb-6 flex items-start justify-between gap-4">

                    <div>
                        <h1 class="text-2xl font-medium">
                            Vehicles
                        </h1>

                        <p class="mt-1 text-sm text-gray-500">
                            Manage registered customer vehicles
                        </p>
                    </div>


                    {{-- Add Vehicle --}}
                    <a
                        href="{{ route('admin.users.addvehicles') }}"
                        class="inline-flex shrink-0 items-center gap-2
                               rounded-lg bg-gray-900 px-4 py-2.5
                               text-sm font-medium text-white
                               transition hover:bg-gray-800"
                    >
                        <i class="ti ti-car"></i>
                        Add vehicle
                    </a>

                </div>


                {{-- Search + Filter --}}
                <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center">

                    {{-- Search --}}
                    <div class="relative w-full sm:max-w-md">

                        <i
                            class="ti ti-search absolute left-3 top-1/2
                                   -translate-y-1/2 text-gray-400"
                        ></i>

                        <input
                            type="text"
                            x-model="search"
                            placeholder="Search vehicles..."
                            class="w-full rounded-lg border border-gray-200
                                   bg-white py-2.5 pl-9 pr-3 text-sm
                                   text-gray-900 placeholder:text-gray-400
                                   focus:border-gray-300 focus:outline-none
                                   focus:ring-2 focus:ring-gray-100"
                        >

                    </div>


                    {{-- Filter --}}
                    <div
                        class="relative"
                        x-data="{ open: false }"
                    >

                        <button
                            type="button"
                            @click="open = !open"
                            class="inline-flex w-full items-center justify-center
                                   gap-2 rounded-lg border border-gray-200
                                   bg-white px-3 py-2.5 text-sm text-gray-600
                                   transition hover:bg-gray-50
                                   sm:w-auto"
                        >

                            <i class="ti ti-filter text-base"></i>

                            <span>Filter</span>

                            <i
                                class="ti ti-chevron-down text-xs transition-transform"
                                :class="{ 'rotate-180': open }"
                            ></i>

                        </button>


                        {{-- Filter Dropdown --}}
                        <div
                            x-show="open"
                            x-transition
                            @click.outside="open = false"
                            class="absolute left-0 z-30 mt-2 w-52
                                   rounded-xl border border-gray-200
                                   bg-white p-2 shadow-lg
                                   sm:left-auto sm:right-0"
                        >

                            <p
                                class="px-3 py-2 text-xs font-medium
                                       uppercase tracking-wide text-gray-400"
                            >
                                Sort vehicles
                            </p>


                            {{-- A-Z --}}
                            <button
                                type="button"
                                @click="
                                    sort = 'az';
                                    open = false;
                                "
                                class="flex w-full items-center gap-3
                                       rounded-lg px-3 py-2 text-sm
                                       text-gray-700 transition hover:bg-gray-50"
                                :class="{ 'bg-gray-50': sort === 'az' }"
                            >

                                <i
                                    class="ti ti-sort-ascending
                                           text-base text-gray-400"
                                ></i>

                                <span>A–Z</span>

                                <i
                                    x-show="sort === 'az'"
                                    class="ti ti-check ml-auto text-sm"
                                ></i>

                            </button>


                            {{-- Z-A --}}
                            <button
                                type="button"
                                @click="
                                    sort = 'za';
                                    open = false;
                                "
                                class="flex w-full items-center gap-3
                                       rounded-lg px-3 py-2 text-sm
                                       text-gray-700 transition hover:bg-gray-50"
                                :class="{ 'bg-gray-50': sort === 'za' }"
                            >

                                <i
                                    class="ti ti-sort-descending
                                           text-base text-gray-400"
                                ></i>

                                <span>Z–A</span>

                                <i
                                    x-show="sort === 'za'"
                                    class="ti ti-check ml-auto text-sm"
                                ></i>

                            </button>


                            <div class="my-1 border-t border-gray-100"></div>


                            {{-- By Make --}}
                            <button
                                type="button"
                                @click="
                                    sort = 'make';
                                    open = false;
                                "
                                class="flex w-full items-center gap-3
                                       rounded-lg px-3 py-2 text-sm
                                       text-gray-700 transition hover:bg-gray-50"
                                :class="{ 'bg-gray-50': sort === 'make' }"
                            >

                                <i
                                    class="ti ti-car
                                           text-base text-gray-400"
                                ></i>

                                <span>By make</span>

                                <i
                                    x-show="sort === 'make'"
                                    class="ti ti-check ml-auto text-sm"
                                ></i>

                            </button>


                            {{-- By Owner --}}
                            <button
                                type="button"
                                @click="
                                    sort = 'owner';
                                    open = false;
                                "
                                class="flex w-full items-center gap-3
                                       rounded-lg px-3 py-2 text-sm
                                       text-gray-700 transition hover:bg-gray-50"
                                :class="{ 'bg-gray-50': sort === 'owner' }"
                            >

                                <i
                                    class="ti ti-user
                                           text-base text-gray-400"
                                ></i>

                                <span>By owner</span>

                                <i
                                    x-show="sort === 'owner'"
                                    class="ti ti-check ml-auto text-sm"
                                ></i>

                            </button>


                            <div class="my-1 border-t border-gray-100"></div>


                            {{-- Reset --}}
                            <button
                                type="button"
                                @click="
                                    search = '';
                                    sort = 'az';
                                    open = false;
                                "
                                class="flex w-full items-center gap-3
                                       rounded-lg px-3 py-2 text-sm
                                       text-gray-500 transition hover:bg-gray-50"
                            >

                                <i
                                    class="ti ti-refresh
                                           text-base text-gray-400"
                                ></i>

                                Reset

                            </button>

                        </div>

                    </div>

                </div>


                {{-- Vehicle Table --}}
                <div
                    class="overflow-hidden rounded-xl border
                           border-gray-200 bg-white"
                >

                    {{-- Table Header --}}
                    <div
                        class="flex items-center justify-between
                               border-b border-gray-100 px-5 py-4"
                    >

                        <div>

                            <p class="font-medium">
                                Vehicle records
                            </p>

                            <p class="mt-1 text-xs text-gray-500">

                                <span
                                    x-text="filteredVehicles.length"
                                ></span>

                                <span
                                    x-text="filteredVehicles.length === 1
                                        ? ' vehicle'
                                        : ' vehicles'"
                                ></span>

                            </p>

                        </div>


                        {{-- Search Indicator --}}
                        <div
                            x-show="search.trim() !== ''"
                            x-transition
                            class="hidden items-center gap-2
                                   text-xs text-gray-500 sm:flex"
                        >

                            <span>Searching for</span>

                            <span
                                class="rounded-md bg-gray-100 px-2 py-1
                                       font-medium text-gray-700"
                                x-text="`'${search}'`"
                            ></span>

                        </div>

                    </div>


                    {{-- Table --}}
                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead>

                                <tr
                                    class="border-b border-gray-100
                                           text-left text-gray-500"
                                >

                                    <th
                                        class="whitespace-nowrap px-5 py-3
                                               font-normal"
                                    >
                                        Vehicle
                                    </th>

                                    <th
                                        class="whitespace-nowrap px-5 py-3
                                               font-normal"
                                    >
                                        Plate number
                                    </th>

                                    <th
                                        class="whitespace-nowrap px-5 py-3
                                               font-normal"
                                    >
                                        Owner
                                    </th>

                                    <th
                                        class="whitespace-nowrap px-5 py-3
                                               font-normal"
                                    >
                                        Engine
                                    </th>

                                    <th
                                        class="whitespace-nowrap px-5 py-3
                                               text-right font-normal"
                                    >
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                {{-- Vehicles --}}
                                <template
                                    x-for="vehicle in filteredVehicles"
                                    :key="vehicle.vehicle_id"
                                >

                                    <tr
                                        class="border-b border-gray-100
                                               transition hover:bg-gray-50"
                                    >

                                        {{-- Vehicle --}}
                                        <td class="px-5 py-3">

                                            <p
                                                class="font-medium text-gray-900"
                                                x-text="vehicle.make"
                                            ></p>

                                            <p
                                                class="text-xs text-gray-500"
                                                x-text="vehicle.year
                                                    ? `Year ${vehicle.year}`
                                                    : 'Vehicle'"
                                            ></p>

                                        </td>


                                        {{-- Plate --}}
                                        <td
                                            class="whitespace-nowrap px-5 py-3
                                                   text-gray-600"
                                            x-text="vehicle.plate_number"
                                        ></td>


                                        {{-- Owner --}}
                                        <td class="px-5 py-3">

                                            <p
                                                class="font-medium text-gray-800"
                                                x-text="vehicle.owner_name"
                                            ></p>

                                            <p
                                                class="text-xs text-gray-500"
                                                x-text="vehicle.owner_id
                                                    ? `Customer #${String(vehicle.owner_id).padStart(3, '0')}`
                                                    : 'No owner'"
                                            ></p>

                                        </td>


                                        {{-- Engine --}}
                                        <td
                                            class="px-5 py-3 text-gray-600"
                                            x-text="vehicle.engine_model"
                                        ></td>


                                        {{-- Actions --}}
                                        <td class="px-5 py-3">

                                            <div
                                                class="flex items-center
                                                       justify-end gap-2"
                                            >

                                                {{-- Edit --}}
                                                <button
                                                    type="button"
                                                    @click="openEditModal(vehicle)"
                                                    class="inline-flex items-center gap-1.5
                                                           rounded-lg border border-gray-200
                                                           px-2.5 py-1.5 text-xs font-medium
                                                           text-gray-600 transition
                                                           hover:bg-gray-50
                                                           hover:text-gray-900"
                                                >

                                                    <i
                                                        class="ti ti-edit text-sm"
                                                    ></i>

                                                    Edit

                                                </button>


                                                {{-- Delete --}}
                                                <button
                                                    type="button"
                                                    @click="openDeleteModal(vehicle)"
                                                    class="inline-flex items-center gap-1.5
                                                           rounded-lg border border-gray-200
                                                           px-2.5 py-1.5 text-xs font-medium
                                                           text-red-600 transition
                                                           hover:bg-red-50
                                                           hover:border-red-200"
                                                >

                                                    <i
                                                        class="ti ti-trash text-sm"
                                                    ></i>

                                                    Delete

                                                </button>

                                            </div>

                                        </td>

                                    </tr>

                                </template>


                                {{-- No Results --}}
                                <tr
                                    x-show="filteredVehicles.length === 0"
                                >

                                    <td
                                        colspan="5"
                                        class="px-5 py-14 text-center"
                                    >

                                        <div
                                            class="flex flex-col items-center"
                                        >

                                            <div
                                                class="flex h-12 w-12
                                                       items-center justify-center
                                                       rounded-full bg-gray-100"
                                            >

                                                <i
                                                    class="ti ti-car-off
                                                           text-xl text-gray-400"
                                                ></i>

                                            </div>


                                            <p
                                                class="mt-3 text-sm
                                                       font-medium text-gray-800"
                                            >
                                                No vehicles found
                                            </p>


                                            <p
                                                class="mt-1 max-w-sm text-xs
                                                       text-gray-500"
                                            >
                                                Try searching with a different
                                                vehicle, plate number, owner,
                                                or engine model.
                                            </p>


                                            <button
                                                type="button"
                                                @click="search = ''"
                                                class="mt-4 text-xs font-medium
                                                       text-gray-700 underline
                                                       underline-offset-2
                                                       hover:text-gray-900"
                                            >
                                                Clear search
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </main>


            {{-- ========================================================= --}}
            {{-- EDIT VEHICLE MODAL --}}
            {{-- ========================================================= --}}

            <div
                x-show="editModal"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center
                       justify-center bg-black/40 px-4"
                @keydown.escape.window="closeEditModal()"
            >

                <div
                    x-show="editModal"
                    x-transition
                    @click.outside="closeEditModal()"
                    class="w-full max-w-lg overflow-hidden
                           rounded-2xl bg-white shadow-xl"
                >

                    {{-- Header --}}
                    <div
                        class="flex items-center justify-between
                               border-b border-gray-100 px-6 py-4"
                    >

                        <div>

                            <h2 class="text-lg font-medium text-gray-900">
                                Edit vehicle
                            </h2>

                            <p class="mt-1 text-xs text-gray-500">
                                Update this vehicle's information.
                            </p>

                        </div>


                        <button
                            type="button"
                            @click="closeEditModal()"
                            class="flex h-8 w-8 items-center justify-center
                                   rounded-lg text-gray-400
                                   transition hover:bg-gray-100
                                   hover:text-gray-700"
                        >
                            <i class="ti ti-x text-lg"></i>
                        </button>

                    </div>


                    {{-- Form --}}
                    <form
                        :action="'{{ url('/admin/vehicles') }}/' + editVehicle.id"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')


                        <div class="space-y-4 px-6 py-5">

                            {{-- Customer --}}
                            <div>

                                <label
                                    for="edit_cust_id"
                                    class="mb-1.5 block text-sm font-medium
                                           text-gray-700"
                                >
                                    Customer / Owner
                                </label>

                                <select
                                    id="edit_cust_id"
                                    name="cust_id"
                                    x-model="editVehicle.cust_id"
                                    required
                                    class="w-full rounded-lg border border-gray-200
                                           bg-white px-3 py-2.5 text-sm
                                           focus:border-gray-300 focus:outline-none
                                           focus:ring-2 focus:ring-gray-100"
                                >

                                    <option value="" disabled>
                                        Select customer
                                    </option>

                                    @foreach ($customers as $customer)

                                        <option
                                            value="{{ $customer->cust_id }}"
                                        >
                                            {{ $customer->first_name }}

                                            {{ $customer->middle_name
                                                ? $customer->middle_name . ' '
                                                : ''
                                            }}

                                            {{ $customer->last_name }}
                                        </option>

                                    @endforeach

                                </select>

                            </div>


                            {{-- Vehicle --}}
                            <div>

                                <label
                                    for="edit_make"
                                    class="mb-1.5 block text-sm font-medium
                                           text-gray-700"
                                >
                                    Vehicle
                                </label>

                                <input
                                    id="edit_make"
                                    type="text"
                                    name="make"
                                    x-model="editVehicle.make"
                                    required
                                    placeholder="Toyota Vios 2022"
                                    class="w-full rounded-lg border border-gray-200
                                           px-3 py-2.5 text-sm
                                           focus:border-gray-300 focus:outline-none
                                           focus:ring-2 focus:ring-gray-100"
                                >

                                <p class="mt-1.5 text-xs text-gray-400">
                                    Enter the make, model, and year.
                                    Example: Toyota Vios 2022
                                </p>

                            </div>


                            {{-- Plate Number --}}
                            <div>

                                <label
                                    for="edit_plate_number"
                                    class="mb-1.5 block text-sm font-medium
                                           text-gray-700"
                                >
                                    Plate number
                                </label>

                                <input
                                    id="edit_plate_number"
                                    type="text"
                                    name="plate_number"
                                    x-model="editVehicle.plate_number"
                                    required
                                    class="w-full rounded-lg border border-gray-200
                                           px-3 py-2.5 text-sm uppercase
                                           focus:border-gray-300 focus:outline-none
                                           focus:ring-2 focus:ring-gray-100"
                                >

                            </div>


                            {{-- Engine Model --}}
                            <div>

                                <label
                                    for="edit_engine_model"
                                    class="mb-1.5 block text-sm font-medium
                                           text-gray-700"
                                >
                                    Engine model
                                </label>

                                <input
                                    id="edit_engine_model"
                                    type="text"
                                    name="engine_model"
                                    x-model="editVehicle.engine_model"
                                    required
                                    class="w-full rounded-lg border border-gray-200
                                           px-3 py-2.5 text-sm
                                           focus:border-gray-300 focus:outline-none
                                           focus:ring-2 focus:ring-gray-100"
                                >

                            </div>

                        </div>


                        {{-- Footer --}}
                        <div
                            class="flex items-center justify-end gap-2
                                   border-t border-gray-100
                                   bg-gray-50/50 px-6 py-4"
                        >

                            <button
                                type="button"
                                @click="closeEditModal()"
                                class="rounded-lg border border-gray-200
                                       bg-white px-4 py-2 text-sm
                                       font-medium text-gray-600
                                       transition hover:bg-gray-50"
                            >
                                Cancel
                            </button>


                            <button
                                type="submit"
                                class="inline-flex items-center gap-2
                                       rounded-lg bg-gray-900 px-4 py-2
                                       text-sm font-medium text-white
                                       transition hover:bg-gray-800"
                            >

                                <i class="ti ti-device-floppy"></i>

                                Save changes

                            </button>

                        </div>

                    </form>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- DELETE VEHICLE MODAL --}}
            {{-- ========================================================= --}}

            <div
                x-show="deleteModal"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center
                       justify-center bg-black/40 px-4"
                @keydown.escape.window="closeDeleteModal()"
            >

                <div
                    x-show="deleteModal"
                    x-transition
                    @click.outside="closeDeleteModal()"
                    class="w-full max-w-md overflow-hidden
                           rounded-2xl bg-white shadow-xl"
                >

                    <div class="px-6 py-6">

                        {{-- Warning Icon --}}
                        <div
                            class="flex h-11 w-11 items-center
                                   justify-center rounded-full bg-red-50"
                        >

                            <i
                                class="ti ti-trash text-xl text-red-600"
                            ></i>

                        </div>


                        <h2
                            class="mt-4 text-lg font-medium text-gray-900"
                        >
                            Delete vehicle?
                        </h2>


                        <p
                            class="mt-2 text-sm leading-6 text-gray-500"
                        >

                            Are you sure you want to delete

                            <span
                                class="font-medium text-gray-800"
                                x-text="deleteVehicle.make"
                            ></span>

                            owned by

                            <span
                                class="font-medium text-gray-800"
                                x-text="deleteVehicle.owner_name"
                            ></span>

                           ?

                            This action cannot be undone.

                        </p>

                    </div>


                    {{-- Footer --}}
                    <div
                        class="flex items-center justify-end gap-2
                               border-t border-gray-100
                               bg-gray-50/50 px-6 py-4"
                    >

                        <button
                            type="button"
                            @click="closeDeleteModal()"
                            class="rounded-lg border border-gray-200
                                   bg-white px-4 py-2 text-sm
                                   font-medium text-gray-600
                                   transition hover:bg-gray-50"
                        >
                            Cancel
                        </button>


                        <form
                            method="POST"
                            :action="'{{ url('/admin/vehicles') }}/' + deleteVehicle.id"
                        >

                            @csrf
                            @method('DELETE')


                            <button
                                type="submit"
                                class="inline-flex items-center gap-2
                                       rounded-lg bg-red-600 px-4 py-2
                                       text-sm font-medium text-white
                                       transition hover:bg-red-700"
                            >

                                <i class="ti ti-trash"></i>

                                Delete vehicle

                            </button>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ============================================================= --}}
    {{-- ALPINE VEHICLE TABLE --}}
    {{-- ============================================================= --}}

    <script>
        function vehicleTable() {
            return {

                search: '',

                sort: 'az',

                editModal: false,

                deleteModal: false,


                /*
                 * Real vehicles from Laravel.
                 */
                vehicles: @js(
                    $vehicles->map(function ($vehicle) {

                        $ownerName = $vehicle->customer
                            ? trim(
                                $vehicle->customer->first_name . ' ' .
                                (
                                    $vehicle->customer->middle_name
                                        ? $vehicle->customer->middle_name . ' '
                                        : ''
                                ) .
                                $vehicle->customer->last_name
                            )
                            : 'No owner';

                        preg_match(
                            '/\b(19|20)\d{2}\b/',
                            $vehicle->make,
                            $yearMatch
                        );

                        return [
                            'vehicle_id' => $vehicle->vehicle_id,

                            'cust_id' => $vehicle->cust_id,

                            'owner_id' => $vehicle->customer?->cust_id,

                            'owner_name' => $ownerName,

                            'make' => $vehicle->make,

                            'plate_number' => $vehicle->plate_number,

                            'engine_model' => $vehicle->engine_model,

                            'year' => $yearMatch[0] ?? null,
                        ];

                    })->values()
                ),


                /*
                 * Edit modal data.
                 */
                editVehicle: {
                    id: null,
                    cust_id: '',
                    make: '',
                    plate_number: '',
                    engine_model: ''
                },


                /*
                 * Delete modal data.
                 */
                deleteVehicle: {
                    id: null,
                    make: '',
                    owner_name: ''
                },


                /*
                 * Search + sorting.
                 */
                get filteredVehicles() {

                    let results = [...this.vehicles];

                    const search = this.search
                        .toLowerCase()
                        .trim();


                    /*
                     * Search
                     */
                    if (search) {

                        results = results.filter(vehicle => {

                            return (
                                vehicle.make
                                    .toLowerCase()
                                    .includes(search) ||

                                vehicle.plate_number
                                    .toLowerCase()
                                    .includes(search) ||

                                vehicle.owner_name
                                    .toLowerCase()
                                    .includes(search) ||

                                vehicle.engine_model
                                    .toLowerCase()
                                    .includes(search)
                            );

                        });

                    }


                    /*
                     * Sorting
                     */
                    results.sort((a, b) => {

                        if (this.sort === 'owner') {

                            return a.owner_name
                                .toLowerCase()
                                .localeCompare(
                                    b.owner_name.toLowerCase()
                                );

                        }


                        if (this.sort === 'make') {

                            return a.make
                                .toLowerCase()
                                .localeCompare(
                                    b.make.toLowerCase()
                                );

                        }


                        if (this.sort === 'za') {

                            return b.make
                                .toLowerCase()
                                .localeCompare(
                                    a.make.toLowerCase()
                                );

                        }


                        return a.make
                            .toLowerCase()
                            .localeCompare(
                                b.make.toLowerCase()
                            );

                    });


                    return results;
                },


                /*
                 * Open edit modal.
                 */
                openEditModal(vehicle) {

                    this.editVehicle = {

                        id: vehicle.vehicle_id,

                        cust_id: vehicle.cust_id,

                        make: vehicle.make || '',

                        plate_number:
                            vehicle.plate_number || '',

                        engine_model:
                            vehicle.engine_model || ''

                    };

                    this.editModal = true;

                    document.body.classList.add(
                        'overflow-hidden'
                    );
                },


                /*
                 * Close edit modal.
                 */
                closeEditModal() {

                    this.editModal = false;

                    document.body.classList.remove(
                        'overflow-hidden'
                    );
                },


                /*
                 * Open delete confirmation.
                 */
                openDeleteModal(vehicle) {

                    this.deleteVehicle = {

                        id: vehicle.vehicle_id,

                        make: vehicle.make,

                        owner_name: vehicle.owner_name

                    };

                    this.deleteModal = true;

                    document.body.classList.add(
                        'overflow-hidden'
                    );
                },


                /*
                 * Close delete confirmation.
                 */
                closeDeleteModal() {

                    this.deleteModal = false;

                    document.body.classList.remove(
                        'overflow-hidden'
                    );
                }

            };
        }
    </script>

</x-app-layout>