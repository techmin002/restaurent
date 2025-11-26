<?php

namespace Modules\Setting\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Setting\Database\Factories\CounterFactory;

class Counter extends Model
{
    use HasFactory;

   protected $table = 'counters'; // optional if table name is default plural
    protected $fillable = [
        'type',
        'cash_opening',
        'cash_closing',
        'bank_opening',
        'bank_closing',
        'deposit',
        'date',
        'day',
    ];
}
