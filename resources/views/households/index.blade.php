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

                <a href="{{ route('households.create') }}" class="inline-block mb-4 px-4 py-2 bg-blue-600 text-white rounded">
                    + Tambah KK
                </a>

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
                        @foreach ($households as $household)
                            <tr class="border-b">
                                <td class="py-2">{{ $household->household_number }}</td>
                                <td class="py-2">{{ $household->head_name }}</td>
                                <td class="py-2">{{ $household->block->name ?? '-' }}</td>
                                <td class="py-2">{{ $household->is_active ? 'Aktif' : 'Nonaktif' }}</td>
                                <td class="py-2">
                                    <a href="{{ route('households.edit', $household) }}" class="text-blue-600 mr-2">Edit</a>
                                    <form action="{{ route('households.destroy', $household) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="mt-4">
                    {{ $households->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
