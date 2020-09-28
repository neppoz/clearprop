<div class="card-transparent">
    <div class="card-header"></div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bookings.store") }}" enctype="multipart/form-data">
            @csrf
            <div id="modus" data-field="{{$modus}}"></div>
            <input type="hidden" name="modus" id="modus" value="0" readonly>
            <div class="form-group">
                <label for="user_id_select">{{ trans('cruds.booking.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}"
                        name="user_id"
                        id="user_id_select" required>
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
            <div class="form-group">
                <label class="required" for="plane_id">{{ trans('cruds.booking.fields.plane') }}</label>
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
            <div class="form-group">
                <label class="required">{{ trans('cruds.booking.fields.instructor_needed') }}</label>
                @foreach(App\Booking::INSTRUCTOR_NEEDED_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('instructor_needed') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="instructor_needed_{{ $key }}"
                               name="instructor_needed"
                               value="{{ $key }}"
                               {{ old('instructor_needed', '1') === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="instructor_needed_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('instructor_needed'))
                    <span class="text-danger">{{ $errors->first('instructor_needed') }}</span>
                @endif
                <span
                    class="help-block text-secondary small">{!! trans('cruds.booking.fields.instructor_needed_helper') !!}</span>
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
                <label class="required"
                       for="reservation_start">{{ trans('cruds.booking.fields.reservation_start') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-calendar-alt"></i>
              </span>
                    </div>
                    <input class="form-control {{ $errors->has('reservation_start') ? 'is-invalid' : '' }}" type="text"
                           name="reservation_start" id="reservation_start" value="{{ old('reservation_start') }}"
                           required>
                    @if($errors->has('reservation_start'))
                        <span class="text-danger">{{ $errors->first('reservation_start') }}</span>
                    @endif
                </div>
                <span
                    class="help-block text-secondary small">{{ trans('cruds.booking.fields.reservation_start_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required"
                       for="reservation_stop">{{ trans('cruds.booking.fields.reservation_stop') }}</label>
                <div class="input-group">
                    <div class="input-group-prepend">
              <span class="input-group-text">
                <i class="fas fa-calendar-alt"></i>
              </span>
                    </div>
                    <input class="form-control {{ $errors->has('reservation_stop') ? 'is-invalid' : '' }}" type="text"
                           name="reservation_stop" id="reservation_stop" value="{{ old('reservation_stop') }}" required>
                    @if($errors->has('reservation_stop'))
                        <span class="text-danger">{{ $errors->first('reservation_stop') }}</span>
                    @endif
                </div>
                <span
                    class="help-block text-secondary small">{{ trans('cruds.booking.fields.reservation_stop_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.booking.fields.status') }}</label>
                @foreach(App\Booking::STATUS_RADIO as $key => $label)
                    <div class="form-check {{ $errors->has('status') ? 'is-invalid' : '' }}">
                        <input class="form-check-input" type="radio" id="status_{{ $key }}"
                               name="status"
                               value="{{ $key }}"
                               {{ old('status', '0') === (string) $key ? 'checked' : '' }} required>
                        <label class="form-check-label" for="status_{{ $key }}">{{ $label }}</label>
                    </div>
                @endforeach
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span
                    class="help-block text-secondary small">{!! trans('cruds.booking.fields.status_helper') !!}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('email') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="email" value="0">
                    <input class="form-check-input" type="checkbox" name="email" id="email"
                           value="1" {{ old('email', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="email">{{ trans('cruds.booking.fields.email') }}</label>
                </div>
                @if($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
                <span class="help-block text-secondary small">{{ trans('cruds.booking.fields.email_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="description">{{ trans('cruds.booking.fields.description') }}</label>
                <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description"
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
</div>
