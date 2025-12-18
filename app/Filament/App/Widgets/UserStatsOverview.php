<?php

namespace App\Filament\App\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaction;
use Filament\Widgets\Concerns\InteractsWithPageFilters; // Import Ini
use Illuminate\Support\Carbon;

class UserStatsOverview extends BaseWidget
{
    use InteractsWithPageFilters; // Gunakan Ini

    protected function getStats(): array
    {
        $userId = auth()->id();
        
        // Ambil Nilai Filter dari Dashboard
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        // Query Dasar
        $query = Transaction::where('user_id', $userId);

        // Terapkan Filter jika user memilih tanggal
        if ($startDate) {
            $query->whereDate('date', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('date', '<=', $endDate);
        }

        // Clone query agar tidak tumpah tindih antara income/expense
        $pemasukan = (clone $query)->where('type', 'income')->sum('amount');
        $pengeluaran = (clone $query)->where('type', 'expense')->sum('amount');
        $saldo = $pemasukan - $pengeluaran;

        return [
            Stat::make('Saldo (Periode Ini)', 'Rp ' . number_format($saldo, 0, ',', '.'))
                ->color('primary'),
            Stat::make('Pemasukan', 'Rp ' . number_format($pemasukan, 0, ',', '.'))
                ->color('success'),
            Stat::make('Pengeluaran', 'Rp ' . number_format($pengeluaran, 0, ',', '.'))
                ->color('danger'),
        ];
    }
}