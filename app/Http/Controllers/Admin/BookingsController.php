<?php

namespace App\Http\Controllers\Admin;

use App\Booking;
use App\Events\BookingCreatedEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Plane;
use App\Services\UserCheckService;
use App\Services\BookingCheckService;
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
                'model'      => '\\App\\Booking',
                'date_field' => 'reservation_start',
                'end_field'  => 'reservation_stop',
                'field'      => 'description',
                'prefix'     => '',
                'suffix'     => '',
                'route'      => 'admin.bookings.edit',
            ],
        ];

        $events = [];

        foreach ($sources as $source) {
            foreach ($source['model']::with(['user', 'plane'])->orderby($source['date_field'], 'asc')->get() as $model) {
                $crudFieldValue = $model->getOriginal($source['date_field']);
                $crudEndFieldValue = $model->getOriginal($source['end_field']);

                if (!$crudFieldValue) {
                    continue;
                }

                $url = [];
                $textColor = [];

                if (auth()->user()->IsAdminRole()) {
                    $url = route($source['route'], $model->id);
                    $textColor = [];
                }

                if (auth()->user()->id === $model->user_id) {
                    $url = route($source['route'], $model->id);
                    $textColor = ['text-primary'];
                }

                $events[] = [
                    'title' => trim($source['prefix'] . " " . $model->plane->callsign
                        . ": " . $model->user->name
                        . " " .$model->{$source['field']}
                        . " " . $source['suffix']),
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

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        if (auth()->user()->IsAdminRole()) {
            return view('admin.bookings.create', compact('users', 'planes'));
        } else {
            $user = auth()->user();

            if ((new UserCheckService())->medicalCheckPassed($user)) {
                if ((new UserCheckService())->balanceCheckPassed($user)) {
                    if ((new UserCheckService())->activityCheckPassed($user)) {
                        // TODO: passing planes array from service (certain amount of activities on plane)
                        return view('admin.bookings.create', compact('user', 'planes'));
                    } else {
                        return back()->withToastError(trans('global.activityCheck'));
                    };
                } else {
                    return back()->withToastError(trans('global.balanceCheck'));
                };
            } else {
                return back()->withToastError(trans('global.medicalCheck'));
            };
        }
    }

    public function store(StoreBookingRequest $request)
    {
        if ((new BookingCheckService())->availabilityCheckPassed($request)) {
            // Book now
            $booking = Booking::create($request->all());
            event(new BookingCreatedEvent($booking));

            return redirect()->route('admin.bookings.index');
        }

        return back()->withToastError(trans('global.planeNotAvailable'));
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        $booking->load('user', 'plane', 'created_by');
//        debug('start: ' . $booking->reservation_start . ' stop: '. $booking->reservation_stop);
        return view('admin.bookings.edit', compact('users', 'planes', 'booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());

        return redirect()->route('admin.bookings.index');
        // if ((new BookingCheckService())->availabilityCheckPassed($request)) {
        //     $booking->update($request->all());

        //     return redirect()->route('admin.bookings.index');
        // }

        // return back()->withToastError(trans('global.planeNotAvailable'));
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

        return redirect()->route('admin.bookings.index');
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        Booking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
