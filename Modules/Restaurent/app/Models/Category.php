<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Restaurent\Database\Factories\CategoryFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'restaurent_id',
        'name',
         'image',
        'description',
        'created_at',
    ];

     public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // protected static function newFactory(): CategoryFactory
    // {
    //     // return CategoryFactory::new();
    // }
}
