<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit KK</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <form action="{{ route('households.update', $household) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1">Blok</label>
                        <select name="block_id" class="w-full border rounded p-2">
                            @foreach ($blocks as $block)
                                <option value="{{ $block->id }}" {{ $household->block_id == $block->id ? 'selected' : '' }}>
                                    {{ $block->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Nomor KK</label>
                        <input type="text" name="household_number" value="{{ old('household_number', $household->household_number) }}" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Nama Kepala Keluarga</label>
                        <input type="text" name="head_name" value="{{ old('head_name', $household->head_name) }}" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Alamat</label>
                        <textarea name="address" class="w-full border rounded p-2">{{ old('address', $household->address) }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">No. HP</label>
                        <input type="text" name="phone" value="{{ old('phone', $household->phone) }}" class="w-full border rounded p-2">
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="is_active" value="1" {{ $household->is_active ? 'checked' : '' }}> Aktif
                        </label>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                    <a href="{{ route('households.index') }}" class="ml-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
