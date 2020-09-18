<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CurrentUserTrait;

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
 * @mixin \Eloquent
 */
class Income extends Model
{
    use SoftDeletes, CurrentUserTrait;

    public $table = 'incomes';

    protected $dates = [
        'entry_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'amount',
        'user_id',
        'entry_date',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'created_by_id',
        'income_category_id',
    ];

    public function getEntryDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setEntryDateAttribute($value)
    {
        $this->attributes['entry_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function income_category()
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
