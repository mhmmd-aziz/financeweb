<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            // Tampilkan Nama User Pemilik Transaksi
            Tables\Columns\TextColumn::make('user.name')
                ->label('User')
                ->searchable()
                ->sortable(),
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\BadgeColumn::make('type')
                ->colors([
                    'success' => 'income',
                    'danger' => 'expense',
                ]),
            Tables\Columns\TextColumn::make('amount')->money('IDR'),
            Tables\Columns\TextColumn::make('date')->date(),
        ])
        ->defaultSort('date', 'desc');
}

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}
