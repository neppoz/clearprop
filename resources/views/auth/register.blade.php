@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="login-logo">
            <div class="login-logo">
                <a href="{{ route('admin.home') }}">
                    <img src="{{ url('/images/ClearProp_textdown.svg') }}" alt="ClearProp Logo" width="150"
                         height="auto"/>
                </a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card card-primary card-outline">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                           class="form-control @error('name') is-invalid @enderror" name="name"
                                           value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ old('email') }}" required autocomplete="email">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password-confirm"
                                       class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                            <hr>

                            <div class="form-group row">
                                <label
                                    class="col-md-4 col-form-label text-md-right">{{ trans('cruds.user.fields.lang') }}</label>

                                <div class="col-md-6">
                                    <select class="form-control {{ $errors->has('lang') ? 'is-invalid' : '' }}"
                                            name="lang" id="lang" required>
                                        <option value
                                                disabled {{ old('lang', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                        <option value="EN">English</option>
                                        <option value="IT">Italian</option>
                                        {{--                                        <option value="DE">German</option>--}}
                                    </select>
                                </div>
                            </div>

                            {{--                        <div class="form-group row">--}}
                            {{--                            <label class="col-md-4 col-form-label text-md-right"--}}
                            {{--                                   for="phone_1">{{ trans('cruds.user.fields.phone_1') }}</label>--}}
                            {{--                            <div class="col-md-6">--}}
                            {{--                                <input class="form-control @error('phone_1') is-invalid @enderror" name="phone_1"--}}
                            {{--                                       value="{{ old('phone_1') }}" type="text" id="phone_1" required>--}}
                            {{--                                @error('phone_1')--}}
                            {{--                                <span class="invalid-feedback" role="alert">--}}
                            {{--                                        <strong>{{ $message }}</strong>--}}
                            {{--                                    </span>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}
                            {{--                        </div>--}}

                            {{--                        <div class="form-group row">--}}
                            {{--                            <input type="hidden" name="privacy_confirmed_at" value="0">--}}
                            {{--                            <input class=" col-md-4 col-form-label text-md-right form-check-input" type="checkbox" name="privacy_confirmed_at" id="privacy_confirmed_at" value="{{ now() }}" {{ old('privacy_confirmed_at', 0) == 0 || old('privacy_confirmed_at') === null ? 'checked' : '' }} required>--}}
                            {{--                            <div class="col-md-6">--}}
                            {{--                                <label class="form-check-label" for="privacy_confirmed_at">{{ trans('cruds.user.fields.privacy') }}</label>--}}
                            {{--                            </div>--}}
                            {{--                            --}}
                            {{--                        </div>--}}

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
