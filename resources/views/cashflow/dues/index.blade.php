<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Iuran Kas Per KK (Rumah Tangga)</h2>
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

            <div class="bg-white p-6 shadow rounded-lg space-y-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Daftar Tagihan & Status Iuran Warga</h3>
                        <p class="text-xs text-gray-500">Pencatatan dilakukan per Kepala Keluarga (KK). Pembayaran akan tercatat otomatis pada Dana Masuk Kas RT.</p>
                    </div>
                    <a href="{{ route('cashflow.dues.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded text-sm flex items-center gap-1 shadow-sm w-fit">
                        + Buat Tagihan Iuran
                    </a>
                </div>

                <!-- Filter Bar -->
                <form action="{{ route('cashflow.dues.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 pt-4 border-t border-gray-100">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Pilih KK</label>
                        <select name="household_id" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua KK</option>
                            @foreach ($households as $hh)
                                <option value="{{ $hh->id }}" {{ request('household_id') == $hh->id ? 'selected' : '' }}>[{{ $hh->block->name ?? '-' }}] {{ $hh->head_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Bulan</label>
                        <select name="month" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Bulan</option>
                            @php
                                $months = [1=>'Januari',2=>'Februari',3=>'Maret',4=>'April',5=>'Mei',6=>'Juni',7=>'Juli',8=>'Agustus',9=>'September',10=>'Oktober',11=>'November',12=>'Desember'];
                            @endphp
                            @foreach ($months as $num => $name)
                                <option value="{{ $num }}" {{ request('month') == $num ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tahun</label>
                        <select name="year" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Tahun</option>
                            @for ($y = date('Y'); $y >= 2024; $y--)
                                <option value="{{ $y }}" {{ request('year') == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Status Pembayaran</label>
                        <select name="status" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Status</option>
                            <option value="Belum Lunas" {{ request('status') == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                            <option value="Lunas" {{ request('status') == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                        </select>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="w-full py-2 px-4 bg-gray-800 text-white rounded text-sm hover:bg-gray-900 font-medium">Cari / Filter</button>
                    </div>
                </form>

                <!-- Dues Table -->
                <div class="overflow-x-auto pt-2">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Blok / KK</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Kepala Keluarga</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Periode</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Tagihan (Rp)</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Bayar</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($dues as $due)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-700">
                                        <span class="font-semibold">{{ $due->household->block->name ?? 'Blok -' }}</span> / No. {{ $due->household->household_number ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-sm font-medium text-gray-900">{{ $due->household->head_name ?? '-' }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-700 whitespace-nowrap">{{ $due->month_name }} {{ $due->year }}</td>
                                    <td class="py-3 px-4 text-sm font-bold text-gray-900 whitespace-nowrap">Rp {{ number_format($due->amount, 0, ',', '.') }}</td>
                                    <td class="py-3 px-4 text-sm whitespace-nowrap">
                                        @if ($due->status === 'Lunas')
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Lunas</span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800">Belum Lunas</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600 whitespace-nowrap">
                                        {{ $due->payment_date ? $due->payment_date->format('d/m/Y') : '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-sm text-right whitespace-nowrap">
                                        @if ($due->status === 'Belum Lunas')
                                            <!-- Inline Pay Modal / Trigger -->
                                            <form action="{{ route('cashflow.dues.pay', $due) }}" method="POST" class="inline-flex items-center gap-1" onsubmit="return confirm('Konfirmasi pembayaran iuran ini?')">
                                                @csrf
                                                <input type="hidden" name="payment_date" value="{{ date('Y-m-d') }}">
                                                <button type="submit" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded text-xs font-semibold shadow-sm">
                                                    Bayar Sekarang
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-emerald-600 font-medium">✔ Terbayar</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-center text-gray-500">Belum ada data tagihan iuran.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $dues->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
