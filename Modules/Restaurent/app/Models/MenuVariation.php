<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Restaurent\Database\Factories\MenuVariationFactory;

class MenuVariation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'menu_id',
        'restaurent_id',
        'name',
        'price',
        'description',
        'status'
    ];
public function menu()
{
    return $this->belongsTo(Menu::class);
}
    // protected static function newFactory(): MenuVariationFactory
    // {
    //     // return MenuVariationFactory::new();
    // }
}
