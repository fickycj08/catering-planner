<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Staff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'position',
        'user_id',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'assigned_order');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Order::class, 'order_staff');

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderAssignments()
    {
        return $this->hasMany(OrderStaff::class); // model pivot
    }
}
