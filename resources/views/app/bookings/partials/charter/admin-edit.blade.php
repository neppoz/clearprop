<div class="card-header">
    <div class="row">
        <div class="col-6">
            {{ trans('cruds.booking.title_singular') }} <span
                class="badge badge-secondary">{{$mode_name->name}}-Admin</span>
        </div>
        <div class="col-6">
            <div class="float-right">
                @can('booking_charter_admin_edit')
                    <form action="{{ route('app.bookings.destroy', $booking->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button type="submit" class="btn btn-outline-danger" id="show_confirm" data-toggle="tooltip"
                                title="{{ trans('global.delete_reservation') }}">
                            {{ trans('global.delete_reservation') }}</button>
                    </form>
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
            <form method="POST" action="{{ route("app.bookings.update", $booking->id) }}" enctype="multipart/form-data">
                @method('PUT')
                @csrf
                <div class="form-group">
                    <label class="required" for="users">{{ trans('cruds.booking.fields.user') }}</label>
                    <div style="padding-bottom: 4px">
                <span class="btn btn-info btn-xs select-all"
                      style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('users') ? 'is-invalid' : '' }}" name="users[]"
                            id="users"
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
                <span class="btn btn-info btn-xs select-all"
                      style="border-radius: 0">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all"
                              style="border-radius: 0">{{ trans('global.deselect_all') }}</span>
                    </div>
                    <select class="form-control select2 {{ $errors->has('instructors') ? 'is-invalid' : '' }}"
                            name="instructors[]"
                            id="instructors" multiple>
                        @foreach($instructors as $id => $instructor)
                            <option
                                value="{{ $id }}" {{ (in_array($id, old('instructors', [])) || $booking->bookingInstructors->contains($id)) ? 'selected' : '' }}>{{ $instructor }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('instructors'))
                        <span class="text-danger">{{ $errors->first('instructors') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.instructor_helper') }}</span>
                </div>
                <div class="form-group">
                    <label class="required">{{ trans('cruds.booking.fields.status') }}</label>
                    @foreach(App\Booking::STATUS_RADIO as $key => $label)
                        <div
                            class="form-check  form-check-inline icheck-primary {{ $errors->has('status') ? 'is-invalid' : '' }}">
                            <input class="form-check-input" type="radio" id="status_{{ $key }}" name="status"
                                   value="{{ $key }}"
                                   {{ old('status', $booking->status) === (string) $key ? 'checked' : '' }} required>
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
                    <div class="icheck-primary">
                        <input type="checkbox" name="email" id="email"
                               value="1" {{ old('email', 0) == 1 ? 'checked' : '' }}>
                        <label for="email">{{ trans('cruds.booking.fields.email') }}</label>
                    </div>
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.email_helper') }}</span>
                </div>
                <div class="form-group">
                    <label for="description">{{ trans('cruds.booking.fields.description') }}</label>
                    <textarea class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
                              name="description"
                              id="description">{{ old('description', $booking->description) }}</textarea>
                    @if($errors->has('description'))
                        <span class="text-danger">{{ $errors->first('description') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.description_helper') }}</span>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" type="submit">
                        <i class="fas fa-edit"></i>
                        {{ trans('global.update') }} {{ strtolower(trans('cruds.booking.title_singular')) }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

            $('#show_confirm').click(function (event) {
                var form = $(this).closest("form");
                var name = $(this).data("name");
                event.preventDefault();
                Swal.fire({
                    title: '{{ trans('global.areYouSure') }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: '{{ trans('global.yesDelete') }}'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                })
            });
        });
    </script>
@endsection
