<aside
    x-cloak
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="
        fixed
        left-0 top-0
        z-50
        h-screen
        w-72
        transform
        bg-slate-900
        text-white
        shadow-2xl
        transition-transform
        duration-300
        ease-in-out

        lg:w-64
        lg:translate-x-0
        lg:shadow-none
    "
>

    {{-- ============================================================= --}}
    {{-- LOGO --}}
    {{-- ============================================================= --}}
    <div
        class="
            flex h-16
            items-center justify-between
            border-b border-slate-700
            px-4
            sm:px-5
        "
    >

        <div class="flex min-w-0 items-center">

            {{-- LOGO BOX --}}
            <div
                class="
                    flex h-10 w-10
                    shrink-0
                    items-center justify-center
                    rounded-xl
                    bg-blue-600
                    text-lg
                    font-bold
                    text-white
                    shadow
                "
            >
                RT
            </div>


            {{-- BRAND --}}
            <div class="ml-3 min-w-0">

                <div class="truncate text-lg font-bold text-white">
                    RT System
                </div>

                <div class="truncate text-xs text-slate-400">
                    Sistem Informasi RT
                </div>

            </div>

        </div>


        {{-- TOMBOL CLOSE MOBILE --}}
        <button
            type="button"
            @click="sidebarOpen = false"
            class="
                flex h-10 w-10
                shrink-0
                items-center justify-center
                rounded-xl
                text-slate-300
                transition
                hover:bg-slate-800
                hover:text-white
                lg:hidden
            "
            aria-label="Tutup menu"
        >

            <svg
                class="h-6 w-6"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M6 18 18 6M6 6l12 12"
                />

            </svg>

        </button>

    </div>


    {{-- ============================================================= --}}
    {{-- SCROLL MENU --}}
    {{-- ============================================================= --}}
    <div
        class="
            h-[calc(100vh-64px)]
            overflow-y-auto
            overscroll-contain
            p-3
            sm:p-4
        "
    >


        {{-- ========================================================= --}}
        {{-- MENU UTAMA --}}
        {{-- ========================================================= --}}
        <div class="mb-6">

            <p
                class="
                    mb-2
                    px-3
                    text-xs
                    font-semibold
                    uppercase
                    tracking-wider
                    text-slate-500
                "
            >
                Menu Utama
            </p>


            <a
                href="{{ route('dashboard') }}"
                @click="sidebarOpen = false"
                class="
                    mb-1
                    flex min-h-11
                    items-center
                    gap-3
                    rounded-xl
                    px-3 py-2.5
                    transition

                    {{ request()->routeIs('dashboard')
                        ? 'bg-blue-600 text-white shadow-sm'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    }}
                "
            >

                <span class="flex w-6 shrink-0 justify-center text-lg">
                    📊
                </span>

                <span class="text-sm font-medium">
                    Dashboard
                </span>

            </a>

        </div>



        {{-- ========================================================= --}}
        {{-- SUPERADMIN --}}
        {{-- ========================================================= --}}
        @role('Superadmin')

            {{-- ===================================================== --}}
            {{-- ADMINISTRASI --}}
            {{-- ===================================================== --}}
            <div class="mb-6">

                <p
                    class="
                        mb-2
                        px-3
                        text-xs
                        font-semibold
                        uppercase
                        tracking-wider
                        text-slate-500
                    "
                >
                    Administrasi
                </p>


                {{-- DATA BLOK --}}
                <a
                    href="{{ route('blocks.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('blocks.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        🏠
                    </span>

                    <span class="text-sm font-medium">
                        Data Blok
                    </span>

                </a>


                {{-- DATA KK --}}
                <a
                    href="{{ route('households.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('households.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        👨‍👩‍👧
                    </span>

                    <span class="text-sm font-medium">
                        Data KK
                    </span>

                </a>


                {{-- SURAT MASUK --}}
                <a
                    href="{{ route('surat-masuk.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('surat-masuk.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        📥
                    </span>

                    <span class="text-sm font-medium">
                        Surat Masuk
                    </span>

                </a>

            </div>


            {{-- ===================================================== --}}
            {{-- KEUANGAN SUPERADMIN --}}
            {{-- ===================================================== --}}
            <div class="mb-6">

                <p
                    class="
                        mb-2
                        px-3
                        text-xs
                        font-semibold
                        uppercase
                        tracking-wider
                        text-slate-500
                    "
                >
                    Keuangan
                </p>


                {{-- TRANSAKSI KAS --}}
                <a
                    href="{{ route('cashflow.transactions.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('cashflow.transactions.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        💰
                    </span>

                    <span class="text-sm font-medium">
                        Transaksi Kas
                    </span>

                </a>


                {{-- IURAN KK --}}
                <a
                    href="{{ route('cashflow.dues.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('cashflow.dues.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        💳
                    </span>

                    <span class="text-sm font-medium">
                        Iuran KK
                    </span>

                </a>


                {{-- SUMBER DANA --}}
                <a
                    href="{{ route('fund-sources.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('fund-sources.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        🏦
                    </span>

                    <span class="text-sm font-medium">
                        Sumber Dana
                    </span>

                </a>


                {{-- KATEGORI TRANSAKSI --}}
                <a
                    href="{{ route('transaction-categories.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('transaction-categories.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        🏷️
                    </span>

                    <span class="text-sm font-medium">
                        Kategori Transaksi
                    </span>

                </a>


                {{-- LAPORAN KEUANGAN --}}
                <a
                    href="{{ route('cashflow.reports.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('cashflow.reports.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        📊
                    </span>

                    <span class="text-sm font-medium">
                        Laporan Keuangan
                    </span>

                </a>

            </div>

        @endrole



        {{-- ========================================================= --}}
        {{-- KETUA RT --}}
        {{-- ========================================================= --}}
        @role('Ketua RT')

            <div class="mb-6">

                <p
                    class="
                        mb-2
                        px-3
                        text-xs
                        font-semibold
                        uppercase
                        tracking-wider
                        text-slate-500
                    "
                >
                    Monitoring
                </p>


                {{-- DATA BLOK --}}
                <a
                    href="{{ route('blocks.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('blocks.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        🏠
                    </span>

                    <span class="text-sm font-medium">
                        Data Blok
                    </span>

                </a>


                {{-- DATA KK --}}
                <a
                    href="{{ route('households.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('households.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        👨‍👩‍👧
                    </span>

                    <span class="text-sm font-medium">
                        Data KK
                    </span>

                </a>


                {{-- KATEGORI TRANSAKSI --}}
                <a
                    href="{{ route('transaction-categories.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('transaction-categories.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        🏷️
                    </span>

                    <span class="text-sm font-medium">
                        Kategori Transaksi
                    </span>

                </a>


                {{-- SUMBER DANA --}}
                <a
                    href="{{ route('fund-sources.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('fund-sources.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        🏦
                    </span>

                    <span class="text-sm font-medium">
                        Sumber Dana
                    </span>

                </a>

            </div>

        @endrole



        {{-- ========================================================= --}}
        {{-- BENDAHARA --}}
        {{-- ========================================================= --}}
        @role('Bendahara')

            <div class="mb-6">

                <p
                    class="
                        mb-2
                        px-3
                        text-xs
                        font-semibold
                        uppercase
                        tracking-wider
                        text-slate-500
                    "
                >
                    Keuangan
                </p>


                {{-- DATA KK --}}
                <a
                    href="{{ route('households.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('households.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        👨‍👩‍👧
                    </span>

                    <span class="text-sm font-medium">
                        Data KK
                    </span>

                </a>


                {{-- IURAN KK --}}
                <a
                    href="{{ route('cashflow.dues.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('cashflow.dues.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        💳
                    </span>

                    <span class="text-sm font-medium">
                        Iuran KK
                    </span>

                </a>


                {{-- VERIFIKASI IURAN --}}
                <a
                    href="{{ route('verifikasi-iuran.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('verifikasi-iuran.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        ✅
                    </span>

                    <span class="text-sm font-medium">
                        Verifikasi Iuran
                    </span>

                </a>


                {{-- TRANSAKSI KAS --}}
                <a
                    href="{{ route('cashflow.transactions.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('cashflow.transactions.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        💰
                    </span>

                    <span class="text-sm font-medium">
                        Transaksi Kas
                    </span>

                </a>


                {{-- LAPORAN KEUANGAN --}}
                <a
                    href="{{ route('cashflow.reports.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('cashflow.reports.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        📊
                    </span>

                    <span class="text-sm font-medium">
                        Laporan Keuangan
                    </span>

                </a>

            </div>

        @endrole



        {{-- ========================================================= --}}
        {{-- SEKRETARIS --}}
        {{-- ========================================================= --}}
        @role('Sekretaris')

            <div class="mb-6">

                <p
                    class="
                        mb-2
                        px-3
                        text-xs
                        font-semibold
                        uppercase
                        tracking-wider
                        text-slate-500
                    "
                >
                    Administrasi
                </p>


                {{-- SURAT MASUK --}}
                <a
                    href="{{ route('surat-masuk.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('surat-masuk.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        📥
                    </span>

                    <span class="text-sm font-medium">
                        Surat Masuk
                    </span>

                </a>

            </div>

        @endrole



        {{-- ========================================================= --}}
        {{-- KETUA BLOCK --}}
        {{-- ========================================================= --}}
        @role('Ketua Block')

            <div class="mb-6">

                <p
                    class="
                        mb-2
                        px-3
                        text-xs
                        font-semibold
                        uppercase
                        tracking-wider
                        text-slate-500
                    "
                >
                    Blok Saya
                </p>


                {{-- PENGAJUAN IURAN --}}
                <a
                    href="{{ route('pengajuan-iuran.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('pengajuan-iuran.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        💳
                    </span>

                    <span class="text-sm font-medium">
                        Pengajuan Iuran
                    </span>

                </a>

            </div>

        @endrole



        {{-- ========================================================= --}}
        {{-- WARGA --}}
        {{-- ========================================================= --}}
        @role('Warga')

            <div class="mb-6">

                <p
                    class="
                        mb-2
                        px-3
                        text-xs
                        font-semibold
                        uppercase
                        tracking-wider
                        text-slate-500
                    "
                >
                    Iuran Saya
                </p>


                {{-- IURAN SAYA --}}
                <a
                    href="{{ route('iuran-saya.index') }}"
                    @click="sidebarOpen = false"
                    class="
                        mb-1
                        flex min-h-11
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        transition

                        {{ request()->routeIs('iuran-saya.*')
                            ? 'bg-blue-600 text-white shadow-sm'
                            : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                        }}
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        💳
                    </span>

                    <span class="text-sm font-medium">
                        Iuran Saya
                    </span>

                </a>

            </div>

        @endrole



        {{-- ========================================================= --}}
        {{-- PENGATURAN --}}
        {{-- ========================================================= --}}
        <div class="border-t border-slate-800 pt-4">

            <p
                class="
                    mb-2
                    px-3
                    text-xs
                    font-semibold
                    uppercase
                    tracking-wider
                    text-slate-500
                "
            >
                Pengaturan
            </p>


            {{-- PROFILE --}}
            <a
                href="{{ route('profile.edit') }}"
                @click="sidebarOpen = false"
                class="
                    mb-1
                    flex min-h-11
                    items-center gap-3
                    rounded-xl
                    px-3 py-2.5
                    transition

                    {{ request()->routeIs('profile.*')
                        ? 'bg-blue-600 text-white shadow-sm'
                        : 'text-slate-300 hover:bg-slate-800 hover:text-white'
                    }}
                "
            >

                <span class="flex w-6 shrink-0 justify-center text-lg">
                    ⚙️
                </span>

                <span class="text-sm font-medium">
                    Profile
                </span>

            </a>


            {{-- LOGOUT --}}
            <form
                method="POST"
                action="{{ route('logout') }}"
                class="w-full"
            >

                @csrf

                <button
                    type="submit"
                    class="
                        flex min-h-11
                        w-full
                        items-center gap-3
                        rounded-xl
                        px-3 py-2.5
                        text-left
                        text-slate-300
                        transition
                        hover:bg-red-600/20
                        hover:text-red-300
                    "
                >

                    <span class="flex w-6 shrink-0 justify-center text-lg">
                        🚪
                    </span>

                    <span class="text-sm font-medium">
                        Logout
                    </span>

                </button>

            </form>

        </div>


        {{-- JARAK BAWAH --}}
        <div class="h-6"></div>

    </div>

</aside>