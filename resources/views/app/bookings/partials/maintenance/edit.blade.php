<div class="card-header">
    <div class="row">
        <div class="col-6">
            {{ trans('cruds.booking.title_singular') }} <span
                class="badge badge-danger">{{$mode_name->name}}</span>
        </div>
        <div class="col-6">
            <div class="float-right">
                @can('booking_maintenance_edit')
                    <form action="{{ route('app.bookings.destroy', $booking->id) }}" method="POST"
                          onsubmit="return confirm('{{ trans('global.areYouSure') }}');">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="submit" class="btn btn-outline-danger"
                               value="{{ trans('global.delete_reservation') }}">
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
                <input type="hidden" name="plane_id" id="plane_id" value="{{ old('plane_id', $booking->plane_id) }}"
                       readonly>
                <input type="hidden" name="status" id="status" value="{{ old('status', $booking->status) }}" readonly>
                <div class="form-group">
                    <label for="users">{{ trans('cruds.booking.fields.assignee') }}</label>
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
                                value="{{ $id }}" {{ (in_array($id, old('bookingUsers', [])) || $booking->bookingUsers->contains($id)) ? 'selected' : '' }}>{{ $user }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                        <span class="text-danger">{{ $errors->first('user') }}</span>
                    @endif
                    <span
                        class="help-block text-secondary small">{{ trans('cruds.booking.fields.assignee_helper') }}</span>
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

@endsection
