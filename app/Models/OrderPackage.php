<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderPackage extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'package_id', 'quantity', 'subtotal'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    protected static function booted()
    {
        static::saving(function ($orderPackage) {
            $orderPackage->subtotal = $orderPackage->package->total_price * $orderPackage->quantity;
        });

        // Tambahkan event untuk update Order setelah perubahan
        static::saved(function ($orderPackage) {
            if ($orderPackage->order) {
                $orderPackage->order->recalculateTotalPrice();
            }
        });

        static::deleted(function ($orderPackage) {
            if ($orderPackage->order) {
                $orderPackage->order->recalculateTotalPrice();
            }
        });
    }
}