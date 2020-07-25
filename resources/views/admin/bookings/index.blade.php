@extends('layouts.admin')
@section('content')
@can('booking_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route("admin.bookings.create") }}">
                {{ trans('global.add') }} {{ trans('cruds.booking.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.booking.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-Booking">
            <thead>
                <tr>

                    <th width="10">

                    </th>
                    @if (auth()->user()->getIsAdminAttribute())
                        <th>
                            {{ trans('cruds.booking.fields.user') }}
                        </th>
                    @endif
                    <th>
                        {{ trans('cruds.booking.fields.reservation_start') }}
                    </th>
                    <th>
                        {{ trans('cruds.booking.fields.plane') }}
                    </th>
                    <th>
                        {{ trans('cruds.booking.fields.reservation_stop') }}
                    </th>
                    <th>
                        {{ trans('cruds.booking.fields.description') }}
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
@if (auth()->user()->getIsAdminAttribute())
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
  let dtDom = 'lBfrtip<"actions">'
@can('booking_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bookings.massDestroy') }}",
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

@else
    let dtButtons = []
    let dtDom = 'Brtp'
@endif

let dtOverrideGlobals = {
    dom: dtDom,
    buttons: dtButtons,
    processing: true,
    serverSide: true,
    retrieve: true,
    aaSorting: [],
    ajax: "{{ route('admin.bookings.index') }}",
    columns: [
        { data: 'placeholder', name: 'placeholder' },
        @if (auth()->user()->getIsAdminAttribute())
            { data: 'user_name', name: 'user.name' },
        @endif
        { data: 'reservation_start', name: 'reservation_start' },
        { data: 'plane_callsign', name: 'plane.callsign' },
        { data: 'reservation_stop', name: 'reservation_stop' },
        { data: 'description', name: 'description' },
        { data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    order: [[ 1, 'desc' ]],
    pageLength: 50,
  };
  $('.datatable-Booking').DataTable(dtOverrideGlobals);
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
});

</script>
@endsection
