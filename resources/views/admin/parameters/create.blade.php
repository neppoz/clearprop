@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.parameter.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.parameters.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="slug">{{ trans('cruds.parameter.fields.slug') }}</label>
                    <input class="form-control {{ $errors->has('slug') ? 'is-invalid' : '' }}" type="text" name="slug"
                           id="slug" value="{{ old('slug', '') }}" required>
                    @if($errors->has('slug'))
                        <span class="text-danger">{{ $errors->first('slug') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.parameter.fields.slug_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="value">{{ trans('cruds.parameter.fields.value') }}</label>
                    <textarea class="form-control {{ $errors->has('value') ? 'is-invalid' : '' }}" name="value"
                              id="value">{{ old('value') }}</textarea>
                    @if($errors->has('value'))
                        <span class="text-danger">{{ $errors->first('value') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.parameter.fields.value_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="lang">{{ trans('cruds.parameter.fields.lang') }}</label>
                    <input class="form-control {{ $errors->has('lang') ? 'is-invalid' : '' }}" type="text" name="lang"
                           id="lang" value="{{ old('lang', '') }}">
                    @if($errors->has('lang'))
                        <span class="text-danger">{{ $errors->first('lang') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.parameter.fields.lang_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary float-right" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>



@endsection
