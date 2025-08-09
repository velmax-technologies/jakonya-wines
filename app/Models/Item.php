<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasTags;
    
    protected $fillable = [
        'name',
        'sku',
        'upc',
        'image_path',
        'is_active',
    ];

    /**
     * Get the item's name.
     */
    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    // stock
    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    // costs
    public function costs()
    {
        return $this->hasMany(ItemCost::class);
    }

    // price
    public function item_prices()
    {
        return $this->hasMany(ItemPrice::class);
    }
}
