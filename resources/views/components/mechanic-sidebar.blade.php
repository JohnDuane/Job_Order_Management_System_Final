<div x-data="{ mobileOpen: false }">

    {{-- ========================================================= --}}
    {{-- MOBILE TOP NAVIGATION --}}
    {{-- ========================================================= --}}

    <header class="md:hidden sticky top-0 z-40 border-b border-gray-200 bg-[#fbfff9]">

        <div class="flex h-16 items-center justify-between px-4">

            <img
                src="{{ asset('images/logobsa.png') }}"
                alt="BSA Auto Repair Shop"
                class="h-10 w-auto object-contain"
            >

            <button
                type="button"
                @click="mobileOpen = !mobileOpen"
                class="flex h-10 w-10 items-center justify-center rounded-lg text-gray-600 hover:bg-white"
                aria-label="Toggle navigation"
            >
                <i
                    class="ti text-2xl"
                    :class="mobileOpen ? 'ti-x' : 'ti-menu-2'"
                ></i>

                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>

            </button>

        </div>

    </header>


    {{-- ========================================================= --}}
    {{-- MOBILE OVERLAY --}}
    {{-- ========================================================= --}}

    <div
        x-show="mobileOpen"
        x-cloak
        x-transition.opacity
        @click="mobileOpen = false"
        class="fixed inset-0 z-40 bg-black/40 md:hidden"
    ></div>


    {{-- ========================================================= --}}
    {{-- MOBILE SIDEBAR --}}
    {{-- ========================================================= --}}

    <aside
        x-show="mobileOpen"
        x-cloak
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        class="fixed inset-y-0 left-0 z-50 flex w-72 flex-col bg-[#fbfff9] border-r border-gray-200 p-4 md:hidden"
    >

        <div class="flex items-center justify-between px-2 pb-6 pt-1">

            <img
                src="{{ asset('images/logobsa.png') }}"
                alt="BSA Auto Repair Shop"
                class="h-11 w-auto object-contain"
            >

            <button
                type="button"
                @click="mobileOpen = false"
                class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-white"
            >
                <i class="ti ti-x text-xl"></i>
            </button>

        </div>


        <nav class="flex flex-col gap-1">

            <a
                href="{{ route('mechanic.dashboard') }}"
                @click="mobileOpen = false"
                class="flex items-center gap-2.5 rounded-lg px-3 py-2
                    {{ request()->routeIs('mechanic.dashboard')
                        ? 'bg-[#d3f4d3] shadow-sm font-medium text-gray-900'
                        : 'text-gray-500 hover:bg-white/70' }}"
            >
                <i class="ti ti-layout-dashboard text-base"></i>
                Dashboard
            </a>


            <a
                href="{{ route('mechanic.MJO') }}"
                @click="mobileOpen = false"
                class="flex items-center gap-2.5 rounded-lg px-3 py-2
                    {{ request()->routeIs('mechanic.MJO')
                        ? 'bg-[#d3f4d3] shadow-sm font-medium text-gray-900'
                        : 'text-gray-500 hover:bg-white/70' }}"
            >
                <i class="ti ti-clipboard-list text-base"></i>
                My job orders
            </a>


            <a
                href="{{ route('mechanic.CJO') }}"
                @click="mobileOpen = false"
                class="flex items-center gap-2.5 rounded-lg px-3 py-2
                    {{ request()->routeIs('mechanic.CJO')
                        ? 'bg-[#d3f4d3] shadow-sm font-medium text-gray-900'
                        : 'text-gray-500 hover:bg-white/70' }}"
            >
                <i class="ti ti-file-plus text-base"></i>
                Create job order
            </a>


            <a
                href="{{ route('mechanic.needs-revision') }}"
                @click="mobileOpen = false"
                class="flex items-center gap-2.5 rounded-lg px-3 py-2
                    {{ request()->routeIs('mechanic.needs-revision')
                        ? 'bg-[#d3f4d3] shadow-sm font-medium text-gray-900'
                        : 'text-gray-500 hover:bg-white/70' }}"
            >
                <i class="ti ti-alert-triangle text-base"></i>
                Needs revision
            </a>

        </nav>


        <div
            class="relative mt-auto"
            x-data="{ open: false }"
        >

            <button
                @click="open = !open"
                class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left hover:bg-white"
            >

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200">
                    <i class="ti ti-user text-xl text-gray-600"></i>
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
                x-cloak
                @click.outside="open = false"
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


    {{-- ========================================================= --}}
    {{-- DESKTOP SIDEBAR --}}
    {{-- ========================================================= --}}

    <aside
        class="hidden md:flex w-56 shrink-0 h-screen sticky top-0
            bg-[#fbfff9] border-r border-gray-200
            p-4 flex-col gap-1"
    >

        <div class="flex items-center justify-center px-2 pb-6 pt-1">

            <img
                src="{{ asset('images/logobsa.png') }}"
                alt="BSA Auto Repair Shop"
                class="h-13 w-auto object-contain"
            >

        </div>


        <a
            href="{{ route('mechanic.dashboard') }}"
            class="flex items-center gap-2.5 rounded-lg px-3 py-2
                {{ request()->routeIs('mechanic.dashboard')
                    ? 'bg-[#d3f4d3] shadow-sm font-medium text-gray-900'
                    : 'text-gray-500 hover:bg-white/70' }}"
        >
            <i class="ti ti-layout-dashboard text-base"></i>
            Dashboard
        </a>


        <a
            href="{{ route('mechanic.MJO') }}"
            class="flex items-center gap-2.5 rounded-lg px-3 py-2
                {{ request()->routeIs('mechanic.MJO')
                    ? 'bg-[#d3f4d3] shadow-sm font-medium text-gray-900'
                    : 'text-gray-500 hover:bg-white/70' }}"
        >
            <i class="ti ti-clipboard-list text-base"></i>
            My job orders
        </a>


        <a
            href="{{ route('mechanic.CJO') }}"
            class="flex items-center gap-2.5 rounded-lg px-3 py-2
                {{ request()->routeIs('mechanic.CJO')
                    ? 'bg-[#d3f4d3] shadow-sm font-medium text-gray-900'
                    : 'text-gray-500 hover:bg-white/70' }}"
        >
            <i class="ti ti-file-plus text-base"></i>
            Create job order
        </a>


        <a
            href="{{ route('mechanic.needs-revision') }}"
            class="flex items-center gap-2.5 rounded-lg px-3 py-2
                {{ request()->routeIs('mechanic.needs-revision')
                    ? 'bg-[#d3f4d3] shadow-sm font-medium text-gray-900'
                    : 'text-gray-500 hover:bg-white/70' }}"
        >
            <i class="ti ti-alert-triangle text-base"></i>
            Needs revision
        </a>


        <div
            class="relative mt-auto"
            x-data="{ open: false }"
        >

            <button
                @click="open = !open"
                class="flex w-full items-center gap-3 rounded-xl px-3 py-3 text-left hover:bg-gray-100"
            >

                <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200">
                    <i class="ti ti-user text-xl text-gray-600"></i>
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
                x-cloak
                @click.outside="open = false"
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