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



                    {{-- SEARCH DESKTOP --}}
                    <div
                        class="
                        relative
                        hidden
                        md:block
                    ">

                        <svg class="
                            absolute
                            left-3
                            top-1/2

                            h-5
                            w-5

                            -translate-y-1/2

                            text-gray-400
                        "
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m21 21-4.35-4.35m2.1-5.4a7.5 7.5 0 1 1-15 0 7.5 7.5 0 0 1 15 0Z" />

                        </svg>


                        <input type="text" placeholder="Cari..."
                            class="
                            h-11
                            w-56

                            rounded-xl

                            border
                            border-gray-300

                            bg-gray-50

                            pl-10
                            pr-4

                            text-sm

                            focus:border-blue-500
                            focus:bg-white
                            focus:ring-2
                            focus:ring-blue-100

                            lg:w-72
                        ">

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


                    {{-- NOTIFICATION --}}
                    <button type="button"
                        class="
                        flex
                        h-11
                        w-11
                        shrink-0
                        items-center
                        justify-center

                        rounded-xl

                        text-gray-500

                        transition

                        hover:bg-gray-100
                        hover:text-gray-700
                    "
                        aria-label="Notifikasi">

                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0 1 18 14.158V11a6.002 6.002 0 0 0-4-5.659V5a2 2 0 1 0-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 1 1-6 0v-1m6 0H9" />

                        </svg>

                    </button>



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
