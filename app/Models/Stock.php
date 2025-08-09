<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{

    protected $fillable = [
        'item_id',
        'supplier_id',
        'quantity',
        'note',
        'expiry_date',
        'is_expired',
    ];

    
}
