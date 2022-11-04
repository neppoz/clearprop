<div class="card-header">
    <div class="row">
        <div class="col-6">
            {{ trans('cruds.booking.title_singular') }}
        </div>
        <div class="col-6">
            <div class="float-right">
                @can('booking_delete')
                    @if(($booking->created_by_id == auth()->user()->id) && ($booking->bookingUsers->count() == 1))
                        <form action="{{ route('app.bookings.destroy', $booking->id) }}" method="POST"
                              onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                            <input type="hidden" name="_method" value="DELETE">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-outline-danger"
                                   value="{{ trans('global.delete_reservation') }}">
                        </form>
                    @else
                        <form action="{{ route('app.bookings.revoke', $booking->id) }}" method="POST"
                              onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                            <input type="hidden" name="_method" value="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="submit" class="btn btn-outline-danger"
                                   value="{{ trans('global.revoke_reservation') }}">
                        </form>
                    @endif
                @endcan
            </div>
        </div>
    </div>
</div>
<div class="card-body">
    <div class="row">
        <div class="col">
            <table class="table table-bordered table-striped">
                <tbody>
                <tr>
                    <th>
                        {{ trans('cruds.booking.fields.user') }}
                    </th>
                    <td>
                        @foreach($booking->bookingUsers as $bookingUsers)
                            <span>{{ $bookingUsers->name ?? '' }}</span><br>
                        @endforeach
                    </td>
                </tr>
                <tr style="{{ $booking->instructor_needed === 1 ? '' : 'display:none' }}">
                    <th>
                        {{ trans('cruds.booking.fields.instructor_needed') }}
                    </th>
                    <td>
                        <span class="fa fa-check-circle text-dark"></span>
                    </td>
                </tr>
                <tr style="{{ $booking->bookingInstructors->count() ? '' : 'display:none' }}">
                    <th>
                        {{ trans('cruds.booking.fields.instructor') }}
                    </th>
                    <td>
                        @foreach($booking->bookingInstructors as $bookingInstructor)
                            <span>{{ $bookingInstructor->name ?? '' }}</span><br>
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.booking.fields.plane') }}
                    </th>
                    <td>
                        {{ $booking->plane->callsign ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.booking.fields.reservation_start') }}
                    </th>
                    <td>
                        {{ $booking->reservation_start ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.booking.fields.reservation_stop') }}
                    </th>
                    <td>
                        {{ $booking->reservation_stop ?? '' }}
                    </td>
                </tr>
                <tr>
                    <th>
                        {{ trans('cruds.booking.fields.status') }}
                    </th>
                    <td>
                        <i class="fa fa-lg fa-{{ $booking->status === 0 ? 'question-circle text-warning' : 'check-circle text-success'}}"></i>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form method="POST" action="{{ route("app.bookings.update", $booking->id) }}"
                  enctype="multipart/form-data">
                @method('PUT')
                @csrf
                @includeWhen($booking->mode_id === 1, 'app.bookings.partials.charter.edit')
                @includeWhen($booking->mode_id === 2, 'app.bookings.partials.school.edit')
                @includeWhen($booking->mode_id === 3, 'app.bookings.partials.promotion.edit')
                @includeWhen($booking->mode_id === 4, 'app.bookings.partials.maintenance.edit')
            </form>
        </div>
    </div>
</div>


<input type="hidden" name="plane_id" id="plane_id" value="{{ old('plane_id', $booking->plane_id) }}" readonly>
<div class="form-group">
    <label class="required" for="slot_id_select">{{ trans('cruds.slot.title_singular') }}</label>
    <select class="form-control select2 {{ $errors->has('slot') ? 'is-invalid' : '' }}" name="slot_id"
            id="slot_id_select" required>
        @foreach($slots as $id => $slot)
            <option
                value="{{ $id }}" {{ (old('slot_id') ? old('slot_id') : $booking->slot->id ?? '') == $id ? 'selected' : '' }}>{{ $slot }}</option>
        @endforeach
    </select>
    @if($errors->has('slot'))
        <span class="text-danger">{{ $errors->first('slot') }}</span>
    @endif
    <span
        class="help-block text-secondary small">{{ trans('cruds.slot.fields.title_helper') }}</span>
</div>
<div class="form-group">
    <label for="users">{{ trans('cruds.booking.fields.school_user') }}</label>
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
    <span class="help-block text-secondary small">{{ trans('cruds.booking.fields.school_user_helper') }}</span>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-sm-4">
            <label for="checkin">{{ trans('cruds.booking.fields.checkin') }}</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        <input type="hidden" name="checkin" value="0">
                        <input type="checkbox" name="checkin" id="checkin" value="1" {{ $booking->checkin || old('checkin', 0) === 1 ? 'checked' : '' }}>
                    </span>
                </div>
                <input class="form-control {{ $errors->has('seats') ? 'is-invalid' : '' }}" type="number"
                       placeholder="{{trans('cruds.booking.fields.checkin_seats')}}" name="seats" id="seats"
                       value="{{ old('seats', $booking->seats) }}" step="1" min="1">
                @if($errors->has('checkin'))
                    <span class="text-danger">{{ $errors->first('checkin') }}</span>
                @endif
            </div>
            <span class="help-block text-secondary small">{{ trans('cruds.booking.fields.checkin_helper') }}</span>
        </div>
        <div class="col-sm-4">
            <label for="seats_available">{{ trans('cruds.booking.fields.seats_available') }}</label>
            <input class="form-control {{ $errors->has('seats_available') ? 'is-invalid' : '' }}" type="number"
                   name="seats_available" id="seats_available"
                   value="{{ old('seats_available', $booking->seats_available) }}" readonly>
            @if($errors->has('seats_available'))
                <span class="text-danger">{{ $errors->first('seats_available') }}</span>
            @endif
            <span
                class="help-block text-secondary small">{{ trans('cruds.booking.fields.seats_available_helper') }}</span>
        </div>
        <div class="col-sm-4">
            <label for="seats_taken">{{ trans('cruds.booking.fields.seats_taken') }}</label>

            <input class="form-control {{ $errors->has('seats_taken') ? 'is-invalid' : '' }}" type="number"
                   name="seats_taken" id="seats_taken"
                   value="{{ old('seats_taken', $booking->seats_taken) }}" readonly>
            @if($errors->has('seats_taken'))
                <span class="text-danger">{{ $errors->first('seats_taken') }}</span>
            @endif
            <span class="help-block text-secondary small">{{ trans('cruds.booking.fields.seats_taken_helper') }}</span>
        </div>
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
        <div class="form-check form-check-inline icheck-primary {{ $errors->has('status') ? 'is-invalid' : '' }}">
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
            let count;
            let count_available;
            let seats = $("#seats");
            let seats_taken = $("#seats_taken");
            let seats_available = $("#seats_available");

            $("#users").change(function () {
                count = $("#users :selected").length;
                if (count > seats.val()) {
                    seats.prop({"min": count});
                    seats.val(count);
                }

                seats_taken.val(count);
                count_available = seats.val() - seats_taken.val();
                seats_available.val(count_available);
            });

            $("#checkin").change(function () {
                if ($(this).is(":checked")) {
                    count = $("#users :selected").length;
                    seats.prop({"min": count});
                    seats.val(count);

                    seats_taken.val(count);
                    count_available = seats.val() - seats_taken.val();
                    seats_available.val(count_available);
                }
            });

            seats.change(function () {
                seats_taken.val(count);
                count_available = seats.val() - seats_taken.val();
                seats_available.val(count_available);
            });

        });
    </script>
@endsection
