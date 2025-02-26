<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePackage extends CreateRecord
{
    protected static string $resource = PackageResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['total_price'] = collect($data['menu_data'] ?? [])->sum('subtotal');
        return $data;
    }

    protected function afterCreate(): void
    {
        $package = $this->record;
        $menuData = collect($this->data['menu_data'] ?? []);
        
        $menuData->each(function ($item) use ($package) {
            if (isset($item['menu_id']) && isset($item['quantity'])) {
                $package->menus()->attach($item['menu_id'], [
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'] ?? 0,
                ]);
            }
        });
         // 🔥 Panggil ulang save untuk memicu event `saved()` di model
         $package->save();
    }
}
