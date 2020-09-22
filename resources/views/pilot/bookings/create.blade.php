@extends('layouts.pilot')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }}
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route("pilot.bookings.store") }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}">
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
                        {!! trans('global.medicalCheck') !!}
                    </div>
                    <div class="alert alert-warning alert-dismissible" id="warning-activity" style="display: none">
                        <h5><i class="icon fas fa-info"></i>{{ trans('global.caution') }}</h5>
                        {!! trans('global.activityCheck') !!}
                    </div>
                    <div class="alert alert-info alert-dismissible" id="info-balance" style="display: none">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h5><i class="icon fas fa-info"></i>{{ trans('global.info') }}</h5>
                        {{ trans('global.balanceCheck') }}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.1.0/dist/sweetalert2.all.min.js"></script>
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })
    </script>
    <script>
        $(document).ready(function () {
            let user = $('#user_id').val();
            let plane;

            function formChecks(data) {
                if (data.medicalCheckPassed === false) {
                    $("#warning-medical").show();
                    $('input[name="instructor_needed"][value="1"]').prop("checked", true);
                    $('input[name="instructor_needed"][value="0"]').prop("disabled", true);
                }

                if ((data.ratingCheckPassed === true) && (data.medicalCheckPassed === true)) {
                    $('input[name="instructor_needed"][value="0"]').prop("disabled", false);
                    $('input[name="instructor_needed"][value="0"]').prop("checked", true);
                } else {
                    $('input[name="instructor_needed"][value="1"]').prop("checked", true);
                    $('input[name="instructor_needed"][value="0"]').prop("disabled", true);
                }

                if ((data.balanceCheckPassed === false)) {
                    $("#info-balance").show();
                    $("#reservation_start").closest(".form-group").hide();
                    $("#reservation_stop").closest(".form-group").hide();
                    $("#description").closest(".form-group").hide();
                    $("button[type=submit]").hide();
                }

                if ((data.activityCheckPassed === false)) {
                    $("#warning-activity").show();
                    $('input[name="instructor_needed"][value="1"]').prop("checked", true);
                    $('input[name="instructor_needed"][value="0"]').prop("disabled", true);
                }
            }

            $("#plane_id").change(function () {
                plane = $(this).val();
                if ($(user)) {
                    $.ajax({
                        url: "{{ route('pilot.ratings.getRatingsForUser') }}?user_id=" + user + "&plane_id=" + plane,
                        method: 'GET',
                        success: function (data) {
                            formChecks(data);
                        }
                    });
                }
            });

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

            $("#reservation_start").on("dp.change", function (e) {
                $('#reservation_stop').data("DateTimePicker").minDate(e.date);
            });
            $("#reservation_stop").on("dp.change", function (e) {
                $('#reservation_start').data("DateTimePicker").maxDate(e.date);
            });

        });
    </script>
@endsection
