<div class="form-group">
    <label class="required" for="plane_id">{{ trans('cruds.booking.fields.user') }}</label>
    <div class="input-group">
        <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-user"></i>
              </span>
        </div>
        <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id"
                id="user_id" required>
            @foreach($users as $id => $user)
                <option
                    value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $user }}</option>
            @endforeach
        </select>
        @if($errors->has('user'))
            <span class="text-danger">{{ $errors->first('user') }}</span>
        @endif
        <span
            class="help-block text-secondary small">{{ trans('cruds.booking.fields.user_helper') }}</span>
    </div>
</div>

