<?php

namespace App\Jobs\StripeWebhooks;

use App\Income;
use App\Payment;
use App\User;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\WebhookClient\Models\WebhookCall;

class ChargeSucceeded implements ShouldQueue
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
        $user = User::where('email', $charge['receipt_email'])->firstOrFail();
        $entry_date = Carbon::createFromTimestamp($charge['created']);
        try {
            $payment = Payment::create([
                'user_id' => $user->id,
                'stripe_id' => $charge['payment_intent'],
                'total' => $charge['amount'],
            ]);

            Income::create([
                'entry_date' => Carbon::parse($entry_date)->format('d-m-Y'),
                'amount' => $charge['amount'],
                'description' => 'Card payment ref.: ' . $payment->id,
                'income_category_id' => '1',
                'user_id' => $user->id,
            ]);

        } catch (\Throwable $exception) {
            Bugsnag::notifyException($exception);
            return $exception->getMessage();
        }

        return true;
    }
}
