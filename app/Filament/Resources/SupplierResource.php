<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SupplierResource\Pages;
use App\Models\Supplier;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\IconPosition;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class SupplierResource extends Resource
{
    protected static ?string $model = Supplier::class;

    protected static ?string $navigationLabel = 'Supplier';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationGroup = 'Manajemen Produk';

    protected static ?string $recordTitleAttribute = 'name';

    protected static int $globalSearchResultsLimit = 5;

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'success' : 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Supplier Information')
                    ->tabs([
                        Tabs\Tab::make('Informasi Dasar')
                            ->icon('heroicon-o-information-circle')
                            ->schema([
                                Section::make('Detail Supplier')
                                    ->description('Masukkan informasi dasar supplier')
                                    ->collapsible()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('name')
                                                    ->required()
                                                    ->label('Nama Supplier')
                                                    ->placeholder('PT. Supplier Indonesia')
                                                    ->maxLength(100),

                                                TextInput::make('company_code')
                                                    ->required()
                                                    ->unique(ignoreRecord: true)
                                                    ->label('Kode Perusahaan')
                                                    ->placeholder('SUP-001'),

                                                Select::make('supplier_type')
                                                    ->required()
                                                    ->label('Jenis Supplier')
                                                    ->options([
                                                        'bahan_baku' => 'Bahan Baku',
                                                        'kemasan' => 'Kemasan',
                                                        'peralatan' => 'Peralatan',
                                                        'jasa' => 'Jasa',
                                                        'lainnya' => 'Lainnya',
                                                    ])
                                                    ->default('bahan_baku'),

                                                Select::make('status')
                                                    ->required()
                                                    ->label('Status')
                                                    ->options([
                                                        'aktif' => 'Aktif',
                                                        'tidak_aktif' => 'Tidak Aktif',
                                                        'blacklist' => 'Blacklist',
                                                    ])
                                                    ->default('aktif'),
                                            ]),
                                    ]),
                            ]),

                        Tabs\Tab::make('Kontak & Alamat')
                            ->icon('heroicon-o-phone')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('contact_person')
                                            ->required()
                                            ->label('Nama Kontak Person')
                                            ->placeholder('John Doe'),

                                        TextInput::make('contact')
                                            ->required()
                                            ->label('Nomor Telepon')
                                            ->tel()
                                            ->placeholder('08123456789'),

                                        TextInput::make('email')
                                            ->email()
                                            ->label('Email')
                                            ->placeholder('supplier@example.com'),

                                        TextInput::make('website')
                                            ->url()
                                            ->label('Website')
                                            ->placeholder('https://www.supplier.com'),
                                    ]),

                                Textarea::make('address')
                                    ->required()
                                    ->label('Alamat Lengkap')
                                    ->placeholder('Jl. Supplier No. 123, Jakarta')
                                    ->rows(3),

                                Grid::make(3)
                                    ->schema([
                                        TextInput::make('city')
                                            ->label('Kota')
                                            ->placeholder('Jakarta'),

                                        TextInput::make('province')
                                            ->label('Provinsi')
                                            ->placeholder('DKI Jakarta'),

                                        TextInput::make('postal_code')
                                            ->label('Kode Pos')
                                            ->placeholder('12345'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Informasi Bisnis')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('npwp')
                                            ->label('NPWP')
                                            ->placeholder('00.000.000.0-000.000'),

                                        TextInput::make('bank_name')
                                            ->label('Nama Bank')
                                            ->placeholder('Bank XYZ'),

                                        TextInput::make('bank_account')
                                            ->label('Nomor Rekening')
                                            ->placeholder('1234567890'),

                                        TextInput::make('bank_account_name')
                                            ->label('Nama Pemilik Rekening')
                                            ->placeholder('PT. Supplier Indonesia'),

                                        Select::make('payment_terms')
                                            ->label('Termin Pembayaran')
                                            ->options([
                                                'cod' => 'Cash On Delivery',
                                                'net7' => 'NET 7',
                                                'net14' => 'NET 14',
                                                'net30' => 'NET 30',
                                                'net60' => 'NET 60',
                                            ]),

                                        DatePicker::make('contract_start_date')
                                            ->label('Tanggal Mulai Kontrak'),
                                    ]),
                            ]),

                        Tabs\Tab::make('Dokumen & Catatan')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                FileUpload::make('documents')
                                    ->label('Dokumen Pendukung')
                                    ->multiple()
                                    ->directory('supplier-documents')
                                    ->maxFiles(5)
                                    ->acceptedFileTypes(['application/pdf', 'image/*']),

                                Textarea::make('notes')
                                    ->label('Catatan')
                                    ->placeholder('Catatan tambahan tentang supplier')
                                    ->rows(3),
                            ]),
                    ])
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('company_code')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('name')
                    ->label('Nama Supplier')
                    ->sortable()
                    ->searchable()
                    ->weight(FontWeight::Bold)
                    ->description(fn ($record) => $record->supplier_type ? ucfirst(str_replace('_', ' ', $record->supplier_type)) : ''),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'aktif',
                        'danger' => 'blacklist',
                        'warning' => 'tidak_aktif',
                    ])
                    ->formatStateUsing(fn ($state) => ucfirst(str_replace('_', ' ', $state))),

                TextColumn::make('contact_person')
                    ->label('Kontak Person')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('contact')
                    ->label('Nomor Telepon')
                    ->icon('heroicon-o-phone')
                    ->iconPosition(IconPosition::Before)
                    ->searchable()
                    ->copyable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->icon('heroicon-o-envelope')
                    ->iconPosition(IconPosition::Before)
                    ->toggleable()
                    ->copyable(),

                TextColumn::make('address')
                    ->label('Alamat')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->address)
                    ->toggleable(),

                TextColumn::make('city')
                    ->label('Kota')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Diperbarui Pada')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('supplier_type')
                    ->label('Jenis Supplier')
                    ->options([
                        'bahan_baku' => 'Bahan Baku',
                        'kemasan' => 'Kemasan',
                        'peralatan' => 'Peralatan',
                        'jasa' => 'Jasa',
                        'lainnya' => 'Lainnya',
                    ]),

                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'aktif' => 'Aktif',
                        'tidak_aktif' => 'Tidak Aktif',
                        'blacklist' => 'Blacklist',
                    ]),

                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dibuat dari'),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Dibuat sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->color('info'),
                Tables\Actions\EditAction::make()
                    ->color('warning'),
                Tables\Actions\DeleteAction::make()
                    ->color('danger'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\BulkAction::make('updateStatus')
                        ->label('Update Status')
                        ->icon('heroicon-o-check-circle')
                        ->form([
                            Select::make('status')
                                ->label('Status Baru')
                                ->options([
                                    'aktif' => 'Aktif',
                                    'tidak_aktif' => 'Tidak Aktif',
                                    'blacklist' => 'Blacklist',
                                ])
                                ->required(),
                        ])
                        ->action(function (Collection $records, array $data): void {
                            foreach ($records as $record) {
                                $record->status = $data['status'];
                                $record->save();
                            }
                        })
                        ->deselectRecordsAfterCompletion(),
                    Tables\Actions\BulkAction::make('exportSelected')
                        ->label('Export Selected')
                        ->icon('heroicon-o-document-arrow-down')
                        ->action(function (Collection $records): void {
                            // Logika untuk export data
                        }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [

        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuppliers::route('/'),
            'create' => Pages\CreateSupplier::route('/create'),

            'edit' => Pages\EditSupplier::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'company_code', 'contact', 'email', 'address', 'city'];
    }
}
