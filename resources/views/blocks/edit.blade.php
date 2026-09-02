<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Blok</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">
                <form action="{{ route('blocks.update', $block) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1">Nama Blok</label>
                        <input type="text" name="name" value="{{ old('name', $block->name) }}" class="w-full border rounded p-2">
                        @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Kode</label>
                        <input type="text" name="code" value="{{ old('code', $block->code) }}" class="w-full border rounded p-2">
                        @error('code') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label>
                            <input type="checkbox" name="is_active" value="1" {{ $block->is_active ? 'checked' : '' }}> Aktif
                        </label>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Update</button>
                    <a href="{{ route('blocks.index') }}" class="ml-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
