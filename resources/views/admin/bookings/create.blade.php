@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.store") }}" enctype="multipart/form-data">
            @csrf
            @if (auth()->user()->getIsAdminAttribute())
                <div class="form-group">
                    <label class="required" for="user_id">{{ trans('cruds.booking.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                        @foreach($users as $id => $user)
                            <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <span class="text-danger">{{ $errors->first('user') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.booking.fields.user_helper') }}</span>
                </div>
            @else
                <div class="form-group">
                    <label class="text" for="user_id">{{ trans('cruds.booking.fields.user') }} : {{ $user->name }}</label>
                    <input type="text" name="user_id" id="user_id" value="{{ $user->id }}" hidden>
                </div>
            @endif
            <div class="form-group">
                <label class="required" for="plane_id">{{ trans('cruds.booking.fields.plane') }}</label>
                <select class="form-control select2 {{ $errors->has('plane') ? 'is-invalid' : '' }}" name="plane_id" id="plane_id" required>
                    @foreach($planes as $id => $plane)
                        <option value="{{ $id }}" {{ old('plane_id') == $id ? 'selected' : '' }}>{{ $plane }}</option>
                    @endforeach
                </select>
                @if($errors->has('plane'))
                    <span class="text-danger">{{ $errors->first('plane') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.plane_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="reservation_start">{{ trans('cruds.booking.fields.reservation_start') }}</label>
                <input class="form-control {{ $errors->has('reservation_start') ? 'is-invalid' : '' }}" type="text" name="reservation_start" id="reservation_start" value="{{ old('reservation_start') }}" required>
                @if($errors->has('reservation_start'))
                    <span class="text-danger">{{ $errors->first('reservation_start') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.reservation_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="reservation_stop">{{ trans('cruds.booking.fields.reservation_stop') }}</label>
                <input class="form-control {{ $errors->has('reservation_stop') ? 'is-invalid' : '' }}" type="text" name="reservation_stop" id="reservation_stop" value="{{ old('reservation_stop') }}" required>
                @if($errors->has('reservation_stop'))
                    <span class="text-danger">{{ $errors->first('reservation_stop') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.booking.fields.reservation_stop_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.booking.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description">{{ old('description') }}</textarea>
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

@section('scripts')
<script>
    $(document).ready(function () {

        $('#reservation_start').datetimepicker({
            minDate: moment(),
            format: 'DD.MM.YYYY HH:mm',
            locale: '{{ app()->getLocale() }}',
            sideBySide: true,
            toolbarPlacement: 'bottom',
            showTodayButton: false,
            showClear: true,
            showClose: true,
            viewMode: 'days',
            inline: false,
            widgetPositioning: {
                horizontal: 'auto',
                vertical: 'bottom'
            },
            icons: {
                time: 'fas fa-clock-o',
                date: 'fas fa-calendar-alt',
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-dot-circle',
                clear: 'fas fa-trash-alt',
                close: 'fas fa-check-circle',

            },
            //disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 6 })], [moment({ h: 20, m: 00 }), moment({ h: 24 })]],
            enabledHours: [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
            stepping: 15,

        });

        $('#reservation_stop').datetimepicker({
            useCurrent: false,
            focusOnShow: false,
            format: 'DD.MM.YYYY HH:mm',
            locale: '{{ app()->getLocale() }}',
            sideBySide: true,
            toolbarPlacement: 'bottom',
            showTodayButton: false,
            showClear: true,
            showClose: true,
            viewMode: 'days',
            inline: false,
            widgetPositioning: {
                horizontal: 'auto',
                vertical: 'bottom'
            },
            icons: {
                time: 'fas fa-clock-o',
                date: 'fas fa-calendar-alt',
                up: 'fas fa-chevron-up',
                down: 'fas fa-chevron-down',
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
                today: 'fas fa-dot-circle',
                clear: 'fas fa-trash-alt',
                close: 'fas fa-check-circle',

            },
            //disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 6 })], [moment({ h: 20, m: 00 }), moment({ h: 24 })]],
            enabledHours: [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
            stepping: 15,

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
