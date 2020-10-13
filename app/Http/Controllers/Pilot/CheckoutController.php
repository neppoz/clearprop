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
//        \Stripe\Stripe::setApiKey('sk_test_51HY3SMKi5dM1ECAoEIARwLvPyljsAMlqCt3rNgP0vClpnAx5WLgcWSaPS0udLNVJSXPb7dDCz5OXkPksxH3R1STz00GTukXV2O');
//
//        $customer = \Stripe\Customer::create([
//            'name' => auth()->user()->name,
//            'email' => auth()->user()->email,
//            'payment_method' => $request->input('payment-method'),
//        ]);
        $paymentMethod = $request->input('payment-method');

        try {
            return redirect()->route('pilot.billing.index')->withMessage('Payment completed successfully. ' . $paymentMethod);
        } catch (\Throwable $exception) {
            return redirect()->back()->withError($exception->getMessage());
        }

    }
//
//    public function charge(Request $request)
//    {
//
//        return view('pilot.billings.index');
//
//
//    }
//
//    public function calculateBasket(Request $request)
//    {
//        // Get itmes from DB and Pass to view
//        $items = [
//            'id' => 'Acconto voli',
//            'amount' => '400',
//        ];
//
//        return view('pilot.billings.checkout', compact('items'));
//    }
//
//    public function cardCheckout(Request $request)
//    {
//        try {
//            \Stripe\Stripe::setApiKey('sk_test_51HY3SMKi5dM1ECAoEIARwLvPyljsAMlqCt3rNgP0vClpnAx5WLgcWSaPS0udLNVJSXPb7dDCz5OXkPksxH3R1STz00GTukXV2O');
//
//            $paymentIntent = \Stripe\PaymentIntent::create([
//                'amount' => '400',
//                'currency' => 'eur',
//            ]);
//            $output = [
//                'clientSecret' => $paymentIntent->client_secret,
//            ];
//
//            return json_encode($output);
//
//        } catch (Error $e) {
//            http_response_code(500);
//            return json_encode(['error' => $e->getMessage()]);
//        }
//    }

}
