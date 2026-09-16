<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-xl font-semibold text-gray-800">
                Buat Pengajuan Iuran
            </h2>

            <p class="text-sm text-gray-500">
                Pilih KK yang sudah membayar iuran bulan ini.
            </p>
        </div>
    </x-slot>

    <div class="py-6">

        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

            {{-- Error validasi --}}
            @if ($errors->any())
                <div class="mb-6 rounded-lg bg-red-100 p-4 text-sm text-red-700">

                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif


            {{-- Informasi blok --}}
            <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

                <p class="text-sm text-gray-500">
                    Blok Anda
                </p>

                <h1 class="mt-1 text-2xl font-bold text-gray-900">
                    {{ $block->name }}
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Pilih warga yang sudah menyerahkan iuran kepada Ketua Block.
                </p>

            </div>


            <form action="{{ route('pengajuan-iuran.store') }}" method="POST" enctype="multipart/form-data"
                id="pengajuanForm">

                @csrf


                {{-- Periode --}}
                <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Periode Iuran
                    </h2>

                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">

                        <div>

                            <label for="bulan" class="block text-sm font-medium text-gray-700">
                                Bulan
                            </label>

                            <select name="bulan" id="bulan" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                                @php
                                    $bulanSekarang = now()->month;
                                @endphp

                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}"
                                        {{ old('bulan', $bulanSekarang) == $i ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                                    </option>
                                @endfor

                            </select>

                        </div>


                        <div>

                            <label for="tahun" class="block text-sm font-medium text-gray-700">
                                Tahun
                            </label>

                            <select name="tahun" id="tahun" required
                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">

                                @for ($tahun = now()->year - 1; $tahun <= now()->year + 1; $tahun++)
                                    <option value="{{ $tahun }}"
                                        {{ old('tahun', now()->year) == $tahun ? 'selected' : '' }}>
                                        {{ $tahun }}
                                    </option>
                                @endfor

                            </select>

                        </div>

                    </div>

                </div>


                {{-- Nominal --}}
                <div class="mb-6 rounded-xl bg-indigo-50 p-5 ring-1 ring-indigo-100">

                    <p class="text-sm font-medium text-indigo-700">
                        Nominal Iuran
                    </p>

                    <p class="mt-1 text-3xl font-bold text-indigo-900">
                        Rp {{ number_format($nominalPerKK, 0, ',', '.') }}
                    </p>

                    <p class="mt-1 text-sm text-indigo-700">
                        Nominal ditentukan oleh sistem dan tidak dapat diubah.
                    </p>

                </div>


                {{-- Pilihan KK --}}
                <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div>

                            <h2 class="text-lg font-semibold text-gray-900">
                                Pilih KK yang Sudah Membayar
                            </h2>

                            <p class="text-sm text-gray-500">
                                Centang nama KK yang sudah menyerahkan iuran.
                            </p>

                        </div>


                        <button type="button" id="selectAll"
                            class="rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200">
                            Pilih Semua
                        </button>

                    </div>


                    <div class="mt-5 grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-3">

                        @foreach ($households as $household)
                            <label
                                class="household-card flex cursor-pointer items-center gap-3 rounded-xl border border-gray-200 p-4 transition hover:bg-gray-50">

                                <input type="checkbox" name="household_ids[]" value="{{ $household->id }}"
                                    class="household-checkbox h-5 w-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500"
                                    {{ in_array($household->id, old('household_ids', [])) ? 'checked' : '' }}>

                                <div class="min-w-0">

                                    <p class="font-semibold text-gray-900">
                                        {{ $household->household_number }}
                                    </p>

                                    <p class="truncate text-sm text-gray-500">
                                        {{ $household->head_name }}
                                    </p>

                                </div>

                            </label>
                        @endforeach

                    </div>

                </div>


                {{-- Ringkasan --}}
                <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Ringkasan Pengajuan
                    </h2>

                    <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2">

                        <div class="rounded-lg bg-gray-50 p-4">

                            <p class="text-sm text-gray-500">
                                Jumlah KK
                            </p>

                            <p id="jumlahKK" class="mt-1 text-2xl font-bold text-gray-900">
                                0 KK
                            </p>

                        </div>


                        <div class="rounded-lg bg-green-50 p-4">

                            <p class="text-sm text-green-700">
                                Total Iuran
                            </p>

                            <p id="totalIuran" class="mt-1 text-2xl font-bold text-green-800">
                                Rp 0
                            </p>

                        </div>

                        <div class="rounded-lg bg-yellow-50 p-4">
                            <p class="text-sm text-yellow-700">
                                KK Belum Bayar
                            </p>
                            <p id="belumBayar" class="mt-1 text-2xl font-bold text-yellow-800">
                                {{ $totalHouseholds }} KK
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Bukti --}}
                <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

                    <h2 class="text-lg font-semibold text-gray-900">
                        Bukti Pembayaran
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Upload bukti jika diperlukan. Format JPG, JPEG, PNG, atau PDF. Maksimal 5 MB.
                    </p>

                    <input type="file" name="bukti" accept=".jpg,.jpeg,.png,.pdf"
                        class="mt-4 block w-full rounded-lg border border-gray-300 p-2 text-sm">

                </div>


                {{-- Catatan --}}
                <div class="mb-6 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-200">

                    <label for="catatan" class="block text-sm font-medium text-gray-700">
                        Catatan
                    </label>

                    <textarea name="catatan" id="catatan" rows="4" placeholder="Tambahkan catatan jika diperlukan..."
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('catatan') }}</textarea>

                </div>


                {{-- Tombol --}}
                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                    <a href="{{ route('pengajuan-iuran.index') }}"
                        class="rounded-lg bg-gray-100 px-5 py-3 text-center text-sm font-semibold text-gray-700 hover:bg-gray-200">
                        Batal
                    </a>

                    <button type="submit"
                        class="rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700">
                        Kirim Pengajuan
                    </button>

                </div>

            </form>

        </div>

    </div>


    {{-- JavaScript hitung total --}}
    <script>
        const nominalPerKK = {{ $nominalPerKK }};

        const checkboxes = document.querySelectorAll('.household-checkbox');

        const jumlahKKElement = document.getElementById('jumlahKK');

        const totalIuranElement = document.getElementById('totalIuran');

        const selectAllButton = document.getElementById('selectAll');

        const totalHouseholds = {{ $totalHouseholds }};

        const belumBayarElement = document.getElementById('belumBayar');

        function formatRupiah(angka) {

            return new Intl.NumberFormat('id-ID').format(angka);

        }


        function updateTotal() {
            const selected = document.querySelectorAll('.household-checkbox:checked');
            const jumlah = selected.length;
            const total = jumlah * nominalPerKK;
            const belumBayar = totalHouseholds - jumlah;

            jumlahKKElement.textContent = jumlah + ' KK';
            totalIuranElement.textContent = 'Rp ' + formatRupiah(total);
            belumBayarElement.textContent = belumBayar + ' KK';
        }


        checkboxes.forEach(function(checkbox) {

            checkbox.addEventListener('change', updateTotal);

        });


        selectAllButton.addEventListener('click', function() {

            const allChecked =
                document.querySelectorAll(
                    '.household-checkbox:checked'
                ).length === checkboxes.length;

            checkboxes.forEach(function(checkbox) {

                checkbox.checked = !allChecked;

            });

            updateTotal();

        });


        updateTotal();
    </script>

</x-app-layout>
