<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pencatatan Dana Masuk (Pemasukan)</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <form action="{{ route('cashflow.transactions.store-income') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="transaction_date" class="block text-gray-700 font-medium mb-1">Tanggal Transaksi <span class="text-red-500">*</span></label>
                            <input type="date" name="transaction_date" id="transaction_date" value="{{ old('transaction_date', date('Y-m-d')) }}" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            @error('transaction_date')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="amount" class="block text-gray-700 font-medium mb-1">Jumlah Pemasukan (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" step="0.01" min="1" name="amount" id="amount" value="{{ old('amount') }}" required placeholder="Contoh: 500000" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            @error('amount')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="fund_source_id" class="block text-gray-700 font-medium mb-1">Sumber Dana <span class="text-red-500">*</span></label>
                            <select name="fund_source_id" id="fund_source_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">-- Pilih Sumber Dana --</option>
                                @foreach ($fundSources as $source)
                                    <option value="{{ $source->id }}" {{ old('fund_source_id') == $source->id ? 'selected' : '' }}>{{ $source->name }}</option>
                                @endforeach
                            </select>
                            @error('fund_source_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="transaction_category_id" class="block text-gray-700 font-medium mb-1">Kategori Transaksi <span class="text-red-500">*</span></label>
                            <select name="transaction_category_id" id="transaction_category_id" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="">-- Pilih Kategori Pemasukan --</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('transaction_category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('transaction_category_id')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="household_id" class="block text-gray-700 font-medium mb-1">KK Pembayar (Opsional)</label>
                        <select name="household_id" id="household_id" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">-- Pilih Kepala Keluarga (Jika Ada) --</option>
                            @foreach ($households as $hh)
                                <option value="{{ $hh->id }}" {{ old('household_id') == $hh->id ? 'selected' : '' }}>
                                    [{{ $hh->block->name ?? 'Blok -' }}] No. {{ $hh->household_number }} - {{ $hh->head_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('household_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-gray-700 font-medium mb-1">Keterangan / Catatan</label>
                        <textarea name="description" id="description" rows="3" placeholder="Deskripsi pemasukan..." class="w-full border-gray-300 rounded-md shadow-sm focus:ring-emerald-500 focus:border-emerald-500">{{ old('description') }}</textarea>
                        @error('description')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="proof_file" class="block text-gray-700 font-medium mb-1">Upload Bukti Transaksi (Opsional)</label>
                        <input type="file" name="proof_file" id="proof_file" accept=".jpg,.jpeg,.png,.pdf" class="w-full border-gray-300 rounded-md shadow-sm text-sm">
                        <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, PDF (Maks. 2MB)</p>
                        @error('proof_file')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('cashflow.transactions.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 font-medium text-sm">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700 font-medium text-sm">Simpan Pemasukan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
