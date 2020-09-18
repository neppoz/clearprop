<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Parameter
 *
 * @property int $id
 * @property string $slug
 * @property string|null $value
 * @property string|null $lang
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Parameter onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parameter withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Parameter withoutTrashed()
 * @mixin \Eloquent
 */
class Parameter extends Model
{
    use SoftDeletes;

    public $table = 'parameters';

    const CHECK_MEDICAL_ENABLED = 1;
    const CHECK_BALANCE_ENABLED = 1;
    const CHECK_ACTIVITIES_ENABLED = 1;

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
