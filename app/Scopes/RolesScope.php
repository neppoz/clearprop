<?php

namespace App\Scopes;
namespace App\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Schema;

class RolesScope implements Scope
{
    protected User $user;
    protected ?string $status;

    public function __construct(User $user, ?string $status = null)
    {
        $this->user = $user;
        $this->status = $status;
    }

    public function apply(Builder $builder, Model $model): void
    {
        // Exclude admins and managers from the scope
        if (!$this->user->is_admin && !$this->user->is_manager) {
            $builder->where(function ($query) use ($model) {
                // Always check user_id
                $query->where('user_id', $this->user->id);

                // Dynamically check for created_by_id
                if (Schema::hasColumn($model->getTable(), 'created_by_id')) {
                    $query->orWhere('created_by_id', $this->user->id);
                }

                // Dynamically check for instructor_id
                if (Schema::hasColumn($model->getTable(), 'instructor_id')) {
                    $query->orWhere('instructor_id', $this->user->id);
                }
            });

            // OPTIONAL: Apply status filter if provided
            if (!is_null($this->status)) {
                $builder->where('status', $this->status);
            }
        }
    }
}
