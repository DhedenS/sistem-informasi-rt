<aside
    class="fixed left-0 top-0 z-40 w-72 lg:w-64 h-screen
           bg-slate-900 text-white
           transform -translate-x-full lg:translate-x-0
           transition-transform duration-200 ease-out"
    :class="{ '!translate-x-0': sidebarOpen }"
    aria-label="Navigasi utama"
>

    {{-- ========================================================= --}}
    {{-- LOGO --}}
    {{-- ========================================================= --}}
    <div class="h-16 flex items-center justify-between px-5 border-b border-slate-700">

        <div class="flex items-center min-w-0">

            <div
                class="w-10 h-10 bg-blue-600 rounded-xl
                       flex items-center justify-center
                       font-bold text-lg shrink-0"
            >
                RT
            </div>

            <div class="ml-3 min-w-0">

                <div class="font-bold text-lg leading-tight">
                    RT System
                </div>

                <div class="text-sm text-slate-400 truncate">
                    Sistem Informasi RT
                </div>

            </div>

        </div>


        {{-- TOMBOL CLOSE MOBILE --}}
        <button
            type="button"
            @click="sidebarOpen = false"
            class="lg:hidden inline-flex h-11 w-11
                   items-center justify-center rounded-xl
                   text-2xl text-slate-300
                   hover:bg-slate-800"
            aria-label="Tutup menu navigasi"
        >
            ×
        </button>

    </div>


    {{-- ========================================================= --}}
    {{-- MENU --}}
    {{-- ========================================================= --}}
    <div class="p-4 overflow-y-auto h-[calc(100vh-64px)]">


        {{-- ===================================================== --}}
        {{-- DASHBOARD - SEMUA ROLE --}}
        {{-- ===================================================== --}}
        <div class="mb-6">

            <p
                class="px-3 mb-2 text-xs font-semibold
                       tracking-wide text-slate-500 uppercase"
            >
                Menu Utama
            </p>


            <a
                href="{{ route('dashboard') }}"
                @click="sidebarOpen = false"
                class="flex min-h-12 items-center gap-3
                       px-3 py-3 rounded-xl
                       {{ request()->routeIs('dashboard')
                            ? 'bg-blue-600 text-white'
                            : 'text-slate-200 hover:bg-slate-800' }}"
            >
                <span class="text-xl">
                    📊
                </span>

                <span class="text-base font-medium">
                    Dashboard
                </span>
            </a>

        </div>



        {{-- ===================================================== --}}
        {{-- SUPERADMIN --}}
        {{-- ===================================================== --}}
        @role('Superadmin')

            {{-- ================= ADMINISTRASI ================= --}}
            <div class="mb-6">

                <p
                    class="px-3 mb-2 text-xs font-semibold
                           tracking-wide text-slate-500 uppercase"
                >
                    Administrasi
                </p>


                {{-- DATA BLOK --}}
                <a
                    href="{{ route('blocks.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('blocks.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        🏠
                    </span>

                    <span class="text-base">
                        Data Blok
                    </span>
                </a>


                {{-- DATA KK --}}
                <a
                    href="{{ route('households.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('households.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        👨‍👩‍👧
                    </span>

                    <span class="text-base">
                        Data KK
                    </span>
                </a>


                {{-- SURAT MASUK --}}
                <a
                    href="{{ route('surat-masuk.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('surat-masuk.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        📥
                    </span>

                    <span class="text-base">
                        Surat Masuk
                    </span>
                </a>

            </div>



            {{-- ================= KEUANGAN ================= --}}
            <div class="mb-6">

                <p
                    class="px-3 mb-2 text-xs font-semibold
                           tracking-wide text-slate-500 uppercase"
                >
                    Keuangan
                </p>


                {{-- TRANSAKSI KAS --}}
                <a
                    href="{{ route('cashflow.transactions.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('cashflow.transactions.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        💰
                    </span>

                    <span class="text-base">
                        Transaksi Kas
                    </span>
                </a>


                {{-- IURAN KK --}}
                <a
                    href="{{ route('cashflow.dues.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('cashflow.dues.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        💳
                    </span>

                    <span class="text-base">
                        Iuran KK
                    </span>
                </a>


                {{-- SUMBER DANA --}}
                <a
                    href="{{ route('fund-sources.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('fund-sources.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        🏦
                    </span>

                    <span class="text-base">
                        Sumber Dana
                    </span>
                </a>


                {{-- KATEGORI TRANSAKSI --}}
                <a
                    href="{{ route('transaction-categories.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('transaction-categories.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        🏷️
                    </span>

                    <span class="text-base">
                        Kategori Transaksi
                    </span>
                </a>


                {{-- LAPORAN --}}
                <a
                    href="{{ route('cashflow.reports.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('cashflow.reports.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        📈
                    </span>

                    <span class="text-base">
                        Laporan Keuangan
                    </span>
                </a>

            </div>



            {{-- ================= APPROVAL ================= --}}
            <div class="mb-6">

                <p
                    class="px-3 mb-2 text-xs font-semibold
                           tracking-wide text-slate-500 uppercase"
                >
                    Persetujuan
                </p>


                @php
                    $jumlahPendingApproval = \App\Models\Approval::where(
                        'approvable_type',
                        \App\Models\PengajuanIuran::class
                    )
                    ->where('status', 'pending')
                    ->count();
                @endphp


                <a
                    href="{{ route('verifikasi-iuran.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl
                           {{ request()->routeIs('verifikasi-iuran.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >

                    <span class="text-xl">
                        ✅
                    </span>

                    <span class="text-base">
                        Approval Iuran
                    </span>


                    @if($jumlahPendingApproval > 0)

                        <span
                            class="ml-auto min-w-6 h-6 px-2
                                   rounded-full bg-red-500
                                   text-white text-xs font-bold
                                   flex items-center justify-center"
                        >
                            {{ $jumlahPendingApproval }}
                        </span>

                    @endif

                </a>

            </div>

        @endrole



        {{-- ===================================================== --}}
        {{-- KETUA RT --}}
        {{-- ===================================================== --}}
     

            <div class="mb-6">

                <p
                    class="px-3 mb-2 text-xs font-semibold
                           tracking-wide text-slate-500 uppercase"
                >
                    Monitoring
                </p>


                {{-- DATA BLOK --}}
                <a
                    href="{{ route('blocks.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('blocks.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        🏠
                    </span>

                    <span class="text-base">
                        Data Blok
                    </span>
                </a>


                {{-- DATA KK --}}
                <a
                    href="{{ route('households.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('households.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        👨‍👩‍👧
                    </span>

                    <span class="text-base">
                        Data KK
                    </span>
                </a>


                {{-- KATEGORI TRANSAKSI --}}
                <a
                    href="{{ route('transaction-categories.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('transaction-categories.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        🏷️
                    </span>

                    <span class="text-base">
                        Kategori Transaksi
                    </span>
                </a>


                {{-- SUMBER DANA --}}
                <a
                    href="{{ route('fund-sources.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl
                           {{ request()->routeIs('fund-sources.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        🏦
                    </span>

                    <span class="text-base">
                        Sumber Dana
                    </span>
                </a>

            </div>

        @endrole



        {{-- ===================================================== --}}
        {{-- BENDAHARA --}}
        {{-- ===================================================== --}}
        

            {{-- ================= KEUANGAN ================= --}}
            <div class="mb-6">

                <p
                    class="px-3 mb-2 text-xs font-semibold
                           tracking-wide text-slate-500 uppercase"
                >
                    Keuangan
                </p>


                {{-- DATA KK --}}
                <a
                    href="{{ route('households.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('households.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        👨‍👩‍👧
                    </span>

                    <span class="text-base">
                        Data KK
                    </span>
                </a>


                {{-- IURAN KK --}}
                <a
                    href="{{ route('cashflow.dues.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('cashflow.dues.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        💳
                    </span>

                    <span class="text-base">
                        Iuran KK
                    </span>
                </a>


                {{-- TRANSAKSI --}}
                <a
                    href="{{ route('cashflow.transactions.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl mb-1
                           {{ request()->routeIs('cashflow.transactions.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        💰
                    </span>

                    <span class="text-base">
                        Transaksi Kas
                    </span>
                </a>


                {{-- LAPORAN --}}
                <a
                    href="{{ route('cashflow.reports.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl
                           {{ request()->routeIs('cashflow.reports.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        📈
                    </span>

                    <span class="text-base">
                        Laporan Keuangan
                    </span>
                </a>

            </div>


            {{-- ================= APPROVAL ================= --}}
            <div class="mb-6">

                <p
                    class="px-3 mb-2 text-xs font-semibold
                           tracking-wide text-slate-500 uppercase"
                >
                    Persetujuan
                </p>


                @php
                    $jumlahPendingApproval = \App\Models\Approval::where(
                        'approvable_type',
                        \App\Models\PengajuanIuran::class
                    )
                    ->where('status', 'pending')
                    ->count();
                @endphp


                <a
                    href="{{ route('verifikasi-iuran.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl
                           {{ request()->routeIs('verifikasi-iuran.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        ✅
                    </span>

                    <span class="text-base">
                        Approval Iuran
                    </span>


                    @if($jumlahPendingApproval > 0)

                        <span
                            class="ml-auto min-w-6 h-6 px-2
                                   rounded-full bg-red-500
                                   text-white text-xs font-bold
                                   flex items-center justify-center"
                        >
                            {{ $jumlahPendingApproval }}
                        </span>

                    @endif

                </a>

            </div>

        @endrole



        {{-- ===================================================== --}}
        {{-- SEKRETARIS --}}
        {{-- ===================================================== --}}
        @role('Sekretaris')

            <div class="mb-6">

                <p
                    class="px-3 mb-2 text-xs font-semibold
                           tracking-wide text-slate-500 uppercase"
                >
                    Administrasi
                </p>


                <a
                    href="{{ route('surat-masuk.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl
                           {{ request()->routeIs('surat-masuk.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        📥
                    </span>

                    <span class="text-base">
                        Surat Masuk
                    </span>
                </a>

            </div>

        @endrole



        {{-- ===================================================== --}}
        {{-- KETUA BLOCK --}}
        {{-- ===================================================== --}}
        @role('Ketua Block')

            <div class="mb-6">

                <p
                    class="px-3 mb-2 text-xs font-semibold
                           tracking-wide text-slate-500 uppercase"
                >
                    Blok Saya
                </p>


                {{-- PENGAJUAN IURAN --}}
                <a
                    href="{{ route('pengajuan-iuran.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl
                           {{ request()->routeIs('pengajuan-iuran.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        💳
                    </span>

                    <span class="text-base">
                        Pengajuan Iuran
                    </span>
                </a>

            </div>

        @endrole



        {{-- ===================================================== --}}
        {{-- WARGA --}}
        {{-- ===================================================== --}}
        @role('Warga')

            <div class="mb-6">

                <p
                    class="px-3 mb-2 text-xs font-semibold
                           tracking-wide text-slate-500 uppercase"
                >
                    Iuran
                </p>


                <a
                    href="{{ route('iuran-saya.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3
                           px-3 py-3 rounded-xl
                           {{ request()->routeIs('iuran-saya.*')
                                ? 'bg-blue-600 text-white'
                                : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">
                        💳
                    </span>

                    <span class="text-base">
                        Iuran Saya
                    </span>
                </a>

            </div>

        @endrole
            {{-- ===================================================== --}}
{{-- APPROVAL IURAN --}}
{{-- ===================================================== --}}
@hasanyrole('Ketua RT|Bendahara')

    <div class="mb-6">

        <p class="px-3 mb-2 text-xs font-semibold tracking-wide text-slate-500 uppercase">
            Persetujuan
        </p>

        @php
            $jumlahPendingApproval = \App\Models\Approval::where(
                'approvable_type',
                \App\Models\PengajuanIuran::class
            )
            ->where('status', 'pending')
            ->count();
        @endphp

        <a
            href="{{ route('verifikasi-iuran.index') }}"
            @click="sidebarOpen = false"
            class="flex min-h-12 items-center gap-3 px-3 py-3 rounded-xl
            {{ request()->routeIs('verifikasi-iuran.*')
                ? 'bg-blue-600 text-white'
                : 'text-slate-200 hover:bg-slate-800' }}"
        >

            <span class="text-xl">
                ✅
            </span>

            <span class="text-base">
                Approval Iuran
            </span>

            @if($jumlahPendingApproval > 0)

                <span
                    class="ml-auto min-w-6 h-6 px-2
                           rounded-full bg-red-500
                           text-white text-xs font-bold
                           flex items-center justify-center"
                >
                    {{ $jumlahPendingApproval }}
                </span>

            @endif

        </a>

    </div>

@endhasanyrole


        {{-- ===================================================== --}}
        {{-- PENGATURAN - SEMUA ROLE --}}
        {{-- ===================================================== --}}
        <div class="pb-4">

            <p
                class="px-3 mb-2 text-xs font-semibold
                       tracking-wide text-slate-500 uppercase"
            >
                Pengaturan
            </p>


            {{-- PROFILE --}}
            <a
                href="{{ route('profile.edit') }}"
                @click="sidebarOpen = false"
                class="flex min-h-12 items-center gap-3
                       px-3 py-3 rounded-xl mb-1
                       {{ request()->routeIs('profile.*')
                            ? 'bg-blue-600 text-white'
                            : 'text-slate-200 hover:bg-slate-800' }}"
            >
                <span class="text-xl">
                    ⚙️
                </span>

                <span class="text-base">
                    Profile
                </span>
            </a>


            {{-- LOGOUT --}}
            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    type="submit"
                    class="w-full flex min-h-12
                           items-center gap-3
                           px-3 py-3 rounded-xl
                           text-slate-200
                           hover:bg-red-600
                           hover:text-white
                           transition"
                >
                    <span class="text-xl">
                        🚪
                    </span>

                    <span class="text-base">
                        Logout
                    </span>
                </button>

            </form>

        </div>

    </div>

</aside>