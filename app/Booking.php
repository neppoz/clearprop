<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes;

    public $table = 'bookings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'reservation_stop',
        'reservation_start',
    ];

    protected $fillable = [
        'user_id',
        'plane_id',
        'type_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'created_by_id',
        'reservation_stop',
        'reservation_start',
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
