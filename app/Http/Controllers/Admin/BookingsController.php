<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBookingRequest;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use App\Services\BookingStatusService;
use App\Services\UserCheckService;
use App\Services\BookingCheckService;
use App\Booking;
use App\Plane;
use App\Type;
use App\User;
use App\Slot;
use Gate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BookingsController extends Controller
{
//    public function index(Request $request)
//    {
//        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
//
//        $sources = [
//            [
//                'model'      => '\\App\\Booking',
//                'date_field' => 'reservation_start',
//                'end_field'  => 'reservation_stop',
//                'route'      => 'admin.bookings.edit',
//            ],
//        ];
//
//        $events = [];
//
////        foreach ($sources as $source) {
////            foreach ($source['model']::with(['user', 'plane', 'instructor'])->orderby($source['date_field'], 'asc')->get() as $model) {
////                $crudFieldValue = $model->getOriginal($source['date_field']);
////                $crudEndFieldValue = $model->getOriginal($source['end_field']);
////
////                if (!$crudFieldValue) {
////                    continue;
////                }
////                // Define defaults
////                $title = trim($model->plane->callsign
////                    . ": " . ($model->user->name ?? '')
////                    . " [" . $model::STATUS_RADIO[$model->status] . "] ");
////                $url = [];
////                $textColor = [];
////
////                if (!empty($model->instructor_id)) {
////                    $title = trim($model->plane->callsign
////                        . ": " . ($model->user->name ?? '')
////                        . " [" . $model::STATUS_RADIO[$model->status]
////                        . " - " . $model->instructor->name . "] ");
////                }
////                if (auth()->user()->is_admin or auth()->user()->is_manager) {
////                    $url = route($source['route'], $model->id);
////                    $textColor = [];
////                }
////                if (auth()->user()->id === $model->user_id) {
////                    $url = route($source['route'], $model->id);
////                    $textColor = ['text-primary'];
////                }
////                // Complex logic: checking if instructor, requires instructor, status is open and/or it is assigned to him
////                if ((auth()->user()->IsInstructorByFlag() && $model->instructor_needed === 1 && $model->status === 0) or (auth()->user()->id === $model->instructor_id)) {
////                    $url = route($source['route'], $model->id);
////                    $textColor = ['text-primary'];
////                }
////
////                $events[] = [
////                    'title' => $title,
////                    'start' => Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $crudFieldValue)->format('Y-m-d H:i:s'),
////                    'end' => Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $crudEndFieldValue)->format('Y-m-d H:i:s'),
////                    'extendedProps' => [
////                        'status' => $model->status,
////                    ],
////                    'url' => $url,
////                    'classNames' => $textColor,
////                ];
////            }
////        }
//
//        return view('admin.bookings.index', compact('events'));
//    }
    public function index(Request $request)
    {
        abort_if(Gate::denies('booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Booking::with(['user', 'instructor', 'plane', 'slot'])
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

                return view('admin.bookings.partials.datatablesActions', compact(
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

            $table->editColumn('modus', function ($row) {
                return Booking::MODUS_SELECT[$row->modus] ?? '';
            });

            $table->editColumn('status', function ($row) {
                return Booking::STATUS_RADIO[$row->status] ?? '';
            });

            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('instructor_name', function ($row) {
                return $row->instructor ? $row->instructor->name : '';
            });

            $table->addColumn('plane_callsign', function ($row) {
                return $row->plane ? $row->plane->callsign : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'instructor', 'plane']);

            return $table->make(true);
        }

        $users = User::get();
        $instructors = User::where('instructor', true)->get();
        $planes = Plane::get();

        return view('admin.bookings.index', compact('users', 'planes', 'instructors'));
    }

    public function create(Request $request)
    {
        abort_if(Gate::denies('booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

//        $modus = $request->modus;

        $slots = Slot::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $types = Type::where('active', '=', true)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');;

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        $instructors = User::where('instructor', '=', true)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
//        return view('admin.bookings.create', compact('users', 'types', 'planes', 'instructors', 'slots', 'modus'));
        return view('admin.bookings.create', compact('users', 'types', 'planes', 'instructors', 'slots'));

    }

    public function store(StoreBookingRequest $request)
    {
        if ((new BookingCheckService())->availabilityCheckPassed($request)) {

            $booking = Booking::create($request->all());

            if ($request->email == true) {
                (new BookingStatusService())->sendNotificationsConfirmed($booking);
            }
//            (new BookingStatusService())->createStatus($booking);

            return redirect()->route('admin.bookings.index');
        }

        return back()->withToastError(trans('global.planeNotAvailable'));
    }

    public function edit(Booking $booking)
    {
        abort_if(Gate::denies('booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        $instructors = User::where('instructor', '=', true)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $slots = Slot::all()->pluck('title', 'id')->prepend(trans('global.pleaseSelect'), '');

        $booking->load('user', 'plane', 'instructor', 'slot', 'created_by');

        return view('admin.bookings.edit', compact('users', 'planes', 'instructors', 'slots', 'booking'));
    }

    public function update(UpdateBookingRequest $request, Booking $booking)
    {
//        $booking->modus = 0; // Is it a bug or is it a feature?
        $booking->update($request->all());

        if ($request->email == true) {
            (new BookingStatusService())->sendNotificationsConfirmed($booking);
        }

//        if ($booking->wasChanged('status')) { // Verify if status has changed
//            (new BookingStatusService())->updateStatus($booking);
//        }

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

        return redirect()->route('admin.bookings.index');
    }

    public function massDestroy(MassDestroyBookingRequest $request)
    {
        Booking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
