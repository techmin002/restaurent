<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'short_description',
        'description',
        'branch_id',
        'created_by',
        'image',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
