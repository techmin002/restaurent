<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

// use Modules\Restaurent\Database\Factories\RestaurentTableFactory;

class RestaurentTable extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $table='restaurent_tables';
    protected $fillable = [
        'table_number',
        'restaurent_id',
        'section_id',
        'created_by',
        'capacity',
        'qr_code_path',
        'status',
        'booking_status'
    ];
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    // protected static function newFactory(): RestaurentTableFactory
    // {
    //     // return RestaurentTableFactory::new();
    // }
}
