<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyActivityRequest;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Plane;
use App\Type;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ActivitiesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Activity::with(['user', 'copilot', 'instructor', 'plane', 'type', 'created_by'])->select(sprintf('%s.*', (new Activity)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'activity_show';
                $editGate      = 'activity_edit';
                $deleteGate    = 'activity_delete';
                $crudRoutePart = 'activities';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : "";
            });
            $table->addColumn('user_name', function ($row) {
                return $row->user ? $row->user->name : '';
            });

            $table->addColumn('copilot_name', function ($row) {
                return $row->copilot ? $row->copilot->name : '';
            });

            $table->addColumn('instructor_name', function ($row) {
                return $row->instructor ? $row->instructor->name : '';
            });

            $table->addColumn('plane_callsign', function ($row) {
                return $row->plane ? $row->plane->callsign : '';
            });

            $table->editColumn('plane.model', function ($row) {
                return $row->plane ? (is_string($row->plane) ? $row->plane : $row->plane->model) : '';
            });
            $table->addColumn('type_name', function ($row) {
                return $row->type ? $row->type->name : '';
            });

            $table->editColumn('type.active', function ($row) {
                return $row->type ? (is_string($row->type) ? $row->type : $row->type->active) : '';
            });

            $table->editColumn('event_start', function ($row) {
                return $row->event_start ? $row->event_start : "";
            });
            $table->editColumn('event_stop', function ($row) {
                return $row->event_stop ? $row->event_stop : "";
            });
            $table->editColumn('engine_warmup', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->engine_warmup ? 'checked' : null) . '>';
            });
            $table->editColumn('warmup_start', function ($row) {
                return $row->warmup_start ? $row->warmup_start : "";
            });
            $table->editColumn('warmup_minutes', function ($row) {
                return $row->warmup_minutes ? $row->warmup_minutes : "";
            });
            $table->editColumn('counter_start', function ($row) {
                return $row->counter_start ? $row->counter_start : "";
            });
            $table->editColumn('counter_stop', function ($row) {
                return $row->counter_stop ? $row->counter_stop : "";
            });
            $table->editColumn('rate', function ($row) {
                return $row->rate ? $row->rate : "";
            });
            $table->editColumn('minutes', function ($row) {
                return $row->minutes ? $row->minutes : "";
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : "";
            });
            $table->editColumn('departure', function ($row) {
                return $row->departure ? $row->departure : "";
            });
            $table->editColumn('arrival', function ($row) {
                return $row->arrival ? $row->arrival : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'copilot', 'instructor', 'plane', 'type', 'engine_warmup']);

            return $table->make(true);
        }

        return view('admin.activities.index');
    }

    public function create()
    {
        abort_if(Gate::denies('activity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $copilots = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $instructors = User::where('instructor', '=', true)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        $types_opt1 = Type::where(['active' => true, 'instructor' => 0])->pluck('name', 'id');
        $types_opt2 = Type::where(['active' => true, 'instructor' => 1])->pluck('name', 'id');

        return view('admin.activities.create', compact('users', 'copilots', 'instructors', 'planes', 'types_opt1', 'types_opt2'));
    }

    public function store(StoreActivityRequest $request)
    {
        $activity = Activity::create($request->all());

        return redirect()->route('admin.activities.index');
    }

    public function edit(Activity $activity)
    {
        abort_if(Gate::denies('activity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $copilots = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $instructors = User::where('instructor', '=', true)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        $types = Type::where('active', '=', true)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $activity->load('user', 'copilot', 'instructor', 'plane', 'type', 'created_by');

        return view('admin.activities.edit', compact('users', 'copilots', 'instructors', 'planes', 'types', 'activity'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->all());

        return redirect()->route('admin.activities.index');
    }

    public function show(Activity $activity)
    {
        abort_if(Gate::denies('activity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activity->load('user', 'copilot', 'instructor', 'plane', 'type', 'created_by');

        return view('admin.activities.show', compact('activity'));
    }

    public function destroy(Activity $activity)
    {
        abort_if(Gate::denies('activity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activity->delete();

        return back();
    }

    public function massDestroy(MassDestroyActivityRequest $request)
    {
        Activity::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
