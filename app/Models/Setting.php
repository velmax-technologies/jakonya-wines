<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'group',
        'value',
    ];

     public function getValueAttribute($value)
    {
        if($this->key === 'payment_methods') {
            return json_decode($value, true); // Cast to array if 'type' is 'array'
        }
       
        return $value; // Return original value if no specific cast is needed
    }

    
}
