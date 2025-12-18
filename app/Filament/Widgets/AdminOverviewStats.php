<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\User;
use App\Models\Transaction;
use Filament\Widgets\Concerns\InteractsWithPageFilters; 
use Illuminate\Support\Carbon;

class AdminOverviewStats extends BaseWidget
{
    // 👇 Menggunakan Trait yang sudah di-import di atas
    use InteractsWithPageFilters; 

    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // 1. Ambil Nilai Filter dari Dashboard
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;

        // 2. Buat Helper Query untuk menerapkan filter tanggal
        $applyFilter = function ($query) use ($startDate, $endDate) {
            if ($startDate) {
                $query->whereDate('date', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('date', '<=', $endDate);
            }
            return $query;
        };

        // 3. Buat Helper Query khusus User (karena kolomnya created_at, bukan date)
        $applyUserFilter = function ($query) use ($startDate, $endDate) {
            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }
            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }
            return $query;
        };

        // 4. Hitung Data
        $totalIncome = $applyFilter(Transaction::where('type', 'income'))->sum('amount');
        $totalExpense = $applyFilter(Transaction::where('type', 'expense'))->sum('amount');
        $totalUser = $applyUserFilter(User::where('role', 'user'))->count();

        return [
            Stat::make('User Baru', $totalUser)
                ->description($startDate ? 'Periode terpilih' : 'Total keseluruhan')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Total Pemasukan', 'Rp ' . number_format($totalIncome, 0, ',', '.'))
                ->description('Total Income')
                ->color('success'),

            Stat::make('Total Pengeluaran', 'Rp ' . number_format($totalExpense, 0, ',', '.'))
                ->description('Total Expense')
                ->color('danger'),
        ];
    }
}