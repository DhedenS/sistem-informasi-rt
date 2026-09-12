<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Administrasi Surat Masuk
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 shadow rounded-lg">

                {{-- Pesan sukses --}}
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Header tabel --}}
                <div class="flex justify-between items-center mb-4">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800">
                            Daftar Surat Masuk
                        </h3>

                        <p class="text-sm text-gray-500">
                            Kelola surat masuk yang diterima oleh RT.
                        </p>
                    </div>

                    <a href="{{ route('surat-masuk.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        + Tambah Surat
                    </a>
                </div>

                {{-- Tabel --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">

                        <thead>
                            <tr class="border-b bg-gray-50">
                                <th class="py-3 px-2">No</th>
                                <th class="py-3 px-2">Nomor Surat</th>
                                <th class="py-3 px-2">Tanggal Surat</th>
                                <th class="py-3 px-2">Tanggal Diterima</th>
                                <th class="py-3 px-2">Pengirim</th>
                                <th class="py-3 px-2">Perihal</th>
                                <th class="py-3 px-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse ($suratMasuks as $surat)

                                <tr class="border-b hover:bg-gray-50">

                                    <td class="py-3 px-2">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="py-3 px-2">
                                        {{ $surat->nomor_surat }}
                                    </td>

                                    <td class="py-3 px-2">
                                        {{ $surat->tanggal_surat->format('d-m-Y') }}
                                    </td>

                                    <td class="py-3 px-2">
                                        {{ $surat->tanggal_diterima->format('d-m-Y') }}
                                    </td>

                                    <td class="py-3 px-2">
                                        {{ $surat->pengirim }}
                                    </td>

                                    <td class="py-3 px-2">
                                        {{ $surat->perihal }}
                                    </td>

                                    <td class="py-3 px-2 whitespace-nowrap">

                                        {{-- Detail --}}
                                        <a href="{{ route('surat-masuk.show', $surat) }}"
                                           class="text-blue-600 hover:underline mr-2">
                                            Detail
                                        </a>

                                        {{-- Edit --}}
                                        <a href="{{ route('surat-masuk.edit', $surat) }}"
                                           class="text-yellow-600 hover:underline mr-2">
                                            Edit
                                        </a>

                                        {{-- Hapus --}}
                                        <form action="{{ route('surat-masuk.destroy', $surat) }}"
                                              method="POST"
                                              class="inline"
                                              onsubmit="return confirm('Yakin ingin menghapus surat ini?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="text-red-600 hover:underline">
                                                Hapus
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7"
                                        class="py-8 text-center text-gray-500">
                                        Belum ada data surat masuk.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>