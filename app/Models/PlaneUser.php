<?php

namespace App\Models;

use App\Enums\RatingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaneUser extends Model
{

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'plane_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'plane_id',
        'base_price_per_minute',
        'instructor_price_per_minute',
    ];

    /**
     * Get the user that owns the aircraft price.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the aircraft associated with the price.
     */
    public function plane(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Plane::class);
    }

    /**
     * Fetches the base price per minute. Individual price takes precedence.
     * If not set, the default price from the Plane model is used.
     */
    public function getBasePricePerMinute(): float
    {
        return $this->base_price_per_minute ?? $this->plane->default_price_per_minute;
    }

    /**
     * Fetches the instructor price per minute. Individual price takes precedence.
     * If not set, the default instructor price from the Plane model is used.
     */
    public function getInstructorPricePerMinute(): float
    {
        return $this->instructor_price_per_minute ?? $this->plane->instructor_price_per_minute;
    }

}
