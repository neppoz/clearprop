<input type="hidden" name="plane_id" id="plane_id" value="{{ old('plane_id', $booking->plane_id) }}" readonly>
<div class="form-group">
    <label class="required">{{ trans('cruds.booking.fields.status') }}</label>
    @foreach(App\Booking::STATUS_RADIO as $key => $label)
        <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
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

        });
    </script>
@endsection
