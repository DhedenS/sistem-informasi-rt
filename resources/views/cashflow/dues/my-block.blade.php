<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Rekap Iuran Blok Saya</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 shadow rounded-lg space-y-4">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-500">Periode: {{ $month }}/{{ $year }}</p>
                        <p class="text-sm text-gray-700">Lunas: <strong>{{ $totalLunas }}</strong> /
                            {{ $totalKK }} KK</p>
                    </div>
                    <a href="{{ route('dues.my-block.export', request()->query()) }}"
                        class="px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm rounded">
                        📥 Export Excel
                    </a>
                </div>

                {{-- FILTER --}}
                <form action="{{ route('dues.my-block') }}" method="GET"
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 pt-4 border-t border-gray-100">

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Cari KK</label>
                        <div class="flex gap-1">
                            <input type="text" list="household-list" name="household_search"
                                value="{{ request('household_search') }}" placeholder="Semua KK (ketik untuk cari)"
                                class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            @if (request('household_search'))
                                <a href="{{ route('dues.my-block', array_merge(request()->except('household_search'), ['page' => 1])) }}"
                                    class="flex items-center px-2 text-xs text-gray-500 hover:text-red-600 border border-gray-300 rounded-md"
                                    title="Reset pencarian">
                                    ✕
                                </a>
                            @endif
                        </div>
                        <datalist id="household-list">
                            @foreach ($households as $hh)
                                <option value="{{ $hh->household_number }} - {{ $hh->head_name }}">
                            @endforeach
                        </datalist>
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

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Status Pembayaran</label>
                        <select name="status"
                            class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="Lunas" {{ request('status') === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="Belum Lunas" {{ request('status') === 'Belum Lunas' ? 'selected' : '' }}>
                                Belum Lunas</option>
                        </select>
                    </div>

                    <div class="sm:col-span-2 md:col-span-4">
                        <button type="submit"
                            class="w-full sm:w-auto py-2 px-4 bg-gray-800 text-white rounded text-sm hover:bg-gray-900 font-medium">
                            Cari / Filter
                        </button>
                    </div>
                </form>

                {{-- MOBILE: Card compact --}}
                <div class="sm:hidden space-y-2">
                    @forelse ($dues as $due)
                        <div
                            class="flex items-center justify-between gap-2 p-2.5 border border-gray-100 rounded-lg text-sm">
                            <div class="min-w-0">
                                <p class="font-semibold text-gray-900 truncate">{{ $due->household->household_number }}
                                    — {{ $due->household->head_name }}</p>
                                <p class="text-xs text-gray-500">Rp {{ number_format($due->amount, 0, ',', '.') }} ·
                                    {{ $due->payment_date?->format('d/m/y') ?? '-' }}</p>
                            </div>
                            <span
                                class="shrink-0 px-2 py-0.5 rounded-full text-xs font-medium {{ $due->status === 'Lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                {{ $due->status === 'Lunas' ? 'Lunas' : 'Belum' }}
                            </span>
                        </div>
                    @empty
                        <div class="py-6 text-center text-gray-500 text-sm">Belum ada data iuran periode ini.</div>
                    @endforelse
                </div>
                {{-- DESKTOP: Table --}}
                <div class="hidden sm:block overflow-x-auto">
                    <table class="w-full text-left border-collapse text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="py-2">No. KK</th>
                                <th class="py-2">Kepala Keluarga</th>
                                <th class="py-2">Nominal</th>
                                <th class="py-2">Status</th>
                                <th class="py-2">Tgl Bayar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dues as $due)
                                <tr class="border-b">
                                    <td class="py-2">{{ $due->household->household_number }}</td>
                                    <td class="py-2">{{ $due->household->head_name }}</td>
                                    <td class="py-2">Rp {{ number_format($due->amount, 0, ',', '.') }}</td>
                                    <td class="py-2">
                                        <span
                                            class="px-2 py-0.5 rounded-full text-xs {{ $due->status === 'Lunas' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $due->status }}
                                        </span>
                                    </td>
                                    <td class="py-2">{{ $due->payment_date?->format('d/m/Y') ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500">Belum ada data iuran
                                        periode ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div>{{ $dues->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
