@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.activity.title') }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.activity.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            @can('activity_create')
                <div class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route("admin.activities.create") }}">
                            <i class="fas fa-edit"></i>
                            {{ trans('global.new') }} {{ trans('cruds.activity.title_singular') }}
                        </a>
                </div>
            </div>
        @endcan
    </div>

        <div class="card-body">
            <table class=" table row-border table-striped table-hover ajaxTable datatable datatable-Activity">
                <thead>
                <tr>
                    <th>
                        <i class="fas fa-eye"></i>
                    </th>
                    <th data-priority="1">
                        {{ trans('cruds.activity.fields.event') }}
                    </th>
                    <th class="min-tablet-l">
                        {{ trans('cruds.activity.fields.type') }}
                    </th>
                    @if (auth()->user()->is_admin OR auth()->user()->is_manager)
                        <th>
                            {{ trans('cruds.activity.fields.user') }}
                        </th>
                    @endif
                    <th>
                        {{ trans('cruds.activity.fields.plane') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.counter_start') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.counter_stop') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.minutes') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.amount') }}
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
        @if (auth()->user()->is_admin OR auth()->user()->is_manager)
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let dtDom = 'lBfrtip<"actions">'
@can('activity_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.activities.massDestroy') }}",
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
    ajax: "{{ route('admin.activities.index') }}",
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
        { data: 'type_name', name: 'type.name' },
            @if (auth()->user()->is_admin OR auth()->user()->is_manager)
            { data: 'user_name', name: 'user.name' },
        @endif
        { data: 'plane_callsign', name: 'plane.callsign' },
        { data: 'counter_start', name: 'counter_start' },
        { data: 'counter_stop', name: 'counter_stop' },
        { data: 'minutes', name: 'minutes' },
        { data: 'amount', name: 'amount' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ], [ 4, 'desc' ], [ 5, 'desc' ]],
    pageLength: 25,
    createdRow: (row, data, dataIndex, cells) => {
        $(cells[0]).css('background-color', data.split_color)
        $(cells[5]).css('color', data.warmup_color)
    }
  };
  $('.datatable-Activity').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});

</script>
@endsection
