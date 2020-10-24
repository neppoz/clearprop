@extends('layouts.admin')
@section('content')

    <div class="row m-2">
        <div class="col-sm-6">
            <h4 class="m-0 text-dark">{{ trans('global.edit') }} {{ trans('cruds.booking.title_singular') }}</h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a
                        href="{{route('admin.bookings.index')}}">{{trans('cruds.planning.title')}}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.edit') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>

    <div class="card-transparent">
        <div class="card-header">
            <div class="row">
                <div class="col-6">
                    {{trans('global.edit')}} {{ trans('cruds.booking.title_singular') }}
                </div>
                <div class="col-6">
                    <div class="float-right">
                        @can('booking_delete')
                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST"
                                  onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="submit" class="btn btn-outline-danger"
                                       value="{{ trans('global.delete') }}">
                            </form>
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
                        {{ trans('cruds.booking.fields.mode') }}
                    </th>
                    <td>
                        {{ $booking->mode->name ?? '' }}
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
                        @if(App\Booking::STATUS_RADIO[$booking->status] === 'pending')
                            <span class="badge badge-warning">{{ App\Booking::STATUS_RADIO[$booking->status] }}</span>
                        @endif
                        @if(App\Booking::STATUS_RADIO[$booking->status] === 'confirmed')
                            <span class="badge badge-success">{{ App\Booking::STATUS_RADIO[$booking->status]}}</span>
                        @endif
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-transparent">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.booking.title_singular') }}
        </div>

        <div class="card-body">
            @can('booking_edit')
                <form method="POST" action="{{ route("admin.bookings.update", $booking->id) }}"
                      enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    @includeWhen($booking->mode_id === 1, 'admin.bookings.partials.charter.edit')
                    @includeWhen($booking->mode_id === 2, 'admin.bookings.partials.school.edit')
                    @includeWhen($booking->mode_id === 3, 'admin.bookings.partials.promotion.edit')
                    @includeWhen($booking->mode_id === 4, 'admin.bookings.partials.maintenance.edit')
                </form>
            @endcan
        </div>
    </div>

@endsection


@section('scripts')

@endsection
