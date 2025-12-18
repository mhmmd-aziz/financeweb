<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class AdminGlobalChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Keuangan Global (Semua User)';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $year = now()->year;

        // Inisialisasi array data 0
        $incomes = array_fill(0, 12, 0);
        $expenses = array_fill(0, 12, 0);

        // 1. Ambil SEMUA Pemasukan (Tanpa filter user_id)
        $incomeData = Transaction::select(DB::raw('MONTH(date) as month'), DB::raw('SUM(amount) as total'))
            ->where('type', 'income')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // 2. Ambil SEMUA Pengeluaran (Tanpa filter user_id)
        $expenseData = Transaction::select(DB::raw('MONTH(date) as month'), DB::raw('SUM(amount) as total'))
            ->where('type', 'expense')
            ->whereYear('date', $year)
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Mapping ke array
        foreach ($incomeData as $month => $total) {
            $incomes[$month - 1] = $total;
        }
        foreach ($expenseData as $month => $total) {
            $expenses[$month - 1] = $total;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Total Pemasukan System',
                    'data' => $incomes,
                    'backgroundColor' => '#3b82f6', // Biru
                    'borderColor' => '#2563eb',
                ],
                [
                    'label' => 'Total Pengeluaran System',
                    'data' => $expenses,
                    'backgroundColor' => '#f43f5e', // Pink/Merah
                    'borderColor' => '#e11d48',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
        ];
    }

    protected function getType(): string
    {
        return 'line'; // Kita pakai LINE chart biar beda dengan user
    }
}