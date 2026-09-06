<x-app-layout>

    {{-- JUDUL --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">
            Dashboard
        </h1>

        <p class="text-sm text-gray-500 mt-1">
            Selamat datang di Sistem Informasi RT
        </p>
    </div>


    {{-- STATISTIK --}}
    <div class="grid grid-cols-4 gap-6 mb-8">

        {{-- TOTAL KK --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Total KK
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        120
                    </h2>

                    <p class="text-xs text-green-600 mt-2">
                        ↑ Data keluarga
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-2xl">
                    👨‍👩‍👧
                </div>

            </div>

        </div>


        {{-- SURAT MASUK --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Surat Masuk
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        15
                    </h2>

                    <p class="text-xs text-blue-600 mt-2">
                        Surat diterima
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-2xl">
                    📥
                </div>

            </div>

        </div>


        {{-- SALDO --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Saldo Kas
                    </p>

                    <h2 class="text-2xl font-bold text-gray-800 mt-2">
                        Rp 5.250.000
                    </h2>

                    <p class="text-xs text-green-600 mt-2">
                        Saldo saat ini
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-2xl">
                    💰
                </div>

            </div>

        </div>


        {{-- TOTAL BLOK --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm text-gray-500">
                        Total Blok
                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">
                        8
                    </h2>

                    <p class="text-xs text-gray-500 mt-2">
                        Blok terdaftar
                    </p>
                </div>

                <div class="w-12 h-12 rounded-xl bg-orange-100 flex items-center justify-center text-2xl">
                    🏘️
                </div>

            </div>

        </div>

    </div>


    {{-- BAGIAN BAWAH --}}
    <div class="grid grid-cols-3 gap-6">

        {{-- GRAFIK --}}
        <div class="col-span-2 bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <div class="flex items-center justify-between mb-6">

                <div>
                    <h2 class="text-lg font-bold text-gray-800">
                        Grafik Cashflow
                    </h2>

                    <p class="text-sm text-gray-500">
                        Pemasukan dan pengeluaran kas
                    </p>
                </div>

                <select class="border border-gray-300 rounded-lg text-sm px-3 py-2">
                    <option>6 Bulan</option>
                    <option>1 Tahun</option>
                </select>

            </div>

            {{-- GRAFIK SEDERHANA --}}
            <div class="h-64 flex items-end gap-5 px-4 border-b border-gray-200">

                <div class="flex-1 bg-blue-200 rounded-t-lg" style="height:40%"></div>

                <div class="flex-1 bg-blue-300 rounded-t-lg" style="height:55%"></div>

                <div class="flex-1 bg-blue-400 rounded-t-lg" style="height:45%"></div>

                <div class="flex-1 bg-blue-500 rounded-t-lg" style="height:70%"></div>

                <div class="flex-1 bg-blue-600 rounded-t-lg" style="height:60%"></div>

                <div class="flex-1 bg-blue-700 rounded-t-lg" style="height:85%"></div>

            </div>

            <div class="flex justify-between text-xs text-gray-400 mt-3 px-3">
                <span>Apr</span>
                <span>Mei</span>
                <span>Jun</span>
                <span>Jul</span>
                <span>Agu</span>
                <span>Sep</span>
            </div>

        </div>


        {{-- AKTIVITAS --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">

            <h2 class="text-lg font-bold text-gray-800">
                Aktivitas Terbaru
            </h2>

            <p class="text-sm text-gray-500 mb-6">
                Aktivitas sistem terbaru
            </p>


            <div class="space-y-5">

                <div class="flex gap-3">

                    <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center">
                        📥
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-800">
                            Surat masuk ditambahkan
                        </p>

                        <p class="text-xs text-gray-400">
                            5 menit yang lalu
                        </p>
                    </div>

                </div>


                <div class="flex gap-3">

                    <div class="w-9 h-9 bg-green-100 rounded-full flex items-center justify-center">
                        💰
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-800">
                            Transaksi baru
                        </p>

                        <p class="text-xs text-gray-400">
                            30 menit yang lalu
                        </p>
                    </div>

                </div>


                <div class="flex gap-3">

                    <div class="w-9 h-9 bg-purple-100 rounded-full flex items-center justify-center">
                        👨‍👩‍👧
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-800">
                            Data KK diperbarui
                        </p>

                        <p class="text-xs text-gray-400">
                            1 jam yang lalu
                        </p>
                    </div>

                </div>


                <div class="flex gap-3">

                    <div class="w-9 h-9 bg-orange-100 rounded-full flex items-center justify-center">
                        🏘️
                    </div>

                    <div>
                        <p class="text-sm font-medium text-gray-800">
                            Data blok ditambahkan
                        </p>

                        <p class="text-xs text-gray-400">
                            2 jam yang lalu
                        </p>
                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>