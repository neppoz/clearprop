<?php

namespace App\Http\Controllers\Admin;

use App\Factor;
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

        return view('admin.factors.create');
    }

    public function store(StoreFactorRequest $request)
    {
        $factor = Factor::create($request->all());

        return redirect()->route('admin.factors.index');

    }

    public function edit(Factor $factor)
    {
        abort_if(Gate::denies('factor_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.factors.edit', compact('factor'));
    }

    public function update(UpdateFactorRequest $request, Factor $factor)
    {
        $factor->update($request->all());

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
