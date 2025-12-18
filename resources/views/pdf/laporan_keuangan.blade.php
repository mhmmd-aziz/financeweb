<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; }
        .header p { margin: 5px 0; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-right { text-align: right; }
        .income { color: green; font-weight: bold; }
        .expense { color: red; font-weight: bold; }
        .total-row { font-weight: bold; background-color: #fafafa; }
        .badge { padding: 4px 8px; border-radius: 4px; color: white; font-size: 10px; }
        .bg-green { background-color: #10b981; }
        .bg-red { background-color: #ef4444; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Keuangan</h2>
        <p>User: {{ auth()->user()->name }}</p>
        <p>Tanggal Cetak: {{ now()->format('d F Y') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Kategori</th>
                <th>Jenis</th>
                <th class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalPemasukan = 0;
                $totalPengeluaran = 0;
            @endphp
            
            @foreach($transactions as $t)
            @php
                if($t->type == 'income') $totalPemasukan += $t->amount;
                else $totalPengeluaran += $t->amount;
            @endphp
            <tr>
                <td>{{ \Carbon\Carbon::parse($t->date)->format('d/m/Y') }}</td>
                <td>{{ $t->name }}</td>
                <td>{{ $t->category->name ?? '-' }}</td>
                <td>
                    <span class="{{ $t->type == 'income' ? 'income' : 'expense' }}">
                        {{ $t->type == 'income' ? 'Pemasukan' : 'Pengeluaran' }}
                    </span>
                </td>
                <td class="text-right">
                    Rp {{ number_format($t->amount, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="4" class="text-right">Total Saldo</td>
                <td class="text-right">
                    Rp {{ number_format($totalPemasukan - $totalPengeluaran, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
</body>
</html>