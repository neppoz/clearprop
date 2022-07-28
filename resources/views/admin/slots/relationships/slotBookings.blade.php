<div class="m-3">
    @can('booking_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.bookings.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.booking.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.booking.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-slotBookings">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.reservation_start') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.reservation_stop') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.modus') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.instructor_needed') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.user.fields.email') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.plane') }}
                        </th>
                        <th>
                            {{ trans('cruds.booking.fields.slot') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($bookings as $key => $booking)
                        <tr data-entry-id="{{ $booking->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $booking->id ?? '' }}
                            </td>
                            <td>
                                {{ $booking->reservation_start ?? '' }}
                            </td>
                            <td>
                                {{ $booking->reservation_stop ?? '' }}
                            </td>
                            <td>
                                {{ $booking->description ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Booking::MODUS_SELECT[$booking->modus] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Booking::STATUS_SELECT[$booking->status] ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Booking::INSTRUCTOR_NEEDED_RADIO[$booking->instructor_needed] ?? '' }}
                            </td>
                            <td>
                                {{ $booking->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $booking->user->email ?? '' }}
                            </td>
                            <td>
                                {{ $booking->plane->callsign ?? '' }}
                            </td>
                            <td>
                                {{ $booking->slot->title ?? '' }}
                            </td>
                            <td>
                                @can('booking_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.bookings.show', $booking->id) }}">
                                        <i class="fas fa-search"></i>
                                    </a>
                                @endcan

                                @can('booking_edit')
                                    <a class="btn btn-xs btn-info"
                                       href="{{ route('admin.bookings.edit', $booking->id) }}">
                                        <i class="fas fa-edit"></i></a>
                                @endcan

                                @can('booking_delete')
                                    <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST"
                                          onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                          style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-xs btn-danger"><i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('booking_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.bookings.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
                        return $(entry).data('entry-id')
                    });

                    if (ids.length === 0) {
                        alert('{{ trans('global.datatables.zero_selected') }}')

                        return
                    }

                    if (confirm('{{ trans('global.areYouSure') }}')) {
                        $.ajax({
                            headers: {'x-csrf-token': _token},
                            method: 'POST',
                            url: config.url,
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[2, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-slotBookings:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
