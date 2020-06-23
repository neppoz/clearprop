<?php

namespace App\Http\Controllers\Admin;

use App\Activity;
use App\Events\ActivityCostCalculation;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyActivityRequest;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Listeners\ActivitySplitCostListener;
use App\Plane;
use App\Type;
use App\User;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as SupportCollection;
use PhpParser\ErrorHandler\Collecting;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class ActivitiesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Activity::with(['user', 'type', 'copilot', 'instructor', 'plane'])
                ->when(auth()->user()->roles->contains(1) !=true, function ($query) {
                    return $query->where('user_id', auth()->id());
                })
                ->select(sprintf('%s.*', (new Activity)->table));

            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->addColumn('split_color', '&nbsp;');
            $table->addColumn('warmup_color', '&nbsp;');

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

            $table->addColumn('type_name', function ($row) {
                return $row->type ? $row->type->name : '';
            });

            $table->editColumn('type.active', function ($row) {
                return $row->type ? (is_string($row->type) ? $row->type : $row->type->active) : '';
            });

            $table->addColumn('plane_callsign', function ($row) {
                return $row->plane ? $row->plane->callsign : '';
            });

            $table->editColumn('plane.model', function ($row) {
                return $row->plane ? (is_string($row->plane) ? $row->plane : $row->plane->model) : '';
            });

            $table->editColumn('counter_start', function ($row) {
                return $row->counter_start ? $row->counter_start : "";
            });
            $table->editColumn('counter_stop', function ($row) {
                return $row->counter_stop ? $row->counter_stop : "";
            });

            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : "";
            });

            $table->editColumn('split_color', function ($row) {
                return $row->split_cost && ['1' => '#f0ad4e'][$row->split_cost] ? ['1' => '#f0ad4e'][$row->split_cost] : 'none';
            });

            $table->editColumn('warmup_color', function ($row) {
                return $row->engine_warmup && ['1' => '#0275d8'][$row->engine_warmup] ? ['1' => '#0275d8'][$row->engine_warmup] : 'none';
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'type', 'plane']);

            return $table->make(true);
        }

        return view('admin.activities.index');
    }

    public function create()
    {
        abort_if(Gate::denies('activity_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $types_opt1 = Type::where(['active' => true, 'instructor' => 0])->pluck('name', 'id');
        $types_opt2 = Type::where(['active' => true, 'instructor' => 1])->pluck('name', 'id');

        $copilots = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $instructors = User::where('instructor', '=', true)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.activities.create', compact('users', 'types_opt1', 'types_opt2', 'copilots', 'instructors', 'planes'));
    }

    public function store(StoreActivityRequest $request)
    {
        if ($request->split_cost == false) {
            $activity = Activity::create($request->all());
            event(new ActivityCostCalculation($activity));
        }

        if ($request->split_cost == true && isset($request->copilot_id)) {
            // TODO: Event und Listener bereits erstellt, Controller entschlacken
            // $activity = $request->all();
            // event(new ActivitySplitCost($activity));

            $data_pilot = clone $request;
            $data_copilot = clone $request;

            $counter_split_value = ($request->counter_stop-$request->counter_start)/2;
            $counter_start_p    = $request->counter_start;
            $counter_stop_p     = $counter_start_p+$counter_split_value;
            $counter_start_c    = $counter_stop_p;
            $counter_stop_c     = $counter_start_c+$counter_split_value;

            $data_copilot->merge([
                'user_id' => $data_pilot->copilot_id,
                'copilot_id' => $data_pilot->user_id,
            ]);
            $data_pilot->merge([
                'counter_start' => $counter_start_p,
                'counter_stop' => $counter_stop_p,
            ]);
            $data_copilot->merge([
                'counter_start' => $counter_start_c,
                'counter_stop' => $counter_stop_c,
            ]);

            if ($request->engine_warmup == true) {
                $warmup_split_value = ($request->counter_start-$request->warmup_start)/2;
                $warmup_start_p     = $request->warmup_start;
                $counter_start_p    = $request->warmup_start+$warmup_split_value;
                $counter_stop_p     = $counter_start_p+$counter_split_value;
                $warmup_start_c     = $counter_stop_p;
                $counter_start_c    = $counter_stop_p+$warmup_split_value;
                $counter_stop_c     = $counter_start_c+$counter_split_value;

                $data_pilot->merge([
                    'warmup_start' => $warmup_start_p,
                    'counter_start' => $counter_start_p,
                    'counter_stop' => $counter_stop_p,
                ]);

                $data_copilot->merge([
                    'warmup_start' => $warmup_start_c,
                    'counter_start' => $counter_start_c,
                    'counter_stop' => $counter_stop_c,
                ]);
            };

            /** Create two records */
            $activity = Activity::create($data_pilot->all());
            $activity = Activity::create($data_copilot->all());
        }

        return redirect()->route('admin.activities.index');
    }

    public function edit(Activity $activity)
    {
        abort_if(Gate::denies('activity_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $types = Type::where('active', '=', true)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $copilots = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $instructors = User::where('instructor', '=', true)->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planes = Plane::all()->pluck('callsign', 'id')->prepend(trans('global.pleaseSelect'), '');

        $activity->load('user', 'copilot', 'instructor', 'plane', 'type');

        return view('admin.activities.edit', compact('users', 'types', 'copilots', 'instructors', 'planes', 'activity'));
    }

    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->all());
        event(new ActivityCostCalculation($activity));

        return redirect()->route('admin.activities.index');
    }

    public function show(Activity $activity)
    {
        abort_if(Gate::denies('activity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activity->load('user', 'copilot', 'instructor', 'plane', 'type');

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
