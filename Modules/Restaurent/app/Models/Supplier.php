<?php

namespace Modules\Restaurent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Restaurent\Database\Factories\SupplierFactory;
use Modules\Expenses\Entities\ExpenseCategory;


class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';

    protected $fillable = [
        'company_name',
        'supplier_name',
        'contact',
        'address',
        'pan_vat',
        'status',
    ];

     public function category()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
}
