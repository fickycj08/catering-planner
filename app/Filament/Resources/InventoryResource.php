<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InventoryResource\Pages;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Model;

class InventoryResource extends Resource
{
    // 1. Jangan tampilkan di sidebar
    protected static bool $shouldRegisterNavigation = false;

    // (opsional) tetap simpan label dsb jika nanti mau di-undo
    protected static ?string $navigationLabel = 'Inventaris';
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationGroup = 'Manajemen Produk';

    // 2. Tolak semua permission
    public static function canViewAny(): bool
    {
        return false;
    }

    public static function canView(Model $record): bool
    {
        return false;
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }

    // 3. Kosongkan form (tidak ada field)
    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    // 3. Kosongkan table (tanpa kolom, tanpa action)
    public static function table(Table $table): Table
    {
        return $table
            ->columns([])
            ->actions([])
            ->bulkActions([]);
    }

    // 4. Hilangkan semua page routes
    public static function getPages(): array
    {
        return [
            // Index, Create, Edit di-disable dengan mengosongkan routes
        ];
    }
}
