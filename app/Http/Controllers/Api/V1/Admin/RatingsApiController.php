<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Booking;
use App\Http\Controllers\Admin\RatingsController;
use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\RatingResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Ratings
 * @authenticated
 */
class RatingsApiController extends Controller
{
    /**
     * Get ratings by plane and user
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ratings = ((new RatingsController())->getRatingsForUser($request));
        // It is already Json, no JsonResource needed
        return $ratings;
//        return RatingResource::toJson($ratings);
    }

}
