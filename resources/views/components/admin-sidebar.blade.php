{{-- ========================================================= --}}
{{-- DESKTOP SIDEBAR --}}
{{-- ========================================================= --}}

<aside
    class="hidden lg:flex w-56 shrink-0 h-screen sticky top-0
           bg-[#fff9f9] border-r border-gray-200
           p-4 flex-col"
>

    {{-- Logo --}}
    <div class="flex items-center justify-center px-2 pb-6 pt-1">

        <img
            src="{{ asset('images/logobsa.png') }}"
            alt="BSA Auto Repair Shop"
            class="h-13 w-auto object-contain"
        >

    </div>


    {{-- Navigation --}}
    <nav class="flex flex-col gap-1">

        <a
            href="{{ route('admin.dashboard') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg
            {{ request()->routeIs('admin.dashboard')
                ? 'bg-[#f5d1d1] shadow-sm font-medium text-gray-900'
                : 'text-gray-500 hover:bg-white/70' }}"
        >
            <i class="ti ti-layout-dashboard text-base"></i>
            Dashboard
        </a>


        <a
            href="{{ route('admin.customers') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg
            {{ request()->routeIs('admin.customers')
                ? 'bg-[#f5d1d1] shadow-sm font-medium text-gray-900'
                : 'text-gray-500 hover:bg-white/70' }}"
        >
            <i class="ti ti-users text-base"></i>
            Customers
        </a>


        <a
            href="{{ route('admin.vehicles') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg
            {{ request()->routeIs('admin.vehicles')
                ? 'bg-[#f5d1d1] shadow-sm font-medium text-gray-900'
                : 'text-gray-500 hover:bg-white/70' }}"
        >
            <i class="ti ti-car text-base"></i>
            Vehicles
        </a>


        <a
            href="{{ route('admin.staff') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg
            {{ request()->routeIs('admin.staff')
                ? 'bg-[#f5d1d1] shadow-sm font-medium text-gray-900'
                : 'text-gray-500 hover:bg-white/70' }}"
        >
            <i class="ti ti-user-check text-base"></i>
            Staff
        </a>


        <a
            href="{{ route('admin.job-orders') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg
            {{ request()->routeIs('admin.job-orders')
                ? 'bg-[#f5d1d1] shadow-sm font-medium text-gray-900'
                : 'text-gray-500 hover:bg-white/70' }}"
        >
            <i class="ti ti-clipboard-list text-base"></i>
            Job orders
        </a>


        <a
            href="{{ route('admin.services') }}"
            class="flex items-center gap-2.5 px-3 py-2 rounded-lg
            {{ request()->routeIs('admin.services')
                ? 'bg-[#f5d1d1] shadow-sm font-medium text-gray-900'
                : 'text-gray-500 hover:bg-white/70' }}"
        >
            <i class="ti ti-settings text-base"></i>
            Services
        </a>

    </nav>


    {{-- User Menu --}}
    <div
        class="relative mt-auto"
        x-data="{ open: false }"
    >

        <button
            @click="open = !open"
            class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left hover:bg-[#f5d1d1]"
        >

            
            <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 text-sm font-bold text-gray-700">
                {{ auth()->user()->initials() }}
            </div>

            <div class="min-w-0 flex-1">

                <p class="truncate text-sm font-semibold text-gray-800">
                    {{ auth()->user()->name }}
                </p>

                <p class="truncate text-xs text-gray-500">
                    {{ ucfirst(auth()->user()->role) }}
                </p>

            </div>

            <i
                class="ti ti-chevron-up text-gray-400 transition-transform"
                :class="{ 'rotate-180': open }"
            ></i>

        </button>


        <div
            x-show="open"
            @click.outside="open = false"
            x-transition
            class="absolute bottom-full left-0 mb-2 w-full rounded-xl border border-gray-200 bg-white p-2 shadow-lg"
            style="display: none;"
        >

            <a
                href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100"
            >
                <i class="ti ti-user-circle text-lg"></i>
                Profile
            </a>


            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button
                    type="submit"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-red-600 hover:bg-red-50"
                >
                    <i class="ti ti-logout text-lg"></i>
                    Logout
                </button>

            </form>

        </div>

    </div>

</aside>


{{-- ========================================================= --}}
{{-- MOBILE NAVIGATION --}}
{{-- ========================================================= --}}

<div
    class="lg:hidden"
    x-data="{ mobileOpen: false }"
>

    {{-- Mobile Topbar --}}
    <header
        class="flex h-16 items-center justify-between border-b border-gray-200 bg-[#fff9f9] px-4"
    >

        <div class="flex items-center gap-3">

            <img
                src="{{ asset('images/logobsa.png') }}"
                alt="BSA Auto Repair Shop"
                class="h-10 w-auto object-contain"
            >

            <div>
                <p class="text-sm font-semibold text-gray-900">
                    Admin
                </p>

                <p class="text-xs text-gray-500">
                    BSA Auto Repair Shop
                </p>
            </div>

        </div>


        {{-- Hamburger --}}
        <button
            type="button"
            @click="mobileOpen = !mobileOpen"
            class="flex h-10 w-10 items-center justify-center rounded-lg text-gray-700 hover:bg-white"
            aria-label="Open navigation"
        >

            <i
                class="ti text-2xl"
                :class="mobileOpen ? 'ti-x' : 'ti-menu-2'"
            ></i>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>


        </button>

    </header>


    {{-- Overlay --}}
    <div
        x-show="mobileOpen"
        x-cloak
        x-transition.opacity
        @click="mobileOpen = false"
        class="fixed inset-0 z-40 bg-black/40"
    ></div>


    {{-- Mobile Drawer --}}
    <aside
        x-show="mobileOpen"
        x-cloak
        x-transition:enter="transition transform ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition transform ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-[#fff9f9] p-4 shadow-xl"
    >

        {{-- Drawer Header --}}
        <div class="flex items-center justify-between px-2 pb-6">

            <img
                src="{{ asset('images/logobsa.png') }}"
                alt="BSA Auto Repair Shop"
                class="h-12 w-auto object-contain"
            >

            <button
                type="button"
                @click="mobileOpen = false"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-white hover:text-gray-900"
            >
                <i class="ti ti-x text-xl"></i>
            </button>

        </div>


        {{-- Navigation --}}
        <nav class="flex flex-col gap-1">

            <a
                href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5
                {{ request()->routeIs('admin.dashboard')
                    ? 'bg-[#f5d1d1] font-medium text-gray-900'
                    : 'text-gray-500 hover:bg-white/70' }}"
            >
                <i class="ti ti-layout-dashboard text-lg"></i>
                Dashboard
            </a>


            <a
                href="{{ route('admin.customers') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5
                {{ request()->routeIs('admin.customers')
                    ? 'bg-[#f5d1d1] font-medium text-gray-900'
                    : 'text-gray-500 hover:bg-white/70' }}"
            >
                <i class="ti ti-users text-lg"></i>
                Customers
            </a>


            <a
                href="{{ route('admin.vehicles') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5
                {{ request()->routeIs('admin.vehicles')
                    ? 'bg-[#f5d1d1] font-medium text-gray-900'
                    : 'text-gray-500 hover:bg-white/70' }}"
            >
                <i class="ti ti-car text-lg"></i>
                Vehicles
            </a>


            <a
                href="{{ route('admin.staff') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5
                {{ request()->routeIs('admin.staff')
                    ? 'bg-[#f5d1d1] font-medium text-gray-900'
                    : 'text-gray-500 hover:bg-white/70' }}"
            >
                <i class="ti ti-user-check text-lg"></i>
                Staff
            </a>


            <a
                href="{{ route('admin.job-orders') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5
                {{ request()->routeIs('admin.job-orders')
                    ? 'bg-[#f5d1d1] font-medium text-gray-900'
                    : 'text-gray-500 hover:bg-white/70' }}"
            >
                <i class="ti ti-clipboard-list text-lg"></i>
                Job orders
            </a>


            <a
                href="{{ route('admin.services') }}"
                class="flex items-center gap-3 rounded-lg px-3 py-2.5
                {{ request()->routeIs('admin.services')
                    ? 'bg-[#f5d1d1] font-medium text-gray-900'
                    : 'text-gray-500 hover:bg-white/70' }}"
            >
                <i class="ti ti-settings text-lg"></i>
                Services
            </a>

        </nav>


        {{-- User --}}
        <div
            class="relative mt-auto"
            x-data="{ open: false }"
        >

            <button
                @click="open = !open"
                class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left hover:bg-white"
            >

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 text-sm font-bold text-gray-700">
                    {{ auth()->user()->initials() }}
                </div>

                <div class="min-w-0 flex-1">

                    <p class="truncate text-sm font-semibold text-gray-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="truncate text-xs text-gray-500">
                        {{ ucfirst(auth()->user()->role) }}
                    </p>

                </div>

                <i
                    class="ti ti-chevron-up text-gray-400 transition-transform"
                    :class="{ 'rotate-180': open }"
                ></i>

            </button>


            <div
                x-show="open"
                x-transition
                class="absolute bottom-full left-0 mb-2 w-full rounded-xl border border-gray-200 bg-white p-2 shadow-lg"
            >

                <a
                    href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-gray-700 hover:bg-gray-100"
                >
                    <i class="ti ti-user-circle text-lg"></i>
                    Profile
                </a>


                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button
                        type="submit"
                        class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-red-600 hover:bg-red-50"
                    >
                        <i class="ti ti-logout text-lg"></i>
                        Logout
                    </button>

                </form>

            </div>

        </div>

    </aside>

</div>