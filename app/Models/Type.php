<?php

namespace App\Models;

use App\Factor;
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

    public function factors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Factor::class)->withPivot(['rate', 'description']);
    }
}
