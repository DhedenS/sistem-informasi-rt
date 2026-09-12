<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-xl font-semibold text-slate-800">
                    Iuran Saya
                </h2>
                <p class="mt-1 text-sm text-slate-500">
                    Informasi pembayaran iuran KK Anda
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Pesan --}}
            @if (session('success'))
                <div class="mb-5 rounded-lg bg-green-50 p-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-lg bg-red-50 p-4 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Informasi KK --}}
            @if ($household)
                <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                    <h3 class="text-base font-semibold text-slate-800">
                        Data KK
                    </h3>

                    <div class="mt-4 grid gap-4 sm:grid-cols-2">
                        <div>
                            <p class="text-xs text-slate-500">Nomor KK</p>
                            <p class="mt-1 font-medium text-slate-800">
                                {{ $household->household_number }}
                            </p>
                        </div>

                        <div>
                            <p class="text-xs text-slate-500">Kepala Keluarga</p>
                            <p class="mt-1 font-medium text-slate-800">
                                {{ $household->head_name }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Daftar Iuran --}}
            <div class="rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
                <div class="border-b border-slate-200 px-5 py-4">
                    <h3 class="font-semibold text-slate-800">
                        Riwayat Iuran
                    </h3>
                    <p class="mt-1 text-sm text-slate-500">
                        Daftar status pembayaran iuran Anda.
                    </p>
                </div>

                @if ($dues->count())
                    {{-- Desktop --}}
                    <div class="hidden overflow-x-auto md:block">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                        Periode
                                    </th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                        Nominal
                                    </th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                        Dibayar
                                    </th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                        Status
                                    </th>
                                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase text-slate-500">
                                        Tanggal Bayar
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-slate-100 bg-white">
                                @foreach ($dues as $due)
                                    <tr>
                                        <td class="px-5 py-4 text-sm font-medium text-slate-800">
                                            {{ $due->month_name }} {{ $due->year }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-slate-600">
                                            Rp {{ number_format($due->amount, 0, ',', '.') }}
                                        </td>

                                        <td class="px-5 py-4 text-sm text-slate-600">
                                            Rp {{ number_format($due->paid_amount, 0, ',', '.') }}
                                        </td>

                                        <td class="px-5 py-4">
                                            @if ($due->status === 'Lunas')
                                                <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                                    Lunas
                                                </span>
                                            @else
                                                <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                                    Belum Lunas
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-5 py-4 text-sm text-slate-600">
                                            {{ $due->payment_date?->format('d/m/Y') ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile --}}
                    <div class="space-y-4 p-4 md:hidden">
                        @foreach ($dues as $due)
                            <div class="rounded-lg border border-slate-200 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-slate-800">
                                            {{ $due->month_name }} {{ $due->year }}
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Iuran bulanan
                                        </p>
                                    </div>

                                    @if ($due->status === 'Lunas')
                                        <span class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Lunas
                                        </span>
                                    @else
                                        <span class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                            Belum Lunas
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-4 grid grid-cols-2 gap-4">
                                    <div>
                                        <p class="text-xs text-slate-500">Nominal</p>
                                        <p class="mt-1 text-sm font-medium text-slate-800">
                                            Rp {{ number_format($due->amount, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-500">Dibayar</p>
                                        <p class="mt-1 text-sm font-medium text-slate-800">
                                            Rp {{ number_format($due->paid_amount, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <div>
                                        <p class="text-xs text-slate-500">Tanggal Bayar</p>
                                        <p class="mt-1 text-sm text-slate-800">
                                            {{ $due->payment_date?->format('d/m/Y') ?? '-' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    @if ($dues->hasPages())
                        <div class="border-t border-slate-200 px-5 py-4">
                            {{ $dues->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-5 py-12 text-center">
                        <p class="font-medium text-slate-700">
                            Belum ada data iuran
                        </p>

                        <p class="mt-1 text-sm text-slate-500">
                            Data pembayaran iuran Anda akan tampil di sini.
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>