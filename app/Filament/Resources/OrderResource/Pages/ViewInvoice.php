<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page; // Import trait

class ViewInvoice extends Page
{
    use InteractsWithRecord; // Gunakan trait untuk mendapatkan method resolveRecord

    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.resources.order-resource.pages.view-invoice';

    public function mount(int|string $record): void
    {
        $this->record = $this->resolveRecord($record);
    }
}
