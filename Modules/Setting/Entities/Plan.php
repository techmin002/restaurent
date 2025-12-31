<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans';

    protected $fillable = [
        'title', 'bigtitle', 'days',
        'data1','data2','data3','data4','data5',
        'data6','data7','data8','data9','data10',
        'image',
    ];
}
