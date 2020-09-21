<?php

namespace App\Http\Controllers\Frontend;

use App\Booking;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Plane;
use App\Services\BookingStatusService;
use App\Services\UserCheckService;
use App\Services\BookingCheckService;
use App\Type;
use App\User;
use Gate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BookingsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $sources = [
            [
                'model' => '\\App\\Booking',
                'date_field' => 'reservation_start',
                'end_field' => 'reservation_stop',
                'route' => 'admin.bookings.edit',
            ],
        ];

        $events = [];

        foreach ($sources as $source) {
            foreach ($source['model']::with(['user', 'plane', 'instructor'])->orderby($source['date_field'], 'asc')->get() as $model) {
                $crudFieldValue = $model->getOriginal($source['date_field']);
                $crudEndFieldValue = $model->getOriginal($source['end_field']);

                if (!$crudFieldValue) {
                    continue;
                }
                // Define defaults
                $title = trim($model->plane->callsign
                    . ": " . ($model->user->name ?? '')
                    . " [" . $model::STATUS_RADIO[$model->status] . "] ");
                $url = [];
                $textColor = [];

                if (!empty($model->instructor_id)) {
                    $title = trim($model->plane->callsign
                        . ": " . ($model->user->name ?? '')
                        . " [" . $model::STATUS_RADIO[$model->status]
                        . " - " . $model->instructor->name . "] ");
                }
                if (auth()->user()->is_admin or auth()->user()->is_manager) {
                    $url = route($source['route'], $model->id);
                    $textColor = [];
                }
                if (auth()->user()->id === $model->user_id) {
                    $url = route($source['route'], $model->id);
                    $textColor = ['text-primary'];
                }
                // Complex logic: checking if instructor, requires instructor, status is open and/or it is assigned to him
                if ((auth()->user()->IsInstructorByFlag() && $model->instructor_needed === 1 && $model->status === 0) or (auth()->user()->id === $model->instructor_id)) {
                    $url = route($source['route'], $model->id);
                    $textColor = ['text-primary'];
                }

                $events[] = [
                    'title' => $title,
                    'start' => Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $crudFieldValue)->format('Y-m-d H:i:s'),
                    'end' => Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $crudEndFieldValue)->format('Y-m-d H:i:s'),
                    'url' => $url,
                    'classNames' => $textColor,
                ];
            }
        }
        return view('admin.bookings.index', compact('events'));
    }

    public function create()
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.bookings.create', compact('planes'));

//        if (auth()->user()->IsAdminByRole() OR auth()->user()->IsManagerByRole()) {
//            return view('admin.bookings.create', compact('users', 'planes', 'instructors'));
//        } else {
//            $user = auth()->user();
//            if ((new UserCheckService())->medicalCheckPassed($user)) {
//                if ((new UserCheckService())->balanceCheckPassed($user)) {
//                    if ((new UserCheckService())->activityCheckPassed($user)) {
//                        return view('admin.bookings.create', compact('user', 'planes'));
//                    } else {
//                        return back()->withToastError(trans('global.activityCheck'));
//                    }
//                } else {
//                    return back()->withToastError(trans('global.balanceCheck'));
//                }
//            } else {
//                return back()->withToastError(trans('global.medicalCheck'));
//            }
//        }
    }

    public function store(StoreBookingRequest $request)
    {
        if ((new BookingCheckService())->availabilityCheckPassed($request)) {

            $booking = Booking::create($request->all());

            (new BookingStatusService())->createStatus($booking);

            return redirect()->route('frontend.bookings.index');
        }

        return back()->withToastError(trans('global.planeNotAvailable'));
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        $instructors = User::where('instructor', '=', true)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $booking->load('user', 'plane', 'created_by');

        return view('admin.bookings.edit', compact('users', 'planes', 'booking', 'instructors'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());

        if ($booking->wasChanged('status')) { // Verify if status has changed
            (new BookingStatusService())->updateStatus($booking);
        }

        return redirect()->route('admin.bookings.index');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->load('user', 'plane', 'created_by');

        return view('admin.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

//        event(new BookingDeletedEvent($booking));

        return redirect()->route('admin.bookings.index');
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        Booking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
