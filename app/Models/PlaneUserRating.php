<?php

namespace App\Models;

use App\Enums\RatingStatus;
use Illuminate\Database\Eloquent\Model;

class PlaneUserRating extends Model
{
    protected $fillable = [
        'user_id',
        'plane_id',
        'status', // Rating status field
    ];

    // Casts the status field to the RatingStatus enum
    protected $casts = [
        'status' => RatingStatus::class,
    ];

    /**
     * Define the relationship with the User model.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship with the Plane model.
     */
    public function plane(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Plane::class);
    }
}
