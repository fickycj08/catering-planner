<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'price', 'category'];

    public function packages(): BelongsToMany
    {
        return $this->belongsToMany(Package::class, 'package_menu')
        ->withPivot('quantity')
        ->withTimestamps();
    }

}
