<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeCategory extends Model
{
    use SoftDeletes;

    const DEPOSIT_RADIO = [
        '0' => 'Fee',
        '1' => 'Activity deposit',
    ];
    public $table = 'income_categories';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'name',
        'deposit',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
