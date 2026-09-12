<aside class="fixed left-0 top-0 z-40 w-64 h-screen bg-slate-900 text-white hidden lg:block">

    {{-- LOGO --}}
    <div class="h-16 flex items-center px-6 border-b border-slate-700">

        <div class="w-9 h-9 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-lg">
            RT
        </div>

        <div class="ml-3">
            <div class="font-bold text-lg">
                RT System
            </div>

            <div class="text-xs text-slate-400">
                Sistem Informasi RT
            </div>
        </div>

    </div>


    {{-- MENU --}}
    <div class="p-4 overflow-y-auto h-[calc(100vh-64px)]">


        {{-- ========================================================= --}}
        {{-- MENU UTAMA --}}
        {{-- ========================================================= --}}

        <div class="mb-6">

            <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                Menu Utama
            </p>

            <a href="{{ route('dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg
               {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                <span>📊</span>

                <span class="text-sm font-medium">
                    Dashboard
                </span>

            </a>

        </div>


        {{-- ========================================================= --}}
        {{-- SUPERADMIN --}}
        {{-- ========================================================= --}}

        @role('Superadmin')

            {{-- ADMINISTRASI --}}
            <div class="mb-6">

                <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                    Administrasi
                </p>


                {{-- DATA BLOK --}}
                <a href="{{ route('blocks.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('blocks.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>🏠</span>

                    <span class="text-sm">
                        Data Blok
                    </span>

                </a>


                {{-- DATA KK --}}
                <a href="{{ route('households.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('households.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>👨‍👩‍👧</span>

                    <span class="text-sm">
                        Data KK
                    </span>

                </a>


                {{-- SURAT MASUK --}}
                <a href="{{ route('surat-masuk.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('surat-masuk.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>📥</span>

                    <span class="text-sm">
                        Surat Masuk
                    </span>

                </a>

            </div>


            {{-- KEUANGAN --}}
            <div class="mb-6">

                <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                    Keuangan
                </p>


                {{-- TRANSAKSI KAS --}}
                <a href="{{ route('cashflow.transactions.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('cashflow.transactions.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>💰</span>

                    <span class="text-sm">
                        Transaksi Kas
                    </span>

                </a>


                {{-- IURAN KK --}}
                <a href="{{ route('cashflow.dues.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('cashflow.dues.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>💳</span>

                    <span class="text-sm">
                        Iuran KK
                    </span>

                </a>


                {{-- SUMBER DANA --}}
                <a href="{{ route('fund-sources.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('fund-sources.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>🏦</span>

                    <span class="text-sm">
                        Sumber Dana
                    </span>

                </a>


                {{-- KATEGORI TRANSAKSI --}}
                <a href="{{ route('transaction-categories.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('transaction-categories.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>🏷️</span>

                    <span class="text-sm">
                        Kategori Transaksi
                    </span>

                </a>


                {{-- LAPORAN KEUANGAN --}}
                <a href="{{ route('cashflow.reports.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('cashflow.reports.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>📊</span>

                    <span class="text-sm">
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

                <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                    Monitoring
                </p>


                {{-- DATA BLOK --}}
                <a href="{{ route('blocks.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('blocks.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>🏠</span>

                    <span class="text-sm">
                        Data Blok
                    </span>

                </a>


                {{-- DATA KK --}}
                <a href="{{ route('households.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('households.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>👨‍👩‍👧</span>

                    <span class="text-sm">
                        Data KK
                    </span>

                </a>


                {{-- KATEGORI TRANSAKSI --}}
                <a href="{{ route('transaction-categories.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('transaction-categories.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>🏷️</span>

                    <span class="text-sm">
                        Kategori Transaksi
                    </span>

                </a>


                {{-- SUMBER DANA --}}
                <a href="{{ route('fund-sources.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('fund-sources.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>🏦</span>

                    <span class="text-sm">
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

                <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                    Keuangan
                </p>


                {{-- DATA KK --}}
                <a href="{{ route('households.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('households.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>👨‍👩‍👧</span>

                    <span class="text-sm">
                        Data KK
                    </span>

                </a>


                {{-- IURAN KK --}}
                <a href="{{ route('cashflow.dues.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('cashflow.dues.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>💳</span>

                    <span class="text-sm">
                        Iuran KK
                    </span>

                </a>


                {{-- VERIFIKASI PENGAJUAN IURAN --}}
                <a href="{{ route('verifikasi-iuran.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('verifikasi-iuran.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>✅</span>

                    <span class="text-sm">
                        Verifikasi Iuran
                    </span>

                </a>


                {{-- TRANSAKSI KAS --}}
                <a href="{{ route('cashflow.transactions.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('cashflow.transactions.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>💰</span>

                    <span class="text-sm">
                        Transaksi Kas
                    </span>

                </a>


                {{-- LAPORAN KEUANGAN --}}
                <a href="{{ route('cashflow.reports.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('cashflow.reports.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>📊</span>

                    <span class="text-sm">
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

                <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                    Administrasi
                </p>


                {{-- SURAT MASUK --}}
                <a href="{{ route('surat-masuk.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('surat-masuk.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>📥</span>

                    <span class="text-sm">
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

                <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                    Blok Saya
                </p>

                {{-- PENGAJUAN IURAN --}}
                <a href="{{ route('pengajuan-iuran.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('pengajuan-iuran.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>💳</span>

                    <span class="text-sm">
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

                <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                    Iuran Saya
                </p>

                <div class="px-3 py-2 text-xs text-slate-500">
                    Fitur iuran akan dibuat pada tahap berikutnya.
                </div>

            </div>

        @endrole



        {{-- ========================================================= --}}
        {{-- PENGATURAN --}}
        {{-- ========================================================= --}}

        <div>

            <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                Pengaturan
            </p>


            {{-- PROFILE --}}
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800">

                <span>⚙️</span>

                <span class="text-sm">
                    Profile
                </span>

            </a>


            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800">

                    <span>🚪</span>

                    <span class="text-sm">
                        Logout
                    </span>

                </button>

            </form>

        </div>

    </div>

</aside>