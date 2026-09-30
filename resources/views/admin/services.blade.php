<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="flex min-h-screen">

            <x-admin-sidebar />

            <main class="flex-1 min-w-0 p-8 flex flex-col gap-6">

                {{-- Header --}}
                <div class="flex items-start justify-between gap-4">

                    <div>
                        <h1 class="text-2xl font-medium">
                            Services
                        </h1>

                        <p class="text-sm text-gray-500 mt-1">
                            Manage available repair and maintenance services
                        </p>
                    </div>

                    <a
                        href="{{ route('admin.users.addservices') }}"
                        class="inline-flex items-center gap-2 bg-gray-900 text-white rounded-lg px-4 py-2 text-sm hover:bg-gray-800"
                    >
                        <i class="ti ti-plus"></i>
                        Add service
                    </a>

                </div>


                {{-- Search + Filter --}}
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center">

                    {{-- Search --}}
                    <div class="relative max-w-sm flex-1">

                        <i
                            class="ti ti-search absolute left-3 top-1/2
                                -translate-y-1/2 text-gray-400"
                        ></i>

                        <input
                            type="text"
                            id="serviceSearch"
                            placeholder="Search services..."
                            class="w-full rounded-lg border border-gray-200
                                py-2 pl-9 pr-3 text-sm
                                focus:border-gray-300
                                focus:outline-none
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
                            @click.outside="open = false"
                            class="inline-flex w-full items-center justify-center
                                gap-2 rounded-lg border border-gray-200
                                bg-white px-3 py-2 text-sm text-gray-600
                                transition hover:bg-gray-50
                                sm:w-auto"
                        >

                            <i class="ti ti-filter text-base"></i>

                            Filter

                            <i
                                class="ti ti-chevron-down text-xs transition-transform"
                                :class="{ 'rotate-180': open }"
                            ></i>

                        </button>


                        {{-- Filter Dropdown --}}
                        <div
                            x-show="open"
                            x-transition
                            x-cloak
                            class="absolute right-0 z-20 mt-2 w-48
                                rounded-xl border border-gray-200
                                bg-white p-2 shadow-lg"
                        >

                            <p class="px-3 py-2 text-xs font-medium uppercase tracking-wide text-gray-400">
                                Sort / Filter
                            </p>

                            <button
                                type="button"
                                onclick="sortServices('name-asc')"
                                @click="open = false"
                                class="flex w-full items-center gap-3 rounded-lg
                                    px-3 py-2 text-sm text-gray-700
                                    transition hover:bg-gray-50"
                            >
                                <i class="ti ti-sort-ascending text-base text-gray-400"></i>
                                A–Z
                            </button>

                            <button
                                type="button"
                                onclick="sortServices('name-desc')"
                                @click="open = false"
                                class="flex w-full items-center gap-3 rounded-lg
                                    px-3 py-2 text-sm text-gray-700
                                    transition hover:bg-gray-50"
                            >
                                <i class="ti ti-sort-descending text-base text-gray-400"></i>
                                Z–A
                            </button>

                            <button
                                type="button"
                                onclick="sortServices('price-asc')"
                                @click="open = false"
                                class="flex w-full items-center gap-3 rounded-lg
                                    px-3 py-2 text-sm text-gray-700
                                    transition hover:bg-gray-50"
                            >
                                <i class="ti ti-sort-ascending text-base text-gray-400"></i>
                                Low-High
                            </button>

                            <button
                                type="button"
                                onclick="sortServices('price-desc')"
                                @click="open = false"
                                class="flex w-full items-center gap-3 rounded-lg
                                    px-3 py-2 text-sm text-gray-700
                                    transition hover:bg-gray-50"
                            >
                                <i class="ti ti-sort-descending text-base text-gray-400"></i>
                                High-Low
                            </button>

                        </div>

                    </div>

                </div>


                {{-- Services --}}
                <div class="bg-white border border-gray-200 rounded-xl overflow-hidden">

                    {{-- Card Header --}}
                    <div class="px-5 py-4 border-b border-gray-100">

                        <p class="font-medium">
                            Service catalog
                        </p>

                        <p class="text-xs text-gray-500 mt-1">
                            Available services for job orders
                        </p>

                    </div>


                    {{-- Service List --}}
                    <div id="serviceList">

                        @forelse ($services as $service)

                            <div
                                x-data="{ editOpen: false, deleteOpen: false }"
                                class="service-item flex items-center gap-4
                                    px-5 py-4 border-b border-gray-100
                                    hover:bg-gray-50"
                                data-name="{{ strtolower($service->service_name) }}"
                                data-price="{{ $service->price }}"
                            >

                                {{-- Icon --}}
                                <div
                                    class="h-10 w-10 shrink-0 rounded-lg
                                        bg-gray-50 flex items-center justify-center"
                                >
                                    <i class="ti ti-tool text-lg text-gray-500"></i>
                                </div>


                                {{-- Service Information --}}
                                <div class="min-w-0 flex-1">

                                    <p class="font-medium text-gray-900">
                                        {{ $service->service_name }}
                                    </p>

                                    <p class="text-xs text-gray-500 mt-0.5">
                                        {{ $service->job_desc ?: 'No description provided.' }}
                                    </p>

                                </div>


                                {{-- Price --}}
                                <div class="text-right shrink-0 min-w-[100px]">

                                    <p class="text-xs text-gray-400">
                                        Price
                                    </p>

                                    <p class="font-medium text-gray-900">
                                        ₱{{ number_format($service->price, 2) }}
                                    </p>

                                </div>


                                {{-- Actions --}}
                                <div class="flex items-center gap-2 shrink-0">

                                    {{-- Edit --}}
                                    <button
                                        type="button"
                                        @click="editOpen = true"
                                        class="inline-flex items-center gap-1.5
                                            rounded-lg border border-gray-200
                                            px-3 py-2 text-sm text-gray-700
                                            transition hover:bg-gray-50"
                                    >
                                        <i class="ti ti-edit text-base"></i>
                                        Edit
                                    </button>


                                    {{-- Delete --}}
                                    <button
                                        type="button"
                                        @click="deleteOpen = true"
                                        class="inline-flex items-center gap-1.5
                                            rounded-lg border border-red-200
                                            px-3 py-2 text-sm text-red-600
                                            transition hover:bg-red-50"
                                    >
                                        <i class="ti ti-trash text-base"></i>
                                        Delete
                                    </button>

                                </div>


                                {{-- ========================================================= --}}
                                {{-- EDIT SERVICE MODAL --}}
                                {{-- ========================================================= --}}

                                <div
                                    x-show="editOpen"
                                    x-cloak
                                    x-transition.opacity
                                    @keydown.escape.window="editOpen = false"
                                    class="fixed inset-0 z-50 flex items-center justify-center
                                        bg-black/40 px-4"
                                >

                                    <div
                                        x-show="editOpen"
                                        x-transition
                                        @click.outside="editOpen = false"
                                        class="w-full max-w-lg rounded-2xl bg-white shadow-xl"
                                    >

                                        {{-- Modal Header --}}
                                        <div class="flex items-start justify-between
                                            border-b border-gray-100 px-6 py-5"
                                        >

                                            <div>

                                                <h2 class="text-lg font-semibold text-gray-900">
                                                    Edit service
                                                </h2>

                                                <p class="mt-1 text-sm text-gray-500">
                                                    Update the service information below.
                                                </p>

                                            </div>

                                            <button
                                                type="button"
                                                @click="editOpen = false"
                                                class="text-gray-400 hover:text-gray-700"
                                            >
                                                <i class="ti ti-x text-xl"></i>
                                            </button>

                                        </div>


                                        {{-- Edit Form --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.services.update', $service) }}"
                                        >

                                            @csrf
                                            @method('PUT')

                                            <div class="p-6 space-y-5">

                                                {{-- Name --}}
                                                <div>

                                                    <label
                                                        class="block text-sm font-medium text-gray-700"
                                                    >
                                                        Service name
                                                    </label>

                                                    <div class="relative mt-1.5">

                                                        <i
                                                            class="ti ti-tool absolute left-3 top-1/2
                                                                -translate-y-1/2 text-gray-400"
                                                        ></i>

                                                        <input
                                                            type="text"
                                                            name="name"
                                                            value="{{ $service->service_name }}"
                                                            required
                                                            class="block w-full rounded-lg
                                                                border border-gray-200
                                                                py-2.5 pl-10 pr-3 text-sm
                                                                focus:border-gray-400
                                                                focus:outline-none
                                                                focus:ring-2 focus:ring-gray-100"
                                                        >

                                                    </div>

                                                </div>


                                                {{-- Description --}}
                                                <div>

                                                    <label
                                                        class="block text-sm font-medium text-gray-700"
                                                    >
                                                        Description
                                                    </label>

                                                    <textarea
                                                        name="description"
                                                        rows="4"
                                                        class="mt-1.5 block w-full resize-none
                                                            rounded-lg border border-gray-200
                                                            px-3 py-2.5 text-sm
                                                            focus:border-gray-400
                                                            focus:outline-none
                                                            focus:ring-2 focus:ring-gray-100"
                                                    >{{ $service->job_desc }}</textarea>

                                                </div>


                                                {{-- Price --}}
                                                <div>

                                                    <label
                                                        class="block text-sm font-medium text-gray-700"
                                                    >
                                                        Price
                                                    </label>

                                                    <div class="relative mt-1.5">

                                                        <span
                                                            class="absolute left-3 top-1/2
                                                                -translate-y-1/2 text-sm text-gray-400"
                                                        >
                                                            ₱
                                                        </span>

                                                        <input
                                                            type="number"
                                                            name="price"
                                                            value="{{ $service->price }}"
                                                            min="0"
                                                            step="0.01"
                                                            required
                                                            class="block w-full rounded-lg
                                                                border border-gray-200
                                                                py-2.5 pl-8 pr-3 text-sm
                                                                focus:border-gray-400
                                                                focus:outline-none
                                                                focus:ring-2 focus:ring-gray-100"
                                                        >

                                                    </div>

                                                </div>

                                            </div>


                                            {{-- Modal Actions --}}
                                            <div
                                                class="flex justify-end gap-2
                                                    border-t border-gray-100 px-6 py-4"
                                            >

                                                <button
                                                    type="button"
                                                    @click="editOpen = false"
                                                    class="rounded-lg border border-gray-200
                                                        px-4 py-2.5 text-sm text-gray-700
                                                        hover:bg-gray-50"
                                                >
                                                    Cancel
                                                </button>

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-2
                                                        rounded-lg bg-gray-900
                                                        px-4 py-2.5 text-sm font-medium
                                                        text-white hover:bg-gray-800"
                                                >
                                                    <i class="ti ti-device-floppy"></i>
                                                    Save changes
                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>


                                {{-- ========================================================= --}}
                                {{-- DELETE CONFIRMATION MODAL --}}
                                {{-- ========================================================= --}}

                                <div
                                    x-show="deleteOpen"
                                    x-cloak
                                    x-transition.opacity
                                    @keydown.escape.window="deleteOpen = false"
                                    class="fixed inset-0 z-50 flex items-center justify-center
                                        bg-black/40 px-4"
                                >

                                    <div
                                        x-show="deleteOpen"
                                        x-transition
                                        @click.outside="deleteOpen = false"
                                        class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
                                    >

                                        {{-- Delete Icon --}}
                                        <div
                                            class="flex h-11 w-11 items-center justify-center
                                                rounded-full bg-red-100"
                                        >
                                            <i class="ti ti-trash text-xl text-red-600"></i>
                                        </div>


                                        {{-- Message --}}
                                        <div class="mt-4">

                                            <h2 class="text-lg font-semibold text-gray-900">
                                                Delete service?
                                            </h2>

                                            <p class="mt-1 text-sm text-gray-500">
                                                Are you sure you want to delete
                                                <span class="font-medium text-gray-700">
                                                    "{{ $service->service_name }}"
                                                </span>?
                                                This action cannot be undone.
                                            </p>

                                        </div>


                                        {{-- Delete Form --}}
                                        <form
                                            method="POST"
                                            action="{{ route('admin.services.destroy', $service) }}"
                                            class="mt-6"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <div class="flex justify-end gap-2">

                                                <button
                                                    type="button"
                                                    @click="deleteOpen = false"
                                                    class="rounded-lg border border-gray-200
                                                        px-4 py-2.5 text-sm text-gray-700
                                                        hover:bg-gray-50"
                                                >
                                                    Cancel
                                                </button>

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center gap-2
                                                        rounded-lg bg-red-600
                                                        px-4 py-2.5 text-sm font-medium
                                                        text-white hover:bg-red-700"
                                                >
                                                    <i class="ti ti-trash"></i>
                                                    Delete service
                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                        @empty

                            {{-- Empty State --}}
                            <div class="px-5 py-12 text-center">

                                <div
                                    class="mx-auto flex h-12 w-12
                                        items-center justify-center
                                        rounded-full bg-gray-50"
                                >
                                    <i class="ti ti-tool text-xl text-gray-400"></i>
                                </div>

                                <h3 class="mt-4 text-sm font-medium text-gray-900">
                                    No services found
                                </h3>

                                <p class="mt-1 text-sm text-gray-500">
                                    Add your first service to start building
                                    your service catalog.
                                </p>

                                <a
                                    href="{{ route('admin.users.addservices') }}"
                                    class="mt-4 inline-flex items-center gap-2
                                        rounded-lg bg-gray-900 px-4 py-2
                                        text-sm font-medium text-white
                                        hover:bg-gray-800"
                                >
                                    <i class="ti ti-plus"></i>
                                    Add service
                                </a>

                            </div>

                        @endforelse

                    </div>

                </div>

            </main>

        </div>

    </div>


    {{-- Success Modal --}}
    @if (session('success'))

        <div
            x-data="{ show: true }"
            x-show="show"
            x-cloak
            x-transition.opacity
            class="fixed inset-0 z-50 flex items-center justify-center
                bg-black/40 px-4"
        >

            <div
                x-show="show"
                x-transition
                @click.outside="show = false"
                class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
            >

                <div class="flex items-start gap-4">

                    <div
                        class="flex h-11 w-11 shrink-0 items-center
                            justify-center rounded-full bg-green-100"
                    >
                        <i class="ti ti-check text-xl text-green-600"></i>
                    </div>

                    <div class="flex-1">

                        <h2 class="text-lg font-semibold text-gray-900">
                            Service added
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

                <div class="mt-6 flex justify-end">

                    <button
                        type="button"
                        @click="show = false"
                        class="rounded-lg bg-gray-900 px-4 py-2.5
                            text-sm font-medium text-white
                            transition hover:bg-gray-800"
                    >
                        OK
                    </button>

                </div>

            </div>

        </div>

    @endif


    {{-- Search + Sorting Script --}}
    <script>

        const searchInput = document.getElementById('serviceSearch');

        if (searchInput) {

            searchInput.addEventListener('input', function () {

                const search = this.value.toLowerCase().trim();

                const services = document.querySelectorAll('.service-item');

                services.forEach(function (service) {

                    const name = service.dataset.name;

                    if (name.includes(search)) {
                        service.classList.remove('hidden');
                    } else {
                        service.classList.add('hidden');
                    }

                });

            });

        }


        function sortServices(type) {

            const list = document.getElementById('serviceList');

            if (!list) {
                return;
            }

            const services = Array.from(
                list.querySelectorAll('.service-item')
            );

            services.sort(function (a, b) {

                if (type === 'name-asc') {

                    return a.dataset.name.localeCompare(
                        b.dataset.name
                    );

                }

                if (type === 'name-desc') {

                    return b.dataset.name.localeCompare(
                        a.dataset.name
                    );

                }

                if (type === 'price-asc') {

                    return Number(a.dataset.price)
                        - Number(b.dataset.price);

                }

                if (type === 'price-desc') {

                    return Number(b.dataset.price)
                        - Number(a.dataset.price);

                }

                return 0;

            });

            services.forEach(function (service) {
                list.appendChild(service);
            });

        }

    </script>

</x-app-layout>