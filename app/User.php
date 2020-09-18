<?php

namespace App;

use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * App\User
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $privacy_confirmed_at
 * @property string|null $password
 * @property string|null $remember_token
 * @property int|null $instructor
 * @property \Illuminate\Support\Carbon|null $medical_due
 * @property string|null $license
 * @property string|null $lang
 * @property string|null $taxno
 * @property string|null $phone_1
 * @property string|null $phone_2
 * @property string|null $address
 * @property string|null $city
 * @property string|null $params
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $factor_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $copilotActivities
 * @property-read int|null $copilot_activities_count
 * @property-read \App\Factor|null $factor
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $instructorActivities
 * @property-read int|null $instructor_activities_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Plane[] $planes
 * @property-read int|null $planes_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Role[] $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Sanctum\PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $userActivities
 * @property-read int|null $user_activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $userBookings
 * @property-read int|null $user_bookings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Income[] $userIncomes
 * @property-read int|null $user_incomes_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFactorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereInstructor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereLicense($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereMedicalDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereParams($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhone2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePrivacyConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereTaxno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 * @mixin \Eloquent
 */
class User extends Authenticatable implements MustVerifyEmail
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
        'instructor',
        'params',
        'remember_token',
        'email_verified_at',
        'privacy_confirmed_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function IsAdminByRole()
    {
        return $this->roles()->where('id', 1)->exists();
    }

    public function IsInstructorByFlag()
    {
        return $this->attributes['instructor'] === 1;
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
}
