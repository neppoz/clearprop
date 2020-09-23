<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSlotRequest;
use App\Http\Requests\UpdateSlotRequest;
use App\Http\Resources\Admin\SlotResource;
use App\Models\Slot;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SlotsApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('slot_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SlotResource(Slot::with(['users'])->get());
    }

    public function store(StoreSlotRequest $request)
    {
        $slot = Slot::create($request->all());
        $slot->users()->sync($request->input('users', []));

        return (new SlotResource($slot))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Slot $slot)
    {
        abort_if(Gate::denies('slot_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new SlotResource($slot->load(['users']));
    }

    public function update(UpdateSlotRequest $request, Slot $slot)
    {
        $slot->update($request->all());
        $slot->users()->sync($request->input('users', []));

        return (new SlotResource($slot))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Slot $slot)
    {
        abort_if(Gate::denies('slot_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $slot->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
