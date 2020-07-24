@extends('layouts.admin')
@section('content')
@can('income_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.incomes.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.income.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.income.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Income">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.income.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.income.fields.entry_date') }}
                    </th>
                    <th>
                        {{ trans('cruds.income.fields.user') }}
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
                    <th>
                        &nbsp;
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('income_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.incomes.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
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
    ajax: "{{ route('admin.incomes.index') }}",
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        { data: 'id', name: 'id' },
        { data: 'entry_date', name: 'entry_date' },
        { data: 'user_name', name: 'user.name' },
        { data: 'income_category_name', name: 'income_category.name' },
        { data: 'amount', name: 'amount' },
        { data: 'description', name: 'description' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  $('.datatable-Income').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});

</script>
@endsection
