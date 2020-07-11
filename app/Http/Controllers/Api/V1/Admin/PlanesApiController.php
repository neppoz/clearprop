<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePlaneRequest;
use App\Http\Requests\UpdatePlaneRequest;
use App\Http\Resources\Admin\PlaneResource;
use App\Plane;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Planes
 *
 */
class PlanesApiController extends Controller
{
    /**
     * Get ALL planes
     */
    public function index()
    {
        abort_if(Gate::denies('plane_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlaneResource(Plane::all());
    }

    /**
     * Create planes
     */
    public function store(StorePlaneRequest $request)
    {
        $plane = Plane::create($request->all());

        return (new PlaneResource($plane))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Get plane by ID
     */
    public function show(Plane $plane)
    {
        abort_if(Gate::denies('plane_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new PlaneResource($plane);
    }

    /**
     * Update plane
     */
    public function update(UpdatePlaneRequest $request, Plane $plane)
    {
        $plane->update($request->all());

        return (new PlaneResource($plane))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Delete plane by ID
     */
    public function destroy(Plane $plane)
    {
        abort_if(Gate::denies('plane_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plane->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
