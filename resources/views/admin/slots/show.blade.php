@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.slot.title') }}
        </div>

        <div class="card-body">
            <div class="form-group">
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.slots.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.slot.fields.id') }}
                        </th>
                        <td>
                            {{ $slot->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.slot.fields.title') }}
                        </th>
                        <td>
                            {{ $slot->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.slot.fields.user') }}
                        </th>
                        <td>
                            @foreach($slot->users as $key => $user)
                                <span class="label label-info">{{ $user->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="form-group">
                    <a class="btn btn-default" href="{{ route('admin.slots.index') }}">
                        {{ trans('global.back_to_list') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            {{ trans('global.relatedData') }}
        </div>
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link" href="#slot_bookings" role="tab" data-toggle="tab">
                    {{ trans('cruds.booking.title') }}
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" role="tabpanel" id="slot_bookings">
                @includeIf('admin.slots.relationships.slotBookings', ['bookings' => $slot->slotBookings])
            </div>
        </div>
    </div>

@endsection
