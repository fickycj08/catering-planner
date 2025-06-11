<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffResource\Pages;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;


class StaffResource extends Resource
{
    protected static ?string $navigationLabel = 'Karyawan';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationGroup = 'Manajemen Karyawan';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->label('Nama Staff'),

            TextInput::make('phone')
                ->required()
                ->label('Nomor HP')
                ->tel(),

            Select::make('position')
    ->label('Posisi')
    ->options([
        'Chef' => 'Chef',
        'Assistant Chef' => 'Assistant Chef',
        'Kitchen Staff' => 'Kitchen Staff',
        'Server' => 'Server',
        'Cashier' => 'Cashier',
        'Administration' => 'Administration',
        'Manager' => 'Manager',
        'Other' => 'Lainnya',
    ])
    ->required(),


        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->label('Nama Staff')
                ->sortable()
                ->searchable(),

            TextColumn::make('phone')
                ->label('Nomor HP')
                ->sortable()
                ->searchable(),

            TextColumn::make('position')
                ->label('Posisi')
                ->sortable(),

            TextColumn::make('order.event_type')
                ->label('Pesanan Ditugaskan')
                ->sortable()
                ->placeholder('Belum ditugaskan'),

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
            'index' => Pages\ListStaff::route('/'),
            'create' => Pages\CreateStaff::route('/create'),
            'edit' => Pages\EditStaff::route('/{record}/edit'),
        ];
    }
}
