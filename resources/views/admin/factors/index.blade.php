@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.factor.title') }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('app.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.factor.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            @can('factor_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route("admin.factors.create") }}">
                            <i class="fas fa-edit"></i>
                            {{ trans('global.new') }} {{ trans('cruds.factor.title_singular') }}
                        </a>
                    </div>
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Factor">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.factor.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.factor.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.factor.fields.description') }}
                        </th>
                        <th>
                            {{ trans('cruds.type.title') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($factors as $key => $factor)
                        <tr data-entry-id="{{ $factor->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $factor->id ?? '' }}
                            </td>
                            <td>
                                {{ $factor->name ?? '' }}
                            </td>
                            <td>
                                {{ $factor->description ?? '' }}
                            </td>
                            <td>
                                <ul>
                                @foreach($factor->factor_types as $item)
                                    <li>{{ $item->name }} (<strong>{{ number_format($item->pivot->rate, 2, ",", ".") }}</strong>{{' €/min. '}})</li>
                                @endforeach
                                </ul>
                            </td>
                            <td>
                                @can('factor_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.factors.show', $factor->id) }}">
                                        <i class="fas fa-search"></i>
                                    </a>
                                @endcan

                                @can('factor_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.factors.edit', $factor->id) }}">
                                        <i class="fas fa-edit"></i></a>
                                @endcan

                                @can('factor_delete')
                                    <form action="{{ route('admin.factors.destroy', $factor->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('factor_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.factors.massDestroy') }}",
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
  $('.datatable-Factor:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection
