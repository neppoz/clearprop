@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.type.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.types.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="name">{{ trans('cruds.type.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name"
                           id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.type.fields.name_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.type.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              name="description"
                              id="description">{{ old('description') }}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.type.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <div class="form-check {{ $errors->has('instructor') ? 'is-invalid' : '' }}">
                        <input type="hidden" name="instructor" value="0">
                        <input class="form-check-input" type="checkbox" name="instructor" id="instructor"
                               value="1" {{ old('instructor', 0) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label"
                               for="instructor">{{ trans('cruds.type.fields.instructor') }}</label>
                    </div>
                    @if($errors->has('instructor'))
                        <span class="text-danger">{{ $errors->first('instructor') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.type.fields.instructor_helper') }}</span>
                </div>
                <div class="form-group">
                    <div class="form-check {{ $errors->has('active') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="checkbox" name="active" id="active" value="1"
                               required {{ old('active', 0) == 1 || old('active') === null ? 'checked' : '' }}>
                        <label class="required form-check-label"
                               for="active">{{ trans('cruds.type.fields.active') }}</label>
                    </div>
                    @if($errors->has('active'))
                        <span class="text-danger">{{ $errors->first('active') }}</span>
                    @endif
                    <span class="help-block text-secondary small">{{ trans('cruds.type.fields.active_helper') }}</span>
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
