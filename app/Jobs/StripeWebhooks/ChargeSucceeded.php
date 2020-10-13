<?php

namespace App\Jobs\StripeWebhooks;

use App\Payment;
use App\User;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;

class ChargeSucceeded //TODO implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var WebhookCall */
    public $webhookCall;

    public function __construct(WebhookCall $webhookCall)
    {
        $this->webhookCall = $webhookCall;
    }

    public function handle()
    {
        // you can access the payload of the webhook call with `$this->webhookCall->payload`
        $charge = $this->webhookCall->payload['data']['object'];
        $user = User::where('email', $charge['receipt_email'])->findOrFail();

        try {
            Payment::create([
                'user_id' => $user->id,
                'stripe_id' => $charge['id'],
                'total' => $charge['amount'],
            ]);

        } catch (\Throwable $exception) {
            Bugsnag::notifyException($exception);
            return $exception->getMessage();
        }

    }
}
