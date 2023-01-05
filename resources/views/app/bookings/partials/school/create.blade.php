<div class="card-header">
    {{ trans('global.create') }} {{ trans('cruds.booking.title_singular') }} <span
        class="badge badge-secondary">{{$mode_name->name}}</span>
</div>
<div class="card-body">
    <form method="POST" action="{{ route("app.bookings.store") }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mode_id" id="mode_id" value="{{$mode_id}}" readonly>
        <div class="form-group">
            <label class="required" for="slot_id_select">{{ trans('cruds.slot.title_singular') }}</label>
            <select class="form-control select2 {{ $errors->has('slot') ? 'is-invalid' : '' }}" name="slot_id"
                    id="slot_id_select" required>
                @foreach($slots as $id => $slot)
                    <option
                        value="{{ $id }} {{ old('slot_id') == $id ? 'selected' : '' }}">{{ $slot }}</option>
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
                <span class="btn btn-info btn-xs select-all"
                      style="border-radius: 0">{{ trans('global.select_all') }}</span>
                <span class="btn btn-info btn-xs deselect-all"
                      style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
            </div>
            <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}" name="users[]"
                    id="users"
                    multiple>

                @foreach($users as $id => $user)
                    <option
                        value="{{ $id }}">{{ $user }}</option>
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
                        <input type="checkbox" name="checkin" id="checkin" value="1">
                    </span>
                        </div>
                        <input class="form-control {{ $errors->has('seats') ? 'is-invalid' : '' }}" type="number"
                               placeholder="{{trans('cruds.booking.fields.checkin_seats')}}" name="seats" id="seats"
                               value="" step="1" min="1">
                        @if($errors->has('checkin'))
                            <span class="text-danger">{{ $errors->first('checkin') }}</span>
                        @endif
                    </div>
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.checkin_helper') }}</span>
                </div>
                <div class="col-sm-4">
                    <label for="seats_available">{{ trans('cruds.booking.fields.seats_available') }}</label>
                    <input class="form-control {{ $errors->has('seats_available') ? 'is-invalid' : '' }}" type="number"
                           name="seats_available" id="seats_available"
                           value="{{ old('seats_available') }}" readonly>
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
                           value="{{ old('seats_taken') }}" readonly>
                    @if($errors->has('seats_taken'))
                        <span class="text-danger">{{ $errors->first('seats_taken') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.seats_taken_helper') }}</span>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label class="required" for="instructors">{{ trans('cruds.activity.fields.instructor') }}</label>
            <div style="padding-bottom: 4px">
                <span class="btn btn-info btn-xs select-all"
                      style="border-radius: 0">{{ trans('global.select_all') }}</span>
                <span class="btn btn-info btn-xs deselect-all"
                      style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
            </div>
            <select class="form-control select2 {{ $errors->has('instructors') ? 'is-invalid' : '' }}"
                    name="instructors[]"
                    id="instructors" multiple required>
                @foreach($instructors as $id => $instructor)
                    <option
                        value="{{ $id }}">{{ $instructor }}</option>
                @endforeach
            </select>
            @if($errors->has('instructors'))
                <span class="text-danger">{{ $errors->first('instructors') }}</span>
            @endif
            <span class="help-block text-secondary small">{{ trans('cruds.booking.fields.instructor_helper') }}</span>
        </div>
        @include('app.bookings.partials.formPlane')
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

