@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col">
        <h3 class="page-title">{{ trans('cruds.activityReport.title') }}</h3>

        <form method="get">
            <div class="row">
                <div class="col-3 form-group">
                    <label class="control-label" for="y">{{ trans('global.year') }}</label>
                    <select name="y" id="y" class="form-control">
                        @foreach(array_combine(range(date("Y"), 2010), range(date("Y"), 2010)) as $year)
                            <option value="{{ $year }}" @if($year===old('y', Request::get('y', date('Y')))) selected @endif>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-3 form-group">
                    <label class="control-label" for="m">{{ trans('global.month') }}</label>
                    <select name="m" for="m" class="form-control">
                        @foreach(cal_info(0)['months'] as $month)
                            <option value="{{ $month }}" @if($month===old('m', Request::get('m', date('F')))) selected @endif>
                                {{ $month }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-4">
                    <label class="control-label">&nbsp;</label><br>
                    <button class="btn btn-primary" type="submit">{{ trans('global.filterDate') }}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col">
        <h3 class="page-title">&nbsp;</h3>

        <form method="POST" action="{{ route("admin.users.report") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col-3 form-group">
                    <label class="required" for="activityfrom">{{ trans('cruds.activityReport.fields.activityfrom') }}</label>
                    <input class="form-control date {{ $errors->has('activityfrom') ? 'is-invalid' : '' }}" type="text" name="activityfrom" id="activityfrom" value="{{ old('activityfrom') }}" required>
                    @if($errors->has('activityfrom'))
                        <span class="text-danger">{{ $errors->first('activityfrom') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activityReport.fields.activityfrom_helper') }}</span>
                </div>
                <div class="col-3 form-group">
                    <label class="required" for="activityto">{{ trans('cruds.activityReport.fields.activityto') }}</label>
                    <input class="form-control date {{ $errors->has('activityto') ? 'is-invalid' : '' }}" type="text" name="activityto" id="activityto" value="{{ old('activityto') }}" required>
                    @if($errors->has('activityto'))
                        <span class="text-danger">{{ $errors->first('activityto') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activityReport.fields.activityto_helper') }}</span>
                </div>
            </div>
            <div class="row">
                <div class="col-6 form-group">
                    <label for="reportname">{{ trans('cruds.activityReport.fields.reportname') }}</label>
                    <input class="form-control {{ $errors->has('reportname') ? 'is-invalid' : '' }}" type="text" name="reportname" id="reportname" value="{{ old('reportname', '') }}">
                    @if($errors->has('reportname'))
                        <span class="text-danger">{{ $errors->first('reportname') }}</span>
                    @endif
                    <span class="help-block">{{ trans('cruds.activityReport.fields.reportname_helper') }}</span>
                </div>
                <div class="col-4">
                    <label class="control-label">&nbsp;</label><br>
                    <button class="btn btn-danger" type="submit">{{ trans('cruds.activityReport.fields.generateReport') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('cruds.activityReport.reports.activityReportSummary') }}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>{{ trans('cruds.activityReport.reports.totaltime') }}</th>
                        <td>{{ $activityTotalTime }}</td>
                    </tr>
                    <tr>
                        <th>{{ trans('cruds.activityReport.reports.amount') }}</th>
                        <td>{{ number_format($activityAmount, 2).'€' }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        {{ trans('cruds.activityReport.reports.activityReportByUser') }}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th>{{ trans('cruds.activityReport.reports.activityByUser') }}</th>
                        <th>{{ trans('cruds.activityReport.reports.activityByMinutes') }}</th>
                        {{-- <th>{{ number_format($activityMinutes, 0) }}</th> --}}
                    </tr>
                    @foreach($activitiesSummary as $act)
                        <tr>
                            <th>{{ $act['name'] }}</th>
                            <td>{{ number_format($act['minutes'], 0) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>




@endsection

@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
<script>
    $('.date').datepicker({
        autoclose: true,
        dateFormat: "{{ config('panel.date_format_js') }}"
      })
</script>
@stop
