<div class="table-responsive">
    <table class=" table table-bordered table-striped table-hover datatable datatable-Income">
        <thead>
        <tr>
            <th>
                <i class="fas fa-eye"></i>
            </th>
            <th data-priority="1">
                {{ trans('cruds.income.fields.entry_date') }}
            </th>
            <th>
                {{ trans('cruds.income.fields.income_category') }}
            </th>
            <th>
                {{ trans('cruds.income.fields.amount') }}
            </th>
            <th>
                {{ trans('cruds.income.fields.description') }}
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
                ajax: "{{ route('admin.incomes.getIncomesByUser', $user_id) }}",
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
                    {type: 'date', data: 'entry_date', name: 'entry_date'},
                    {data: 'income_category_name', name: 'income_category.name'},
                    {data: 'amount', name: 'amount'},
                    {data: 'description', name: 'description'},
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
