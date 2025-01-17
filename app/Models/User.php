<?php

namespace App\Models;

use Carbon\Carbon;
use DateTimeInterface;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Panel;
use Filament\Models\Contracts\FilamentUser;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property-read bool $is_admin
 * @property-read bool $is_member
 * @property-read bool $is_manager
 * @property-read bool $is_instructor
 * @property-read bool $is_mechanic
 */

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, SoftDeletes, Notifiable, HasRoles;

    const IS_ADMIN = 'Admin';
    const IS_MEMBER = 'Member';
    const IS_MANAGER = 'Manager';
    const IS_INSTRUCTOR = 'Instructor';
    const IS_MECHANIC = 'Mechanic';

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

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
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

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'medical_due' => 'date',
            'email_verified_at' => 'datetime',
            'privacy_confirmed_at' => 'datetime',
        ];
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->hasRole(self::IS_ADMIN);
    }

    public function getIsMemberAttribute(): bool
    {
        return $this->hasRole(self::IS_MEMBER);
    }

    public function getIsManagerAttribute(): bool
    {
        return $this->hasRole(self::IS_MANAGER);
    }

    public function getIsInstructorAttribute(): bool
    {
        return $this->hasRole(self::IS_INSTRUCTOR);
    }

    public function getIsMechanicAttribute(): bool
    {
        return $this->hasRole(self::IS_MECHANIC);
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

    public function scopeInstructors(Builder $query): void
    {
        $query->whereHas('roles', function ($query) {
            $query->where('name', self::IS_INSTRUCTOR);
        });
    }

    public function instructorActivities(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Activity::class, 'instructor_id', 'id');
    }

    public function userIncomes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Income::class, 'user_id', 'id');
    }

    public function factor(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Factor::class, 'factor_id');
    }

    public function planes(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Plane::class)
            ->withPivot('base_price_per_minute', 'instructor_price_per_minute');
    }

}
