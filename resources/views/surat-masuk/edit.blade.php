<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Surat Masuk
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <h3 class="text-xl font-semibold text-gray-800 mb-6">
                    Form Surat Masuk
                </h3>

                @if ($errors->any())
                    <div class="mb-5 p-4 bg-red-100 text-red-700 rounded-lg">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat-masuk.store') }}"
                      method="POST"
                      enctype="multipart/form-data">

                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Nomor Surat
                            </label>

                            <input type="text"
                                   name="nomor_surat"
                                   value="{{ old('nomor_surat') }}"
                                   placeholder="Contoh: 001/RT/IX/2026"
                                   class="w-full border-gray-300 rounded-lg"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Pengirim
                            </label>

                            <input type="text"
                                   name="pengirim"
                                   value="{{ old('pengirim') }}"
                                   placeholder="Nama instansi/pengirim"
                                   class="w-full border-gray-300 rounded-lg"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Surat
                            </label>

                            <input type="date"
                                   name="tanggal_surat"
                                   value="{{ old('tanggal_surat') }}"
                                   class="w-full border-gray-300 rounded-lg"
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Diterima
                            </label>

                            <input type="date"
                                   name="tanggal_diterima"
                                   value="{{ old('tanggal_diterima') }}"
                                   class="w-full border-gray-300 rounded-lg"
                                   required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Perihal
                            </label>

                            <input type="text"
                                   name="perihal"
                                   value="{{ old('perihal') }}"
                                   placeholder="Perihal surat"
                                   class="w-full border-gray-300 rounded-lg"
                                   required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Isi Ringkas
                            </label>

                            <textarea name="isi_ringkas"
                                      rows="4"
                                      placeholder="Ringkasan isi surat..."
                                      class="w-full border-gray-300 rounded-lg">{{ old('isi_ringkas') }}</textarea>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                File Surat
                            </label>

                            <input type="file"
                                   name="file_surat"
                                   accept=".pdf,.jpg,.jpeg,.png"
                                   class="w-full border border-gray-300 rounded-lg p-2">

                            <p class="text-xs text-gray-500 mt-1">
                                Format: PDF, JPG, JPEG, PNG. Maksimal 5 MB.
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Keterangan
                            </label>

                            <textarea name="keterangan"
                                      rows="3"
                                      placeholder="Keterangan tambahan..."
                                      class="w-full border-gray-300 rounded-lg">{{ old('keterangan') }}</textarea>
                        </div>

                    </div>

                    <div class="flex justify-end gap-3 mt-6">

                        <a href="{{ route('surat-masuk.index') }}"
                           class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                            Batal
                        </a>

                        <button type="submit"
                                class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Simpan Surat
                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>