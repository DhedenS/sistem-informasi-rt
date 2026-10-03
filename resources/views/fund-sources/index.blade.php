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
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
                    <a href="{{ route('fund-sources.create') }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-medium text-sm w-fit">
                        + Tambah Sumber Dana
                    </a>
                </div>
                <form action="{{ route('fund-sources.index') }}" method="GET"
                    class="mb-4 flex flex-col sm:flex-row gap-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari nama atau keterangan sumber dana..."
                        class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm">
                    <button type="submit"
                        class="w-full sm:w-auto px-4 py-2 bg-gray-800 text-white rounded text-sm hover:bg-gray-900">
                        Cari
                    </button>
                    @if (request('search'))
                        <a href="{{ route('fund-sources.index') }}"
                            class="w-full sm:w-auto text-center px-4 py-2 bg-gray-200 text-gray-700 rounded text-sm hover:bg-gray-300">
                            Reset
                        </a>
                    @endif
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 border-b">
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                    Sumber Dana</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Keterangan</th>
                                <th class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                                </th>
                                <th
                                    class="py-3 px-4 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($fundSources as $source)
                                <tr>
                                    <td class="py-3 px-4 font-medium text-gray-900">{{ $source->name }}</td>
                                    <td class="py-3 px-4 text-gray-600">{{ $source->description ?? '-' }}</td>
                                    <td class="py-3 px-4">
                                        @if ($source->is_active)
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aktif</span>
                                        @else
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Nonaktif</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('fund-sources.edit', $source) }}"
                                                class="px-3 py-1.5 bg-blue-100 text-blue-700 rounded-md text-xs font-semibold hover:bg-blue-200 transition">
                                                Edit
                                            </a>
                                            <form action="{{ route('fund-sources.destroy', $source) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus sumber dana ini?')">
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
                                    <td colspan="4" class="py-4 text-center text-gray-500">Belum ada data sumber
                                        dana.</td>
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
