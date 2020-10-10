@extends('layouts.pilot')
@section('content')
    <div class="row m-2">
        <div class="col-sm-6">
            <h4 class="m-0 text-dark">{{ trans('cruds.billing.title') }}</h4>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{route('pilot.welcome')}}">Home</a></li>
                <li class="breadcrumb-item active">{{ trans('cruds.billing.title') }}</li>
            </ol>
        </div><!-- /.col -->
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            Checkout
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('pilot.checkout.processCheckout') }}" method="POST" id="checkout-form">
                        @csrf
                        <input id="card-holder-name" type="text" placeholder="Card holder name"/>
                        <input type="hidden" name="payment-method" id="payment-method" value=""/>

                        <div id="card-element">
                            <!-- Elements will create input elements here -->
                        </div>

                        <!-- We'll put the error messages in this element -->
                        <div id="card-errors" role="alert"></div>

                        <button id="submit">Pay</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection

@section('scripts')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(document).ready(function () {
            let stripe = Stripe("{{ env('STRIPE_KEY') }}")
            let elements = stripe.elements()
            let style = {
                base: {
                    color: '#32325d',
                    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            }
            let card = elements.create('card', {style: style})
            card.mount('#card-element')
            let paymentMethod = null
            $('#checkout-form').on('submit', function (e) {
                if (paymentMethod) {
                    return true
                }
                stripe.confirmCardPayment(
                    "{{ $intent->client_secret }}",
                    {
                        payment_method: {
                            card: card,
                            billing_details: {name: $('#card-holder-name').val()}
                        }
                    }
                ).then(function (result) {
                    if (result.error) {
                        console.log(result)
                        alert('error')
                    } else {
                        paymentMethod = result.paymentIntent.payment_method
                        $('#payment-method').val(paymentMethod)
                        $('#checkout-form').submit()
                    }
                })
                return false
            })
        });
    </script>
@endsection

@section('styles')
    <style>
        .StripeElement {
            box-sizing: border-box;
            height: 40px;
            padding: 10px 12px;
            border: 1px solid transparent;
            border-radius: 4px;
            background-color: white;
            box-shadow: 0 1px 3px 0 #e6ebf1;
            -webkit-transition: box-shadow 150ms ease;
            transition: box-shadow 150ms ease;
        }
        .StripeElement--focus {
            box-shadow: 0 1px 3px 0 #cfd7df;
        }
        .StripeElement--invalid {
            border-color: #fa755a;
        }
        .StripeElement--webkit-autofill {
            background-color: #fefde5 !important;
        }
    </style>
@endsection
