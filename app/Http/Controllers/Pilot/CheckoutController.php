<?php

namespace App\Http\Controllers\Pilot;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Customer;
use Stripe\Charge;

class CheckoutController extends Controller
{
    public function paymentIntent(Request $request)
    {
        try {
            \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

            $intent = \Stripe\PaymentIntent::create([
                'receipt_email' => auth()->user()->email,
                'amount' => $request->input('amount') * 100,
                'currency' => env('STRIPE_CURRENCY'),
                'metadata' => ['integration_check' => 'accept_a_payment'],
                'description' => $request->input('title'),
                'application_fee_amount' => ceil($request->input('amount') * env('STRIPE_FEE')),
            ], ['stripe_account' => env('STRIPE_CONNECTED_ACCOUNT')]);

            return view('pilot.billings.checkout', compact('intent'));

        } catch (\Throwable $e) {
            http_response_code(500);
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function processCheckout(Request $request)
    {
        $paymentId = $request->input('payment-id');
        $paymentMethod = $request->input('payment-method');
        $paymentStatus = $request->input('payment-status');

        try {
            if ($paymentStatus == 'succeeded') {
                return redirect()->route('pilot.welcome')->withMessage(trans('global.payment-success'));
            }
        } catch (\Throwable $exception) {
            return redirect()->back()->withError($exception->getMessage());
        }

        return true;
    }

}
