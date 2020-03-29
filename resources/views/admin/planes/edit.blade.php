@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.plane.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.planes.update", [$plane->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="callsign">{{ trans('cruds.plane.fields.callsign') }}</label>
                <input class="form-control {{ $errors->has('callsign') ? 'is-invalid' : '' }}" type="text" name="callsign" id="callsign" value="{{ old('callsign', $plane->callsign) }}" required>
                @if($errors->has('callsign'))
                    <span class="text-danger">{{ $errors->first('callsign') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.plane.fields.callsign_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="vendor">{{ trans('cruds.plane.fields.vendor') }}</label>
                <input class="form-control {{ $errors->has('vendor') ? 'is-invalid' : '' }}" type="text" name="vendor" id="vendor" value="{{ old('vendor', $plane->vendor) }}" required>
                @if($errors->has('vendor'))
                    <span class="text-danger">{{ $errors->first('vendor') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.plane.fields.vendor_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="model">{{ trans('cruds.plane.fields.model') }}</label>
                <input class="form-control {{ $errors->has('model') ? 'is-invalid' : '' }}" type="text" name="model" id="model" value="{{ old('model', $plane->model) }}">
                @if($errors->has('model'))
                    <span class="text-danger">{{ $errors->first('model') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.plane.fields.model_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="prodno">{{ trans('cruds.plane.fields.prodno') }}</label>
                <input class="form-control {{ $errors->has('prodno') ? 'is-invalid' : '' }}" type="text" name="prodno" id="prodno" value="{{ old('prodno', $plane->prodno) }}">
                @if($errors->has('prodno'))
                    <span class="text-danger">{{ $errors->first('prodno') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.plane.fields.prodno_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="active" value="0">
                    <input class="form-check-input" type="checkbox" name="active" id="active" value="1" {{ $plane->active || old('active', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="active">{{ trans('cruds.plane.fields.active') }}</label>
                </div>
                @if($errors->has('active'))
                    <span class="text-danger">{{ $errors->first('active') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.plane.fields.active_helper') }}</span>
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