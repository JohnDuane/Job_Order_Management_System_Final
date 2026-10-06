<x-app-layout>


    <div class="min-h-screen bg-white text-gray-900" x-data="staffTable()">

        <div class="min-h-screen lg:flex">
  
            <x-admin-sidebar />


            <main class="min-w-0 flex-1 flex-col gap-6 p-4 sm:p-6 lg:p-8">

                {{-- Header --}}
                <div class="mb-6 flex items-start justify-between gap-4">

                    <div>
                        <h1 class="text-2xl font-medium">
                            Staff
                        </h1>

                        <p class="mt-1 text-sm text-gray-500">
                            Manage staff accounts and roles
                        </p>
                    </div>

                    <a href="{{ route('admin.users.create') }}"
                        class="inline-flex shrink-0 items-center gap-2
                               rounded-lg bg-gray-900 px-4 py-2.5
                               text-sm font-medium text-white
                               transition hover:bg-gray-800">
                        <i class="ti ti-user-plus"></i>
                        Add staff
                    </a>

                </div>


                {{-- =================================================
                     SEARCH + FILTER
                     ================================================= --}}
                <div class="mb-6 flex flex-col gap-2 sm:flex-row sm:items-center">

                    {{-- Search --}}
                    <div class="relative w-full sm:max-w-md">

                        <i
                            class="ti ti-search absolute left-3 top-1/2
                                   -translate-y-1/2 text-gray-400"></i>

                        <input type="text" x-model="search" placeholder="Search staff..."
                            class="w-full rounded-lg border border-gray-200
                                   bg-white py-2.5 pl-9 pr-3 text-sm
                                   text-gray-900 placeholder:text-gray-400
                                   focus:border-gray-300
                                   focus:outline-none
                                   focus:ring-2 focus:ring-gray-100">

                    </div>


                    {{-- Filter --}}
                    <div class="relative" x-data="{ open: false }">

                        <button type="button" @click="open = !open"
                            class="inline-flex w-full items-center justify-center
                                   gap-2 rounded-lg border border-gray-200
                                   bg-white px-3 py-2.5 text-sm text-gray-600
                                   transition hover:bg-gray-50
                                   sm:w-auto">

                            <i class="ti ti-filter text-base"></i>

                            <span>
                                Filter
                            </span>

                            <i class="ti ti-chevron-down text-xs transition-transform"
                                :class="{ 'rotate-180': open }"></i>

                        </button>


                        {{-- Filter Dropdown --}}
                        <div x-show="open" x-cloak x-transition @click.outside="open = false"
                            class="absolute right-0 z-30 mt-2 w-56
                                   rounded-xl border border-gray-200
                                   bg-white p-2 shadow-lg">

                            <p
                                class="px-3 py-2 text-xs font-medium
                                       uppercase tracking-wide text-gray-400">
                                Sort / Filter
                            </p>


                            {{-- A-Z --}}
                            <button type="button"
                                @click="
                                    sort = 'az';
                                    open = false;
                                "
                                class="flex w-full items-center gap-3 rounded-lg
                                       px-3 py-2 text-sm text-gray-700
                                       transition hover:bg-gray-50"
                                :class="{ 'bg-gray-50': sort === 'az' }">

                                <i
                                    class="ti ti-sort-ascending
                                           text-base text-gray-400"></i>

                                <span>
                                    A–Z
                                </span>

                                <i x-show="sort === 'az'" class="ti ti-check ml-auto text-sm text-gray-700"></i>

                            </button>


                            {{-- Z-A --}}
                            <button type="button"
                                @click="
                                    sort = 'za';
                                    open = false;
                                "
                                class="flex w-full items-center gap-3 rounded-lg
                                       px-3 py-2 text-sm text-gray-700
                                       transition hover:bg-gray-50"
                                :class="{ 'bg-gray-50': sort === 'za' }">

                                <i
                                    class="ti ti-sort-descending
                                           text-base text-gray-400"></i>

                                <span>
                                    Z–A
                                </span>

                                <i x-show="sort === 'za'" class="ti ti-check ml-auto text-sm text-gray-700"></i>

                            </button>


                            <div class="my-1 border-t border-gray-100"></div>


                            {{-- By Name --}}
                            <button type="button"
                                @click="
                                    filter = 'name';
                                    open = false;
                                "
                                class="flex w-full items-center gap-3 rounded-lg
                                       px-3 py-2 text-sm text-gray-700
                                       transition hover:bg-gray-50"
                                :class="{ 'bg-gray-50': filter === 'name' }">

                                <i class="ti ti-user text-base text-gray-400"></i>

                                <span>
                                    By name
                                </span>

                                <i x-show="filter === 'name'" class="ti ti-check ml-auto text-sm text-gray-700"></i>

                            </button>


                            {{-- By Role --}}
                            <button type="button"
                                @click="
                                    filter = 'role';
                                    open = false;
                                "
                                class="flex w-full items-center gap-3 rounded-lg
                                       px-3 py-2 text-sm text-gray-700
                                       transition hover:bg-gray-50"
                                :class="{ 'bg-gray-50': filter === 'role' }">

                                <i
                                    class="ti ti-user-shield
                                           text-base text-gray-400"></i>

                                <span>
                                    By role
                                </span>

                                <i x-show="filter === 'role'" class="ti ti-check ml-auto text-sm text-gray-700"></i>

                            </button>


                            {{-- Role Filters --}}
                            <div x-show="filter === 'role'" x-cloak x-transition
                                class="mt-1 border-t border-gray-100 pt-1">

                                {{-- All roles --}}
                                <button type="button"
                                    @click="
                                        role = 'all';
                                        open = false;
                                    "
                                    class="flex w-full items-center gap-3
                                           rounded-lg px-3 py-2 text-sm
                                           text-gray-600 hover:bg-gray-50">

                                    <span class="ml-7">
                                        All roles
                                    </span>

                                    <i x-show="role === 'all'" class="ti ti-check ml-auto"></i>

                                </button>


                                {{-- Admin --}}
                                <button type="button"
                                    @click="
                                        role = 'admin';
                                        open = false;
                                    "
                                    class="flex w-full items-center gap-3
                                           rounded-lg px-3 py-2 text-sm
                                           text-gray-600 hover:bg-gray-50">

                                    <span class="ml-7">
                                        Admin
                                    </span>

                                    <i x-show="role === 'admin'" class="ti ti-check ml-auto"></i>

                                </button>


                                {{-- Supervisor --}}
                                <button type="button"
                                    @click="
                                        role = 'supervisor';
                                        open = false;
                                    "
                                    class="flex w-full items-center gap-3
                                           rounded-lg px-3 py-2 text-sm
                                           text-gray-600 hover:bg-gray-50">

                                    <span class="ml-7">
                                        Supervisor
                                    </span>

                                    <i x-show="role === 'supervisor'" class="ti ti-check ml-auto"></i>

                                </button>


                                {{-- Mechanic --}}
                                <button type="button"
                                    @click="
                                        role = 'mechanic';
                                        open = false;
                                    "
                                    class="flex w-full items-center gap-3
                                           rounded-lg px-3 py-2 text-sm
                                           text-gray-600 hover:bg-gray-50">

                                    <span class="ml-7">
                                        Mechanic
                                    </span>

                                    <i x-show="role === 'mechanic'" class="ti ti-check ml-auto"></i>

                                </button>

                            </div>


                            <div class="my-1 border-t border-gray-100"></div>


                            {{-- Reset --}}
                            <button type="button"
                                @click="
                                    reset();
                                    open = false;
                                "
                                class="flex w-full items-center gap-3
                                       rounded-lg px-3 py-2 text-sm
                                       text-gray-500
                                       transition hover:bg-gray-50">

                                <i class="ti ti-refresh text-base text-gray-400"></i>

                                Reset

                            </button>

                        </div>

                    </div>

                </div>


                {{-- =================================================
                     STAFF TABLE
                     ================================================= --}}
                <div class="overflow-hidden rounded-xl
                           border border-gray-200 bg-white">

                    {{-- Table Header --}}
                    <div
                        class="flex items-center justify-between
                               border-b border-gray-100 px-5 py-4">

                        <div>

                            <p class="font-medium">
                                Staff accounts
                            </p>

                            <p class="mt-1 text-xs text-gray-500">

                                <span x-text="filteredStaff.length"></span>

                                <span
                                    x-text="
                                        filteredStaff.length === 1
                                            ? 'staff member'
                                            : 'staff members'
                                    "></span>

                            </p>

                        </div>


                        {{-- Search Indicator --}}
                        <div x-show="search.trim() !== ''" x-cloak x-transition
                            class="hidden items-center gap-2
                                   text-xs text-gray-500 sm:flex">

                            <span>
                                Searching for
                            </span>

                            <span
                                class="rounded-md bg-gray-100 px-2 py-1
                                       font-medium text-gray-700"
                                x-text="'\'' + search + '\''"></span>

                        </div>

                    </div>


                    {{-- Table --}}
                    <div class="overflow-x-auto">

                        <table class="w-full text-sm">

                            <thead>

                                <tr
                                    class="border-b border-gray-100
                                           text-left text-gray-500">

                                    <th class="whitespace-nowrap px-5 py-3 font-normal">
                                        Staff
                                    </th>

                                    <th class="whitespace-nowrap px-5 py-3 font-normal">
                                        Email
                                    </th>

                                    <th class="whitespace-nowrap px-5 py-3 font-normal">
                                        Role
                                    </th>

                                    <th class="whitespace-nowrap px-5 py-3 text-right font-normal">
                                        Action
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                {{-- Staff Rows --}}
                                <template x-for="staff in filteredStaff" :key="staff.id">

                                    <tr
                                        class="border-b border-gray-100
                                               transition hover:bg-gray-50">

                                        {{-- Staff --}}
                                        <td class="px-5 py-3">

                                            <div class="flex items-center gap-3">

                                                <div
                                                    class="flex h-9 w-9 shrink-0
                                                           items-center justify-center
                                                           rounded-full bg-gray-100">

                                                    <i class="ti ti-user text-gray-500"></i>

                                                </div>


                                                <div>

                                                    <p class="font-medium text-gray-900" x-text="staff.full_name"></p>

                                                    <p class="text-xs text-gray-500"
                                                        x-text="'Staff #' + String(staff.id).padStart(3, '0')"></p>

                                                    <span x-show="staff.is_current_user"
                                                        class="inline-flex items-center gap-1
                                                            rounded-md bg-blue-50 px-1.5 py-0.5
                                                            text-[10px] font-medium text-blue-600">
                                                        <i class="ti ti-user-check text-xs"></i>
                                                        You
                                                    </span>

                                                </div>

                                            </div>

                                        </td>


                                        {{-- Email --}}
                                        <td class="px-5 py-3 text-gray-600" x-text="staff.email"></td>


                                        {{-- Role --}}
                                        <td class="px-5 py-3">

                                            <span
                                                class="inline-flex rounded-md
                                                       px-2.5 py-1 text-xs
                                                       font-medium"
                                                :class="roleClass(staff.role)" x-text="formatRole(staff.role)"></span>

                                        </td>


                                        {{-- Action --}}
                                        <td class="px-5 py-3 text-right">

                                            <div class="flex items-center justify-end gap-2">

                                                {{-- UPDATE --}}
                                                <button type="button"
                                                    @click="
                                                        selectedStaff = { ...staff };
                                                        modal = 'update';
                                                    "
                                                    class="inline-flex items-center gap-1.5
                                                           rounded-lg border border-gray-200
                                                           bg-white px-3 py-2
                                                           text-xs font-medium text-gray-700
                                                           transition hover:bg-gray-50">

                                                    <i class="ti ti-edit text-sm"></i>

                                                    Update

                                                </button>


                                                {{-- Delete --}}
                                                <button type="button" x-show="!staff.is_current_user"
                                                    @click="
                                                        selectedStaff = staff;
                                                        modal = 'delete';
                                                    "
                                                    class="inline-flex items-center gap-1.5 rounded-lg
                                                        border border-red-200 bg-white px-3 py-2
                                                        text-xs font-medium text-red-600
                                                        transition hover:bg-red-50">
                                                    <i class="ti ti-trash text-sm"></i>
                                                    Delete
                                                </button>

                                            </div>

                                        </td>

                                    </tr>

                                </template>


                                {{-- No Results --}}
                                <tr x-show="filteredStaff.length === 0">

                                    <td colspan="4" class="px-5 py-14 text-center">

                                        <div class="flex flex-col items-center">

                                            <div
                                                class="flex h-12 w-12
                                                       items-center justify-center
                                                       rounded-full bg-gray-100">

                                                <i
                                                    class="ti ti-users
                                                           text-xl text-gray-400"></i>

                                            </div>


                                            <p
                                                class="mt-3 text-sm
                                                       font-medium text-gray-800">
                                                No staff found
                                            </p>


                                            <p
                                                class="mt-1 max-w-sm
                                                       text-xs text-gray-500">
                                                Try searching with a different
                                                name, email, or role.
                                            </p>


                                            <button type="button" @click="reset()"
                                                class="mt-4 text-xs
                                                       font-medium text-gray-700
                                                       underline
                                                       underline-offset-2
                                                       hover:text-gray-900">
                                                Clear filters
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </main>

        </div>


        {{-- =========================================================
             SUCCESS MODAL
             ========================================================= --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-cloak x-transition.opacity
                class="fixed inset-0 z-[60] flex items-center
                       justify-center bg-black/40 px-4">

                <div @click.outside="show = false"
                    class="w-full max-w-md rounded-2xl
                           bg-white p-6 shadow-xl">

                    <div class="flex items-start gap-4">

                        <div
                            class="flex h-11 w-11 shrink-0
                                   items-center justify-center
                                   rounded-full bg-green-100">

                            <i class="ti ti-check text-xl text-green-600"></i>

                        </div>


                        <div class="flex-1">

                            <h2 class="text-lg font-semibold text-gray-900">
                                Success
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                {{ session('success') }}
                            </p>

                        </div>

                    </div>


                    <div class="mt-6 flex justify-end">

                        <button type="button" @click="show = false"
                            class="rounded-lg bg-gray-900 px-4 py-2.5
                                   text-sm font-medium text-white
                                   transition hover:bg-gray-800">
                            OK
                        </button>

                    </div>

                </div>

            </div>
        @endif

        {{-- Error Modal --}}
        @if (session('error'))
            <div x-data="{ show: true }" x-show="show" x-cloak x-transition
                class="fixed inset-0 z-50 flex items-center
               justify-center bg-black/40 px-4">

                <div @click.outside="show = false"
                    class="w-full max-w-md rounded-2xl
                   bg-white p-6 shadow-xl">

                    <div class="flex items-start gap-4">

                        <div
                            class="flex h-11 w-11 shrink-0
                           items-center justify-center
                           rounded-full bg-red-100">

                            <i class="ti ti-alert-circle
                              text-xl text-red-600"></i>

                        </div>


                        <div class="flex-1">

                            <h2 class="text-lg font-semibold text-gray-900">
                                Action not allowed
                            </h2>

                            <p class="mt-1 text-sm text-gray-500">
                                {{ session('error') }}
                            </p>

                        </div>

                    </div>


                    <div class="mt-6 flex justify-end">

                        <button type="button" @click="show = false"
                            class="rounded-lg bg-gray-900
                           px-4 py-2.5 text-sm
                           font-medium text-white
                           transition hover:bg-gray-800">
                            OK
                        </button>

                    </div>

                </div>

            </div>
        @endif


        {{-- =========================================================
             UPDATE MODAL
             ========================================================= --}}
        <div x-show="modal === 'update'" x-cloak x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center
                   bg-black/40 px-4">

            <div x-show="modal === 'update'" x-transition @click.outside="modal = null"
                class="w-full max-w-lg rounded-2xl
                       bg-white shadow-xl">

                {{-- Modal Header --}}
                <div
                    class="flex items-start justify-between
                           border-b border-gray-100 px-6 py-5">

                    <div>

                        <h2 class="text-lg font-semibold text-gray-900">
                            Update staff
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Update the selected staff account.
                        </p>

                    </div>


                    <button type="button" @click="modal = null"
                        class="rounded-lg p-2 text-gray-400
                               hover:bg-gray-100 hover:text-gray-600">

                        <i class="ti ti-x text-lg"></i>

                    </button>

                </div>


                {{-- Update Form --}}
                <form method="POST"
                    :action="selectedStaff
                        ?
                        '{{ url('/admin/staff') }}/' + selectedStaff.id :
                        '#'"
                    class="p-6">

                    @csrf
                    @method('PUT')


                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                        {{-- First Name --}}
                        <div>

                            <label
                                class="mb-1.5 block text-sm font-medium
                                       text-gray-700">
                                First name
                            </label>

                            <input type="text" name="first_name" :value="selectedStaff?.first_name ?? ''" required
                                class="w-full rounded-lg border border-gray-200
                                       px-3 py-2.5 text-sm
                                       focus:border-gray-400
                                       focus:outline-none
                                       focus:ring-2 focus:ring-gray-100">

                        </div>


                        {{-- Last Name --}}
                        <div>

                            <label
                                class="mb-1.5 block text-sm font-medium
                                       text-gray-700">
                                Last name
                            </label>

                            <input type="text" name="last_name" :value="selectedStaff?.last_name ?? ''" required
                                class="w-full rounded-lg border border-gray-200
                                       px-3 py-2.5 text-sm
                                       focus:border-gray-400
                                       focus:outline-none
                                       focus:ring-2 focus:ring-gray-100">

                        </div>


                        {{-- Middle Name --}}
                        <div class="sm:col-span-2">

                            <label
                                class="mb-1.5 block text-sm font-medium
                                       text-gray-700">
                                Middle name
                            </label>

                            <input type="text" name="middle_name" :value="selectedStaff?.middle_name ?? ''"
                                class="w-full rounded-lg border border-gray-200
                                       px-3 py-2.5 text-sm
                                       focus:border-gray-400
                                       focus:outline-none
                                       focus:ring-2 focus:ring-gray-100">

                        </div>


                        {{-- Email --}}
                        <div class="sm:col-span-2">

                            <label
                                class="mb-1.5 block text-sm font-medium
                                       text-gray-700">
                                Email
                            </label>

                            <input type="email" name="email" :value="selectedStaff?.email ?? ''" required
                                class="w-full rounded-lg border border-gray-200
                                       px-3 py-2.5 text-sm
                                       focus:border-gray-400
                                       focus:outline-none
                                       focus:ring-2 focus:ring-gray-100">

                        </div>


                        {{-- Role --}}
                        <div class="sm:col-span-2">

                            <label class="mb-1.5 block text-sm font-medium text-gray-700">
                                Role
                            </label>

                            <select name="role" x-model="selectedStaff.role" required
                                :disabled="selectedStaff?.is_current_user"
                                class="w-full rounded-lg border border-gray-200 px-3 py-2.5
                                    text-sm focus:border-gray-400 focus:outline-none
                                    focus:ring-2 focus:ring-gray-100
                                    disabled:cursor-not-allowed
                                    disabled:bg-gray-100
                                    disabled:text-gray-500">

                                <option value="admin">
                                    Admin
                                </option>

                                <option value="supervisor">
                                    Supervisor
                                </option>

                                <option value="mechanic">
                                    Mechanic
                                </option>

                            </select>


                            <input x-show="selectedStaff?.is_current_user" type="hidden" name="role"
                                :value="selectedStaff?.role ?? ''">


                            <p x-show="selectedStaff?.is_current_user" x-transition
                                class="mt-1.5 flex items-center gap-1.5 text-xs text-amber-600">

                                <i class="ti ti-lock text-sm"></i>

                                <span>
                                    Your role cannot be changed while you are logged in.
                                </span>

                            </p>

                        </div>

                    </div>


                    {{-- Buttons --}}
                    <div class="mt-6 flex justify-end gap-2">

                        <button type="button" @click="modal = null"
                            class="rounded-lg border border-gray-200
                                   px-4 py-2.5 text-sm font-medium
                                   text-gray-600 hover:bg-gray-50">
                            Cancel
                        </button>


                        <button type="submit"
                            class="rounded-lg bg-gray-900
                                   px-4 py-2.5 text-sm font-medium
                                   text-white hover:bg-gray-800">
                            Save changes
                        </button>

                    </div>

                </form>

            </div>

        </div>


        {{-- =========================================================
             DELETE MODAL
             ========================================================= --}}
        <div x-show="modal === 'delete'" x-cloak x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center
                   bg-black/40 px-4">

            <div x-show="modal === 'delete'" x-transition @click.outside="modal = null"
                class="w-full max-w-md rounded-2xl
                       bg-white p-6 shadow-xl">

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-11 w-11 shrink-0
                               items-center justify-center
                               rounded-full bg-red-50">

                        <i class="ti ti-trash text-xl text-red-600"></i>

                    </div>


                    <div>

                        <h2 class="text-lg font-semibold text-gray-900">
                            Delete staff account?
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">

                            Are you sure you want to delete

                            <span class="font-medium text-gray-700" x-text="selectedStaff?.full_name ?? ''"></span>?

                        </p>

                        <p class="mt-2 text-xs text-gray-400">
                            This action cannot be undone.
                        </p>

                    </div>

                </div>


                {{-- Delete Form --}}
                <form method="POST"
                    :action="selectedStaff
                        ?
                        '{{ url('/admin/staff') }}/' + selectedStaff.id :
                        '#'"
                    class="mt-6 flex justify-end gap-2">

                    @csrf
                    @method('DELETE')


                    <button type="button" @click="modal = null"
                        class="rounded-lg border border-gray-200
                               px-4 py-2.5 text-sm font-medium
                               text-gray-600 hover:bg-gray-50">
                        Cancel
                    </button>


                    <button type="submit"
                        class="rounded-lg bg-red-600
                               px-4 py-2.5 text-sm font-medium
                               text-white hover:bg-red-700">
                        Delete account
                    </button>

                </form>

            </div>

        </div>


        {{-- =========================================================
             ALPINE STAFF TABLE
             ========================================================= --}}
        <script>
            function staffTable() {

                return {

                    /*
                    |--------------------------------------------------------------------------
                    | Search / Filter
                    |--------------------------------------------------------------------------
                    */

                    search: '',

                    sort: 'az',

                    filter: 'all',

                    role: 'all',


                    /*
                    |--------------------------------------------------------------------------
                    | Modal
                    |--------------------------------------------------------------------------
                    |
                    | IMPORTANT:
                    | null = no modal is open
                    | 'update' = update modal
                    | 'delete' = delete modal
                    |
                    */

                    modal: null,


                    /*
                    |--------------------------------------------------------------------------
                    | Selected Staff
                    |--------------------------------------------------------------------------
                    */

                    selectedStaff: null,


                    /*
                    |--------------------------------------------------------------------------
                    | Staff Data
                    |--------------------------------------------------------------------------
                    */

                    staff: @js($staffData),


                    /*
                    |--------------------------------------------------------------------------
                    | Filtered Staff
                    |--------------------------------------------------------------------------
                    */

                    get filteredStaff() {

                        let results = [...this.staff];


                        /*
                        |--------------------------------------------------------------------------
                        | Search
                        |--------------------------------------------------------------------------
                        */

                        const search = this.search
                            .toLowerCase()
                            .trim();


                        if (search) {

                            results = results.filter(staff => {

                                return (

                                    staff.full_name
                                    .toLowerCase()
                                    .includes(search)

                                    ||

                                    staff.email
                                    .toLowerCase()
                                    .includes(search)

                                    ||

                                    staff.role
                                    .toLowerCase()
                                    .includes(search)

                                );

                            });

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Role Filter
                        |--------------------------------------------------------------------------
                        */

                        if (this.role !== 'all') {
                            results = results.filter(staff => {
                                return staff.role === this.role;
                            });
                        }


                        /*
                        |--------------------------------------------------------------------------
                        | Sorting
                        |--------------------------------------------------------------------------
                        */

                        results.sort((a, b) => {
                            const nameA =
                                a.full_name.toLowerCase();

                            const nameB =
                                b.full_name.toLowerCase();

                            if (this.sort === 'za') {
                                return nameB.localeCompare(nameA);
                            }

                            return nameA.localeCompare(nameB);

                        });

                        return results;

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Format Role
                    |--------------------------------------------------------------------------
                    */

                    formatRole(role) {

                        if (!role) {
                            return '';
                        }

                        return role.charAt(0).toUpperCase() +
                            role.slice(1);

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Role Badge
                    |--------------------------------------------------------------------------
                    */

                    roleClass(role) {

                        if (role === 'admin') {

                            return 'bg-purple-50 text-purple-700';

                        }


                        if (role === 'supervisor') {

                            return 'bg-blue-50 text-blue-700';

                        }


                        if (role === 'mechanic') {

                            return 'bg-green-50 text-green-700';

                        }


                        return 'bg-gray-100 text-gray-700';

                    },


                    /*
                    |--------------------------------------------------------------------------
                    | Reset
                    |--------------------------------------------------------------------------
                    */

                    reset() {

                        this.search = '';

                        this.sort = 'az';

                        this.filter = 'all';

                        this.role = 'all';

                    }

                };

            }
        </script>

    </div>

    @if (session('success'))
        <div
            class="mb-6 flex items-start gap-3 rounded-xl
                border border-green-200 bg-green-50 p-4"
        >

            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center
                    rounded-full bg-green-100"
            >
                <i class="ti ti-check text-lg text-green-600"></i>
            </div>

            <div>
                <p class="text-sm font-medium text-green-800">
                    Success
                </p>

                <p class="mt-0.5 text-sm text-green-700">
                    {{ session('success') }}
                </p>
            </div>

        </div>
    @endif

</x-app-layout>
