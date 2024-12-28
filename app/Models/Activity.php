<?php

namespace App\Models;

use App\Enums\ActivityStatus;
use App\Scopes\RolesScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Activity extends Model
{
    use SoftDeletes;

    const SPLIT_COST_RADIO = [
        '0' => 'No split',
        '1' => '50-50',
    ];

    public $table = 'activities';

    protected $dates = [
        'event',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'status' => ActivityStatus::class,
    ];

    protected $fillable = [
        'user_id',
        'type_id',
        'split_cost',
        'copilot_id',
        'instructor_id',
        'plane_id',
        'event',
        'warmup_start',
        'counter_start',
        'counter_stop',
        'departure',
        'arrival',
        'event_start',
        'event_stop',
        'warmup_minutes',
        'minutes',
        'amount',
        'base_price_per_minute',
        'instructor_price_per_minute',
        'package_id',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
        'status',
    ];

    protected static function booted(): void
    {
        $user = auth()->user();

        // Apply the scope only if the user is not an admin or manager
        if (!$user->is_admin && !$user->is_manager) {
            static::addGlobalScope(new RolesScope(
                user: $user,
//                status: 'active' // Optional status filter
            ));
        }
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function copilot(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'copilot_id');
    }

    public function instructor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function plane(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Plane::class, 'plane_id');
    }

    public function getFullCounterAttribute(): string
    {
        return $this->counter_start . ' / ' . $this->counter_stop;
    }

    public function created_by(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
