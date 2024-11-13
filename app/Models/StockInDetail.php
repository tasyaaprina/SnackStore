<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockInDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_in_id',
        'product_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    public function stockIn()
    {
        return $this->belongsTo(StockIn::class, 'stock_in_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
