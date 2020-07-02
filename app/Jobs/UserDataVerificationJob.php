<?php

namespace App\Jobs;

use App\User;
use App\Activity;
use App\Income;

use Bugsnag\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Notifications\UserDataMedicalEmailNotification;
use App\Notifications\UserDataBalanceEmailNotification;
use Illuminate\Support\Facades\Notification;
use Throwable;
use Log;

class UserDataVerificationJob //implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $activities = Activity::where('user_id', $this->user->id)
                ->whereBetween('event', [now()->startOfYear(), now()]);

            $incomes = Income::whereHas('income_category', function ($q) {
                $q->where('deposit', '=', 1);
            })
                ->where('user_id', $this->user->id)
                ->whereBetween('entry_date', [now()->startOfYear(), now()]);

            $balance = ($activities->sum('amount')-abs($incomes->sum('amount')));

            /** Recipients */
            $admins = User::wherehas('roles', function ($q) {
                $q->where('role_id', User::IS_ADMIN);
            })->get();

            if ($balance > 0) {
                $data  = ['name' => $this->user->name, 'balance' => number_format($balance, 2, ',', '.')];
                $admins = User::wherehas('getIsAdminAttribute')->get();
                Notification::send($admins, new UserDataBalanceEmailNotification($data));
            }

            /** checking user conditions */
            if (!empty($this->user->medical_due) && $this->user->medical_due <=  now()) {
                $data  = ['name' => $this->user->name, 'medical_due' => $this->user->medical_due];
                Notification::send($admins, new UserDataMedicalEmailNotification($data));
            };

            return;
            /** */
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
