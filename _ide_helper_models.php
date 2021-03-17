<?php

// @formatter:off

/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App {
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
     * @method static \Illuminate\Database\Eloquent\Builder|Activity newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Activity newQuery()
     * @method static \Illuminate\Database\Query\Builder|Activity onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Activity query()
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereAmount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereArrival($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCopilotId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCounterStart($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCounterStop($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereCreatedById($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereDeparture($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereEngineWarmup($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereEvent($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereEventStart($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereEventStop($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereInstructorId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereMinutes($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity wherePlaneId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereRate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereSplitCost($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereTypeId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereWarmupMinutes($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Activity whereWarmupStart($value)
     * @method static \Illuminate\Database\Query\Builder|Activity withTrashed()
     * @method static \Illuminate\Database\Query\Builder|Activity withoutTrashed()
     */
    class Activity extends \Eloquent
    {
    }
}

namespace App {
    /**
     * App\Asset
     *
     * @property int $id
     * @property string|null $serial_number
     * @property string|null $name
     * @property string|null $notes
     * @property int|null $start_hours
     * @property \Illuminate\Support\Carbon|null $start_date
     * @property int|null $end_hours
     * @property \Illuminate\Support\Carbon|null $end_date
     * @property int|null $current_running_hours
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property int|null $category_id
     * @property int|null $status_id
     * @property int|null $location_id
     * @property int|null $assigned_to_id
     * @property int|null $plane_id
     * @property-read \App\User|null $assigned_to
     * @property-read \App\AssetCategory|null $category
     * @property-read mixed $photos
     * @property-read \App\AssetLocation|null $location
     * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\MediaLibrary\Models\Media[] $media
     * @property-read int|null $media_count
     * @property-read \App\Plane|null $plane
     * @property-read \App\AssetStatus|null $status
     * @method static \Illuminate\Database\Eloquent\Builder|Asset newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Asset newQuery()
     * @method static \Illuminate\Database\Query\Builder|Asset onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Asset query()
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereAssignedToId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereCategoryId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereCurrentRunningHours($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereEndDate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereEndHours($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereLocationId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereNotes($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset wherePlaneId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereSerialNumber($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereStartDate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereStartHours($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereStatusId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Asset whereUpdatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|Asset withTrashed()
     * @method static \Illuminate\Database\Query\Builder|Asset withoutTrashed()
     */
    class Asset extends \Eloquent implements \Spatie\MediaLibrary\HasMedia\HasMedia
    {
    }
}

namespace App {
    /**
     * App\AssetCategory
     *
     * @property int $id
     * @property string|null $name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @method static \Illuminate\Database\Eloquent\Builder|AssetCategory newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetCategory newQuery()
     * @method static \Illuminate\Database\Query\Builder|AssetCategory onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetCategory query()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetCategory whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetCategory whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetCategory whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetCategory whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetCategory whereUpdatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|AssetCategory withTrashed()
     * @method static \Illuminate\Database\Query\Builder|AssetCategory withoutTrashed()
     */
    class AssetCategory extends \Eloquent
    {
    }
}

namespace App {
    /**
     * App\AssetLocation
     *
     * @property int $id
     * @property string|null $name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @method static \Illuminate\Database\Eloquent\Builder|AssetLocation newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetLocation newQuery()
     * @method static \Illuminate\Database\Query\Builder|AssetLocation onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetLocation query()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetLocation whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetLocation whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetLocation whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetLocation whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetLocation whereUpdatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|AssetLocation withTrashed()
     * @method static \Illuminate\Database\Query\Builder|AssetLocation withoutTrashed()
     */
    class AssetLocation extends \Eloquent
    {
    }
}

namespace App {
    /**
     * App\AssetStatus
     *
     * @property int $id
     * @property string|null $name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @method static \Illuminate\Database\Eloquent\Builder|AssetStatus newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetStatus newQuery()
     * @method static \Illuminate\Database\Query\Builder|AssetStatus onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetStatus query()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetStatus whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetStatus whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetStatus whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetStatus whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetStatus whereUpdatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|AssetStatus withTrashed()
     * @method static \Illuminate\Database\Query\Builder|AssetStatus withoutTrashed()
     */
    class AssetStatus extends \Eloquent
    {
    }
}

namespace App {
    /**
     * App\AssetsHistory
     *
     * @property int $id
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property int|null $asset_id
     * @property int|null $status_id
     * @property int|null $location_id
     * @property int|null $assigned_user_id
     * @property int|null $plane_id
     * @property-read \App\Asset|null $asset
     * @property-read \App\User|null $assigned_user
     * @property-read \App\AssetLocation|null $location
     * @property-read \App\AssetStatus|null $status
     * @method static \Illuminate\Database\Eloquent\Builder|AssetsHistory newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetsHistory newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetsHistory query()
     * @method static \Illuminate\Database\Eloquent\Builder|AssetsHistory whereAssetId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetsHistory whereAssignedUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetsHistory whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetsHistory whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetsHistory whereLocationId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetsHistory wherePlaneId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetsHistory whereStatusId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|AssetsHistory whereUpdatedAt($value)
     */
    class AssetsHistory extends \Eloquent
    {
    }
}

namespace App {
    /**
     * App\Booking
     *
     * @property int $id
     * @property \Illuminate\Support\Carbon $reservation_start
     * @property \Illuminate\Support\Carbon $reservation_stop
     * @property string|null $description
     * @property int $mode_id
     * @property int $status
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property int|null $slot_id
     * @property int|null $checkin
     * @property int|null $seats
     * @property int|null $seats_taken
     * @property int|null $seats_available
     * @property int|null $instructor_needed
     * @property int $plane_id
     * @property int|null $created_by_id
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $bookingInstructors
     * @property-read int|null $booking_instructors_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $bookingUsers
     * @property-read int|null $booking_users_count
     * @property-read \App\User|null $created_by
     * @property-read \App\User $instructor
     * @property-read \App\Mode $mode
     * @property-read \App\Plane $plane
     * @property-read \App\Slot|null $slot
     * @property-read \App\Type $type
     * @method static \Illuminate\Database\Eloquent\Builder|Booking newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Booking newQuery()
     * @method static \Illuminate\Database\Query\Builder|Booking onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Booking query()
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCheckin($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereCreatedById($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereInstructorNeeded($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereModeId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking wherePlaneId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereReservationStart($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereReservationStop($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereSeats($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereSeatsAvailable($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereSeatsTaken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereSlotId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereStatus($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Booking whereUpdatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|Booking withTrashed()
     * @method static \Illuminate\Database\Query\Builder|Booking withoutTrashed()
     */
    class Booking extends \Eloquent
    {
    }
}

namespace App {
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
     * @mixin \Eloquent
     */
    class Expense extends \Eloquent
    {
    }
}

namespace App {
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
     * @mixin \Eloquent
     */
    class ExpenseCategory extends \Eloquent
    {
    }
}

namespace App {
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
     * @mixin \Eloquent
     */
    class Factor extends \Eloquent
    {
    }
}

namespace App {
    /**
     * App\Income
     *
     * @property int $id
     * @property \Illuminate\Support\Carbon|null $entry_date
     * @property string|null $amount
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
     * @method static \Illuminate\Database\Eloquent\Builder|Income newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Income newQuery()
     * @method static \Illuminate\Database\Query\Builder|Income onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Income query()
     * @method static \Illuminate\Database\Eloquent\Builder|Income whereAmount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Income whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Income whereCreatedById($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Income whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Income whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Income whereEntryDate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Income whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Income whereIncomeCategoryId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Income whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Income whereUserId($value)
     * @method static \Illuminate\Database\Query\Builder|Income withTrashed()
     * @method static \Illuminate\Database\Query\Builder|Income withoutTrashed()
     */
    class Income extends \Eloquent
    {
    }
}

namespace App {
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
     * @mixin \Eloquent
     */
    class IncomeCategory extends \Eloquent
    {
    }
}

namespace App {
    /**
     * App\Mode
     *
     * @property int $id
     * @property string $name
     * @property int $active
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Mode newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Mode newQuery()
     * @method static \Illuminate\Database\Query\Builder|Mode onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Mode query()
     * @method static \Illuminate\Database\Eloquent\Builder|Mode whereActive($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Mode whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Mode whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Mode whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Mode whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Mode whereUpdatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|Mode withTrashed()
     * @method static \Illuminate\Database\Query\Builder|Mode withoutTrashed()
     */
    class Mode extends \Eloquent
    {
    }
}

namespace App {
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
     * @mixin \Eloquent
     */
    class Parameter extends \Eloquent
    {
    }
}

namespace App {
    /**
     * App\Payment
     *
     * @property int $id
     * @property int $user_id
     * @property string $stripe_id
     * @property int $subtotal
     * @property int $tax
     * @property int $total
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
     * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Payment whereStripeId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Payment whereSubtotal($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTax($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTotal($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUserId($value)
     */
    class Payment extends \Eloquent
    {
    }
}

namespace App {
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
     * @mixin \Eloquent
     */
    class Permission extends \Eloquent
    {
    }
}

namespace App {
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
     * @mixin \Eloquent
     */
    class Plane extends \Eloquent
    {
    }
}

namespace App {
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
     * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
     * @method static \Illuminate\Database\Query\Builder|Role onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Role query()
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|Role withTrashed()
     * @method static \Illuminate\Database\Query\Builder|Role withoutTrashed()
     */
    class Role extends \Eloquent
    {
    }
}

namespace App {
    /**
     * App\Slot
     *
     * @property int $id
     * @property string $title
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $slotBookings
     * @property-read int|null $slot_bookings_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
     * @property-read int|null $users_count
     * @method static \Illuminate\Database\Eloquent\Builder|Slot newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|Slot newQuery()
     * @method static \Illuminate\Database\Query\Builder|Slot onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|Slot query()
     * @method static \Illuminate\Database\Eloquent\Builder|Slot whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Slot whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Slot whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Slot whereTitle($value)
     * @method static \Illuminate\Database\Eloquent\Builder|Slot whereUpdatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|Slot withTrashed()
     * @method static \Illuminate\Database\Query\Builder|Slot withoutTrashed()
     */
    class Slot extends \Eloquent
    {
    }
}

namespace App {
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
     * @mixin \Eloquent
     */
    class Type extends \Eloquent
    {
    }
}

namespace App {
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
     * @property-read mixed $is_admin
     * @property-read mixed $is_manager
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $instructorActivities
     * @property-read int|null $instructor_activities_count
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\Booking[] $instructorBookings
     * @property-read int|null $instructor_bookings_count
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
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\UserAlert[] $userUserAlerts
     * @property-read int|null $user_user_alerts_count
     * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
     * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|User query()
     * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereCity($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereFactorId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereInstructor($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereLang($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereLicense($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereMedicalDue($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereParams($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone1($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone2($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User wherePrivacyConfirmedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereTaxno($value)
     * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
     * @method static \Illuminate\Database\Query\Builder|User withTrashed()
     * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
     */
    class User extends \Eloquent
    {
    }
}

namespace App {
    /**
     * App\UserAlert
     *
     * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $users
     * @property-read int|null $users_count
     * @method static \Illuminate\Database\Eloquent\Builder|UserAlert newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|UserAlert newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|UserAlert query()
     */
    class UserAlert extends \Eloquent
    {
    }
}

