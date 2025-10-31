<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Restaurent\Database\Factories\MenuFactory;

class Menu extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'restaurent_id',
        'name',
        'created_by',
        'image',
        'description',
        'price',
        'status'
    ];
public function variations()
{
    return $this->hasMany(MenuVariation::class,'menu_id','id');
}
    // protected static function newFactory(): MenuFactory
    // {
    //     // return MenuFactory::new();
    // }
}
