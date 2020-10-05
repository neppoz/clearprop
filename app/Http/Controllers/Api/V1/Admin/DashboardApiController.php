<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DashboardResource;
use App\Services\StatisticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group Dashboard
 * @authenticated
 */
class DashboardApiController extends Controller
{

    public function stats(Request $request)
    {
        $statistics = (new StatisticsService())->dashboard($request);

        return DashboardResource::collection($statistics);
    }

    public function currentUser()
    {
        return Auth::user();
    }
}
