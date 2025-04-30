<?php

namespace App\Filament\Resources\LaporanAnalitikResource\Pages;

use App\Filament\Resources\LaporanAnalitikResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaporanAnalitik extends EditRecord
{
    protected static string $resource = LaporanAnalitikResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
