@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="login-logo">
            <div class="login-logo">
                <a href="{{ route('admin.home') }}">
                    {{ trans('panel.site_title') }}
                </a>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Complete Profile') }}</div>
                @foreach($user as $user)
                <div class="card-body">
                    <form method="POST" action="{{ route('register.step2') }}">
                        @csrf

                        <div class="form-group">
                            <label class="required">{{ trans('cruds.user.fields.lang') }}</label>
                            <select class="form-control {{ $errors->has('lang') ? 'is-invalid' : '' }}" name="lang" id="lang" required>
                                <option value disabled {{ old('lang', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\User::LANG_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('lang', $user->lang) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('lang'))
                                <span class="text-danger">{{ $errors->first('lang') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.lang_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="taxno">{{ trans('cruds.user.fields.taxno') }}</label>
                            <input class="form-control {{ $errors->has('taxno') ? 'is-invalid' : '' }}" type="text" name="taxno" id="taxno" value="{{ old('taxno', $user->taxno) }}" required>
                            @if($errors->has('taxno'))
                                <span class="text-danger">{{ $errors->first('taxno') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.taxno_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="phone_1">{{ trans('cruds.user.fields.phone_1') }}</label>
                            <input class="form-control {{ $errors->has('phone_1') ? 'is-invalid' : '' }}" type="text" name="phone_1" id="phone_1" value="{{ old('phone_1', $user->phone_1) }}" required>
                            @if($errors->has('phone_1'))
                                <span class="text-danger">{{ $errors->first('phone_1') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.phone_1_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="phone_2">{{ trans('cruds.user.fields.phone_2') }}</label>
                            <input class="form-control {{ $errors->has('phone_2') ? 'is-invalid' : '' }}" type="text" name="phone_2" id="phone_2" value="{{ old('phone_2', $user->phone_2) }}" required>
                            @if($errors->has('phone_2'))
                                <span class="text-danger">{{ $errors->first('phone_2') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.phone_2_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="address">{{ trans('cruds.user.fields.address') }}</label>
                            <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', $user->address) }}" required>
                            @if($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.address_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="city">{{ trans('cruds.user.fields.city') }}</label>
                            <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text" name="city" id="city" value="{{ old('city', $user->city) }}" required>
                            @if($errors->has('city'))
                                <span class="text-danger">{{ $errors->first('city') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.city_helper') }}</span>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Finish registration') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
