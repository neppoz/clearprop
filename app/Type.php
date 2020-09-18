<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Type
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $active
 * @property int $instructor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Factor[] $factors
 * @property-read int|null $factors_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Type onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereInstructor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Type withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Type withoutTrashed()
 * @mixin \Eloquent
 */
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

    public function factors()
    {
        return $this->belongsToMany(Factor::class)->withPivot(['rate','description']);
    }
}
