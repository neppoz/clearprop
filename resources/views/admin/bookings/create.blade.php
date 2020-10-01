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
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
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
                    <label class="required" for="modus_select">{{ trans('cruds.booking.fields.modus') }}</label>
                    <select class="form-control select2 {{ $errors->has('modus') ? 'is-invalid' : '' }}"
                            name="modus"
                            id="modus_select" required>
                        @foreach(App\Booking::MODUS_SELECT as $key => $label)
                            <option
                                value="{{ $key }}" {{ old('modus') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('modus'))
                        <span class="text-danger">{{ $errors->first('modus') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.modus_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="slot_id_select">{{ trans('cruds.slot.title_singular') }}</label>
                    <select class="form-control select2 {{ $errors->has('slot') ? 'is-invalid' : '' }}"
                            name="slot_id"
                            id="slot_id_select">
                        @foreach($slots as $id => $slot)
                            <option
                                value="{{ $id }}" {{ old('slot_id') == $id ? 'selected' : '' }}>{{ $slot }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('slot'))
                        <span class="text-danger">{{ $errors->first('slot') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.slot.fields.title_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="user_id_select">{{ trans('cruds.booking.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}"
                            name="user_id"
                            id="user_id_select" required>
                        @foreach($users as $id => $user)
                            <option
                                value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <span class="text-danger">{{ $errors->first('user') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.user_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required" for="plane_id">{{ trans('cruds.booking.fields.plane') }}</label>
                    <select class="form-control select2 {{ $errors->has('plane') ? 'is-invalid' : '' }}" name="plane_id"
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
                <div class="form-group">
                    <label class="required">{{ trans('cruds.booking.fields.instructor_needed') }}</label>
                    @foreach(App\Booking::INSTRUCTOR_NEEDED_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('instructor_needed') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="instructor_needed_{{ $key }}"
                                   name="instructor_needed"
                                   value="{{ $key }}"
                                   {{ old('instructor_needed', '1') === (string) $key ? 'checked' : '' }} required>
                            <label class="form-check-label" for="instructor_needed_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('instructor_needed'))
                        <span class="text-danger">{{ $errors->first('instructor_needed') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{!! trans('cruds.booking.fields.instructor_needed_helper') !!}</span>
                </div>
                <div class="form-group">
                    <div class="alert alert-warning alert-dismissible" id="warning-medical" style="display: none">
                        <h5><i class="icon fas fa-info"></i>{{ trans('global.caution') }}</h5>
                        {!! trans('global.medicalCheck_for_admin') !!}
                    </div>
                    <div class="alert alert-warning alert-dismissible" id="warning-activity" style="display: none">
                        <h5><i class="icon fas fa-info"></i>{{ trans('global.caution') }}</h5>
                        {!! trans('global.activityCheck_for_admin') !!}
                    </div>
                    <div class="alert alert-info alert-dismissible" id="info-balance" style="display: none">
                        <h5><i class="icon fas fa-info"></i>{{ trans('global.info') }}</h5>
                        {{ trans('global.balanceCheck_for_admin') }}
                    </div>
                    <div class="alert alert-info alert-dismissible" id="info-rating" style="display: none">
                        <h5><i class="icon fas fa-info"></i>{{ trans('global.info') }}</h5>
                        {{ trans('global.ratingCheck_for_admin') }}
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
                               type="text"
                               name="reservation_start" id="reservation_start" value="{{ old('reservation_start') }}"
                               required>
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
                               type="text"
                               name="reservation_stop" id="reservation_stop" value="{{ old('reservation_stop') }}"
                               required>
                        @if($errors->has('reservation_stop'))
                            <span class="text-danger">{{ $errors->first('reservation_stop') }}</span>
                        @endif
                    </div>
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.reservation_stop_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.booking.fields.status') }}</label>
                    @foreach(App\Booking::STATUS_RADIO as $key => $label)
                        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="status_{{ $key }}"
                                   name="status"
                                   value="{{ $key }}"
                                   {{ old('status', '0') === (string) $key ? 'checked' : '' }} required>
                            <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has('status'))
                        <span class="text-danger">{{ $errors->first('status') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{!! trans('cruds.booking.fields.status_helper') !!}</span>
                </div>
                <div class="form-group">
                    <div class="form-check {{ $errors->has('email') ? 'is-invalid' : '' }}">
                        <input type="hidden" name="email" value="0">
                        <input class="form-check-input" type="checkbox" name="email" id="email"
                               value="1" {{ old('email', 0) == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="email">{{ trans('cruds.booking.fields.email') }}</label>
                    </div>
                    @if($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.email_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.booking.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              name="description"
                              id="description">{{ old('description') }}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.description_helper') }}</span>
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

@section('scripts')
    <script>
        $(document).ready(function () {
            let slot = $("#slot_id_select");
            let modus = $("#modus_select");
            let user_select = $("#user_id_select");
            let modus_val = '0';
            let user;
            let plane;
            let warning_medical = $("#warning-medical");
            let warning_activity = $("#warning-activity");
            let info_balance = $("#info-balance");
            let info_rating = $("#info-rating");
            let instructor_needed_val_1 = $('input[name="instructor_needed"][value="1"]');
            let instructor_needed_val_0 = $('input[name="instructor_needed"][value="0"]');
            let status_val_1 = $('input[name="status"][value="1"]');
            let status_val_0 = $('input[name="status"][value="0"]');

            // Call the function passing value
            switchModus(modus_val);

            modus.change(function () {
                modus_val = modus.val();
                switchModus(modus_val);
            });

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

            $("#reservation_start").on("dp.change", function (e) {
                $('#reservation_stop').data("DateTimePicker").minDate(e.date);
            });
            $("#reservation_stop").on("dp.change", function (e) {
                $('#reservation_start').data("DateTimePicker").maxDate(e.date);
            });

            function switchModus(modus_val) {
                if (modus_val === '0') { // modus is personal

                    slot.prop("disabled", true);
                    user_select.prop("disabled", false);

                    instructor_needed_val_1.prop("checked", true);
                    status_val_0.prop("checked", true);

                    function formChecks(data) {
                        warning_medical.hide();
                        warning_activity.hide();
                        info_balance.hide();
                        info_rating.hide();
                        instructor_needed_val_0.prop("disabled", false);

                        if (data.medicalCheckPassed === false) {
                            warning_medical.show();
                            instructor_needed_val_1.prop("checked", true);
                            instructor_needed_val_0.prop("disabled", true);
                            status_val_0.prop("checked", true);
                        }

                        if (data.ratingCheckPassed === false) {
                            info_rating.show();
                            instructor_needed_val_1.prop("checked", true);
                            status_val_0.prop("checked", true);
                        }

                        if ((data.activityCheckPassed === false)) {
                            warning_activity.show();
                            instructor_needed_val_1.prop("checked", true);
                            status_val_0.prop("checked", true);
                        }

                        if ((data.balanceCheckPassed === false)) {
                            info_balance.show();
                        }
                    }

                    $("#user_id_select").change(function () {
                        user = $(this).val();
                        plane = $("#plane_id").val();
                        warning_medical.hide();
                        if ($(plane)) {
                            $.ajax({
                                url: "{{ route('admin.ratings.getRatingsForUser') }}?user_id=" + user + "&plane_id=" + plane,
                                method: 'GET',
                                success: function (data) {
                                    formChecks(data);
                                }
                            });
                        }
                    });

                    $("#plane_id").change(function () {
                        plane = $(this).val();
                        if ($(user)) {
                            $.ajax({
                                url: "{{ route('admin.ratings.getRatingsForUser') }}?user_id=" + user + "&plane_id=" + plane,
                                method: 'GET',
                                success: function (data) {
                                    formChecks(data);
                                }
                            });
                        }
                    });
                }

                if (modus_val === '1') { // modus is slot, open for booking

                    slot.prop("disabled", false);
                    user_select.val('');
                    user_select.prop("disabled", true);
                    $('#status').val(0);
                    status_val_0.prop("checked", true);
                    status_val_1.prop("disabled", true);

                    warning_medical.hide();
                    warning_activity.hide();
                    info_balance.hide();
                    info_rating.hide();
                }

                if (modus_val === '2') { // modus is slot blocked

                    slot.prop("disabled", false);
                    user_select.val('');
                    user_select.prop("disabled", true);
                    $('#status').val(1);
                    status_val_1.prop("checked", true);
                    status_val_0.prop("disabled", true);

                    warning_medical.hide();
                    warning_activity.hide();
                    info_balance.hide();
                    info_rating.hide();
                }
            }
        });
    </script>
@endsection
