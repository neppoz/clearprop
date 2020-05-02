<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use SoftDeletes;

    public $table = 'types';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'active',
        'instructor',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
    ];

    // public function getNameAttribute()
    // {
    //     if ($this->instructor == true) {
    //         return $this->name;
    //     }

    //     return $this->name;
    // }
}
