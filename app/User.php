<?php

namespace App;

use Carbon\Carbon;
use DateTimeInterface;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable // implements MustVerifyEmail
{
    use SoftDeletes, Notifiable, HasApiTokens;

    public $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

    const IS_ADMIN = 1;
    const IS_MEMBER = 2;
    const IS_MANAGER = 3;
    const IS_INSTRUCTOR = 4;
    const IS_MECHANIC = 5;

    const LANG_SELECT = [
        'EN' => 'English',
        'DE' => 'German',
        'IT' => 'Italian',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'medical_due',
        'email_verified_at',
        'privacy_confirmed_at',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'lang',
        'taxno',
        'phone_1',
        'phone_2',
        'address',
        'city',
        'factor_id',
        'license',
        'medical_due',
        'params',
        'remember_token',
        'email_verified_at',
        'privacy_confirmed_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function getIsManagerAttribute()
    {
        return $this->roles()->where('id', 3)->exists();
    }

    public function getIsInstructorAttribute()
    {
        return $this->roles()->where('id', 4)->exists();
    }

    public function getIsMechanicAttribute()
    {
        return $this->roles()->where('id', 5)->exists();
    }

    public function userActivities()
    {
        return $this->hasMany(Activity::class, 'user_id', 'id');
    }

    public function userBookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_user');
    }

    public function instructorBookings()
    {
        return $this->belongsToMany(Booking::class, 'booking_instructor');
    }

    public function copilotActivities()
    {
        return $this->hasMany(Activity::class, 'copilot_id', 'id');
    }

    public function instructorActivities()
    {
        return $this->hasMany(Activity::class, 'instructor_id', 'id');
    }

    public function userIncomes()
    {
        return $this->hasMany(Income::class, 'user_id', 'id');
    }

    public function setPasswordAttribute($input)
    {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    public function factor()
    {
        return $this->belongsTo(Factor::class, 'factor_id');
    }

    public function getMedicalDueAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setMedicalDueAttribute($value)
    {
        $this->attributes['medical_due'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function getEmailVerifiedAtAttribute($value)
    {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value)
    {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setTaxnoAttribute($value)
    {
        $this->attributes['taxno'] = strtoupper($value);
    }

    public function planes()
    {
        return $this->belongsToMany(Plane::class);
    }

    public function userUserAlerts()
    {
        return $this->belongsToMany(UserAlert::class);
    }
}
