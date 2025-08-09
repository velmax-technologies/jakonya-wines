<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Tags\HasTags;

class ItemCost extends Model
{
    use HasTags;

    protected $fillable = [
        'item_id',
        'cost',
        'stock_id',
    ];

    
}
