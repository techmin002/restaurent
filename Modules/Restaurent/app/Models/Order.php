<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Restaurent\Database\Factories\OrderFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table='orders';
    protected $fillable = [
        'customer_id',
        'table_id',
        'office_id',
        'restaurent_id',
        'created_by',
        'order_type',
        'discount_type',
        'discount_value',
        'discount_amount',
        'delivery_charge',
        'remarks',
        'sub_total',
        'grand_total',
        'order_time',
        'status',
        'order_from'
    ];
    public function items()
{
    return $this->hasMany(OrderMenu::class, 'order_id');
}
public function table() {
    return $this->belongsTo(RestaurentTable::class, 'table_id');
}

public function office() {
    return $this->belongsTo(OfficeRegister::class);
}
public function customer() {
    return $this->belongsTo(Customer::class);
}
public function variation()
{
    return $this->belongsTo(MenuVariation::class);
}
public function menu()
{
    return $this->belongsTo(Menu::class);
}
    // protected static function newFactory(): OrderFactory
    // {
    //     // return OrderFactory::new();
    // }
}
