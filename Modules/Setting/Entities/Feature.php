<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image'];

    // Optional factory
    // protected static function newFactory()
    // {
    //     return \Modules\Setting\Database\Factories\FeatureFactory::new();
    // }
}
