<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncomeCategoryRequest;
use App\Http\Requests\UpdateIncomeCategoryRequest;
use App\Http\Resources\Admin\IncomeCategoryResource;
use App\IncomeCategory;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IncomeCategoryApiController extends Controller
{
    /**
     * @hideFromAPIDocumentation
     */
    public function index()
    {
        abort_if(Gate::denies('income_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IncomeCategoryResource(IncomeCategory::all());
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function store(StoreIncomeCategoryRequest $request)
    {
        $incomeCategory = IncomeCategory::create($request->all());

        return (new IncomeCategoryResource($incomeCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function show(IncomeCategory $incomeCategory)
    {
        abort_if(Gate::denies('income_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new IncomeCategoryResource($incomeCategory);
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function update(UpdateIncomeCategoryRequest $request, IncomeCategory $incomeCategory)
    {
        $incomeCategory->update($request->all());

        return (new IncomeCategoryResource($incomeCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function destroy(IncomeCategory $incomeCategory)
    {
        abort_if(Gate::denies('income_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $incomeCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
