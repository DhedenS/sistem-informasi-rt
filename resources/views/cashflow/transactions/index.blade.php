<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transaksi Cashflow Kas RT</h2>
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

            <!-- Metric Cards: Income, Expense, Realtime Balance -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Total Income Card -->
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-emerald-500">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Total Pemasukan</p>
                    <h3 class="text-xl font-bold text-emerald-600">Rp {{ number_format($totalIncome, 0, ',', '.') }}
                    </h3>
                </div>

                <!-- Total Expense Card -->
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-rose-500">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Total Pengeluaran
                    </p>
                    <h3 class="text-xl font-bold text-rose-600">Rp {{ number_format($totalExpense, 0, ',', '.') }}
                    </h3>
                </div>

                <!-- Saldo Kas Realtime Card -->
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-500 mb-1">Saldo Kas RT</p>
                    <h3 class="text-xl font-bold {{ $balance >= 0 ? 'text-blue-600' : 'text-red-600' }}">Rp
                        {{ number_format($balance, 0, ',', '.') }}</h3>
                </div>
            </div>

            <!-- Action Buttons and Filter Form -->
            <div class="bg-white p-6 shadow rounded-lg space-y-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('cashflow.transactions.create-income') }}"
                            class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white font-medium rounded text-sm flex items-center gap-1 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Tambah Pemasukan
                        </a>
                        <a href="{{ route('cashflow.transactions.create-expense') }}"
                            class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-medium rounded text-sm flex items-center gap-1 shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4">
                                </path>
                            </svg>
                            Tambah Pengeluaran
                        </a>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('cashflow.reports.index') }}"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded text-sm flex items-center gap-1">
                            📊 Laporan Keuangan
                        </a>
                    </div>
                </div>

                <!-- Filter Bar -->
                <form action="{{ route('cashflow.transactions.index') }}" method="GET"
                    class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-3 pt-4 border-t border-gray-100">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tipe Transaksi</label>
                        <select name="type"
                            class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Tipe</option>
                            <option value="masuk" {{ request('type') == 'masuk' ? 'selected' : '' }}>Pemasukan
                            </option>
                            <option value="keluar" {{ request('type') == 'keluar' ? 'selected' : '' }}>Pengeluaran
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Kategori</label>
                        <select name="category_id"
                            class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                    [{{ ucfirst($cat->type) }}] {{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Sumber Dana</label>
                        <select name="fund_source_id"
                            class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Sumber</option>
                            @foreach ($fundSources as $source)
                                <option value="{{ $source->id }}"
                                    {{ request('fund_source_id') == $source->id ? 'selected' : '' }}>
                                    {{ $source->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Mulai</label>
                        <input type="date" name="start_date" value="{{ request('start_date') }}"
                            class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Selesai</label>
                        <div class="flex gap-2">
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full text-sm border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit"
                                class="px-3 py-2 bg-gray-800 text-white rounded text-sm hover:bg-gray-900 font-medium">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Transactions Table -->
                <div class="overflow-x-auto pt-2">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal
                                </th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                                </th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Kategori</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Sumber
                                    Dana</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah
                                    (Rp)</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti
                                </th>
                                <th
                                    class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($transactions as $trx)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4 text-sm text-gray-900 font-medium whitespace-nowrap">
                                        {{ $trx->transaction_date->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 text-sm whitespace-nowrap">
                                        @if ($trx->type === 'masuk')
                                            <span
                                                class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">Pemasukan</span>
                                        @else
                                            <span
                                                class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-rose-100 text-rose-800">Pengeluaran</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-700 font-medium">
                                        {{ $trx->category->name ?? '-' }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $trx->fundSource->name ?? '-' }}
                                    </td>
                                    <td
                                        class="py-3 px-4 text-sm font-bold whitespace-nowrap {{ $trx->type === 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ $trx->type === 'masuk' ? '+' : '-' }} Rp
                                        {{ number_format($trx->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-sm whitespace-nowrap">
                                        @if ($trx->proof_file)
                                            <a href="{{ asset('storage/' . $trx->proof_file) }}" target="_blank"
                                                class="inline-flex items-center text-xs text-blue-600 hover:underline">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                    </path>
                                                </svg>
                                                Lihat
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-sm text-right whitespace-nowrap">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('cashflow.transactions.show', $trx) }}"
                                                class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md text-xs font-semibold hover:bg-blue-200 transition">
                                                Detail
                                            </a>
                                            <form action="{{ route('cashflow.transactions.destroy', $trx) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin hapus transaksi ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1.5 bg-rose-100 text-rose-700 rounded-md text-xs font-semibold hover:bg-rose-200 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="py-6 text-center text-gray-500">Belum ada data
                                        transaksi.</td>
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
