@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h4 class="m-0 text-dark">
                {{ trans('cruds.booking.title_singular') }}
            </h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('app.home')}}">Home</a></li>
                <li class="breadcrumb-item"><a
                        href="{{route('admin.bookings.index')}}">{{trans('cruds.booking.title')}}</a></li>
                <li class="breadcrumb-item active">{{ trans('global.create') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>
    <div class="card-transparent">
        <div class="card-header"></div>

        <div class="card-body">
            <form method="POST" action="{{ route("admin.bookings.store") }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="required" for="mode_id">{{ trans('cruds.booking.fields.mode') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-tags"></i>
                      </span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('mode') ? 'is-invalid' : '' }}"
                                name="mode_id"
                                id="mode_id" required>
                            @foreach($modes as $id => $mode)
                                <option
                                    value="{{ $id }}" {{ old('mode_id') == $id ? 'selected' : '' }}>{{ $mode }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('mode'))
                            <span class="text-danger">{{ $errors->first('mode') }}</span>
                        @endif
                        <span
                            class="help-block text-secondary small">{{ trans('cruds.booking.fields.mode_helper') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="required" for="plane_id">{{ trans('cruds.booking.fields.plane') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-plane"></i>
                      </span>
                        </div>
                        <select class="form-control select2 {{ $errors->has('plane') ? 'is-invalid' : '' }}"
                                name="plane_id"
                                id="plane_id" required>
                            @foreach($planes as $id => $plane)
                                <option
                                    value="{{ $id }}" {{ old('plane_id') == $id ? 'selected' : '' }}>{{ $plane }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('plane'))
                            <span class="text-danger">{{ $errors->first('plane') }}</span>
                        @endif
                        <span
                            class="help-block text-secondary small">{{ trans('cruds.booking.fields.plane_helper') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="reservation_start">{{ trans('cruds.booking.fields.reservation_start') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                      </span>
                        </div>
                        <input class="form-control {{ $errors->has('reservation_start') ? 'is-invalid' : '' }}"
                               type="text" name="reservation_start" id="reservation_start"
                               value="{{ old('reservation_start') }}" required>
                        @if($errors->has('reservation_start'))
                            <span class="text-danger">{{ $errors->first('reservation_start') }}</span>
                        @endif
                    </div>
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.reservation_start_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required"
                           for="reservation_stop">{{ trans('cruds.booking.fields.reservation_stop') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                      <span class="input-group-text">
                        <i class="fas fa-calendar-alt"></i>
                      </span>
                        </div>
                        <input class="form-control {{ $errors->has('reservation_stop') ? 'is-invalid' : '' }}"
                               type="text" name="reservation_stop" id="reservation_stop"
                               value="{{ old('reservation_stop') }}" required>
                        @if($errors->has('reservation_stop'))
                            <span class="text-danger">{{ $errors->first('reservation_stop') }}</span>
                        @endif
                    </div>
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.reservation_stop_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">
                        {{ trans('global.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('styles')

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            $('#reservation_start').datetimepicker({
                minDate: moment(),
                format: 'DD/MM/YYYY HH:mm',
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
                format: 'DD/MM/YYYY HH:mm',
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
                    vertical: 'top'
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

            $("#reservation_start").on("dp.change", function (e) {
                $('#reservation_stop').data("DateTimePicker").minDate(e.date);
            });
            $("#reservation_stop").on("dp.change", function (e) {
                $('#reservation_start').data("DateTimePicker").maxDate(e.date);
            });

        });
    </script>
@endsection
