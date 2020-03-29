@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.booking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.update", [$booking->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.booking.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ ($booking->user ? $booking->user->id : old('user_id')) == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.user_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="plane_id">{{ trans('cruds.booking.fields.plane') }}</label>
                <select class="form-control select2 {{ $errors->has('plane') ? 'is-invalid' : '' }}" name="plane_id" id="plane_id" required>
                    @foreach($planes as $id => $plane)
                        <option value="{{ $id }}" {{ ($booking->plane ? $booking->plane->id : old('plane_id')) == $id ? 'selected' : '' }}>{{ $plane }}</option>
                    @endforeach
                </select>
                @if($errors->has('plane'))
                    <span class="text-danger">{{ $errors->first('plane') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.plane_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="reservation_start">{{ trans('cruds.booking.fields.reservation_start') }}</label>
                <input class="form-control datetime {{ $errors->has('reservation_start') ? 'is-invalid' : '' }}" type="text" name="reservation_start" id="reservation_start" value="{{ old('reservation_start', $booking->reservation_start) }}" required>
                @if($errors->has('reservation_start'))
                    <span class="text-danger">{{ $errors->first('reservation_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.reservation_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="reservation_stop">{{ trans('cruds.booking.fields.reservation_stop') }}</label>
                <input class="form-control datetime {{ $errors->has('reservation_stop') ? 'is-invalid' : '' }}" type="text" name="reservation_stop" id="reservation_stop" value="{{ old('reservation_stop', $booking->reservation_stop) }}" required>
                @if($errors->has('reservation_stop'))
                    <span class="text-danger">{{ $errors->first('reservation_stop') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.reservation_stop_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.booking.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description', $booking->description) }}</textarea>
                @if($errors->has('description'))
                    <span class="text-danger">{{ $errors->first('description') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.description_helper') }}</span>
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