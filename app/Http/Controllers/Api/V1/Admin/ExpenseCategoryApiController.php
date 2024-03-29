<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\ExpenseCategory;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseCategoryRequest;
use App\Http\Requests\UpdateExpenseCategoryRequest;
use App\Http\Resources\Admin\ExpenseCategoryResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseCategoryApiController extends Controller
{
    /**
     * @hideFromAPIDocumentation
     */
    public function index()
    {
        abort_if(Gate::denies('expense_category_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseCategoryResource(ExpenseCategory::all());
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function store(StoreExpenseCategoryRequest $request)
    {
        $expenseCategory = ExpenseCategory::create($request->all());

        return (new ExpenseCategoryResource($expenseCategory))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function show(ExpenseCategory $expenseCategory)
    {
        abort_if(Gate::denies('expense_category_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ExpenseCategoryResource($expenseCategory);
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function update(UpdateExpenseCategoryRequest $request, ExpenseCategory $expenseCategory)
    {
        $expenseCategory->update($request->all());

        return (new ExpenseCategoryResource($expenseCategory))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @hideFromAPIDocumentation
     */
    public function destroy(ExpenseCategory $expenseCategory)
    {
        abort_if(Gate::denies('expense_category_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $expenseCategory->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
