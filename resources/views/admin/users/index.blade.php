@extends('layouts.admin')
@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h2 class="m-0">{{ trans('cruds.user.title') }}</h2>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('app.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.user.title') }}</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
                        <li class="nav-item">
                            <a class="nav-link active show" href="#active_users" role="tab" aria-controls="active_users"
                               data-toggle="pill"
                               aria-selected="true">
                                Active
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#deleted_users" role="tab" aria-controls="deleted_users"
                               data-toggle="pill" aria-selected="false">
                                Inactive
                            </a>
                        </li>
                    </ul>
                    <div class="row p-4">
                        <div class="col">
                            @can('user_create')
                                <div style="margin-bottom: 10px;" class="row">
                                    <div class="col-lg-12">
                                        <a class="btn btn-success" href="{{ route('admin.users.create') }}">
                                            <i class="fas fa-edit"></i>
                                            {{ trans('global.new') }} {{ trans('cruds.user.title_singular') }}
                                        </a>
                                    </div>
                                </div>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" role="tabpanel" id="active_users"
                             aria-labelledby="active_users">
                            <div class="table-responsive">
                                <table class=" table table-bordered table-striped table-hover datatable datatable-active_users">
                                    <thead>
                                    <tr>
                                        <th width="10">

                                        </th>
                                        <th>
                                            {{ trans('cruds.user.fields.id') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.user.fields.name') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.user.fields.email') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.user.fields.lang') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.user.fields.factor') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.user.fields.plane') }}
                                        </th>
                                        <th>
                                            {{ trans('cruds.user.fields.roles') }}
                                        </th>
                                        <th>
                                            &nbsp;
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $key => $user)
                                        <tr data-entry-id="{{ $user->id }}">
                                            <td>

                                            </td>
                                            <td>
                                                {{ $user->id ?? '' }}
                                            </td>
                                            <td>
                                                {{ $user->name ?? '' }}
                                            </td>
                                            <td>
                                                {{ $user->email ?? '' }}
                                            </td>
                                            <td>
                                                {{ App\User::LANG_SELECT[$user->lang] ?? '' }}
                                            </td>
                                            <td>
                                                {{ $user->factor->name ?? '' }}
                                            </td>
                                            <td>
                                                @foreach($user->planes as $key => $item)
                                                    <span class="badge badge-info">{{ $item->callsign }}</span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @foreach($user->roles as $key => $roles)
                                                    {{ $roles->title }}
                                                @endforeach
                                            </td>
                                            <td>
                                                @can('user_show')
                                                    <a class="btn btn-xs btn-primary"
                                                       href="{{ route('admin.users.show', $user->id) }}">
                                                        <i class="fas fa-search"></i>
                                                    </a>
                                                @endcan

                                                @can('user_edit')
                                                    <a class="btn btn-xs btn-info"
                                                       href="{{ route('admin.users.edit', $user->id) }}">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan

                                                @can('user_delete')
                                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                                          style="display: inline-block;">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" class="btn btn-xs btn-danger"><i
                                                                    class="fas fa-trash"></i>
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
                        <div class="tab-pane" role="tabpanel" id="deleted_users" aria-labelledby="deleted_users">
                            @includeIf('admin.users.relationships.deletedUsers')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('user_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.users.massDestroy') }}",
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
                order: [[1, 'desc']],
                pageLength: 100,
            });
            let table = $('.datatable-User:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
@endsection
