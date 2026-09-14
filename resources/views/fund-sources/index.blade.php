<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Master Sumber Dana</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow rounded-lg">

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="flex justify-between items-center mb-6">
                    <a href="{{ route('fund-sources.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-medium text-sm">
                        + Tambah Sumber Dana
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Sumber Dana</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($fundSources as $source)
                                <tr>
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $source->name }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $source->description ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        @if($source->is_active)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-right space-x-2">
                                        <a href="{{ route('fund-sources.edit', $source) }}" class="text-blue-600 hover:text-blue-900 font-medium text-sm">Edit</a>
                                        <form action="{{ route('fund-sources.destroy', $source) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus sumber dana ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium text-sm">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">Belum ada data sumber dana.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $fundSources->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
