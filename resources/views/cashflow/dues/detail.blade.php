<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Iuran Per KK</h2>
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

            <a href="{{ route('cashflow.dues.index', ['month' => $month, 'year' => $year]) }}"
                class="text-sm text-blue-600 hover:underline inline-flex items-center gap-1">
                &larr; Kembali ke Ringkasan Blok
            </a>

            <div class="bg-white p-6 shadow rounded-lg space-y-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div>
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
                        <h3 class="text-lg font-bold text-gray-800">Daftar Iuran Per KK</h3>
                        <p class="text-xs text-gray-500">
                            Periode: <span class="font-semibold text-gray-700">{{ $months[(int) $month] ?? $month }}
                                {{ $year }}</span>
                        </p>
                    </div>
                    <a href="{{ route('verifikasi-iuran.export-excel', ['block_id' => request('block_id'), 'month' => $month, 'year' => $year]) }}"
                        class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded text-sm flex items-center gap-1 shadow-sm w-fit">
                        📥 Export Excel
                    </a>
                </div>

                <!-- Filter Bar -->
                <form action="{{ route('cashflow.dues.index') }}" method="GET"
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 pt-4 border-t border-gray-100">
                    <input type="hidden" name="block_id" value="{{ request('block_id') }}">
                    <input type="hidden" name="month" value="{{ $month }}">
                    <input type="hidden" name="year" value="{{ $year }}">

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Pilih KK</label>
                        <select name="household_id" id="household-select"
                            class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua KK</option>
                            @foreach ($households as $hh)
                                <option value="{{ $hh->id }}"
                                    {{ request('household_id') == $hh->id ? 'selected' : '' }}>
                                    [{{ $hh->block->name ?? '-' }}] {{ $hh->head_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Status Pembayaran</label>
                        <select name="status"
                            class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="Belum Lunas" {{ request('status') == 'Belum Lunas' ? 'selected' : '' }}>
                                Belum Lunas</option>
                            <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit"
                            class="w-full py-2 px-4 bg-gray-800 text-white rounded text-sm hover:bg-gray-900 font-medium">
                            Cari / Filter
                        </button>
                    </div>
                </form>

                <!-- Dues Table -->
                <div class="hidden md:block overflow-x-auto pt-2">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase">Nama KK</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase">Blok</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase">Periode</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase">Jumlah</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase">Tgl Bayar</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($dues as $due)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm font-bold text-gray-900">
                                        {{ $due->household->head_name ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700">
                                        {{ $due->household->block->name ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700">
                                        {{ $months[(int) $due->month] ?? $due->month }} {{ $due->year }}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700">
                                        Rp {{ number_format($due->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-sm">
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $due->status === 'Lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                            {{ $due->status }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700">
                                        {{ $due->payment_date ? \Carbon\Carbon::parse($due->payment_date)->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-right">
                                        @if ($due->status !== 'Lunas')
                                            <form action="{{ route('cashflow.dues.pay', $due->id) }}" method="POST"
                                                class="inline"
                                                onsubmit="return confirm('Tandai iuran {{ $due->household->head_name }} sebagai Lunas?');">
                                                @csrf
                                                <input type="hidden" name="payment_date"
                                                    value="{{ now()->toDateString() }}">
                                                <button type="submit"
                                                    class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded text-xs font-semibold shadow-sm">
                                                    Tandai Lunas
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400">Sudah Lunas</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-center text-gray-500">
                                        Tidak ada data iuran untuk periode/filter ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- Dues Accordion (HP) -->
                <div class="md:hidden space-y-2 pt-2">
                    @forelse ($dues as $due)
                        <details class="group rounded-xl border border-gray-200 overflow-hidden bg-white">

                            {{-- Ringkas: selalu terlihat --}}
                            <summary
                                class="flex items-center justify-between gap-2 px-3 py-2.5 cursor-pointer select-none hover:bg-gray-50 list-none [&::-webkit-details-marker]:hidden">

                                <div class="flex items-center gap-2 min-w-0">
                                    <svg class="w-4 h-4 shrink-0 text-gray-400 transition-transform group-open:rotate-90"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5l7 7-7 7" />
                                    </svg>
                                    <span class="font-semibold text-sm text-gray-900 truncate">
                                        {{ $due->household->head_name ?? '-' }}
                                    </span>
                                </div>

                                <span
                                    class="shrink-0 px-2 py-0.5 rounded-full text-xs font-medium {{ $due->status === 'Lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $due->status }}
                                </span>
                            </summary>

                            {{-- Detail: muncul saat diklik --}}
                            <div class="px-3 py-3 space-y-2 border-t border-gray-100 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Blok</span>
                                    <span class="text-gray-900">{{ $due->household->block->name ?? '-' }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Periode</span>
                                    <span class="text-gray-900">{{ $months[(int) $due->month] ?? $due->month }}
                                        {{ $due->year }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Jumlah</span>
                                    <span class="font-semibold text-gray-900">Rp
                                        {{ number_format($due->amount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-500">Tgl Bayar</span>
                                    <span class="text-gray-900">
                                        {{ $due->payment_date ? \Carbon\Carbon::parse($due->payment_date)->format('d/m/Y') : '-' }}
                                    </span>
                                </div>

                                <div class="pt-2">
                                    @if ($due->status !== 'Lunas')
                                        <form action="{{ route('cashflow.dues.pay', $due->id) }}" method="POST"
                                            onsubmit="return confirm('Tandai iuran {{ $due->household->head_name }} sebagai Lunas?');">
                                            @csrf
                                            <input type="hidden" name="payment_date"
                                                value="{{ now()->toDateString() }}">
                                            <button type="submit"
                                                class="w-full py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold shadow-sm">
                                                Tandai Lunas
                                            </button>
                                        </form>
                                    @else
                                        <p class="text-center text-xs text-gray-400">Sudah Lunas</p>
                                    @endif
                                </div>
                            </div>

                        </details>
                    @empty
                        <div class="py-6 text-center text-gray-500 text-sm">
                            Tidak ada data iuran untuk periode/filter ini.
                        </div>
                    @endforelse
                </div>
                <div class="mt-4">
                    {{ $dues->links() }}
                </div>
            </div>
        </div>
    </div>
    <style>
        .choices__inner {
            min-height: 44px;
            font-size: 14px;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                new Choices('#household-select', {
                    searchEnabled: true,
                    searchPlaceholderValue: 'Cari nama KK...',
                    itemSelectText: '',
                    shouldSort: false,
                    searchFields: ['label'],
                });
            });
        </script>
    @endpush
</x-app-layout>
