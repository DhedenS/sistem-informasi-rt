<x-app-layout>

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}
    <div class="mb-5 sm:mb-6">

        <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">
            Dashboard
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Selamat datang di Sistem Informasi RT
        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- STATISTIK --}}
    {{-- Mobile  : 1 kolom --}}
    {{-- Tablet  : 2 kolom --}}
    {{-- Desktop : 4 kolom --}}
    {{-- ========================================================= --}}
    <div
        class="
            mb-6
            grid
            grid-cols-1
            gap-4
            sm:grid-cols-2
            xl:grid-cols-4
        "
    >

        {{-- TOTAL KK --}}
        <div
            class="
                min-w-0
                rounded-2xl
                border border-gray-200
                bg-white
                p-4
                shadow-sm
                sm:p-5
            "
        >

            <div class="flex items-center justify-between gap-4">

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-500">
                        Total KK
                    </p>

                    <p
                        class="
                            mt-1
                            text-2xl
                            font-bold
                            text-gray-900
                            sm:text-3xl
                        "
                    >
                        {{ $totalKK }}
                    </p>

                    <p
                        class="
                            mt-2
                            text-xs
                            font-medium
                            text-green-600
                        "
                    >
                        ↑ Data keluarga
                    </p>

                </div>


                <div
                    class="
                        flex
                        h-12
                        w-12
                        shrink-0
                        items-center
                        justify-center
                        rounded-xl
                        bg-blue-100
                        text-2xl
                    "
                >
                    👨‍👩‍👧‍👦
                </div>

            </div>

        </div>


        {{-- SURAT MASUK --}}
        <div
            class="
                min-w-0
                rounded-2xl
                border border-gray-200
                bg-white
                p-4
                shadow-sm
                sm:p-5
            "
        >

            <div class="flex items-center justify-between gap-4">

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-500">
                        Surat Masuk
                    </p>

                    <p
                        class="
                            mt-1
                            text-2xl
                            font-bold
                            text-gray-900
                            sm:text-3xl
                        "
                    >
                        {{ $totalSuratMasuk }}
                    </p>

                    <p
                        class="
                            mt-2
                            text-xs
                            font-medium
                            text-blue-600
                        "
                    >
                        Surat diterima
                    </p>

                </div>


                <div
                    class="
                        flex
                        h-12
                        w-12
                        shrink-0
                        items-center
                        justify-center
                        rounded-xl
                        bg-purple-100
                        text-2xl
                    "
                >
                    📄
                </div>

            </div>

        </div>


        {{-- SALDO KAS --}}
        <div
            class="
                min-w-0
                rounded-2xl
                border border-gray-200
                bg-white
                p-4
                shadow-sm
                sm:p-5
            "
        >

            <div class="flex items-center justify-between gap-4">

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-500">
                        Saldo Kas
                    </p>

                    <p
                        class="
                            mt-1
                            break-words
                            text-xl
                            font-bold
                            text-gray-900
                            sm:text-2xl
                        "
                    >
                        Rp {{ number_format($saldoKas, 0, ',', '.') }}
                    </p>

                    <p
                        class="
                            mt-2
                            text-xs
                            font-medium
                            text-green-600
                        "
                    >
                        Saldo saat ini
                    </p>

                </div>


                <div
                    class="
                        flex
                        h-12
                        w-12
                        shrink-0
                        items-center
                        justify-center
                        rounded-xl
                        bg-green-100
                        text-2xl
                    "
                >
                    💰
                </div>

            </div>

        </div>


        {{-- TOTAL BLOK --}}
        <div
            class="
                min-w-0
                rounded-2xl
                border border-gray-200
                bg-white
                p-4
                shadow-sm
                sm:p-5
            "
        >

            <div class="flex items-center justify-between gap-4">

                <div class="min-w-0">

                    <p class="text-sm font-medium text-gray-500">
                        Total Blok
                    </p>

                    <p
                        class="
                            mt-1
                            text-2xl
                            font-bold
                            text-gray-900
                            sm:text-3xl
                        "
                    >
                        {{ $totalBlok }}
                    </p>

                    <p class="mt-2 text-xs text-gray-500">
                        Blok terdaftar
                    </p>

                </div>


                <div
                    class="
                        flex
                        h-12
                        w-12
                        shrink-0
                        items-center
                        justify-center
                        rounded-xl
                        bg-orange-100
                        text-2xl
                    "
                >
                    🏘️
                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- BAGIAN BAWAH --}}
    {{-- Mobile  : 1 kolom --}}
    {{-- Desktop : grafik + aktivitas --}}
    {{-- ========================================================= --}}
    <div
        class="
            grid
            grid-cols-1
            gap-4
            lg:grid-cols-2
            lg:gap-6
        "
    >

        {{-- ===================================================== --}}
        {{-- GRAFIK CASHFLOW --}}
        {{-- ===================================================== --}}
        <div
            class="
                min-w-0
                overflow-hidden
                rounded-2xl
                border border-gray-200
                bg-white
                shadow-sm
            "
        >

            <div class="p-4 sm:p-6">

                {{-- HEADER GRAFIK --}}
                <div
                    class="
                        mb-6
                        flex
                        flex-col
                        gap-3
                        sm:flex-row
                        sm:items-center
                        sm:justify-between
                    "
                >

                    <div class="min-w-0">

                        <h2
                            class="
                                text-lg
                                font-bold
                                text-gray-900
                            "
                        >
                            Grafik Cashflow
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Pemasukan dan pengeluaran kas
                        </p>

                    </div>


                    <button
                        type="button"
                        class="
                            inline-flex
                            min-h-11
                            w-full
                            items-center
                            justify-center
                            rounded-xl
                            border border-gray-300
                            bg-white
                            px-4
                            py-2
                            text-sm
                            font-medium
                            text-gray-600
                            transition
                            hover:bg-gray-50
                            sm:w-auto
                        "
                    >
                        6 Bulan
                    </button>

                </div>


                {{-- GRAFIK --}}
                <div
                    class="
                        flex
                        h-60
                        w-full
                        min-w-0
                        items-end
                        justify-between
                        gap-2
                        border-b
                        border-gray-200
                        px-1
                        sm:h-64
                        sm:gap-4
                        sm:px-2
                    "
                >

                    @foreach ($cashflowData as $item)

                        @php
                            $tinggiMasuk =
                                ($maxValue ?? 0) > 0 && $item['masuk'] > 0
                                    ? max(($item['masuk'] / $maxValue) * 100, 4)
                                    : 0;
                        @endphp


                        <div
                            class="
                                flex
                                h-full
                                min-w-0
                                flex-1
                                flex-col
                                items-center
                                justify-end
                            "
                        >

                            {{-- BAR --}}
                            <div
                                class="
                                    w-full
                                    max-w-12
                                    rounded-t-md
                                    bg-blue-500
                                    transition-all
                                "
                                style="height: {{ $tinggiMasuk }}%;"
                                title="Rp {{ number_format($item['masuk'], 0, ',', '.') }}"
                            ></div>


                            {{-- BULAN --}}
                            <span
                                class="
                                    mt-2
                                    block
                                    w-full
                                    truncate
                                    text-center
                                    text-[10px]
                                    text-gray-500
                                    sm:text-xs
                                "
                            >
                                {{ $item['label'] }}
                            </span>

                        </div>

                    @endforeach

                </div>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- AKTIVITAS TERBARU --}}
        {{-- ===================================================== --}}
        <div
            class="
                min-w-0
                overflow-hidden
                rounded-2xl
                border border-gray-200
                bg-white
                shadow-sm
            "
        >

            <div class="p-4 sm:p-6">


                {{-- HEADER AKTIVITAS --}}
                <div
                    class="
                        mb-5
                        flex
                        items-start
                        justify-between
                        gap-3
                    "
                >

                    <div class="min-w-0">

                        <h2
                            class="
                                text-lg
                                font-bold
                                text-gray-900
                            "
                        >
                            Aktivitas Terbaru
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Aktivitas sistem terbaru
                        </p>

                    </div>


                    <a
                        href="{{ route('riwayat-transaksi.index') }}"
                        class="
                            shrink-0
                            whitespace-nowrap
                            text-sm
                            font-semibold
                            text-blue-600
                            hover:text-blue-700
                        "
                    >
                        Lihat Semua →
                    </a>

                </div>


                {{-- DAFTAR --}}
                <div class="space-y-3">

                    @forelse ($transaksiTerbaru as $trx)

                        <div
                            class="
                                flex
                                min-w-0
                                items-start
                                gap-3
                                rounded-xl
                                border
                                border-gray-100
                                p-3
                            "
                        >

                            {{-- ICON --}}
                            <div
                                class="
                                    flex
                                    h-10
                                    w-10
                                    shrink-0
                                    items-center
                                    justify-center
                                    rounded-full

                                    {{ $trx->type === 'masuk'
                                        ? 'bg-green-100'
                                        : 'bg-red-100'
                                    }}
                                "
                            >
                                {{ $trx->type === 'masuk' ? '📥' : '📤' }}
                            </div>


                            {{-- CONTENT --}}
                            <div class="min-w-0 flex-1">

                                <div
                                    class="
                                        flex
                                        flex-col
                                        gap-1
                                        sm:flex-row
                                        sm:items-center
                                        sm:justify-between
                                    "
                                >

                                    <p
                                        class="
                                            min-w-0
                                            text-sm
                                            font-semibold
                                            text-gray-800
                                        "
                                    >
                                        {{ $trx->type === 'masuk'
                                            ? 'Pemasukan'
                                            : 'Pengeluaran'
                                        }}
                                    </p>


                                    <span
                                        class="
                                            shrink-0
                                            text-xs
                                            text-gray-400
                                        "
                                    >
                                        {{ $trx->created_at->diffForHumans() }}
                                    </span>

                                </div>


                                <p
                                    class="
                                        mt-1
                                        break-words
                                        text-sm
                                        font-medium

                                        {{ $trx->type === 'masuk'
                                            ? 'text-green-600'
                                            : 'text-red-600'
                                        }}
                                    "
                                >
                                    {{ $trx->type === 'masuk' ? '+' : '-' }}

                                    Rp {{ number_format($trx->amount, 0, ',', '.') }}
                                </p>


                                @if (!empty($trx->description))

                                    <p
                                        class="
                                            mt-1
                                            break-words
                                            text-xs
                                            text-gray-500
                                        "
                                    >
                                        {{ $trx->description }}
                                    </p>

                                @endif

                            </div>

                        </div>

                    @empty

                        {{-- EMPTY STATE --}}
                        <div
                            class="
                                flex
                                min-h-40
                                flex-col
                                items-center
                                justify-center
                                rounded-xl
                                border
                                border-dashed
                                border-gray-300
                                bg-gray-50
                                px-4
                                text-center
                            "
                        >

                            <div class="mb-2 text-3xl">
                                💰
                            </div>

                            <p
                                class="
                                    text-sm
                                    font-medium
                                    text-gray-600
                                "
                            >
                                Belum ada transaksi
                            </p>

                            <p
                                class="
                                    mt-1
                                    text-xs
                                    text-gray-400
                                "
                            >
                                Aktivitas transaksi terbaru akan muncul di sini.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</x-app-layout>