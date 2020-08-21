@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.store") }}" enctype="multipart/form-data">
            @csrf
            @if (auth()->user()->IsAdminByRole())
                <div class="form-group">
                    <label class="required" for="user_id_select">{{ trans('cruds.booking.fields.user') }}</label>
                    <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id_select" required>
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
                    <label class="text" for="user_id_input">{{ trans('cruds.booking.fields.user') }} : {{ $user->name }}</label>
                    <input type="hidden" name="user_id" id="user_id_input" value="{{ $user->id }}" readonly>
                </div>
            @endif
            <div class="form-group">
                <label class="required" for="type_id">{{ trans('cruds.activity.fields.type') }}</label>
                <select class="form-control select2 {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type_id" id="type_id" required>
                    <option selected value="">{{ trans('global.pleaseSelect') }}</option>
                    {{-- The values come from ajax call when selecting the pilot. It depends on the factors --}}
                </select>
                @if($errors->has('type'))
                    <span class="text-danger">{{ $errors->first('type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.activity.fields.type_helper') }}</span>
            </div>
{{--            @if (auth()->user()->IsAdminByRole())--}}
{{--                <div class="form-group">--}}
{{--                    <label for="instructor_id">{{ trans('cruds.booking.fields.instructor') }}</label>--}}
{{--                    <select class="form-control select2 {{ $errors->has('instructor') ? 'is-invalid' : '' }}" name="instructor_id" id="instructor_id" disabled>--}}
{{--                        @foreach($instructors as $id => $instructor)--}}
{{--                            <option value="{{ $id }}" {{ old('instructor_id') == $id ? 'selected' : '' }}>{{ $instructor }}</option>--}}
{{--                        @endforeach--}}
{{--                    </select>--}}
{{--                    @if($errors->has('instructor'))--}}
{{--                        <span class="text-danger">{{ $errors->first('instructor') }}</span>--}}
{{--                    @endif--}}
{{--                    <span class="help-block">{{ trans('cruds.booking.fields.instructor_helper') }}</span>--}}
{{--                </div>--}}
{{--                <div class="form-group">--}}
{{--                    <label class="required">{{ trans('cruds.booking.fields.status') }}</label>--}}
{{--                    @foreach(App\Booking::STATUS_RADIO as $key => $label)--}}
{{--                        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">--}}
{{--                            <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}" {{ old('status', '0') === (string) $key ? 'checked' : '' }} required>--}}
{{--                            <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>--}}
{{--                        </div>--}}
{{--                    @endforeach--}}
{{--                    @if($errors->has('status'))--}}
{{--                        <span class="text-danger">{{ $errors->first('status') }}</span>--}}
{{--                    @endif--}}
{{--                    <span class="help-block">{{ trans('cruds.booking.fields.status_helper') }}</span>--}}
{{--                </div>--}}
{{--            @else--}}
{{--                <input type="hidden" name="status" id="status" value="{{ old('status', '0')}}" readonly>--}}
{{--            @endif--}}
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
        if($('#user_id_input').length){
            let user =  $("#user_id_input").val();
            $.ajax({
                url: "{{ route('admin.types.getTypeByFactor') }}?user_id=" + user,
                method: 'GET',
                success: function(data) {
                    $('#type_id').html(data.html);
                }
            });
        }

        $("#user_id_select").change(function(){
            $.ajax({
                url: "{{ route('admin.types.getTypeByFactor') }}?user_id=" + $(this).val(),
                method: 'GET',
                success: function(data) {
                    $('#type_id').html(data.html);
                }
            });
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

        $("#reservation_start").on("dp.change",function (e) {
            $('#reservation_stop').data("DateTimePicker").minDate(e.date);
        });
        $("#reservation_stop").on("dp.change",function (e) {
            $('#reservation_start').data("DateTimePicker").maxDate(e.date);
        });

    });
</script>
@endsection
