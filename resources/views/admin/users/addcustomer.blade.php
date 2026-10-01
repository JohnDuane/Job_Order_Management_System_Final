<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="flex min-h-screen">

            {{-- Admin Sidebar --}}
            <x-admin-sidebar />


            {{-- Main Content --}}
            <main class="flex-1 min-w-0 p-6 sm:p-8">

                {{-- Header --}}
                <div class="mb-6">

                    <div class="flex items-center gap-2 text-sm text-gray-400 mb-3">

                        <a
                            href="{{ route('admin.customers') }}"
                            class="hover:text-gray-700"
                        >
                            Customers
                        </a>

                        <i class="ti ti-chevron-right text-xs"></i>

                        <span class="text-gray-600">
                            Add customer
                        </span>

                    </div>

                    <h1 class="text-2xl font-medium">
                        Add customer
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Add a new customer to the system.
                    </p>

                </div>


                {{-- Form --}}
                <form
                    method="POST"
                    action="{{ route('admin.users.addcustomer.store') }}"
                    class="max-w-3xl"
                >

                    @csrf


                    {{-- Customer Information --}}
                    <div class="rounded-xl border border-gray-200 bg-white">

                        <div class="border-b border-gray-100 px-5 py-4">

                            <p class="font-medium">
                                Customer information
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Enter the customer's basic information.
                            </p>

                        </div>


                        <div class="p-5">

                            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">


                                {{-- First Name --}}
                                <div>

                                    <label
                                        for="first_name"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        First name
                                    </label>

                                    <input
                                        id="first_name"
                                        type="text"
                                        name="first_name"
                                        value="{{ old('first_name') }}"
                                        placeholder="Juan"
                                        class="mt-1.5 block w-full rounded-lg border border-gray-200
                                               px-3 py-2.5 text-sm
                                               placeholder:text-gray-400
                                               focus:border-gray-400 focus:outline-none
                                               focus:ring-2 focus:ring-gray-100"
                                    >

                                    @error('first_name')
                                        <p class="mt-1.5 text-xs text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                                <div>

                                    <label
                                        for="middle_name"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Middle name
                                    </label>

                                    <input
                                        id="middle_name"
                                        type="text"
                                        name="middle_name"
                                        value="{{ old('middle_name') }}"
                                        placeholder="Juan"
                                        class="mt-1.5 block w-full rounded-lg border border-gray-200
                                               px-3 py-2.5 text-sm
                                               placeholder:text-gray-400
                                               focus:border-gray-400 focus:outline-none
                                               focus:ring-2 focus:ring-gray-100"
                                    >

                                    @error('middle_name')
                                        <p class="mt-1.5 text-xs text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Last Name --}}
                                <div>

                                    <label
                                        for="last_name"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Last name
                                    </label>

                                    <input
                                        id="last_name"
                                        type="text"
                                        name="last_name"
                                        value="{{ old('last_name') }}"
                                        placeholder="Dela Cruz"
                                        class="mt-1.5 block w-full rounded-lg border border-gray-200
                                               px-3 py-2.5 text-sm
                                               placeholder:text-gray-400
                                               focus:border-gray-400 focus:outline-none
                                               focus:ring-2 focus:ring-gray-100"
                                    >

                                    @error('last_name')
                                        <p class="mt-1.5 text-xs text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Contact Number --}}
                                <div>

                                    <label
                                        for="contact_number"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Contact number
                                    </label>

                                    <div class="relative mt-1.5">

                                        <i class="ti ti-phone absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>

                                        <input
                                            id="contact_number"
                                            type="text"
                                            name="contact_number"
                                            value="{{ old('contact_number') }}"
                                            placeholder="09XXXXXXXXX"
                                            class="block w-full rounded-lg border border-gray-200
                                                   py-2.5 pl-10 pr-3 text-sm
                                                   placeholder:text-gray-400
                                                   focus:border-gray-400 focus:outline-none
                                                   focus:ring-2 focus:ring-gray-100"
                                        >

                                        

                                    </div>

                                    @error('contact_number')
                                        <p class="mt-1.5 text-xs text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Address --}}
                                <div class="sm:col-span-2">

                                    <label
                                        for="address"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Address
                                    </label>

                                    <textarea
                                        id="address"
                                        name="address"
                                        rows="3"
                                        placeholder="Enter customer's address"
                                        class="mt-1.5 block w-full resize-none rounded-lg border border-gray-200
                                               px-3 py-2.5 text-sm
                                               placeholder:text-gray-400
                                               focus:border-gray-400 focus:outline-none
                                               focus:ring-2 focus:ring-gray-100"
                                    >{{ old('address') }}</textarea>


                                @error('address')
                                    <p class="mt-1.5 text-xs text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror
                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Actions --}}
                    <div class="mt-5 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                        <a
                            href="{{ route('admin.customers') }}"
                            class="inline-flex items-center justify-center rounded-lg
                                   border border-gray-200 px-4 py-2.5 text-sm
                                   text-gray-700 hover:bg-gray-50"
                        >
                            Cancel
                        </a>

                        <button
                            type="submit"
                            class="inline-flex items-center justify-center gap-2
                                   rounded-lg bg-gray-900 px-4 py-2.5 text-sm
                                   font-medium text-white hover:bg-gray-800"
                        >
                            <i class="ti ti-user-plus"></i>
                            Add customer
                        </button>

                    </div>

                </form>

            </main>

        </div>

    </div>



    {{-- Success Modal --}}
@if (session('success'))

    <div
        x-data="{ show: true }"
        x-show="show"
        x-transition
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4"
    >

        <div
            @click.outside="show = false"
            class="w-full max-w-md rounded-2xl bg-white p-6 shadow-xl"
        >

            {{-- Header --}}
            <div class="flex items-start gap-4">

                <div
                    class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-green-100"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 0 1-6.364 0M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0ZM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75Zm-.375 0h.008v.015h-.008V9.75Z" />
                    </svg>

                </div>

                <div class="flex-1">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Customer added
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        {{ session('success') }}
                    </p>

                </div>

            </div>


            {{-- Vehicle Question --}}
            <div class="mt-5 rounded-xl bg-gray-50 p-4">

                <div class="flex items-start gap-3">

                    <i class="ti ti-car text-lg text-gray-500"></i>

                    <div>

                        <p class="text-sm font-medium text-gray-800">
                            Add a vehicle?
                        </p>

                        <p class="mt-1 text-xs leading-5 text-gray-500">
                            Would you like to add a vehicle for this customer now?
                        </p>

                    </div>

                </div>

            </div>


            {{-- Actions --}}
            <div class="mt-6 flex flex-col-reverse gap-2 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('admin.customers') }}"
                    class="rounded-lg border border-gray-200 px-4 py-2.5
                        text-sm font-medium text-gray-700
                        transition hover:bg-gray-50
                        text-center"
                >
                    Not now
                </a>


                <a
                    href="{{ route('admin.users.addvehicles', ['customer' => session('customer_id')]) }}"
                    class="rounded-lg bg-gray-900 px-4 py-2.5
                        text-sm font-medium text-white
                        transition hover:bg-gray-800
                        text-center"
                >
                    Add vehicle
                </a>

            </div>

        </div>

    </div>

@endif

</x-app-layout>