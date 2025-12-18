<?php

namespace App\Filament\App\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\Transaction;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class IncomeExpenseChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Grafik Pemasukan & Pengeluaran';
    
    protected static ?int $sort = 3; // Urutan ke-3 (Di bawah statistik)
    
    protected int | string | array $columnSpan = 'full'; // Lebar Penuh

    protected function getData(): array
    {
        $userId = auth()->id();
        
        // Ambil Filter dari Dashboard
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        // Siapkan Query Builder
        $query = Transaction::where('user_id', $userId);

        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        // Logic Grouping Data (Per Tanggal)
        $dataIncome = (clone $query)->where('type', 'income')
            ->selectRaw('DATE_FORMAT(date, "%Y-%m-%d") as date_label, sum(amount) as total')
            ->groupBy('date_label')
            ->orderBy('date_label')
            ->pluck('total', 'date_label')
            ->toArray();

        $dataExpense = (clone $query)->where('type', 'expense')
            ->selectRaw('DATE_FORMAT(date, "%Y-%m-%d") as date_label, sum(amount) as total')
            ->groupBy('date_label')
            ->orderBy('date_label')
            ->pluck('total', 'date_label')
            ->toArray();

        // Gabungkan Label Tanggal agar sumbu X rapi
        $labels = array_unique(array_merge(array_keys($dataIncome), array_keys($dataExpense)));
        sort($labels);

        // Map data ke label (isi 0 jika tanggal tersebut tidak ada transaksi)
        $datasetIncome = [];
        $datasetExpense = [];

        foreach ($labels as $date) {
            $datasetIncome[] = $dataIncome[$date] ?? 0;
            $datasetExpense[] = $dataExpense[$date] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pemasukan',
                    'data' => $datasetIncome,
                    'backgroundColor' => '#10b981', // Hijau (Emerald-500)
                    'borderColor' => '#10b981',
                    'barThickness' => 20, // Opsional: Biar batang gak terlalu gemuk
                ],
                [
                    'label' => 'Pengeluaran',
                    'data' => $datasetExpense,
                    'backgroundColor' => '#ef4444', // Merah (Red-500)
                    'borderColor' => '#ef4444',
                    'barThickness' => 20,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar'; // <--- KEMBALI KE BAR CHART
    }
}