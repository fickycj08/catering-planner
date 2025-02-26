<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SubscriptionResource\Pages;
use App\Models\Subscription;
use App\Models\Package;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;
    protected static ?string $navigationLabel = 'Subscription';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Manajemen Pesanan';
    protected static ?string $modelLabel = 'Subscription';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Pelanggan')
                    ->schema([
                        Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->required()
                            ->label('Pelanggan')
                            ->searchable()
                            ->preload()
                            ->native(false)
                            ->placeholder('Pilih pelanggan')
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->collapsible(),
                
                Section::make('Detail Langganan')
                    ->schema([
                        Grid::make(3)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->required()
                                    ->label('Tanggal Mulai')
                                    ->native(false)
                                    ->displayFormat('d M Y'),
                                
                                DatePicker::make('end_date')
                                    ->required()
                                    ->label('Tanggal Berakhir')
                                    ->native(false)
                                    ->displayFormat('d M Y')
                                    ->minDate(fn ($get) => $get('start_date')),
                                
                                ToggleButtons::make('status')
                                    ->options([
                                        'Aktif' => 'Aktif',
                                        'Nonaktif' => 'Nonaktif',
                                    ])
                                    ->icons([
                                        'Aktif' => 'heroicon-o-check-circle',
                                        'Nonaktif' => 'heroicon-o-x-circle',
                                    ])
                                    ->colors([
                                        'Aktif' => 'success',
                                        'Nonaktif' => 'danger',
                                    ])
                                    ->inline()
                                    ->required(),
                            ]),
                    ])
                    ->collapsible(),
                
                Section::make('Paket Langganan')
                    ->schema([
                        Repeater::make('packages')
                            ->schema([
                                Grid::make(3)
                                    ->schema([
                                        Select::make('package_id')
                                            ->label('Paket')
                                            ->options(Package::getOptions())
                                            ->required()
                                            ->live()
                                            ->searchable()
                                            ->placeholder('Cari paket...')
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                self::updatePackagePrice($state, $set, $get);
                                            }),
                                        
                                        TextInput::make('quantity')
                                            ->numeric()
                                            ->required()
                                            ->default(1)
                                            ->minValue(1)
                                            ->live()
                                            ->afterStateUpdated(function ($state, $set, $get) {
                                                self::updatePackagePrice($get('package_id'), $set, $get);
                                            })
                                            ->label('Jumlah'),
                                        
                                        TextInput::make('subtotal')
                                            ->numeric()
                                            ->disabled()
                                            ->dehydrated()
                                            ->prefix('Rp')
                                            ->label('Subtotal')
                                            ->hintAction(
                                                Forms\Components\Actions\Action::make('hitungUlang')
                                                    ->icon('heroicon-o-arrow-path')
                                                    ->action(function ($set, $get) {
                                                        self::updatePackagePrice($get('package_id'), $set, $get);
                                                    })
                                            ),
                                    ]),
                            ])
                            ->label('Daftar Paket')
                            ->live()
                            ->defaultItems(1)
                            ->addActionLabel('Tambah Paket')
                            ->columns(1)
                            ->columnSpanFull()
                            ->itemLabel(fn (array $state): ?string => Package::find($state['package_id'])?->name ?? 'Paket Baru'),
                        
                        Forms\Components\Placeholder::make('total_price_info')
                            ->content(fn ($get) => 'Total Harga: Rp ' . number_format($get('total_price'), 0, ',', '.'))
                            ->visible(fn ($get) => $get('total_price') > 0),
                        
                        TextInput::make('total_price')
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->prefix('Rp')
                            ->label('Total Harga Langganan')
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->columns(1),
            ]);
    }

    private static function updatePackagePrice($packageId, $set, $get)
    {
        $price = Package::find($packageId)?->total_price ?? 0;
        $quantity = $get('quantity') ?? 1;
        $subtotal = $price * $quantity;
        $set('subtotal', $subtotal);
        
        // Update total price
        $packages = $get('../packages') ?? [];
        $total = collect($packages)->sum(fn($pkg) => $pkg['subtotal'] ?? 0);
        $set('total_price', $total);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')
                    ->label('Pelanggan')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('total_price')
                    ->money('IDR', locale: 'id')
                    ->label('Total Harga')
                    ->sortable()
                    ->color('success'),
                
                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'Aktif',
                        'danger' => 'Nonaktif',
                    ])
                    ->icons([
                        'Aktif' => 'heroicon-o-check-circle',
                        'Nonaktif' => 'heroicon-o-x-circle',
                    ])
                    ->iconPosition('after'),
                
                    TextColumn::make('start_date')
                    ->label('Mulai')
                    ->date('d M Y')
                    ->sortable(),
                
                
                    TextColumn::make('end_date')
                    ->label('Berakhir')
                    ->date('d M Y')
                    ->sortable()
                    ->color(function ($record) {
                        // Perbaikan: Gunakan Carbon instance dari casted date
                        return now()->gt($record->end_date) ? 'danger' : 'success';
                    })
                
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'Aktif' => 'Aktif',
                        'Nonaktif' => 'Nonaktif',
                    ])
                    ->native(false),
                
                Tables\Filters\Filter::make('periode_aktif')
                    ->form([
                        DatePicker::make('start_date')
                            ->label('Dari Tanggal'),
                        DatePicker::make('end_date')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('start_date', '>=', $date),
                            )
                            ->when(
                                $data['end_date'],
                                fn (Builder $query, $date): Builder => $query->whereDate('end_date', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->iconButton()
                    ->tooltip('Edit'),
                
                Tables\Actions\Action::make('perpanjang')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->tooltip('Perpanjang Langganan')
                    ->visible(fn ($record) => $record->status === 'Aktif'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->requiresConfirmation()
                        ->modalHeading('Hapus Langganan')
                        ->modalDescription('Yakin ingin menghapus langganan yang dipilih?'),
                ]),
            ])
            ->emptyStateHeading('Belum ada langganan')
            ->emptyStateDescription('Klik tombol dibawah untuk membuat langganan baru')
            ->emptyStateIcon('heroicon-o-document-text')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Buat Langganan Baru')
                    ->icon('heroicon-o-plus'),
            ])
            ->defaultSort('start_date', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSubscriptions::route('/'),
            'create' => Pages\CreateSubscription::route('/create'),
            'edit' => Pages\EditSubscription::route('/{record}/edit'),
        ];
    }
}
