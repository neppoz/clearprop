<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $table = 'users';

    protected $fillable = [
        'user_id',
        'stripe_id',
        'subtotal',
        'tax',
        'total',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
