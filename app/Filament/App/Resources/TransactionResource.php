<?php

namespace App\Filament\App\Resources;

use App\Filament\App\Resources\TransactionResource\Pages;
use App\Models\Transaction;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Group;
use Illuminate\Database\Eloquent\Builder;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Transactions';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Input Transaksi')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Transaksi')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Beli Nasi Padang'),

                        // 1. KATEGORI (JADI YANG PERTAMA & UTAMA)
                        Forms\Components\Select::make('category_id')
                            ->label('Kategori')
                            ->relationship('category', 'name', function (Builder $query) {
                                // Tampilkan semua kategori milik user
                                return $query->where('user_id', auth()->id());
                            })
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live() // Wajib live agar bisa update field lain
                            ->afterStateUpdated(function (Set $set, $state) {
                                // LOGIKA OTOMATIS:
                                // Begitu kategori dipilih, langsung cari Tipe-nya di database
                                if ($state) {
                                    $category = \App\Models\Category::find($state);
                                    if ($category) {
                                        // Isi field Type sesuai kategori
                                        $set('type', $category->type);
                                    }
                                }
                            })
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label('Nama Kategori'),
                                
                                // Saat buat kategori, pilih jenisnya disini
                                Forms\Components\Select::make('type')
                                    ->label('Jenis Kategori')
                                    ->options([
                                        'income' => 'Pemasukan',
                                        'expense' => 'Pengeluaran',
                                    ])
                                    ->required(),
                                    
                                // WARNA DIHAPUS DARI FORM (Akan di-set otomatis di background)
                                
                                Forms\Components\Hidden::make('user_id')
                                    ->default(fn () => auth()->id()),
                            ])
                            ->createOptionUsing(function (array $data) {
                                $data['user_id'] = auth()->id();
                                
                                // LOGIKA WARNA OTOMATIS
                                // Jika Income -> Hijau, Jika Expense -> Merah
                                if ($data['type'] === 'income') {
                                    $data['color'] = '#10b981'; // Emerald-500 (Hijau)
                                } else {
                                    $data['color'] = '#ef4444'; // Red-500 (Merah)
                                }

                                $category = \App\Models\Category::create($data);
                                return $category->id;
                            }),

                        // 2. JENIS (OTOMATIS TERISI & READ ONLY)
                        Forms\Components\Select::make('type')
                            ->label('Jenis')
                            ->options([
                                'income' => 'Pemasukan',
                                'expense' => 'Pengeluaran',
                            ])
                            ->required()
                            ->disabled() // User GABOLEH ubah manual
                            ->dehydrated(), // PENTING: Agar data tetap tersimpan ke database meski disabled

                        Forms\Components\TextInput::make('amount')
                            ->label('Nominal')
                            ->prefix('Rp')
                            ->numeric()
                            ->required(),

                        Forms\Components\DatePicker::make('date')
                            ->label('Tanggal')
                            ->required()
                            ->default(now()),

                        Forms\Components\FileUpload::make('image')
                            ->label('Bukti / Struk')
                            ->image()
                            ->disk('public')
                            ->directory('transactions')
                            ->visibility('public')
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('note')
                            ->label('Catatan Tambahan')
                            ->columnSpanFull(),

                        Forms\Components\Hidden::make('user_id')
                            ->default(fn () => auth()->id()),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->where('user_id', auth()->id()))
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->description(fn (Transaction $record) => $record->note ? \Illuminate\Support\Str::limit($record->note, 20) : null),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn ($record) => $record->category?->color ?? 'gray')
                    ->searchable(),

                Tables\Columns\TextColumn::make('type')
                    ->label('Jenis')
                    ->badge()
                    ->colors([
                        'success' => 'income',
                        'danger' => 'expense',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    }),

                Tables\Columns\TextColumn::make('amount')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable()
                    ->weight('bold')
                    ->color(fn (Transaction $record) => $record->type === 'income' ? 'success' : 'danger'),

                Tables\Columns\ImageColumn::make('image')
                    ->label('Bukti')
                    ->disk('public')
                    ->circular(),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Filter Jenis')
                    ->options([
                        'income' => 'Pemasukan',
                        'expense' => 'Pengeluaran',
                    ]),
                Tables\Filters\Filter::make('date')
                    ->form([
                        Forms\Components\DatePicker::make('from')->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('until')->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'], fn (Builder $query, $date) => $query->whereDate('date', '>=', $date))
                            ->when($data['until'], fn (Builder $query, $date) => $query->whereDate('date', '<=', $date));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                \pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction::make()
                    ->label('Export Terpilih'),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('Detail Transaksi')
                    ->icon('heroicon-m-information-circle')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama Transaksi')
                            ->weight('bold'),
                        
                        TextEntry::make('date')
                            ->label('Tanggal')
                            ->date('d F Y')
                            ->icon('heroicon-m-calendar'),

                        TextEntry::make('amount')
                            ->label('Nominal')
                            ->money('IDR')
                            ->color('success')
                            ->size(TextEntry\TextEntrySize::Large)
                            ->weight('bold'),

                        TextEntry::make('type')
                            ->label('Jenis')
                            ->badge()
                            ->colors([
                                'success' => 'income',
                                'danger' => 'expense',
                            ]),

                        TextEntry::make('category.name')
                            ->label('Kategori')
                            ->badge()
                            ->color(fn ($record) => $record->category?->color ?? 'gray'),

                        TextEntry::make('note')
                            ->label('Catatan')
                            ->placeholder('Tidak ada catatan')
                            ->columnSpanFull(),
                    ])->columnSpan(2),

                Group::make([
                    Section::make('Bukti Gambar')
                        ->icon('heroicon-m-photo')
                        ->schema([
                            ImageEntry::make('image')
                                ->hiddenLabel()
                                ->disk('public')
                                ->visibility('public')
                                ->height(200)
                                ->extraImgAttributes([
                                    'class' => 'rounded-lg object-cover w-full',
                                ]),
                        ]),
                ])->columnSpan(1),
            ])->columns(3);
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