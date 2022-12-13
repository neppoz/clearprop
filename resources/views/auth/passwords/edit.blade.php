@extends('layouts.admin')
@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h2 class="m-0">{{ trans('cruds.profile.title_singular') }}</h2>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('app.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.profile.title_singular') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex p-0 border-none">
                    <h3 class="card-title p-3">
                        <i class="fas fa-chart-pie mr-1"></i>
                        {{ trans('cruds.profile.finance_stats') }}
                    </h3>
                    <ul class="nav nav-pills ml-auto p-2">
                        @foreach($collectionFinanceStatistics as $financeStatistics)
                            <li class="nav-item"><a
                                        class="nav-link {{$loop->first ? 'active' : ''}}"
                                        href="#tab_{{$financeStatistics['id']}}"
                                        data-toggle="tab">{{$financeStatistics['name']}}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        @foreach($collectionFinanceStatistics as $financeStatistics)
                            <div class="tab-pane {{$loop->first ? 'active' : ''}}"
                                 id="tab_{{$financeStatistics['id']}}">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="info-box mb-3">
                                                <span class="info-box-icon {{ $financeStatistics['sum_balance'] > 0 ? 'bg-success' : 'bg-danger'}} elevation-1"><i
                                                            class="fas fa-piggy-bank"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">{{trans('cruds.profile.balance_sum')}}</span>
                                                <span class="info-box-number h4">{{  number_format($financeStatistics['sum_balance'], 2, ',', '.') }}  &euro;</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box mb-3">
                                                <span class="info-box-icon bg-lightblue elevation-1"><i
                                                            class="fas fa-plane"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">{{trans('cruds.profile.activity_sum')}}</span>
                                                <span class="info-box-number h4">{{  number_format($financeStatistics['sum_activity'], 2, ',', '.') }}  &euro;</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="info-box mb-3">
                                            <span class="info-box-icon bg-indigo elevation-1"><i
                                                        class="fas fa-money-check"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">{{trans('cruds.profile.payment_sum')}}</span>
                                                <span class="info-box-number h4">{{  number_format($financeStatistics['sum_payments'], 2, ',', '.') }}  &euro;</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline">
                <div class="card-header d-flex p-0 border-none">
                    <h3 class="card-title p-3">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ trans('cruds.profile.personal_data') }}
                    </h3>
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
                                   name="email" id="email" value="{{ old('email', auth()->user()->email) }}"
                                   required>
                            @if($errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('email') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="license">{{ trans('cruds.user.fields.license') }}</label>
                            <input class="form-control {{ $errors->has('license') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="license" id="license"
                                   value="{{ old('license', auth()->user()->license) }}">
                            @if($errors->has('license'))
                                <span class="text-danger">{{ $errors->first('license') }}</span>
                            @endif
                            <span
                                    class="help-block text-secondary small">{{ trans('cruds.user.fields.license_helper') }}</span>
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
                            <span
                                    class="help-block text-secondary small">{{ trans('cruds.user.fields.medical_due_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="taxno">{{ trans('cruds.user.fields.taxno') }}</label>
                            <input class="form-control {{ $errors->has('taxno') ? 'is-invalid' : '' }}" type="text"
                                   name="taxno" id="taxno" value="{{ old('taxno', auth()->user()->taxno) }}"
                                   required>
                            @if($errors->has('taxno'))
                                <span class="text-danger">{{ $errors->first('taxno') }}</span>
                            @endif
                            <span
                                    class="help-block text-secondary small">{{ trans('cruds.user.fields.taxno_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="phone_1">{{ trans('cruds.user.fields.phone_1') }}</label>
                            <input class="form-control {{ $errors->has('phone_1') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="phone_1" id="phone_1" value="{{ old('phone_1', auth()->user()->phone_1) }}"
                                   required>
                            @if($errors->has('phone_1'))
                                <span class="text-danger">{{ $errors->first('phone_1') }}</span>
                            @endif
                            <span
                                    class="help-block text-secondary small">{{ trans('cruds.user.fields.phone_1_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="phone_2">{{ trans('cruds.user.fields.phone_2') }}</label>
                            <input class="form-control {{ $errors->has('phone_2') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="phone_2" id="phone_2"
                                   value="{{ old('phone_2', auth()->user()->phone_2) }}">
                            @if($errors->has('phone_2'))
                                <span class="text-danger">{{ $errors->first('phone_2') }}</span>
                            @endif
                            <span
                                    class="help-block text-secondary small">{{ trans('cruds.user.fields.phone_2_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="address">{{ trans('cruds.user.fields.address') }}</label>
                            <input class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                                   type="text"
                                   name="address" id="address" value="{{ old('address', auth()->user()->address) }}"
                                   required>
                            @if($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                            @endif
                            <span
                                    class="help-block text-secondary small">{{ trans('cruds.user.fields.address_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="city">{{ trans('cruds.user.fields.city') }}</label>
                            <input class="form-control {{ $errors->has('city') ? 'is-invalid' : '' }}" type="text"
                                   name="city" id="city" value="{{ old('city', auth()->user()->city) }}" required>
                            @if($errors->has('city'))
                                <span class="text-danger">{{ $errors->first('city') }}</span>
                            @endif
                            <span
                                    class="help-block text-secondary small">{{ trans('cruds.user.fields.city_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="lang">{{ trans('cruds.user.fields.lang') }}</label>
                            <select class="form-control select2 {{ $errors->has('lang') ? 'is-invalid' : '' }}"
                                    name="lang" id="lang" required>
                                @foreach(config('panel.available_languages') as $langLocale => $langName)
                                    <option
                                            value="{{ $langLocale }}" {{ ($langLocale ? auth()->user()->lang : old('lang')) == $langLocale ? 'selected' : ''}}>{{ $langName }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('lang'))
                                <span class="text-danger">{{ $errors->first('lang') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary float-right" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    {{ trans('global.change_password') }}
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route("profile.password.update") }}">
                        @csrf
                        <input type="hidden" name="email" id="email" value="{{ auth()->user()->email }}">
                        <div class="form-group">
                            <label class="required"
                                   for="password">New {{ trans('cruds.user.fields.password') }}</label>
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
                            <button class="btn btn-danger float-right" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
