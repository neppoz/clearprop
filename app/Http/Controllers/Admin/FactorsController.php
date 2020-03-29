<?php

namespace App\Http\Controllers\Admin;

use App\Factor;
use App\Type;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyFactorRequest;
use App\Http\Requests\StoreFactorRequest;
use App\Http\Requests\UpdateFactorRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class FactorsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('factor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $factors = Factor::all();

        return view('admin.factors.index', compact('factors'));
    }

    public function create()
    {
        abort_if(Gate::denies('factor_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = Type::all();

        return view('admin.factors.create', compact('types'));
    }

    public function store(StoreFactorRequest $request)
    {
        $factor = Factor::create($request->all());

        $types = $request->input('types', []);
        $rates = $request->input('rates', []);
        for ($type=0; $type < count($types); $type++) {
            if ($types[$type] != '') {
                $factor->factor_types()->attach($types[$type], ['rate' => $rates[$type]]);
            }
        }

        return redirect()->route('admin.factors.index');
    }

    public function edit(Factor $factor)
    {
        abort_if(Gate::denies('factor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = Type::all();

        $factor->load(['factor_types']);

        return view('admin.factors.edit', compact('types', 'factor'));
    }

    public function update(UpdateFactorRequest $request, Factor $factor)
    {
        $factor->update($request->all());

        $factor->factor_types()->detach();
        $types = $request->input('types', []);
        $rates = $request->input('rates', []);
        for ($type=0; $type < count($types); $type++) {
            if ($types[$type] != '') {
                $factor->factor_types()->attach($types[$type], ['rate' => $rates[$type]]);
            }
        }

        return redirect()->route('admin.factors.index');
    }

    public function show(Factor $factor)
    {
        abort_if(Gate::denies('factor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $factor->load('factorUsers');

        return view('admin.factors.show', compact('factor'));
    }

    public function destroy(Factor $factor)
    {
        abort_if(Gate::denies('factor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $factor->delete();

        return back();
    }

    public function massDestroy(MassDestroyFactorRequest $request)
    {
        Factor::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
