<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class askedQuestions extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'subtitle'];

    // Optional factory
    // protected static function newFactory()
    // {
    //     return \Modules\Setting\Database\Factories\FeatureFactory::new();
    // }
}
