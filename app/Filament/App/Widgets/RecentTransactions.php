<?php

namespace App\Filament\App\Widgets;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Models\Transaction;
use App\Filament\App\Resources\TransactionResource; 
use Filament\Infolists\Infolist;

class RecentTransactions extends BaseWidget
{
    protected static ?int $sort = 5; 
    protected int | string | array $columnSpan = 'full'; 
    protected static ?string $heading = '5 Transaksi Terakhir';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Transaction::where('user_id', auth()->id())
                    ->latest('date')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y'),
                
                Tables\Columns\TextColumn::make('name')
                    ->label('Keterangan')
                    ->limit(20), // Biar gak kepanjangan

                Tables\Columns\TextColumn::make('category.name') // Tambahkan .name
                    ->label('Kategori')
                    ->badge()
                    ->color(fn ($record) => $record->category?->color ?? 'gray'), // Ambil warna dinamis

                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR')
                    ->weight('bold')
                    ->color(fn (Transaction $record) => $record->type === 'income' ? 'success' : 'danger')
                    ->prefix(fn (Transaction $record) => $record->type === 'income' ? '+ ' : '- '),
            ])
            ->paginated(false)
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton()
                   
                    ->infolist(fn (Infolist $infolist) => TransactionResource::infolist($infolist)), 
            ]);
    }
}