<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait CurrentUserTrait
{
    public static function bootCurrentUserTrait()
    {
        if (!app()->runningInConsole() && auth()->check()) {
            $isAdmin = auth()->user()->is_admin;
            // static::creating(function ($model) use ($isAdmin) {
            //     // Prevent admin from setting his own id - admin entries are global.

            //     // If required, remove the surrounding IF condition and admins will act as users
            //     if (!$isAdmin) {
            //         $model->created_by_id = auth()->id();
            //     }
            // });
            if (!$isAdmin) {
                static::addGlobalScope('user_id', function (Builder $builder) {
                    $builder->where('user_id', auth()->id());
                });
            }
        }
    }
}
