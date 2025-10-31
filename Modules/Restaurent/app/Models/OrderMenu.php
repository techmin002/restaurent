<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Restaurent\Database\Factories\OrderMenuFactory;

class OrderMenu extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table="order_menus";
    protected $fillable = [
        'order_id',
        'menu_id',
        'variation_id',
        'qty'
    ];
public function order()
{
    return $this->belongsTo(Order::class);
}

public function menu()
{
    return $this->belongsTo(Menu::class);
}

public function variation()
{
    return $this->belongsTo(MenuVariation::class);
}

    // protected static function newFactory(): OrderMenuFactory
    // {
    //     // return OrderMenuFactory::new();
    // }
}
