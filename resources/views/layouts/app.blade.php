<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'Sistem Informasi RT') }}
    </title>


    <link rel="preconnect" href="https://fonts.bunny.net">

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>


<body class="bg-gray-100 font-sans text-gray-900 antialiased">


    <div x-data="{ sidebarOpen: false }" @keydown.escape.window="sidebarOpen = false" class="min-h-screen">


        {{-- ====================================================== --}}
        {{-- OVERLAY MOBILE --}}
        {{-- ====================================================== --}}

        <div x-cloak x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
            class="
            fixed inset-0
            z-40
            bg-black/50
            backdrop-blur-[1px]
            lg:hidden
        ">
        </div>



        {{-- ====================================================== --}}
        {{-- SIDEBAR --}}
        {{-- ====================================================== --}}

        @include('layouts.navigation')



        {{-- ====================================================== --}}
        {{-- MAIN WRAPPER --}}
        {{-- ====================================================== --}}

        <div
            class="
            min-h-screen
            min-w-0
            w-full
            transition-all
            duration-300
            lg:ml-64
            lg:w-[calc(100%-16rem)]
        ">


            {{-- ================================================== --}}
            {{-- TOP BAR --}}
            {{-- ================================================== --}}

            <header
                class="
                sticky
                top-0
                z-30

                flex
                min-h-16
                w-full
                items-center
                justify-between

                border-b
                border-gray-200

                bg-white

                px-3
                py-2

                shadow-sm

                sm:px-5
                lg:px-8
            ">


                {{-- KIRI --}}
                <div
                    class="
                    flex
                    min-w-0
                    items-center
                    gap-3
                ">


                    {{-- BUTTON MENU MOBILE --}}
                    <button type="button" @click="sidebarOpen = true"
                        class="
                        flex
                        h-11
                        w-11
                        shrink-0
                        items-center
                        justify-center

                        rounded-xl

                        border
                        border-gray-200

                        bg-white

                        text-gray-700

                        transition

                        hover:bg-gray-100

                        focus:outline-none
                        focus:ring-2
                        focus:ring-blue-500

                        lg:hidden
                    "
                        aria-label="Buka menu">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />

                        </svg>

                    </button>



                    {{-- BRAND MOBILE --}}
                    <div class="min-w-0 md:hidden">

                        <p
                            class="
                            truncate
                            text-sm
                            font-bold
                            text-gray-800
                        ">
                            RT System
                        </p>

                        <p
                            class="
                            truncate
                            text-xs
                            text-gray-500
                        ">
                            Sistem Informasi RT
                        </p>

                    </div>

                </div>



                {{-- KANAN --}}
                <div
                    class="
                    flex
                    min-w-0
                    items-center
                    gap-1

                    sm:gap-3
                ">


                    {{-- PROFILE --}}
                    <div
                        class="
                        flex
                        min-w-0
                        items-center
                        gap-2

                        sm:gap-3
                    ">


                        {{-- AVATAR --}}
                        <div
                            class="
                            flex
                            h-10
                            w-10
                            shrink-0
                            items-center
                            justify-center

                            rounded-full

                            bg-blue-600

                            text-sm
                            font-bold
                            text-white
                        ">

                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}

                        </div>



                        {{-- NAME --}}
                        <div class="hidden min-w-0 sm:block">

                            <p
                                class="
                                max-w-40
                                truncate

                                text-sm
                                font-semibold
                                text-gray-800

                                lg:max-w-52
                            ">

                                {{ Auth::user()->name }}

                            </p>


                            <p
                                class="
                                max-w-40
                                truncate

                                text-xs
                                text-gray-500

                                lg:max-w-52
                            ">

                                {{ Auth::user()->getRoleNames()->first() ?? 'Pengguna' }}

                            </p>

                        </div>

                    </div>

                </div>

            </header>



            {{-- ================================================== --}}
            {{-- PAGE CONTENT --}}
            {{-- ================================================== --}}

            <main
                class="
                responsive-content

                w-full
                min-w-0
                max-w-full

                overflow-x-hidden

                p-3

                sm:p-5
                md:p-6
                lg:p-8
            ">


                {{-- HEADER PAGE --}}
                @isset($header)
                    <div
                        class="
                        mb-4
                        min-w-0

                        sm:mb-6
                    ">

                        {{ $header }}

                    </div>
                @endisset



                {{-- CONTENT --}}
                <div class="min-w-0 max-w-full">

                    {{ $slot }}

                </div>


            </main>

        </div>

    </div>

    @stack('scripts')
</body>

</html>
