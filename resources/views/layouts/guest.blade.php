<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SIP-RT') }} - Sistem Pengelolaan RT</title>

        <!-- Google Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Plus Jakarta Sans', 'sans-serif'],
                            },
                        }
                    }
                }
            </script>
        @endif
        <style>
            body { font-family: 'Plus Jakarta Sans', sans-serif; }
        </style>
    </head>
    <body class="h-full bg-slate-950 text-slate-100 antialiased selection:bg-blue-600 selection:text-white flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-x-hidden">
        
        <!-- Background Ambient Glow -->
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-blue-600/10 blur-[130px] rounded-full pointer-events-none"></div>

        <div class="sm:mx-auto sm:w-full sm:max-w-md text-center relative z-10">
            <a href="/" class="inline-flex items-center gap-3 group">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-blue-600 to-indigo-500 flex items-center justify-center font-extrabold text-white text-2xl shadow-xl shadow-blue-500/20 group-hover:scale-105 transition-transform">
                    RT
                </div>
                <div class="text-left">
                    <span class="text-xl font-bold bg-gradient-to-r from-white via-slate-200 to-slate-400 bg-clip-text text-transparent">SIP-RT</span>
                    <span class="block text-[10px] uppercase tracking-wider font-semibold text-blue-400">Sistem Pengelolaan RT</span>
                </div>
            </a>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md relative z-10">
            <div class="bg-slate-900/80 backdrop-blur-xl border border-slate-800 py-8 px-6 shadow-2xl shadow-slate-950 rounded-2xl sm:px-10">
                {{ $slot }}
            </div>
        </div>

        <div class="mt-8 text-center text-xs text-slate-500 relative z-10">
            &copy; {{ date('Y') }} Sistem Informasi & Pengelolaan Kas RT
        </div>
    </body>
</html>
