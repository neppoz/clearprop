<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Plane
 *
 * @property int $id
 * @property string $callsign
 * @property string $vendor
 * @property string|null $model
 * @property string|null $prodno
 * @property string $counter_type
 * @property int|null $warmup_type
 * @property int|null $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $planeActivities
 * @property-read int|null $plane_activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $planeBookings
 * @property-read int|null $plane_bookings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $planeUsers
 * @property-read int|null $plane_users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Plane onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereCallsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereCounterType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereProdno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereVendor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereWarmupType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plane withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Plane withoutTrashed()
 * @mixin \Eloquent
 */
class Plane extends Model
{
    use SoftDeletes;

    public $table = 'planes';

    const WARMUP_TYPE_RADIO = [
        '0' => 'No',
        '1' => 'Yes',
    ];

    const COUNTER_TYPE_SELECT = [
        '100' => 'Industrial minutes (100/hour)',
        '060' => 'Hours and minutes (hh,mm)',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'callsign',
        'vendor',
        'model',
        'prodno',
        'counter_type',
        'warmup_type',
        'active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function planeActivities()
    {
        return $this->hasMany(Activity::class, 'plane_id', 'id');
    }

    public function planeBookings()
    {
        return $this->hasMany(Booking::class, 'plane_id', 'id');
    }

    public function planeUsers()
    {
        return $this->belongsToMany(User::class);
    }
}
