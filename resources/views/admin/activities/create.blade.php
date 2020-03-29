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
                <label for="copilot_id">{{ trans('cruds.activity.fields.copilot') }}</label>
                <select class="form-control select2 {{ $errors->has('copilot') ? 'is-invalid' : '' }}" name="copilot_id" id="copilot_id">
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
                <select class="form-control select2 {{ $errors->has('instructor') ? 'is-invalid' : '' }}" name="instructor_id" id="instructor_id">
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
                <label class="required" for="type_id">{{ trans('cruds.activity.fields.type') }}</label>
                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type_id" id="type_id" required>
                    @foreach($types as $id => $type)
                        <option value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.type_helper') }}</span>
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
                <input class="form-control {{ $errors->has('warmup_start') ? 'is-invalid' : '' }}" type="number" name="warmup_start" id="warmup_start" value="{{ old('warmup_start', '0') }}" step="0.01">
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
    // $(document).ready(function(){
    //     $('#engine_warmup').on('change', function(){
    //         if ($("input[type=checkbox]").is(":checked")) {
    //             $("#warmup_start").prop("disabled", false);
    //             $("#warmup_start").prop('required', true);
    //         }
    //         else{
    //             $("#warmup_start").val("");
    //             $("#warmup_start").prop('required', false);
    //             $("#warmup_start").prop("disabled", true);
    //         }
    //     });

    //     $('#type_id').on('change', function() {
    //         if ($('#type_id option:selected').text().includes('--- with Instructor')) {
    //             $("#instructor_id").prop("disabled", false);
    //             $("#copilot_id").prop("disabled", true);
    //             $("#split_cost").prop("disabled", true);
    //         } else {
    //             $("#instructor_id").prop("disabled", true);
    //             $("#copilot_id").prop("disabled", false);
    //             $("#split_cost").prop("disabled", false);
    //         }
    //     });
    // });
</script>
@endsection
