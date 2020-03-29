<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyParameterRequest;
use App\Http\Requests\StoreParameterRequest;
use App\Http\Requests\UpdateParameterRequest;
use App\Parameter;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParametersController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('parameter_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $parameters = Parameter::all();

        return view('admin.parameters.index', compact('parameters'));
    }

    public function create()
    {
        abort_if(Gate::denies('parameter_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.parameters.create');
    }

    public function store(StoreParameterRequest $request)
    {
        $parameter = Parameter::create($request->all());

        return redirect()->route('admin.parameters.index');

    }

    public function edit(Parameter $parameter)
    {
        abort_if(Gate::denies('parameter_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.parameters.edit', compact('parameter'));
    }

    public function update(UpdateParameterRequest $request, Parameter $parameter)
    {
        $parameter->update($request->all());

        return redirect()->route('admin.parameters.index');

    }

    public function show(Parameter $parameter)
    {
        abort_if(Gate::denies('parameter_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.parameters.show', compact('parameter'));
    }

    public function destroy(Parameter $parameter)
    {
        abort_if(Gate::denies('parameter_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $parameter->delete();

        return back();

    }

    public function massDestroy(MassDestroyParameterRequest $request)
    {
        Parameter::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
