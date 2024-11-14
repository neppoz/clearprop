<?php

namespace App\Scopes;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CurrentUserScope implements Scope
{
    protected $status;
    protected $createdBy;

    // Konstruktor mit optionalen Parametern
    public function __construct($status = null, $createdBy = null)
    {
        $this->status = $status;
        $this->createdBy = $createdBy;
    }

    public function apply(Builder $builder, Model $model): void
    {
        // Anwenden des Scopes für nicht-Admin-Benutzer
        if (Auth::check() && Auth::user()->is_member) {
            $builder->where(function ($query) {
                $query->where('user_id', Auth::id());

                // OR-Bedingung für `created_by_id`, falls `createdBy` gesetzt ist
                if (!is_null($this->createdBy)) {
                    $query->orWhere('created_by_id', $this->createdBy);
                }
            });
        }

        // Zusätzlicher Statusfilter, falls angegeben
        if (!is_null($this->status)) {
            $builder->where('status', $this->status);
        }
    }
}
