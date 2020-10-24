@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.planning.title') }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.planning.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            @can('booking_create')
                <a class="btn btn-success"
                   href="{{ route('admin.bookings.create') }}">
                    <i class="fas fa-edit"></i> {{ trans('global.new') }} {{ trans('cruds.booking.title_singular') }}
                </a>
            @endcan
        </div>

        <div class="card-body">
            <table class=" table row-column ajaxTable datatable datatable-Booking">
                <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th width="10">

                    </th>
                    <th>

                    </th>
                    <th>
                        {{ trans('cruds.booking.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.user.fields.instructor') }}
                    </th>
                    <th>
                        {{ trans('cruds.booking.fields.plane') }}
                    </th>
                    <th>
                        {{ trans('cruds.booking.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.booking.fields.mode') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td width="10">
                    </td>
                    <td width="10">
                    </td>
                    <td>
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($users as $key => $item)
                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    </td>
                    <td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($planes as $key => $item)
                                <option value="{{ $item->callsign }}">{{ $item->callsign }}</option>
                            @endforeach
                        </select>

                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
                    <td>
                    </td>
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
            let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
            @can('booking_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.bookings.massDestroy') }}",
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

            let dtOverrideGlobals = {
                buttons: dtButtons,
                processing: true,
                serverSide: true,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('admin.bookings.index') }}",
                columns: [
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'reservation_start_time', name: 'reservation_start_time'},
                    {data: 'reservation_stop_time', name: 'reservation_stop_time'},
                    {data: 'user', name: 'user.name'},
                    {data: 'instructor', name: 'instructor.name'},
                    {data: 'plane_callsign', name: 'plane.callsign'},
                    {
                        data: 'status',
                        name: 'status',
                        render: data => {
                            if (data === 'pending') {
                                return '<span class="badge badge-warning">' + data + '</span>';
                            }
                            if (data === 'confirmed') {
                                return '<span class="badge badge-success">' + data + '</span>';
                            }
                            return data;
                        },
                    },
                    {data: 'mode_name', name: 'mode.name'},
                    {data: 'actions', name: '{{ trans('global.actions') }}'}
                ],
                orderCellsTop: true,
                order: [[1, 'asc']],
                rowGroup: {
                    dataSrc: 'reservation_start_date_iso',
                },
                pageLength: 25,
            };
            let table = $('.datatable-Booking').DataTable(dtOverrideGlobals);
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
            $('.datatable thead').on('input', '.search', function () {
                let strict = $(this).attr('strict') || false
                let value = strict && this.value ? "^" + this.value + "$" : this.value
                console.log(value);
                table
                    .column($(this).parent().index())
                    .search(value, strict)
                    .draw()
            });
        });

    </script>
@endsection
