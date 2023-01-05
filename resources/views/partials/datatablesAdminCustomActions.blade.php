@can($undeleteGate)
    <form action="{{ route('admin.' . $crudRoutePart . '.undelete', $row->id) }}" method="POST"
          onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
        <input type="hidden" name="_method" value="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="btn btn-xs btn-info">{{trans('global.datatables.undelete')}}</button>
    </form>
@endcan
