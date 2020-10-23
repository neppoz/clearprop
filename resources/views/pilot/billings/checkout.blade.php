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
            {{trans('global.proceed-payment')}}
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12 text-center">
                    <div class="label">{{$intent->description}}</div>
                    <div class="h2">{{number_format($intent->amount / 100, 2,',','.')}} &euro;</div>

                    <div class="row align-items-center mt-2 bg-light">
                        <div class="col-sm-2 col-md-4 mx-auto">
                            <img src="{{asset('/images/payment/1.png')}}" alt="visa">
                        </div>
                        <div class="col-sm-2 col-md-4 mx-auto text-center">
                            <i class="fas fa-check-circle text-success"></i>
                            <p class="text-success text-bold">{{trans('global.secure-transaction')}}</p>
                        </div>
                        <div class="col-sm-2 col-md-4 mx-auto">
                            <img src="{{asset('/images/payment/2.png')}}" alt="mastercard">
                        </div>
                    </div>

                </div>
            </div>
            <div class="row align-items-center mt-2 border-secondary">
                <div class="col-12">
                    <hr>
                    <form action="{{ route('pilot.checkout.processCheckout') }}" method="POST" id="checkout-form">
                        @csrf
                        <input type="hidden" name="payment-id" id="payment-id" value=""/>
                        <input type="hidden" name="payment-method" id="payment-method" value=""/>
                        <input type="hidden" name="payment-status" id="payment-status" value=""/>
                        <h5>{{trans('cruds.checkout.fields.card-element')}}</h5>
                        <hr>
                        <div class="input-group mb-2">
                            <input type="text" class="form-control" id="card-name"
                                   placeholder="{{trans('cruds.checkout.fields.cardholder-name')}}" required>
                        </div>
                        <div class="input-group mb-2">
                            <span id="card-number" class="form-control">
                            <!-- Stripe Card Element -->
                            </span>
                        </div>
                        <div class="input-group mb-2">
                            <span id="card-cvc" class="form-control">
                            <!-- Stripe CVC Element -->
                            </span>
                            <span id="card-exp" class="form-control">
                            <!-- Stripe Card Expiry Element -->
                            </span>
                        </div>

                        <br>
                        <div class="form-group text-center">
                            <button class="btn btn-block btn-success" id="checkout-button">
                                <i class="fas fa-lock"></i>
                                {{trans('global.pay-now')}}
                            </button>
                            <div class="modal fade" id="loadingModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-dialog-centered d-flex justify-content-center"
                                     role="document">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="row">
                                            <div class="spinner-border text-warning ml-auto" role="status"
                                                 aria-hidden="true"></div>
                                        </div>
                                        <div class="row">
                                            <div class="text-warning">{{trans('global.payment-processing')}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            let stripe = Stripe("{{ env('STRIPE_KEY') }}", {
                stripeAccount: "{{ env('STRIPE_CONNECTED_ACCOUNT') }}",
            })
            let elements = stripe.elements()

            // Try to match bootstrap 4 styling
            var style = {
                base: {
                    'lineHeight': '1.35',
                    'fontSize': '16px',
                    'fontSmoothing': 'antialiased',
                    'color': '#495057',
                    'fontFamily': 'apple-system,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif'
                }
            };

            // Card number
            var card = elements.create('cardNumber', {
                'placeholder': '{{trans('cruds.checkout.fields.card-number')}}',
                'style': style
            });
            card.mount('#card-number');

            // CVC
            var cvc = elements.create('cardCvc', {
                'placeholder': '{{trans('cruds.checkout.fields.card-cvc')}}',
                'style': style
            });
            cvc.mount('#card-cvc');

            // Card expiry
            var exp = elements.create('cardExpiry', {
                'placeholder': '{{trans('cruds.checkout.fields.card-exp')}}',
                'style': style
            });
            exp.mount('#card-exp');

            let paymentMethod = null
            $('#checkout-form').on('submit', function (e) {
                $('#checkout-button').prop("disabled", true)

                if (paymentMethod) {
                    return true
                }
                $('.modal').modal('show');
                setTimeout(function () {
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
                            paymentId = result.paymentIntent.id
                            paymentMethod = result.paymentIntent.payment_method
                            paymentStatus = result.paymentIntent.status
                            $('#payment-id').val(paymentId)
                            $('#payment-method').val(paymentMethod)
                            $('#payment-status').val(paymentStatus)
                            $('#checkout-form').submit()
                        }
                    })

                    // $('.modal').modal('hide');
                }, 2000);

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