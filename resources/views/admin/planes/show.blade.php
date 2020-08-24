@extends('layouts.admin')
@section('content')

<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
            <li class="nav-item">
                <a class="nav-link active show" href="#plane" role="tab" aria-controls="plane" data-toggle="pill" aria-selected="true">
                    {{ trans('global.general') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#plane_activities" role="tab" aria-controls="plane_activities" data-toggle="pill" aria-selected="false">
                    {{ trans('cruds.activity.title') }}
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade show active" role="tabpanel" id="plane" aria-labelledby="plane">
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
        </div>
        <div class="tab-pane" role="tabpanel" id="plane_activities" aria-labelledby="plane_activities">
            @includeIf('admin.planes.relationships.planeActivities', ['plane_id' => $plane->id])
        </div>
    </div>
</div>

@endsection
