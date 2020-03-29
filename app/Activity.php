<?php

namespace App;

use App\Traits\MultiTenantModelTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
    use SoftDeletes, MultiTenantModelTrait;

    public $table = 'activities';

    protected $dates = [
        'event',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'rate',
        'event',
        'amount',
        'user_id',
        'arrival',
        'type_id',
        'minutes',
        'plane_id',
        'departure',
        'created_at',
        'copilot_id',
        'event_stop',
        'deleted_at',
        'updated_at',
        'event_start',
        'warmup_start',
        'counter_stop',
        'counter_start',
        'instructor_id',
        'engine_warmup',
        'created_by_id',
        'warmup_minutes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

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

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');

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
