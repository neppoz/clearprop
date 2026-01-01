<?php

namespace App\Models;

use App\Enums\AssetCategory;
use App\Enums\AssetStatus;
use App\Observers\AssetObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy([AssetObserver::class])]
class Asset extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'assets';

    protected $fillable = [
        'category',
        'plane_id',
        'serial_number',
        'name',
        'start_hours',
        'start_date',
        'end_hours',
        'end_date',
        'current_running_hours',
        'service_interval_hours',
        'last_service_hours',
        'last_service_date',
        'status',
        'notes',
        'assigned_to_id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'start_hours' => 'integer',
            'end_hours' => 'integer',
            'current_running_hours' => 'integer',
            'service_interval_hours' => 'integer',
            'last_service_hours' => 'integer',
            'last_service_date' => 'date',
            'status' => AssetStatus::class,
            'category' => AssetCategory::class,
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function getServiceStatusAttribute(): string
    {
        if (!$this->service_interval_hours) {
            return 'no_interval';
        }

        $hoursUntilService = $this->getHoursUntilServiceAttribute();

        if ($hoursUntilService <= 0) {
            return 'overdue';
        }
        if ($hoursUntilService <= 50) {
            return 'due_soon';
        }

        return 'ok';
    }

    public function getHoursUntilServiceAttribute(): int
    {
        if (!$this->service_interval_hours) {
            return 0;
        }

        $lastServiceAt = $this->last_service_hours ?? $this->start_hours ?? 0;
        $hoursSinceService = ($this->current_running_hours ?? 0) - $lastServiceAt;

        return $this->service_interval_hours - $hoursSinceService;
    }

    public function plane(): BelongsTo
    {
        return $this->belongsTo(Plane::class, 'plane_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
}
