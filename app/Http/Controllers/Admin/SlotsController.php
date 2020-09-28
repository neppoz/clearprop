<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySlotRequest;
use App\Http\Requests\StoreSlotRequest;
use App\Http\Requests\UpdateSlotRequest;
use App\Slot;
use App\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SlotsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('slot_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $slots = Slot::all();

        return view('admin.slots.index', compact('slots'));
    }

    public function create()
    {
        abort_if(Gate::denies('slot_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id');

        return view('admin.slots.create', compact('users'));
    }

    public function store(StoreSlotRequest $request)
    {
        $slot = Slot::create($request->all());
        $slot->users()->sync($request->input('users', []));

        return redirect()->route('admin.slots.index');
    }

    public function edit(Slot $slot)
    {
        abort_if(Gate::denies('slot_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::all()->pluck('name', 'id');

        $slot->load('users');

        return view('admin.slots.edit', compact('users', 'slot'));
    }

    public function update(UpdateSlotRequest $request, Slot $slot)
    {
        $slot->update($request->all());
        $slot->users()->sync($request->input('users', []));

        return redirect()->route('admin.slots.index');
    }

    public function show(Slot $slot)
    {
        abort_if(Gate::denies('slot_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $slot->load('users', 'slotBookings');

        return view('admin.slots.show', compact('slot'));
    }

    public function destroy(Slot $slot)
    {
        abort_if(Gate::denies('slot_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $slot->delete();

        return back();
    }

    public function massDestroy(MassDestroySlotRequest $request)
    {
        Slot::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
