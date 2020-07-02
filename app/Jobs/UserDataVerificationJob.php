<?php

namespace App\Jobs;

use App\User;
use Bugsnag\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Notifications\UserDataMedicalEmailNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
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
            /** checking user conditions */
            if ($this->user->medical_due <=  now()) {
                $data  = ['name' => $this->user->name, 'medical_due' => $this->user->medical_due];
                Notification::send($this->user, new UserDataMedicalEmailNotification($data));
            };

            return;
            /** */
        } catch (Throwable $exception) {
            report($exception);
        }
    }
}
