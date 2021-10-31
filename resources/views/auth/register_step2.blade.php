@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
        @include('partials.logo')
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Complete Profile') }}</div>
                    {{-- @foreach($user as $user) --}}
                <div class="card-body">
                    <form method="POST" action="{{ route('register.step2') }}">
                        @csrf

                        <div class="form-group">
                            <label class="required" for="license">{{ trans('cruds.user.fields.license') }}</label>
                            <input class="form-control {{ $errors->has('license') ? 'is-invalid' : '' }}" type="text" name="license" id="license" value="{{ old('license', $user->license) }}" required>
                            @if($errors->has('license'))
                                <span class="text-danger">{{ $errors->first('license') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.license_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="medical_due">{{ trans('cruds.user.fields.medical_due') }}</label>
                            <input class="form-control date {{ $errors->has('medical_due') ? 'is-invalid' : '' }}" type="text" name="medical_due" id="medical_due" value="{{ old('medical_due', $user->medical_due) }}" required>
                            @if($errors->has('medical_due'))
                                <span class="text-danger">{{ $errors->first('medical_due') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.medical_due_helper') }}</span>
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
                            <label for="phone_2">{{ trans('cruds.user.fields.phone_2') }}</label>
                            <input class="form-control {{ $errors->has('phone_2') ? 'is-invalid' : '' }}" type="text" name="phone_2" id="phone_2" value="{{ old('phone_2', $user->phone_2) }}">
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
                        <div class="form-group">
                            <div class="form-check {{ $errors->has('privacy_confirmed_at') ? 'is-invalid' : '' }}">
                                <input type="hidden" name="privacy_confirmed_at" value="0">
                                <input class="form-check-input" type="checkbox" name="privacy_confirmed_at" id="privacy_confirmed_at" value="{{ now() }}" {{ old('privacy_confirmed_at', 0) == 0 || old('privacy_confirmed_at') === null ? 'checked' : '' }} required>
                                <label class="form-check-label" for="privacy_confirmed_at">{{ trans('cruds.user.fields.privacy') }}</label>
                            </div>
                            @if($errors->has('instructor'))
                                <span class="text-danger">{{ $errors->first('instructor') }}</span>
                            @endif
                            <span class="help-block">{{ trans('cruds.user.fields.instructor_helper') }}</span>
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
                {{-- @endforeach --}}
            </div>
        </div>
    </div>
</div>
@endsection
