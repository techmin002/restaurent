<?php

namespace Modules\Product\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Product\Database\factories\TechnicalToolsFactory;

class TechnicalTools extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tool_name',
        'model_name',
        'price',
        'image',
        'description',
        'stock',
        'status',
    ];

    protected static function newFactory()
    {
        //return TechnicalToolsFactory::new();
    }
}
