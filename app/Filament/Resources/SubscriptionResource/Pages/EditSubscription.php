<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use App\Filament\Resources\SubscriptionResource;
use Filament\Resources\Pages\EditRecord;

class EditSubscription extends EditRecord
{
    protected static string $resource = SubscriptionResource::class;

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // 🔥 Ambil semua paket langganan yang sudah ada dari pivot table
        $subscription = $this->getRecord();
        $data['packages'] = $subscription->packages->map(function ($package) {
            return [
                'package_id' => $package->id,
                'quantity' => $package->pivot->quantity,
                'subtotal' => $package->pivot->subtotal,
            ];
        })->toArray();

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // 🔥 Hitung ulang total harga sebelum menyimpan perubahan
        $data['total_price'] = collect($data['packages'] ?? [])->sum('subtotal');

        return $data;
    }

    protected function afterSave(): void
    {
        $subscription = $this->record;
        $packageData = collect($this->data['packages'] ?? []);

        $subscription->packages()->detach();

        $packageData->each(function ($item) use ($subscription) {
            if (isset($item['package_id']) && isset($item['quantity'])) {
                $subscription->packages()->attach($item['package_id'], [
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'] ?? 0,
                ]);
            }
        });

        // 🔥 Panggil recalculate setelah update
        $subscription->recalculateTotalPrice();
    }
}
