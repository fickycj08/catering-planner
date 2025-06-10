<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Ambil daftar menu yang sudah terkait dengan paket ini
        $data['menu_data'] = DB::table('package_menu')
            ->where('package_id', $this->record->id)
            ->get()
            ->map(function ($item) {
                return [
                    'menu_id' => $item->menu_id,
                    'quantity' => $item->quantity,
                    'subtotal' => $item->subtotal,
                ];
            })
            ->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['total_price'] = collect($data['menu_data'] ?? [])->sum('subtotal');

        return $data;
    }

    protected function afterSave(): void
    {
        $package = $this->record;
        $menuData = collect($this->data['menu_data'] ?? []);

        // Hapus semua menu lama
        $package->menus()->detach();

        // Tambahkan menu yang baru
        $menuData->each(function ($item) use ($package) {
            if (isset($item['menu_id']) && isset($item['quantity'])) {
                $package->menus()->attach($item['menu_id'], [
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'] ?? 0,
                ]);
            }
        });

        // 🔥 Panggil ulang save untuk memperbarui total_price
        $package->save();
    }
}
