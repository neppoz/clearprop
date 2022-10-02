<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Mode;
use App\Services\BookingNotificationService;
use App\Services\BookingCheckService;
use App\Booking;
use App\Plane;
use App\Services\BookingStatusService;
use App\User;
use App\Slot;
use Gate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BookingsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Booking::with(['bookingUsers', 'bookingInstructors', 'mode', 'slot', 'plane'])
                ->where('reservation_stop', '>=', today())
                ->orderBy('reservation_start', 'asc')
                ->select(sprintf('%s.*', (new Booking)->table));

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'booking_show';
                $editGate = 'booking_edit';
                $deleteGate = 'booking_delete';
                $crudRoutePart = 'bookings';

                return view('app.bookings.partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->addColumn('reservation_start_time', function ($row) {
                return Carbon::createFromFormat('d/m/Y H:i', $row->reservation_start)->format(config('panel.time_format'));
            });

            $table->addColumn('reservation_stop_time', function ($row) {
                return Carbon::createFromFormat('d/m/Y H:i', $row->reservation_stop)->format(config('panel.time_format'));
            });

            $table->addColumn('reservation_start_date_iso', function ($row) {
                return Carbon::createFromFormat('d/m/Y H:i', $row->reservation_start)->isoFormat('dddd, DD MMMM YYYY');
            });

            $table->addColumn('mode', function ($row) {
                if ($slot = $row->slot) {
                    return $row->mode->name . ': ' . $slot->title;
                }
                return $row->mode ? $row->mode->name : '';
            });

            $table->addColumn('status', function ($row) {
                $labels = [];

                if ($row->status === 0) {
                    $labels[] = sprintf('<i class="fas fa-question-circle fa-lg text-warning" aria-hidden="true"></i>');
                }
                if ($row->status === 1) {
                    $labels[] = sprintf('<i class="fas fa-check-circle fa-lg text-success" aria-hidden="true"></i>');
//                    $labels[] = sprintf('<span class="badge badge-success">%s</span>', Booking::STATUS_RADIO[$row->status]);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('user', function ($row) {
                $labels = [];

                if ($row->checkin === 1) {
                    $labels[] = sprintf('<span class="text-black-50 text-sm">' . trans('global.checkin_active') . ': +' . $row->seats_available . '</span><br>');

                }

                foreach ($row->bookingUsers as $user) {
                    $labels[] = sprintf('<span class="text">%s</span><br>', $user->name);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('instructor', function ($row) {
                $labels = [];

                if ($row->instructor_needed === 1 && $row->bookingInstructors->count() === 0) {
                    $labels[] = sprintf('<span class="badge badge-warning">' . trans('global.instructor_is_needed') . '</span><br>');
                }

                foreach ($row->bookingInstructors as $instructor) {
                    $labels[] = sprintf('<span class="text">%s</span><br>', $instructor->name);
                }

                return implode(' ', $labels);
            });

            $table->editColumn('plane_callsign', function ($row) {
                return $row->plane ? $row->plane->callsign : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'status', 'user', 'instructor', 'plane']);

            return $table->make(true);
        }

        $users = User::get();
        $modes = Mode::get();
        $planes = Plane::get();

        return view('app.bookings.index', compact('users', 'planes', 'modes'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mode_id = $request->mode_id ?? 1;
        $mode_name = $reqest->mode_name ?? 'Charter';

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $instructors = User::whereHas('roles', function ($role) {
            $role->where('role_id', User::IS_INSTRUCTOR);
        })->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('app.bookings.create', compact('mode_id', 'mode_name', 'planes', 'users', 'instructors'));

    }

    public function store(StoreBookingRequest $request)
    {
        if ((new BookingCheckService())->availabilityCheckPassed($request)) {

            $booking = Booking::create($request->all());

            (new BookingStatusService())->createStatus($request, $booking);

            return redirect()->route('app.home');
        }

        return back()->withToastError(trans('global.planeNotAvailable'));
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        $instructors = User::whereHas('roles', function ($role) {
            $role->where('role_id', User::IS_INSTRUCTOR);
        })->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $slots = Slot::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $booking->load('bookingUsers', 'plane', 'slot', 'created_by');

        return view('app.bookings.edit', compact('users', 'planes', 'instructors', 'slots', 'booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        $booking->update($request->all());
        $booking->bookingUsers()->sync($request->input('users', []));
        $booking->bookingInstructors()->sync($request->input('instructors', []));

        if ($request->input('email') == true) {
            (new BookingNotificationService())->sendNotificationsConfirmed($booking);
        }

        return redirect()->route('app.home');
    }

    public function show(Booking $booking)
    {
        abort_if(Gate::denies('booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->load('user', 'plane', 'created_by');

        return view('app.bookings.show', compact('booking'));
    }

    public function destroy(Booking $booking)
    {
        abort_if(Gate::denies('booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $booking->delete();

        return redirect()->route('app.home');
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        Booking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function book(Request $request)
    {
        $booking = Booking::findOrFail($request->id);

        (new BookingCheckService())->decrementSeats($booking);

        return redirect()->route('app.home');

    }

    public function revoke(Request $request)
    {
        $booking = Booking::findOrFail($request->id);

        (new BookingCheckService())->incrementSeats($booking);

        return redirect()->route('app.home');

    }
}
