@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                {{ trans('cruds.booking.title_singular') }}
            </div>
            <div class="col-6">
                <div class="float-right">
                    @can('booking_delete')
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-outline-danger" value="{{ trans('global.delete') }}">
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
                        {{ trans('cruds.booking.fields.user') }}
                    </th>
                    <td>
                        {{ $booking->user->name ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.booking.fields.instructor_needed') }}
                    </th>
                    <td>
                        <span
                            class="text-primary">{{ App\Booking::INSTRUCTOR_NEEDED_RADIO[$booking->instructor_needed] ?? '' }}</span>
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
                @if(!empty($booking->instructor_id) && App\Booking::STATUS_RADIO[$booking->status] === 'confirmed')
                    <tr>
                        <th>
                            {{ trans('cruds.booking.fields.instructor') }}
                        </th>
                        <td>
                            {{ $booking->instructor->name ?? '' }}
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.booking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.update", $booking->id) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <input type="hidden" name="user_id" id="user_id" value="{{ old('user_id', $booking->user_id) }}" readonly>
            <input type="hidden" name="instructor_needed" id="instructor_needed"
                   value="{{ old('instructor_needed', $booking->instructor_needed) }}" readonly>
            <input type="hidden" name="plane_id" id="plane_id" value="{{ old('plane_id', $booking->plane_id) }}"
                   readonly>
            <input type="hidden" name="reservation_start" id="reservation_start"
                   value="{{ old('reservation_start', $booking->reservation_start) }}" readonly>
            <input type="hidden" name="reservation_stop" id="reservation_stop"
                   value="{{ old('reservation_stop', $booking->reservation_stop) }}" readonly>
            <input type="hidden" name="status" id="status" value="{{ old('reservation_stop', $booking->status) }}"
                   readonly>
            @can('booking_edit')
                @if ($booking->instructor_needed === 1 && $booking->status === 0)
                    <div class="form-group">
                        <label for="instructor_id_select">{{ trans('cruds.activity.fields.instructor') }}</label>
                        <select class="form-control select2 {{ $errors->has('instructor') ? 'is-invalid' : '' }}"
                                name="instructor_id" id="instructor_id_select">
                            @foreach($instructors as $id => $instructor)
                                <option
                                    value="{{ $id }}" {{ old('instructor_id') == $id ? 'selected' : '' }}>{{ $instructor }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('instructor'))
                            <span class="text-danger">{{ $errors->first('instructor') }}</span>
                        @endif
                        <span
                            class="help-block text-secondary small">{{ trans('cruds.booking.fields.instructor_helper') }}</span>
                    </div>
                @endif
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
            @endcan
        </form>
    </div>
</div>

@endsection


@section('scripts')
    <script>
        $(document).ready(function () {

            $("#instructor_id_select").change(function () {
                $('#status').val(1);
            });

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
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'fas fa-dot-circle',
                    close: 'fas fa-check-circle'
                },
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
                    up: 'fas fa-chevron-up',
                    down: 'fas fa-chevron-down',
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                    today: 'fas fa-dot-circle',
                    close: 'fas fa-check-circle'
                },
                stepping: 15
            });

            $("#reservation_start").on("dp.change", function (e) {
                $('#reservation_stop').data("DateTimePicker").minDate(e.date);
            });
            $("#reservation_stop").on("dp.change", function (e) {
                $('#reservation_start').data("DateTimePicker").maxDate(e.date);
            });

        });
    </script>
@endsection
