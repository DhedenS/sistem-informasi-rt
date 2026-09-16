<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
            <p class="text-sm text-gray-500 mt-1">
                Selamat datang di Sistem Informasi RT
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- STATISTIK --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

                {{-- TOTAL KK --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Total KK
                                </p>
                                <p class="text-2xl font-semibold text-gray-800 mt-1">
                                    {{ $totalKK }}
                                </p>
                                <p class="text-xs text-green-600 mt-1">
                                    ↑ Data keluarga
                                </p>
                            </div>

                            <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                👨‍👩‍👧‍👦
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SURAT MASUK --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Surat Masuk
                                </p>
                                <p class="text-2xl font-semibold text-gray-800 mt-1">
                                    {{ $totalSuratMasuk }}
                                </p>
                                <p class="text-xs text-blue-600 mt-1">
                                    Surat diterima
                                </p>
                            </div>

                            <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                📄
                            </div>
                        </div>
                    </div>
                </div>

                {{-- SALDO KAS --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Saldo Kas
                                </p>
                                <p class="text-2xl font-semibold text-gray-800 mt-1">
                                    Rp {{ number_format($saldoKas, 0, ',', '.') }}
                                </p>
                                <p class="text-xs text-green-600 mt-1">
                                    Saldo saat ini
                                </p>
                            </div>

                            <div class="p-3 rounded-full bg-green-100 text-green-600">
                                💰
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TOTAL BLOK --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-500">
                                    Total Blok
                                </p>
                                <p class="text-2xl font-semibold text-gray-800 mt-1">
                                    {{ $totalBlok }}
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    Blok terdaftar
                                </p>
                            </div>

                            <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                                🏘️
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            {{-- BAGIAN BAWAH --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- GRAFIK CASHFLOW --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Grafik Cashflow
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Pemasukan dan pengeluaran kas
                                </p>
                            </div>

                            <button
                                type="button"
                                class="px-3 py-1.5 text-sm font-medium
                                       text-gray-600 border border-gray-300
                                       rounded-lg hover:bg-gray-50">
                                6 Bulan
                            </button>
                        </div>

                        <div class="flex items-end justify-between h-64 space-x-4">

                            @foreach ($cashflowData as $item)

                                @php
                                    $tinggiMasuk = $item['masuk'] > 0
                                        ? max(($item['masuk'] / $maxValue) * 100, 4)
                                        : 0;
                                @endphp

                                <div class="flex flex-col items-center flex-1 h-full justify-end">

                                    <div
                                        class="w-full bg-blue-500 rounded-t"
                                        style="height: {{ $tinggiMasuk }}%;"
                                        title="Rp {{ number_format($item['masuk'], 0, ',', '.') }}">
                                    </div>

                                    <span class="text-xs text-gray-500 mt-2">
                                        {{ $item['label'] }}
                                    </span>

                                </div>

                            @endforeach

                        </div>
                    </div>
                </div>


                {{-- AKTIVITAS TERBARU --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">

                        {{-- HEADER AKTIVITAS + LIHAT SEMUA --}}
                        <div class="flex items-center justify-between mb-6">

                            <div>
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Aktivitas Terbaru
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Aktivitas sistem terbaru
                                </p>
                            </div>

                            {{-- LIHAT SEMUA --}}
                            <a
                                href="{{ route('riwayat-transaksi.index') }}"
                                class="text-sm font-medium text-blue-600 hover:text-blue-700 whitespace-nowrap"
                            >
                                Lihat Semua →
                            </a>

                        </div>


                        {{-- DAFTAR TRANSAKSI --}}
                        <div class="space-y-5">

                            @forelse ($transaksiTerbaru as $trx)

                                <div class="flex items-start">

                                    <div class="flex-shrink-0">
                                        <div
                                            class="w-10 h-10 rounded-full
                                            {{ $trx->type === 'masuk'
                                                ? 'bg-green-100'
                                                : 'bg-red-100' }}
                                            flex items-center justify-center">
                                            💰
                                        </div>
                                    </div>

                                    <div class="ml-4">

                                        <p class="text-sm font-medium text-gray-800">
                                            {{ $trx->type === 'masuk'
                                                ? 'Pemasukan'
                                                : 'Pengeluaran' }}:
                                            Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                        </p>

                                        <p class="text-xs text-gray-500">
                                            {{ $trx->created_at->diffForHumans() }}
                                        </p>

                                    </div>

                                </div>

                            @empty

                                <p class="text-sm text-gray-500">
                                    Belum ada transaksi tercatat.
                                </p>

                            @endforelse

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>