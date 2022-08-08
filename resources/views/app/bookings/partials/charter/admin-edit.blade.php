<input type="hidden" name="plane_id" id="plane_id" value="{{ old('plane_id', $booking->plane_id) }}" readonly>
<div class="form-group">
    <label class="required" for="users">{{ trans('cruds.booking.fields.user') }}</label>
    <div style="padding-bottom: 4px">
        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
        <span class="btn btn-info btn-xs deselect-all"
              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
    </div>
    <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}" name="users[]" id="users"
            multiple required>
        @foreach($users as $id => $user)
            <option
                value="{{ $id }}" {{ (in_array($id, old('users', [])) || $booking->bookingUsers->contains($id)) ? 'selected' : '' }}>{{ $user }}</option>
        @endforeach
    </select>
    @if($errors->has('users'))
        <span class="text-danger">{{ $errors->first('users') }}</span>
    @endif
    <span class="help-block text-secondary small">{{ trans('cruds.booking.fields.user_helper') }}</span>
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
    <label for="instructors">{{ trans('cruds.activity.fields.instructor') }}</label>
    <div style="padding-bottom: 4px">
        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
        <span class="btn btn-info btn-xs deselect-all"
              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
    </div>
    <select class="form-control select2 {{ $errors->has('instructors') ? 'is-invalid' : '' }}" name="instructors[]"
            id="instructors" multiple>
        @foreach($instructors as $id => $instructor)
            <option
                value="{{ $id }}" {{ (in_array($id, old('instructors', [])) || $booking->bookingInstructors->contains($id)) ? 'selected' : '' }}>{{ $instructor }}</option>
        @endforeach
    </select>
    @if($errors->has('instructors'))
        <span class="text-danger">{{ $errors->first('instructors') }}</span>
    @endif
    <span class="help-block text-secondary small">{{ trans('cruds.booking.fields.instructor_helper') }}</span>
</div>
<div class="form-group">
    <label class="required">{{ trans('cruds.booking.fields.status') }}</label>
    @foreach(App\Booking::STATUS_RADIO as $key => $label)
        <div class="form-check  form-check-inline icheck-primary {{ $errors->has('status') ? 'is-invalid' : '' }}">
            <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status" value="{{ $key }}"
                   {{ old('status', $booking->status) === (string) $key ? 'checked' : '' }} required>
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
<div class="form-group">
    <label for="description">{{ trans('cruds.booking.fields.description') }}</label>
    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
              id="description">{{ old('description', $booking->description) }}</textarea>
    @if($errors->has('description'))
        <span class="text-danger">{{ $errors->first('description') }}</span>
    @endif
    <span class="help-block text-secondary small">{{ trans('cruds.booking.fields.description_helper') }}</span>
</div>
<div class="form-group">
    <button class="btn btn-success" type="submit">
        <i class="fas fa-edit"></i>
        {{ trans('global.update') }} {{ strtolower(trans('cruds.booking.title_singular')) }}
    </button>
</div>


@section('scripts')
    @parent
    <script>
        $(document).ready(function () {
            let user_select = $("#users");
            let user;
            let plane;
            let warning_medical = $("#warning-medical");
            let warning_activity = $("#warning-activity");
            let info_balance = $("#info-balance");
            let info_rating = $("#info-rating");

            user_select.change(function () {
                user = $(this).val();
                plane = $("#plane_id").val();
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
