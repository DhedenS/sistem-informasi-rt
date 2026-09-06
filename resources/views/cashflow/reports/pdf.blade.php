<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Cashflow Kas RT</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
            color: #333;
            margin: 0;
            padding: 10px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #1e3a8a;
            text-transform: uppercase;
        }
        .header p {
            margin: 4px 0 0 0;
            font-size: 11px;
            color: #666;
        }
        .summary-box {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .summary-box td {
            width: 33.33%;
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
            background-color: #f8fafc;
        }
        .summary-box font-title {
            display: block;
            font-size: 9px;
            text-transform: uppercase;
            color: #64748b;
        }
        .summary-box .amount {
            font-size: 14px;
            font-weight: bold;
            margin-top: 3px;
        }
        .income { color: #059669; }
        .expense { color: #dc2626; }
        .balance { color: #2563eb; }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
        }
        table.data-table th {
            background-color: #f1f5f9;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            color: #475569;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .footer {
            margin-top: 25px;
            text-align: right;
            font-size: 10px;
            color: #64748b;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Laporan Keuangan Cashflow Kas RT</h1>
        <p>
            @if($request->filled('start_date') && $request->filled('end_date'))
                Periode: {{ date('d/m/Y', strtotime($request->start_date)) }} s/d {{ date('d/m/Y', strtotime($request->end_date)) }}
            @else
                Periode: Seluruh Transaksi Sampai {{ date('d F Y') }}
            @endif
        </p>
    </div>

    <!-- Summary Box -->
    <table class="summary-box">
        <tr>
            <td>
                <span class="font-title">Total Pemasukan</span>
                <div class="amount income">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
            </td>
            <td>
                <span class="font-title">Total Pengeluaran</span>
                <div class="amount expense">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
            </td>
            <td>
                <span class="font-title">Saldo Kas</span>
                <div class="amount balance">Rp {{ number_format($balance, 0, ',', '.') }}</div>
            </td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="4%" class="text-center">No</th>
                <th width="10%">Tanggal</th>
                <th width="8%" class="text-center">Jenis</th>
                <th width="16%">Kategori</th>
                <th width="16%">Sumber Dana</th>
                <th width="14%" class="text-right">Jumlah (Rp)</th>
                <th width="32%">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $index => $trx)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $trx->transaction_date->format('d/m/Y') }}</td>
                    <td class="text-center">
                        <strong class="{{ $trx->type === 'masuk' ? 'income' : 'expense' }}">
                            {{ ucfirst($trx->type) }}
                        </strong>
                    </td>
                    <td>{{ $trx->category->name ?? '-' }}</td>
                    <td>{{ $trx->fundSource->name ?? '-' }}</td>
                    <td class="text-right">
                        <strong class="{{ $trx->type === 'masuk' ? 'income' : 'expense' }}">
                            {{ $trx->type === 'masuk' ? '+' : '-' }} {{ number_format($trx->amount, 0, ',', '.') }}
                        </strong>
                    </td>
                    <td>{{ $trx->description ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada transaksi terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak secara otomatis oleh Sistem Pengelolaan Kas RT pada {{ date('d F Y H:i') }} WIB</p>
    </div>

</body>
</html>
