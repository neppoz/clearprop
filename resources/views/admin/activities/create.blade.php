@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.activity.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.activities.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.activity.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="type_id">{{ trans('cruds.activity.fields.type') }}</label>
                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type_id" id="type_id" required>
                    <option selected value="">{{ trans('global.pleaseSelect') }}</option>
                    <optgroup label={{ trans('cruds.activity.fields.opt1') }} id="opt1">
                        @foreach($types_opt1 as $id => $type)
                            <option value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </optgroup>
                    <optgroup label={{ trans('cruds.activity.fields.opt2') }} id="opt2">
                        @foreach($types_opt2 as $id => $type)
                            <option value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </optgroup>
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.activity.fields.split_cost') }}</label>
                @foreach(App\Activity::SPLIT_COST_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('split_cost') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="split_cost_{{ $key }}" name="split_cost" value="{{ $key }}" {{ old('split_cost', '0') === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="split_cost_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('split_cost'))
                    <span class="text-danger">{{ $errors->first('split_cost') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.split_cost_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="copilot_id">{{ trans('cruds.activity.fields.copilot') }}</label>
                <select class="form-control select2 {{ $errors->has('copilot') ? 'is-invalid' : '' }}" name="copilot_id" id="copilot_id" disabled>
                    @foreach($copilots as $id => $copilot)
                        <option value="{{ $id }}" {{ old('copilot_id') == $id ? 'selected' : '' }}>{{ $copilot }}</option>
                    @endforeach
                </select>
                @if($errors->has('copilot'))
                    <span class="text-danger">{{ $errors->first('copilot') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.copilot_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="instructor_id">{{ trans('cruds.activity.fields.instructor') }}</label>
                <select class="form-control select2 {{ $errors->has('instructor') ? 'is-invalid' : '' }}" name="instructor_id" id="instructor_id" disabled>
                    @foreach($instructors as $id => $instructor)
                        <option value="{{ $id }}" {{ old('instructor_id') == $id ? 'selected' : '' }}>{{ $instructor }}</option>
                    @endforeach
                </select>
                @if($errors->has('instructor'))
                    <span class="text-danger">{{ $errors->first('instructor') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.instructor_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="plane_id">{{ trans('cruds.activity.fields.plane') }}</label>
                <select class="form-control select2 {{ $errors->has('plane') ? 'is-invalid' : '' }}" name="plane_id" id="plane_id" required>
                    @foreach($planes as $id => $plane)
                        <option value="{{ $id }}" {{ old('plane_id') == $id ? 'selected' : '' }}>{{ $plane }}</option>
                    @endforeach
                </select>
                @if($errors->has('plane'))
                    <span class="text-danger">{{ $errors->first('plane') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.plane_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="event">{{ trans('cruds.activity.fields.event') }}</label>
                <input class="form-control date {{ $errors->has('event') ? 'is-invalid' : '' }}" type="text" name="event" id="event" value="{{ old('event') }}" required>
                @if($errors->has('event'))
                    <span class="text-danger">{{ $errors->first('event') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.event_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('engine_warmup') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="engine_warmup" value="0">
                    <input class="form-check-input" type="checkbox" name="engine_warmup" id="engine_warmup" value="1" {{ old('engine_warmup', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="engine_warmup">{{ trans('cruds.activity.fields.engine_warmup') }}</label>
                </div>
                @if($errors->has('engine_warmup'))
                    <span class="text-danger">{{ $errors->first('engine_warmup') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.engine_warmup_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="warmup_start">{{ trans('cruds.activity.fields.warmup_start') }}</label>
                <input class="form-control {{ $errors->has('warmup_start') ? 'is-invalid' : '' }}" type="number" name="warmup_start" id="warmup_start" value="{{ old('warmup_start', '0') }}" step="0.01" readonly>
                @if($errors->has('warmup_start'))
                    <span class="text-danger">{{ $errors->first('warmup_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.warmup_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="counter_start">{{ trans('cruds.activity.fields.counter_start') }}</label>
                <input class="form-control {{ $errors->has('counter_start') ? 'is-invalid' : '' }}" type="number" name="counter_start" id="counter_start" value="{{ old('counter_start', '0') }}" step="0.01" required>
                @if($errors->has('counter_start'))
                    <span class="text-danger">{{ $errors->first('counter_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.counter_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="counter_stop">{{ trans('cruds.activity.fields.counter_stop') }}</label>
                <input class="form-control {{ $errors->has('counter_stop') ? 'is-invalid' : '' }}" type="number" name="counter_stop" id="counter_stop" value="{{ old('counter_stop', '0') }}" step="0.01" required>
                @if($errors->has('counter_stop'))
                    <span class="text-danger">{{ $errors->first('counter_stop') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.counter_stop_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="departure">{{ trans('cruds.activity.fields.departure') }}</label>
                <input class="form-control {{ $errors->has('departure') ? 'is-invalid' : '' }}" type="text" name="departure" id="departure" value="{{ old('departure', '') }}">
                @if($errors->has('departure'))
                    <span class="text-danger">{{ $errors->first('departure') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.departure_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="arrival">{{ trans('cruds.activity.fields.arrival') }}</label>
                <input class="form-control {{ $errors->has('arrival') ? 'is-invalid' : '' }}" type="text" name="arrival" id="arrival" value="{{ old('arrival', '') }}">
                @if($errors->has('arrival'))
                    <span class="text-danger">{{ $errors->first('arrival') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.arrival_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="event_start">{{ trans('cruds.activity.fields.event_start') }}</label>
                <input class="form-control timepicker {{ $errors->has('event_start') ? 'is-invalid' : '' }}" type="text" name="event_start" id="event_start" value="{{ old('event_start') }}">
                @if($errors->has('event_start'))
                    <span class="text-danger">{{ $errors->first('event_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.event_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="event_stop">{{ trans('cruds.activity.fields.event_stop') }}</label>
                <input class="form-control timepicker {{ $errors->has('event_stop') ? 'is-invalid' : '' }}" type="text" name="event_stop" id="event_stop" value="{{ old('event_stop') }}">
                @if($errors->has('event_stop'))
                    <span class="text-danger">{{ $errors->first('event_stop') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.event_stop_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.activity.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
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
        $("#type_id").change(function(){
            var selected = $("option:selected", this);
            if(selected.parent()[0].id == "opt1"){
                //OptGroup 1, this are regular flights (no instructor)
                $('#copilot_id').prop('disabled', false);
                $('#copilot_id').prop('required', false);
                $('#instructor_id').prop('disabled', true);
                $('input[name="split_cost"]').prop('disabled', false);

            } else if(selected.parent()[0].id == "opt2"){
                //OptGroup 1, this are instructor flights
                $('#copilot_id').prop('disabled', true);
                $('#instructor_id').prop('disabled', false);
                $('#instructor_id').prop('required', true);
                $('input[name="split_cost"][value="0"]').prop("checked", true);
                $('input[name="split_cost"]').prop('disabled', true);
            }
        });

        $('input[name="split_cost"]').change(function(){
            if (this.checked && this.value == '0') {
                $('#copilot_id').prop('required', false);
            } else {
                $('#copilot_id').prop('required', true);
            }
        });

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
