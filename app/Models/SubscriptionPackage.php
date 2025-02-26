<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    use HasFactory;

    protected $table = 'subscription_package';

    protected $fillable = ['subscription_id', 'package_id', 'quantity', 'subtotal'];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    protected static function booted()
    {
        static::saving(function ($subscriptionPackage) {
            $subscriptionPackage->subtotal = $subscriptionPackage->package->total_price * $subscriptionPackage->quantity;
        });

        // Tambahkan event untuk update total_price di Subscription
        static::saved(function ($subscriptionPackage) {
            if ($subscriptionPackage->subscription) {
                $subscriptionPackage->subscription->recalculateTotalPrice();
            }
        });

        static::deleted(function ($subscriptionPackage) {
            if ($subscriptionPackage->subscription) {
                $subscriptionPackage->subscription->recalculateTotalPrice();
            }
        });
    }
}
