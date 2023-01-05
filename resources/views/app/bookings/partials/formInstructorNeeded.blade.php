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
