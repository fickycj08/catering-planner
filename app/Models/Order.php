<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'event_type', 'total_price', 'status', 'scheduled_date', 'tujuan', 'special_request', 'discount_amount', 'final_amount', 'payment_method', 'down_payment', 'remaining_payment', 'payment_proof', 'payment_notes', 'special_instructions'];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function packages()
    {
        return $this->hasMany(OrderPackage::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Menghapus method booted() dan boot() yang ada

    public function recalculateTotalPrice()
    {
        $this->total_price = $this->items()->sum('subtotal') + $this->packages()->sum('subtotal');
        $this->saveQuietly(); // Menyimpan tanpa memicu event
    }


    protected $casts = [
        'total_price' => 'integer',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'scheduled_date' => 'date', // Pastikan ini ada
    ];

    // Tambahkan state transitions
    public function markAsProcessing()
    {
        $this->update(['status' => 'processing']);
    }

    public function completeOrder()
    {
        $this->update(['status' => 'completed']);
    }

    public function cancelOrder()
    {
        $this->update(['status' => 'cancelled']);
    }

    public function staff(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Staff::class, 'order_staff');
    }
    public function assignedStaff()
{
    return $this->hasMany(OrderStaff::class);
}

}