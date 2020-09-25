@extends('layouts.admin')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h3 class="m-0 text-dark">{{ trans('cruds.expenseReport.title') }}</h3>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('admin.home')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.expenseReport.title') }}</li>
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
                                    @foreach(array_combine(range(date("Y"), 1900), range(date("Y"), 1900)) as $year)
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
                                <span class="help-block pl-2 text-muted">{{ $toSelectedDate }}</span>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-2">
                                <label class="control-label">&nbsp;</label><br>
                                <button class="btn btn-primary" type="submit">{{ trans('global.filterDate') }}</button>
                            </div>
                            <div class="form-group col-md-2">
                                <label class="control-label">&nbsp;</label><br>
                                <button class="btn btn-warning float-right" name="pdf" value="true"
                                        type="submit">{{ trans('global.pdf') }}</button>
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
@stop
