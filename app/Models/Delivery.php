<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $table = 'deliveries';

    protected $fillable = [
        'sale_id',
        'delivery_address',
        'contact',
        'status'
    ];

    //*start with the relationship
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
