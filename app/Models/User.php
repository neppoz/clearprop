<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    protected function casts(): array
    {
        return [
            'medical_due' => 'date',
            'email_verified_at' => 'datetime',
            'privacy_confirmed_at' => 'datetime',
        ];
    }

    public function scopeInstructors(Builder $query): void
    {
        $query->whereHas('roles', function ($role) {
            $role->where('role_id', User::IS_INSTRUCTOR);
        });
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->roles()->where('id', self::IS_ADMIN)->exists();
    }

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function getIsManagerAttribute(): bool
    {
        return $this->roles()->where('id', self::IS_MANAGER)->exists();
    }

    public function getIsInstructorAttribute(): bool
    {
        return $this->roles()->where('id', self::IS_INSTRUCTOR)->exists();
    }

    public function getIsMechanicAttribute(): bool
    {
        return $this->roles()->where('id', self::IS_MECHANIC)->exists();
    }

    public function userActivities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Activity::class, 'user_id', 'id');
    }

    public function userBookings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'booking_user', 'user_id', 'booking_id');
    }

    public function instructorBookings(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Reservation::class, 'booking_instructor', 'user_id', 'booking_id');
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

    public function setTaxnoAttribute($value): void
    {
        $this->attributes['taxno'] = strtoupper($value);
    }

    public function planes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Plane::class)
            ->withPivot('base_price_per_minute', 'instructor_price_per_minute', 'rating_status');
    }

    public function userUserAlerts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(UserAlert::class);
    }

}
