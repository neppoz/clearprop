@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.plane.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.planes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.plane.fields.id') }}
                        </th>
                        <td>
                            {{ $plane->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plane.fields.callsign') }}
                        </th>
                        <td>
                            {{ $plane->callsign }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plane.fields.vendor') }}
                        </th>
                        <td>
                            {{ $plane->vendor }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plane.fields.model') }}
                        </th>
                        <td>
                            {{ $plane->model }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plane.fields.prodno') }}
                        </th>
                        <td>
                            {{ $plane->prodno }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plane.fields.counter_type') }}
                        </th>
                        <td>
                            {{ App\Plane::COUNTER_TYPE_SELECT[$plane->counter_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plane.fields.warmup_type') }}
                        </th>
                        <td>
                            {{ App\Plane::WARMUP_TYPE_RADIO[$plane->warmup_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.plane.fields.active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $plane->active ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.planes.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

{{--<div class="card">--}}
{{--    <div class="card-header">--}}
{{--        {{ trans('global.relatedData') }}--}}
{{--    </div>--}}
{{--    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#plane_activities" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.activity.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--        <li class="nav-item">--}}
{{--            <a class="nav-link" href="#plane_bookings" role="tab" data-toggle="tab">--}}
{{--                {{ trans('cruds.booking.title') }}--}}
{{--            </a>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--    <div class="tab-content">--}}
{{--        <div class="tab-pane" role="tabpanel" id="plane_activities">--}}
{{--            @includeIf('admin.planes.relationships.planeActivities', ['activities' => $plane->planeActivities])--}}
{{--        </div>--}}
{{--        <div class="tab-pane" role="tabpanel" id="plane_bookings">--}}
{{--            @includeIf('admin.planes.relationships.planeBookings', ['bookings' => $plane->planeBookings])--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}

@endsection
