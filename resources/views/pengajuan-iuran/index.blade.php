<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                Iuran Blok Saya
            </h2>

            <p class="text-sm text-gray-500">
                Daftar pengajuan iuran warga di blok Anda.
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="mb-6 rounded-lg bg-green-100 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Notifikasi error --}}
            @if (session('error'))
                <div class="mb-6 rounded-lg bg-red-100 p-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Error validasi --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-100 p-4 text-sm text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Header halaman --}}
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h1 class="text-2xl font-bold text-gray-900">
                        Daftar Pengajuan Iuran
                    </h1>

                    <p class="mt-1 text-sm text-gray-500">
                        Pantau pengajuan iuran yang telah Anda kirim.
                    </p>
                </div>

                <a href="{{ route('pengajuan-iuran.create') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                    + Buat Pengajuan Iuran
                </a>

            </div>

            {{-- Tabel --}}
            <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-200">

                @if ($pengajuan->count())

                    {{-- Desktop --}}
                    <div class="hidden overflow-x-auto md:block">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">
                                <tr>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        No
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Periode
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Jumlah KK
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Nominal / KK
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Total
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-semibold uppercase text-gray-500">
                                        Status
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-semibold uppercase text-gray-500">
                                        Aksi
                                    </th>

                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">

                                @foreach ($pengajuan as $item)
                                    <tr class="hover:bg-gray-50">

                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $pengajuan->firstItem() + $loop->index }}
                                        </td>

                                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">
                                            {{ $item->bulan }}/{{ $item->tahun }}
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $item->details->count() }} KK
                                        </td>

                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            Rp {{ number_format($item->nominal_per_kk, 0, ',', '.') }}
                                        </td>

                                        <td class="px-6 py-4 text-sm font-bold text-gray-900">
                                            Rp {{ number_format($item->total_iuran, 0, ',', '.') }}
                                        </td>

                                        <td class="px-6 py-4">

                                            @if ($item->status === 'Menunggu Verifikasi')
                                                <span
                                                    class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-800">
                                                    Menunggu Verifikasi
                                                </span>
                                            @elseif ($item->status === 'Disetujui')
                                                <span
                                                    class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-800">
                                                    Disetujui
                                                </span>
                                            @elseif ($item->status === 'Ditolak')
                                                <span
                                                    class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-800">
                                                    Ditolak
                                                </span>
                                            @else
                                                <span
                                                    class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-800">
                                                    {{ $item->status }}
                                                </span>
                                            @endif

                                        </td>

                                        <td class="px-6 py-4 text-right">

                                            <div class="flex items-center justify-end gap-3">

                                                <a href="{{ route('pengajuan-iuran.show', $item) }}"
                                                    class="font-semibold text-indigo-600 hover:text-indigo-800">
                                                    Detail
                                                </a>

                                                @if ($item->status === 'Menunggu Verifikasi')
                                                    <form action="{{ route('pengajuan-iuran.cancel', $item) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Batalkan pengajuan iuran periode {{ $item->bulan }}/{{ $item->tahun }}?');">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="font-semibold text-red-600 hover:text-red-800">
                                                            Batalkan
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>

                        </table>

                    </div>


                    {{-- Mobile --}}
                    <div class="space-y-4 p-4 md:hidden">

                        @foreach ($pengajuan as $item)
                            <div class="rounded-xl border border-gray-200 p-4">

                                <div class="flex items-start justify-between gap-3">

                                    <div>
                                        <h3 class="font-semibold text-gray-900">
                                            Iuran {{ $item->bulan }}/{{ $item->tahun }}
                                        </h3>

                                        <p class="mt-1 text-sm text-gray-500">
                                            {{ $item->details->count() }} KK
                                        </p>
                                    </div>

                                    @if ($item->status === 'Menunggu Verifikasi')
                                        <span
                                            class="rounded-full bg-yellow-100 px-2.5 py-1 text-xs font-semibold text-yellow-800">
                                            Menunggu
                                        </span>
                                    @elseif ($item->status === 'Disetujui')
                                        <span
                                            class="rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-800">
                                            Disetujui
                                        </span>
                                    @elseif ($item->status === 'Ditolak')
                                        <span
                                            class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-800">
                                            Ditolak
                                        </span>
                                    @endif

                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-4">

                                    <div>
                                        <p class="text-xs text-gray-500">
                                            Nominal / KK
                                        </p>

                                        <p class="font-semibold text-gray-900">
                                            Rp {{ number_format($item->nominal_per_kk, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-gray-500">
                                            Total
                                        </p>

                                        <p class="font-semibold text-gray-900">
                                            Rp {{ number_format($item->total_iuran, 0, ',', '.') }}
                                        </p>
                                    </div>

                                </div>

                                <div class="mt-4 flex gap-2">

                                    <a href="{{ route('pengajuan-iuran.show', $item) }}"
                                        class="flex-1 rounded-lg bg-gray-100 px-4 py-3 text-center text-sm font-semibold text-gray-700 hover:bg-gray-200">
                                        Lihat Detail
                                    </a>

                                    @if ($item->status === 'Menunggu Verifikasi')
                                        <form action="{{ route('pengajuan-iuran.cancel', $item) }}" method="POST"
                                            class="flex-1"
                                            onsubmit="return confirm('Batalkan pengajuan iuran periode {{ $item->bulan }}/{{ $item->tahun }}?');">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                class="w-full rounded-lg bg-red-100 px-4 py-3 text-center text-sm font-semibold text-red-700 hover:bg-red-200">
                                                Batalkan
                                            </button>
                                        </form>
                                    @endif

                                </div>

                            </div>
                        @endforeach

                    </div>
                @else
                    <div class="px-6 py-14 text-center">

                        <h3 class="text-lg font-semibold text-gray-900">
                            Belum Ada Pengajuan
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Belum ada pengajuan iuran dari blok Anda.
                        </p>

                        <a href="{{ route('pengajuan-iuran.create') }}"
                            class="mt-5 inline-flex rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white hover:bg-indigo-700">
                            Buat Pengajuan Iuran
                        </a>

                    </div>

                @endif

            </div>

            {{-- Pagination --}}
            @if ($pengajuan->hasPages())
                <div class="mt-6">
                    {{ $pengajuan->links() }}
                </div>
            @endif

        </div>
    </div>

</x-app-layout>
