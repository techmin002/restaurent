<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    
        'customer_id',
        'total_amount',
        'paid_amount',
        'due_amount',
        'status',
        'remarks',
      
    ];

    // Optional: link to order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Optional: link to customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
