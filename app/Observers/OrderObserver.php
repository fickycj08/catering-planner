<?php

namespace App\Observers;

use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    // app/Observers/OrderObserver.php
    public function updating(Order $order)
    {
        // Auto update tanggal completed
        if ($order->isDirty('status')) {
            switch ($order->status) {
                case 'processing':
                    // Logic ketika masuk ke processing
                    break;

                case 'completed':
                    $order->completed_at = now();
                    break;

                case 'cancelled':
                    // Logic pembatalan
                    break;
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
