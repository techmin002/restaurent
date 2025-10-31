<?php

namespace Modules\Restaurent\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Restaurent\Models\Employee;

class Restaurent extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    public function user(){
        return $this->belongsTo(User::class,'id','restaurent_id')->where('access_type','Admin');
    }
    public function employees(){
        return $this->belongsTo(Employee::class,'id','restaurent_id');
    }
    // protected static function newFactory(): RestaurentFactory
    // {
    //     // return RestaurentFactory::new();
    // }
}
