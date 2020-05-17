@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.activity.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.activities.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.id') }}
                        </th>
                        <td>
                            {{ $activity->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.user') }}
                        </th>
                        <td>
                            {{ $activity->user->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.type') }}
                        </th>
                        <td>
                            {{ $activity->type->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.split_cost') }}
                        </th>
                        <td>
                            {{ App\Activity::SPLIT_COST_RADIO[$activity->split_cost] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.copilot') }}
                        </th>
                        <td>
                            {{ $activity->copilot->name ?? '' }}
                        </td>
                    </tr>

                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.instructor') }}
                        </th>
                        <td>
                            {{ $activity->instructor->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.plane') }}
                        </th>
                        <td>
                            {{ $activity->plane->callsign ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.event') }}
                        </th>
                        <td>
                            {{ $activity->event }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.engine_warmup') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $activity->engine_warmup ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.warmup_start') }}
                        </th>
                        <td>
                            {{ $activity->warmup_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.counter_start') }}
                        </th>
                        <td>
                            {{ $activity->counter_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.counter_stop') }}
                        </th>
                        <td>
                            {{ $activity->counter_stop }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.departure') }}
                        </th>
                        <td>
                            {{ $activity->departure }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.arrival') }}
                        </th>
                        <td>
                            {{ $activity->arrival }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.event_start') }}
                        </th>
                        <td>
                            {{ $activity->event_start }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.event_stop') }}
                        </th>
                        <td>
                            {{ $activity->event_stop }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.warmup_minutes') }}
                        </th>
                        <td>
                            {{ $activity->warmup_minutes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.rate') }}
                        </th>
                        <td>
                            {{ $activity->rate }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.minutes') }}
                        </th>
                        <td>
                            {{ $activity->minutes }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.amount') }}
                        </th>
                        <td>
                            {{ $activity->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.activity.fields.description') }}
                        </th>
                        <td>
                            {{ $activity->description }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.activities.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
