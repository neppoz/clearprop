<?php

namespace App\Models;

use App\Enums\PackageType;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'price',
        'initial_minutes',
        'remaining_minutes',
        'valid_from',
        'valid_until',
        'type',
        'plane_id',
        'instructor_included',
    ];

    protected $casts = [
        'type' => PackageType::class, // Enum cast for type
    ];

    /**
     * Relationship with the User model.
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relationship with the Plane model.
     */
    public function plane(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Plane::class);
    }

    /**
     * Check if the package is currently active.
     */
    public function isActive(): bool
    {
        return now()->between($this->valid_from, $this->valid_until);
    }

    /**
     * Check if the package has instructor included
     */
    public function isInstructorIncluded(): bool
    {
        return $this->instructor_included;
    }

    /**
     * Check if the package is valid for a specific plane.
     */
    public function isValidForPlane(?int $planeId): bool
    {
        return $this->plane_id === null || $this->plane_id === $planeId;
    }
}
