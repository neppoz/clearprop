@extends('layouts.admin')
@section('content')
    <div class="row">
        <div class="col">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            {{ trans('cruds.booking.title_singular') }}
                        </div>
                        <div class="col-6">
                            <div class="float-right">
                                @can('booking_delete')
                                    @if(($booking->created_by_id == auth()->user()->id) && ($booking->bookingUsers->count() == 1))
                                        <form action="{{ route('app.bookings.destroy', $booking->id) }}" method="POST"
                                              onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-outline-danger"
                                                   value="{{ trans('global.delete_reservation') }}">
                                        </form>
                                    @else
                                        <form action="{{ route('app.bookings.revoke', $booking->id) }}" method="POST"
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
                    <div class="row">
                        <div class="col">
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
                    <div class="row">
                        <div class="col">
                            <form method="POST" action="{{ route("app.bookings.update", $booking->id) }}"
                                  enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                @includeWhen($booking->mode_id === 1, 'app.bookings.partials.charter.edit')
                                @includeWhen($booking->mode_id === 2, 'app.bookings.partials.school.edit')
                                @includeWhen($booking->mode_id === 3, 'app.bookings.partials.promotion.edit')
                                @includeWhen($booking->mode_id === 4, 'app.bookings.partials.maintenance.edit')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')

@endsection
