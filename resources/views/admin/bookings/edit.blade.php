@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="row justify-content-end">
            <div class="col-6">
                {{ trans('cruds.booking.title_singular') }} {{ trans('cruds.booking.fields.id') }} {{ $booking->id }}
            </div>
            <div class="col-6">

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
                        {{ $booking->user->name ?? '' }}
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
                @can('booking_delete')
                <tr>
                    <th>
                        <form action="{{ route('admin.bookings.destroy', [$booking->id]) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-outline-danger" value="{{ trans('global.delete') }} {{ trans('cruds.booking.title_singular') }}">
                        </form>
                    </th>
                    <td>

                    </td>
                <tr>
                @endcan
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.booking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.update", [$booking->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id', $booking->user_id) }}" readonly>
                <input type="hidden" name="plane_id" id="plane_id" value="{{ old('plane_id', $booking->plane_id) }}" readonly>
            </div>
            <div class="form-group">
                <label class="required" for="reservation_start">{{ trans('cruds.booking.fields.reservation_start') }}</label>
                <input class="form-control {{ $errors->has('reservation_start') ? 'is-invalid' : '' }}" type="text" name="reservation_start" id="reservation_start" value="{{ old('reservation_start', $booking->reservation_start) }}" required>
                @if($errors->has('reservation_start'))
                    <span class="text-danger">{{ $errors->first('reservation_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.reservation_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="reservation_stop">{{ trans('cruds.booking.fields.reservation_stop') }}</label>
                <input class="form-control {{ $errors->has('reservation_stop') ? 'is-invalid' : '' }}" type="text" name="reservation_stop" id="reservation_stop" value="{{ old('reservation_stop', $booking->reservation_stop) }}" required>
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
            @can('booking_edit')
            <div class="form-group">
                <button class="btn btn-success" type="submit">
                    <i class="fas fa-edit"></i>
                    {{ trans('global.update') }} {{ trans('cruds.booking.title_singular') }}
                </button>
            </div>
            @endcan
        </form>
    </div>
</div>

@endsection


@section('scripts')
<script>
    $(document).ready(function () {

        $('#reservation_start').datetimepicker({
            format: 'DD.MM.YYYY HH:mm',
            locale: '{{ app()->getLocale() }}',
            sideBySide: true,
            toolbarPlacement: 'top',
            showTodayButton: true,
            showClose: true,
            widgetPositioning: {
                horizontal: 'auto',
                vertical: 'top'
            },
            icons: {
                // time: 'glyphicon glyphicon-time',
                // date: 'glyphicon glyphicon-calendar',
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-dot-circle',
                // clear: 'glyphicon glyphicon-trash',
                close: 'fas fa-check-circle'

            },
            //disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 6 })], [moment({ h: 20, m: 00 }), moment({ h: 24 })]],
            //enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
            stepping: 15,
        });

        $('#reservation_stop').datetimepicker({
            useCurrent: false,
            format: 'DD.MM.YYYY HH:mm',
            locale: '{{ app()->getLocale() }}',
            sideBySide: true,
            toolbarPlacement: 'top',
            showTodayButton: true,
            showClose: true,
            widgetPositioning: {
                horizontal: 'auto',
                vertical: 'top'
            },
            icons: {
                // time: 'glyphicon glyphicon-time',
                // date: 'glyphicon glyphicon-calendar',
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-dot-circle',
                // clear: 'glyphicon glyphicon-trash',
                close: 'fas fa-check-circle'

            },
            //disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 6 })], [moment({ h: 20, m: 00 }), moment({ h: 24 })]],
            //enabledHours: [8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
            stepping: 15
        });

        $("#reservation_start").on("dp.change",function (e) {
            $('#reservation_stop').data("DateTimePicker").minDate(e.date);
        });
        $("#reservation_stop").on("dp.change",function (e) {
            $('#reservation_start').data("DateTimePicker").maxDate(e.date);
        });

    });
</script>
@endsection
