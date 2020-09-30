<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Http\Resources\Admin\BookingResource;
use App\Services\BookingCheckService;
use App\Services\BookingStatusService;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Reservations
 * @authenticated
 */
class BookingsApiController extends Controller
{
    /**
     * Get ALL reservations
     */
    public function index()
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $bookings = Booking::with(['user', 'plane', 'created_by'])
            ->orderBy('reservation_start', 'desc')
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->paginate(25);

        return BookingResource::collection($bookings);
    }

    /**
     * Create reservations
     */
    public function store(StoreBookingRequest $request)
    {
        if ((new BookingCheckService())->availabilityCheckPassed($request)) {
            $booking = Booking::create($request->all());
            $booking->modus = 0;
            $booking->save();

            (new BookingStatusService())->createStatus($booking);

            return (new BookingResource($booking))
                ->response()
                ->setStatusCode(Response::HTTP_CREATED);
        }

        return response('Duplicate booking. No data saved.', Response::HTTP_FORBIDDEN);

    }

    /**
     * Get reservation by ID
     */
    public function show(Booking $booking)
    {
//        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new BookingResource($booking->load(['user', 'plane', 'created_by']));
    }

    /**
     * Update reservations
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());

        return (new BookingResource($booking))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Delete reservation by ID
     */
    public function destroy(Booking $booking)
    {
//        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
