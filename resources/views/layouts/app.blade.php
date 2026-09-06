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

<body class="font-sans antialiased bg-gray-100">

    <div class="min-h-screen">

        {{-- SIDEBAR --}}
        @include('layouts.navigation')

        {{-- AREA UTAMA --}}
        <div style="margin-left: 256px; min-height: 100vh;">

            {{-- TOPBAR --}}
            <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-8">

                <div class="flex items-center">
                    <div class="relative">
                        <input
                            type="text"
                            placeholder="Search..."
                            class="w-72 h-10 border border-gray-300 rounded-lg px-4 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                        >
                    </div>
                </div>

                <div class="flex items-center gap-6">

                    <button class="text-xl text-gray-500 hover:text-gray-700">
                        🔔
                    </button>

                    <div class="flex items-center gap-3">

                        <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-gray-800">
                                {{ Auth::user()->name }}
                            </p>

                            <p class="text-xs text-gray-500">
                                {{ Auth::user()->getRoleNames()->first() }}
                            </p>
                        </div>

                    </div>

                </div>

            </header>

            {{-- CONTENT --}}
            <main class="p-8">

                @isset($header)
                    <div class="mb-6">
                        {{ $header }}
                    </div>
                @endisset

                {{ $slot }}

            </main>

        </div>

    </div>

</body>
</html>