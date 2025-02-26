<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use App\Models\Menu;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Support\Str;
use Illuminate\Support\Number;

class OrderResource extends Resource
{
    protected static ?string $naggationLabel = 'Orders';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Manajemen Pesanan';
    protected static ?string $modelLabel = 'Orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Section 1: Informasi Utama
                Section::make('Informasi Pesanan')
                    ->icon('heroicon-o-information-circle')
                    ->columns(2)
                    ->schema([
                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->required()
                            ->label('Pelanggan')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->columnSpanFull()
                            ->placeholder('Pilih pelanggan')
                            ->suffixIcon('heroicon-o-user'),

                        Grid::make(2)
                            ->schema([
                                Select::make('event_type')
                                    ->label('Tipe Acara')
                                    ->options([
                                        'Pernikahan' => 'Pernikahan',
                                        'Ulang Tahun' => 'Ulang Tahun',
                                        'Gathering' => 'Gathering',
                                        'Seminar' => 'Seminar',
                                        'Catering Karyawan Pabrik' => 'Catering Karyawan Pabrik',
                                        'Lainnya' => 'Lainnya',
                                    ])
                                    ->live()
                                    ->required()
                                    ->native(false)
                                    ->selectablePlaceholder(false)
                                    ->suffixIcon('heroicon-o-tag'),

                                TextInput::make('custom_event_type')
                                    ->label('Tipe Acara Kustom')
                                    ->hidden(fn($get) => $get('event_type') !== 'Lainnya')
                                    ->required(fn($get) => $get('event_type') === 'Lainnya')
                                    ->placeholder('Masukkan tipe acara custom'),
                            ])
                            ->columnSpanFull(),

                        Select::make('status')
                            ->label('Status Pesanan')
                            ->options([
                                'pending' => 'Pending',
                                'processing' => 'Processing',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('pending')
                            ->required()
                            ->live()
                            ->native(false)

                            ->hiddenOn('create') // Optional: sembunyikan saat create
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                // Section 2: Item Pesanan
                Section::make('Detail Pesanan')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->columns(2)
                    ->schema([
                        Repeater::make('items')
                            ->relationship('items')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        Select::make('menu_id')
                                            ->relationship('menu', 'name')
                                            ->required()
                                            ->label('Menu')
                                            ->live()
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                self::updateSubtotal($state, $set, $get, 'menu');
                                            })
                                            ->searchable()
                                            ->preload()
                                            ->columnSpan(2)
                                            ->placeholder('Pilih menu'),

                                        TextInput::make('quantity')
                                            ->numeric()
                                            ->required()
                                            ->default(1)
                                            ->minValue(1)
                                            ->live()
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                self::updateSubtotal($get('menu_id'), $set, $get, 'menu');
                                            })
                                            ->suffixIcon('heroicon-o-plus'),

                                        TextInput::make('subtotal')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->disabled()
                                            ->dehydrated()
                                            ->label('Subtotal')
                                            ->formatStateUsing(fn($state) => Number::format($state ?? 0, locale: 'id'))
                                            ->columnSpan(1),
                                    ]),
                            ])
                            ->label('Menu')
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => Menu::find($state['menu_id'])?->name ?? 'Menu Baru')
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Menu')
                            ->columns(1),

                        Repeater::make('packages')
                            ->relationship('packages')
                            ->schema([
                                Grid::make(4)
                                    ->schema([
                                        Select::make('package_id')
                                            ->relationship('package', 'name')
                                            ->required()
                                            ->label('Paket')
                                            ->live()
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                self::updateSubtotal($state, $set, $get, 'package');
                                            })
                                            ->searchable()
                                            ->preload()
                                            ->columnSpan(2)
                                            ->placeholder('Pilih paket'),

                                        TextInput::make('quantity')
                                            ->numeric()
                                            ->required()
                                            ->default(1)
                                            ->minValue(1)
                                            ->live()
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                self::updateSubtotal($get('package_id'), $set, $get, 'package');
                                            })
                                            ->suffixIcon('heroicon-o-plus'),

                                        TextInput::make('subtotal')
                                            ->numeric()
                                            ->prefix('Rp')
                                            ->disabled()
                                            ->dehydrated()
                                            ->label('Subtotal')
                                            ->formatStateUsing(fn($state) => Number::format($state ?? 0, locale: 'id'))
                                            ->columnSpan(1),
                                    ]),
                            ])
                            ->label('Paket')
                            ->collapsible()
                            ->itemLabel(fn(array $state): ?string => Package::find($state['package_id'])?->name ?? 'Paket Baru')
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Paket')
                            ->columns(1),
                    ]),

                // Section 3: Total Pembayaran
                Section::make('Total Pembayaran')
                    ->icon('heroicon-o-currency-dollar')
                    ->schema([
                        TextInput::make('total_price')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled()
                            ->dehydrated()
                            ->label('Total Harga')
                            ->default(0)
                            ->formatStateUsing(fn($state) => Number::format($state, locale: 'id'))
                            ->extraAttributes([
                                'class' => 'font-bold text-lg text-primary-600 dark:text-primary-400'
                            ])
                            ->columnSpanFull(),
                    ])
                    ->columns(1)
                    ->collapsible(),
            ]);
    }

    private static function updateSubtotal($id, $set, $get, $type)
    {
        $price = $type === 'menu'
            ? Menu::find($id)?->price ?? 0
            : Package::find($id)?->total_price ?? 0;

        // Tambahkan null coalescing untuk quantity
        $quantity = $get('quantity') ?? 0;
        $subtotal = $price * $quantity;
        $set('subtotal', $subtotal);

        $total = collect($get('../../items'))->sum(fn($item) => $item['subtotal'] ?? 0) +
            collect($get('../../packages'))->sum(fn($item) => $item['subtotal'] ?? 0);


        $set('../../total_price', $total);

        // Auto update status jika total > 0
        if ($total > 0 && $get('../../status') === 'pending') {
            $set('../../status', 'processing');
        }
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->customer->phone ?? '-'),

                TextColumn::make('event_type')
                    ->label('Tipe Acara')
                    ->badge()
                    ->color('primary')
                    ->searchable()
                    ->sortable()
                    ->description(fn($record) => $record->custom_event_type),

                TextColumn::make('total_price')
                    ->label('Total Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->color('success')
                    ->weight('bold'),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'processing',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                    ])
                    ->icons([
                        'pending' => 'heroicon-o-clock',
                        'processing' => 'heroicon-o-arrow-path',
                        'completed' => 'heroicon-o-check-circle',
                        'cancelled' => 'heroicon-o-x-circle',
                    ])
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Processing',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ])
                    ->multiple()
                    ->label('Status Pesanan'),

                SelectFilter::make('event_type')
                    ->options([
                        'Pernikahan' => 'Pernikahan',
                        'Ulang Tahun' => 'Ulang Tahun',
                        'Gathering' => 'Gathering',
                        'Seminar' => 'Seminar',
                        'Catering Karyawan Pabrik' => 'Catering Karyawan Pabrik',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->multiple()
                    ->label('Tipe Acara'),
            ])
            ->actions([
                // Action buttons untuk status
                Tables\Actions\Action::make('process')
                    ->label('Proses Pesanan')
                    ->icon('heroicon-o-arrow-path')
                    ->hidden(fn($record) => $record->status !== 'pending')
                    ->action(fn($record) => $record->markAsProcessing()),

                Tables\Actions\Action::make('complete')
                    ->label('Tandai Selesai')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn($record) => $record->status === 'completed')
                    ->action(fn($record) => $record->completeOrder()),

                Tables\Actions\Action::make('cancel')
                    ->label('Batalkan')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->requiresConfirmation()
                    ->action(fn($record) => $record->cancelOrder()),

                // Edit dan View action
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil-square'),
                Tables\Actions\ViewAction::make()
                    ->icon('heroicon-o-eye'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->icon('heroicon-o-trash'),
                    Tables\Actions\BulkAction::make('markAsCompleted')
                        ->label('Tandai Selesai')
                        ->icon('heroicon-o-check-circle')
                        ->action(fn($records) => $records->each->update(['status' => 'completed'])),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'List' => Pages\ListOrders::route('/{record}'),
        ];
    }
}
