@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col-8">
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
                    <span class="help-block pl-2 text-muted">{{ $fromSelectedDate }}</span>
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
                    <span class="help-block pl-2 text-muted">{{ $toSelectedDate }}</span>
                </div>
                <div class="col-4">
                    <label class="control-label">&nbsp;</label><br>
                    <button class="btn btn-primary" type="submit">{{ trans('global.filterDate') }}</button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-4">
        <h3 class="page-title">{{ trans('cruds.activityReport.title_generate') }}</h3>

        <form method="POST" action="{{ route("admin.users.report") }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label class="text-muted" for="activityreport">{{ trans('cruds.activityReport.fields.activityfilter') }} {{ $fromSelectedDate }} - {{ $toSelectedDate }}</label>
                        <input class="form-control date {{ $errors->has('activityfrom') ? 'is-invalid' : '' }}" type="hidden" name="activityfrom" id="activityfrom" value="{{ $fromSelectedDate }}">
                        {{-- @if($errors->has('activityfrom'))
                            <span class="text-danger">{{ $errors->first('activityfrom') }}</span>
                        @endif --}}
                        {{-- <span class="help-block">{{ trans('cruds.activityReport.fields.activityfrom_helper') }}</span> --}}

                        {{-- <label class="col-2" for="activityto">{{ trans('cruds.activityReport.fields.activityto') }}</label> --}}
                        <input class="form-control date {{ $errors->has('activityto') ? 'is-invalid' : '' }}" type="hidden" name="activityto" id="activityto" value="{{ $toSelectedDate }}" required>
                        {{-- @if($errors->has('activityto'))
                            <span class="text-danger">{{ $errors->first('activityto') }}</span>
                        @endif --}}
                        {{-- <span class="help-block">{{ trans('cruds.activityReport.fields.activityto_helper') }}</span> --}}

                        {{-- <label class="required col" for="reportname">{{ trans('cruds.activityReport.fields.reportname') }}</label>
                        <input class="form-control col {{ $errors->has('reportname') ? 'is-invalid' : '' }}" type="text" name="reportname" id="reportname" value="{{ old('reportname', '') }}">
                        @if($errors->has('reportname'))
                            <span class="text-danger">{{ $errors->first('reportname') }}</span>
                        @endif
                        <span class="help-block">{{ trans('cruds.activityReport.fields.reportname_helper') }}</span> --}}

                        {{-- <label class="control-label col">&nbsp;</label><br> --}}
                        <button class="btn btn-danger" type="submit">{{ trans('cruds.activityReport.fields.generateReport') }}</button>
                    </div>
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
                            <td>{{ $act['name'] }}</td>
                            <td>{{ number_format($act['minutes'], 0) }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">

            </div>
        </div>

    </div>
</div>




@endsection


@section('scripts')

@endsection
