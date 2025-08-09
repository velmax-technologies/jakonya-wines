<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Illuminate\Database\Eloquent\Model;

class ItemPrice extends Model
{
    use HasTags;

    protected $fillable = [
        'item_id',
        'price',
    ];

    /**
     * Get the item's price.
     */
    public function getPriceAttribute($value)
    {
        return number_format($value, 2, '.', ''); // Format price to two decimal places
    }

}
