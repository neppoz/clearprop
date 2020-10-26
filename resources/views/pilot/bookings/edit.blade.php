@extends('layouts.pilot')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h4 class="m-0 text-dark">{{ trans('cruds.booking.title') }}</h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('pilot.welcome')}}">Home</a></li>
                <li class="breadcrumb-item"><a
                        href="{{route('pilot.welcome')}}">{{ trans('cruds.booking.title_singular') }}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.edit') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    {{ trans('cruds.booking.title_singular') }}
                </div>
                <div class="col-6">
                    <div class="float-right">
                        @can('booking_delete')
                            @if(($booking->created_by_id == auth()->user()->id) && ($booking->bookingUsers->count() == 1))
                                <form action="{{ route('pilot.bookings.destroy', $booking->id) }}" method="POST"
                                      onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-outline-danger"
                                           value="{{ trans('global.delete_reservation') }}">
                                </form>
                            @else
                                <form action="{{ route('pilot.bookings.revoke', $booking->id) }}" method="POST"
                                      onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                    <input type="hidden" name="_method" value="POST">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-outline-danger"
                                           value="{{ trans('global.revoke_reservation') }}">
                                </form>
                            @endif
                        @endcan
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>
                        {{ trans('cruds.booking.fields.user') }}
                    </th>
                    <td>
                        @foreach($booking->bookingUsers as $bookingUsers)
                            <span>{{ $bookingUsers->name ?? '' }}</span><br>
                        @endforeach
                    </td>
                </tr>
                <tr style="{{ $booking->instructor_needed === 1 ? '' : 'display:none' }}">
                    <th>
                        {{ trans('cruds.booking.fields.instructor_needed') }}
                    </th>
                    <td>
                        <span class="fa fa-check-circle text-dark"></span>
                    </td>
                </tr>
                <tr style="{{ $booking->bookingInstructors->count() ? '' : 'display:none' }}">
                    <th>
                        {{ trans('cruds.booking.fields.instructor') }}
                    </th>
                    <td>
                        @foreach($booking->bookingInstructors as $bookingInstructor)
                            <span>{{ $bookingInstructor->name ?? '' }}</span><br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.booking.fields.plane') }}
                    </th>
                    <td>
                        {{ $booking->plane->callsign ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.booking.fields.reservation_start') }}
                    </th>
                    <td>
                        {{ $booking->reservation_start ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.booking.fields.reservation_stop') }}
                    </th>
                    <td>
                        {{ $booking->reservation_stop ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.booking.fields.status') }}
                    </th>
                    <td>
                        <i class="fa fa-lg fa-{{ $booking->status === 0 ? 'question-circle text-warning' : 'check-circle text-success'}}"></i>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.booking.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("pilot.bookings.update", $booking->id) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <input type="hidden" name="plane_id" id="plane_id" value="{{ old('plane_id', $booking->plane_id) }}"
                       readonly>
                <input type="hidden" name="status" id="status" value="{{ old('status', $booking->status) }}" readonly>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.booking.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              name="description"
                              id="description">{{ old('description', $booking->description) }}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">
                        <i class="fas fa-edit"></i>
                        {{ trans('global.update') }} {{ strtolower(trans('cruds.booking.title_singular')) }}
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection


@section('scripts')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection
