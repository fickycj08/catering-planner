<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'menu_id', 'quantity', 'subtotal'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    protected static function booted()
    {
        static::saving(function ($item) {
            $item->subtotal = $item->menu->price * $item->quantity;
        });

        // Tambahkan event untuk update Order setelah perubahan
        static::saved(function ($item) {
            if ($item->order) {
                $item->order->recalculateTotalPrice();
            }
        });

        static::deleted(function ($item) {
            if ($item->order) {
                $item->order->recalculateTotalPrice();
            }
        });
    }
}