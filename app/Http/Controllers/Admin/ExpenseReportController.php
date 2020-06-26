<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use VerumConsilium\Browsershot\Facades\PDF;
use App\Services\StatisticsService;

class ExpenseReportController extends Controller
{
    public function index(Request $request)
    {
        $fromMonth = Carbon::parse(sprintf(
            '%s-%s-01',
            request()->query('y', Carbon::now()->year),
            request()->query('m', Carbon::now()->month)
        ));
        $from = Carbon::parse(sprintf(
            '%s-01-01',
            request()->query('y', Carbon::now()->year)
        ));
        $to      = clone $fromMonth;
        $to->day = $to->daysInMonth;

        $fromDate = Carbon::parse($from)->format('Y-m-d');
        $toDate = Carbon::parse($to)->format('Y-m-d');
        session([
            'fromDate' => $fromDate,
            'toDate' => $toDate,
        ]);

        $fromSelectedDate = Carbon::parse($from)->format(config('panel.date_format'));
        $toSelectedDate = Carbon::parse($to)->format(config('panel.date_format'));

        /** Invoke Service Class */
        $statistics = (new StatisticsService())->getExpenseReport($request);

        session([
            'fromSelectedDate' => $fromSelectedDate,
            'toSelectedDate' => $toSelectedDate,
        ]);


        /* download pdf button */
        if (request()->query('pdf')) {
            return PDF::loadView('admin.expenseReports.pdf', $statistics)
                ->format('A4')
                ->showBackground()
                ->download();
        }

        return view('admin.expenseReports.index', [
            'expensesSummary' => $statistics['expensesSummary'],
            'incomesSummary'=> $statistics['incomesSummary'],
            'expensesTotal'=> $statistics['expensesTotal'],
            'incomesTotal'=> $statistics['incomesTotal'],
            'profit' => $statistics['profit'],
            'overdueMembers' => $statistics['overdueMembers']
        ], compact(
            'fromSelectedDate',
            'toSelectedDate'
        ));
    }
}
