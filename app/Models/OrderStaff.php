<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStaff extends Model
{
    protected $table = 'order_staff';

    protected $fillable = [
        'order_id',
        'staff_id',
        'role_in_order',
        'status_pengerjaan',
        'is_leader',
    ];
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
}
