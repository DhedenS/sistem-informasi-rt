<x-app-layout>

    <x-slot name="header">

        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                Detail Setoran
            </h1>

            <p class="mt-1 text-base text-gray-600">
                Pemeriksaan nominal setoran Ketua Blok.
            </p>
        </div>

    </x-slot>


    <div class="mx-auto max-w-3xl space-y-5">

        @if(session('success'))

            <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
                {{ session('success') }}
            </div>

        @endif


        {{-- INFO --}}
        <section class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-7 shadow-sm">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Blok
                    </p>

                    <h2 class="text-2xl font-bold text-gray-900">
                        {{ $blockDeposit->block->name ?? '-' }}
                    </h2>

                </div>


                <span class="w-fit rounded-full bg-yellow-100 px-4 py-2 font-bold text-yellow-800">

                    {{ strtoupper($blockDeposit->status) }}

                </span>

            </div>


            <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">

                <div class="rounded-xl bg-gray-50 p-4">

                    <p class="text-sm text-gray-500">
                        Ketua Blok
                    </p>

                    <p class="mt-1 text-lg font-bold text-gray-900">
                        {{ $blockDeposit->user->name ?? '-' }}
                    </p>

                </div>


                <div class="rounded-xl bg-gray-50 p-4">

                    <p class="text-sm text-gray-500">
                        Periode
                    </p>

                    <p class="mt-1 text-lg font-bold text-gray-900">

                        {{ str_pad($blockDeposit->month, 2, '0', STR_PAD_LEFT) }}
                        /
                        {{ $blockDeposit->year }}

                    </p>

                </div>

            </div>

        </section>


        {{-- VALIDASI --}}
        <section class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-7 shadow-sm">

            <h2 class="text-xl font-bold text-gray-900">
                Validasi Nominal
            </h2>


            <div class="mt-5 space-y-4">

                <div class="flex items-center justify-between gap-4 border-b pb-4">

                    <span class="text-base text-gray-600">
                        Pembayaran warga tercatat
                    </span>

                    <strong class="text-lg text-gray-900">
                        Rp {{ number_format(
                            $blockDeposit->expected_amount,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>


                <div class="flex items-center justify-between gap-4 border-b pb-4">

                    <span class="text-base text-gray-600">
                        Uang disetor
                    </span>

                    <strong class="text-lg text-gray-900">
                        Rp {{ number_format(
                            $blockDeposit->submitted_amount,
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>


                <div class="flex items-center justify-between gap-4">

                    <span class="text-base text-gray-600">
                        Selisih
                    </span>

                    <strong class="text-lg {{ $blockDeposit->is_matched
                        ? 'text-green-700'
                        : 'text-red-700' }}"
                    >
                        Rp {{ number_format(
                            abs($blockDeposit->difference),
                            0,
                            ',',
                            '.'
                        ) }}
                    </strong>

                </div>

            </div>


            @if($blockDeposit->is_matched)

                <div class="mt-6 rounded-xl border border-green-200 bg-green-50 p-5">

                    <p class="text-lg font-bold text-green-800">
                        ✓ Nominal Sesuai
                    </p>

                    <p class="mt-1 text-base text-green-700">
                        Uang yang disetor sesuai dengan pembayaran warga yang tercatat.
                    </p>

                </div>

            @else

                <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-5">

                    <p class="text-lg font-bold text-red-800">
                        ⚠ Nominal Tidak Sesuai
                    </p>

                    <p class="mt-1 text-base text-red-700">
                        Terdapat selisih antara catatan pembayaran dan uang yang disetor.
                    </p>

                </div>

            @endif

        </section>

    </div>

</x-app-layout>