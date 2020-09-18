<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Factor
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $factorUsers
 * @property-read int|null $factor_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Type[] $factor_types
 * @property-read int|null $factor_types_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Type[] $types
 * @property-read int|null $types_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Factor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factor withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Factor withoutTrashed()
 * @mixin \Eloquent
 */
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
