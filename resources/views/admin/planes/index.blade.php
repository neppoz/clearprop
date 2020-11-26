@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.plane.title') }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.plane.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            @can('plane_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('admin.planes.create') }}">
                            <i class="fas fa-edit"></i>
                            {{ trans('global.create') }}
                        </a>
                    </div>
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Plane">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.plane.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.plane.fields.callsign') }}
                        </th>
                        <th>
                            {{ trans('cruds.plane.fields.model') }}
                        </th>
                        <th>
                            {{ trans('cruds.plane.fields.counter_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.plane.fields.warmup_type') }}
                        </th>
                        <th>
                            {{ trans('cruds.plane.fields.active') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($planes as $key => $plane)
                        <tr data-entry-id="{{ $plane->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $plane->id ?? '' }}
                            </td>
                            <td>
                                {{ $plane->callsign ?? '' }}
                            </td>
                            <td>
                                {{ $plane->model ?? '' }}
                            </td>
                            <td>
                                {{ App\Plane::COUNTER_TYPE_SELECT[$plane->counter_type] ?? '' }}
                            </td>
                            <td>
                                {{ App\Plane::WARMUP_TYPE_RADIO[$plane->warmup_type] ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $plane->active ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $plane->active ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('plane_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.planes.show', $plane->id) }}">
                                        <i class="fas fa-search"></i>
                                    </a>
                                @endcan

                                @can('plane_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.planes.edit', $plane->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('plane_delete')
                                    <form action="{{ route('admin.planes.destroy', $plane->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('plane_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.planes.massDestroy') }}",
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Plane:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
