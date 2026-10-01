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

    <header class="sticky top-0 z-50 border-b border-gray-200 bg-white/95 backdrop-blur">

        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-4 lg:px-8">

            {{-- Logo --}}
            <a
                href="{{ url('/') }}"
                class="flex items-center"
            >

                <img
                    src="{{ asset('images/logobsa.png') }}"
                    alt="BSA Auto Repair Shop"
                    class="h-11 w-auto object-contain"
                >

            </a>


            {{-- Desktop Navigation --}}
            <nav class="hidden items-center gap-8 md:flex">

                <a
                    href="#services"
                    class="text-sm text-gray-500 transition hover:text-red-600"
                >
                    Services
                </a>

                <a
                    href="#about"
                    class="text-sm text-gray-500 transition hover:text-red-600"
                >
                    About
                </a>

                <a
                    href="#contact"
                    class="text-sm text-gray-500 transition hover:text-red-600"
                >
                    Contact
                </a>

            </nav>


            {{-- Login --}}
            <a
                href="{{ route('login') }}"
                class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-red-600"
            >

                <i class="ti ti-login text-base"></i>

                Login

            </a>

        </div>

    </header>



    {{-- ========================================================= --}}
    {{-- HERO --}}
    {{-- ========================================================= --}}

    <section class="relative overflow-hidden border-b border-gray-200">

        {{-- Decorative red accent --}}
        <div class="absolute -right-32 -top-32 h-80 w-80 rounded-full bg-red-50"></div>

        <div class="absolute -bottom-40 -left-40 h-80 w-80 rounded-full bg-red-50"></div>


        <div class="relative mx-auto grid max-w-7xl items-center gap-14 px-5 py-20 lg:grid-cols-2 lg:px-8 lg:py-28">


            {{-- Hero Text --}}
            <div>

                


                <h1 class="max-w-2xl text-4xl font-semibold leading-tight tracking-tight sm:text-5xl lg:text-6xl">

                    Reliable care for
                    <span class="text-red-600">
                        every road.
                    </span>

                </h1>


                <p class="mt-6 max-w-xl text-base leading-7 text-gray-500">

                    Professional vehicle repair and maintenance
                    services for cars, trucks, SUVs, and other
                    vehicles at BSA Auto Repair Shop.

                </p>


                {{-- Buttons --}}
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">

                    <a
                        href="#services"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-red-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-red-700"
                    >

                        View our services

                        <i class="ti ti-arrow-right"></i>

                    </a>


                    <a
                        href="#contact"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-200 bg-white px-5 py-3 text-sm font-medium text-gray-700 transition hover:border-gray-300 hover:bg-gray-50"
                    >

                        <i class="ti ti-map-pin"></i>

                        Visit our shop

                    </a>

                </div>


                {{-- Small trust information --}}
                <div class="mt-8 flex flex-wrap items-center gap-6">

                    <div class="flex items-center gap-2">

                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-50">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 2.994v2.25m10.5-2.25v2.25m-14.252 13.5V7.491a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v11.251m-18 0a2.25 2.25 0 0 0 2.25 2.25h13.5a2.25 2.25 0 0 0 2.25-2.25m-18 0v-7.5a2.25 2.25 0 0 1 2.25-2.25h13.5a2.25 2.25 0 0 1 2.25 2.25v7.5m-6.75-6h2.25m-9 2.25h4.5m.002-2.25h.005v.006H12v-.006Zm-.001 4.5h.006v.006h-.006v-.005Zm-2.25.001h.005v.006H9.75v-.006Zm-2.25 0h.005v.005h-.006v-.005Zm6.75-2.247h.005v.005h-.005v-.005Zm0 2.247h.006v.006h-.006v-.006Zm2.25-2.248h.006V15H16.5v-.005Z" />
                            </svg>

                        </div>

                        <div>

                            <p class="text-sm font-medium">
                                Since 2016
                            </p>

                            <p class="text-[11px] text-gray-400">
                                Serving customers
                            </p>

                        </div>

                    </div>


                    <div class="h-8 w-px bg-gray-200"></div>


                    <div class="flex items-center gap-2">

                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-gray-900">

                            <i class="ti ti-car text-sm text-white"></i>

                        </div>

                        <div>

                            <p class="text-sm font-medium">
                                Complete care
                            </p>

                            <p class="text-[11px] text-gray-400">
                                Repair & maintenance
                            </p>

                        </div>

                    </div>

                </div>

            </div>



            {{-- Hero Visual --}}
            <div class="relative">

                <div class="relative overflow-hidden rounded-2xl bg-gray-950">

                    {{-- Red accent --}}
                    <div class="absolute -right-20 -top-20 h-56 w-56 rounded-full bg-red-600/20"></div>

                    <div class="absolute -bottom-24 -left-20 h-64 w-64 rounded-full bg-red-600/10"></div>


                    <div class="relative flex min-h-[380px] items-center justify-center p-8">

                        <div class="text-center">

                            <div class="mx-auto flex h-30 w-30 items-center justify-center rounded-2xl shadow-lg">

                                <img
                                    src="{{ asset('images/logobsa.png') }}"
                                    alt="BSA Auto Repair Shop Logo"
                                    class="max-h-20 w-auto object-contain"
                                >

                            </div>


                            <p class="mt-6 text-base font-medium text-white">
                                BSA Auto Repair Shop
                            </p>

                            <p class="mt-1 text-xs text-gray-400">
                                Repair · Maintenance · Service
                            </p>


                            <div class="mx-auto mt-6 flex items-center justify-center gap-2">

                                <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                <span class="text-[11px] uppercase tracking-[0.2em] text-gray-500">
                                    Carmen, Davao del Norte
                                </span>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Floating info card --}}
                <div class="absolute -bottom-6 left-5 rounded-xl border border-gray-200 bg-white p-4 shadow-lg sm:left-8">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-red-50">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.25c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 0 1 2.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 0 0 .322-1.672V2.75a.75.75 0 0 1 .75-.75 2.25 2.25 0 0 1 2.25 2.25c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282m0 0h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 0 1-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 0 0-1.423-.23H5.904m10.598-9.75H14.25M5.904 18.5c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 0 1-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 9.953 4.167 9.5 5 9.5h1.053c.472 0 .745.556.5.96a8.958 8.958 0 0 0-1.302 4.665c0 1.194.232 2.333.654 3.375Z" />
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs text-gray-400">
                                Your vehicle
                            </p>

                            <p class="text-sm font-medium">
                                In trusted hands
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

                <div class="flex items-center gap-2">

                    <span class="h-px w-8 bg-red-600"></span>

                    <p class="text-xs font-semibold uppercase tracking-wider text-red-600">
                        Our services
                    </p>

                </div>


                <h2 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">
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
                <div class="group rounded-xl border border-gray-200 bg-white p-5 transition hover:-translate-y-1 hover:border-red-200 hover:shadow-md">

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-50 transition group-hover:bg-red-600">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15 11.25 1.5 1.5.75-.75V8.758l2.276-.61a3 3 0 1 0-3.675-3.675l-.61 2.277H12l-.75.75 1.5 1.5M15 11.25l-8.47 8.47c-.34.34-.8.53-1.28.53s-.94.19-1.28.53l-.97.97-.75-.75.97-.97c.34-.34.53-.8.53-1.28s.19-.94.53-1.28L12.75 9M15 11.25 12.75 9" />
                            </svg>


                    </div>


                    <h3 class="mt-5 text-sm font-semibold">
                        Oil Change
                    </h3>


                    <p class="mt-2 text-xs leading-5 text-gray-500">
                        Routine oil service to help keep your engine running smoothly.
                    </p>

                </div>



                {{-- Brake Repair --}}
                <div class="group rounded-xl border border-gray-200 bg-white p-5 transition hover:-translate-y-1 hover:border-red-200 hover:shadow-md">

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-50 transition group-hover:bg-red-600">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                        </svg>

                    </div>


                    <h3 class="mt-5 text-sm font-semibold">
                        Brake Repair
                    </h3>


                    <p class="mt-2 text-xs leading-5 text-gray-500">
                        Brake inspection and repair for safer vehicle operation.
                    </p>

                </div>



                {{-- Engine Check --}}
                <div class="group rounded-xl border border-gray-200 bg-white p-5 transition hover:-translate-y-1 hover:border-red-200 hover:shadow-md">

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-50 transition group-hover:bg-red-600">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>

                    </div>


                    <h3 class="mt-5 text-sm font-semibold">
                        Engine Check
                    </h3>


                    <p class="mt-2 text-xs leading-5 text-gray-500">
                        Inspection and maintenance for common engine-related concerns.
                    </p>

                </div>



                {{-- General Repair --}}
                <div class="group rounded-xl border border-gray-200 bg-white p-5 transition hover:-translate-y-1 hover:border-red-200 hover:shadow-md">

                    <div class="flex h-11 w-11 items-center justify-center rounded-lg bg-red-50 transition group-hover:bg-red-600">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 0 1-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1 1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276 3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008Z" />
                        </svg>

                    </div>


                    <h3 class="mt-5 text-sm font-semibold">
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
        class="scroll-mt-20 border-y border-gray-200 bg-gray-50"
    >

        <div class="mx-auto grid max-w-7xl gap-12 px-5 py-20 lg:grid-cols-2 lg:px-8">


            {{-- About Text --}}
            <div>

                <div class="flex items-center gap-2">

                    <span class="h-px w-8 bg-red-600"></span>

                    <p class="text-xs font-semibold uppercase tracking-wider text-red-600">
                        About BSA
                    </p>

                </div>


                <h2 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">
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


                <div class="mt-7 flex items-center gap-3">

                    <div class="h-10 w-1 rounded-full bg-red-600"></div>

                    <p class="text-sm font-medium text-gray-700">
                        Reliable service. Practical solutions. Better vehicle care.
                    </p>

                </div>

            </div>



            {{-- Stats --}}
            <div class="grid grid-cols-2 gap-3 self-center">


                <div class="rounded-xl border border-gray-200 bg-white p-5 transition hover:border-red-200">

                    <p class="text-3xl font-semibold text-red-600">
                        2016
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Established
                    </p>

                </div>


                <div class="rounded-xl border border-gray-200 bg-white p-5 transition hover:border-red-200">

                    <p class="text-3xl font-semibold">
                        6
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Shop personnel
                    </p>

                </div>


                <div class="rounded-xl border border-gray-200 bg-white p-5 transition hover:border-red-200">

                    <p class="text-3xl font-semibold text-red-600">
                        4+
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Service categories
                    </p>

                </div>


                <div class="rounded-xl border border-gray-200 bg-white p-5 transition hover:border-red-200">

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                        </svg>

                    </div>

                    <p class="mt-3 text-xs text-gray-500">
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

            <div class="relative overflow-hidden rounded-2xl bg-gray-950 px-6 py-12 text-white sm:px-10 lg:px-14">


                {{-- Red decorative shape --}}
                <div class="absolute -right-20 -top-32 h-80 w-80 rounded-full bg-red-600/20"></div>

                <div class="absolute -bottom-40 left-1/3 h-72 w-72 rounded-full bg-red-600/10"></div>


                <div class="relative flex flex-col items-start justify-between gap-8 md:flex-row md:items-center">

                    <div class="max-w-xl">

                        <div class="flex items-center gap-2">

                            <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                            <p class="text-xs font-medium uppercase tracking-wider text-red-400">
                                BSA Job Order Management System
                            </p>

                        </div>


                        <h2 class="mt-3 text-2xl font-semibold sm:text-3xl">
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
                        class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-red-600 px-5 py-3 text-sm font-medium text-white transition hover:bg-red-700"
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
        class="scroll-mt-20 border-t border-gray-200"
    >

        <div class="mx-auto max-w-7xl px-5 py-20 lg:px-8">

            <div class="grid gap-10 md:grid-cols-2">


                {{-- Contact Header --}}
                <div>

                    <div class="flex items-center gap-2">

                        <span class="h-px w-8 bg-red-600"></span>

                        <p class="text-xs font-semibold uppercase tracking-wider text-red-600">
                            Visit us
                        </p>

                    </div>


                    <h2 class="mt-3 text-3xl font-semibold tracking-tight sm:text-4xl">
                        Get your vehicle serviced.
                    </h2>


                    <p class="mt-4 max-w-md text-sm leading-6 text-gray-500">

                        Visit BSA Auto Repair Shop for your vehicle
                        repair and maintenance needs.

                    </p>


                    {{-- Logo --}}
                    <div class="mt-7">

                        <img
                            src="{{ asset('images/logobsa.png') }}"
                            alt="BSA Auto Repair Shop"
                            class="h-14 w-auto object-contain"
                        >

                    </div>

                </div>



                {{-- Contact Information --}}
                <div class="space-y-4">


                    {{-- Location --}}
                    <div class="group flex items-start gap-4 rounded-xl border border-gray-200 bg-white p-4 transition hover:border-red-200">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>


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



                    {{-- Services --}}
                    <div class="group flex items-start gap-4 rounded-xl border border-gray-200 bg-white p-4 transition hover:border-red-200">

                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-red-50">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L2.25 3.75l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
                            </svg>


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



                    {{-- System --}}
                    <div class="group flex items-start gap-4 rounded-xl border border-gray-200 bg-white p-4 transition hover:border-red-200">

                        <div class="group flex items-start gap-4 rounded-xl border border-gray-200 bg-white p-4 transition hover:border-red-200">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 0 0 2.25-2.25V6.75a2.25 2.25 0 0 0-2.25-2.25H6.75A2.25 2.25 0 0 0 4.5 6.75v10.5a2.25 2.25 0 0 0 2.25 2.25Zm.75-12h9v9h-9v-9Z" />
                            </svg>

                        </div>


                        <div>

                            <p class="text-sm font-medium">
                                Digital job orders
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Organized customer, vehicle, service, and job order records.
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

    <footer class="border-t border-gray-200 bg-gray-950">

        <div class="mx-auto flex max-w-7xl flex-col gap-5 px-5 py-8 sm:flex-row sm:items-center sm:justify-between lg:px-8">


            <div class="flex items-center gap-3">

                <img
                    src="{{ asset('images/logobsa.png') }}"
                    alt="BSA Auto Repair Shop"
                    class="h-10 w-auto rounded-md bg-white object-contain p-1"
                >

                <div>

                    <p class="text-sm font-medium text-white">
                        BSA Auto Repair Shop
                    </p>

                    <p class="mt-1 text-xs text-gray-500">
                        Vehicle repair and maintenance
                    </p>

                </div>

            </div>


            <div class="text-left sm:text-right">

                <p class="text-xs text-gray-500">
                    © {{ date('Y') }} BSA Auto Repair Shop.
                </p>

                <p class="mt-1 text-xs text-gray-600">
                    All rights reserved.
                </p>

            </div>

        </div>

    </footer>


</body>

</html>