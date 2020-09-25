@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h4 class="m-0 text-dark">
                {{ trans('global.create') }} &nbsp;
                @if($modus === 'pilot')
                    {{ trans('cruds.booking.title_singular') }}
                @elseif($modus === 'slot')
                    {{ trans('cruds.schedule.title_singular') }}
                @endif
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

    @if($modus === 'pilot')
        @include('admin.bookings.partials.pilot.create')
    @elseif($modus === 'slot')
        @include('admin.bookings.partials.slot.create')
    @endif

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            let modus = $('#modus').data("field");

            if (modus === 'pilot') {
                let user;
                let plane;
                let warning_medical = $("#warning-medical");
                let warning_activity = $("#warning-activity");
                let info_balance = $("#info-balance");
                let info_rating = $("#info-rating");
                let instructor_needed_val_1 = $('input[name="instructor_needed"][value="1"]');
                let instructor_needed_val_0 = $('input[name="instructor_needed"][value="0"]');

                instructor_needed_val_1.prop("checked", true);

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
                    }

                    if ((data.activityCheckPassed === false)) {
                        warning_activity.show();
                        instructor_needed_val_1.prop("checked", true);
                    }

                    if ((data.balanceCheckPassed === false)) {
                        info_balance.show();
                    }
                }

                $("#user_id_select").change(function () {
                    user = $(this).val();
                    plane = $("#plane_id").val();
                    $("#warning-medical").hide();
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

            if (modus === 'slot') {
                $("#instructor_id_select").change(function () {
                    $('#instructor_needed').val(1);
                });

                $("#user_id_select").change(function () {
                    $('#status').val(1);
                });
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

        });
    </script>
@endsection
