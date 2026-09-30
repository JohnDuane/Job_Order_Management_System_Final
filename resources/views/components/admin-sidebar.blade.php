<aside class="w-56 shrink-0 bg-[#f5d1d1] border-r border-gray-200 p-4 flex flex-col">

    <!-- Logo -->
    <div class="flex items-center gap-2 px-2 pb-6 pt-1">
        <i class="ti ti-tool text-xl text-blue-600"></i>
        <span class="font-medium text-[15px]">JOMS</span>
    </div>

    <!-- Navigation -->
    <nav class="flex flex-col gap-1">

        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg
                  {{ request()->routeIs('admin.dashboard')
                      ? 'bg-white shadow-sm font-medium text-gray-900'
                      : 'text-gray-500 hover:bg-white/70' }}">
            <i class="ti ti-layout-dashboard text-base"></i>
            Dashboard
        </a>

        <a href="{{ route('admin.customers') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg
                  {{ request()->routeIs('admin.customers')
                      ? 'bg-white shadow-sm font-medium text-gray-900'
                      : 'text-gray-500 hover:bg-white/70' }}">
            <i class="ti ti-users text-base"></i>
            Customers
        </a>

        <a href="{{ route('admin.vehicles') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg
                  {{ request()->routeIs('admin.vehicles')
                      ? 'bg-white shadow-sm font-medium text-gray-900'
                      : 'text-gray-500 hover:bg-white/70' }}">
            <i class="ti ti-car text-base"></i>
            Vehicles
        </a>

        <a href="{{ route('admin.staff') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg
                  {{ request()->routeIs('admin.staff')
                      ? 'bg-white shadow-sm font-medium text-gray-900'
                      : 'text-gray-500 hover:bg-white/70' }}">
            <i class="ti ti-user-check text-base"></i>
            Staff
        </a>

        <a href="{{ route('admin.job-orders') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg
                  {{ request()->routeIs('admin.job-orders')
                      ? 'bg-white shadow-sm font-medium text-gray-900'
                      : 'text-gray-500 hover:bg-white/70' }}">
            <i class="ti ti-clipboard-list text-base"></i>
            Job orders
        </a>

        <a href="{{ route('admin.services') }}"
           class="flex items-center gap-2.5 px-3 py-2 rounded-lg
                  {{ request()->routeIs('admin.services')
                      ? 'bg-white shadow-sm font-medium text-gray-900'
                      : 'text-gray-500 hover:bg-white/70' }}">
            <i class="ti ti-settings text-base"></i>
            Services
        </a>

    </nav>


    <!-- User Menu -->
    <div class="relative mt-auto" x-data="{ open: false }">

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