<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\CategoryResource\Pages;
use App\Filament\App\Resources\CategoryResource\RelationManagers;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
{
    return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            
            Forms\Components\Select::make('type')
                ->options([
                    'income' => 'Pemasukan',
                    'expense' => 'Pengeluaran',
                ])
                ->required(),

            Forms\Components\ColorPicker::make('color')
                ->label('Warna Label'),
                
            Forms\Components\Hidden::make('user_id')
                ->default(fn () => auth()->id()),
        ]);
}

public static function table(Table $table): Table
{
    return $table
        ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->id()))
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->searchable(),
            Tables\Columns\BadgeColumn::make('type')
                ->colors([
                    'success' => 'income',
                    'danger' => 'expense',
                ]),
            Tables\Columns\ColorColumn::make('color'),
        ])
        ->actions([
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
