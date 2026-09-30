<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>
        BSA Auto Repair Shop
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tabler Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2/dist/tabler-icons.min.css"
    >
</head>


<body class="bg-white text-gray-900 antialiased">


    {{-- ========================================================= --}}
    {{-- NAVBAR --}}
    {{-- ========================================================= --}}

    <header class="border-b border-gray-100 bg-white">

        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">

            {{-- Logo --}}
            <a
                href="{{ url('/') }}"
                class="flex items-center gap-2"
            >

                <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-900">
                    <i class="ti ti-tool text-lg text-white"></i>
                </div>

                <div>
                    <p class="text-sm font-semibold">
                        BSA Auto Repair
                    </p>

                    <p class="text-[11px] text-gray-500">
                        Shop
                    </p>
                </div>

            </a>


            {{-- Desktop Navigation --}}
            <nav class="hidden items-center gap-7 md:flex">

                <a
                    href="#services"
                    class="text-sm text-gray-500 transition hover:text-gray-900"
                >
                    Services
                </a>

                <a
                    href="#about"
                    class="text-sm text-gray-500 transition hover:text-gray-900"
                >
                    About
                </a>

                <a
                    href="#contact"
                    class="text-sm text-gray-500 transition hover:text-gray-900"
                >
                    Contact
                </a>

            </nav>


            {{-- Login --}}
            <a
                href="{{ route('login') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2 text-sm text-white transition hover:bg-gray-800"
            >
                <i class="ti ti-login text-base"></i>
                Login
            </a>

        </div>

    </header>



    {{-- ========================================================= --}}
    {{-- HERO --}}
    {{-- ========================================================= --}}

    <section class="border-b border-gray-100">

        <div class="mx-auto grid max-w-7xl items-center gap-12 px-5 py-20 lg:grid-cols-2 lg:px-8 lg:py-28">


            {{-- Hero Text --}}
            <div>


                <h1 class="max-w-2xl text-4xl font-medium leading-tight tracking-tight sm:text-5xl lg:text-6xl">

                    Keeping your vehicle
                    <span class="text-gray-400">
                        ready for the road.
                    </span>

                </h1>


                <p class="mt-6 max-w-xl text-base leading-7 text-gray-500">

                    BSA Auto Repair Shop provides reliable vehicle repair
                    and maintenance services for cars, trucks, SUVs, and
                    other vehicles.

                </p>


                <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                    <a
                        href="#services"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-5 py-3 text-sm text-white transition hover:bg-gray-800"
                    >

                        View our services

                        <i class="ti ti-arrow-right"></i>

                    </a>


                    <a
                        href="#contact"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 px-5 py-3 text-sm text-gray-700 transition hover:bg-gray-50"
                    >

                        <i class="ti ti-map-pin"></i>

                        Visit our shop

                    </a>

                </div>

            </div>



            {{-- Hero Visual --}}
            <div class="relative">

                <div class="overflow-hidden rounded-2xl bg-gray-100">

                    <div class="flex min-h-[360px] items-center justify-center">

                        <div class="text-center">

                            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-2xl bg-white shadow-sm">

                                <i class="ti ti-car text-4xl text-gray-700"></i>

                            </div>

                            <p class="mt-5 text-sm font-medium">
                                BSA Auto Repair Shop
                            </p>

                            <p class="mt-1 text-xs text-gray-500">
                                Repair · Maintenance · Service
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Floating info card --}}
                <div class="absolute -bottom-5 left-5 rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:left-8">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50">

                            <i class="ti ti-calendar text-lg text-gray-700"></i>

                        </div>

                        <div>

                            <p class="text-xs text-gray-500">
                                Serving customers since
                            </p>

                            <p class="text-sm font-medium">
                                2016
                            </p>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- SERVICES --}}
    {{-- ========================================================= --}}

    <section
        id="services"
        class="scroll-mt-20"
    >

        <div class="mx-auto max-w-7xl px-5 py-20 lg:px-8">


            {{-- Section Header --}}
            <div class="max-w-xl">

                <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                    Our services
                </p>

                <h2 class="mt-2 text-3xl font-medium tracking-tight">
                    Vehicle care made simple.
                </h2>

                <p class="mt-3 text-sm leading-6 text-gray-500">
                    From routine maintenance to vehicle repairs,
                    our shop handles a range of automotive service needs.
                </p>

            </div>


            {{-- Services Grid --}}
            <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">


                {{-- Oil Change --}}
                <div class="rounded-xl border border-gray-200 p-5 transition hover:border-gray-300 hover:shadow-sm">

                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50">

                        <i class="ti ti-droplet text-lg text-gray-700"></i>

                    </div>

                    <h3 class="mt-5 text-sm font-medium">
                        Oil Change
                    </h3>

                    <p class="mt-2 text-xs leading-5 text-gray-500">
                        Routine oil service to help keep your engine running smoothly.
                    </p>

                </div>


                {{-- Brake Repair --}}
                <div class="rounded-xl border border-gray-200 p-5 transition hover:border-gray-300 hover:shadow-sm">

                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50">

                        <i class="ti ti-disc text-lg text-gray-700"></i>

                    </div>

                    <h3 class="mt-5 text-sm font-medium">
                        Brake Repair
                    </h3>

                    <p class="mt-2 text-xs leading-5 text-gray-500">
                        Brake inspection and repair for safer vehicle operation.
                    </p>

                </div>


                {{-- Engine Check --}}
                <div class="rounded-xl border border-gray-200 p-5 transition hover:border-gray-300 hover:shadow-sm">

                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50">

                        <i class="ti ti-settings text-lg text-gray-700"></i>

                    </div>

                    <h3 class="mt-5 text-sm font-medium">
                        Engine Check
                    </h3>

                    <p class="mt-2 text-xs leading-5 text-gray-500">
                        Inspection and maintenance for common engine-related concerns.
                    </p>

                </div>


                {{-- General Repair --}}
                <div class="rounded-xl border border-gray-200 p-5 transition hover:border-gray-300 hover:shadow-sm">

                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-gray-50">

                        <i class="ti ti-tool text-lg text-gray-700"></i>

                    </div>

                    <h3 class="mt-5 text-sm font-medium">
                        General Repair
                    </h3>

                    <p class="mt-2 text-xs leading-5 text-gray-500">
                        Vehicle repair and maintenance for different types of automotive needs.
                    </p>

                </div>


            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- ABOUT --}}
    {{-- ========================================================= --}}

    <section
        id="about"
        class="scroll-mt-20 border-y border-gray-100 bg-gray-50"
    >

        <div class="mx-auto grid max-w-7xl gap-12 px-5 py-20 lg:grid-cols-2 lg:px-8">


            {{-- About Text --}}
            <div>

                <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                    About BSA
                </p>

                <h2 class="mt-2 text-3xl font-medium tracking-tight">
                    A local shop built around vehicle care.
                </h2>

                <p class="mt-5 text-sm leading-7 text-gray-500">

                    BSA Auto Repair Shop was established in 2016 and
                    started as a home-based auto repair business.
                    Since then, it has grown into an established
                    vehicle repair and maintenance shop.

                </p>

                <p class="mt-4 text-sm leading-7 text-gray-500">

                    The shop serves customers in Prk 6, Ising, Carmen,
                    Davao del Norte and provides services for cars,
                    trucks, SUVs, and other types of vehicles.

                </p>

            </div>


            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-3 self-center">


                <div class="rounded-xl border border-gray-200 bg-white p-5">

                    <p class="text-3xl font-medium">
                        2016
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Established
                    </p>

                </div>


                <div class="rounded-xl border border-gray-200 bg-white p-5">

                    <p class="text-3xl font-medium">
                        6
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Shop personnel
                    </p>

                </div>


                <div class="rounded-xl border border-gray-200 bg-white p-5">

                    <p class="text-3xl font-medium">
                        4+
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Service categories
                    </p>

                </div>


                <div class="rounded-xl border border-gray-200 bg-white p-5">

                    <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-900">

                        <i class="ti ti-car text-sm text-white"></i>

                    </div>

                    <p class="mt-2 text-xs text-gray-500">
                        Cars, trucks & SUVs
                    </p>

                </div>


            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- DIGITAL SYSTEM CTA --}}
    {{-- ========================================================= --}}

    <section>

        <div class="mx-auto max-w-7xl px-5 py-20 lg:px-8">

            <div class="overflow-hidden rounded-2xl bg-gray-900 px-6 py-12 text-white sm:px-10 lg:px-14">

                <div class="flex flex-col items-start justify-between gap-8 md:flex-row md:items-center">

                    <div class="max-w-xl">

                        <p class="text-xs uppercase tracking-wider text-gray-400">
                            BSA Job Order Management System
                        </p>

                        <h2 class="mt-2 text-2xl font-medium sm:text-3xl">
                            Manage job orders with less paperwork.
                        </h2>

                        <p class="mt-3 text-sm leading-6 text-gray-400">
                            Our digital system helps organize customer,
                            vehicle, service, staff, and job order records
                            in one place.
                        </p>

                    </div>


                    <a
                        href="{{ route('login') }}"
                        class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-white px-5 py-3 text-sm font-medium text-gray-900 transition hover:bg-gray-100"
                    >

                        Access JOMS

                        <i class="ti ti-arrow-right"></i>

                    </a>

                </div>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- CONTACT --}}
    {{-- ========================================================= --}}

    <section
        id="contact"
        class="scroll-mt-20 border-t border-gray-100"
    >

        <div class="mx-auto max-w-7xl px-5 py-20 lg:px-8">

            <div class="grid gap-10 md:grid-cols-2">


                {{-- Contact Header --}}
                <div>

                    <p class="text-xs font-medium uppercase tracking-wider text-gray-400">
                        Visit us
                    </p>

                    <h2 class="mt-2 text-3xl font-medium tracking-tight">
                        Get your vehicle serviced.
                    </h2>

                    <p class="mt-4 max-w-md text-sm leading-6 text-gray-500">
                        Visit BSA Auto Repair Shop for your vehicle
                        repair and maintenance needs.
                    </p>

                </div>


                {{-- Contact Information --}}
                <div class="space-y-4">


                    <div class="flex items-start gap-4 rounded-xl border border-gray-200 p-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-50">

                            <i class="ti ti-map-pin text-lg text-gray-700"></i>

                        </div>

                        <div>

                            <p class="text-sm font-medium">
                                Location
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Prk 6, Ising, Carmen, Davao del Norte
                            </p>

                        </div>

                    </div>


                    <div class="flex items-start gap-4 rounded-xl border border-gray-200 p-4">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-50">

                            <i class="ti ti-tool text-lg text-gray-700"></i>

                        </div>

                        <div>

                            <p class="text-sm font-medium">
                                Services
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Repair and maintenance for various vehicle types
                            </p>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- FOOTER --}}
    {{-- ========================================================= --}}

    <footer class="border-t border-gray-100">

        <div class="mx-auto flex max-w-7xl flex-col gap-3 px-5 py-6 sm:flex-row sm:items-center sm:justify-between lg:px-8">

            <div>

                <p class="text-sm font-medium">
                    BSA Auto Repair Shop
                </p>

                <p class="mt-1 text-xs text-gray-400">
                    Vehicle repair and maintenance
                </p>

            </div>


            <p class="text-xs text-gray-400">
                © {{ date('Y') }} BSA Auto Repair Shop. All rights reserved.
            </p>

        </div>

    </footer>


</body>

</html>