<div class="form-group">
    <label class="required" for="plane_id">{{ trans('cruds.booking.fields.plane') }}</label>
    <div class="input-group">
        <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-plane"></i>
              </span>
        </div>
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
</div>
