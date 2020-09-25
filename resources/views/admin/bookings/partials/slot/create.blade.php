<div class="card-transparent">
    <div class="card-header"></div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.schedules.store") }}" enctype="multipart/form-data">
            @csrf
            <div id="modus" data-field="{{$modus}}"></div>
            <input type="hidden" name="modus" id="modus" value="1" readonly>
            <input type="hidden" name="status" id="status" value="0" readonly>
            <input type="hidden" name="instructor_needed" id="instructor_needed" value="0" readonly>
            <div class="form-group">
                <label class="required" for="slot_id_select">{{ trans('cruds.slot.fields.title') }}</label>
                <select class="form-control select2 {{ $errors->has('slot') ? 'is-invalid' : '' }}"
                        name="slot_id"
                        id="slot_id_select" required>
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
                <label for="user_id_select">{{ trans('cruds.activity.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}"
                        name="user_id" id="user_id_select">
                    @foreach($users as $id => $user)
                        <option
                            value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                    <span class="text-danger">{{ $errors->first('user') }}</span>
                @endif
                <span
                    class="help-block text-secondary small">{{ trans('cruds.schedule.fields.user_helper') }}</span>
            </div>
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
                    class="help-block text-secondary small">{{ trans('cruds.schedule.fields.instructor_helper') }}</span>
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
                    <input class="form-control {{ $errors->has('reservation_start') ? 'is-invalid' : '' }}" type="text"
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
                    <input class="form-control {{ $errors->has('reservation_stop') ? 'is-invalid' : '' }}" type="text"
                           name="reservation_stop" id="reservation_stop" value="{{ old('reservation_stop') }}" required>
                    @if($errors->has('reservation_stop'))
                        <span class="text-danger">{{ $errors->first('reservation_stop') }}</span>
                    @endif
                </div>
                <span
                    class="help-block text-secondary small">{{ trans('cruds.booking.fields.reservation_stop_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.booking.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
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

{{--<script>--}}
{{--    $(document).ready(function () {--}}

{{--        $("#instructor_id_select").change(function () {--}}
{{--            $('#instructor_needed').val(1);--}}
{{--        });--}}

{{--        $("#user_id_select").change(function () {--}}
{{--            $('#status').val(1);--}}
{{--        });--}}

{{--        $('#reservation_start').datetimepicker({--}}
{{--            minDate: moment(),--}}
{{--            format: 'DD/MM/YYYY HH:mm',--}}
{{--            locale: '{{ app()->getLocale() }}',--}}
{{--            sideBySide: true,--}}
{{--            toolbarPlacement: 'bottom',--}}
{{--            showTodayButton: false,--}}
{{--            showClear: true,--}}
{{--            showClose: true,--}}
{{--            viewMode: 'days',--}}
{{--            inline: false,--}}
{{--            widgetPositioning: {--}}
{{--                horizontal: 'auto',--}}
{{--                vertical: 'bottom'--}}
{{--            },--}}
{{--            icons: {--}}
{{--                time: 'fas fa-clock-o',--}}
{{--                date: 'fas fa-calendar-alt',--}}
{{--                up: 'fas fa-chevron-up',--}}
{{--                down: 'fas fa-chevron-down',--}}
{{--                previous: 'fas fa-chevron-left',--}}
{{--                next: 'fas fa-chevron-right',--}}
{{--                today: 'fas fa-dot-circle',--}}
{{--                clear: 'fas fa-trash-alt',--}}
{{--                close: 'fas fa-check-circle',--}}

{{--            },--}}
{{--            //disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 6 })], [moment({ h: 20, m: 00 }), moment({ h: 24 })]],--}}
{{--            enabledHours: [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],--}}
{{--            stepping: 15,--}}

{{--        });--}}

{{--        $('#reservation_stop').datetimepicker({--}}
{{--            useCurrent: false,--}}
{{--            focusOnShow: false,--}}
{{--            format: 'DD/MM/YYYY HH:mm',--}}
{{--            locale: '{{ app()->getLocale() }}',--}}
{{--            sideBySide: true,--}}
{{--            toolbarPlacement: 'bottom',--}}
{{--            showTodayButton: false,--}}
{{--            showClear: true,--}}
{{--            showClose: true,--}}
{{--            viewMode: 'days',--}}
{{--            inline: false,--}}
{{--            widgetPositioning: {--}}
{{--                horizontal: 'auto',--}}
{{--                vertical: 'bottom'--}}
{{--            },--}}
{{--            icons: {--}}
{{--                time: 'fas fa-clock-o',--}}
{{--                date: 'fas fa-calendar-alt',--}}
{{--                up: 'fas fa-chevron-up',--}}
{{--                down: 'fas fa-chevron-down',--}}
{{--                previous: 'fas fa-chevron-left',--}}
{{--                next: 'fas fa-chevron-right',--}}
{{--                today: 'fas fa-dot-circle',--}}
{{--                clear: 'fas fa-trash-alt',--}}
{{--                close: 'fas fa-check-circle',--}}

{{--            },--}}
{{--            //disabledTimeIntervals: [[moment({ h: 0 }), moment({ h: 6 })], [moment({ h: 20, m: 00 }), moment({ h: 24 })]],--}}
{{--            enabledHours: [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],--}}
{{--            stepping: 15,--}}

{{--        });--}}

{{--        $("#reservation_start").on("dp.change", function (e) {--}}
{{--            $('#reservation_stop').data("DateTimePicker").minDate(e.date);--}}
{{--        });--}}
{{--        $("#reservation_stop").on("dp.change", function (e) {--}}
{{--            $('#reservation_start').data("DateTimePicker").maxDate(e.date);--}}
{{--        });--}}

{{--    });--}}
{{--</script>--}}

