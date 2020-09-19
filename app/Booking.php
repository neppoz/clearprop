<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Booking
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $reservation_start
 * @property \Illuminate\Support\Carbon $reservation_stop
 * @property string|null $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property int|null $instructor_id
 * @property int $type_id
 * @property int $plane_id
 * @property int|null $created_by_id
 * @property-read \App\User|null $created_by
 * @property-read \App\User|null $instructor
 * @property-read \App\Plane $plane
 * @property-read \App\Type $type
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Booking onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereInstructorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking wherePlaneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereReservationStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereReservationStop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Booking withoutTrashed()
 * @mixin \Eloquent
 */
class Booking extends Model
{
    use SoftDeletes;

    public $table = 'bookings';

    const STATUS_RADIO = [
        '0' => 'pending',
        '1' => 'confirmed',
    ];
    const INSTRUCTOR_NEEDED_RADIO = [
        '0' => 'no',
        '1' => 'yes',
    ];
    const TYPE_SELECT = [
        '0' => 'personal',
        '1' => 'slot',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'reservation_stop',
        'reservation_start',
    ];

    protected $fillable = [
        'reservation_start',
        'reservation_stop',
        'description',
        'type',
        'instructor_needed',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'user_id',
        'type_id',
        'instructor_id',
        'plane_id',
        'created_by_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plane()
    {
        return $this->belongsTo(Plane::class, 'plane_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function getReservationStartAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setReservationStartAttribute($value)
    {
        $this->attributes['reservation_start'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function getReservationStopAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setReservationStopAttribute($value)
    {
        $this->attributes['reservation_stop'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }
}
