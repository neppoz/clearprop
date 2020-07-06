<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\User;
use App\Activity;
use App\Income;
use niklasravnsborg\LaravelPdf\Facades\Pdf;
use App\Notifications\UserDataReportEmailNotification;
use Illuminate\Support\Facades\Notification;
use Throwable;

class UserDataReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $from;
    protected $to;
    protected $sender;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $from, $to, $sender)
    {
        $this->user = $user;
        $this->from = $from;
        $this->to = $to;
        $this->sender = $sender;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $user = $this->user;
            $sender_email = $this->sender->email;

            $report_name = $this->to.'_'.$user->name.'_'.uniqid();
            $path = storage_path('tmp/reports');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $activity_lines = Activity::select('event', 'counter_start', 'counter_stop', 'rate', 'minutes', 'amount')
                ->where('user_id', '=', $user->id)
                ->whereBetween('event', [$this->from, $this->to])
                ->get();

            $activityAmountTotal = $activity_lines->sum('amount');
            $activityMinutesTotal = $activity_lines->sum('minutes');
            $activityHoursAndMinutes = intval($activityMinutesTotal / 60) . ':' . $activityMinutesTotal%60;


            $income_lines = Income::whereHas('income_category', function ($q) {
                $q->where('deposit', '=', 1);
            })
                ->whereBetween('entry_date', [$this->from, $this->to])
                ->where('user_id', '=', $user->id)
                ->get();
            $incomeAmountTotal = $income_lines->sum('amount');


            $granTotal = $incomeAmountTotal + -abs($activityAmountTotal);

            $pdf = Pdf::loadView('reports.members', compact(
                'user',
                'activity_lines',
                'income_lines',
                'activityMinutesTotal',
                'activityHoursAndMinutes',
                'activityAmountTotal',
                'incomeAmountTotal',
                'granTotal'
            ));

            $pdf->save($path.'/'.$report_name.'.pdf');

            $attachment = $path.'/'.$report_name.'.pdf';

            $data  = ['name' => $user->name, 'date' => $this->to];
            Notification::send($user, new UserDataReportEmailNotification($data, $attachment, $sender_email));

            return;
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
