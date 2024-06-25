<?php

namespace App\Models;

use App\Factor;
use Illuminate\Database\Eloquent\Builder;
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

    public function scopeCurrentUserTypes(Builder $query, $userId): void
    {
        $query->whereHas('factors', function ($q) use ($userId) {
            $q->where('id', '=', $userId);
        })->where('active', 1);
    }
//
//$user = User::findOrFail($request->user_id);
//$types_opt1 = Type::whereHas('factors', function ($q) use ($user) {
//                $q->where('id', '=', $user->factor_id);
//            })->
//where(['active' => true, 'instructor' => 0])->pluck('name', 'id');
//
//$types_opt2 = Type::whereHas('factors', function ($q) use ($user) {
//    $q->where('id', '=', $user->factor_id);
//})->where(['active' => true, 'instructor' => 1])->pluck('name', 'id');
}
