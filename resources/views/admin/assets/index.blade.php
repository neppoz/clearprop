@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.asset.title') }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('app.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.asset.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            @can('asset_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('admin.assets.create') }}">
                            <i class="fas fa-edit"></i>
                            {{ trans('global.create') }}
                        </a>
                    </div>
                </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Asset">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.asset.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.asset.fields.current_running_hours') }}
                        </th>
                        <th>
                            {{ trans('cruds.asset.fields.end_hours') }}
                        </th>
                        <th>
                            {{ trans('cruds.asset.fields.end_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.asset.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.asset.fields.plane') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($assets as $key => $asset)
                        <tr data-entry-id="{{ $asset->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $asset->name ?? '' }}
                            </td>
                            <td>
                                {{ $asset->current_running_hours ?? '' }}
                            </td>
                            <td>
                                {{ $asset->end_hours ?? '' }}
                            </td>
                            <td>
                                {{ $asset->end_date ?? '' }}
                            </td>
                            <td>
                                {{ $asset->status->name ?? '' }}
                            </td>
                            <td>
                                {{ $asset->plane->callsign ?? '' }}
                            </td>
                            <td>
                                @can('asset_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.assets.show', $asset->id) }}">
                                        <i class="fas fa-search"></i>
                                    </a>
                                @endcan

                                @can('asset_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.assets.edit', $asset->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('asset_delete')
                                    <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST"
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



@endsection
@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('asset_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.assets.massDestroy') }}",
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
            let table = $('.datatable-Asset:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
