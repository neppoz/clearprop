<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use App\Http\Resources\Admin\TypeResource;
use App\Type;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Types
 *
 */
class TypesApiController extends Controller
{
    /**
     * Get ALL types
     */
    public function index()
    {
        abort_if(Gate::denies('type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = Type::where('active', 1)->get();

        return TypeResource::collection($types);
    }

    /**
     * Create types
     */
    public function store(StoreTypeRequest $request)
    {
        $type = Type::create($request->all());

        return (new TypeResource($type))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Get type by ID
     */
    public function show(Type $type)
    {
        abort_if(Gate::denies('type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new TypeResource($type);
    }

    /**
     * Update types
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $type->update($request->all());

        return (new TypeResource($type))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Delete type by ID
     */
    public function destroy(Type $type)
    {
        abort_if(Gate::denies('type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $type->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
