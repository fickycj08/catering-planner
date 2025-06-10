<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;

class PaymentProof extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected static string $view = 'filament.resources.order-resource.pages.payment-proof';

    public function mount($record): void
    {
        parent::mount($record); // penting: jalankan parent::mount

        if (! $this->record?->payment_proof) {
            abort(404, 'Bukti Pembayaran tidak ditemukan.');
        }
    }

    public function getPaymentProofUrlProperty(): string
    {
        return Storage::url($this->record->payment_proof);
    }
}
