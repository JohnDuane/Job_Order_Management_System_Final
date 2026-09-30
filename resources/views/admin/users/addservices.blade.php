<x-app-layout>

    <div class="min-h-screen bg-white text-gray-900">

        <div class="flex min-h-screen">

            {{-- Admin Sidebar --}}
            <x-admin-sidebar />


            {{-- Main Content --}}
            <main class="flex-1 min-w-0 p-6 sm:p-8">

                {{-- Header --}}
                <div class="mb-6">

                    <div class="mb-3 flex items-center gap-2 text-sm text-gray-400">

                        <a
                            href="{{ route('admin.services') }}"
                            class="hover:text-gray-700"
                        >
                            Services
                        </a>

                        <i class="ti ti-chevron-right text-xs"></i>

                        <span class="text-gray-600">
                            Add service
                        </span>

                    </div>

                    <h1 class="text-2xl font-medium">
                        Add service
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Add a service that can be used in job orders.
                    </p>

                </div>


                {{-- Form --}}
                <form
                    method="POST"
                    action="{{ route('admin.services.store') }}"
                    class="max-w-3xl"
                >
                    @csrf


                    {{-- Service Information --}}
                    <div class="rounded-xl border border-gray-200 bg-white">

                        <div class="border-b border-gray-100 px-5 py-4">

                            <p class="font-medium">
                                Service information
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Provide the name and details of the service.
                            </p>

                        </div>


                        <div class="p-5">

                            <div class="flex flex-col gap-5">


                                {{-- Service Name --}}
                                <div>

                                    <label
                                        for="name"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Service name
                                    </label>

                                    <div class="relative mt-1.5">

                                        <i class="ti ti-tool absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>

                                        <input
                                            id="name"
                                            type="text"
                                            name="name"
                                            value="{{ old('name') }}"
                                            placeholder="e.g. Brake repair"
                                            required
                                            class="block w-full rounded-lg border border-gray-200
                                                   py-2.5 pl-10 pr-3 text-sm
                                                   placeholder:text-gray-400
                                                   focus:border-gray-400 focus:outline-none
                                                   focus:ring-2 focus:ring-gray-100"
                                        >

                                    </div>

                                    @error('name')
                                        <p class="mt-1.5 text-xs text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>


                                {{-- Description --}}
                                <div>

                                    <label
                                        for="description"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Description
                                    </label>

                                    <textarea
                                        id="description"
                                        name="description"
                                        rows="5"
                                        placeholder="Describe what this service covers..."
                                        class="mt-1.5 block w-full resize-none rounded-lg
                                               border border-gray-200 px-3 py-2.5 text-sm
                                               placeholder:text-gray-400
                                               focus:border-gray-400 focus:outline-none
                                               focus:ring-2 focus:ring-gray-100"
                                    >{{ old('description') }}</textarea>

                                    @error('description')
                                        <p class="mt-1.5 text-xs text-red-600">
                                            {{ $message }}
                                        </p>
                                    @enderror

                                </div>

                                {{-- Price --}}
                                <div>

                                    <label
                                        for="price"
                                        class="block text-sm font-medium text-gray-700"
                                    >
                                        Price
                                    </label>

                                    <div class="relative mt-1.5">

                                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400">
                                            ₱
                                        </span>

                                        <input
                                            id="price"
                                            type="number"
                                            name="price"
                                            value="{{ old('price') }}"
                                            placeholder="0.00"
                                            min="0"
                                            step="0.01"
                                            required
                                            class="block w-full rounded-lg border border-gray-200
                                                py-2.5 pl-8 pr-3 text-sm
                                                placeholder:text-gray-400
                                                focus:border-gray-400 focus:outline-none
                                                focus:ring-2 focus:ring-gray-100"
                                        >

                                    </div>

                                    @error('price')
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
                            href="{{ route('admin.services') }}"
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
                            <i class="ti ti-plus"></i>
                            Add service
                        </button>

                    </div>

                </form>

            </main>

        </div>

    </div>

</x-app-layout>