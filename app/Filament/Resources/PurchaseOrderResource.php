<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PurchaseOrderResource\Pages;
use App\Models\PurchaseOrder;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PurchaseOrderResource extends Resource
{
    protected static ?string $model = PurchaseOrder::class;

    protected static ?string $navigationLabel = 'Purchase Order';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Manajemen Produk';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('supplier_id')
                ->relationship('supplier', 'name')
                ->required()
                ->label('Supplier'),

            Select::make('inventory_id')
                ->relationship('inventory', 'item_name')
                ->required()
                ->label('Item'),

            TextInput::make('quantity')
                ->numeric()
                ->required()
                ->minValue(1)
                ->label('Jumlah'),

            Select::make('status')
                ->options([
                    'pending' => 'Pending',
                    'received' => 'Received',
                    'cancelled' => 'Cancelled',
                ])
                ->required()
                ->label('Status'),

            DatePicker::make('order_date')
                ->required()
                ->label('Tanggal Order'),

            DatePicker::make('expected_date')
                ->label('Estimasi Tiba'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('supplier.name')
                    ->label('Supplier')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('inventory.item_name')
                    ->label('Item')
                    ->sortable()
                    ->searchable(),

                TextColumn::make('quantity'),

                TextColumn::make('status')
                    ->badge(),

                TextColumn::make('order_date')
                    ->date()
                    ->label('Order'),

                TextColumn::make('expected_date')
                    ->date()
                    ->label('Estimasi'),
            ])
            ->filters([])
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchaseOrders::route('/'),
            'create' => Pages\CreatePurchaseOrder::route('/create'),
            'edit' => Pages\EditPurchaseOrder::route('/{record}/edit'),
        ];
    }
}
