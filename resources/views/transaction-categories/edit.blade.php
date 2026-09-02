<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Kategori Transaksi</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <form action="{{ route('transaction-categories.update', $transactionCategory) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1">Nama Kategori</label>
                        <input type="text" name="name" value="{{ old('name', $transactionCategory->name) }}" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Tipe</label>
                        <select name="type" class="w-full border rounded p-2">
                            <option value="masuk" {{ $transactionCategory->type == 'masuk' ? 'selected' : '' }}>Masuk</option>
                            <option value="keluar" {{ $transactionCategory->type == 'keluar' ? 'selected' : '' }}>Keluar</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="is_active" value="1" {{ $transactionCategory->is_active ? 'checked' : '' }}> Aktif
                        </label>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                    <a href="{{ route('transaction-categories.index') }}" class="ml-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
