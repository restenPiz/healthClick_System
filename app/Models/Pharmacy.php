<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;
    protected $table = 'pharmacies';
    protected $fillable = [
        'user_id',
        'pharmacy_name',
        'pharmacy_contact',
        'pharmacy_file',
        'pharmacy_location',
        'pharmacy_description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
