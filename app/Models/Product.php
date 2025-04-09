<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'product_price',
        'product_description',
        'quantity',
        'category_id',
        'pharmacy_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
