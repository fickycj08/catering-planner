<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use App\Filament\Resources\InventoryResource\RelationManagers;
use App\Models\Inventory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\NumberInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryResource extends Resource
{
    protected static ?string $navigationLabel = 'Inventaris';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Manajemen Produk';


    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('item_name')
                ->required()
                ->label('Nama Item'),

            TextInput::make('quantity')
                ->required()
                ->label('Jumlah')
                ->numeric()
                ->minValue(0),

            TextInput::make('unit')
                ->required()
                ->label('Satuan'),

            Select::make('supplier_id')
                ->relationship('supplier', 'name')
                ->nullable()
                ->label('Supplier'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('item_name')
                ->label('Nama Item')
                ->sortable()
                ->searchable(),

            TextColumn::make('quantity')
                ->label('Jumlah')
                ->sortable(),

            TextColumn::make('unit')
                ->label('Satuan')
                ->sortable(),

            TextColumn::make('supplier.name')
                ->label('Supplier')
                ->sortable()
                ->placeholder('Tanpa Supplier'),

            TextColumn::make('last_updated')
                ->label('Terakhir Diperbarui')
                ->dateTime()
                ->sortable(),
        ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListInventories::route('/'),
            'create' => Pages\CreateInventory::route('/create'),
            'edit' => Pages\EditInventory::route('/{record}/edit'),
        ];
    }
}
