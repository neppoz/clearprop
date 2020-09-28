@extends('layouts.pilot')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h4 class="m-0 text-dark">{{ trans('cruds.activity.title') }}</h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('pilot.welcome')}}">Home</a></li>
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
            <table class=" table row-column ajaxTable datatable datatable-Activity">
                <thead>
                <tr>
                    <th width="10">
                        <i class="fas fa-eye"></i>
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.minutes') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.plane') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.counter_start') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.counter_stop') }}
                    </th>
                </tr>
                </thead>
            </table>
        </div>
    </div>



@endsection
@section('scripts')
    @parent
    <script src="https://cdn.datatables.net/v/bs4/rg-1.1.2/datatables.min.js"></script>
    <script>
        $(function () {
            @can('activity_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.activities.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).data(), function (entry) {
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

            let dtButtons = []
            let dtDom = 'Brtp'

            let dtOverrideGlobals = {
                dom: dtDom,
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('pilot.activities.index') }}",
                responsive: {
                    details: {
                        renderer: function (api, rowIdx, columns) {
                            var data = $.map(columns, function (col, i) {
                                return col.hidden ?
                                    '<tr data-dt-row="' + col.rowIndex + '" data-dt-column="' + col.columnIndex + '">' +
                                    '<td class="font-weight-bold">' + col.title + ':' + '</td> ' +
                                    '<td>' + col.data + '</td>' +
                                    '</tr>' :
                                    '';
                            }).join('');

                            return data ?
                                $('<table/>').append(data) :
                                false;
                        }
                    }
                },
                columns: [
                    {
                        "orderable": false,
                        'searchable': false,
                        "data": 'placeholder',
                        "defaultContent": '',
                    },
                    {data: 'type_name', name: 'type.name'},
                    {data: 'minutes', name: 'minutes'},
                    {data: 'plane_callsign', name: 'plane.callsign'},
                    {
                        data: 'amount', name: 'amount',
                        render: data => {
                            return data + ' &euro;';
                        },
                    },
                    {data: 'counter_start', name: 'counter_start'},
                    {data: 'counter_stop', name: 'counter_stop'}
                ],
                order: [],
                rowGroup: {
                    dataSrc: 'event_date_iso',
                },
                pageLength: 25,
                createdRow: (row, data, dataIndex, cells) => {
                    $(cells[0]).css('background-color', data.split_color)
                    $(cells[1]).css('color', data.warmup_color)
                }
            };
            $('.datatable-Activity').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        });
    </script>
@endsection
