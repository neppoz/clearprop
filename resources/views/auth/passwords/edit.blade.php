@extends('layouts.pilot')
@section('content')

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.my_profile') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("profile.password.updateProfile") }}">
                        @csrf
                        <div class="form-group">
                            <label class="required" for="name">{{ trans('cruds.user.fields.name') }}</label>
                            <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text"
                                   name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                            @if($errors->has('name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="title">{{ trans('cruds.user.fields.email') }}</label>
                            <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text"
                                   name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="license">{{ trans('cruds.user.fields.license') }}</label>
                            <input class="form-control {{ $errors->has('license') ? 'is-invalid' : '' }}" type="text"
                                   name="license" id="license" value="{{ old('license', auth()->user()->license) }}"
                                   required>
                            @if($errors->has('license'))
                                <span class="text-danger">{{ $errors->first('license') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.license_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required"
                                   for="medical_due">{{ trans('cruds.user.fields.medical_due') }}</label>
                            <input class="form-control date {{ $errors->has('medical_due') ? 'is-invalid' : '' }}"
                                   type="text" name="medical_due" id="medical_due"
                                   value="{{ old('medical_due', auth()->user()->medical_due) }}" required>
                            @if($errors->has('medical_due'))
                                <span class="text-danger">{{ $errors->first('medical_due') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.medical_due_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="taxno">{{ trans('cruds.user.fields.taxno') }}</label>
                            <input class="form-control {{ $errors->has('taxno') ? 'is-invalid' : '' }}" type="text"
                                   name="taxno" id="taxno" value="{{ old('taxno', auth()->user()->taxno) }}" required>
                            @if($errors->has('taxno'))
                                <span class="text-danger">{{ $errors->first('taxno') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.taxno_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="phone_1">{{ trans('cruds.user.fields.phone_1') }}</label>
                            <input class="form-control {{ $errors->has('phone_1') ? 'is-invalid' : '' }}" type="text"
                                   name="phone_1" id="phone_1" value="{{ old('phone_1', auth()->user()->phone_1) }}"
                                   required>
                            @if($errors->has('phone_1'))
                                <span class="text-danger">{{ $errors->first('phone_1') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.phone_1_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="phone_2">{{ trans('cruds.user.fields.phone_2') }}</label>
                            <input class="form-control {{ $errors->has('phone_2') ? 'is-invalid' : '' }}" type="text"
                                   name="phone_2" id="phone_2" value="{{ old('phone_2', auth()->user()->phone_2) }}">
                            @if($errors->has('phone_2'))
                                <span class="text-danger">{{ $errors->first('phone_2') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.phone_2_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="address">{{ trans('cruds.user.fields.address') }}</label>
                            <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text"
                                   name="address" id="address" value="{{ old('address', auth()->user()->address) }}"
                                   required>
                            @if($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.address_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="city">{{ trans('cruds.user.fields.city') }}</label>
                            <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text"
                                   name="city" id="city" value="{{ old('city', auth()->user()->city) }}" required>
                            @if($errors->has('city'))
                                <span class="text-danger">{{ $errors->first('city') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.city_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ trans('global.change_password') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route("profile.password.update") }}">
                        @csrf
                        <input type="hidden" name="email" id="email" value="{{ auth()->user()->email }}">
                        <div class="form-group">
                            <label class="required" for="password">New {{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                                   type="password" name="password" id="password" required>
                            @if($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="required" for="password_confirmation">Repeat
                                New {{ trans('cruds.user.fields.password') }}</label>
                            <input class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                                   type="password" name="password_confirmation" id="password_confirmation" required>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="row">--}}
    {{--    <div class="col-md-6">--}}
    {{--        <div class="card">--}}
    {{--            <div class="card-header">--}}
    {{--                {{ trans('global.delete_account') }}--}}
    {{--            </div>--}}

    {{--            <div class="card-body">--}}
    {{--                <form method="POST" action="{{ route("profile.password.destroyProfile") }}" onsubmit="return prompt('{{ __('global.delete_account_warning') }}') == '{{ auth()->user()->email }}'">--}}
    {{--                    @csrf--}}
    {{--                    <div class="form-group">--}}
    {{--                        <button class="btn btn-danger" type="submit">--}}
    {{--                            {{ trans('global.delete') }}--}}
    {{--                        </button>--}}
    {{--                    </div>--}}
    {{--                </form>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    {{--</div>--}}
@endsection
