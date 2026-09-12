<x-app-layout>

    <x-slot name="header">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                Ajukan Setoran Iuran
            </h1>

            <p class="mt-1 text-base text-gray-600">
                Masukkan nominal uang yang akan diserahkan kepada Bendahara.
            </p>
        </div>
    </x-slot>


    <div class="mx-auto max-w-3xl">

        @if(session('error'))
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-base font-medium text-red-800">
                {{ session('error') }}
            </div>
        @endif


        @if($errors->any())
            <div class="mb-5 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">

                <p class="font-bold">
                    Periksa kembali data berikut:
                </p>

                <ul class="mt-2 list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        <form
            method="POST"
            action="{{ route('block-deposits.store') }}"
            class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-7 shadow-sm"
        >
            @csrf


            {{-- BLOK --}}
            <div class="mb-5">

                <label
                    for="block_id"
                    class="mb-2 block text-base font-bold text-gray-800"
                >
                    Blok
                </label>

                <select
                    id="block_id"
                    name="block_id"
                    required
                    class="min-h-14 w-full rounded-xl border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500"
                >

                    <option value="">
                        Pilih Blok
                    </option>

                    @foreach($blocks as $block)

                        <option
                            value="{{ $block->id }}"
                            @selected(old('block_id') == $block->id)
                        >
                            {{ $block->name }}
                        </option>

                    @endforeach

                </select>

            </div>


            {{-- BULAN TAHUN --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">

                <div>

                    <label
                        for="month"
                        class="mb-2 block text-base font-bold text-gray-800"
                    >
                        Bulan
                    </label>

                    <select
                        name="month"
                        id="month"
                        required
                        class="min-h-14 w-full rounded-xl border-gray-300 text-base"
                    >

                        <option value="">
                            Pilih Bulan
                        </option>

                        @php
                            $months = [
                                1 => 'Januari',
                                2 => 'Februari',
                                3 => 'Maret',
                                4 => 'April',
                                5 => 'Mei',
                                6 => 'Juni',
                                7 => 'Juli',
                                8 => 'Agustus',
                                9 => 'September',
                                10 => 'Oktober',
                                11 => 'November',
                                12 => 'Desember',
                            ];
                        @endphp

                        @foreach($months as $number => $monthName)

                            <option
                                value="{{ $number }}"
                                @selected(
                                    old('month', now()->month) == $number
                                )
                            >
                                {{ $monthName }}
                            </option>

                        @endforeach

                    </select>

                </div>


                <div>

                    <label
                        for="year"
                        class="mb-2 block text-base font-bold text-gray-800"
                    >
                        Tahun
                    </label>

                    <input
                        id="year"
                        type="number"
                        name="year"
                        value="{{ old('year', now()->year) }}"
                        required
                        class="min-h-14 w-full rounded-xl border-gray-300 text-base"
                    >

                </div>

            </div>


            {{-- PEMBAYARAN TERCATAT --}}
            <div class="mb-5">

                <label
                    for="expected_amount"
                    class="mb-2 block text-base font-bold text-gray-800"
                >
                    Total Pembayaran Warga Tercatat
                </label>

                <input
                    id="expected_amount"
                    type="number"
                    min="0"
                    step="1"
                    name="expected_amount"
                    value="{{ old('expected_amount') }}"
                    required
                    placeholder="Contoh: 900000"
                    class="min-h-14 w-full rounded-xl border-gray-300 text-lg font-semibold"
                >

                <p class="mt-2 text-sm text-gray-500">
                    Sementara diisi manual. Nanti nilai ini akan otomatis diambil dari modul iuran.
                </p>

            </div>


            {{-- UANG DISETOR --}}
            <div class="mb-5">

                <label
                    for="submitted_amount"
                    class="mb-2 block text-base font-bold text-gray-800"
                >
                    Uang yang Disetor
                </label>

                <input
                    id="submitted_amount"
                    type="number"
                    min="0"
                    step="1"
                    name="submitted_amount"
                    value="{{ old('submitted_amount') }}"
                    required
                    placeholder="Contoh: 900000"
                    class="min-h-14 w-full rounded-xl border-gray-300 text-lg font-semibold"
                >

            </div>


            {{-- CATATAN --}}
            <div class="mb-6">

                <label
                    for="notes"
                    class="mb-2 block text-base font-bold text-gray-800"
                >
                    Catatan
                </label>

                <textarea
                    id="notes"
                    name="notes"
                    rows="4"
                    placeholder="Tambahkan catatan jika diperlukan"
                    class="w-full rounded-xl border-gray-300 text-base"
                >{{ old('notes') }}</textarea>

            </div>


            <button
                type="submit"
                class="min-h-14 w-full rounded-xl bg-blue-600 px-6 py-3 text-lg font-bold text-white shadow-sm hover:bg-blue-700"
            >
                Ajukan Setoran
            </button>

        </form>

    </div>

</x-app-layout>