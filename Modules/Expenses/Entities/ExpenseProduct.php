<?php

namespace Modules\Expenses\Entities;

use Illuminate\Database\Eloquent\Model;

class ExpenseProduct extends Model
{
    protected $table = 'expense_products';

    protected $fillable = [
        'expense_id',
        'product_name',
        'product_qty',
        'product_price',
        'total_price',
        'restaurant_id',
        'status',
    ];

    public function expense()
    {
        return $this->belongsTo(\Modules\Expenses\Entities\Expenses::class, 'expense_id');
    }
}
