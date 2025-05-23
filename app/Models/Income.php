<?php

namespace App\Models;

use App\Enums\PaymentType;
use App\Scopes\RolesScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Income extends Model
{
    use SoftDeletes;

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

    protected static function booted(): void
    {
        $user = auth()->user();

        // Apply the scope only if the user is not an admin or manager
        if (!$user->is_admin && !$user->is_manager) {
            static::addGlobalScope(new RolesScope(
                user: $user,
//                status: 'active' // Optional status filter
            ));
        }
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function income_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id', 'id');
    }

    public function created_by(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function scopeOfDefaultDepositCategory(Builder $query, ?int $userId = null): Builder
    {
        $depositCategoryId = IncomeCategory::where('deposit', PaymentType::Deposit->value)
            ->orderBy('id', 'asc')
            ->value('id'); // Use only the first default deposit value

        $query->where('income_category_id', $depositCategoryId);

        if ($userId !== null) {
            $query->where('user_id', $userId);
        }

        return $query;
    }

}
