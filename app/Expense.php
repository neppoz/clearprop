<?php

namespace App;

use App\Traits\CurrentUserTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class Expense extends Model
{
    use SoftDeletes, CurrentUserTrait;

    public $table = 'expenses';

    protected $dates = [
        'entry_date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'amount',
        'entry_date',
        'created_at',
        'updated_at',
        'deleted_at',
        'description',
        'expense_category_id',
    ];

    public function expense_category()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');

    }

    public function getEntryDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;

    }

    public function setEntryDateAttribute($value)
    {
        $this->attributes['entry_date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;

    }
}
