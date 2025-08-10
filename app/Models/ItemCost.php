<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class ItemCost extends Model
{
    use HasTags;
    use LogsActivity;

    protected $fillable = [
        'item_id',
        'cost',
        'stock_id',
    ];

    
    // logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('item_cost')
            ->dontSubmitEmptyLogs();
        // Chain fluent methods for configuration options
    }
}
