@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.activity.title_singular') }} {{ trans('cruds.activity.fields.id') }} {{ $activity->id }}
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
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
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.activity.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.activities.update", [$activity->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="plane_id">{{ trans('cruds.activity.fields.plane') }}</label>
                <select class="form-control select2 {{ $errors->has('plane') ? 'is-invalid' : '' }}" name="plane_id" id="plane_id" required>
                    @foreach($planes as $id => $plane)
                        <option value="{{ $id }}" {{ ($activity->plane ? $activity->plane->id : old('plane_id')) == $id ? 'selected' : '' }}>{{ $plane }}</option>
                    @endforeach
                </select>
                @if($errors->has('plane'))
                    <span class="text-danger">{{ $errors->first('plane') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.plane_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="event">{{ trans('cruds.activity.fields.event') }}</label>
                <input class="form-control date {{ $errors->has('event') ? 'is-invalid' : '' }}" type="text" name="event" id="event" value="{{ old('event', $activity->event) }}" required>
                @if($errors->has('event'))
                    <span class="text-danger">{{ $errors->first('event') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.event_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('engine_warmup') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="engine_warmup" value="0">
                    <input class="form-check-input" type="checkbox" name="engine_warmup" id="engine_warmup" value="1" {{ $activity->engine_warmup || old('engine_warmup', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="engine_warmup">{{ trans('cruds.activity.fields.engine_warmup') }}</label>
                </div>
                @if($errors->has('engine_warmup'))
                    <span class="text-danger">{{ $errors->first('engine_warmup') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.engine_warmup_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="warmup_start">{{ trans('cruds.activity.fields.warmup_start') }}</label>
                <input class="form-control {{ $errors->has('warmup_start') ? 'is-invalid' : '' }}" type="number" name="warmup_start" id="warmup_start" value="{{ old('warmup_start', $activity->warmup_start) }}" step="0.01" readonly>
                @if($errors->has('warmup_start'))
                    <span class="text-danger">{{ $errors->first('warmup_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.warmup_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="counter_start">{{ trans('cruds.activity.fields.counter_start') }}</label>
                <input class="form-control {{ $errors->has('counter_start') ? 'is-invalid' : '' }}" type="number" name="counter_start" id="counter_start" value="{{ old('counter_start', $activity->counter_start) }}" step="0.01" required>
                @if($errors->has('counter_start'))
                    <span class="text-danger">{{ $errors->first('counter_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.counter_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="counter_stop">{{ trans('cruds.activity.fields.counter_stop') }}</label>
                <input class="form-control {{ $errors->has('counter_stop') ? 'is-invalid' : '' }}" type="number" name="counter_stop" id="counter_stop" value="{{ old('counter_stop', $activity->counter_stop) }}" step="0.01" required>
                @if($errors->has('counter_stop'))
                    <span class="text-danger">{{ $errors->first('counter_stop') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.counter_stop_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="departure">{{ trans('cruds.activity.fields.departure') }}</label>
                <input class="form-control {{ $errors->has('departure') ? 'is-invalid' : '' }}" type="text" name="departure" id="departure" value="{{ old('departure', $activity->departure) }}">
                @if($errors->has('departure'))
                    <span class="text-danger">{{ $errors->first('departure') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.departure_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="arrival">{{ trans('cruds.activity.fields.arrival') }}</label>
                <input class="form-control {{ $errors->has('arrival') ? 'is-invalid' : '' }}" type="text" name="arrival" id="arrival" value="{{ old('arrival', $activity->arrival) }}">
                @if($errors->has('arrival'))
                    <span class="text-danger">{{ $errors->first('arrival') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.arrival_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="event_start">{{ trans('cruds.activity.fields.event_start') }}</label>
                <input class="form-control timepicker {{ $errors->has('event_start') ? 'is-invalid' : '' }}" type="text" name="event_start" id="event_start" value="{{ old('event_start', $activity->event_start) }}">
                @if($errors->has('event_start'))
                    <span class="text-danger">{{ $errors->first('event_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.event_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="event_stop">{{ trans('cruds.activity.fields.event_stop') }}</label>
                <input class="form-control timepicker {{ $errors->has('event_stop') ? 'is-invalid' : '' }}" type="text" name="event_stop" id="event_stop" value="{{ old('event_stop', $activity->event_stop) }}">
                @if($errors->has('event_stop'))
                    <span class="text-danger">{{ $errors->first('event_stop') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.event_stop_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.activity.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $activity->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.description_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $("#engine_warmup").change(function(){
            if($(this).is(":checked")) {
                //'checked' event code
                $('#warmup_start').prop('readonly', false);
                return;
            }
            $('#warmup_start').val(0);
            $('#warmup_start').prop('readonly', true);
        });
    });
</script>
@endsection
