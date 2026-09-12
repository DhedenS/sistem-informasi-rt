<aside
    class="fixed left-0 top-0 z-40 w-72 lg:w-64 h-screen bg-slate-900 text-white transform -translate-x-full lg:translate-x-0 transition-transform duration-200 ease-out"
    :class="{ '!translate-x-0': sidebarOpen }"
    aria-label="Navigasi utama"
>

    <!-- LOGO -->
    <div class="h-16 flex items-center justify-between px-5 border-b border-slate-700">

        <div class="flex items-center min-w-0">

            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center font-bold text-lg shrink-0">
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

        <button
            type="button"
            @click="sidebarOpen = false"
            class="lg:hidden inline-flex h-11 w-11 items-center justify-center rounded-xl text-2xl text-slate-300 hover:bg-slate-800"
            aria-label="Tutup menu navigasi"
        >
            ×
        </button>

    </div>


    <!-- MENU -->
    <div class="p-4 overflow-y-auto h-[calc(100vh-64px)]">

        <!-- DASHBOARD -->
        <div class="mb-6">

            <p class="px-3 mb-2 text-xs font-semibold tracking-wide text-slate-500 uppercase">
                Menu Utama
            </p>

            <a
                href="{{ route('dashboard') }}"
                @click="sidebarOpen = false"
                class="flex min-h-12 items-center gap-3 px-3 py-3 rounded-xl
                {{ request()->routeIs('dashboard')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-200 hover:bg-slate-800' }}"
            >
                <span class="text-xl">📊</span>

                <span class="text-base font-medium">
                    Dashboard
                </span>
            </a>

        </div>


        <!-- ADMINISTRASI -->
        <div class="mb-6">

            <p class="px-3 mb-2 text-xs font-semibold tracking-wide text-slate-500 uppercase">
                Administrasi
            </p>

            @role('Superadmin')

                <a
                    href="{{ route('blocks.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3 px-3 py-3 rounded-xl mb-1
                    {{ request()->routeIs('blocks.*')
                        ? 'bg-blue-600 text-white'
                        : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">🏠</span>

                    <span class="text-base">
                        Data Blok
                    </span>
                </a>

            @endrole


            @hasanyrole('Superadmin|Bendahara')

                <a
                    href="{{ route('households.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3 px-3 py-3 rounded-xl mb-1
                    {{ request()->routeIs('households.*')
                        ? 'bg-blue-600 text-white'
                        : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">👨‍👩‍👧</span>

                    <span class="text-base">
                        Data KK
                    </span>
                </a>

            @endhasanyrole


            <a
                href="{{ route('surat-masuk.index') }}"
                @click="sidebarOpen = false"
                class="flex min-h-12 items-center gap-3 px-3 py-3 rounded-xl mb-1
                {{ request()->routeIs('surat-masuk.*')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-200 hover:bg-slate-800' }}"
            >
                <span class="text-xl">📥</span>

                <span class="text-base">
                    Surat Masuk
                </span>
            </a>


            <a
                href="#"
                class="flex min-h-12 items-center gap-3 px-3 py-3 rounded-xl text-slate-200 hover:bg-slate-800"
            >
                <span class="text-xl">📤</span>

                <span class="text-base">
                    Surat Keluar
                </span>
            </a>

        </div>


        <!-- KEUANGAN -->
        <div class="mb-6">

            <p class="px-3 mb-2 text-xs font-semibold tracking-wide text-slate-500 uppercase">
                Keuangan
            </p>

            <a
                href="#"
                class="flex min-h-12 items-center gap-3 px-3 py-3 rounded-xl text-slate-200 hover:bg-slate-800"
            >
                <span class="text-xl">💰</span>

                <span class="text-base">
                    Transaksi
                </span>
            </a>


            @role('Superadmin')

                <a
                    href="{{ route('transaction-categories.index') }}"
                    @click="sidebarOpen = false"
                    class="flex min-h-12 items-center gap-3 px-3 py-3 rounded-xl mt-1
                    {{ request()->routeIs('transaction-categories.*')
                        ? 'bg-blue-600 text-white'
                        : 'text-slate-200 hover:bg-slate-800' }}"
                >
                    <span class="text-xl">🏷️</span>

                    <span class="text-base">
                        Kategori Transaksi
                    </span>
                </a>

            @endrole

        </div>


        <!-- PERSETUJUAN -->
        <div class="mb-6">

            <p class="px-3 mb-2 text-xs font-semibold tracking-wide text-slate-500 uppercase">
                Persetujuan
            </p>

            <a
                href="{{ route('approval.index') }}"
                @click="sidebarOpen = false"
                class="flex min-h-12 items-center gap-3 px-3 py-3 rounded-xl
                {{ request()->routeIs('approval.*')
                    ? 'bg-blue-600 text-white'
                    : 'text-slate-200 hover:bg-slate-800' }}"
            >
                <span class="text-xl">✅</span>

                <span class="text-base">
                    Approval
                </span>
            </a>

        </div>


        <!-- PENGATURAN -->
        <div>

            <p class="px-3 mb-2 text-xs font-semibold tracking-wide text-slate-500 uppercase">
                Pengaturan
            </p>

            <a
                href="{{ route('profile.edit') }}"
                @click="sidebarOpen = false"
                class="flex min-h-12 items-center gap-3 px-3 py-3 rounded-xl text-slate-200 hover:bg-slate-800"
            >
                <span class="text-xl">⚙️</span>

                <span class="text-base">
                    Profile
                </span>
            </a>


            <form
                method="POST"
                action="{{ route('logout') }}"
            >
                @csrf

                <button
                    type="submit"
                    class="w-full flex min-h-12 items-center gap-3 px-3 py-3 rounded-xl text-slate-200 hover:bg-slate-800"
                >
                    <span class="text-xl">🚪</span>

                    <span class="text-base">
                        Logout
                    </span>
                </button>

            </form>

        </div>

    </div>

</aside>