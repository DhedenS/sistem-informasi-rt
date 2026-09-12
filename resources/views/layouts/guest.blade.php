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

<body class="font-sans antialiased bg-slate-100 text-gray-900">

    <main class="min-h-screen flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8">

        <div class="w-full max-w-5xl overflow-hidden rounded-3xl bg-white shadow-xl border border-gray-200">

            <div class="grid grid-cols-1 lg:grid-cols-2">

                {{-- BAGIAN KIRI / BRANDING --}}
                <section class="hidden lg:flex relative min-h-[650px] flex-col justify-between bg-slate-900 p-10 text-white">

                    <div>

                        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-blue-600 text-2xl font-bold shadow-lg">
                            RT
                        </div>

                        <h1 class="mt-8 text-4xl font-bold leading-tight">
                            Sistem Informasi RT
                        </h1>

                        <p class="mt-4 max-w-md text-lg leading-relaxed text-slate-300">
                            Kelola administrasi, data warga, keuangan, dan persetujuan RT dengan lebih mudah.
                        </p>

                    </div>


                    <div class="space-y-5">

                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10 text-xl">
                                ✓
                            </div>

                            <div>

                                <p class="font-semibold">
                                    Mudah digunakan
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    Tampilan sederhana dan mudah dipahami.
                                </p>

                            </div>

                        </div>


                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10 text-xl">
                                📱
                            </div>

                            <div>

                                <p class="font-semibold">
                                    Bisa digunakan di HP
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    Nyaman digunakan dari perangkat mobile.
                                </p>

                            </div>

                        </div>


                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-white/10 text-xl">
                                🔒
                            </div>

                            <div>

                                <p class="font-semibold">
                                    Akses aman
                                </p>

                                <p class="mt-1 text-sm text-slate-400">
                                    Setiap pengguna masuk menggunakan akun masing-masing.
                                </p>

                            </div>

                        </div>

                    </div>


                    <p class="text-sm text-slate-500">
                        © {{ date('Y') }} Sistem Informasi RT
                    </p>

                </section>


                {{-- BAGIAN KANAN --}}
                <section class="flex min-h-[600px] items-center p-5 sm:p-8 lg:p-12">

                    <div class="w-full max-w-md mx-auto">

                        {{-- LOGO MOBILE --}}
                        <div class="mb-8 lg:hidden">

                            <div class="flex items-center gap-3">

                                <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-xl font-bold text-white shadow">
                                    RT
                                </div>

                                <div>

                                    <p class="text-xl font-bold text-gray-900">
                                        RT System
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        Sistem Informasi RT
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{ $slot }}

                    </div>

                </section>

            </div>

        </div>

    </main>

</body>
</html>