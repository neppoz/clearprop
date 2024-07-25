<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Plane extends Model
{
    use SoftDeletes;

    const WARMUP_TYPE_RADIO = [
        '0' => 'No',
        '1' => 'Yes',
    ];

    const COUNTER_TYPE_SELECT = [
        '100' => 'Industrial minutes (100/hour)',
        '060' => 'Hours and minutes (hh,mm)',
    ];

    public $table = 'planes';

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

    public function planeActivities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Activity::class, 'plane_id', 'id');
    }

    public function planeBookings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Reservation::class, 'plane_id', 'id');
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('base_price_per_minute', 'instructor_price_per_minute', 'rating_status');
    }
}
