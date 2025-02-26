<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'total_price', 'status', 'start_date', 'end_date'];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'subscription_package')
                    ->withPivot('quantity', 'subtotal')
                    ->withTimestamps();
    }

    protected static function booted()
    {
        static::saving(function ($subscription) {
            $totalPrice = $subscription->packages->sum(fn($pkg) => $pkg->pivot->subtotal);
            $subscription->total_price = $totalPrice;
        });
    }
    public function recalculateTotalPrice()
    {
        $this->total_price = $this->packages()->sum('subscription_package.subtotal');
        $this->saveQuietly(); // Simpan tanpa memicu event
    }
}
