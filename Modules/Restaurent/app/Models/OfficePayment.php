<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Restaurent\Models\OfficeRegister;
use Modules\Restaurent\Models\OfficePayment;


class OfficePayment extends Model
{
    use SoftDeletes;

    protected $table = 'office_payments';

    protected $fillable = [
        'office_id',
        'due_amount',
        'paid_amount',
        'total_amount',
        'status',
    ];

    public function office()
    {
        return $this->belongsTo(OfficeRegister::class, 'office_id', 'id');
    }
}
