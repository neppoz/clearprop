<?php

namespace App;

use App\Traits\CurrentUserTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use SoftDeletes, CurrentUserTrait;

    public $table = 'bookings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'reservation_stop',
        'reservation_start',
    ];

    protected $fillable = [
        'user_id',
        'plane_id',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'created_by_id',
        'reservation_stop',
        'reservation_start',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function plane()
    {
        return $this->belongsTo(Plane::class, 'plane_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
