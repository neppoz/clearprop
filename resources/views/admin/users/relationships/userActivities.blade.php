<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-Activity">
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
        </tr>
        </thead>
    </table>
</div>

@section('scripts')
    @parent
    <script>
        $(function () {
            let dtOverrideGlobals = {
                dom: 'tp',
                buttons: [],
                processing: true,
                serverSide: false,
                retrieve: true,
                aaSorting: [],
                ajax: "{{ route('app.activities.getActivitiesByUser', $user_id) }}",
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
                        "data": null,
                        "defaultContent": '',
                    },
                    {type: 'date', data: 'event', name: 'event'},
                    {data: 'type_name', name: 'type.name'},
                    {data: 'plane_callsign', name: 'plane.callsign'},
                    {data: 'counter_start', name: 'counter_start'},
                    {data: 'counter_stop', name: 'counter_stop'},
                    {data: 'minutes', name: 'minutes'},
                    {data: 'amount', name: 'amount'},
                ],
                order: [[1, 'desc'], [4, 'desc'], [5, 'desc']],
                pageLength: 25,
                createdRow: (row, data, dataIndex, cells) => {
                    $(cells[0]).css('background-color', data.split_color)
                    $(cells[5]).css('color', data.warmup_color)
                }
            };
            $('.datatable-Activity').DataTable(dtOverrideGlobals);
            $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })
    </script>
@endsection
