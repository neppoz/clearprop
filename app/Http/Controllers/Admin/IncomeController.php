<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyIncomeRequest;
use App\Http\Requests\StoreIncomeRequest;
use App\Http\Requests\UpdateIncomeRequest;
use App\Income;
use App\IncomeCategory;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class IncomeController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('income_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Income::with(['user', 'income_category', 'created_by'])->select(sprintf('%s.*', (new Income)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate = 'income_show';
                $editGate = 'income_edit';
                $deleteGate = 'income_delete';
                $crudRoutePart = 'incomes';

                return view('partials.datatablesAdminActions', compact(
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

            $table->addColumn('income_category_name', function ($row) {
                return $row->income_category ? $row->income_category->name : '';
            });

            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : "";
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : "";
            });

            $table->rawColumns(['actions', 'placeholder', 'user', 'income_category']);

            return $table->make(true);
        }

        return view('admin.incomes.index');
    }

    public function create()
    {
        abort_if(Gate::denies('income_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $income_categories = IncomeCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.incomes.create', compact('users', 'income_categories'));
    }

    public function store(StoreIncomeRequest $request)
    {
        $income = Income::create($request->all());

        return redirect()->route('admin.incomes.index');
    }

    public function edit(Income $income)
    {
        abort_if(Gate::denies('income_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $income_categories = IncomeCategory::all()->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $income->load('user', 'income_category', 'created_by');

        return view('admin.incomes.edit', compact('users', 'income_categories', 'income'));
    }

    public function update(UpdateIncomeRequest $request, Income $income)
    {
        $income->update($request->all());

        return redirect()->route('admin.incomes.index');
    }

    public function show(Income $income)
    {
        abort_if(Gate::denies('income_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $income->load('user', 'income_category', 'created_by');

        return view('admin.incomes.show', compact('income'));
    }

    public function destroy(Income $income)
    {
        abort_if(Gate::denies('income_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $income->delete();

        return back();
    }

    public function massDestroy(MassDestroyIncomeRequest $request)
    {
        Income::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function getIncomesByUser(Request $request)
    {
        abort_if(Gate::denies('income_access', 'user_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax() and !empty($request->user_id)) {
            try {
                $query = Income::with(['user', 'income_category', 'created_by'])
                    ->where('user_id', $request->user_id)
                    ->select(sprintf('%s.*', (new Income)->table));
                $table = Datatables::of($query);

                $table->addColumn('placeholder', '&nbsp;');
                $table->addColumn('actions', '&nbsp;');

                $table->editColumn('actions', function ($row) {
                    $viewGate = 'income_show';
                    $editGate = 'income_edit';
                    $deleteGate = 'income_delete';
                    $crudRoutePart = 'incomes';

                    return view('partials.datatablesAdminActions', compact(
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

                $table->addColumn('income_category_name', function ($row) {
                    return $row->income_category ? $row->income_category->name : '';
                });

                $table->editColumn('amount', function ($row) {
                    return $row->amount ? $row->amount : "";
                });
                $table->editColumn('description', function ($row) {
                    return $row->description ? $row->description : "";
                });

                $table->rawColumns(['actions', 'placeholder', 'user', 'income_category']);

                return $table->make(true);
            } catch (\Throwable $exception) {
                report($exception);
                return back()->withToastError($exception->getMessage());
            }
        }
        return false;
    }
}
