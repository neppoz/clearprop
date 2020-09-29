<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Booking;
use App\Http\Controllers\Admin\RatingsController;
use App\Http\Controllers\Controller;

//use App\Http\Requests\StoreBookingRequest;
//use App\Http\Requests\UpdateBookingRequest;
//use App\Http\Resources\Admin\BookingResource;
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
//        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ratings = ((new RatingsController())->getRatingsForUser($request));

        dd($ratings);
        return RatingResource::collection($ratings);
    }

//    /**
//     * Create reservations
//     */
//    public function store(StoreBookingRequest $request)
//    {
//        $booking = Booking::create($request->all());
//
//        return (new BookingResource($booking))
//            ->response()
//            ->setStatusCode(Response::HTTP_CREATED);
//    }
//
//    /**
//     * Get reservation by ID
//     */
//    public function show(Booking $booking)
//    {
////        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//
//        return new BookingResource($booking->load(['user', 'plane', 'created_by']));
//    }
//
//    /**
//     * Update reservations
//     */
//    public function update(UpdateBookingRequest $request, Booking $booking)
//    {
//        $booking->update($request->all());
//
//        return (new BookingResource($booking))
//            ->response()
//            ->setStatusCode(Response::HTTP_ACCEPTED);
//    }
//
//    /**
//     * Delete reservation by ID
//     */
//    public function destroy(Booking $booking)
//    {
////        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//
//        $booking->delete();
//
//        return response(null, Response::HTTP_NO_CONTENT);
//    }
}
