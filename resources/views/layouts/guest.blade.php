<!DOCTYPE html>

<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    class="h-full"
>

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1"
    >

    <meta
        name="csrf-token"
        content="{{ csrf_token() }}"
    >


    <title>
        {{ config('app.name', 'SIP-RT') }} - Sistem Informasi RT
    </title>


    {{-- ========================================================= --}}
    {{-- FONT --}}
    {{-- ========================================================= --}}

    <link
        rel="preconnect"
        href="https://fonts.googleapis.com"
    >

    <link
        rel="preconnect"
        href="https://fonts.gstatic.com"
        crossorigin
    >

    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >


    {{-- ========================================================= --}}
    {{-- CSS + JS --}}
    {{-- ========================================================= --}}

    @if (
        file_exists(public_path('build/manifest.json')) ||
        file_exists(public_path('hot'))
    )

        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])

    @else

        {{-- FALLBACK JIKA VITE BELUM JALAN --}}
        <script src="https://cdn.tailwindcss.com"></script>

        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        fontFamily: {
                            sans: [
                                'Plus Jakarta Sans',
                                'sans-serif'
                            ],
                        },
                    }
                }
            }
        </script>

    @endif


    <style>

        body {
            font-family:
                'Plus Jakarta Sans',
                sans-serif;
        }

    </style>

</head>


<body
    class="
        min-h-screen
        bg-slate-100
        text-slate-900
        antialiased
    "
>


