<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'category_id',
        'description',
        'image',
        'stock',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function stockInDetails()
    {
        return $this->hasMany(StockInDetail::class, 'product_id');
    }
}
