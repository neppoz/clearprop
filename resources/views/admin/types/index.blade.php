@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.type.title') }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.type.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            @can('type_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route("admin.types.create") }}">
                            <i class="fas fa-edit"></i>
                            {{ trans('global.new') }} {{ trans('cruds.type.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Type">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.type.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.type.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.type.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.type.fields.instructor') }}
                        </th>
                        <th>
                            {{ trans('cruds.type.fields.active') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($types as $key => $type)
                        <tr data-entry-id="{{ $type->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $type->id ?? '' }}
                            </td>
                            <td>
                                {{ $type->name ?? '' }}
                            </td>
                            <td>
                                {{ $type->description ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $type->instructor ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $type->instructor ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $type->active ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $type->active ? 'checked' : '' }}>
                            </td>
                            <td>
                                @can('type_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.types.show', $type->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('type_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.types.edit', $type->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('type_delete')
                                    <form action="{{ route('admin.types.destroy', $type->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('type_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.types.massDestroy') }}",
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
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Type:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
