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
