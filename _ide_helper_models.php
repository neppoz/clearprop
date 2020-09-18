<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\IncomeCategory
 *
 * @property int $id
 * @property string|null $name
 * @property int|null $deposit
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncomeCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncomeCategory newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\IncomeCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncomeCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncomeCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncomeCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncomeCategory whereDeposit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncomeCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncomeCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\IncomeCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\IncomeCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\IncomeCategory withoutTrashed()
 */
	class IncomeCategory extends \Eloquent {}
}

namespace App{
/**
 * App\Booking
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon $reservation_start
 * @property \Illuminate\Support\Carbon $reservation_stop
 * @property string|null $description
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @property int|null $instructor_id
 * @property int $type_id
 * @property int $plane_id
 * @property int|null $created_by_id
 * @property-read \App\User|null $created_by
 * @property-read \App\User|null $instructor
 * @property-read \App\Plane $plane
 * @property-read \App\Type $type
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Booking onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereInstructorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking wherePlaneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereReservationStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereReservationStop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Booking whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Booking withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Booking withoutTrashed()
 */
	class Booking extends \Eloquent {}
}

namespace App{
/**
 * App\Type
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property int $active
 * @property int $instructor
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Factor[] $factors
 * @property-read int|null $factors_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Type onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereInstructor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Type whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Type withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Type withoutTrashed()
 */
	class Type extends \Eloquent {}
}

namespace App{
/**
 * App\Plane
 *
 * @property int $id
 * @property string $callsign
 * @property string $vendor
 * @property string|null $model
 * @property string|null $prodno
 * @property string $counter_type
 * @property int|null $warmup_type
 * @property int|null $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $planeActivities
 * @property-read int|null $plane_activities_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $planeBookings
 * @property-read int|null $plane_bookings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $planeUsers
 * @property-read int|null $plane_users_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Plane onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereCallsign($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereCounterType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereModel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereProdno($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereVendor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Plane whereWarmupType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Plane withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Plane withoutTrashed()
 */
	class Plane extends \Eloquent {}
}

namespace App{
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
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\MustVerifyEmail {}
}

namespace App{
/**
 * App\Factor
 *
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $factorUsers
 * @property-read int|null $factor_users_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Type[] $factor_types
 * @property-read int|null $factor_types_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Type[] $types
 * @property-read int|null $types_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Factor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Factor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Factor withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Factor withoutTrashed()
 */
	class Factor extends \Eloquent {}
}

namespace App{
/**
 * App\Role
 *
 * @property int $id
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Permission[] $permissions
 * @property-read int|null $permissions_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Role onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Role whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Role withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Role withoutTrashed()
 */
	class Role extends \Eloquent {}
}

namespace App{
/**
 * App\Expense
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $entry_date
 * @property float|null $amount
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $expense_category_id
 * @property-read \App\ExpenseCategory|null $expense_category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expense newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Expense onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expense whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expense whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expense whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expense whereExpenseCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Expense whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Expense withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Expense withoutTrashed()
 */
	class Expense extends \Eloquent {}
}

namespace App{
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
 */
	class Activity extends \Eloquent {}
}

namespace App{
/**
 * App\ExpenseCategory
 *
 * @property int $id
 * @property string|null $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExpenseCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExpenseCategory newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\ExpenseCategory onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExpenseCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExpenseCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExpenseCategory whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExpenseCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExpenseCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ExpenseCategory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ExpenseCategory withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\ExpenseCategory withoutTrashed()
 */
	class ExpenseCategory extends \Eloquent {}
}

namespace App{
/**
 * App\Income
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $entry_date
 * @property float|null $amount
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $income_category_id
 * @property int|null $user_id
 * @property int|null $created_by_id
 * @property-read \App\User|null $created_by
 * @property-read \App\IncomeCategory|null $income_category
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Income onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereEntryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereIncomeCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Income whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Income withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Income withoutTrashed()
 */
	class Income extends \Eloquent {}
}

namespace App{
/**
 * App\Parameter
 *
 * @property int $id
 * @property string $slug
 * @property string|null $value
 * @property string|null $lang
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Parameter onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Parameter whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Parameter withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Parameter withoutTrashed()
 */
	class Parameter extends \Eloquent {}
}

namespace App{
/**
 * App\Permission
 *
 * @property int $id
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Permission onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Permission whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Permission withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Permission withoutTrashed()
 */
	class Permission extends \Eloquent {}
}

