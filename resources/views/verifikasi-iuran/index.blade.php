<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Verifikasi Iuran
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Kelola dan verifikasi pengajuan iuran dari Ketua Block.
            </p>
        </div>
    </x-slot>


    <div class="py-6">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">


            {{-- ====================================================== --}}
            {{-- NOTIFIKASI --}}
            {{-- ====================================================== --}}

            @if (session('success'))

                <div class="mb-4 rounded-lg bg-green-100 border border-green-200
                            px-4 py-3 text-green-800">

                    {{ session('success') }}

                </div>

            @endif


            @if (session('error'))

                <div class="mb-4 rounded-lg bg-red-100 border border-red-200
                            px-4 py-3 text-red-800">

                    {{ session('error') }}

                </div>

            @endif


            {{-- ====================================================== --}}
            {{-- BANNER REKAP & EXPORT EXCEL --}}
            {{-- ====================================================== --}}
            <div class="mb-5 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-xl p-5 text-white shadow-sm">
                <div>
                    <h3 class="text-lg font-bold flex items-center gap-2">
                        <span>📊</span> Rekapitulasi Iuran Warga & Export Excel
                    </h3>
                    <p class="text-sm text-blue-100 mt-1">
                        Lihat rekap status iuran warga per blok (siapa yang sudah & belum bayar) dan download Excel (.xlsx).
                    </p>
                </div>
                <a href="{{ route('verifikasi-iuran.rekap') }}"
                   class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-lg bg-white text-blue-700 font-semibold text-sm hover:bg-blue-50 transition shadow shrink-0">
                    Buka Rekap & Export Excel →
                </a>
            </div>

            {{-- ====================================================== --}}
            {{-- CARD UTAMA --}}
            {{-- ====================================================== --}}

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">


                {{-- HEADER CARD --}}

                <div class="p-5 border-b border-gray-200">

                    <h3 class="text-lg font-semibold text-gray-800">
                        Daftar Pengajuan Iuran
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        Periksa jumlah KK, total iuran, dan bukti pembayaran
                        sebelum melakukan verifikasi.
                    </p>

                </div>


                {{-- ================================================== --}}
                {{-- DATA PENGAJUAN --}}
                {{-- ================================================== --}}

                @if ($pengajuan->count())


                    {{-- ================================================== --}}
                    {{-- DESKTOP --}}
                    {{-- ================================================== --}}

                    <div class="hidden md:block overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">

                                <tr>

                                    <th class="px-4 py-3 text-left text-xs font-semibold
                                               text-gray-500 uppercase">
                                        No
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold
                                               text-gray-500 uppercase">
                                        Blok
                                    </th>

                                    <th class="px-4 py-3 text-left text-xs font-semibold
                                               text-gray-500 uppercase">
                                        Periode
                                    </th>

                                    <th class="px-4 py-3 text-center text-xs font-semibold
                                               text-gray-500 uppercase">
                                        Jumlah KK
                                    </th>

                                    <th class="px-4 py-3 text-right text-xs font-semibold
                                               text-gray-500 uppercase">
                                        Total
                                    </th>

                                    <th class="px-4 py-3 text-center text-xs font-semibold
                                               text-gray-500 uppercase">
                                        Status
                                    </th>

                                    <th class="px-4 py-3 text-center text-xs font-semibold
                                               text-gray-500 uppercase">
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            <tbody class="bg-white divide-y divide-gray-200">


                                @foreach ($pengajuan as $item)

                                    <tr class="hover:bg-gray-50">


                                        {{-- NO --}}

                                        <td class="px-4 py-4 text-sm text-gray-700">

                                            {{ $pengajuan->firstItem() + $loop->index }}

                                        </td>


                                        {{-- BLOK --}}

                                        <td class="px-4 py-4 text-sm font-medium text-gray-800">

                                            {{ $item->block->name ?? '-' }}

                                        </td>


                                        {{-- PERIODE --}}

                                        <td class="px-4 py-4 text-sm text-gray-700">

                                            {{ sprintf('%02d', $item->bulan) }}/{{ $item->tahun }}

                                        </td>


                                        {{-- JUMLAH KK --}}

                                        <td class="px-4 py-4 text-sm text-gray-700 text-center">

                                            {{ $item->details_count ?? $item->details->count() }} KK

                                        </td>


                                        {{-- TOTAL --}}

                                        <td class="px-4 py-4 text-sm font-semibold
                                                   text-gray-800 text-right">

                                            Rp {{ number_format($item->total_iuran, 0, ',', '.') }}

                                        </td>


                                        {{-- ================================================= --}}
                                        {{-- STATUS --}}
                                        {{-- ================================================= --}}

                                        <td class="px-4 py-4 text-center">


                                            {{-- MENUNGGU --}}

                                            @if ($item->status === 'Menunggu Verifikasi')

                                                <span class="inline-flex items-center
                                                             px-3 py-1.5
                                                             rounded-full
                                                             text-xs font-semibold
                                                             bg-yellow-100
                                                             text-yellow-800
                                                             border border-yellow-200">

                                                    🕐 Menunggu Verifikasi

                                                </span>


                                            {{-- DISETUJUI --}}

                                            @elseif ($item->status === 'Disetujui')

                                                <span class="inline-flex items-center
                                                             px-3 py-1.5
                                                             rounded-full
                                                             text-xs font-semibold
                                                             bg-green-100
                                                             text-green-800
                                                             border border-green-200">

                                                    ✅ Disetujui

                                                </span>


                                            {{-- DITOLAK --}}

                                            @elseif ($item->status === 'Ditolak')

                                                <span class="inline-flex items-center
                                                             px-3 py-1.5
                                                             rounded-full
                                                             text-xs font-semibold
                                                             bg-red-100
                                                             text-red-800
                                                             border border-red-200">

                                                    ❌ Ditolak

                                                </span>


                                            @endif

                                        </td>


                                        {{-- AKSI --}}

                                        <td class="px-4 py-4 text-center">

                                            <a href="{{ route('verifikasi-iuran.show', $item) }}"
                                               class="inline-flex items-center
                                                      px-3 py-2
                                                      rounded-lg
                                                      bg-blue-600
                                                      text-white
                                                      text-sm
                                                      font-medium
                                                      hover:bg-blue-700
                                                      transition">

                                                Lihat Detail

                                            </a>

                                        </td>


                                    </tr>

                                @endforeach


                            </tbody>

                        </table>

                    </div>



                    {{-- ================================================== --}}
                    {{-- MOBILE --}}
                    {{-- ================================================== --}}

                    <div class="md:hidden divide-y divide-gray-200">


                        @foreach ($pengajuan as $item)


                            <div class="p-4">


                                {{-- HEADER CARD MOBILE --}}

                                <div class="flex justify-between items-start gap-3">


                                    <div>

                                        <h4 class="font-semibold text-gray-800">

                                            {{ $item->block->name ?? '-' }}

                                        </h4>


                                        <p class="text-sm text-gray-500 mt-1">

                                            Periode:
                                            {{ sprintf('%02d', $item->bulan) }}/{{ $item->tahun }}

                                        </p>

                                    </div>



                                    {{-- STATUS MOBILE --}}

                                    @if ($item->status === 'Menunggu Verifikasi')

                                        <span class="inline-flex items-center
                                                     px-2.5 py-1
                                                     rounded-full
                                                     text-xs font-semibold
                                                     bg-yellow-100
                                                     text-yellow-800
                                                     border border-yellow-200">

                                            🕐 Menunggu

                                        </span>


                                    @elseif ($item->status === 'Disetujui')

                                        <span class="inline-flex items-center
                                                     px-2.5 py-1
                                                     rounded-full
                                                     text-xs font-semibold
                                                     bg-green-100
                                                     text-green-800
                                                     border border-green-200">

                                            ✅ Disetujui

                                        </span>


                                    @elseif ($item->status === 'Ditolak')

                                        <span class="inline-flex items-center
                                                     px-2.5 py-1
                                                     rounded-full
                                                     text-xs font-semibold
                                                     bg-red-100
                                                     text-red-800
                                                     border border-red-200">

                                            ❌ Ditolak

                                        </span>

                                    @endif


                                </div>



                                {{-- INFORMASI MOBILE --}}

                                <div class="mt-4 grid grid-cols-2 gap-3">


                                    {{-- JUMLAH KK --}}

                                    <div class="bg-gray-50 rounded-lg p-3">

                                        <p class="text-xs text-gray-500">
                                            Jumlah KK
                                        </p>

                                        <p class="font-semibold text-gray-800">

                                            {{ $item->details_count ?? $item->details->count() }} KK

                                        </p>

                                    </div>



                                    {{-- TOTAL --}}

                                    <div class="bg-gray-50 rounded-lg p-3">

                                        <p class="text-xs text-gray-500">
                                            Total
                                        </p>

                                        <p class="font-semibold text-gray-800">

                                            Rp {{ number_format($item->total_iuran, 0, ',', '.') }}

                                        </p>

                                    </div>


                                </div>



                                {{-- TOMBOL DETAIL --}}

                                <a href="{{ route('verifikasi-iuran.show', $item) }}"
                                   class="mt-4 block w-full text-center
                                          px-4 py-3
                                          rounded-lg
                                          bg-blue-600
                                          text-white
                                          font-medium
                                          hover:bg-blue-700
                                          transition">

                                    Lihat Detail

                                </a>


                            </div>


                        @endforeach


                    </div>



                    {{-- ================================================== --}}
                    {{-- PAGINATION --}}
                    {{-- ================================================== --}}

                    <div class="p-4 border-t border-gray-200">

                        {{ $pengajuan->links() }}

                    </div>


                @else


                    {{-- ================================================== --}}
                    {{-- DATA KOSONG --}}
                    {{-- ================================================== --}}

                    <div class="p-10 text-center">


                        <div class="text-gray-400 text-5xl mb-4">
                            📋
                        </div>


                        <h3 class="text-lg font-semibold text-gray-800">

                            Belum Ada Pengajuan

                        </h3>


                        <p class="text-sm text-gray-500 mt-1">

                            Belum ada pengajuan iuran dari Ketua Block.

                        </p>


                    </div>


                @endif


            </div>


        </div>

    </div>

</x-app-layout>