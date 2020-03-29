<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyTypeRequest;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Type;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TypesController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = Type::all();

        return view('admin.types.index', compact('types'));
    }

    public function create()
    {
        abort_if(Gate::denies('type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.types.create');
    }

    public function store(StoreTypeRequest $request)
    {
        $type = Type::create($request->all());

        return redirect()->route('admin.types.index');

    }

    public function edit(Type $type)
    {
        abort_if(Gate::denies('type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.types.edit', compact('type'));
    }

    public function update(UpdateTypeRequest $request, Type $type)
    {
        $type->update($request->all());

        return redirect()->route('admin.types.index');

    }

    public function show(Type $type)
    {
        abort_if(Gate::denies('type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.types.show', compact('type'));
    }

    public function destroy(Type $type)
    {
        abort_if(Gate::denies('type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $type->delete();

        return back();

    }

    public function massDestroy(MassDestroyTypeRequest $request)
    {
        Type::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);

    }
}
