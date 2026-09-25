<x-app-layout>

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}
    <div class="mb-4 sm:mb-6">
        <h1 class="text-xl font-bold text-gray-900 sm:text-2xl lg:text-3xl">
            Dashboard
        </h1>

        <p class="mt-1 text-xs text-gray-500 sm:text-sm">
            Selamat datang di Sistem Informasi RT
        </p>
    </div>


    {{-- ========================================================= --}}
    {{-- STATISTIK --}}
    {{-- Mobile  : 2 kolom --}}
    {{-- Desktop : 4 kolom --}}
    {{-- ========================================================= --}}
    <div
        class="
            dashboard-stat-grid
            mb-5
            grid
            gap-2.5
            sm:gap-4
            xl:gap-5
        "
    >

        {{-- TOTAL KK --}}
        <div
            class="
                min-w-0
                rounded-xl
                border border-gray-200
                bg-white
                p-3
                shadow-sm
                transition
                sm:rounded-2xl
                sm:p-4
                lg:p-5
            "
        >
            <div class="flex h-full items-center justify-between gap-2 sm:gap-4">

                <div class="min-w-0">
                    <p class="truncate text-[11px] font-medium text-gray-500 sm:text-sm">
                        Total KK
                    </p>

                    <p class="mt-0.5 text-xl font-bold text-gray-900 sm:mt-1 sm:text-2xl lg:text-3xl">
                        {{ $totalKK }}
                    </p>

                    <p class="mt-1 truncate text-[10px] font-medium text-green-600 sm:mt-2 sm:text-xs">
                        ↑ Data keluarga
                    </p>
                </div>

                <div
                    class="
                        flex
                        h-9
                        w-9
                        shrink-0
                        items-center
                        justify-center
                        rounded-lg
                        bg-blue-100
                        text-lg
                        sm:h-11
                        sm:w-11
                        sm:rounded-xl
                        sm:text-xl
                        lg:h-12
                        lg:w-12
                        lg:text-2xl
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
                rounded-xl
                border border-gray-200
                bg-white
                p-3
                shadow-sm
                sm:rounded-2xl
                sm:p-4
                lg:p-5
            "
        >
            <div class="flex h-full items-center justify-between gap-2 sm:gap-4">

                <div class="min-w-0">
                    <p class="truncate text-[11px] font-medium text-gray-500 sm:text-sm">
                        Surat Masuk
                    </p>

                    <p class="mt-0.5 text-xl font-bold text-gray-900 sm:mt-1 sm:text-2xl lg:text-3xl">
                        {{ $totalSuratMasuk }}
                    </p>

                    <p class="mt-1 truncate text-[10px] font-medium text-blue-600 sm:mt-2 sm:text-xs">
                        Surat diterima
                    </p>
                </div>

                <div
                    class="
                        flex
                        h-9
                        w-9
                        shrink-0
                        items-center
                        justify-center
                        rounded-lg
                        bg-purple-100
                        text-lg
                        sm:h-11
                        sm:w-11
                        sm:rounded-xl
                        sm:text-xl
                        lg:h-12
                        lg:w-12
                        lg:text-2xl
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
                rounded-xl
                border border-gray-200
                bg-white
                p-3
                shadow-sm
                sm:rounded-2xl
                sm:p-4
                lg:p-5
            "
        >
            <div class="flex h-full items-center justify-between gap-2 sm:gap-4">

                <div class="min-w-0">
                    <p class="truncate text-[11px] font-medium text-gray-500 sm:text-sm">
                        Saldo Kas
                    </p>

                    <p
                        class="
                            mt-0.5
                            truncate
                            text-base
                            font-bold
                            text-gray-900
                            sm:mt-1
                            sm:text-xl
                            lg:text-2xl
                        "
                        title="Rp {{ number_format($saldoKas, 0, ',', '.') }}"
                    >
                        Rp {{ number_format($saldoKas, 0, ',', '.') }}
                    </p>

                    <p class="mt-1 truncate text-[10px] font-medium text-green-600 sm:mt-2 sm:text-xs">
                        Saldo saat ini
                    </p>
                </div>

                <div
                    class="
                        flex
                        h-9
                        w-9
                        shrink-0
                        items-center
                        justify-center
                        rounded-lg
                        bg-green-100
                        text-lg
                        sm:h-11
                        sm:w-11
                        sm:rounded-xl
                        sm:text-xl
                        lg:h-12
                        lg:w-12
                        lg:text-2xl
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
                rounded-xl
                border border-gray-200
                bg-white
                p-3
                shadow-sm
                sm:rounded-2xl
                sm:p-4
                lg:p-5
            "
        >
            <div class="flex h-full items-center justify-between gap-2 sm:gap-4">

                <div class="min-w-0">
                    <p class="truncate text-[11px] font-medium text-gray-500 sm:text-sm">
                        Total Blok
                    </p>

                    <p class="mt-0.5 text-xl font-bold text-gray-900 sm:mt-1 sm:text-2xl lg:text-3xl">
                        {{ $totalBlok }}
                    </p>

                    <p class="mt-1 truncate text-[10px] text-gray-500 sm:mt-2 sm:text-xs">
                        Blok terdaftar
                    </p>
                </div>

                <div
                    class="
                        flex
                        h-9
                        w-9
                        shrink-0
                        items-center
                        justify-center
                        rounded-lg
                        bg-orange-100
                        text-lg
                        sm:h-11
                        sm:w-11
                        sm:rounded-xl
                        sm:text-xl
                        lg:h-12
                        lg:w-12
                        lg:text-2xl
                    "
                >
                    🏘️
                </div>

            </div>
        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- GRAFIK + AKTIVITAS --}}
    {{-- ========================================================= --}}
    <div
        class="
            grid
            min-w-0
            grid-cols-1
            gap-4
            xl:grid-cols-2
            xl:gap-6
        "
    >

        {{-- ===================================================== --}}
        {{-- GRAFIK CASHFLOW --}}
        {{-- ===================================================== --}}
        <div
            class="
                min-w-0
                overflow-hidden
                rounded-xl
                border border-gray-200
                bg-white
                shadow-sm
                sm:rounded-2xl
            "
        >

            <div class="p-3 sm:p-5 lg:p-6">

                {{-- HEADER --}}
                <div
                    class="
                        mb-3
                        flex
                        items-start
                        justify-between
                        gap-2
                        sm:mb-5
                        sm:items-center
                    "
                >

                    <div class="min-w-0">
                        <h2 class="text-base font-bold text-gray-900 sm:text-lg">
                            Grafik Cashflow
                        </h2>

                        <p class="mt-0.5 text-[11px] text-gray-500 sm:mt-1 sm:text-sm">
                            Pemasukan dan pengeluaran kas
                        </p>
                    </div>


                    <button
                        type="button"
                        class="
                            inline-flex
                            min-h-0
                            shrink-0
                            items-center
                            justify-center
                            rounded-lg
                            border border-gray-300
                            bg-white
                            px-2.5
                            py-1.5
                            text-[10px]
                            font-medium
                            text-gray-600
                            transition
                            hover:bg-gray-50
                            sm:rounded-xl
                            sm:px-4
                            sm:py-2
                            sm:text-sm
                        "
                    >
                        6 Bulan
                    </button>

                </div>


                {{-- LEGEND --}}
                <div class="mb-3 flex flex-wrap items-center gap-3 sm:mb-4 sm:gap-5">

                    <div class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>

                        <span class="text-[10px] text-gray-500 sm:text-xs">
                            Pemasukan
                        </span>
                    </div>

                    <div class="flex items-center gap-1.5">
                        <span class="h-2.5 w-2.5 rounded-full bg-red-400"></span>

                        <span class="text-[10px] text-gray-500 sm:text-xs">
                            Pengeluaran
                        </span>
                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- GRAFIK --}}
                {{-- ================================================= --}}
                <div class="cashflow-chart">

                    @foreach ($cashflowData as $item)

                        @php
                            $tinggiMasuk =
                                ($maxValue ?? 0) > 0 && $item['masuk'] > 0
                                    ? max(($item['masuk'] / $maxValue) * 100, 4)
                                    : 0;

                            $tinggiKeluar =
                                ($maxValue ?? 0) > 0 && $item['keluar'] > 0
                                    ? max(($item['keluar'] / $maxValue) * 100, 4)
                                    : 0;
                        @endphp


                        <div class="cashflow-item">

                            {{-- AREA BAR --}}
                            <div class="cashflow-bar-area">

                                {{-- PEMASUKAN --}}
                                <div
                                    class="
                                        cashflow-bar
                                        bg-blue-500
                                    "
                                    style="height: {{ $tinggiMasuk }}%;"
                                    title="Pemasukan {{ $item['label'] }}: Rp {{ number_format($item['masuk'], 0, ',', '.') }}"
                                ></div>


                                {{-- PENGELUARAN --}}
                                <div
                                    class="
                                        cashflow-bar
                                        bg-red-400
                                    "
                                    style="height: {{ $tinggiKeluar }}%;"
                                    title="Pengeluaran {{ $item['label'] }}: Rp {{ number_format($item['keluar'], 0, ',', '.') }}"
                                ></div>

                            </div>


                            {{-- BULAN --}}
                            <span class="cashflow-label">
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
                rounded-xl
                border border-gray-200
                bg-white
                shadow-sm
                sm:rounded-2xl
            "
        >

            <div class="p-3 sm:p-5 lg:p-6">


                {{-- HEADER --}}
                <div
                    class="
                        mb-4
                        flex
                        items-start
                        justify-between
                        gap-2
                        sm:mb-5
                        sm:gap-3
                    "
                >

                    <div class="min-w-0">
                        <h2 class="text-base font-bold text-gray-900 sm:text-lg">
                            Aktivitas Terbaru
                        </h2>

                        <p class="mt-0.5 text-[11px] text-gray-500 sm:mt-1 sm:text-sm">
                            Aktivitas sistem terbaru
                        </p>
                    </div>


                    <a
                        href="{{ route('riwayat-transaksi.index') }}"
                        class="
                            shrink-0
                            whitespace-nowrap
                            text-[10px]
                            font-semibold
                            text-blue-600
                            hover:text-blue-700
                            sm:text-sm
                        "
                    >
                        Lihat Semua →
                    </a>

                </div>


                {{-- DAFTAR --}}
                <div class="space-y-2 sm:space-y-3">

                    @forelse ($transaksiTerbaru as $trx)

                        <div
                            class="
                                flex
                                min-w-0
                                items-start
                                gap-2.5
                                rounded-lg
                                border border-gray-100
                                p-2.5
                                sm:gap-3
                                sm:rounded-xl
                                sm:p-3
                            "
                        >

                            {{-- ICON --}}
                            <div
                                class="
                                    flex
                                    h-8
                                    w-8
                                    shrink-0
                                    items-center
                                    justify-center
                                    rounded-full
                                    text-sm
                                    sm:h-10
                                    sm:w-10
                                    sm:text-base

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
                                        items-start
                                        justify-between
                                        gap-2
                                    "
                                >

                                    <p
                                        class="
                                            min-w-0
                                            truncate
                                            text-xs
                                            font-semibold
                                            text-gray-800
                                            sm:text-sm
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
                                            whitespace-nowrap
                                            text-[9px]
                                            text-gray-400
                                            sm:text-xs
                                        "
                                    >
                                        {{ $trx->created_at->diffForHumans() }}
                                    </span>

                                </div>


                                <p
                                    class="
                                        mt-0.5
                                        truncate
                                        text-xs
                                        font-semibold
                                        sm:mt-1
                                        sm:text-sm

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
                                            mt-0.5
                                            line-clamp-2
                                            text-[10px]
                                            leading-relaxed
                                            text-gray-500
                                            sm:mt-1
                                            sm:text-xs
                                        "
                                    >
                                        {{ $trx->description }}
                                    </p>

                                @endif

                            </div>

                        </div>

                    @empty

                        <div
                            class="
                                flex
                                min-h-32
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
                                sm:min-h-40
                            "
                        >

                            <div class="mb-1 text-2xl sm:mb-2 sm:text-3xl">
                                💰
                            </div>

                            <p class="text-xs font-medium text-gray-600 sm:text-sm">
                                Belum ada transaksi
                            </p>

                            <p class="mt-1 text-[10px] text-gray-400 sm:text-xs">
                                Aktivitas transaksi terbaru akan muncul di sini.
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- CSS KHUSUS DASHBOARD --}}
    {{-- ========================================================= --}}
    <style>

        /*
        |--------------------------------------------------------------------------
        | STATISTIC GRID
        |--------------------------------------------------------------------------
        */

        .dashboard-stat-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }


        /*
        |--------------------------------------------------------------------------
        | CASHFLOW CHART
        |--------------------------------------------------------------------------
        */

        .cashflow-chart {
            width: 100%;
            min-width: 0;

            height: 180px;

            display: grid;
            grid-template-columns: repeat(6, minmax(0, 1fr));

            align-items: end;

            gap: 5px;

            padding: 8px 2px 0;

            border-bottom: 1px solid #e5e7eb;

            overflow: hidden;
        }


        .cashflow-item {
            height: 100%;
            min-width: 0;

            display: flex;
            flex-direction: column;

            align-items: center;
            justify-content: flex-end;
        }


        .cashflow-bar-area {
            width: 100%;
            min-width: 0;

            height: calc(100% - 25px);

            display: flex;

            align-items: flex-end;
            justify-content: center;

            gap: 2px;
        }


        .cashflow-bar {
            width: 32%;
            max-width: 18px;
            min-width: 4px;

            border-radius: 4px 4px 0 0;

            transition:
                height 0.25s ease,
                opacity 0.2s ease;

            cursor: pointer;
        }


        .cashflow-bar:hover {
            opacity: 0.8;
        }


        .cashflow-label {
            display: block;

            width: 100%;

            margin-top: 7px;

            overflow: hidden;

            text-align: center;

            font-size: 9px;
            line-height: 1;

            color: #6b7280;

            white-space: nowrap;
            text-overflow: ellipsis;
        }


        /*
        |--------------------------------------------------------------------------
        | HP SANGAT KECIL
        |--------------------------------------------------------------------------
        */

        @media (max-width: 359px) {

            .dashboard-stat-grid {
                grid-template-columns: minmax(0, 1fr);
            }

            .cashflow-chart {
                height: 165px;

                gap: 3px;
            }

            .cashflow-bar {
                width: 35%;
                max-width: 14px;
            }

            .cashflow-label {
                font-size: 8px;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | MOBILE NORMAL
        |--------------------------------------------------------------------------
        */

        @media (min-width: 360px) and (max-width: 639px) {

            .dashboard-stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .cashflow-chart {
                height: 175px;

                gap: 4px;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | TABLET
        |--------------------------------------------------------------------------
        */

        @media (min-width: 640px) {

            .dashboard-stat-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .cashflow-chart {
                height: 230px;

                gap: 8px;

                padding-left: 8px;
                padding-right: 8px;
            }

            .cashflow-bar-area {
                gap: 4px;
            }

            .cashflow-bar {
                width: 30%;
                max-width: 24px;
            }

            .cashflow-label {
                margin-top: 9px;

                font-size: 12px;
            }

        }


        /*
        |--------------------------------------------------------------------------
        | DESKTOP
        |--------------------------------------------------------------------------
        */

        @media (min-width: 1280px) {

            .dashboard-stat-grid {
                grid-template-columns: repeat(4, minmax(0, 1fr));
            }

            .cashflow-chart {
                height: 260px;

                gap: 12px;

                padding-left: 12px;
                padding-right: 12px;
            }

            .cashflow-bar {
                max-width: 28px;
            }

        }

    </style>

</x-app-layout>