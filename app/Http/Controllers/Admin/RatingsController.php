<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Plane;
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
            if ($user->planes()->where('plane_id', $plane->id)->exists()) {
                return response()->json(['rating' => true]);
            }
        }
        return response()->json(['rating' => false]);
    }
}
