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

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('cashflow.dues.create') }}"
                            class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded text-sm shadow-sm">
                            + Buat Tagihan
                        </a>
                        <a href="{{ route('verifikasi-iuran.export-excel', ['month' => $month, 'year' => $year]) }}"
                            class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded text-sm shadow-sm">
                            📥 Export Excel
                        </a>
                    </div>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div style="display:grid; grid-template-columns:repeat(2,minmax(0,1fr));">

                        {{-- Total KK --}}
                        <div class="p-3 sm:p-5 border-r border-b border-gray-100">
                            <div class="flex items-center gap-1 text-gray-500">
                                <span class="text-sm">👨‍👩‍👧</span>
                                <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wide">Total KK</p>
                            </div>
                            <p class="text-xl sm:text-3xl font-bold text-gray-900 mt-1">{{ $totalKK }}</p>
                        </div>

                        {{-- Terkumpul --}}
                        <div class="p-3 sm:p-5 border-b border-gray-100">
                            <div class="flex items-center gap-1 text-gray-500">
                                <span class="text-sm">💰</span>
                                <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wide">Terkumpul</p>
                            </div>
                            <p class="text-base sm:text-2xl font-bold text-emerald-600 mt-1 break-words">
                                Rp {{ number_format($totalTerkumpul, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Lunas --}}
                        <div class="p-3 sm:p-5 border-r border-gray-100">
                            <div class="flex items-center gap-1 text-gray-500">
                                <span class="text-sm">✅</span>
                                <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wide">Lunas</p>
                            </div>
                            <p class="text-xl sm:text-3xl font-bold text-green-600 mt-1">
                                {{ $totalLunas }}
                                <span class="text-xs sm:text-sm font-normal text-gray-400">/ {{ $totalKK }}</span>
                            </p>
                        </div>

                        {{-- Belum Bayar --}}
                        <div class="p-3 sm:p-5">
                            <div class="flex items-center gap-1 text-gray-500">
                                <span class="text-sm">❌</span>
                                <p class="text-[10px] sm:text-xs font-semibold uppercase tracking-wide">Belum Bayar</p>
                            </div>
                            <p class="text-xl sm:text-3xl font-bold text-red-600 mt-1">{{ $totalBelumBayar }}</p>
                        </div>

                    </div>

                    {{-- Progress bar (tidak berubah) --}}
                    <div class="px-4 sm:px-5 py-3 bg-gray-50 border-t border-gray-100">
                        <div class="flex items-center justify-between text-xs text-gray-500 mb-1.5">
                            <span>Progres Pembayaran</span>
                            <span class="font-semibold text-green-700">{{ $persentaseLunas }}%</span>
                        </div>
                        <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full bg-green-500 rounded-full" style="width: {{ $persentaseLunas }}%"></div>
                        </div>
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

                <!-- Summary Accordion -->
                <div class="pt-2 space-y-3">
                    @forelse ($summary as $blok)
                        @php
                            $isOverdue = \Carbon\Carbon::create($year, $month, 1)->lt(now()->startOfMonth());
                            $belumLunasColor =
                                $blok->belum_lunas > 0
                                    ? ($isOverdue
                                        ? 'bg-red-100 text-red-800'
                                        : 'bg-amber-100 text-amber-800')
                                    : 'bg-gray-100 text-gray-600';
                        @endphp

                        <details class="group rounded-xl border border-gray-200 overflow-hidden">

                            <summary
                                class="flex items-center justify-between gap-3 px-4 py-3 bg-gray-50 cursor-pointer select-none hover:bg-gray-100 transition list-none">

                                <div class="flex items-center gap-3">
                                    <svg class="w-4 h-4 text-gray-400 transition-transform group-open:rotate-90"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                    <span class="font-bold text-gray-900">{{ $blok->name }}</span>
                                </div>

                                <div class="flex items-center gap-2 text-xs">
                                    <span class="text-gray-500">{{ $blok->total_kk }} KK</span>
                                    <span
                                        class="px-2 py-0.5 rounded-full font-medium bg-emerald-100 text-emerald-800">{{ $blok->lunas }}
                                        Lunas</span>
                                    @if ($blok->belum_lunas > 0)
                                        <span
                                            class="px-2 py-0.5 rounded-full font-medium {{ $belumLunasColor }}">{{ $blok->belum_lunas }}
                                            Belum</span>
                                    @endif
                                </div>

                            </summary>

                            <div class="px-4 py-4 space-y-3 border-t border-gray-100">

                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-sm text-gray-500">Jumlah KK</span>
                                    <span class="text-sm font-semibold text-gray-900">{{ $blok->total_kk }}</span>
                                </div>

                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-sm text-gray-500">Lunas</span>
                                    <span
                                        class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">{{ $blok->lunas }}
                                        Lunas</span>
                                </div>

                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-sm text-gray-500">Belum Lunas</span>
                                    <span
                                        class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $belumLunasColor }}">{{ $blok->belum_lunas }}
                                        Belum</span>
                                </div>

                                <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                    <span class="text-sm text-gray-500">Total Terkumpul</span>
                                    <span class="text-sm font-bold text-gray-900">Rp
                                        {{ number_format($blok->total_terkumpul, 0, ',', '.') }}</span>
                                </div>

                                <div class="flex items-center justify-between py-2">
                                    <span class="text-sm text-gray-500">Aksi</span>
                                    <a href="{{ route('cashflow.dues.index', ['block_id' => $blok->id, 'month' => $month, 'year' => $year]) }}"
                                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-semibold shadow-sm">
                                        Lihat Detail
                                    </a>
                                </div>

                            </div>

                        </details>
                    @empty
                        <div class="py-10 text-center text-gray-500 text-sm">
                            Belum ada data blok.
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
