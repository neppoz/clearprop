<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
