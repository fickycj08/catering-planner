<?php

namespace App\Filament\Resources\SubscriptionResource\Pages;

use App\Filament\Resources\SubscriptionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubscription extends CreateRecord
{
    protected static string $resource = SubscriptionResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['total_price'] = collect($data['packages'] ?? [])->sum('subtotal');

        return $data;
    }

    protected function afterCreate(): void
    {
        $subscription = $this->record;
        $packageData = collect($this->data['packages'] ?? []);

        $packageData->each(function ($item) use ($subscription) {
            if (isset($item['package_id']) && isset($item['quantity'])) {
                $subscription->packages()->attach($item['package_id'], [
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['subtotal'] ?? 0,
                ]);
            }
        });

        // 🔥 Panggil recalculate setelah attach
        $subscription->recalculateTotalPrice();
    }
}
