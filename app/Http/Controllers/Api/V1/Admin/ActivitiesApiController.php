<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Activity;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use App\Http\Resources\Admin\ActivityResource;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Activities
 *
 */
class ActivitiesApiController extends Controller
{
    /**
     * Get ALL activities
     */
    public function index()
    {
        abort_if(Gate::denies('activity_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ActivityResource(
            Activity::with(['user', 'copilot', 'instructor', 'plane', 'type', 'created_by'])
            ->where('user_id', auth()->user()->id)
            ->get()
        );
    }

    /**
     * Create activities
     */
    public function store(StoreActivityRequest $request)
    {
        $activity = Activity::create($request->all());

        return (new ActivityResource($activity))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Get activities by ID
     */
    public function show(Activity $activity)
    {
        abort_if(Gate::denies('activity_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ActivityResource(
            Activity::with(['user', 'copilot', 'instructor', 'plane', 'type', 'created_by'])
            ->where('user_id', auth()->user()->id)
            ->get()
        );
    }

    /**
     * Update activities
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $activity->update($request->all());

        return (new ActivityResource($activity))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * Delete activities by ID
     */
    public function destroy(Activity $activity)
    {
        abort_if(Gate::denies('activity_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $activity->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
