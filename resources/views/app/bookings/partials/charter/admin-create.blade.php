<div class="card-header">
    {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }} <span
        class="badge badge-secondary">{{$mode_name->name}}-Admin</span>
</div>
<div class="card-body">
    <form method="POST" action="{{ route("app.bookings.store") }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode_id" id="mode_id" value="{{$mode_id}}" readonly>
        @include('app.bookings.partials.formPilot')
        @include('app.bookings.partials.formPlane')
        @include('app.bookings.partials.formAdminAlerts')
        @include('app.bookings.partials.formInstructor')
        @include('app.bookings.partials.formReservationStartStop')
        <div class="form-group">
            <label class="required">{{ trans('cruds.booking.fields.status') }}</label>
            @foreach(App\Booking::STATUS_RADIO as $key => $label)
                <div
                    class="form-check  form-check-inline icheck-primary {{ $errors->has('status') ? 'is-invalid' : '' }}">
                    <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}"
                           required>
                    <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                </div>
            @endforeach
            @if($errors->has('status'))
                <span class="text-danger">{{ $errors->first('status') }}</span>
            @endif
            <span class="help-block text-secondary small">{!! trans('cruds.booking.fields.status_helper') !!}</span>
        </div>
        <div class="form-group">
            <div class="icheck-primary">
                <input type="checkbox" name="email" id="email"
                       value="1" {{ old('email', 0) == 1 ? 'checked' : '' }}>
                <label for="email">{{ trans('cruds.booking.fields.email') }}</label>
            </div>
            <span class="help-block text-secondary small">{{ trans('cruds.booking.fields.email_helper') }}</span>
        </div>
        @include('app.bookings.partials.formDescription')
        <div class="form-group">
            <button class="btn btn-success" type="submit">
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

            $("#plane_id").change(function () {
                plane = $(this).val();
                user = $('#user_id').val()
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

                if (data.medicalCheckPassed === false) {
                    warning_medical.show();
                }

                if (data.ratingCheckPassed === false) {
                    info_rating.show();
                }

                if (data.activityCheckPassed === false) {
                    warning_activity.show();
                }

                if (data.balanceCheckPassed === false) {
                    info_balance.show();
                }
            }
        });
    </script>
@endsection

