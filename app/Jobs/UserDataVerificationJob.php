<?php

namespace App\Jobs;

use App\Parameter;
use App\Permission;
use App\User;
use App\Activity;
use App\Income;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Notifications\UserDataMedicalEmailNotification;
use App\Notifications\UserDataBalanceEmailNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;
use Throwable;

class UserDataVerificationJob implements ShouldQueue
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
            if (Parameter::where('slug', 'check.balance')->value('value') == Parameter::CHECK_BALANCE_ENABLED) {
                $activities = Activity::where('user_id', $this->user->id)
                    ->whereBetween('event', [now()->startOfYear(), now()]);

                $incomes = Income::whereHas('income_category', function ($q) {
                    $q->where('deposit', '=', 1);
                })
                    ->where('user_id', $this->user->id)
                    ->whereBetween('entry_date', [now()->startOfYear(), now()]);

                $balance = ($activities->sum('amount') - abs($incomes->sum('amount')));

                if ($balance > 0) {
                    $data = ['name' => $this->user->name, 'balance' => number_format($balance, 2, ',', '.')];
                    Notification::send($this->getNotifiableUsers(Permission::notification_all_users_balance), new UserDataBalanceEmailNotification($data));
                }
            }

            if (Parameter::where('slug', 'check.medical')->value('value') == Parameter::CHECK_MEDICAL_ENABLED) {
                if ((!empty($this->user->medical_due)) && (Carbon::createFromFormat(config('panel.date_format'), $this->user->medical_due)->format('Y-m-d') <= now())) {
                    $data = ['name' => $this->user->name, 'medical_due' => $this->user->medical_due];
                    Notification::send($this->getNotifiableUsers(Permission::notification_all_users_medical), new UserDataMedicalEmailNotification($data));
                }
            }

            return;
            /** */
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    public function getNotifiableUsers($permission_id): \Illuminate\Database\Eloquent\Collection|array
    {
        return User::whereHas('roles', function ($query) use ($permission_id) {
            $query->whereHas('permissions', function ($query) use ($permission_id) {
                $query->where('id', '=', $permission_id);
            });
        })->get();
    }
}
