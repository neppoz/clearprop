@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.plane.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.planes.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="callsign">{{ trans('cruds.plane.fields.callsign') }}</label>
                <input class="form-control {{ $errors->has('callsign') ? 'is-invalid' : '' }}" type="text"
                       name="callsign" id="callsign" value="{{ old('callsign', '') }}" required>
                @if($errors->has('callsign'))
                    <span class="text-danger">{{ $errors->first('callsign') }}</span>
                @endif
                <span class="help-block text-secondary small">{{ trans('cruds.plane.fields.callsign_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="vendor">{{ trans('cruds.plane.fields.vendor') }}</label>
                <input class="form-control {{ $errors->has('vendor') ? 'is-invalid' : '' }}" type="text" name="vendor"
                       id="vendor" value="{{ old('vendor', 'Custom') }}" required>
                @if($errors->has('vendor'))
                    <span class="text-danger">{{ $errors->first('vendor') }}</span>
                @endif
                <span class="help-block text-secondary small">{{ trans('cruds.plane.fields.vendor_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="model">{{ trans('cruds.plane.fields.model') }}</label>
                <input class="form-control {{ $errors->has('model') ? 'is-invalid' : '' }}" type="text" name="model"
                       id="model" value="{{ old('model', '') }}">
                @if($errors->has('model'))
                    <span class="text-danger">{{ $errors->first('model') }}</span>
                @endif
                <span class="help-block text-secondary small">{{ trans('cruds.plane.fields.model_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="prodno">{{ trans('cruds.plane.fields.prodno') }}</label>
                <input class="form-control {{ $errors->has('prodno') ? 'is-invalid' : '' }}" type="text" name="prodno"
                       id="prodno" value="{{ old('prodno', '') }}">
                @if($errors->has('prodno'))
                    <span class="text-danger">{{ $errors->first('prodno') }}</span>
                @endif
                <span class="help-block text-secondary small">{{ trans('cruds.plane.fields.prodno_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.plane.fields.counter_type') }}</label>
                <select class="form-control {{ $errors->has('counter_type') ? 'is-invalid' : '' }}" name="counter_type"
                        id="counter_type" required>
                    <option value
                            disabled {{ old('counter_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Plane::COUNTER_TYPE_SELECT as $key => $label)
                        <option
                            value="{{ $key }}" {{ old('counter_type', '100') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('counter_type'))
                    <span class="text-danger">{{ $errors->first('counter_type') }}</span>
                @endif
                <span
                    class="help-block text-secondary small">{{ trans('cruds.plane.fields.counter_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.plane.fields.warmup_type') }}</label>
                @foreach(App\Plane::WARMUP_TYPE_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('warmup_type') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="warmup_type_{{ $key }}" name="warmup_type"
                               value="{{ $key }}" {{ old('warmup_type', '0') === (string) $key ? 'checked' : '' }}>
                        <label class="form-check-label" for="warmup_type_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('warmup_type'))
                    <span class="text-danger">{{ $errors->first('warmup_type') }}</span>
                @endif
                <span
                    class="help-block text-secondary small">{{ trans('cruds.plane.fields.warmup_type_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="active" value="0">
                    <input class="form-check-input" type="checkbox" name="active" id="active"
                           value="1" {{ old('active', 0) == 1 || old('active') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ trans('cruds.plane.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <span class="text-danger">{{ $errors->first('active') }}</span>
                @endif
                <span class="help-block text-secondary small">{{ trans('cruds.plane.fields.active_helper') }}</span>
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
