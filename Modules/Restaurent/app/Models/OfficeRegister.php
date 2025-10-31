<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Restaurent\Database\Factories\OfficeRegisterFactory;

class OfficeRegister extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table='office_registers';
    protected $fillable = [
         'name',
         'code',
        'restaurent_id',
        'owner_name',
        'created_by',
        'address',
        'contact_numbers',
        'qr_code_path',
        'status',
        'type',
        'booking_status'
    ];

    // protected static function newFactory(): OfficeRegisterFactory
    // {
    //     // return OfficeRegisterFactory::new();
    // }
}
