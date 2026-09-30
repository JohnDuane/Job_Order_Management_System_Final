<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <title>BSA Auto Repair Shop · Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Tabler Icons --}}
    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2/dist/tabler-icons.min.css"
    >

</head>


<body class="min-h-screen bg-white text-gray-900 antialiased">


    <main class="flex min-h-screen items-center justify-center px-5 py-10">

        <div class="w-full max-w-md">


            {{-- ================================================= --}}
            {{-- BRAND --}}
            {{-- ================================================= --}}

            <div class="mb-8 text-center">

                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-gray-900"
                >
                    <i class="ti ti-tool text-2xl text-white"></i>
                </div>

                <h1 class="mt-4 text-xl font-medium text-gray-900">
                    BSA Auto Repair Shop
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Job Order Management System
                </p>

            </div>


            {{-- ================================================= --}}
            {{-- LOGIN CARD --}}
            {{-- ================================================= --}}

            <div
                class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8"
            >


                {{-- Heading --}}
                <div class="mb-6">

                    <h2 class="text-lg font-medium text-gray-900">
                        Welcome back
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Sign in to access the management system.
                    </p>

                </div>


                {{-- Session Status --}}
                <x-auth-session-status
                    class="mb-4"
                    :status="session('status')"
                />


                {{-- ================================================= --}}
                {{-- LOGIN FORM --}}
                {{-- ================================================= --}}

                <form
                    method="POST"
                    action="{{ route('login') }}"
                >

                    @csrf


                    {{-- ================================================= --}}
                    {{-- EMAIL --}}
                    {{-- ================================================= --}}

                    <div>

                        <label
                            for="email"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Email
                        </label>


                        <div class="relative mt-1.5">

                            <i
                                class="ti ti-mail absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                            ></i>


                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="Enter your email"
                                class="block w-full rounded-lg border border-gray-200
                                       py-2.5 pl-10 pr-3 text-sm text-gray-900
                                       placeholder:text-gray-400
                                       focus:border-gray-400
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-gray-100"
                            >

                        </div>


                        @if ($errors->get('email'))

                            <p class="mt-2 text-sm text-red-600">
                                {{ $errors->first('email') }}
                            </p>

                        @endif

                    </div>


                    {{-- ================================================= --}}
                    {{-- PASSWORD --}}
                    {{-- ================================================= --}}

                    <div class="mt-4">

                        <label
                            for="password"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Password
                        </label>


                        <div class="relative mt-1.5">

                            <i
                                class="ti ti-lock absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"
                            ></i>


                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="block w-full rounded-lg border border-gray-200
                                       py-2.5 pl-10 pr-3 text-sm text-gray-900
                                       placeholder:text-gray-400
                                       focus:border-gray-400
                                       focus:outline-none
                                       focus:ring-2
                                       focus:ring-gray-100"
                            >

                        </div>


                        @if ($errors->get('password'))

                            <p class="mt-2 text-sm text-red-600">
                                {{ $errors->first('password') }}
                            </p>

                        @endif

                    </div>


                    {{-- ================================================= --}}
                    {{-- REMEMBER ME / FORGOT PASSWORD --}}
                    {{-- ================================================= --}}

                    <div class="mt-4 flex items-center justify-between gap-3">


                        {{-- Remember Me --}}
                        <label
                            for="remember_me"
                            class="inline-flex items-center"
                        >

                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="rounded border-gray-300 text-gray-900
                                       shadow-sm focus:ring-gray-300"
                            >

                            <span class="ms-2 text-sm text-gray-500">
                                Remember me
                            </span>

                        </label>


                        {{-- Forgot Password --}}
                        @if (Route::has('password.request'))

                            <a
                                href="{{ route('password.request') }}"
                                class="text-sm text-gray-500 transition
                                       hover:text-gray-900"
                            >
                                Forgot password?
                            </a>

                        @endif

                    </div>


                    {{-- ================================================= --}}
                    {{-- LOGIN BUTTON --}}
                    {{-- ================================================= --}}

                    <button
                        type="submit"
                        class="mt-6 flex w-full items-center justify-center
                               gap-2 rounded-lg bg-gray-900 px-4 py-2.5
                               text-sm font-medium text-white
                               transition hover:bg-gray-800
                               focus:outline-none focus:ring-2
                               focus:ring-gray-300"
                    >

                        <i class="ti ti-login text-base"></i>

                        Log in

                    </button>


                </form>

            </div>


            {{-- ================================================= --}}
            {{-- FOOTER --}}
            {{-- ================================================= --}}

            <p class="mt-6 text-center text-xs text-gray-400">
                BSA Auto Repair Shop · Job Order Management System
            </p>


        </div>

    </main>


</body>

</html>