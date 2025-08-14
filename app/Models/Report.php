<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    protected $fillable = [
        'title',
        'description',
        'type', // e.g., 'sales', 'purchases', etc.
        'report_date',
        'user_id' // Optional: if you want to track which user created the report
    ];

    /**
     * Report Sale Items Relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function report_sale_items(): HasMany
    {
        return $this->hasMany(ReportSaleItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
