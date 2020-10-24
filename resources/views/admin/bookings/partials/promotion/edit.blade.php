<input type="hidden" name="plane_id" id="plane_id" value="{{ old('plane_id', $booking->plane_id) }}" readonly>
<div class="form-group">
    <label for="users">{{ trans('cruds.booking.fields.user') }}</label>
    <div style="padding-bottom: 4px">
        <span class="btn btn-info btn-xs select-all" style="border-radius: 0">{{ trans('global.select_all') }}</span>
        <span class="btn btn-info btn-xs deselect-all"
              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
    </div>
    <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}" name="users[]" id="users"
            multiple>
        @foreach($users as $id => $user)
            <option
                value="{{ $id }}" {{ (in_array($id, old('bookingUsers', [])) || $booking->bookingUsers->contains($id)) ? 'selected' : '' }}>{{ $user }}</option>
        @endforeach
    </select>
    @if($errors->has('user'))
        <span class="text-danger">{{ $errors->first('user') }}</span>
    @endif
    <span class="help-block text-secondary small">{{ trans('cruds.booking.fields.user_helper') }}</span>
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
        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
            <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status"
                   value="{{ $key }}"
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
    <div class="form-check {{ $errors->has('checkin') ? 'is-invalid' : '' }}">
        <input type="hidden" name="checkin" value="0">
        <input class="form-check-input" type="checkbox" name="checkin" id="checkin"
               value="1" {{ old('checkin', 0) == 1 ? 'checked' : '' }}>
        <label class="form-check-label" for="checkin">{{ trans('cruds.booking.fields.checkin') }}</label>
    </div>
    @if($errors->has('checkin'))
        <span class="text-danger">{{ $errors->first('checkin') }}</span>
    @endif
    <span class="help-block text-secondary small">{{ trans('cruds.booking.fields.checkin_helper') }}</span>
</div>
<div class="form-group">
    <div class="form-check {{ $errors->has('email') ? 'is-invalid' : '' }}">
        <input type="hidden" name="email" value="0">
        <input class="form-check-input" type="checkbox" name="email" id="email"
               value="1" {{ old('email', 0) == 1 ? 'checked' : '' }}>
        <label class="form-check-label"
               for="email">{{ trans('cruds.booking.fields.email') }}</label>
    </div>
    @if($errors->has('email'))
        <span class="text-danger">{{ $errors->first('email') }}</span>
    @endif
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
            let status_val_0 = $('input[name="status"][value="0"]');
            status_val_0.prop("checked", true);
        });
    </script>
@endsection
