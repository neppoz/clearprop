<div class="card-header">
    {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }} <span
        class="badge badge-secondary">{{$mode_name}}</span>
</div>
<div class="card-body">
    <form method="POST" action="{{ route("app.bookings.store") }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode_id" id="mode_id" value="{{$mode_id}}" readonly>
        <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->id }}" readonly>
        @include('app.bookings.partials.formPlane')
        @include('app.bookings.partials.formAlerts')
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
        @include('app.bookings.partials.formReservationStartStop')
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
            let user = $('#user_id').val();
            let plane;
            let warning_medical = $("#warning-medical");
            let warning_activity = $("#warning-activity");
            let info_balance = $("#info-balance");
            let info_rating = $("#info-rating");
            let instructor_needed_val_1 = $('input[name="instructor_needed"][value="1"]');
            let instructor_needed_val_0 = $('input[name="instructor_needed"][value="0"]');

            instructor_needed_val_0.prop("checked", false);
            instructor_needed_val_1.prop("checked", false);

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
        });
    </script>
@endsection

