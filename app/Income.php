<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CurrentUserTrait;

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
