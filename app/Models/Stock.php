<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Stock extends Model
{
    use LogsActivity;

    protected $fillable = [
        'item_id',
        'supplier_id',
        'quantity',
        'note',
        'expiry_date',
        'is_expired',
    ];

    // logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('stock')
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
    
}
