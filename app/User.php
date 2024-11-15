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
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;

class User extends Authenticatable implements FilamentUser
{
    use SoftDeletes, Notifiable;

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
    public $table = 'users';
    protected $hidden = [
        'password',
        'remember_token',
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

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function getIsManagerAttribute(): bool
    {
        return $this->roles()->where('id', 3)->exists();
    }

    public function getIsInstructorAttribute(): bool
    {
        return $this->roles()->where('id', 4)->exists();
    }

    public function getIsMechanicAttribute(): bool
    {
        return $this->roles()->where('id', 5)->exists();
    }

    public function userActivities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Activity::class, 'user_id', 'id');
    }

    public function userBookings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_user');
    }

    public function instructorBookings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Booking::class, 'booking_instructor');
    }

    public function copilotActivities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Activity::class, 'copilot_id', 'id');
    }

    public function instructorActivities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Activity::class, 'instructor_id', 'id');
    }

    public function userIncomes(): \Illuminate\Database\Eloquent\Relations\HasMany
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

    public function factor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Factor::class, 'factor_id');
    }

    public function getMedicalDueAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setMedicalDueAttribute($value)
    {
        $this->attributes['medical_due'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function getEmailVerifiedAtAttribute($value): ?string
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

    public function planes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Plane::class);
    }

    public function userUserAlerts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(UserAlert::class);
    }

    public function getCreatedAtAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function getDeletedAtAttribute($value): ?string
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }
}
