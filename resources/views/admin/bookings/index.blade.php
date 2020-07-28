@extends('layouts.admin')
@section('content')
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
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Booking">
            <thead>
                <tr>

                    <th>
                        <i class="fas fa-eye"></i>
                    </th>
                    <th data-priority="1">
                        {{ trans('cruds.booking.fields.reservation_start') }}
                    </th>
                    @if (auth()->user()->getIsAdminAttribute())
                        <th>
                            {{ trans('cruds.booking.fields.user') }}
                        </th>
                    @endif
                    <th>
                        {{ trans('cruds.booking.fields.plane') }}
                    </th>
                    <th>
                        {{ trans('cruds.booking.fields.reservation_stop') }}
                    </th>
                    <th class="min-tablet-l">
                        {{ trans('cruds.booking.fields.description') }}
                    </th>
                    <th data-priority="2">
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
@if (auth()->user()->getIsAdminAttribute())
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let dtDom = 'lBfrtip<"actions">'
@can('booking_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bookings.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
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

@else
    let dtButtons = []
    let dtDom = 'Brtp'
@endif

let dtOverrideGlobals = {
    dom: dtDom,
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.bookings.index') }}",
    responsive: {
        details: {
            renderer: function ( api, rowIdx, columns ) {
                var data = $.map( columns, function ( col, i ) {
                    return col.hidden ?
                        '<tr data-dt-row="'+col.rowIndex+'" data-dt-column="'+col.columnIndex+'">'+
                            '<td class="font-weight-bold">'+col.title+':'+'</td> '+
                            '<td>'+col.data+'</td>'+
                        '</tr>' :
                        '';
                } ).join('');

                return data ?
                    $('<table/>').append( data ) :
                    false;
            }
        }
    },
    columns: [
        {
            "orderable":      false,
            'searchable':     false,
            "data":           null,
            "defaultContent": '',
        },
        { data: 'reservation_start', name: 'reservation_start' },
        @if (auth()->user()->getIsAdminAttribute())
            { data: 'user_name', name: 'user.name' },
        @endif
        { data: 'plane_callsign', name: 'plane.callsign' },
        { data: 'reservation_stop', name: 'reservation_stop' },
        { data: 'description', name: 'description' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
    pageLength: 25,
  };
  $('.datatable-Booking').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});

</script>
@endsection
