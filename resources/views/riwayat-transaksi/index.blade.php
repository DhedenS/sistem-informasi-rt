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


                    {{-- TABEL DESKTOP --}}
                    <div class="overflow-x-auto">

                        <table class="min-w-full divide-y divide-gray-200">

                            <thead class="bg-gray-50">
                                <tr>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Kategori
                                    </th>

                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Keterangan
                                    </th>

                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
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

                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Pemasukan
                                                </span>

                                            @else

                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
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
                                            Belum ada transaksi tercatat.
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