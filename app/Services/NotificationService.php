<?php

namespace App\Services;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Throwable;

class NotificationService
{
    public function getUnreadNotificationsForLoggedInUser()
    {
        $unreadNotifications = auth()->user()->unreadNotifications;

        return $unreadNotifications;
    }

}
