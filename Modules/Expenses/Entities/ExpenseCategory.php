<?php

namespace Modules\Expenses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Branch\Entities\Branch;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'image',
        'branch_id',
        'created_by',
        'description',
        'status'
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
    protected static function newFactory()
    {
        return \Modules\Expenses\Database\factories\ExpenseCategoryFactory::new();
    }
}
