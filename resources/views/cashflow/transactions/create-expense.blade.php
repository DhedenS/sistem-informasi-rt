<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pencatatan Dana Keluar (Pengeluaran)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <form action="{{ route('cashflow.transactions.store-expense') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="transaction_date" class="block text-gray-700 font-medium mb-1">Tanggal Transaksi <span class="text-red-500">*</span></label>
                            <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            @error('transaction_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="amount" class="block text-gray-700 font-medium mb-1">Jumlah Pengeluaran (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" min="1" name="amount" id="amount" value="{{ old('amount') }}" required placeholder="Contoh: 250000" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            @error('amount')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="transaction_category_id" class="block text-gray-700 font-medium mb-1">Kategori Pengeluaran <span class="text-red-500">*</span></label>
                        <select name="transaction_category_id" id="transaction_category_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500">
                            <option value="">-- Pilih Kategori Pengeluaran --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('transaction_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('transaction_category_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-medium mb-1">Keterangan / Keperluan</label>
                        <textarea name="description" id="description" rows="3" placeholder="Rincian penggunaan dana pengeluaran..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-rose-500 focus:border-rose-500">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="proof_file" class="block text-gray-700 font-medium mb-1">Upload Bukti Transaksi / Nota / Kwitansi <span class="text-red-500">*</span></label>
                        <input type="file" name="proof_file" id="proof_file" accept=".jpg,.jpeg,.png,.pdf" required class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                        <p class="text-xs text-gray-500 mt-1">Bukti transaksi wajib diupload untuk pengeluaran. Format: JPG, PNG, PDF (Maks. 2MB)</p>
                        @error('proof_file')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('cashflow.transactions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-medium text-sm">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded hover:bg-rose-700 font-medium text-sm">Simpan Pengeluaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
