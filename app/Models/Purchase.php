<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_id',
        'purchase_date',
        'due_date',
        'total_amount',
        'paid_amount',
        'due_amount',
        'invoice_number',
        'notes',
        'is_paid',
        'status',
    ];
        
}
