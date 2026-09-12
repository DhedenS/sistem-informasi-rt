<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistem Informasi RT') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 text-gray-900">
    <div
        class="min-h-screen"
        x-data="{ sidebarOpen: false }"
        @keydown.escape.window="sidebarOpen = false"
    >
        {{-- OVERLAY MOBILE --}}
        <div
            x-cloak
            x-show="sidebarOpen"
            x-transition.opacity
            @click="sidebarOpen = false"
            class="fixed inset-0 z-30 bg-slate-950/60 lg:hidden"
        ></div>

        {{-- SIDEBAR --}}
        @include('layouts.navigation')

        {{-- AREA UTAMA --}}
        <div class="min-h-screen lg:ml-64">

            {{-- TOPBAR --}}
            <header class="sticky top-0 z-20 min-h-16 bg-white border-b border-gray-200 flex items-center justify-between gap-3 px-4 sm:px-6 lg:px-8 py-3">

                <div class="flex items-center gap-3 min-w-0">
                    <button
                        type="button"
                        @click="sidebarOpen = true"
                        class="lg:hidden inline-flex h-12 w-12 shrink-0 items-center justify-center rounded-xl border border-gray-300 bg-white text-2xl text-gray-700 shadow-sm active:bg-gray-100"
                        aria-label="Buka menu navigasi"
                    >
                        ☰
                    </button>

                    <div class="hidden md:block relative">
                        <input
                            type="text"
                            placeholder="Cari..."
                            class="w-64 lg:w-72 h-11 border border-gray-300 rounded-xl px-4 text-base focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>

                    <div class="md:hidden min-w-0">
                        <p class="text-base font-bold text-gray-900 truncate">
                            RT System
                        </p>

                        <p class="text-sm text-gray-500 truncate">
                            Sistem Informasi RT
                        </p>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-4 shrink-0">

                    <button
                        type="button"
                        class="inline-flex h-12 w-12 items-center justify-center rounded-xl text-2xl text-gray-600 hover:bg-gray-100"
                        aria-label="Notifikasi"
                    >
                        🔔
                    </button>

                    <div class="flex items-center gap-3">

                        <div class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center text-lg font-bold shrink-0">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <div class="hidden sm:block max-w-40">
                            <p class="text-base font-semibold text-gray-800 truncate">
                                {{ Auth::user()->name }}
                            </p>

                            <p class="text-sm text-gray-500 truncate">
                                {{ Auth::user()->getRoleNames()->first() }}
                            </p>
                        </div>

                    </div>
                </div>
            </header>

            {{-- CONTENT --}}
            <main class="p-4 sm:p-6 lg:p-8">

                @isset($header)
                    <div class="mb-5 sm:mb-6">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}

            </main>

        </div>
    </div>
</body>
</html>