<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Restaurent\Models\Order;
use Modules\Restaurent\Models\OfficePayment;
use Modules\Restaurent\Models\OfficeRegister;


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
        'booking_status',
        	// 'office_id',	
            // 'due_amount',
            // 'paid_amount',	
            // 'total_amount',
            // 	'status',	

    ];

    // protected static function newFactory(): OfficeRegisterFactory
    // {
    //     // return OfficeRegisterFactory::new();
    // }

    public function payments()
{
    return $this->hasMany(Payment::class, 'office_id', 'id');
}
public function orders()
{
    return $this->hasMany(Order::class, 'office_id', 'id');
}
// OfficeRegister.php
public function paymentSummary()
{
    return $this->hasOne(OfficePayment::class, 'office_id', 'id');
}



}


