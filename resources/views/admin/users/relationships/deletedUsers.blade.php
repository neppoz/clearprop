<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-deleted_users">
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
                {{ trans('cruds.user.fields.created_at') }}
            </th>
            <th>
                {{ trans('cruds.user.fields.updated_at') }}
            </th>
            <th>
                {{ trans('cruds.user.fields.deleted_at') }}
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
                ajax: "{{ route('admin.users.getDeletedUsers') }}",
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
                    {data: 'placeholder', name: 'placeholder'},
                    {data: 'id', name: 'id'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {type: 'date', data: 'created_at', name: 'created_at'},
                    {type: 'date', data: 'updated_at', name: 'updated_at'},
                    {type: 'date', data: 'deleted_at', name: 'deleted_at'},
                ],
                order: [[1, 'desc']],
                pageLength: 25,
            };
            $('.datatable-Income').DataTable(dtOverrideGlobals);
            $('a[data-toggle="pill"]').on('shown.bs.tab', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });
        })

    </script>
@endsection
