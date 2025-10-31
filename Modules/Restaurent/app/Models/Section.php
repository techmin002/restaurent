<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Restaurent\Database\Factories\SectionFactory;

class Section extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table='sections';
    protected $fillable = [
        'name',
        'restaurent_id',
        'status',
        'created_by',
        'section_code'
    ];

    // protected static function newFactory(): SectionFactory
    // {
    //     // return SectionFactory::new();
    // }
}
