<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Laporan Keuangan Cashflow RT</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow border-t-4 border-emerald-500">
                    <p class="text-xs font-semibold uppercase text-gray-500">Total Pemasukan (Filter)</p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-t-4 border-rose-500">
                    <p class="text-xs font-semibold uppercase text-gray-500">Total Pengeluaran (Filter)</p>
                    <h3 class="text-2xl font-bold text-rose-600 mt-1">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                </div>

                <div class="bg-white p-6 rounded-lg shadow border-t-4 border-blue-500">
                    <p class="text-xs font-semibold uppercase text-gray-500">Saldo (Filter)</p>
                    <h3 class="text-2xl font-bold {{ $balance >= 0 ? 'text-blue-600' : 'text-red-600' }} mt-1">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
                </div>
            </div>

            <!-- Filter Panel and Export Actions -->
            <div class="bg-white p-6 shadow rounded-lg space-y-6">
                <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 pb-4 border-b">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Filter Laporan Keuangan</h3>
                        <p class="text-xs text-gray-500">Saring laporan transaksi berdasarkan periode tanggal, tipe, sumber dana, kategori, dan blok.</p>
                    </div>

                    <!-- Export Buttons -->
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('cashflow.reports.pdf', request()->query()) }}" target="_blank" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-medium rounded text-sm flex items-center gap-1 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Export PDF
                        </a>
                        <a href="{{ route('cashflow.reports.excel', request()->query()) }}" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded text-sm flex items-center gap-1 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Export Excel
                        </a>
                    </div>
                </div>

                <form action="{{ route('cashflow.reports.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ request('end_date') }}" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tipe Transaksi</label>
                        <select name="type" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Tipe</option>
                            <option value="masuk" {{ request('type') == 'masuk' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="keluar" {{ request('type') == 'keluar' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Sumber Dana</label>
                        <select name="fund_source_id" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Sumber</option>
                            @foreach ($fundSources as $source)
                                <option value="{{ $source->id }}" {{ request('fund_source_id') == $source->id ? 'selected' : '' }}>{{ $source->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Kategori</label>
                        <select name="category_id" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>[{{ ucfirst($cat->type) }}] {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Blok RT</label>
                        <div class="flex gap-2">
                            <select name="block_id" class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Semua Blok</option>
                                @foreach ($blocks as $block)
                                    <option value="{{ $block->id }}" {{ request('block_id') == $block->id ? 'selected' : '' }}>{{ $block->name }}</option>
                                @endforeach
                            </select>
                            <button type="submit" class="px-3 py-2 bg-gray-800 text-white rounded text-sm hover:bg-gray-900 font-medium">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Transactions Data Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Sumber Dana</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Blok / KK</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah (Rp)</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($transactions as $index => $trx)
                                <tr class="hover:bg-gray-50 text-sm">
                                    <td class="py-3 px-4 text-gray-500">{{ $transactions->firstItem() + $index }}</td>
                                    <td class="py-3 px-4 font-medium whitespace-nowrap">{{ $trx->transaction_date->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        @if ($trx->type === 'masuk')
                                            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-emerald-100 text-emerald-800">Masuk</span>
                                        @else
                                            <span class="px-2 py-0.5 rounded text-xs font-semibold bg-rose-100 text-rose-800">Keluar</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 font-medium text-gray-800">{{ $trx->category->name ?? '-' }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $trx->fundSource->name ?? '-' }}</td>
                                    <td class="py-3 px-4 text-gray-600">
                                        @if($trx->household)
                                            {{ $trx->household->block->name ?? '' }} - {{ $trx->household->head_name }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 font-bold whitespace-nowrap {{ $trx->type === 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-600">{{ $trx->description ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-6 text-center text-gray-500">Tidak ada data transaksi sesuai filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
