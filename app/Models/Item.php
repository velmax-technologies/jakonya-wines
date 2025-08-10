<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Item extends Model
{
    use HasTags;
    use LogsActivity;

    
    protected $fillable = [
        'name',
        'sku',
        'upc',
        'image_path',
        'is_active',
    ];

    // logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('item')
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }

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

    // stock adjustments
    public function stock_adjustments()
    {
        return $this->hasMany(StockAdjustment::class);
    }

    // addition stock adjustments
    public function addition_stock_adjustments()
    {
        return $this->hasMany(StockAdjustment::class)->where('type', 'addition');
    }

    // subtraction stock adjustments
    public function subtraction_stock_adjustments()
    {
        return $this->hasMany(StockAdjustment::class)->where('type', 'subtraction');
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

    // item sales
    public function item_sale(): HasOne
    {
        return $this->hasOne(ItemSale::class);
    }

    // item return
    public function item_return(): HasOne
    {
        return $this->hasOne(ItemReturn::class);
    }
}
