<?php

namespace App\Models;

use App\ExpenseCategory;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

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

    public function expense_category(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');

    }

}
