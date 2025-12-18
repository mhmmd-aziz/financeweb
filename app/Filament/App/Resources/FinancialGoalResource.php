<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\FinancialGoalResource\Pages;
use App\Filament\App\Resources\FinancialGoalResource\RelationManagers;
use App\Models\FinancialGoal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Split;

class FinancialGoalResource extends Resource
{
    protected static ?string $model = FinancialGoal::class;

    protected static ?int $navigationSort = 3;
    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\Section::make('Target Impian')
                ->description('Masukkan barang atau tujuan yang ingin dicapai')
                ->schema([
                    Forms\Components\TextInput::make('title')->required(),
                    Forms\Components\TextInput::make('target_amount')->numeric()->prefix('Rp')->required(),
                    Forms\Components\TextInput::make('current_amount')->numeric()->prefix('Rp')->default(0),
                    Forms\Components\DatePicker::make('target_date'),
                    Forms\Components\FileUpload::make('image')
                        ->image()
                        ->avatar() // Biar bulat/kecil
                        ->directory('goals'),
                    Forms\Components\Hidden::make('user_id')
                        ->default(fn () => auth()->id()),
                ])
        ]);
}

public static function infolist(Infolist $infolist): Infolist
{
    return $infolist
        ->schema([
            Section::make('Target Impian')
                ->schema([
                    Split::make([
                        // Bagian Kiri: Gambar
                        ImageEntry::make('image')
                            ->hiddenLabel()
                            ->disk('public')
                            ->width(200)
                            ->height(200)
                            ->circular(), // Gambar bulat besar
                        
                        // Bagian Kanan: Data
                        Section::make()
                            ->schema([
                                TextEntry::make('title')
                                    ->label('Nama Target')
                                    ->size(TextEntry\TextEntrySize::Large)
                                    ->weight('bold'),
                                
                                TextEntry::make('target_date')
                                    ->label('Tenggat Waktu')
                                    ->date('d F Y')
                                    ->color('danger'),

                                TextEntry::make('target_amount')
                                    ->label('Harga Target')
                                    ->money('IDR'),
                                
                                TextEntry::make('current_amount')
                                    ->label('Tabungan Terkumpul')
                                    ->money('IDR')
                                    ->color('primary'),
                                
                                TextEntry::make('progress')
                                    ->label('Progress Saat Ini')
                                    ->state(fn ($record) => $record->progress . '%') // Ambil dari model accessor
                                    ->badge()
                                    ->color(fn ($state) => intval($state) >= 100 ? 'success' : 'warning'),
                            ])->grow(), // Mengisi sisa ruang
                    ])->from('md'), // Split layout aktif di layar medium ke atas
            ]),
        ]);
}

    public static function table(Table $table): Table
{
    return $table
        ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->id()))
        ->columns([
            Tables\Columns\ImageColumn::make('image')->circular(),
            Tables\Columns\TextColumn::make('title')->searchable(),
            Tables\Columns\TextColumn::make('target_amount')->money('IDR'),
            Tables\Columns\TextColumn::make('current_amount')->money('IDR'),
            // Progress Bar Custom
            Tables\Columns\TextColumn::make('progress')
                ->label('Progress')
                ->suffix('%')
                ->getStateUsing(fn ($record) => $record->progress),
        ])

        ->actions([
    Tables\Actions\ViewAction::make(), // <--- TAMBAHKAN INI
    Tables\Actions\EditAction::make(),
    Tables\Actions\DeleteAction::make(),
        ]);
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
            'index' => Pages\ListFinancialGoals::route('/'),
            'create' => Pages\CreateFinancialGoal::route('/create'),
            'edit' => Pages\EditFinancialGoal::route('/{record}/edit'),
        ];
    }
}
