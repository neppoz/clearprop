<?php

namespace App\Models;

use App\Models\IncomeCategory;
use App\Scopes\CurrentUserScope;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

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
        // Füge den Scope nur für nicht-Admin-Benutzer hinzu
        if (Auth::check() && Auth::user()->roles->contains(\App\Models\User::IS_MEMBER)) {
            static::addGlobalScope(new CurrentUserScope());
        }
    }
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function income_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(IncomeCategory::class, 'income_category_id');
    }

    public function created_by(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
