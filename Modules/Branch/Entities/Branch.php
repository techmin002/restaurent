<?php

namespace Modules\Branch\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Employee\Entities\Employee;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [];
    public function user(){
        return $this->belongsTo(User::class,'id','branch_id')->where('access_type','Admin');
    }
    public function employees(){
        return $this->hasMany(Employee::class);
    }
    protected static function newFactory()
    {
        return \Modules\Branch\Database\factories\BranchFactory::new();
    }
}
