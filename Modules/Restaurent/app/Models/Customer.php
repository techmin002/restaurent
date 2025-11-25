<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Restaurent\Database\Factories\CustomerFactory;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table='customers';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'restaurent_id',
        'last_visit',
        'due_amount',
        'status',
    ];
    public function orders()
{
    return $this->hasMany(Order::class);
}

public function payments()
{
    return $this->hasMany(Payment::class, 'customer_id', 'id');
}
public function paymentss()
{
    return $this->hasMany(CustomerPayment::class, 'customer_id', 'id');
}




    // protected static function newFactory(): CustomerFactory
    // {
    //     // return CustomerFactory::new();
    // }
}
