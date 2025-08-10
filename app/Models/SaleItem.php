<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'item_id',
        'quantity',
       
    ];


    // relationships
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
