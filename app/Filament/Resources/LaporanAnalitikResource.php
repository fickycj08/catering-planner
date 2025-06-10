<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanAnalitikResource\Pages;
use App\Models\LaporanAnalitik;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LaporanAnalitikResource extends Resource
{
    protected static ?string $model = LaporanAnalitik::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListLaporanAnalitiks::route('/'),
            'create' => Pages\CreateLaporanAnalitik::route('/create'),
            'edit' => Pages\EditLaporanAnalitik::route('/{record}/edit'),
        ];
    }
}
