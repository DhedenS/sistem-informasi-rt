<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data Blok</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('blocks.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                    + Tambah Blok
                </a>

                <form action="{{ route('blocks.index') }}" method="GET" class="mb-4 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau kode blok..."
                        class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded text-sm hover:bg-gray-900">
                        Cari
                    </button>
                    @if (request('search'))
                        <a href="{{ route('blocks.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm hover:bg-gray-300">
                            Reset
                        </a>
                    @endif
                </form>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">Nama</th>
                            <th class="py-2">Kode</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blocks as $block)
                            <tr class="border-b">
                                <td class="py-2">{{ $block->name }}</td>
                                <td class="py-2">{{ $block->code }}</td>
                                <td class="py-2">{{ $block->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                                <td class="py-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('blocks.edit', $block) }}"
                                            class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md text-xs font-semibold hover:bg-blue-200 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('blocks.destroy', $block) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus blok ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-3 py-1.5 bg-red-100 text-red-700 rounded-md text-xs font-semibold hover:bg-red-200 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $blocks->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
