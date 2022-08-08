<div class="card-header">
    {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }} <span
        class="badge badge-secondary">{{$mode_name}}</span>
</div>
<div class="card-body">
    <form method="POST" action="{{ route("app.bookings.store") }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode_id" id="mode_id" value="{{$mode_id}}" readonly>
        <input type="hidden" name="status" id="status" value="0" readonly>

        @can('booking_charter_create')
            <div class="form-group">
                <label class="required" for="user_id">{{ trans('cruds.activity.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id"
                        id="user_id" required>
                    @foreach($users as $id => $user)
                        <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span class="help-block text-secondary small">{{ trans('cruds.activity.fields.user_helper') }}</span>
            </div>
        @endcan
        @can('bookings_create')
            <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}" readonly>
        @endcan

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
            <div>
                <label class="required"
                       for="instructor_needed">{{ trans('cruds.booking.fields.instructor_needed') }}</label>
            </div>
            @foreach(App\Booking::INSTRUCTOR_NEEDED_RADIO as $key => $label)
                <div
                    class="form-check form-check-inline icheck-primary {{ $errors->has('instructor_needed') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="radio" id="instructor_needed_{{ $key }}"
                           name="instructor_needed" value="{{ $key }}" required>
                    <label class="form-check-label" for="instructor_needed_{{ $key }}">{{ $label }}</label>
                </div>
            @endforeach
            @if($errors->has('instructor_needed'))
                <span class="text-danger">{{ $errors->first('instructor_needed') }}</span>
            @endif
            <div
                class="help-block text-secondary small">{!! trans('cruds.booking.fields.instructor_needed_helper') !!}</div>
        </div>
        <div class="form-group">
            <div class="alert alert-warning alert-dismissible" id="warning-medical" style="display: none">
                <h5><i class="icon fas fa-info"></i>{{ trans('global.caution') }}</h5>
                {!! trans('global.medicalCheck') !!}
            </div>
            <div class="alert alert-warning alert-dismissible" id="warning-activity" style="display: none">
                <h5><i class="icon fas fa-info"></i>{{ trans('global.caution') }}</h5>
                {!! trans('global.activityCheck') !!}
            </div>
            <div class="alert alert-info alert-dismissible" id="info-balance" style="display: none">
                <h5><i class="icon fas fa-info"></i>{{ trans('global.info') }}</h5>
                {{ trans('global.balanceCheck') }}
            </div>
            <div class="alert alert-info alert-dismissible" id="info-rating" style="display: none">
                <h5><i class="icon fas fa-info"></i>{{ trans('global.info') }}</h5>
                {{ trans('global.ratingCheck') }}
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

@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            let user;
            let plane;
            let warning_medical = $("#warning-medical");
            let warning_activity = $("#warning-activity");
            let info_balance = $("#info-balance");
            let info_rating = $("#info-rating");
            let instructor_needed_val_1 = $('input[name="instructor_needed"][value="1"]');
            let instructor_needed_val_0 = $('input[name="instructor_needed"][value="0"]');

            instructor_needed_val_0.prop("checked", false);
            instructor_needed_val_1.prop("checked", false);

            @can('booking_charter_create')
            $("#user_id").change(function () {
                user = $(this).val();
                instructor_needed_val_0.prop("checked", false);
                instructor_needed_val_1.prop("checked", false);
                if ($(plane)) {
                    $.ajax({
                        url: "{{ route('app.ratings.getRatingsForUser') }}?user_id=" + user + "&plane_id=" + plane,
                        method: 'GET',
                        success: function (data) {
                            formChecks(data);
                        }
                    });
                }
            });
            @endcan

                @can('bookings_create')
                user = $('#user_id').val();
            @endcan

            $("#plane_id").change(function () {
                plane = $(this).val();
                instructor_needed_val_0.prop("checked", false);
                instructor_needed_val_1.prop("checked", false);
                if ($(user)) {
                    $.ajax({
                        url: "{{ route('app.ratings.getRatingsForUser') }}?user_id=" + user + "&plane_id=" + plane,
                        method: 'GET',
                        success: function (data) {
                            formChecks(data);
                        }
                    });
                }
            });

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
                }

                if (data.ratingCheckPassed === false) {
                    info_rating.show();
                    instructor_needed_val_1.prop("checked", true);
                    instructor_needed_val_0.prop("disabled", true);
                }

                if (data.activityCheckPassed === false) {
                    warning_activity.show();
                    instructor_needed_val_1.prop("checked", true);
                    instructor_needed_val_0.prop("disabled", true);
                }

                if (data.balanceCheckPassed === false) {
                    info_balance.show();
                    $("#reservation_start").prop("disabled", true);
                    $("#reservation_stop").prop("disabled", true);
                    $("#description").prop("disabled", true);
                    $("button[type=submit]").prop("disabled", true);
                }
            }

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

