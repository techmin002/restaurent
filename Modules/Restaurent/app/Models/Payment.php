<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
       
        'customer_id',
        'office_id',
        'amount',
        'payment_method',
        'payment_date',
        'status',
        'remarks',
    ];

    // Optional: link to order
    public function order()
{
    return $this->belongsTo(Order::class, 'order_id', 'id');
}

    // Optional: link to customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

}
