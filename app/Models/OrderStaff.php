<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStaff extends Model
{
    public function order()
{
    return $this->belongsTo(Order::class);
}

public function staff()
{
    return $this->belongsTo(Staff::class);
}

}
