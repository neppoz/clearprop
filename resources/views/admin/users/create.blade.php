@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.user.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.users.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <span class="text-danger">{{ $errors->first('name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="email">{{ trans('cruds.user.fields.email') }}</label>
                <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email') }}" required>
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="password">{{ trans('cruds.user.fields.password') }}</label>
                <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                @if($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.password_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="factor_id">{{ trans('cruds.user.fields.factor') }}</label>
                <select class="form-control select2 {{ $errors->has('factor') ? 'is-invalid' : '' }}" name="factor_id" id="factor_id" required>
                    @foreach($factors as $id => $factor)
                        <option value="{{ $id }}" {{ old('factor_id') == $id ? 'selected' : '' }}>{{ $factor }}</option>
                    @endforeach
                </select>
                @if($errors->has('factor'))
                    <span class="text-danger">{{ $errors->first('factor') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.factor_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('instructor') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="instructor" value="0">
                    <input class="form-check-input" type="checkbox" name="instructor" id="instructor" value="1" {{ old('instructor', 0) == 1 || old('instructor') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="instructor">{{ trans('cruds.user.fields.instructor') }}</label>
                </div>
                @if($errors->has('instructor'))
                    <span class="text-danger">{{ $errors->first('instructor') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.instructor_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="license">{{ trans('cruds.user.fields.license') }}</label>
                <input class="form-control {{ $errors->has('license') ? 'is-invalid' : '' }}" type="text" name="license" id="license" value="{{ old('license', '') }}">
                @if($errors->has('license'))
                    <span class="text-danger">{{ $errors->first('license') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.license_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="medical_due">{{ trans('cruds.user.fields.medical_due') }}</label>
                <input class="form-control date {{ $errors->has('medical_due') ? 'is-invalid' : '' }}" type="text" name="medical_due" id="medical_due" value="{{ old('medical_due') }}">
                @if($errors->has('medical_due'))
                    <span class="text-danger">{{ $errors->first('medical_due') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.medical_due_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="roles">{{ trans('cruds.user.fields.roles') }}</label>
                <div style="padding-bottom: 4px">
                    <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
                    <span class="btn btn-info btn-xs deselect-all" style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                </div>
                <select class="form-control select2 {{ $errors->has('roles') ? 'is-invalid' : '' }}" name="roles[]" id="roles" multiple required>
                    @foreach($roles as $id => $roles)
                        <option value="{{ $id }}" {{ in_array($id, old('roles', [])) ? 'selected' : '' }}>{{ $roles }}</option>
                    @endforeach
                </select>
                @if($errors->has('roles'))
                    <span class="text-danger">{{ $errors->first('roles') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.roles_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.user.fields.lang') }}</label>
                <select class="form-control {{ $errors->has('lang') ? 'is-invalid' : '' }}" name="lang" id="lang" required>
                    <option value disabled {{ old('lang', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\User::LANG_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('lang', 'EN') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('lang'))
                    <span class="text-danger">{{ $errors->first('lang') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.lang_helper') }}</span>
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