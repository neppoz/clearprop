<?php

namespace App;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use SoftDeletes, Notifiable, HasApiTokens;

    public $table = 'users';

    protected $hidden = [
        'password',
        'remember_token',
    ];

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
        'instructor',
        'params',
        'remember_token',
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function userActivities()
    {
        return $this->hasMany(Activity::class, 'user_id', 'id');
    }

    public function userBookings()
    {
        return $this->hasMany(Booking::class, 'user_id', 'id');
    }

    public function copilotActivities()
    {
        return $this->hasMany(Activity::class, 'copilot_id', 'id');
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
}
