<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StockAdjustment extends Model
{
    protected $fillable = [
        'item_id',
        'quantity',
        'reason',
        'type',
        'user_id',
        'adjusted_at',
        'note',
    ];


    // item relationship
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // user relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the adjusted quantity formatted.
     */
    public function getQuantityAttribute($value)
    {
        return number_format($value, 2, '.', ''); // Format quantity to two decimal places
    }
    
    /**
     * Get the adjusted at timestamp formatted.
     */
    public function getAdjustedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s'); // Format timestamp
    }
}
