<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'original_price',
        'sales_price',
        'remaining_qty',
        'brand_id',
        'offer_status',
        'category_id',
        'description',
        'feature',
        'image',
        'status',
        'backend_price',
        'images'
    ];

    protected static function newFactory()
    {
        return \Modules\Product\Database\factories\ProductFactory::new();
    }
}
