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
            Pagamento
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form method="POST" action="{{ route("pilot.checkout.paymentIntent") }}" id="payment-form">
                        @csrf
                        <div class="form-group">
                            <label class="required" for="amount">{{ trans('cruds.billing.fields.amount') }}</label>
                            <select class="form-control select2 {{ $errors->has('amount') ? 'is-invalid' : '' }}"
                                    name="amount" id="amount" required>
                                <option value="100" selected>100 €</option>
                                <option value="200">200 €</option>
                                <option value="300">300 €</option>
                                <option value="400">400 €</option>
                                <option value="500">500 €</option>
                            </select>
                            @if($errors->has('value'))
                                <span class="text-danger">{{ $errors->first('amount') }}</span>
                            @endif
                        </div>

                        <label for="card-element">
                            Credit or debit card
                        </label>
                        <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>

                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">
                                Paga con Carta di credito
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

