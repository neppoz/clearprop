@extends('layouts.admin')
@section('content')
<div class="row">
    <div class="col">
        <h3 class="page-title">{{ trans('cruds.expenseReport.reports.title') }}</h3>
        <div class="row">
            <div class="col-3 form-group">
                <span class="help-block pl-2 text-muted">{{ $fromSelectedDate }}</span>
            </div>
            <div class="col-3 form-group">
                <span class="help-block pl-2 text-muted">{{ $toSelectedDate }}</span>
            </div>
        </div>
    </div>
</div>

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



@endsection

