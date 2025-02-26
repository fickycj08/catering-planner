<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'total_price'];

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class, 'package_menu')
                    ->withPivot(['quantity', 'subtotal'])
                    ->withTimestamps();
    }

    protected static function booted()
    {
        static::saved(function ($package) {
            // Ambil total subtotal dari package_menu untuk package ini
            $total = $package->menus()->sum('package_menu.subtotal');

            // Perbarui total_price di packages
            $package->updateQuietly(['total_price' => $total]);
        });
    }
    public static function getOptions()
{
    return self::all()->mapWithKeys(function ($package) {
        return [$package->id => $package->name . ' (Rp ' . number_format($package->total_price, 0, ',', '.') . ')'];
    });
}

}
