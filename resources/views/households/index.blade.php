<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Data KK</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <a href="{{ route('households.create') }}"
                    class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                    + Tambah KK
                </a>

                <form action="{{ route('households.index') }}" method="GET" class="mb-4 flex gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari No. KK, nama kepala keluarga, atau blok..."
                        class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded text-sm hover:bg-gray-900">
                        Cari
                    </button>
                    @if (request('search'))
                        <a href="{{ route('households.index') }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm hover:bg-gray-300">
                            Reset
                        </a>
                    @endif
                </form>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b">
                            <th class="py-2">No. KK</th>
                            <th class="py-2">Kepala Keluarga</th>
                            <th class="py-2">Blok</th>
                            <th class="py-2">Status</th>
                            <th class="py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($households as $household)
                            <tr class="border-b">
                                <td class="py-2">{{ $household->household_number }}</td>
                                <td class="py-2">{{ $household->head_name }}</td>
                                <td class="py-2">{{ $household->block->name ?? '-' }}</td>
                                <td class="py-2">
                                    @if ($household->is_active)
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Aktif
                                        </span>
                                    @else
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Nonaktif
                                        </span>
                                    @endif
                                </td>
                                <td class="py-2">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('households.edit', $household) }}"
                                            class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md text-xs font-semibold hover:bg-blue-200 transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('households.destroy', $household) }}" method="POST"
                                            onsubmit="return confirm('Yakin hapus?')">
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
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-500">
                                    Tidak ada data KK ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $households->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
