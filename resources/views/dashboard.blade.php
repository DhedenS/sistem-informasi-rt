<x-app-layout>

    {{-- JUDUL --}}
    <div class="mb-6 sm:mb-8">

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
            Dashboard
        </h1>

        <p class="text-base text-gray-600 mt-1">
            Selamat datang di Sistem Informasi RT
        </p>

    </div>


    {{-- STATISTIK --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-8">

        {{-- TOTAL KK --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">

            <div class="flex items-center justify-between gap-4">

                <div>

                    <p class="text-base text-gray-600">
                        Total KK
                    </p>

                    <h2 class="text-3xl font-bold text-gray-900 mt-2">
                        120
                    </h2>

                    <p class="text-sm text-green-700 mt-2">
                        ↑ Data keluarga
                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-3xl shrink-0">
                    👨‍👩‍👧
                </div>

            </div>

        </div>


        {{-- SURAT MASUK --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">

            <div class="flex items-center justify-between gap-4">

                <div>

                    <p class="text-base text-gray-600">
                        Surat Masuk
                    </p>

                    <h2 class="text-3xl font-bold text-gray-900 mt-2">
                        15
                    </h2>

                    <p class="text-sm text-blue-700 mt-2">
                        Surat diterima
                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-purple-100 flex items-center justify-center text-3xl shrink-0">
                    📥
                </div>

            </div>

        </div>


        {{-- SALDO KAS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">

            <div class="flex items-center justify-between gap-4">

                <div class="min-w-0">

                    <p class="text-base text-gray-600">
                        Saldo Kas
                    </p>

                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mt-2 break-words">
                        Rp 5.250.000
                    </h2>

                    <p class="text-sm text-green-700 mt-2">
                        Saldo saat ini
                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-3xl shrink-0">
                    💰
                </div>

            </div>

        </div>


        {{-- APPROVAL --}}
        @hasanyrole('Ketua RT|Bendahara')
       <a
    href="{{ route('verifikasi-iuran.index') }}"
    class="block bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6 hover:border-blue-300 hover:shadow-md transition"
>

            <div class="flex items-center justify-between gap-4">

                <div>

                    <p class="text-base text-gray-600">
                        Approval Menunggu
                    </p>

                    <h2 class="text-3xl font-bold text-gray-900 mt-2">
                        {{ $pendingApprovals ?? 0 }}
                    </h2>

                    <p class="text-sm font-medium text-orange-700 mt-2">
                        Perlu ditindaklanjuti
                    </p>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-3xl shrink-0">
                    ✅
                </div>

            </div>

        </a>

    </div>


    {{-- BAGIAN BAWAH --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-4 sm:gap-6">

        {{-- GRAFIK --}}
        <div class="xl:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">

            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

                <div>

                    <h2 class="text-xl font-bold text-gray-900">
                        Grafik Cashflow
                    </h2>

                    <p class="text-base text-gray-600">
                        Pemasukan dan pengeluaran kas
                    </p>

                </div>

                <select class="min-h-12 w-full sm:w-auto border border-gray-300 rounded-xl text-base px-4 py-2">

                    <option>
                        6 Bulan
                    </option>

                    <option>
                        1 Tahun
                    </option>

                </select>

            </div>


            <div class="overflow-x-auto pb-2">

                <div class="min-w-[520px]">

                    <div class="h-64 flex items-end gap-5 px-4 border-b border-gray-200">

                        <div class="flex-1 bg-blue-200 rounded-t-lg" style="height:40%"></div>

                        <div class="flex-1 bg-blue-300 rounded-t-lg" style="height:55%"></div>

                        <div class="flex-1 bg-blue-400 rounded-t-lg" style="height:45%"></div>

                        <div class="flex-1 bg-blue-500 rounded-t-lg" style="height:70%"></div>

                        <div class="flex-1 bg-blue-600 rounded-t-lg" style="height:60%"></div>

                        <div class="flex-1 bg-blue-700 rounded-t-lg" style="height:85%"></div>

                    </div>

                    <div class="flex justify-between text-sm text-gray-500 mt-3 px-3">

                        <span>Apr</span>
                        <span>Mei</span>
                        <span>Jun</span>
                        <span>Jul</span>
                        <span>Agu</span>
                        <span>Sep</span>

                    </div>

                </div>

            </div>

        </div>


        {{-- AKTIVITAS --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">

            <h2 class="text-xl font-bold text-gray-900">
                Aktivitas Terbaru
            </h2>

            <p class="text-base text-gray-600 mb-6">
                Aktivitas sistem terbaru
            </p>


            <div class="space-y-5">

                <div class="flex gap-3">

                    <div class="w-11 h-11 bg-blue-100 rounded-full flex items-center justify-center text-xl shrink-0">
                        📥
                    </div>

                    <div>

                        <p class="text-base font-semibold text-gray-900">
                            Surat masuk ditambahkan
                        </p>

                        <p class="text-sm text-gray-500">
                            5 menit yang lalu
                        </p>

                    </div>

                </div>


                <div class="flex gap-3">

                    <div class="w-11 h-11 bg-green-100 rounded-full flex items-center justify-center text-xl shrink-0">
                        💰
                    </div>

                    <div>

                        <p class="text-base font-semibold text-gray-900">
                            Transaksi baru
                        </p>

                        <p class="text-sm text-gray-500">
                            30 menit yang lalu
                        </p>

                    </div>

                </div>


                <div class="flex gap-3">

                    <div class="w-11 h-11 bg-purple-100 rounded-full flex items-center justify-center text-xl shrink-0">
                        👨‍👩‍👧
                    </div>

                    <div>

                        <p class="text-base font-semibold text-gray-900">
                            Data KK diperbarui
                        </p>

                        <p class="text-sm text-gray-500">
                            1 jam yang lalu
                        </p>

                    </div>

                </div>


                <div class="flex gap-3">

                    <div class="w-11 h-11 bg-orange-100 rounded-full flex items-center justify-center text-xl shrink-0">
                        ✅
                    </div>

                    <div>

                        <p class="text-base font-semibold text-gray-900">
                            Approval menunggu tindakan
                        </p>

                        <p class="text-sm text-gray-500">
                            Lihat daftar approval
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>