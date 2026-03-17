<?php

namespace Modules\Expenses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Modules\Expenses\Models\ExpenseCategory;
use Modules\Expenses\Entities\ExpenseProduct;



class Expenses extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded=[];
    protected $fillable = [
        'title',
        'amount',
        'expense_category_id',
        'date',
        'status',
        'descriptions',
        'mode',
        'receipt'
    ];

    public function category()
    {
        return $this->belongsTo(ExpenseCategory::class,'expense_category_id','id');
    }
    protected static function newFactory()
    {
        return \Modules\Expenses\Database\factories\ExpensesFactory::new();
    }

    public function expenseProducts()
{
    return $this->hasMany(ExpenseProduct::class, 'expense_id');
}
}