<div class="min-h-screen">


    {{-- ========================================================= --}}
    {{-- GRID UTAMA --}}
    {{-- ========================================================= --}}

    <div
        class="
            grid
            min-h-screen
            grid-cols-1
            lg:grid-cols-2
        "
    >


        {{-- ===================================================== --}}
        {{-- LEFT SIDE - DESKTOP --}}
        {{-- ===================================================== --}}

        <div
            class="
                relative
                hidden
                overflow-hidden
                bg-slate-950
                lg:flex
                lg:min-h-screen
                lg:flex-col
                lg:justify-between
                lg:p-10
                xl:p-14
            "
        >


            {{-- ================================================= --}}
            {{-- BACKGROUND DECORATION --}}
            {{-- ================================================= --}}

            <div
                class="
                    pointer-events-none
                    absolute
                    -right-40
                    -top-40
                    h-96
                    w-96
                    rounded-full
                    bg-blue-600/20
                    blur-3xl
                "
            ></div>


            <div
                class="
                    pointer-events-none
                    absolute
                    -bottom-40
                    -left-32
                    h-96
                    w-96
                    rounded-full
                    bg-indigo-500/20
                    blur-3xl
                "
            ></div>


            {{-- ================================================= --}}
            {{-- BRAND --}}
            {{-- ================================================= --}}

            <div class="relative z-10">

                <a
                    href="/"
                    class="
                        inline-flex
                        items-center
                        gap-4
                    "
                >

                    <div
                        class="
                            flex
                            h-14
                            w-14
                            shrink-0
                            items-center
                            justify-center
                            rounded-2xl
                            bg-gradient-to-br
                            from-blue-600
                            to-indigo-500
                            text-xl
                            font-extrabold
                            text-white
                            shadow-lg
                            shadow-blue-950/30
                        "
                    >
                        RT
                    </div>


                    <div>

                        <h1
                            class="
                                text-xl
                                font-bold
                                text-white
                            "
                        >
                            SIP-RT
                        </h1>


                        <p
                            class="
                                mt-0.5
                                text-sm
                                text-slate-400
                            "
                        >
                            Sistem Informasi RT
                        </p>

                    </div>

                </a>

            </div>



            {{-- ================================================= --}}
            {{-- HERO --}}
            {{-- ================================================= --}}

            <div
                class="
                    relative
                    z-10
                    max-w-xl
                "
            >

                <span
                    class="
                        inline-flex
                        rounded-full
                        border
                        border-blue-400/20
                        bg-blue-500/10
                        px-4
                        py-2
                        text-sm
                        font-semibold
                        text-blue-300
                    "
                >
                    Administrasi RT Digital
                </span>


                <h2
                    class="
                        mt-6
                        text-4xl
                        font-bold
                        leading-tight
                        text-white
                        xl:text-5xl
                    "
                >
                    Kelola lingkungan RT
                    dengan lebih mudah.
                </h2>


                <p
                    class="
                        mt-5
                        max-w-lg
                        text-base
                        leading-relaxed
                        text-slate-400
                        xl:text-lg
                    "
                >
                    Kelola data warga, iuran, keuangan,
                    surat, dan administrasi RT dalam satu
                    sistem yang terintegrasi.
                </p>



                {{-- FEATURE CARD --}}
                <div
                    class="
                        mt-8
                        grid
                        grid-cols-2
                        gap-4
                    "
                >


                    {{-- DATA WARGA --}}
                    <div
                        class="
                            rounded-2xl
                            border
                            border-white/10
                            bg-white/5
                            p-5
                            backdrop-blur-sm
                        "
                    >

                        <div
                            class="
                                flex
                                h-11
                                w-11
                                items-center
                                justify-center
                                rounded-xl
                                bg-blue-500/10
                                text-2xl
                            "
                        >
                            👨‍👩‍👧
                        </div>


                        <p
                            class="
                                mt-4
                                font-semibold
                                text-white
                            "
                        >
                            Data Warga
                        </p>


                        <p
                            class="
                                mt-1
                                text-sm
                                leading-relaxed
                                text-slate-400
                            "
                        >
                            Terpusat dan mudah dikelola.
                        </p>

                    </div>



                    {{-- KEUANGAN --}}
                    <div
                        class="
                            rounded-2xl
                            border
                            border-white/10
                            bg-white/5
                            p-5
                            backdrop-blur-sm
                        "
                    >

                        <div
                            class="
                                flex
                                h-11
                                w-11
                                items-center
                                justify-center
                                rounded-xl
                                bg-green-500/10
                                text-2xl
                            "
                        >
                            💰
                        </div>


                        <p
                            class="
                                mt-4
                                font-semibold
                                text-white
                            "
                        >
                            Keuangan RT
                        </p>


                        <p
                            class="
                                mt-1
                                text-sm
                                leading-relaxed
                                text-slate-400
                            "
                        >
                            Transparan dan tercatat.
                        </p>

                    </div>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- FOOTER LEFT --}}
            {{-- ================================================= --}}

            <p
                class="
                    relative
                    z-10
                    text-sm
                    text-slate-500
                "
            >
                © {{ date('Y') }} SIP-RT
            </p>

        </div>



        {{-- ===================================================== --}}
        {{-- RIGHT SIDE - FORM --}}
        {{-- ===================================================== --}}

        <div
            class="
                relative
                flex
                min-h-screen
                items-center
                justify-center
                overflow-hidden
                bg-slate-100
                px-4
                py-8
                sm:px-6
                sm:py-10
                lg:px-10
                xl:px-16
            "
        >


            {{-- MOBILE DECORATION --}}
            <div
                class="
                    pointer-events-none
                    absolute
                    -right-32
                    -top-32
                    h-72
                    w-72
                    rounded-full
                    bg-blue-500/10
                    blur-3xl
                    lg:hidden
                "
            ></div>



            <div
                class="
                    relative
                    z-10
                    w-full
                    max-w-md
                "
            >


                {{-- ================================================= --}}
                {{-- MOBILE LOGO --}}
                {{-- ================================================= --}}

                <div
                    class="
                        mb-8
                        flex
                        items-center
                        justify-center
                        lg:hidden
                    "
                >

                    <a
                        href="/"
                        class="
                            inline-flex
                            items-center
                            gap-3
                        "
                    >

                        <div
                            class="
                                flex
                                h-12
                                w-12
                                shrink-0
                                items-center
                                justify-center
                                rounded-2xl
                                bg-gradient-to-br
                                from-blue-600
                                to-indigo-500
                                text-lg
                                font-extrabold
                                text-white
                                shadow-lg
                                shadow-blue-500/20
                            "
                        >
                            RT
                        </div>


                        <div class="text-left">

                            <p
                                class="
                                    text-lg
                                    font-bold
                                    text-slate-900
                                "
                            >
                                SIP-RT
                            </p>

                            <p
                                class="
                                    text-xs
                                    text-slate-500
                                "
                            >
                                Sistem Informasi RT
                            </p>

                        </div>

                    </a>

                </div>



                {{-- ================================================= --}}
                {{-- AUTH CARD --}}
                {{-- ================================================= --}}

                <div
                    class="
                        w-full
                        rounded-2xl
                        border
                        border-slate-200
                        bg-white
                        p-5
                        shadow-xl
                        shadow-slate-200/60
                        sm:p-7
                        md:p-8
                    "
                >

                    {{ $slot }}

                </div>



                {{-- ================================================= --}}
                {{-- MOBILE FOOTER --}}
                {{-- ================================================= --}}

                <p
                    class="
                        mt-6
                        text-center
                        text-xs
                        leading-relaxed
                        text-slate-500
                    "
                >
                    © {{ date('Y') }}
                    Sistem Informasi & Pengelolaan RT
                </p>

            </div>

        </div>

    </div>

</div>


</body>

</html>