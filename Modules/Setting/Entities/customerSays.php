<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class customerSays extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'image','working','description'];

    // Optional factory
    // protected static function newFactory()
    // {
    //     return \Modules\Setting\Database\Factories\FeatureFactory::new();
    // }
}
