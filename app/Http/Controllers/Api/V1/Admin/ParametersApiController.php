<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreParameterRequest;
use App\Http\Requests\UpdateParameterRequest;
use App\Http\Resources\Admin\ParameterResource;
use App\Parameter;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ParametersApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('parameter_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ParameterResource(Parameter::all());

    }

    public function store(StoreParameterRequest $request)
    {
        $parameter = Parameter::create($request->all());

        return (new ParameterResource($parameter))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);

    }

    public function show(Parameter $parameter)
    {
        abort_if(Gate::denies('parameter_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ParameterResource($parameter);

    }

    public function update(UpdateParameterRequest $request, Parameter $parameter)
    {
        $parameter->update($request->all());

        return (new ParameterResource($parameter))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);

    }

    public function destroy(Parameter $parameter)
    {
        abort_if(Gate::denies('parameter_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $parameter->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
