<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CurrentUserTrait;

/**
 * App\Activity
 *
 * @property int $id
 * @property string|null $event_start
 * @property string|null $event_stop
 * @property int|null $engine_warmup
 * @property float|null $warmup_start
 * @property float $counter_start
 * @property float $counter_stop
 * @property int|null $warmup_minutes
 * @property float|null $rate
 * @property int|null $minutes
 * @property float|null $amount
 * @property string|null $departure
 * @property string|null $arrival
 * @property int $split_cost
 * @property \Illuminate\Support\Carbon $event
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property int $plane_id
 * @property int $type_id
 * @property int|null $copilot_id
 * @property int|null $instructor_id
 * @property int|null $created_by_id
 * @property-read \App\User|null $copilot
 * @property-read \App\User|null $created_by
 * @property-read \App\User|null $instructor
 * @property-read \App\Plane $plane
 * @property-read \App\Type $type
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Activity onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereArrival($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCopilotId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCounterStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCounterStop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereDeparture($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereEngineWarmup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereEventStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereEventStop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereInstructorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity wherePlaneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereSplitCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereWarmupMinutes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Activity whereWarmupStart($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Activity withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Activity withoutTrashed()
 * @mixin \Eloquent
 */
class Activity extends Model
{
    use SoftDeletes, CurrentUserTrait;

    public $table = 'activities';

    const SPLIT_COST_RADIO = [
        '0' => 'No split',
        '1' => '50-50',
    ];

    protected $dates = [
        'event',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'user_id',
        'type_id',
        'split_cost',
        'copilot_id',
        'instructor_id',
        'plane_id',
        'event',
        'engine_warmup',
        'warmup_start',
        'counter_start',
        'counter_stop',
        'departure',
        'arrival',
        'event_start',
        'event_stop',
        'warmup_minutes',
        'rate',
        'minutes',
        'amount',
        'description',
        'created_at',
        'updated_at',
        'deleted_at',
        'created_by_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function copilot()
    {
        return $this->belongsTo(User::class, 'copilot_id');
    }

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function plane()
    {
        return $this->belongsTo(Plane::class, 'plane_id');
    }

    public function getEventAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEventAttribute($value)
    {
        $this->attributes['event'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
