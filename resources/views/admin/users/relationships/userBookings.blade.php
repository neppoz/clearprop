<div class="m-3">
    @can('booking_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.bookings.create") }}">
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
                <table class=" table table-bordered table-striped table-hover datatable datatable-Booking">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.booking.fields.reservation_start') }}
                            </th>
                            <th>
                                {{ trans('cruds.booking.fields.plane') }}
                            </th>
                            <th>
                                {{ trans('cruds.booking.fields.reservation_stop') }}
                            </th>
                            <th>
                                {{ trans('cruds.booking.fields.description') }}
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
                                    {{ $booking->reservation_start ?? '' }}
                                </td>
                                <td>
                                    {{ $booking->plane->callsign ?? '' }}
                                </td>
                                <td>
                                    {{ $booking->reservation_stop ?? '' }}
                                </td>
                                <td>
                                    {{ $booking->description ?? '' }}
                                </td>
                                <td>
                                    @can('booking_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.bookings.show', $booking->id) }}">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    @endcan

                                    @can('booking_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.bookings.edit', $booking->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('booking_delete')
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <button type="submit" class="btn btn-xs btn-danger"><i
                                                    class="fas fa-trash"></i></button>
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
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: false,
    retrieve: true,
    aaSorting: [],
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { type: 'date', data: 'reservation_start', name: 'reservation_start' },
        { data: 'plane_callsign', name: 'plane.callsign' },
        { type: 'date', data: 'reservation_stop', name: 'reservation_stop' },
        { data: 'description', name: 'description' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  $('.datatable-Booking:not(.ajaxTable)').DataTable(dtOverrideGlobals);
    $('a[data-toggle="pill"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
