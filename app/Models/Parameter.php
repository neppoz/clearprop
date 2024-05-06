<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use SoftDeletes;

    const CHECK_MEDICAL_ENABLED = 1;
    const CHECK_BALANCE_ENABLED = 1;
    const CHECK_ACTIVITIES_ENABLED = 1;
    const CHECK_RATINGS_ENABLED = 1;
    public $table = 'parameters';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'slug',
        'lang',
        'value',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
