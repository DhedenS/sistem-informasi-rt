<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Detail Transaksi Kas</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg space-y-6">

                <div class="flex justify-between items-center border-b pb-4">
                    <div>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $transaction->type === 'masuk' ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                            {{ $transaction->type === 'masuk' ? 'Pemasukan Kas' : 'Pengeluaran Kas' }}
                        </span>
                        <p class="text-xs text-gray-500 mt-2">ID Transaksi: #{{ $transaction->id }} | Dicatat pada: {{ $transaction->created_at->format('d M Y H:i') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-gray-500">Nominal</p>
                        <p class="text-2xl font-bold {{ $transaction->type === 'masuk' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $transaction->type === 'masuk' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                    <div>
                        <p class="text-gray-500 font-medium">Tanggal Transaksi</p>
                        <p class="text-gray-900 font-semibold mt-1">{{ $transaction->transaction_date->format('d F Y') }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 font-medium">Kategori Transaksi</p>
                        <p class="text-gray-900 font-semibold mt-1">{{ $transaction->category->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 font-medium">Sumber Dana</p>
                        <p class="text-gray-900 font-semibold mt-1">{{ $transaction->fundSource->name ?? '-' }}</p>
                    </div>

                    <div>
                        <p class="text-gray-500 font-medium">Pencatat / Operator</p>
                        <p class="text-gray-900 font-semibold mt-1">{{ $transaction->user->name ?? '-' }}</p>
                    </div>

                    @if($transaction->household)
                        <div class="col-span-2 bg-gray-50 p-4 rounded border">
                            <p class="text-gray-500 font-medium">Data Kepala Keluarga (KK) Terkait</p>
                            <p class="text-gray-900 font-bold mt-1">{{ $transaction->household->head_name }}</p>
                            <p class="text-gray-600 text-xs">Blok: {{ $transaction->household->block->name ?? '-' }} | No. Rumah/KK: {{ $transaction->household->household_number }}</p>
                        </div>
                    @endif

                    <div class="col-span-2">
                        <p class="text-gray-500 font-medium">Keterangan / Catatan</p>
                        <p class="text-gray-900 mt-1 p-3 bg-gray-50 rounded border">{{ $transaction->description ?? 'Tidak ada keterangan.' }}</p>
                    </div>
                </div>

                <!-- Proof File Section -->
                <div class="border-t pt-4">
                    <h4 class="font-semibold text-gray-800 mb-3">Bukti Transaksi</h4>
                    @if ($transaction->proof_file)
                        @php
                            $ext = pathinfo($transaction->proof_file, PATHINFO_EXTENSION);
                        @endphp

                        @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png']))
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $transaction->proof_file) }}" alt="Bukti Transaksi" class="max-h-96 rounded border shadow-sm mx-auto">
                            </div>
                        @endif

                        <div class="flex items-center space-x-3">
                            <a href="{{ asset('storage/' . $transaction->proof_file) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 font-medium flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                Buka / Unduh Bukti Transaksi
                            </a>
                        </div>
                    @else
                        <p class="text-gray-500 italic text-sm">Tidak ada dokumen bukti transaksi yang diunggah.</p>
                    @endif
                </div>

                <div class="flex justify-between items-center border-t pt-4">
                    <a href="{{ route('cashflow.transactions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-medium text-sm">Kembali ke Daftar</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
