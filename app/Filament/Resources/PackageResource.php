<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Models\Package;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static ?string $navigationLabel = 'Paket Catering';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationGroup = 'Manajemen Catering';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->label('Nama Paket'),

                TextInput::make('description')
                    ->label('Deskripsi Paket'),

                // 🔥 Repeater untuk menampilkan menu yang sudah dipilih sebelumnya
                Repeater::make('menu_data')
                    ->schema([
                        Select::make('menu_id')
                            ->label('Pilih Menu')
                            ->options(\App\Models\Menu::all()->pluck('name', 'id'))
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                if ($state) {
                                    $menu = \App\Models\Menu::find($state);
                                    $quantity = $get('quantity') ?? 1;
                                    $subtotal = $menu ? $menu->price * $quantity : 0;
                                    $set('subtotal', $subtotal);
                                }
                            }),

                        TextInput::make('quantity')
                            ->numeric()
                            ->required()
                            ->default(1)
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $menuId = $get('menu_id');
                                if ($menuId) {
                                    $menu = \App\Models\Menu::find($menuId);
                                    $subtotal = $menu ? $menu->price * $state : 0;
                                    $set('subtotal', $subtotal);
                                }
                            })
                            ->label('Jumlah'),

                        TextInput::make('subtotal')
                            ->numeric()
                            ->disabled()
                            ->label('Subtotal Menu'),
                    ])
                    ->label('Menu dalam Paket')
                    ->columns(3)
                    ->reactive()
                    ->defaultItems(0),

                TextInput::make('total_price')
                    ->disabled()
                    ->label('Total Harga Paket')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Paket')
                    ->searchable(),
                TextColumn::make('total_price')
                    ->label('Harga Paket')
                    ->money('IDR'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
