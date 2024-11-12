

@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))

@section('content')
    @include('plugins/payment::partials.header')
  <div>
       
  <!-- <div class="card p-5" style="background-color: #F1F3F9;">
        <div>
             Main form for payment -->
            <!-- <form action="{{ $action }}" method="post" class="payment-checkout-form">
                @csrf
                <input type="hidden" name="name" value="{{ $name }}">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <input type="hidden" name="currency" value="{{ $currency }}">
                @if (isset($returnUrl))
                    <input type="hidden" name="return_url" value="{{ $returnUrl }}">
                @endif
                @if (isset($callbackUrl))
                    <input type="hidden" name="callback_url" value="{{ $callbackUrl }}">
                @endif
                {!! apply_filters(PAYMENT_FILTER_PAYMENT_PARAMETERS, null) !!}

                @include('plugins/payment::partials.payment-methods')

                <br>
                <div class="text-center">
                    <button  class=" btn btn-info" data-processing-text="{{ __('Processing. Please wait...') }}" data-error-header="{{ __('Error') }}">{{ __('Checkout') }}</button>
                </div>
           

                                <div class="d-flex flex-column justify-content-sm-center justify-content-md-center">
                                    <p class="text-wrap text-white" id="errorMessage">{{ __('Opps your credit is not sufficient . please recharge it.') }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </form> -->
        <!-- </div>
    </div>  -->

</div>
    @include('plugins/payment::partials.footer')

@endsection
