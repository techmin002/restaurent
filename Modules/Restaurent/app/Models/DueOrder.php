<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Restaurent\Database\Factories\DueOrderFactory;

class DueOrder extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
     protected $table = 'due_orders';

    protected $fillable = [
        'order_id', 'customer_id', 'customer_name','due_amount', 'status','total_amount','paid_amount'
    ];
        
        public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // protected static function newFactory(): DueOrderFactory
    // {
    //     // return DueOrderFactory::new();
    // }
}
