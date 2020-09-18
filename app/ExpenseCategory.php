<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class ExpenseCategory extends Model
{
    use SoftDeletes;

    public $table = 'expense_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
