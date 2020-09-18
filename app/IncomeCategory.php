<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
class IncomeCategory extends Model
{
    use SoftDeletes;

    public $table = 'income_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const DEPOSIT_RADIO = [
        '0' => 'Fee',
        '1' => 'Activity deposit',
    ];

    protected $fillable = [
        'name',
        'deposit',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
