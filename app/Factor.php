<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Factor extends Model
{
    use SoftDeletes;

    public $table = 'factors';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function factorUsers()
    {
        return $this->hasMany(User::class, 'factor_id', 'id');
    }

    public function factor_types()
    {
        return $this->belongsToMany(Type::class)->withPivot(['rate','description']);
    }

    public function types()
    {
        return $this->belongsToMany(Type::class)->withPivot(['rate','description']);
    }
}
