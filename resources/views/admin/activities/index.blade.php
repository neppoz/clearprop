@extends('layouts.admin')
@section('content')
@can('activity_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.activities.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.activity.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.activity.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Activity">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.event') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.type') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.user') }}
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
                        {{ trans('cruds.activity.fields.warmup_minutes') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.minutes') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.amount') }}
                    </th>
                    {{-- <th>
                        {{ trans('cruds.activity.fields.copilot') }}
                    </th> --}}
                    {{-- <th>
                        {{ trans('cruds.activity.fields.instructor') }}
                    </th> --}}

                    {{-- <th>
                        {{ trans('cruds.plane.fields.model') }}
                    </th> --}}

                    {{-- <th>
                        {{ trans('cruds.type.fields.active') }}
                    </th> --}}
                    {{-- <th>
                        {{ trans('cruds.activity.fields.event_start') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.event_stop') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.engine_warmup') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.warmup_start') }}
                    </th> --}}
                    {{-- <th>
                        {{ trans('cruds.activity.fields.rate') }}
                    </th> --}}
                    {{-- <th>
                        {{ trans('cruds.activity.fields.departure') }}
                    </th>
                    <th>
                        {{ trans('cruds.activity.fields.arrival') }}
                    </th> --}}
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
@can('activity_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.activities.massDestroy') }}",
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
    ajax: "{{ route('admin.activities.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'event', name: 'event' },
{ data: 'type_name', name: 'type.name' },
{ data: 'user_name', name: 'user.name' },
{ data: 'plane_callsign', name: 'plane.callsign' },
{ data: 'counter_start', name: 'counter_start' },
{ data: 'counter_stop', name: 'counter_stop' },
{ data: 'warmup_minutes', name: 'warmup_minutes' },
{ data: 'minutes', name: 'minutes' },
{ data: 'amount', name: 'amount' },

// { data: 'copilot_name', name: 'copilot.name' },
// { data: 'instructor_name', name: 'instructor.name' },
// { data: 'plane.model', name: 'plane.model' },
// { data: 'type.active', name: 'type.active' },
// { data: 'event_start', name: 'event_start' },
// { data: 'event_stop', name: 'event_stop' },
// { data: 'engine_warmup', name: 'engine_warmup' },
// { data: 'warmup_start', name: 'warmup_start' },
// { data: 'rate', name: 'rate' },
// { data: 'departure', name: 'departure' },
// { data: 'arrival', name: 'arrival' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  $('.datatable-Activity').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});

</script>
@endsection
