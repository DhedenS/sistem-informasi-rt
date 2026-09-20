<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Iuran Kas Per KK (Rumah Tangga)</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('success'))
                <div class="p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-700 rounded shadow-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow rounded-lg space-y-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Ringkasan Iuran Per Blok</h3>
                        <p class="text-xs text-gray-500">Klik "Lihat Detail" untuk melihat status iuran per KK dalam satu
                            blok.</p>
                    </div>
                    <a href="{{ route('cashflow.dues.create') }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded text-sm flex items-center gap-1 shadow-sm w-fit">
                        + Buat Tagihan Iuran
                    </a>
                    <a href="{{ route('verifikasi-iuran.export-excel', ['month' => $month, 'year' => $year]) }}"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded text-sm flex items-center gap-1 shadow-sm w-fit">
                        📥 Export Excel
                    </a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500">Total KK Aktif</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalKK }} <span
                                    class="text-sm font-normal text-gray-500">KK</span></p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl">
                            👨‍👩‍👧</div>
                    </div>

                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500">Sudah Bayar (Lunas)</p>
                            <div class="flex items-baseline gap-2 mt-1">
                                <span class="text-2xl font-bold text-green-600">{{ $totalLunas }}</span>
                                <span
                                    class="text-xs font-semibold text-green-700 bg-green-100 px-2 py-0.5 rounded-full">{{ $persentaseLunas }}%</span>
                            </div>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-2xl">
                            ✅</div>
                    </div>

                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500">Belum Bayar</p>
                            <p class="text-2xl font-bold text-red-600 mt-1">{{ $totalBelumBayar }} <span
                                    class="text-sm font-normal text-gray-500">KK</span></p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-2xl">
                            ❌</div>
                    </div>

                    <div
                        class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase text-gray-500">Total Uang Terkumpul</p>
                            <p class="text-xl font-bold text-emerald-600 mt-1">Rp
                                {{ number_format($totalTerkumpul, 0, ',', '.') }}</p>
                        </div>
                        <div
                            class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl">
                            💰</div>
                    </div>

                </div>
                <!-- Filter Periode -->
                <form action="{{ route('cashflow.dues.index') }}" method="GET"
                    class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-4 gap-3 pt-4 border-t border-gray-100">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Blok</label>
                        <select name="filter_block"
                            class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Blok</option>
                            @foreach ($blocks as $blk)
                                <option value="{{ $blk->id }}"
                                    {{ request('filter_block') == $blk->id ? 'selected' : '' }}>
                                    {{ $blk->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Bulan</label>
                        <select name="month"
                            class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @php
                                $months = [
                                    1 => 'Januari',
                                    2 => 'Februari',
                                    3 => 'Maret',
                                    4 => 'April',
                                    5 => 'Mei',
                                    6 => 'Juni',
                                    7 => 'Juli',
                                    8 => 'Agustus',
                                    9 => 'September',
                                    10 => 'Oktober',
                                    11 => 'November',
                                    12 => 'Desember',
                                ];
                            @endphp
                            @foreach ($months as $num => $name)
                                <option value="{{ $num }}" {{ (int) $month === $num ? 'selected' : '' }}>
                                    {{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tahun</label>
                        <select name="year"
                            class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @for ($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ (int) $year === $y ? 'selected' : '' }}>
                                    {{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full py-2 px-4 bg-gray-800 text-white rounded text-sm hover:bg-gray-900 font-medium">Tampilkan</button>
                    </div>
                </form>

                <!-- Summary Table -->
                <div class="overflow-x-auto pt-2">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Blok
                                </th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah
                                    KK</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Lunas
                                </th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Belum
                                    Lunas</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Total
                                    Terkumpul</th>
                                <th
                                    class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($summary as $blok)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm font-bold text-gray-900">{{ $blok->name }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-700">{{ $blok->total_kk }}</td>
                                    <td class="py-3 px-4 text-sm">
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">{{ $blok->lunas }}
                                            Lunas</span>
                                    </td>
                                    <td class="py-3 px-4 text-sm">
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">{{ $blok->belum_lunas }}
                                            Belum</span>
                                    </td>
                                    <td class="py-3 px-4 text-sm font-bold text-gray-900">Rp
                                        {{ number_format($blok->total_terkumpul, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-sm text-right">
                                        <a href="{{ route('cashflow.dues.index', ['block_id' => $blok->id, 'month' => $month, 'year' => $year]) }}"
                                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded text-xs font-semibold shadow-sm">
                                            Lihat Detail
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-center text-gray-500">Belum ada data blok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
