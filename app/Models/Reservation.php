<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    const STATUS_RADIO = [
        '0' => 'pending',
        '1' => 'confirmed',
    ];

    use SoftDeletes;

    const INSTRUCTOR_NEEDED_RADIO = [
        '0' => 'no',
        '1' => 'yes',
    ];
    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'bookings';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'reservation_stop',
        'reservation_start',
    ];

    protected $fillable = [
        'reservation_start',
        'reservation_stop',
        'description',
        'mode_id',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
        'slot_id',
        'checkin',
        'seats',
        'seats_taken',
        'seats_available',
        'instructor_needed',
        'plane_id',
        'created_by_id',
    ];

    public function bookingUsers(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'booking_user');
    }

    public function bookingInstructors(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(User::class, 'booking_instructor');
    }

    public function mode(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Mode::class, 'mode_id');
    }

    public function plane(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Plane::class, 'plane_id');
    }

    public function type(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    public function instructor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function slot(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Slot::class, 'slot_id');
    }

    public function created_by(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

}
