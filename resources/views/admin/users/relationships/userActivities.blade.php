<div class="m-3">
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
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Activity">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.user') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.copilot') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.instructor') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.plane') }}
                            </th>
                            <th>
                                {{ trans('cruds.plane.fields.model') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.type') }}
                            </th>
                            <th>
                                {{ trans('cruds.type.fields.active') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.event') }}
                            </th>
                            <th>
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
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.warmup_minutes') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.counter_start') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.counter_stop') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.rate') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.minutes') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.amount') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.departure') }}
                            </th>
                            <th>
                                {{ trans('cruds.activity.fields.arrival') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activities as $key => $activity)
                            <tr data-entry-id="{{ $activity->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $activity->id ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->user->name ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->copilot->name ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->instructor->name ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->plane->callsign ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->plane->model ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->type->name ?? '' }}
                                </td>
                                <td>
                                    <span style="display:none">{{ $activity->type->active ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $activity->type->active ? 'checked' : '' }}>
                                </td>
                                <td>
                                    {{ $activity->event ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->event_start ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->event_stop ?? '' }}
                                </td>
                                <td>
                                    <span style="display:none">{{ $activity->engine_warmup ?? '' }}</span>
                                    <input type="checkbox" disabled="disabled" {{ $activity->engine_warmup ? 'checked' : '' }}>
                                </td>
                                <td>
                                    {{ $activity->warmup_start ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->warmup_minutes ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->counter_start ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->counter_stop ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->rate ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->minutes ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->amount ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->departure ?? '' }}
                                </td>
                                <td>
                                    {{ $activity->arrival ?? '' }}
                                </td>
                                <td>
                                    @can('activity_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.activities.show', $activity->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('activity_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.activities.edit', $activity->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('activity_delete')
                                        <form action="{{ route('admin.activities.destroy', $activity->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
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
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('activity_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.activities.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
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
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  $('.datatable-Activity:not(.ajaxTable)').DataTable({ buttons: dtButtons })
    $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
        $($.fn.dataTable.tables(true)).DataTable()
            .columns.adjust();
    });
})

</script>
@endsection