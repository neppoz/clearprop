<div class="m-3">
    <div class="card">
        <div class="card-header">
        @can('activity_create')
            <div class="row">
                <div class="col-lg-12">
                    <a class="btn btn-success" href="{{ route("admin.activities.create") }}">
                        <i class="fas fa-edit"></i>
                        {{ trans('global.new') }}
                    </a>
                </div>
            </div>
        @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-instructorActivity">
                    <thead>
                        <tr>
                            <th>
                                <i class="fas fa-eye"></i>
                            </th>
                            <th data-priority="1">
                                {{ trans('cruds.activity.fields.event') }}
                            </th>
                            <th class="min-tablet-l">
                                {{ trans('cruds.activity.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.plane') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.minutes') }}
                            </th>
                            <th data-priority="2">
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
@if (auth()->user()->IsAdminRole())
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let dtDom = 'lBfrtip<"actions">'
@can('activity_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.activities.massDestroy') }}",
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
    ajax: "{{ route('admin.activities.getActivitiesByUserAsInstructor', $user_id) }}",
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
        { type: 'date', data: 'event', name: 'event' },
        { data: 'user_name', name: 'user.name' },
        { data: 'plane_callsign', name: 'plane.callsign' },
        { data: 'minutes', name: 'minutes' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
    pageLength: 25,
    createdRow: (row, data, dataIndex, cells) => {
        $(cells[0]).css('background-color', data.split_color)
        $(cells[5]).css('color', data.warmup_color)
    }
  };
  $('.datatable-instructorActivity').DataTable(dtOverrideGlobals);
    $('a[data-toggle="pill"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
