<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plane extends Model
{
    use SoftDeletes;

    public $table = 'planes';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const COUNTER_TYPE_SELECT = [
        '100' => '100sec/min',
        '060'  => '60sec/min',
    ];

    protected $fillable = [
        'callsign',
        'vendor',
        'model',
        'prodno',
        'counter_type',
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
}
