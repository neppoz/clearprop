<?php

namespace App\Models;

use App\Enums\RatingStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserPlanePrice extends Model
{
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'user_plane_prices';

    protected $casts = [
        'status' => RatingStatus::class,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'plane_id',
        'base_price_per_minute',
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
    public function aircraft(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Plane::class);
    }
}
