<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Pengajuan Iuran
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Periksa data pengajuan sebelum melakukan verifikasi.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi Success --}}
            @if (session('success'))
                <div
                    class="mb-5 rounded-lg bg-green-100 border border-green-200
                            px-4 py-3 text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Notifikasi Error --}}
            @if (session('error'))
                <div
                    class="mb-5 rounded-lg bg-red-100 border border-red-200
                            px-4 py-3 text-red-800">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Error Validasi --}}
            @if ($errors->any())
                <div
                    class="mb-5 rounded-lg bg-red-100 border border-red-200
                            px-4 py-3 text-red-800">

                    <p class="font-semibold mb-2">
                        Terjadi kesalahan:
                    </p>

                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif


            {{-- ========================================================= --}}
            {{-- HEADER STATUS --}}
            {{-- ========================================================= --}}

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-5">

                <div
                    class="flex flex-col sm:flex-row sm:items-center
                            sm:justify-between gap-4">

                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Pengajuan #{{ $pengajuanIuran->id }}
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Diajukan pada
                            {{ $pengajuanIuran->created_at?->format('d/m/Y H:i') ?? '-' }}
                        </p>
                    </div>

                    {{-- Status --}}
                    <div class="flex items-center gap-3">

                        @if ($pengajuanIuran->status === 'Menunggu Verifikasi')
                            <span
                                class="inline-flex items-center px-4 py-2
                                         rounded-full text-sm font-semibold
                                         bg-yellow-100 text-yellow-800">
                                Menunggu Verifikasi
                            </span>
                        @elseif ($pengajuanIuran->status === 'Disetujui')
                            <span
                                class="inline-flex items-center px-4 py-2
                                         rounded-full text-sm font-semibold
                                         bg-green-100 text-green-800">
                                Disetujui
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-4 py-2
                                         rounded-full text-sm font-semibold
                                         bg-red-100 text-red-800">
                                Ditolak
                            </span>
                        @endif

                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- INFORMASI PENGAJUAN --}}
            {{-- ========================================================= --}}

            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200
                        overflow-hidden mb-5">

                <div class="p-5 border-b border-gray-200">

                    <h3 class="text-lg font-semibold text-gray-800">
                        Informasi Pengajuan
                    </h3>

                </div>

                <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- Blok --}}
                    <div>
                        <p class="text-sm text-gray-500">
                            Blok
                        </p>

                        <p class="mt-1 font-semibold text-gray-800">
                            {{ $pengajuanIuran->block->name ?? '-' }}
                        </p>
                    </div>

                    {{-- Pengaju --}}
                    <div>
                        <p class="text-sm text-gray-500">
                            Pengaju
                        </p>

                        <p class="mt-1 font-semibold text-gray-800">
                            {{ $pengajuanIuran->user->name ?? '-' }}
                        </p>
                    </div>

                    {{-- Periode --}}
                    <div>
                        <p class="text-sm text-gray-500">
                            Periode Iuran
                        </p>

                        <p class="mt-1 font-semibold text-gray-800">
                            {{ sprintf('%02d', $pengajuanIuran->bulan) }}
                            /
                            {{ $pengajuanIuran->tahun }}
                        </p>
                    </div>

                    {{-- Jumlah KK --}}
                    <div>
                        <p class="text-sm text-gray-500">
                            Jumlah KK Diajukan
                        </p>

                        <p class="mt-1 font-semibold text-gray-800">
                            {{ $pengajuanIuran->details->count() }} dari {{ $totalHouseholdsAktif }} KK aktif
                        </p>

                        @if ($kkBelumBayar > 0)
                            <p class="mt-1 text-sm font-medium text-yellow-700">
                                ⚠ {{ $kkBelumBayar }} KK belum membayar
                            </p>
                        @endif
                    </div>

                    {{-- Nominal --}}
                    <div>
                        <p class="text-sm text-gray-500">
                            Nominal per KK
                        </p>

                        <p class="mt-1 font-semibold text-gray-800">
                            Rp
                            {{ number_format($pengajuanIuran->nominal_per_kk, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Total --}}
                    <div>
                        <p class="text-sm text-gray-500">
                            Total Iuran Sistem
                        </p>

                        <p class="mt-1 text-xl font-bold text-green-600">
                            Rp
                            {{ number_format($pengajuanIuran->total_iuran, 0, ',', '.') }}
                        </p>
                    </div>

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- DAFTAR KK --}}
            {{-- ========================================================= --}}

            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200
                        overflow-hidden mb-5">

                <div class="p-5 border-b border-gray-200">

                    <h3 class="text-lg font-semibold text-gray-800">
                        Daftar KK yang Membayar
                    </h3>

                    <p class="text-sm text-gray-500 mt-1">
                        {{ $pengajuanIuran->details->count() }}
                        KK dipilih oleh Ketua Block.
                    </p>

                </div>

                @if ($pengajuanIuran->details->count())

                    <div class="divide-y divide-gray-200">

                        @foreach ($pengajuanIuran->details as $index => $detail)
                            <div class="p-4 flex items-center gap-4">

                                {{-- Nomor --}}
                                <div
                                    class="w-9 h-9 shrink-0 rounded-full
                                            bg-blue-100 text-blue-700
                                            flex items-center justify-center
                                            font-semibold text-sm">
                                    {{ $index + 1 }}
                                </div>

                                {{-- Data KK --}}
                                <div class="flex-1 min-w-0">

                                    <p class="font-semibold text-gray-800">
                                        {{ $detail->household->household_number ?? '-' }}
                                    </p>

                                    <p class="text-sm text-gray-500 truncate">
                                        {{ $detail->household->head_name ?? '-' }}
                                    </p>

                                </div>

                                {{-- Nominal --}}
                                <div class="text-right">

                                    <p class="font-semibold text-gray-800">
                                        Rp
                                        {{ number_format($pengajuanIuran->nominal_per_kk, 0, ',', '.') }}
                                    </p>

                                    <p class="text-xs text-green-600">
                                        Sudah Bayar
                                    </p>

                                </div>

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="p-6 text-center text-gray-500">
                        Tidak ada KK dalam pengajuan ini.
                    </div>

                @endif

            </div>


            {{-- ========================================================= --}}
            {{-- BUKTI PEMBAYARAN --}}
            {{-- ========================================================= --}}

            <div
                class="bg-white rounded-xl shadow-sm border border-gray-200
                        overflow-hidden mb-5">

                <div class="p-5 border-b border-gray-200">

                    <h3 class="text-lg font-semibold text-gray-800">
                        Bukti Pembayaran
                    </h3>

                </div>

                <div class="p-5">

                    @if ($pengajuanIuran->bukti)
                        <a href="{{ asset('storage/' . $pengajuanIuran->bukti) }}" target="_blank"
                            class="inline-flex items-center justify-center
                                  w-full sm:w-auto px-5 py-3
                                  rounded-lg bg-blue-600 text-white
                                  font-medium hover:bg-blue-700">

                            📎 Lihat Bukti Pembayaran

                        </a>

                        <p class="text-xs text-gray-500 mt-2">
                            Bukti akan dibuka pada tab baru.
                        </p>
                    @else
                        <div
                            class="rounded-lg bg-gray-50 border border-gray-200
                                    p-4 text-sm text-gray-500">
                            Tidak ada bukti pembayaran yang dilampirkan.
                        </div>
                    @endif

                </div>

            </div>


            {{-- ========================================================= --}}
            {{-- CATATAN --}}
            {{-- ========================================================= --}}

            @if ($pengajuanIuran->catatan)
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200
                            overflow-hidden mb-5">

                    <div class="p-5 border-b border-gray-200">

                        <h3 class="text-lg font-semibold text-gray-800">
                            Catatan
                        </h3>

                    </div>

                    <div class="p-5">

                        <div
                            class="rounded-lg bg-gray-50 border border-gray-200
                                    p-4 text-sm text-gray-700 whitespace-pre-line">
                            {{ $pengajuanIuran->catatan }}
                        </div>

                    </div>

                </div>
            @endif


            {{-- ========================================================= --}}
            {{-- INFORMASI VERIFIKASI --}}
            {{-- ========================================================= --}}

            @if ($pengajuanIuran->status !== 'Menunggu Verifikasi')
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200
                            overflow-hidden mb-5">

                    <div class="p-5 border-b border-gray-200">

                        <h3 class="text-lg font-semibold text-gray-800">
                            Informasi Verifikasi
                        </h3>

                    </div>

                    <div class="p-5 grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- Diverifikasi --}}
                        <div>
                            <p class="text-sm text-gray-500">
                                Diverifikasi oleh
                            </p>

                            <p class="mt-1 font-semibold text-gray-800">
                                {{ $pengajuanIuran->verifier->name ?? '-' }}
                            </p>
                        </div>

                        {{-- Waktu --}}
                        <div>
                            <p class="text-sm text-gray-500">
                                Waktu Verifikasi
                            </p>

                            <p class="mt-1 font-semibold text-gray-800">
                                {{ $pengajuanIuran->diverifikasi_pada?->format('d/m/Y H:i') ?? '-' }}
                            </p>
                        </div>

                        {{-- Uang Diterima --}}
                        <div>
                            <p class="text-sm text-gray-500">
                                Uang Diterima
                            </p>

                            <p class="mt-1 text-lg font-bold text-green-600">
                                Rp
                                {{ number_format($pengajuanIuran->uang_diterima ?? 0, 0, ',', '.') }}
                            </p>
                        </div>

                    </div>

                </div>
            @endif


            {{-- ========================================================= --}}
            {{-- VERIFIKASI PENGAJUAN --}}
            {{-- ========================================================= --}}

            @if ($pengajuanIuran->status === 'Menunggu Verifikasi')
                <div
                    class="bg-white rounded-xl shadow-sm border border-gray-200
                            overflow-hidden mb-5">

                    <div class="p-5 border-b border-gray-200">

                        <h3 class="text-lg font-semibold text-gray-800">
                            Verifikasi Pengajuan
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Masukkan jumlah uang yang benar-benar diterima
                            oleh Bendahara. Pengajuan hanya dapat disetujui
                            jika jumlahnya sesuai dengan total sistem.
                        </p>

                    </div>

                    <div class="p-5">

                        {{-- ================================================= --}}
                        {{-- FORM APPROVAL --}}
                        {{-- ================================================= --}}

                        <form method="POST" action="{{ route('verifikasi-iuran.approve', $pengajuanIuran) }}"
                            id="form-approve">

                            @csrf
                            @if ($kkBelumBayar > 0)
                                <div class="rounded-lg bg-yellow-50 border border-yellow-200 p-4 mb-5">
                                    <p class="font-semibold text-yellow-800">
                                        ⚠ Perhatian: Belum semua KK membayar
                                    </p>
                                    <p class="text-sm text-yellow-700 mt-1">
                                        Pengajuan ini hanya mencakup {{ $pengajuanIuran->details->count() }}
                                        dari {{ $totalHouseholdsAktif }} KK aktif di blok ini.
                                        {{ $kkBelumBayar }} KK belum tercatat membayar iuran periode ini.
                                    </p>
                                    <p class="text-sm text-yellow-700 mt-2">
                                        Jika seluruh {{ $totalHouseholdsAktif }} KK membayar,
                                        total seharusnya: Rp
                                        {{ number_format($totalHouseholdsAktif * $pengajuanIuran->nominal_per_kk, 0, ',', '.') }}
                                        ({{ $totalHouseholdsAktif }} KK × Rp
                                        {{ number_format($pengajuanIuran->nominal_per_kk, 0, ',', '.') }})
                                    </p>
                                </div>
                            @endif
                            {{-- Total Sistem --}}
                            <div
                                class="rounded-lg bg-blue-50 border border-blue-200
                                        p-4 mb-5">

                                <p class="text-sm text-blue-700">
                                    Total yang diterima
                                </p>

                                <p class="text-2xl font-bold text-blue-800 mt-1">
                                    Rp
                                    {{ number_format($pengajuanIuran->total_iuran, 0, ',', '.') }}
                                </p>

                            </div>


                            {{-- Uang Diterima --}}
                            <div class="mb-5">

                                <label for="uang_diterima"
                                    class="block text-sm font-semibold
                                              text-gray-700 mb-2">

                                    Uang Diterima Bendahara

                                </label>

                                <div class="relative">

                                    <span
                                        class="absolute left-3 top-1/2
                                                 -translate-y-1/2
                                                 text-gray-500 font-medium">
                                        Rp
                                    </span>

                                    <input type="number" name="uang_diterima" id="uang_diterima"
                                        value="{{ old('uang_diterima') }}" min="0" step="1" required
                                        class="w-full pl-12 pr-4 py-3
                                        rounded-lg border-gray-300
                                        focus:border-blue-500
                                        focus:ring-blue-500"
                                        placeholder="Contoh: {{ $totalHouseholdsAktif * $pengajuanIuran->nominal_per_kk }}">
                                </div>
                                @error('uang_diterima')
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            {{-- Status Perbandingan --}}
                            <div id="status-perbandingan" class="hidden rounded-lg p-4 mb-5">

                                <p id="status-text" class="font-semibold">
                                </p>

                                <p id="status-detail" class="text-sm mt-1">
                                </p>

                            </div>


                            {{-- Tombol --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                                {{-- Tombol Setujui --}}
                                <button type="submit" id="btn-approve" disabled
                                    class="w-full px-5 py-3 rounded-lg
                                               bg-gray-400 text-white
                                               font-semibold cursor-not-allowed
                                               transition">

                                    ✓ Setujui Pengajuan

                                </button>

                                {{-- Tombol Tolak --}}
                                <button type="button"
                                    onclick="document.getElementById('form-tolak').classList.toggle('hidden')"
                                    class="w-full px-5 py-3 rounded-lg
                                               bg-red-600 text-white
                                               font-semibold hover:bg-red-700
                                               transition">

                                    ✕ Tolak Pengajuan

                                </button>

                            </div>

                        </form>


                        {{-- ================================================= --}}
                        {{-- FORM PENOLAKAN --}}
                        {{-- ================================================= --}}

                        <div id="form-tolak"
                            class="hidden mt-5 rounded-lg
                                    bg-red-50 border border-red-200 p-5">

                            <h4 class="font-semibold text-red-800">
                                Alasan Penolakan
                            </h4>

                            <p class="text-sm text-red-700 mt-1 mb-4">
                                Jelaskan alasan pengajuan ini ditolak.
                            </p>

                            <form method="POST" action="{{ route('verifikasi-iuran.reject', $pengajuanIuran) }}">

                                @csrf

                                <textarea name="catatan" rows="4" required maxlength="1000"
                                    class="w-full rounded-lg border-gray-300
                                                 focus:border-red-500
                                                 focus:ring-red-500"
                                    placeholder="Contoh: Jumlah uang yang diterima tidak sesuai dengan total iuran.">{{ old('catatan') }}</textarea>

                                @error('catatan')
                                    <p class="mt-2 text-sm text-red-600">
                                        {{ $message }}
                                    </p>
                                @enderror

                                <button type="submit"
                                    class="mt-3 w-full px-5 py-3
                                               rounded-lg bg-red-600 text-white
                                               font-semibold hover:bg-red-700">

                                    Konfirmasi Penolakan

                                </button>

                            </form>

                        </div>

                    </div>

                </div>
            @endif


            {{-- ========================================================= --}}
            {{-- KEMBALI --}}
            {{-- ========================================================= --}}

            <div class="flex flex-col sm:flex-row gap-3">

                <a href="{{ route('verifikasi-iuran.index') }}"
                    class="inline-flex items-center justify-center
                          px-5 py-3 rounded-lg
                          bg-gray-200 text-gray-700
                          font-medium hover:bg-gray-300">

                    ← Kembali ke Daftar

                </a>

            </div>

        </div>
    </div>


    {{-- ============================================================= --}}
    {{-- JAVASCRIPT PERBANDINGAN NOMINAL --}}
    {{-- ============================================================= --}}

    @if ($pengajuanIuran->status === 'Menunggu Verifikasi')
        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const input = document.getElementById('uang_diterima');
                const button = document.getElementById('btn-approve');
                const statusBox = document.getElementById('status-perbandingan');
                const statusText = document.getElementById('status-text');
                const statusDetail = document.getElementById('status-detail');

                const totalSistem = Number(
                    {{ (int) round((float) $pengajuanIuran->total_iuran) }}
                );

                function formatRupiah(angka) {
                    return new Intl.NumberFormat('id-ID').format(angka);
                }

                function resetButton() {

                    button.disabled = true;

                    button.classList.remove(
                        'bg-green-600',
                        'hover:bg-green-700'
                    );

                    button.classList.add(
                        'bg-gray-400',
                        'cursor-not-allowed'
                    );
                }

                function cekUang() {

                    const uangDiterima = Number(input.value);

                    resetButton();

                    if (!input.value) {

                        statusBox.classList.add('hidden');

                        return;
                    }

                    statusBox.classList.remove('hidden');

                    if (uangDiterima === totalSistem) {

                        {{-- =============================== --}}
                        {{-- NOMINAL SESUAI --}}
                        {{-- =============================== --}}

                        statusBox.className =
                            'rounded-lg p-4 mb-5 bg-green-50 border border-green-200 text-green-800';

                        statusText.textContent =
                            '✓ Jumlah uang sesuai';

                        statusDetail.textContent =
                            'Uang diterima sama dengan total iuran sistem: Rp ' +
                            formatRupiah(totalSistem);

                        button.disabled = false;

                        button.classList.remove(
                            'bg-gray-400',
                            'cursor-not-allowed'
                        );

                        button.classList.add(
                            'bg-green-600',
                            'hover:bg-green-700',
                            'cursor-pointer'
                        );

                    } else {

                        {{-- =============================== --}}
                        {{-- NOMINAL TIDAK SESUAI --}}
                        {{-- =============================== --}}

                        statusBox.className =
                            'rounded-lg p-4 mb-5 bg-red-50 border border-red-200 text-red-800';

                        statusText.textContent =
                            '✕ Jumlah uang tidak sesuai';

                        if (uangDiterima < totalSistem) {

                            statusDetail.textContent =
                                'Uang diterima kurang Rp ' +
                                formatRupiah(
                                    totalSistem - uangDiterima
                                );

                        } else {

                            statusDetail.textContent =
                                'Uang diterima lebih Rp ' +
                                formatRupiah(
                                    uangDiterima - totalSistem
                                );

                        }

                    }
                }

                input.addEventListener(
                    'input',
                    cekUang
                );

                cekUang();

            });
        </script>
    @endif

</x-app-layout>
