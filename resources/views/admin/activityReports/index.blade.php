@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.activityReport.title') }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('app.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.activityReport.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>

    <div class="row m-2">
        <div class="col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <form method="get">
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label" for="y">{{ trans('global.year') }}</label>
                                <select name="y" id="y" class="form-control">
                                    @foreach(array_combine(range(date("Y"), 2010), range(date("Y"), 2010)) as $year)
                                        <option value="{{ $year }}"
                                                @if($year===old('y', Request::get('y', date('Y')))) selected @endif>
                                            {{ $year }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="help-block pl-2 text-muted">{{ $fromSelectedDate }}</span>
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label" for="m">{{ trans('global.month') }}</label>
                                <select name="m" for="m" class="form-control">
                                    @foreach(cal_info(0)['months'] as $month)
                                        <option value="{{ $month }}"
                                                @if($month===old('m', Request::get('m', date('F')))) selected @endif>
                                            {{ $month }}
                                        </option>
                                    @endforeach
                                </select>
                                <span class="help-block text-muted">{{ $toSelectedDate }}</span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-4">
                                <label class="control-label"></label>
                                <button class="btn btn-primary" type="submit">{{ trans('global.filterDate') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row m-2">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <form method="POST" action="{{ route("admin.users.report") }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6 text-left">
                                {{ trans('cruds.activityReport.reports.activityReportSummary') }} {{ trans('cruds.activityReport.fields.activityfrom') }}
                                <strong>{{ $fromSelectedDate }}</strong> {{ trans('cruds.activityReport.fields.activityuntil') }}
                                <strong>{{ $toSelectedDate }}</strong>
                            </div>
                            <div class="col-6 text-right">
                                <button class="btn btn-warning"
                                        type="submit">{{ trans('cruds.activityReport.fields.generateReport') }}</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th class="w-50"></th>
                                    <th class="w-25">{{ trans('cruds.activityReport.reports.activityByMinutes') }}</th>
                                    <th class="w-25">{{ trans('cruds.activityReport.reports.activityTotalTime') }}</th>

                                </tr>
                                <tr>
                                    <th class="w-50">{{ trans('cruds.activityReport.reports.activityReportTotal') }}</th>
                                    <th class="w-25">{{ $activityTotalMinutes ?? '' }}</th>
                                    <th class="w-25">{{ $activityTotalTime ?? '' }}</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th class="w-50">{{ trans('cruds.activityReport.reports.activityReportByPlane') }}</th>
                                    <th class="w-25">{{ trans('cruds.activityReport.reports.activityByMinutes') }}</th>
                                    <th class="w-25">{{ trans('cruds.activityReport.reports.activityTotalTime') }}</th>
                                </tr>
                                @foreach($activitiesPlaneSummary ?? '' as $act)
                                    <tr>
                                        <td class="w-50">{{ $act['callsign'] }}</td>
                                        <td class="w-25">{{ number_format($act['minutes'], 2) }}</td>
                                        <td class="w-25">{{ sprintf("%02d", intval($act['minutes']/60)).':'. sprintf("%02d", $act['minutes']%60)}}</td>
                                    </tr>
                                @endforeach
                            </table>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th class="w-50">{{ trans('cruds.activityReport.reports.activityReportByType') }}</th>
                                    <th class="w-25">{{ trans('cruds.activityReport.reports.activityByMinutes') }}</th>
                                    <th class="w-25">{{ trans('cruds.activityReport.reports.activityTotalTime') }}</th>

                                </tr>
                                @foreach($activitiesTypeSummary ?? '' as $act)
                                    <tr>
                                        <td class="w-50">{{ $act['name'] }}</td>
                                        <td class="w-25">{{ number_format($act['minutes'], 2) }}</td>
                                        <td class="w-25">{{ sprintf("%02d", intval($act['minutes']/60)).':'. sprintf("%02d", $act['minutes']%60)}}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row m-2">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.activityReport.reports.activityReportByInstructor') }}
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th class="w-50">{{ trans('cruds.activityReport.reports.activityByInstructor') }}</th>
                        <th class="w-25">{{ trans('cruds.activityReport.reports.activityByMinutes') }}</th>
                        <th class="w-25">{{ trans('cruds.activityReport.reports.activityTotalTime') }}</th>
                    </tr>
                    @foreach($activitiesInstructorSummary ?? '' as $act)
                        <tr>
                            <td class="w-50">{{ $act['name'] }}</td>
                            <td class="w-25">{{ number_format($act['minutes'], 0) }}</td>
                            <td class="w-25">{{ sprintf("%02d", intval($act['minutes']/60)).':'. sprintf("%02d", $act['minutes']%60)}}</td>
                        </tr>
                    @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row m-2">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.activityReport.reports.activityReportByUser') }}
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col">
                <table class="table table-bordered table-striped">
                    <tr>
                        <th class="w-50">{{ trans('cruds.activityReport.reports.activityByUser') }}</th>
                        <th class="w-25">{{ trans('cruds.activityReport.reports.activityByMinutes') }}</th>
                        <th class="w-25">{{ trans('cruds.activityReport.reports.activityTotalTime') }}</th>
                    </tr>
                    @foreach($activitiesUserSummary ?? '' as $act)
                        <tr>
                            <td class="w-50">{{ $act['name'] }}</td>
                            <td class="w-25">{{ number_format($act['minutes'], 0) }}</td>
                            <td class="w-25">{{ sprintf("%02d", intval($act['minutes']/60)).':'. sprintf("%02d", $act['minutes']%60)}}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
            </div>
        </div>
    </div>

@endsection


@section('scripts')

@endsection
