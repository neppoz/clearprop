<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Factor;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFactorRequest;
use App\Http\Requests\UpdateFactorRequest;
use App\Http\Resources\Admin\FactorResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Factors
 * @authenticated
 */
class FactorsApiController extends Controller
{

    /**
     * Get ALL factors
     */
    public function index()
    {
//        abort_if(Gate::denies('factor_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FactorResource(Factor::all());
    }

    /**
     * Create factors
     */
    public function store(StoreFactorRequest $request)
    {
        $factor = Factor::create($request->all());

        return (new FactorResource($factor))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Get factor by ID
     */
    public function show(Factor $factor)
    {
//        abort_if(Gate::denies('factor_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new FactorResource($factor);
    }

    /**
     * Update factors
     */
    public function update(UpdateFactorRequest $request, Factor $factor)
    {
        $factor->update($request->all());

        return (new FactorResource($factor))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Delete factor by ID
     */
    public function destroy(Factor $factor)
    {
//        abort_if(Gate::denies('factor_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $factor->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
