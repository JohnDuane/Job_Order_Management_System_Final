<x-app-layout>

    <div
        class="min-h-screen bg-white text-gray-900"
        x-data="customerTable()"
    >

        <div class="flex min-h-screen">

            {{-- Admin Sidebar --}}
            <x-admin-sidebar />


            {{-- Main Content --}}
            <main class="flex-1 min-w-0 p-6 sm:p-8">

                {{-- Header --}}
                <div class="mb-6 flex items-start justify-between gap-4">

                    <div>
                        <h1 class="text-2xl font-medium">
                            Customers
                        </h1>

                        <p class="mt-1 text-sm text-gray-500">
                            Manage customer records
                        </p>
                    </div>


                    {{-- Add Customer --}}
                    <a
                        href="{{ route('admin.users.addcustomer') }}"
                        class="inline-flex shrink-0 items-center gap-2
                               rounded-lg bg-gray-900 px-4 py-2.5
                               text-sm font-medium text-white
                               transition hover:bg-gray-800"
                    >
                        <i class="ti ti-user-plus"></i>
                        Add customer
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
                            placeholder="Search customers..."
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

                            <span>
                                Filter
                            </span>

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
                                   bg-white p-2 shadow-lg sm:left-auto sm:right-0"
                        >

                            <p
                                class="px-3 py-2 text-xs font-medium
                                       uppercase tracking-wide text-gray-400"
                            >
                                Sort customers
                            </p>


                            {{-- A-Z --}}
                            <button
                                type="button"
                                @click="
                                    sort = 'az';
                                    open = false;
                                "
                                class="flex w-full items-center gap-3 rounded-lg
                                       px-3 py-2 text-sm text-gray-700
                                       transition hover:bg-gray-50"
                                :class="{ 'bg-gray-50': sort === 'az' }"
                            >

                                <i
                                    class="ti ti-sort-ascending text-base text-gray-400"
                                ></i>

                                <span>
                                    A–Z
                                </span>

                                <i
                                    x-show="sort === 'az'"
                                    class="ti ti-check ml-auto text-sm text-gray-700"
                                ></i>

                            </button>


                            {{-- Z-A --}}
                            <button
                                type="button"
                                @click="
                                    sort = 'za';
                                    open = false;
                                "
                                class="flex w-full items-center gap-3 rounded-lg
                                       px-3 py-2 text-sm text-gray-700
                                       transition hover:bg-gray-50"
                                :class="{ 'bg-gray-50': sort === 'za' }"
                            >

                                <i
                                    class="ti ti-sort-descending text-base text-gray-400"
                                ></i>

                                <span>
                                    Z–A
                                </span>

                                <i
                                    x-show="sort === 'za'"
                                    class="ti ti-check ml-auto text-sm text-gray-700"
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
                                class="flex w-full items-center gap-3 rounded-lg
                                       px-3 py-2 text-sm text-gray-500
                                       transition hover:bg-gray-50"
                            >

                                <i
                                    class="ti ti-refresh text-base text-gray-400"
                                ></i>

                                Reset

                            </button>

                        </div>

                    </div>

                </div>


                {{-- Customer Table --}}
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
                                Customer records
                            </p>

                            <p class="mt-1 text-xs text-gray-500">

                                <span x-text="filteredCustomers.length"></span>

                                <span
                                    x-text="filteredCustomers.length === 1
                                        ? 'customer'
                                        : 'customers'"
                                ></span>

                            </p>

                        </div>


                        {{-- Active Search Indicator --}}
                        <div
                            x-show="search.trim() !== ''"
                            x-transition
                            class="hidden items-center gap-2 text-xs text-gray-500 sm:flex"
                        >

                            <span>
                                Searching for
                            </span>

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
                                        Customer
                                    </th>

                                    <th
                                        class="whitespace-nowrap px-5 py-3
                                               font-normal"
                                    >
                                        Contact
                                    </th>

                                    <th
                                        class="whitespace-nowrap px-5 py-3
                                               font-normal"
                                    >
                                        Vehicles
                                    </th>

                                    <th
                                        class="whitespace-nowrap px-5 py-3
                                               font-normal"
                                    >
                                        Address
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

                                {{-- Customers --}}
                                <template
                                    x-for="customer in filteredCustomers"
                                    :key="customer.cust_id"
                                >

                                    <tr
                                        class="border-b border-gray-100
                                               transition hover:bg-gray-50"
                                    >

                                        {{-- Customer --}}
                                        <td class="px-5 py-3">

                                            <p
                                                class="font-medium text-gray-900"
                                                x-text="customer.full_name"
                                            ></p>

                                            <p
                                                class="text-xs text-gray-500"
                                                x-text="`Customer #${String(customer.cust_id).padStart(3, '0')}`"
                                            ></p>

                                        </td>


                                        {{-- Contact --}}
                                        <td
                                            class="whitespace-nowrap px-5 py-3
                                                   text-gray-600"
                                            x-text="customer.contact_number"
                                        ></td>


                                        {{-- Vehicles --}}
                                        <td
                                            class="whitespace-nowrap px-5 py-3
                                                   text-gray-600"
                                        >

                                            <span
                                                x-text="customer.vehicle_count"
                                            ></span>

                                            <span
                                                x-text="customer.vehicle_count === 1
                                                    ? ' vehicle'
                                                    : ' vehicles'"
                                            ></span>

                                        </td>


                                        {{-- Address --}}
                                        <td
                                            class="max-w-xs px-5 py-3
                                                   text-gray-600"
                                        >

                                            <p
                                                class="truncate"
                                                :title="customer.address"
                                                x-text="customer.address"
                                            ></p>

                                        </td>


                                        {{-- Actions --}}
                                        <td class="px-5 py-3">

                                            <div
                                                class="flex items-center
                                                       justify-end gap-2"
                                            >

                                                {{-- Edit --}}
                                                <button
                                                    type="button"
                                                    @click="openEditModal(customer)"
                                                    class="inline-flex items-center gap-1.5 rounded-lg
                                                        border border-gray-200 px-2.5 py-1.5
                                                        text-xs font-medium text-gray-600
                                                        transition hover:bg-gray-50 hover:text-gray-900"
                                                >
                                                    <i class="ti ti-edit text-sm"></i>
                                                    Edit
                                                </button>


                                                {{-- Delete --}}
                                                <button
                                                    type="button"
                                                    @click="openDeleteModal(customer)"
                                                    class="inline-flex items-center gap-1.5 rounded-lg
                                                        border border-gray-200 px-2.5 py-1.5
                                                        text-xs font-medium text-red-600
                                                        transition hover:bg-red-50 hover:border-red-200"
                                                >
                                                    <i class="ti ti-trash text-sm"></i>
                                                    Delete
                                                </button>

                                            </div>

                                        </td>

                                    </tr>

                                </template>


                                {{-- No Search Results --}}
                                <tr
                                    x-show="filteredCustomers.length === 0"
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
                                                    class="ti ti-search
                                                           text-xl text-gray-400"
                                                ></i>

                                            </div>


                                            <p
                                                class="mt-3 text-sm
                                                       font-medium text-gray-800"
                                            >
                                                No customers found
                                            </p>


                                            <p
                                                class="mt-1 max-w-sm text-xs
                                                       text-gray-500"
                                            >
                                                Try searching with a different
                                                name, contact number, or address.
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


            {{-- EDIT CUSTOMER MODAL --}}
            <div
                x-show="editModal"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center
                    bg-black/40 px-4"
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
                    <div class="flex items-center justify-between
                                border-b border-gray-100 px-6 py-4">

                        <div>

                            <h2 class="text-lg font-medium text-gray-900">
                                Edit customer
                            </h2>

                            <p class="mt-1 text-xs text-gray-500">
                                Update this customer's information.
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
                        :action="'{{ url('/admin/customers') }}/' + editCustomer.id"
                        method="POST"
                    >

                        @csrf
                        @method('PUT')

                        <div class="space-y-4 px-6 py-5">

                            {{-- First Name --}}
                            <div>

                                <label
                                    for="edit_first_name"
                                    class="mb-1.5 block text-sm font-medium
                                        text-gray-700"
                                >
                                    First name
                                </label>

                                <input
                                    id="edit_first_name"
                                    type="text"
                                    name="first_name"
                                    x-model="editCustomer.first_name"
                                    required
                                    class="w-full rounded-lg border border-gray-200
                                        px-3 py-2 text-sm
                                        focus:border-gray-300
                                        focus:outline-none
                                        focus:ring-2 focus:ring-gray-100"
                                >

                            </div>


                            {{-- Middle Name --}}
                            <div>

                                <label
                                    for="edit_middle_name"
                                    class="mb-1.5 block text-sm font-medium
                                        text-gray-700"
                                >
                                    Middle name
                                    <span class="font-normal text-gray-400">
                                        (optional)
                                    </span>
                                </label>

                                <input
                                    id="edit_middle_name"
                                    type="text"
                                    name="middle_name"
                                    x-model="editCustomer.middle_name"
                                    class="w-full rounded-lg border border-gray-200
                                        px-3 py-2 text-sm
                                        focus:border-gray-300
                                        focus:outline-none
                                        focus:ring-2 focus:ring-gray-100"
                                >

                            </div>


                            {{-- Last Name --}}
                            <div>

                                <label
                                    for="edit_last_name"
                                    class="mb-1.5 block text-sm font-medium
                                        text-gray-700"
                                >
                                    Last name
                                </label>

                                <input
                                    id="edit_last_name"
                                    type="text"
                                    name="last_name"
                                    x-model="editCustomer.last_name"
                                    required
                                    class="w-full rounded-lg border border-gray-200
                                        px-3 py-2 text-sm
                                        focus:border-gray-300
                                        focus:outline-none
                                        focus:ring-2 focus:ring-gray-100"
                                >

                            </div>


                            {{-- Contact --}}
                            <div>

                                <label
                                    for="edit_contact_number"
                                    class="mb-1.5 block text-sm font-medium
                                        text-gray-700"
                                >
                                    Contact number
                                </label>

                                <input
                                    id="edit_contact_number"
                                    type="text"
                                    name="contact_number"
                                    x-model="editCustomer.contact_number"
                                    maxlength="11"
                                    required
                                    class="w-full rounded-lg border border-gray-200
                                        px-3 py-2 text-sm
                                        focus:border-gray-300
                                        focus:outline-none
                                        focus:ring-2 focus:ring-gray-100"
                                >

                            </div>


                            {{-- Address --}}
                            <div>

                                <label
                                    for="edit_address"
                                    class="mb-1.5 block text-sm font-medium
                                        text-gray-700"
                                >
                                    Address
                                </label>

                                <textarea
                                    id="edit_address"
                                    name="address"
                                    rows="3"
                                    x-model="editCustomer.address"
                                    required
                                    class="w-full resize-none rounded-lg
                                        border border-gray-200 px-3 py-2
                                        text-sm
                                        focus:border-gray-300
                                        focus:outline-none
                                        focus:ring-2 focus:ring-gray-100"
                                ></textarea>

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
                                    rounded-lg bg-gray-900
                                    px-4 py-2 text-sm font-medium
                                    text-white transition
                                    hover:bg-gray-800"
                            >
                                <i class="ti ti-device-floppy"></i>
                                Save changes
                            </button>

                        </div>

                    </form>

                </div>

            </div>





            {{-- DELETE CUSTOMER MODAL --}}
            <div
                x-show="deleteModal"
                x-cloak
                x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center
                    bg-black/40 px-4"
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
                            class="flex h-11 w-11 items-center justify-center
                                rounded-full bg-red-50"
                        >
                            <i
                                class="ti ti-trash text-xl text-red-600"
                            ></i>
                        </div>


                        <h2
                            class="mt-4 text-lg font-medium text-gray-900"
                        >
                            Delete customer?
                        </h2>


                        <p class="mt-2 text-sm leading-6 text-gray-500">

                            Are you sure you want to delete

                            <span
                                class="font-medium text-gray-800"
                                x-text="deleteCustomer.name"
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
                            :action="'{{ url('/admin/customers') }}/' + deleteCustomer.id"
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
                                Delete customer
                            </button>

                        </form>

                    </div>

                </div>

            </div>







        </div>

    </div>


    {{-- Alpine Customer Table --}}
   <script>
    function customerTable() {
        return {
            search: '',
            sort: 'az',
            open: false,

            editModal: false,
            deleteModal: false,

            editCustomer: {
                id: null,
                first_name: '',
                middle_name: '',
                last_name: '',
                contact_number: '',
                address: ''
            },

            deleteCustomer: {
                id: null,
                name: ''
            },

            customers: @js(
                $customers->map(function ($customer) {
                    return [
                        'cust_id' => $customer->cust_id,
                        'first_name' => $customer->first_name,
                        'middle_name' => $customer->middle_name ?? '',
                        'last_name' => $customer->last_name,
                        'contact_number' => $customer->contact_number,
                        'address' => $customer->address,
                        'vehicle_count' => $customer->vehicles->count(),
                        'full_name' => trim(
                            $customer->first_name . ' ' .
                            ($customer->middle_name
                                ? $customer->middle_name . ' '
                                : '') .
                            $customer->last_name
                        ),
                    ];
                })->values()
            ),

            get filteredCustomers() {
                let results = [...this.customers];

                const search = this.search.toLowerCase().trim();

                // Search
                if (search) {
                    results = results.filter(customer => {
                        return (
                            customer.full_name.toLowerCase().includes(search) ||
                            customer.contact_number.toLowerCase().includes(search) ||
                            customer.address.toLowerCase().includes(search)
                        );
                    });
                }

                // Sort
                results.sort((a, b) => {
                    const nameA = a.full_name.toLowerCase();
                    const nameB = b.full_name.toLowerCase();

                    if (this.sort === 'za') {
                        return nameB.localeCompare(nameA);
                    }

                    return nameA.localeCompare(nameB);
                });

                return results;
            },

            openEditModal(customer) {
                this.editCustomer = {
                    id: customer.cust_id,
                    first_name: customer.first_name || '',
                    middle_name: customer.middle_name || '',
                    last_name: customer.last_name || '',
                    contact_number: customer.contact_number || '',
                    address: customer.address || ''
                };

                this.editModal = true;
                document.body.classList.add('overflow-hidden');
            },

            closeEditModal() {
                this.editModal = false;
                document.body.classList.remove('overflow-hidden');
            },

            openDeleteModal(customer) {
                this.deleteCustomer = {
                    id: customer.cust_id,
                    name: customer.full_name
                };

                this.deleteModal = true;
                document.body.classList.add('overflow-hidden');
            },

            closeDeleteModal() {
                this.deleteModal = false;
                document.body.classList.remove('overflow-hidden');
            },

            reset() {
                this.search = '';
                this.sort = 'az';
            }
        }
    }
</script>

</x-app-layout>