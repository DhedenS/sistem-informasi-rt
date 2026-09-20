<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight flex items-center gap-2">
                    <span>📊</span> Rekapitulasi Iuran Warga
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Rekap status pembayaran iuran bulanan per Blok untuk transparansi & pembagian ke warga.
                </p>
            </div>

            {{-- ACTION BUTTONS --}}
            <div class="flex items-center gap-2 print:hidden">
                <a href="{{ route('verifikasi-iuran.export-excel', request()->all()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-emerald-600 text-white font-semibold text-sm hover:bg-emerald-700 shadow-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Export Excel (.xlsx)
                </a>

                <button type="button" onclick="window.print()"
                        class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gray-800 text-white font-semibold text-sm hover:bg-gray-900 shadow-sm transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    Cetak / Print
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- PRINT TITLE HEADER (HANYA MUNCUL SAAT PRINTER) --}}
            <div class="hidden print:block mb-6 text-center border-b pb-4">
                <h1 class="text-2xl font-bold text-gray-900">REKAPITULASI IURAN WARGA RT</h1>
                <p class="text-sm text-gray-600 mt-1">
                    Periode: Bulan {{ sprintf('%02d', $month) }} / {{ $year }}
                    @if($selectedBlockId)
                        | Blok: {{ $blocks->firstWhere('id', $selectedBlockId)->name ?? '-' }}
                    @else
                        | Semua Blok
                    @endif
                </p>
            </div>

            {{-- ========================================================= --}}
            {{-- FILTER BAR --}}
            {{-- ========================================================= --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6 print:hidden">
                <form method="GET" action="{{ route('verifikasi-iuran.rekap') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                    {{-- BULAN --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Bulan</label>
                        <select name="month" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            @php
                                $months = [
                                    1 => '01 - Januari', 2 => '02 - Februari', 3 => '03 - Maret', 4 => '04 - April',
                                    5 => '05 - Mei', 6 => '06 - Juni', 7 => '07 - Juli', 8 => '08 - Agustus',
                                    9 => '09 - September', 10 => '10 - Oktober', 11 => '11 - November', 12 => '12 - Desember'
                                ];
                            @endphp
                            @foreach ($months as $num => $name)
                                <option value="{{ $num }}" {{ (int)$month === $num ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- TAHUN --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Tahun</label>
                        <select name="year" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            @for ($y = date('Y') + 1; $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ (int)$year === $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    {{-- BLOK --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Blok</label>
                        <select name="block_id" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Blok</option>
                            @foreach ($blocks as $block)
                                <option value="{{ $block->id }}" {{ $selectedBlockId == $block->id ? 'selected' : '' }}>
                                    {{ $block->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- STATUS --}}
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-1.5">Status Pembayaran</label>
                        <select name="status" class="w-full rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="Lunas" {{ $selectedStatus === 'Lunas' ? 'selected' : '' }}>✅ Sudah Bayar (Lunas)</option>
                            <option value="Belum Lunas" {{ $selectedStatus === 'Belum Lunas' ? 'selected' : '' }}>❌ Belum Bayar</option>
                            <option value="Menunggu Verifikasi" {{ $selectedStatus === 'Menunggu Verifikasi' ? 'selected' : '' }}>🕐 Menunggu Verifikasi</option>
                        </select>
                    </div>

                    {{-- BUTTONS --}}
                    <div class="flex items-end gap-2">
                        <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2.5 rounded-lg text-sm transition text-center">
                            Filter
                        </button>
                        <a href="{{ route('verifikasi-iuran.rekap') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-3 py-2.5 rounded-lg text-sm transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- ========================================================= --}}
            {{-- SUMMARY STAT CARDS --}}
            {{-- ========================================================= --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

                {{-- CARD 1: TOTAL KK --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">Total KK Aktif</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalKK }} <span class="text-sm font-normal text-gray-500">KK</span></p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-2xl font-bold">
                        👨‍👩‍👧
                    </div>
                </div>

                {{-- CARD 2: SUDAH BAYAR --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">Sudah Bayar (Lunas)</p>
                        <div class="flex items-baseline gap-2 mt-1">
                            <span class="text-2xl font-bold text-green-600">{{ $lunasKK }}</span>
                            <span class="text-xs font-semibold text-green-700 bg-green-100 px-2 py-0.5 rounded-full">{{ $persentaseLunas }}%</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center text-2xl font-bold">
                        ✅
                    </div>
                </div>

                {{-- CARD 3: BELUM BAYAR --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">Belum Bayar</p>
                        <p class="text-2xl font-bold text-red-600 mt-1">{{ $belumBayarKK }} <span class="text-sm font-normal text-gray-500">KK</span></p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center text-2xl font-bold">
                        ❌
                    </div>
                </div>

                {{-- CARD 4: TOTAL NOMINAL --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 flex items-center justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase text-gray-500">Total Uang Terkumpul</p>
                        <p class="text-xl font-bold text-emerald-600 mt-1">Rp {{ number_format($totalNominal, 0, ',', '.') }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold">
                        💰
                    </div>
                </div>

            </div>

            {{-- ========================================================= --}}
            {{-- DATA TABLE REKAP --}}
            {{-- ========================================================= --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-5 border-b border-gray-200 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Daftar Warga & Status Iuran
                        </h3>
                        <p class="text-sm text-gray-500 mt-0.5">
                            Periode Bulan {{ sprintf('%02d', $month) }}/{{ $year }}
                        </p>
                    </div>

                    <div class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold text-gray-900">{{ count($rekapList) }}</span> KK
                    </div>
                </div>

                @if(count($rekapList) > 0)
                    {{-- DESKTOP TABLE --}}
                    <div class="hidden md:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Blok</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No. Rumah / KK</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Kepala Keluarga</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status Pembayaran</th>
                                    <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Tanggal Bayar</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Nominal</th>
                                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($rekapList as $index => $item)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3.5 text-sm text-gray-600 text-center">{{ $index + 1 }}</td>
                                        <td class="px-4 py-3.5 text-sm font-semibold text-gray-800">{{ $item->block_name }}</td>
                                        <td class="px-4 py-3.5 text-sm text-gray-700 font-mono">{{ $item->household_number }}</td>
                                        <td class="px-4 py-3.5 text-sm font-medium text-gray-900">
                                            {{ $item->head_name }}
                                            @if($item->phone && $item->phone !== '-')
                                                <span class="block text-xs text-gray-400 font-normal">📞 {{ $item->phone }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 text-center">
                                            @if($item->status === 'Sudah Bayar')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800 border border-green-200">
                                                    ✅ Sudah Bayar
                                                </span>
                                            @elseif($item->status === 'Menunggu Verifikasi')
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800 border border-yellow-200">
                                                    🕐 Menunggu Verifikasi
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800 border border-red-200">
                                                    ❌ Belum Bayar
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 text-sm text-gray-600 text-center font-mono">
                                            {{ $item->payment_date }}
                                        </td>
                                        <td class="px-4 py-3.5 text-sm font-semibold text-gray-800 text-right font-mono">
                                            {{ $item->nominal > 0 ? 'Rp ' . number_format($item->nominal, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-4 py-3.5 text-sm text-gray-500">
                                            {{ $item->notes }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- MOBILE LIST --}}
                    <div class="md:hidden divide-y divide-gray-200">
                        @foreach($rekapList as $index => $item)
                            <div class="p-4 flex flex-col gap-2">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <span class="text-xs font-bold text-blue-600 uppercase">{{ $item->block_name }}</span>
                                        <h4 class="font-semibold text-gray-900">{{ $item->head_name }}</h4>
                                        <p class="text-xs text-gray-500">No. Rumah/KK: {{ $item->household_number }}</p>
                                    </div>
                                    <div>
                                        @if($item->status === 'Sudah Bayar')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">✅ Sudah Bayar</span>
                                        @elseif($item->status === 'Menunggu Verifikasi')
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">🕐 Menunggu</span>
                                        @else
                                            <span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">❌ Belum Bayar</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex items-center justify-between text-xs text-gray-600 pt-2 border-t border-gray-100">
                                    <span>Tgl: {{ $item->payment_date }}</span>
                                    <span class="font-bold text-gray-900">
                                        {{ $item->nominal > 0 ? 'Rp ' . number_format($item->nominal, 0, ',', '.') : '-' }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-10 text-center">
                        <div class="text-gray-400 text-5xl mb-3">🔍</div>
                        <h3 class="text-lg font-semibold text-gray-800">Tidak ada data ditemukan</h3>
                        <p class="text-sm text-gray-500 mt-1">Coba sesuaikan filter bulan, tahun, atau blok yang dipilih.</p>
                    </div>
                @endif
            </div>

        </div>
    </div>

</x-app-layout>
