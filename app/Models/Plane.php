<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read float $default_price_per_minute
 * @property-read float $instructor_price_per_minute
 */

class Plane extends Model
{
    use SoftDeletes;

    const COUNTER_TYPE_SELECT = [
        '100' => 'Industrial minutes (100/hour)',
        '060' => 'Hours and minutes (hh,mm)',
        '000' => 'No counter (using Engine On/Off values)',
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
        'default_price_per_minute',
        'instructor_price_per_minute',
        'counter_type',
        'warmup_minutes',
        'pilot_paying_warmup',
        'active',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'pilot_paying_warmup' => 'boolean',
        'warmup_minutes' => 'integer',
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
            ->withPivot('base_price_per_minute', 'instructor_price_per_minute');
    }
}
