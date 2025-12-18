<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total User', User::where('role', 'user')->count())
                ->description('User terdaftar')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),
                
            Stat::make('Total Transaksi Masuk', 'Rp ' . number_format(Transaction::where('type', 'income')->sum('amount')))
                ->description('Global Income')
                ->color('success'),

            Stat::make('Total Transaksi Keluar', 'Rp ' . number_format(Transaction::where('type', 'expense')->sum('amount')))
                ->description('Global Expense')
                ->color('danger'),
        ];
    }
}