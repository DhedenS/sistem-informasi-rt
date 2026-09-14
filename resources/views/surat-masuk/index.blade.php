<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Administrasi Surat Masuk
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="flex justify-between items-center mb-6">

                    <div>
                        <h3 class="text-xl font-semibold text-gray-800">
                            Daftar Surat Masuk
                        </h3>

                        <p class="text-gray-500 mt-1">
                            Kelola surat masuk yang diterima oleh RT.
                        </p>
                    </div>

                    <a href="{{ route('surat-masuk.create') }}"
                       class="px-5 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        + Tambah Surat
                    </a>

                </div>

                @if (session('success'))
                    <div class="mb-5 p-4 bg-green-100 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="overflow-x-auto">

                    <table class="w-full text-left">

                        <thead>
                            <tr class="border-b bg-gray-50">

                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Nomor Surat</th>
                                <th class="px-4 py-3">Tanggal Surat</th>
                                <th class="px-4 py-3">Tanggal Diterima</th>
                                <th class="px-4 py-3">Pengirim</th>
                                <th class="px-4 py-3">Perihal</th>
                                <th class="px-4 py-3">Aksi</th>

                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($suratMasuks as $surat)

                                <tr class="border-b hover:bg-gray-50">

                                    <td class="px-4 py-4">
                                        {{ $loop->iteration + ($suratMasuks->currentPage() - 1) * $suratMasuks->perPage() }}
                                    </td>

                                    <td class="px-4 py-4 font-medium">
                                        {{ $surat->nomor_surat }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $surat->tanggal_surat->format('d-m-Y') }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $surat->tanggal_diterima->format('d-m-Y') }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $surat->pengirim }}
                                    </td>

                                    <td class="px-4 py-4">
                                        {{ $surat->perihal }}
                                    </td>

                                    <td class="px-4 py-4">

                                        <div class="flex gap-3">

                                            <a href="{{ route('surat-masuk.show', $surat) }}"
                                               class="text-blue-600 hover:underline">
                                                Lihat
                                            </a>

                                            <a href="{{ route('surat-masuk.edit', $surat) }}"
                                               class="text-yellow-600 hover:underline">
                                                Edit
                                            </a>

                                            <form action="{{ route('surat-masuk.destroy', $surat) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Yakin ingin menghapus surat ini?')">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="text-red-600 hover:underline">
                                                    Hapus
                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7"
                                        class="text-center py-10 text-gray-500">
                                        Belum ada data surat masuk.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-5">
                    {{ $suratMasuks->links() }}
                </div>

            </div>

        </div>
    </div>

</x-app-layout>