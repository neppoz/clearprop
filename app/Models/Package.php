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
        'hours',
        'valid_from',
        'valid_until',
        'type',
        'plane_id',
        'instructor_id',
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
     * Relationship with the Instructor (User) model.
     */
    public function instructor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Check if the package is currently active.
     */
    public function isActive(): bool
    {
        return now()->between($this->valid_from, $this->valid_until);
    }

    /**
     * Check if the package is valid for a specific instructor.
     */
    public function isValidForInstructor(?int $instructorId): bool
    {
        return $this->instructor_id === null || $this->instructor_id === $instructorId;
    }

    /**
     * Check if the package is valid for a specific plane.
     */
    public function isValidForPlane(?int $planeId): bool
    {
        return $this->plane_id === null || $this->plane_id === $planeId;
    }
}
