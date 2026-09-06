<aside class="fixed left-0 top-0 z-40 w-64 h-screen bg-slate-900 text-white hidden lg:block">

    <!-- LOGO -->
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


    <!-- MENU -->
    <div class="p-4 overflow-y-auto h-[calc(100vh-64px)]">

        <!-- DASHBOARD -->
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


        <!-- ADMINISTRASI -->
        <div class="mb-6">

            <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                Administrasi
            </p>


            @role('Superadmin')

                <a href="{{ route('blocks.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('blocks.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>🏠</span>
                    <span class="text-sm">Data Blok</span>

                </a>

            @endrole


            @hasanyrole('Superadmin|Bendahara')

                <a href="{{ route('households.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
                   {{ request()->routeIs('households.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>👨‍👩‍👧</span>
                    <span class="text-sm">Data KK</span>

                </a>

            @endhasanyrole


            <a href="{{ route('surat-masuk.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg mb-1
               {{ request()->routeIs('surat-masuk.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                <span>📥</span>
                <span class="text-sm">Surat Masuk</span>

            </a>


            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800">

                <span>📤</span>
                <span class="text-sm">Surat Keluar</span>

            </a>

        </div>


        <!-- KEUANGAN -->
        <div class="mb-6">

            <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                Keuangan
            </p>


            <a href="#"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800">

                <span>💰</span>
                <span class="text-sm">Transaksi</span>

            </a>


            @role('Superadmin')

                <a href="{{ route('transaction-categories.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-lg mt-1
                   {{ request()->routeIs('transaction-categories.*') ? 'bg-blue-600 text-white' : 'text-slate-300 hover:bg-slate-800' }}">

                    <span>🏷️</span>
                    <span class="text-sm">Kategori Transaksi</span>

                </a>

            @endrole

        </div>


        <!-- PENGATURAN -->
        <div>

            <p class="px-3 mb-2 text-xs font-semibold text-slate-500 uppercase">
                Pengaturan
            </p>


            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800">

                <span>⚙️</span>
                <span class="text-sm">Profile</span>

            </a>


            <form method="POST" action="{{ route('logout') }}">

                @csrf

                <button type="submit"
                    class="w-full flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-300 hover:bg-slate-800">

                    <span>🚪</span>
                    <span class="text-sm">Logout</span>

                </button>

            </form>

        </div>

    </div>

</aside>