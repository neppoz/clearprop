@extends('layouts.admin')
@section('content-header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h2 class="m-0">{{ trans('cruds.expenseReport.title') }}</h2>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('app.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.expenseReport.title') }}</li>
            </ol>
        </div>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="card invisible">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <span class="placeholder col-6"></span>
                                    </h5>
                                    <p class="card-text placeholder">
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-header d-flex p-0 border-none">
                                    <h3 class="card-title p-3">
                                        <i class="fas fa-filter mr-1"></i>
                                        {{ trans('global.filter') }}
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <form method="get">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"
                                                           for="y">{{ trans('global.year') }}</label>
                                                    <select name="y" id="y" class="form-control">
                                                        @foreach(array_combine(range(date("Y"), 1900), range(date("Y"), 1900)) as $year)
                                                            <option value="{{ $year }}"
                                                                    @if($year===old('y', Request::get('y', date('Y')))) selected @endif>
                                                                {{ $year }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block pl-2 text-muted">{{ $fromSelectedDate }}</span>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label"
                                                           for="m">{{ trans('global.month') }}</label>
                                                    <select name="m" for="m" class="form-control">
                                                        @foreach(cal_info(0)['months'] as $month)
                                                            <option value="{{ $month }}"
                                                                    @if($month===old('m', Request::get('m', date('F')))) selected @endif>
                                                                {{ $month }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    <span class="help-block pl-2 text-muted">{{ $toSelectedDate }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6 float-right">
                                                <div class="form-group">
                                                    <label class="control-label">&nbsp;</label><br>
                                                    <button class="btn btn-primary float-right"
                                                            type="submit">{{ trans('global.filterDate') }}</button>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label class="control-label">&nbsp;</label><br>
                                                    <button class="btn btn-warning float-right" name="pdf" value="true"
                                                            type="submit">{{ trans('global.pdf') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
                    {{ trans('cruds.expenseReport.reports.incomeReport') }}
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>{{ trans('cruds.expenseReport.reports.income') }}</th>
                                    <td>{{ number_format($incomesTotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('cruds.expenseReport.reports.expense') }}</th>
                                    <td>{{ number_format($expensesTotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <th>{{ trans('cruds.expenseReport.reports.profit') }}</th>
                                    <td>{{ number_format($profit, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>{{ trans('cruds.expenseReport.reports.incomeByCategory') }}</th>
                                    <th>{{ number_format($incomesTotal, 2) }}</th>
                                </tr>
                                @foreach($incomesSummary as $inc)
                                    <tr>
                                        <th>{{ $inc['name'] }}</th>
                                        <td>{{ number_format($inc['amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="col">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>{{ trans('cruds.expenseReport.reports.expenseByCategory') }}</th>
                                    <th>{{ number_format($expensesTotal, 2) }}</th>
                                </tr>
                                @foreach($expensesSummary as $inc)
                                    <tr>
                                        <th>{{ $inc['name'] }}</th>
                                        <td>{{ number_format($inc['amount'], 2) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th>{{ trans('cruds.expenseReport.reports.membername') }}</th>
                                    <th>{{ trans('cruds.expenseReport.reports.sumactivity') }}</th>
                                    <th>{{ trans('cruds.expenseReport.reports.sumincome') }}</th>
                                    <th>{{ trans('cruds.expenseReport.reports.sumtotal') }}</th>
                                </tr>
                                @foreach($overdueMembers as $member)
                                    @if($member->total != 0)
                                        <tr>
                                            <td>{{ $member->name }}</td>
                                            <td>{{ number_format($member->sumact, 2) }}</td>
                                            <td>{{ number_format($member->suminc, 2) }}</td>
                                            @if($member->total < 0)
                                                <th class="text-danger">{{ number_format($member->total, 2) }}</th>
                                            @else
                                                <td class="text-success">{{ number_format($member->total, 2) }}</td>
                                            @endif
                                        </tr>
                                    @endif
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
    @parent
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
    <script>
        $('.date').datepicker({
            autoclose: true,
            dateFormat: "{{ config('panel.date_format_js') }}"
        })
    </script>
@endsection


{{--    <div class="row m-2">--}}
{{--        @can('user_edit' && ($userMedicalGoingDue[$userMedicalDueInFuture] > 0 OR $userMedicalGoingDue[$userMedicalIsAlreadyDue] > 0))--}}
{{--            <div class="col">--}}
{{--                <div class="alert alert-warning alert-dismissible">--}}
{{--                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
{{--                <h5><i class="icon fas fa-exclamation-circle"></i> Invalid medical</h5>--}}
{{--                {{$userMedicalGoingDue[$userMedicalDueInFuture]}} members will be invalidated in less than a month.<br>--}}
{{--                {{$userMedicalGoingDue[$userMedicalIsAlreadyDue]}} members have no valid medical today.<br>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        @endcan--}}
{{--    </div>--}}

{{--    <div class="row m-2 mb-3">--}}
{{--        <div class="col-12 col-sm-6 col-md-4">--}}
{{--            <div class="info-box shadow-sm">--}}
{{--                <span class="info-box-icon bg-primary"><i class="fas fa-plane"></i></span>--}}
{{--                <div class="info-box-content">--}}
{{--                    <span class="info-box-text h4">Your airtime: {{ $statistics['getActivitySumTotalPersonal'] ?? ''}}</span>--}}
{{--                    <span class="info-box-text h6">--}}
{{--                        PIC: {{ $statistics['getActivitySumAsCommand'] ?? ''}} ---}}
{{--                        SPIC: {{ $statistics['getActivitySumAsCopilot'] ?? ''}} ---}}
{{--                        FI: {{ $statistics['getActivitySumAsInstructor'] ?? ''}}--}}
{{--                    </span>--}}
{{--                    <span class="info-box-text"><h4>Community airtime: {{ $statistics['getActivitySumTotalOfAllMembers'] ?? '' }}</h4></span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="col-12 col-sm-6 col-md-4">--}}
{{--            <div class="info-box shadow-sm">--}}
{{--                <span class="info-box-icon bg-primary"><i class="fas fa-plane"></i></span>--}}
{{--                <div class="info-box-content">--}}
{{--                    <span class="info-box-text h4">Your airtime: {{ $statistics['getActivitySumTotalPersonal'] ?? ''}}</span>--}}
{{--                    <span class="info-box-text h6">--}}
{{--                        PIC: {{ $statistics['getActivitySumAsCommand'] ?? ''}} ---}}
{{--                        SPIC: {{ $statistics['getActivitySumAsCopilot'] ?? ''}} ---}}
{{--                        FI: {{ $statistics['getActivitySumAsInstructor'] ?? ''}}--}}
{{--                    </span>--}}
{{--                    <span class="info-box-text"><h4>Community airtime: {{ $statistics['getActivitySumTotalOfAllMembers'] ?? '' }}</h4></span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--                @if($statistics['incomeAmountTotal'] > $statistics['activityAmountTotal'])--}}
{{--                    <div class="info-box shadow-sm text-black" >--}}
{{--                        <span class="info-box-icon bg-success"><i class="fas fa-piggy-bank"></i></span>--}}
{{--                        <div class="info-box-content">--}}
{{--                            <span class="info-box-text"><h4>{{  number_format($statistics['granTotal'], 2, ',', '.') }}  &euro;</h4></span>--}}
{{--                            <span class="info-box-number">{{ trans('cruds.dashboard.grantotal') }}</span>--}}
{{--                        </div>--}}
{{--                        <a class="stretched-link text-secondary" href="##">Show details</a>--}}
{{--                    </div>--}}
{{--                @else--}}
{{--                    <div class="info-box shadow-sm">--}}
{{--                        <span class="info-box-icon bg-danger"><i class="fas fa-piggy-bank"></i></span>--}}
{{--                        <div class="info-box-content">--}}
{{--                            <span class="info-box-text"><h4>{{  number_format($statistics['granTotal'], 2, ',', '.') }}  &euro;</h4></span>--}}
{{--                            <span class="info-box-number">{{ trans('cruds.dashboard.grantotal') }}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </a>--}}


{{--        <div class="col-12 col-sm-6 col-md-4">--}}
{{--            <div class="info-box shadow-sm">--}}
{{--                <span class="info-box-icon bg-primary"><i class="fas fa-plane"></i></span>--}}
{{--                <div class="info-box-content">--}}
{{--                    <span class="info-box-text"><h4>{{ $statistics['activityHoursAndMinutes'] }}</h4></span>--}}
{{--                    <span class="info-box-number">{{ trans('cruds.dashboard.activityHoursAndMinutes') }}</span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <hr>--}}
{{--    <div class="row m-2">--}}
{{--        @include('partials.stats-top-dashboard')--}}
{{--    </div>--}}
{{--    <div class="row m-2">--}}
{{--        @include('partials.stats-general')--}}
{{--    </div>--}}
{{--    @can('expense_report_access')--}}
{{--        <div class="row">--}}
{{--            <div class="col-12 col-sm-12 col-md-12">--}}
{{--                <div class="alert alert-info alert-dismissible">--}}
{{--                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
{{--                    <h5><i class="icon fas fa-info"></i>{{ trans('global.info') }}</h5>--}}
{{--                    <span>{!! trans('global.service_information_admins') !!}</span>--}}
{{--                    <span><a class="text-white"--}}
{{--                             href="{{ route("admin.expense-reports.index") }}">{{trans('global.link_text_goto')}}</a></span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endcan--}}
{{--    @if(auth()->user()->is_member)--}}
{{--        <div class="row">--}}
{{--            <div class="col-12 col-sm-12 col-md-12">--}}
{{--                <div class="alert alert-warning alert-dismissible">--}}
{{--                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>--}}
{{--                    <h5><i class="icon fas fa-exclamation-circle"></i>{{ trans('global.caution') }}</h5>--}}
{{--                    <span>{!! trans('global.medicalCheck') !!}</span>--}}
{{--                    <span><a class="text-danger"--}}
{{--                             href="{{ route('profile.password.edit') }}">{{trans('global.message_update_profile')}}</a></span>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    @endif--}}

{{--    <div class="row m-2 mb-3">--}}
{{--        <div class="col-12">--}}
{{--            <h4 class="text-dark">{{ trans('cruds.dashboard.reservation_title') }}</h4>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="row m-2 mb-3">--}}
{{--        <div class="col-12">--}}
{{--            <div class="btn-group mr-1">--}}
{{--                @can('booking_create')--}}
{{--                    <a class="btn btn-primary btn-block btn-flat"--}}
{{--                       href="{{route('app.bookings.create', ['mode_id' =>1]) }}"><i--}}
{{--                            class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_charter_booking') }}</a>--}}
{{--                @endcan--}}
{{--            </div>--}}
{{--            <div class="btn-group mr-1">--}}
{{--                @can('booking_school_create')--}}
{{--                    <a class="btn btn-secondary btn-block btn-flat"--}}
{{--                       href="{{route('app.bookings.create', ['mode_id' => 2]) }}"><i--}}
{{--                            class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_school_booking') }}</a>--}}
{{--                @endcan--}}
{{--            </div>--}}
{{--            <div class="btn-group mr-1">--}}
{{--                @can('booking_maintenance_create')--}}
{{--                    <a class="btn btn-danger btn-block btn-flat"--}}
{{--                       href="{{route('app.bookings.create', ['mode_id' =>4]) }}"><i--}}
{{--                            class="fa fa-plus"></i> {{ trans('cruds.dashboard.create_maintenance_booking') }}</a>--}}
{{--                @endcan--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <div class="row m-2">--}}
{{--        --}}
{{--    </div>--}}
<!-- conditional data -->
{{--    <div class="row m-2">--}}
{{--        <div class="col-md-6">--}}
{{--            @if(auth()->user()->can('user_management_access') AND (count($userMedicalGoingDue) > 0))--}}
{{--                <div class="row m-2">--}}
{{--                    <div class="col">--}}
{{--                        <h4 class="text-dark">{{trans('global.deadline_users')}}</h4>--}}
{{--                    </div><!-- /.col -->--}}
{{--                </div>--}}
{{--                <div class="row m-2">--}}
{{--                    <div class="col">--}}
{{--                        @include('partials.admin.deadlines-global')--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    <div class="row">--}}
{{--        <div class="col-md-6">--}}
{{--            @if(auth()->user()->can('asset_show') AND (count($statistics['assetsOverhaulData']) > 0))--}}
{{--                <div class="row m-2">--}}
{{--                    <div class="col">--}}
{{--                        <h4 class="text-dark">{{trans('global.deadline_assets')}}</h4>--}}
{{--                    </div><!-- /.col -->--}}
{{--                </div>--}}
{{--                <div class="row m-2">--}}
{{--                    <div class="col">--}}
{{--                        @include('partials.admin.assets-global')--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}
{{--    </div>--}}
