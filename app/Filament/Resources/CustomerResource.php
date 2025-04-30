<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;


class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationLabel = 'Pelanggan';
    protected static ?int $navigationSort = 2;
    
    protected static ?string $navigationGroup = 'Manajemen Pesanan';
    


    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->label('Nama Customer'),
    
            TextInput::make('email')
                ->email()
                ->required()
                ->unique(),
    
            TextInput::make('phone')
                ->required()
                ->label('Nomor HP'),
    
            Textarea::make('address')
                ->required()
                ->label('Alamat'),
        ]);
    }
    

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')
                ->label('Nama')
                ->sortable()
                ->searchable(),

            TextColumn::make('email')
                ->label('Email')
                ->sortable()
                ->searchable(),

            TextColumn::make('phone')
                ->label('Nomor HP')
                ->sortable()
                ->searchable(),

            TextColumn::make('address')
                ->label('Alamat')
                ->limit(30) // Batas panjang tampilan alamat
                ->tooltip(fn ($record) => $record->address), // Tooltip jika teks terlalu panjang

            TextColumn::make('created_at')
                ->label('Dibuat Pada')
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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
