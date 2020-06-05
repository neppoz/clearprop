<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Activity;
use App\Expense;
use App\Http\Controllers\Controller;
use App\Income;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use VerumConsilium\Browsershot\Facades\PDF;

class ExpenseReportController extends Controller
{
    public function index()
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

        $fromSelectedDate = Carbon::parse($from)->format(config('panel.date_format'));
        $toSelectedDate = Carbon::parse($to)->format(config('panel.date_format'));

        $expenses = Expense::with('expense_category')
            ->whereBetween('entry_date', [$from, $to]);

        $incomes = Income::with('income_category')
            ->whereBetween('entry_date', [$from, $to]);

        $expensesTotal   = $expenses->sum('amount');
        $incomesTotal    = $incomes->sum('amount');
        $groupedExpenses = $expenses->whereNotNull('expense_category_id')->orderBy('amount', 'desc')->get()->groupBy('expense_category_id');
        $groupedIncomes  = $incomes->whereNotNull('income_category_id')->orderBy('amount', 'desc')->get()->groupBy('income_category_id');
        $profit          = $incomesTotal - $expensesTotal;

        $expensesSummary = [];

        foreach ($groupedExpenses as $exp) {
            foreach ($exp as $line) {
                if (!isset($expensesSummary[$line->expense_category->name])) {
                    $expensesSummary[$line->expense_category->name] = [
                        'name'   => $line->expense_category->name,
                        'amount' => 0,
                    ];
                }

                $expensesSummary[$line->expense_category->name]['amount'] += $line->amount;
            }
        }

        $incomesSummary = [];

        foreach ($groupedIncomes as $inc) {
            foreach ($inc as $line) {
                if (!isset($incomesSummary[$line->income_category->name])) {
                    $incomesSummary[$line->income_category->name] = [
                        'name'   => $line->income_category->name,
                        'amount' => 0,
                    ];
                }

                $incomesSummary[$line->income_category->name]['amount'] += $line->amount;
            }
        }

        /* Overdue payment members */
        $overdueMembers = DB::select(DB::raw("
            SELECT
                u.id,
                u.name,
                COALESCE(suminc, 0) AS suminc,
                COALESCE(sumact, 0) AS sumact,
                COALESCE(suminc, 0) - COALESCE(sumact, 0) AS total
            FROM
                users u
                    LEFT JOIN
                (SELECT
                    user_id, SUM(amount) AS sumact
                FROM
                    activities a
                WHERE
                    a.event BETWEEN (:activityfrom) AND (:activityto)
                GROUP BY a.user_id) a ON u.id = a.user_id
                    LEFT JOIN
                (SELECT
                    user_id, SUM(amount) AS suminc
                FROM
                    incomes i
                INNER JOIN income_categories ic ON i.income_category_id = ic.id
                WHERE
                    i.entry_date BETWEEN (:incomefrom) AND (:incometo)
                        AND ic.deposit = 1
                GROUP BY i.user_id) i ON u.id = i.user_id
            ORDER BY total ASC
        "), array(
            'activityfrom' => $from,
            'activityto'   => $to,
            'incomefrom'   => $from,
            'incometo'     => $to
        ));

        $data = compact(
            'expensesSummary',
            'incomesSummary',
            'expensesTotal',
            'incomesTotal',
            'profit',
            'overdueMembers',
            'fromSelectedDate',
            'toSelectedDate'
        );

        /* download pdf button */
        if (request()->query('pdf')) {
            return PDF::loadView('admin.expenseReports.pdf', $data)
                ->format('A4')
                ->showBackground()
                ->download();
        }

        return view('admin.expenseReports.index', $data);
    }
}
