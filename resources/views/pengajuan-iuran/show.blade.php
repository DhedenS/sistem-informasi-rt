<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                Detail Pengajuan Iuran
            </h2>

            <p class="text-sm text-gray-500">
                Informasi lengkap pengajuan iuran.
            </p>
        </div>
    </x-slot>


    <div class="py-6">

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Status --}}
            <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

                <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-sm text-gray-500">
                            Periode
                        </p>

                        <h1 class="text-2xl font-bold text-gray-900">
                            {{ $pengajuanIuran->bulan }}/{{ $pengajuanIuran->tahun }}
                        </h1>

                    </div>


                    <div>

                        @if ($pengajuanIuran->status === 'Menunggu Verifikasi')

                            <span class="inline-flex rounded-full bg-yellow-100 px-4 py-2 text-sm font-semibold text-yellow-800">
                                Menunggu Verifikasi
                            </span>

                        @elseif ($pengajuanIuran->status === 'Disetujui')

                            <span class="inline-flex rounded-full bg-green-100 px-4 py-2 text-sm font-semibold text-green-800">
                                Disetujui
                            </span>

                        @elseif ($pengajuanIuran->status === 'Ditolak')

                            <span class="inline-flex rounded-full bg-red-100 px-4 py-2 text-sm font-semibold text-red-800">
                                Ditolak
                            </span>

                        @endif

                    </div>

                </div>

            </div>


            {{-- Informasi pengajuan --}}
            <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

                <h2 class="text-lg font-semibold text-gray-900">
                    Informasi Pengajuan
                </h2>


                <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2">

                    <div>

                        <p class="text-sm text-gray-500">
                            Blok
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $pengajuanIuran->block->name ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-sm text-gray-500">
                            Pengaju
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            {{ $pengajuanIuran->user->name ?? '-' }}
                        </p>

                    </div>


                    <div>

                        <p class="text-sm text-gray-500">
                            Nominal per KK
                        </p>

                        <p class="mt-1 font-semibold text-gray-900">
                            Rp {{ number_format($pengajuanIuran->nominal_per_kk, 0, ',', '.') }}
                        </p>

                    </div>


                    <div>

                        <p class="text-sm text-gray-500">
                            Total Iuran
                        </p>

                        <p class="mt-1 text-xl font-bold text-green-700">
                            Rp {{ number_format($pengajuanIuran->total_iuran, 0, ',', '.') }}
                        </p>

                    </div>

                </div>

            </div>


            {{-- Daftar KK --}}
            <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

                <div class="flex items-center justify-between">

                    <div>

                        <h2 class="text-lg font-semibold text-gray-900">
                            KK yang Membayar
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            {{ $pengajuanIuran->details->count() }} KK
                        </p>

                    </div>

                </div>


                <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2">

                    @foreach ($pengajuanIuran->details as $detail)

                        <div class="rounded-lg border border-gray-200 p-4">

                            <p class="font-semibold text-gray-900">
                                {{ $detail->household->household_number ?? '-' }}
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                {{ $detail->household->head_name ?? '-' }}
                            </p>

                        </div>

                    @endforeach

                </div>

            </div>


            {{-- Bukti --}}
            @if ($pengajuanIuran->bukti)

                <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Bukti Pembayaran
                    </h2>

                    <a
                        href="{{ asset('storage/' . $pengajuanIuran->bukti) }}"
                        target="_blank"
                        class="mt-4 inline-flex rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700"
                    >
                        Lihat Bukti
                    </a>

                </div>

            @endif


            {{-- Catatan --}}
            @if ($pengajuanIuran->catatan)

                <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Catatan
                    </h2>

                    <p class="mt-2 whitespace-pre-line text-sm text-gray-700">
                        {{ $pengajuanIuran->catatan }}
                    </p>

                </div>

            @endif


            {{-- Verifikasi --}}
            @if ($pengajuanIuran->diverifikasi_oleh)

                <div class="mb-6 rounded-xl bg-gray-50 p-5 ring-1 ring-gray-200">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Informasi Verifikasi
                    </h2>

                    <p class="mt-2 text-sm text-gray-600">
                        Diverifikasi oleh:
                        <span class="font-semibold">
                            {{ $pengajuanIuran->verifier->name ?? '-' }}
                        </span>
                    </p>

                    @if ($pengajuanIuran->diverifikasi_pada)

                        <p class="mt-1 text-sm text-gray-600">
                            Waktu:
                            {{ $pengajuanIuran->diverifikasi_pada->format('d-m-Y H:i') }}
                        </p>

                    @endif

                </div>

            @endif


            {{-- Tombol kembali --}}
            <div>

                <a
                    href="{{ route('pengajuan-iuran.index') }}"
                    class="inline-flex rounded-lg bg-gray-100 px-5 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-200"
                >
                    ← Kembali
                </a>

            </div>

        </div>

    </div>

</x-app-layout>