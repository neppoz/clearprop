<div class="m-3">
    @can('activity_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route("admin.activities.create") }}">
                    {{ trans('global.add') }} {{ trans('cruds.activity.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.activity.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-instructorActivity">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.event') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.plane') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.type') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.minutes') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.amount') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($instructoractivities as $key => $activity)
                            <tr data-entry-id="{{ $activity->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $activity->event ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->plane->callsign ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->type->name ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->minutes ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->amount ?? '' }}
                                </td>
                                <td>
                                    @can('activity_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.activities.show', $activity->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('activity_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.activities.edit', $activity->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('activity_delete')
                                        <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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

$.fn.dataTable.moment(['MM.DD.YYYY']);

let dtOverrideGlobals = {
    buttons: dtButtons,
    processing: true,
    serverSide: false,
    retrieve: true,
    aaSorting: [],
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { type: 'date', data: 'event', name: 'event' },
        { data: 'plane_callsign', name: 'plane.callsign' },
        { data: 'type_name', name: 'type.name' },
        { data: 'minutes', name: 'minutes' },
        { data: 'amount', name: 'amount' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
    pageLength: 25,
    createdRow: (row, data, dataIndex, cells) => {
        $(cells[0]).css('background-color', data.split_color)
        $(cells[5]).css('color', data.warmup_color)
    }
  };
  $('.datatable-instructorActivity:not(.ajaxTable)').DataTable(dtOverrideGlobals)
    $('a[data-toggle="pill"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
