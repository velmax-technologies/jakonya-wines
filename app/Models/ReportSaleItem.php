<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportSaleItem extends Model
{
    protected $fillable = [
        'report_id',
        'item_id',
        'quantity',
        'price',
        'total',
    ];

    public function report():BelongsTo
    {
        return $this->belongsTo(Report::class);
    }

    public function item():BelongsTo
    {
        return $this->belongsTo(Item::class);
    }
}
