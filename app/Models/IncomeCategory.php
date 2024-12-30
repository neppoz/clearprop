<?php

namespace App\Models;

use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeCategory extends Model
{
    use SoftDeletes;

    const DEPOSIT_RADIO = [
        '0' => 'Fee',
        '1' => 'Activity deposit',
    ];

    public const ACTIVITY_TYPE_DEPOSIT = 1;

    public $table = 'income_categories';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'name',
        'deposit',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function incomes(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Income::class);
    }

    public function isDeposit(): bool
    {
        return $this->type === PaymentType::Deposit->value;
    }
}
