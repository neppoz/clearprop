<?php

namespace App\Http\Controllers\Pilot;

use App\Http\Controllers\Controller;
use App\Parameter;
use App\Plane;
use App\Services\UserCheckService;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getRatingsForUser(Request $request)
    {
        if ($request->user_id && $request->plane_id) {
            $user = User::findOrFail($request->user_id);
            $plane = Plane::findOrFail($request->plane_id);
            $medicalCheckPassed = (new UserCheckService())->medicalCheckPassed($user);
            $balanceCheckPassed = (new UserCheckService())->balanceCheckPassed($user);
            $activityCheckPassed = (new UserCheckService())->activityCheckPassed($user, $plane);
            $ratingCheckPassed = (new UserCheckService())->ratingCheckPassed($user, $plane);
        }

        return response()->json([
            'medicalCheckPassed' => $medicalCheckPassed ?? 'false',
            'balanceCheckPassed' => $balanceCheckPassed ?? 'false',
            'activityCheckPassed' => $activityCheckPassed ?? 'false',
            'ratingCheckPassed' => $ratingCheckPassed ?? 'false'
        ]);
    }
}
