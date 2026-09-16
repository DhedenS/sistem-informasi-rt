<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Riwayat Transaksi
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Riwayat seluruh pemasukan dan pengeluaran kas RT
            </p>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    {{-- JUDUL --}}
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-800">
                            Daftar Transaksi
                        </h3>

                        <p class="text-sm text-gray-500 mt-1">
                            Informasi transaksi kas yang tercatat dalam sistem
                        </p>
                    </div>

                    {{-- FILTER --}}
                    <form method="GET" action="{{ route('riwayat-transaksi.index') }}"
                          class="mb-6">

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

                            {{-- PENCARIAN --}}
                            <div>
                                <label for="search"
                                       class="block text-sm font-medium text-gray-700 mb-1">
                                    Cari Transaksi
                                </label>

                                <input
                                    type="text"
                                    name="search"
                                    id="search"
                                    value="{{ $search ?? '' }}"
                                    placeholder="Cari keterangan..."
                                    class="w-full rounded-md border-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            {{-- JENIS TRANSAKSI --}}
                            <div>
                                <label for="type"
                                       class="block text-sm font-medium text-gray-700 mb-1">
                                    Jenis Transaksi
                                </label>

                                <select
                                    name="type"
                                    id="type"
                                    class="w-full rounded-md border-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500"
                                >
                                    <option value="">Semua Jenis</option>

                                    <option value="masuk"
                                        {{ ($type ?? '') === 'masuk' ? 'selected' : '' }}>
                                        Pemasukan
                                    </option>

                                    <option value="keluar"
                                        {{ ($type ?? '') === 'keluar' ? 'selected' : '' }}>
                                        Pengeluaran
                                    </option>
                                </select>
                            </div>

                            {{-- TANGGAL MULAI --}}
                            <div>
                                <label for="date_from"
                                       class="block text-sm font-medium text-gray-700 mb-1">
                                    Dari Tanggal
                                </label>

                                <input
                                    type="date"
                                    name="date_from"
                                    id="date_from"
                                    value="{{ $date_from ?? '' }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                            {{-- TANGGAL SAMPAI --}}
                            <div>
                                <label for="date_to"
                                       class="block text-sm font-medium text-gray-700 mb-1">
                                    Sampai Tanggal
                                </label>

                                <input
                                    type="date"
                                    name="date_to"
                                    id="date_to"
                                    value="{{ $date_to ?? '' }}"
                                    class="w-full rounded-md border-gray-300 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500"
                                >
                            </div>

                        </div>

                        {{-- TOMBOL --}}
                        <div class="flex flex-wrap gap-2 mt-4">

                            <button
                                type="submit"
                                class="inline-flex items-center px-4 py-2
                                       bg-indigo-600 border border-transparent
                                       rounded-md font-semibold text-xs text-white
                                       uppercase tracking-widest
                                       hover:bg-indigo-700
                                       focus:bg-indigo-700
                                       active:bg-indigo-900
                                       focus:outline-none focus:ring-2
                                       focus:ring-indigo-500 focus:ring-offset-2
                                       transition"
                            >
                                🔎 Cari
                            </button>

                            <a
                                href="{{ route('riwayat-transaksi.index') }}"
                                class="inline-flex items-center px-4 py-2
                                       bg-gray-200 border border-transparent
                                       rounded-md font-semibold text-xs text-gray-700
                                       uppercase tracking-widest
                                       hover:bg-gray-300
                                       transition"
                            >
                                Reset
                            </a>

                        </div>

                    </form>

                    {{-- TABEL DESKTOP --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">
                                <tr>

                                    <th class="px-6 py-3 text-left text-xs font-medium
                                               text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium
                                               text-gray-500 uppercase tracking-wider">
                                        Jenis
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium
                                               text-gray-500 uppercase tracking-wider">
                                        Kategori
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium
                                               text-gray-500 uppercase tracking-wider">
                                        Keterangan
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-medium
                                               text-gray-500 uppercase tracking-wider">
                                        Nominal
                                    </th>

                                </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200">

                                @forelse ($transaksi as $trx)

                                    <tr class="hover:bg-gray-50">

                                        {{-- TANGGAL --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $trx->transaction_date?->format('d/m/Y') ?? '-' }}
                                        </td>

                                        {{-- JENIS --}}
                                        <td class="px-6 py-4 whitespace-nowrap">

                                            @if ($trx->type === 'masuk')

                                                <span class="inline-flex items-center px-2.5 py-0.5
                                                             rounded-full text-xs font-medium
                                                             bg-green-100 text-green-800">
                                                    Pemasukan
                                                </span>

                                            @else

                                                <span class="inline-flex items-center px-2.5 py-0.5
                                                             rounded-full text-xs font-medium
                                                             bg-red-100 text-red-800">
                                                    Pengeluaran
                                                </span>

                                            @endif

                                        </td>

                                        {{-- KATEGORI --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $trx->category->name ?? '-' }}
                                        </td>

                                        {{-- KETERANGAN --}}
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            {{ $trx->description ?? '-' }}
                                        </td>

                                        {{-- NOMINAL --}}
                                        <td class="px-6 py-4 whitespace-nowrap text-right">

                                            @if ($trx->type === 'masuk')

                                                <span class="text-sm font-semibold text-green-600">
                                                    + Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                                </span>

                                            @else

                                                <span class="text-sm font-semibold text-red-600">
                                                    - Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td
                                            colspan="5"
                                            class="px-6 py-8 text-center text-sm text-gray-500"
                                        >
                                            Tidak ada transaksi yang sesuai dengan filter.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{-- PAGINATION --}}
                    @if ($transaksi->hasPages())

                        <div class="mt-6">
                            {{ $transaksi->links() }}
                        </div>

                    @endif

                </div>
            </div>

        </div>
    </div>

</x-app-layout> 