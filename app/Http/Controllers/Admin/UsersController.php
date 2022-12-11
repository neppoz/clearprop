<?php

namespace App\Http\Controllers\Admin;

use App\Factor;
use App\Plane;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Role;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = User::with(['factor'])
                ->select(sprintf('%s.*', (new User)->table));
            debug($query);
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');
            $table->editColumn('actions', function ($row) {
                $viewGate = 'user_show';
                $editGate = 'user_edit';
                $deleteGate = 'user_delete';
                $crudRoutePart = 'users';

                return view('partials.datatablesAdminActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });
            $table->editColumn('lang', function ($row) {
                return $row->lang ? User::LANG_SELECT[strtoupper($row->lang)] : '';
            });

            $table->addColumn('factor_name', function ($row) {
                return $row->factor ? $row->factor->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'user']);

            $table->orderColumn('name', 'name $1')->toJson();

            return $table->make(true);
        }

        return view('admin.users.index');

    }

    public function create()
    {
        abort_if(Gate::denies('user_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $factors = Factor::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planes = Plane::all()->pluck('callsign', 'id');

        if (Gate::denies('user_self_to_admin')) {
            $roles = Role::where('id', '<>', 1)->pluck('title', 'id');
        } else {
            $roles = Role::pluck('title', 'id');
        }

        return view('admin.users.create', compact('factors', 'planes', 'roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->all());
        $user->planes()->sync($request->input('planes', []));
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        abort_if(Gate::denies('user_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $factors = Factor::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $planes = Plane::all()->pluck('callsign', 'id');

        if (Gate::denies('user_self_to_admin')) {
            $roles = Role::where('id', '<>', 1)->pluck('title', 'id');
        } else {
            $roles = Role::pluck('title', 'id');
        }

        $user->load('factor', 'planes', 'roles');

        return view('admin.users.edit', compact('factors', 'planes', 'roles', 'user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->all());
        $user->planes()->sync($request->input('planes', []));
        $user->roles()->sync($request->input('roles', []));

        return redirect()->route('admin.users.index');
    }

    public function show(User $user)
    {
        abort_if(Gate::denies('user_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->load('factor', 'planes', 'roles', 'userActivities', 'userBookings', 'instructorActivities', 'userIncomes');

        return view('admin.users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        abort_if(Gate::denies('user_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user->delete();

        return back();
    }

    public function massDestroy(MassDestroyUserRequest $request)
    {
        User::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function getDeletedUsers(Request $request)
    {
        abort_if(Gate::denies('user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            try {
                $query = User::onlyTrashed()->select(sprintf('%s.*', (new User)->table));

                $table = Datatables::of($query);

                $table->addColumn('placeholder', '&nbsp;');
                $table->addColumn('actions', '&nbsp;');
                $table->editColumn('actions', function ($row) {
                    $undeleteGate = 'user_undelete';
                    $crudRoutePart = 'users';

                    return view('partials.datatablesAdminCustomActions', compact(
                        'undeleteGate',
                        'crudRoutePart',
                        'row'
                    ));
                });
                $table->rawColumns(['actions', 'placeholder', 'user']);

                $table->orderColumn('name', 'name $1')->toJson();

                return $table->make(true);
            } catch (\Throwable $exception) {
                report($exception);
                return back()->withToastError($exception->getMessage());
            }
        }
        return false;
    }

    public function undelete($user_id)
    {
        abort_if(Gate::denies('user_undelete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        User::where('id', $user_id)->withTrashed()->restore();

        return back();
    }
}
