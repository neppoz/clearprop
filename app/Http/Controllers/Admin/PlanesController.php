<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyPlaneRequest;
use App\Http\Requests\StorePlaneRequest;
use App\Http\Requests\UpdatePlaneRequest;
use App\Plane;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PlanesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('plane_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $planes = Plane::all();

        return view('admin.planes.index', compact('planes'));
    }

    public function create()
    {
        abort_if(Gate::denies('plane_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.planes.create');
    }

    public function store(StorePlaneRequest $request)
    {
        $plane = Plane::create($request->all());

        return redirect()->route('admin.planes.index');

    }

    public function edit(Plane $plane)
    {
        abort_if(Gate::denies('plane_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.planes.edit', compact('plane'));
    }

    public function update(UpdatePlaneRequest $request, Plane $plane)
    {
        $plane->update($request->all());

        return redirect()->route('admin.planes.index');

    }

    public function show(Plane $plane)
    {
        abort_if(Gate::denies('plane_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plane->load('planeActivities', 'planeBookings', 'planeUsers');

        return view('admin.planes.show', compact('plane'));
    }

    public function destroy(Plane $plane)
    {
        abort_if(Gate::denies('plane_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $plane->delete();

        return back();

    }

    public function massDestroy(MassDestroyPlaneRequest $request)
    {
        Plane::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
