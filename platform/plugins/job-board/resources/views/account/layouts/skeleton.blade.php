@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))

<style>
    .setMainContent {
        margin-top: 100px;
        margin-left: -100px;
        background-color: #EFF6F9;
    }

    .setNav {
        margin-left: 100px;
        margin-top: 120px;
    }

    .skeletonDesign {}

    .summaryDesign {
        background-color: #F1F3F9;
        width: 50vh;
        height: 30vh;
        margin-left: 30px;
        margin-top: 0px;
    }

    .paymentDesign {
        background-color: #F1F3F9;
        margin-left: 100px;
        width: 75vh;
        height: 40vh;
    }

    .mainDesign {
        display: flex;
        flex-direction: row;
    }

    .design {
        display: flex;
        flex-direction: row-reverse;
        justify-content: space-between;
    }

    .textDesign {
        margin-left: 260px;
    }

    .buttonDesign {
        margin-left: 500px;
        width: 318px;
        height: 60px;
        background-color: #072AC8;
        margin-top: -180px;
        radius: 30px;
        color: white;
    }

    @media (min-width: 320px) and (max-width: 480px) {
        .setMainContent {
            margin-top: 0px;
            margin-left: 0px;
            background-color: #EFF6F9;
        }

        .setNav {
            margin-left: 0px;
            margin-top: 0px;
            display: none;
        }

        .skeletonDesign {
            margin-left: 0px;
        }

        .mainDesign {
            display: flex;
            flex-direction: column;
        }

        .summaryDesign {
            background-color: #F1F3F9;
            width: 100%;
            height: 100%;
            margin-left: 0px;
            margin-bottom: 20px;
            margin-top: 40px;
        }

        .paymentDesign {
            margin-left: 0px;
            width: 100%;
            height: 100%;
            margin-bottom: 100px;
        }

        .design {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-left: 0px;
            height: 100vh;
        }

        .textDesign {
            margin-left: 0px;
            margin-top: -30px;
        }

        .buttonDesign {
            margin-left: 0px;
            width: 318px;
            height: 60px;
            background-color: #072AC8;
            margin-top: 0px;
            margin-bottom: 20px;
            radius: 30px;
            color: white;
        }
    }

    @media (min-width: 481px) and (max-width: 768px) {
        .setMainContent {
            margin-top: 0px;
            margin-left: 0px;
            background-color: #EFF6F9;
        }

        .setNav {
            margin-left: 0px;
            margin-top: 0px;
            display: none;
        }

        .skeletonDesign {
            margin-left: 0px;
        }

        .mainDesign {
            display: flex;
            flex-direction: column;
        }

        .summaryDesign {
            background-color: #F1F3F9;
            width: 100%;
            height: 100%;
            margin-left: 0px;
            margin-bottom: 20px;
        }

        .paymentDesign {
            margin-left: 0px;
            width: 100%;
            margin-bottom: 40px;
        }

        .design {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-left: 0px;
            height: 100vh;
        }

        .textDesign {
            margin-left: 0px;
            margin-top: -60px;
        }

        .buttonDesign {
            margin-left: 50px;
            width: 318px;
            height: 60px;
            background-color: #072AC8;
            margin-bottom: 120px;
            radius: 30px;
            color: white;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .textDesign {
            margin-left: 0px;
            margin-top: -60px;
        }

        .mainDesign {
            display: flex;
            flex-direction: column;
        }

        .setMainContent {
            margin-top: 0px;
            margin-left: 0px;
            background-color: #EFF6F9;
        }

        .setNav {
            margin-left: 0px;
            margin-top: 0px;
            display: none;
        }

        .paymentDesign {
            margin-left: 0px;
            margin-top: 20px;
            width: 100%;
            margin-bottom: 40px;
        }

        .setMainContent {
            margin-top: 0px;
            margin-left: 0px;
            background-color: #EFF6F9;
        }

        .setNav {
            margin-left: 0px;
            margin-top: 0px;
            display: nine;
        }

        .skeletonDesign {
            margin-left: 0px;
        }

        .summaryDesign {
            background-color: #F1F3F9;
            width: 100%;
            height: 100%;
            margin-left: 0px;
            margin-top: 10px;
        }

        .design {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-left: 0px;
            width: 100%;

        }

        .buttonDesign {
            margin-left: 200px;
            width: 318px;
            height: 60px;
            background-color: #072AC8;
            margin-bottom: 120px;
            radius: 30px;
            color: white;
        }
    }


    @media (min-width: 1025px) and (max-width: 1200px) {
        .textDesign {
            margin-left: 0px;
            margin-top: -60px;
        }

        .mainDesign {
            display: flex;
            flex-direction: column;
        }

        .setMainContent {
            margin-top: 0px;
            margin-left: 0px;
            background-color: #EFF6F9;
        }

        .setNav {
            margin-left: 0px;
            margin-top: 0px;
            display: none;
        }

        .paymentDesign {
            margin-left: 0px;
            margin-top: 20px;
            width: 100%;
            margin-bottom: 40px;
        }

        .setMainContent {
            margin-top: 0px;
            margin-left: 0px;
            background-color: #EFF6F9;
        }

        .setNav {
            margin-left: 0px;
            margin-top: 0px;
            display: nine;
        }

        .skeletonDesign {
            margin-left: 0px;
        }

        .summaryDesign {
            background-color: #F1F3F9;
            width: 100%;
            height: 100%;
            margin-left: 0px;
            margin-top: 10px;
        }

        .design {
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-left: 0px;
            width: 100%;

        }

        .buttonDesign {
            margin-left: 330px;
            width: 318px;
            height: 60px;
            background-color: #072AC8;
            margin-bottom: 120px;
            radius: 30px;
            color: white;
        }
    }

    @media (min-width: 1201px) and (max-width: 1400px) {
        .skeletonDesign {
            margin-left: 0px;
        }

        .mainDesign {
            display: flex;
            flex-direction: column;
        }

        .textDesign {
            margin-left: 0px;
            margin-top: 50px;
        }

        .setMainContent {
            margin-top: 0px;
            margin-left: 50px;
            background-color: #EFF6F9;
        }

        .setNav {
            margin-left: 0px;
            margin-top: 0px;
            display: none;
        }

        .paymentDesign {
            margin-left: 0px;
            margin-top: -60px;
            width: 70vh;
            margin-bottom: 40px;
        }

        .setMainContent {
            margin-top: 0px;
            margin-left: 0px;
            background-color: #EFF6F9;
        }

        .setNav {
            margin-left: 0px;
            margin-top: 0px;
            display: none;
        }

        .skeletonDesign {
            margin-left: 0px;
            margin-top: 0px;
        }

        .summaryDesign {
            background-color: #F1F3F9;
            width: 30%;
            height: 50%;
            margin-left: 20px;
            margin-top: -60px;
        }

        .design {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            margin-left: 0px;
            width: 100%;

        }

        .buttonDesign {
            margin-left: 330px;
            width: 318px;
            height: 60px;
            background-color: #072AC8;
            margin-top: 1000px;
            margin-right: 0px;
            radius: 30px;
            color: white;
        }
    }

    @media (min-width: 1401px) and (max-width: 1600px) {
        .textDesign {
            margin-left: 0px;
            margin-top: 20px;
        }

        .mainDesign {
            display: flex;
            flex-direction: column;
        }

        .setMainContent {
            margin-top: 0px;
            margin-left: 100px;
            background-color: #EFF6F9;
        }

        .setNav {
            margin-left: 0px;
            margin-top: 0px;
            display: none;
        }

        .paymentDesign {
            margin-left: 0px;
            margin-top: 20px;
            width: 100%;
            margin-bottom: 40px;
        }

        .setMainContent {
            margin-top: 0px;
            margin-left: 0px;
            background-color: #EFF6F9;
        }

        .setNav {
            margin-left: 0px;
            margin-top: 0px;
            display: none;
        }

        .skeletonDesign {
            margin-left: 0px;
            margin-top: 0px;
        }

        .paymentDesign {
            margin-left: 0px;
            margin-top: 20px;
            width: 100%;
            margin-bottom: 40px;
        }

        .summaryDesign {
            background-color: #F1F3F9;
            width: 60%;
            height: 100%;
            margin-left: 20px;
            margin-top: 20px;
        }

        .design {
            display: flex;
            flex-direction: row-reverse;
            justify-content: center;
            margin-left: 0px;
            width: 100%;

        }

        .buttonDesign {
            margin-left: 330px;
            width: 518px;
            height: 60px;
            background-color: #072AC8;
            margin-top: 1000px;
            margin-right: -800px;
            radius: 30px;
            color: white;
        }
    }
</style>

@section('content')

    <body style="background: rgba(239, 246, 249, 1);">
        @include('core/base::layouts.partials.svg-icon')

        <div id="app">


            <main >

                <div class="skeletonDesign">
                    <div class="text-center textDesign">
                        <h2 class="text-primary">Thank you for choosing our services!</h2>
                        <p class=""> Please complete your payment below to continue.</p>
                    </div>

                    @if (auth('account')->check() && !auth('account')->user()->canPost())
                        <div class="container my-5">
                            <div class="alert alert-warning">{{ trans('plugins/job-board::package.add_credit_warning') }}
                                <a
                                    href="{{ route('public.account.packages') }}">{{ trans('plugins/job-board::package.add_credit') }}</a>
                            </div>
                        </div>
                        <br>
                    @endif

                    <div class="design row mt-30 px-5">

                        <div class="paymentDesign col-sm-6 mb-3 mb-sm-0">
                            @yield('content')


                            <form action="{{ route('payments.checkout') }}" method="post" class="payment-checkout-form">
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
                                {{-- <div style="background-color: #EFF6F9;">
                                    <!-- <div class="text-center">
                            <button  class=" btn btn-info" data-processing-text="{{ __('Processing. Please wait...') }}" data-error-header="{{ __('Error') }}">{{ __('Checkout') }}</button>
                        </div> -->
                                    <div class="d-grid  buttonDesign rounded-pill" style="margin-top: 80px">

                                        <button class="btn   text-white payment-checkout-btn  checkAction"
                                            data-processing-text="{{ __('Processing. Please wait...') }}"
                                            data-error-header="{{ __('Error') }}">Proceed <i
                                                class="bi bi-arrow-right"></i></button>
                                    </div>


                                    <div class="d-flex flex-column justify-content-sm-center justify-content-md-center">
                                        <p class="text-wrap text-white" id="errorMessage">
                                            {{ __('Opps your credit is not sufficient . please recharge it.') }}</p>
                                    </div>
                                </div> --}}
                        </div>

                        <div class="card summaryDesign col-sm-6 mb-3 mb-sm-0" style="background: rgba(241, 243, 249, 1);">
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-center">Order Summary</h5>

                                <div class="px-1 border-bottom pb-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="py-1 text-black fw-bold">Service</p>
                                        <p class="fw-bold text-black">Price</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class=" text-black">Consultant Package</p>
                                        <p class="fw-bold text-black">$50</p>
                                    </div>
                                </div>

                                <div class="py-4 px-1">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class="py-1 text-black">Total</p>
                                        <p class="fw-bold text-black">$50</p>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center">
                                        <p class=" text-black">Payable Total</p>
                                        <p class="fw-bold text-black">$50</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div style="background-color: #EFF6F9;">
                            <!-- <div class="text-center">
                <button  class=" btn btn-info" data-processing-text="{{ __('Processing. Please wait...') }}" data-error-header="{{ __('Error') }}">{{ __('Checkout') }}</button>
            </div> -->
                            <div class="text-center px-5" style="margin-top: 50px; margin-bottom: 20px;">

                                <button class="btn btn-primary px-5 rounded-pill"
                                    data-processing-text="{{ __('Processing. Please wait...') }}"
                                    data-error-header="{{ __('Error') }}">Proceed <i
                                        class="bi bi-arrow-right"></i></button>
                            </div>


                            <div class="d-flex flex-column justify-content-sm-center justify-content-md-center">
                                <p class="text-wrap" id="errorMessage">
                                    {{ __('Opps your credit is not sufficient . please recharge it.') }}</p>
                            </div>
                        </div>

                    </div>


                </div>
        </div>
        </form>


        </main>

        @if (is_plugin_active('language'))
            @php
                $supportedLocales = Language::getSupportedLocales();
            @endphp

            @if ($supportedLocales && count($supportedLocales) > 1)
                @if (count(\Botble\Base\Supports\Language::getAvailableLocales()) > 1)
                    <footer>
                        <p>{{ __('Languages') }}:
                            @foreach ($supportedLocales as $localeCode => $properties)
                                <a rel="alternate" hreflang="{{ $localeCode }}"
                                    href="{{ Language::getSwitcherUrl($localeCode, $properties['lang_code']) }}"
                                    @if ($localeCode == Language::getCurrentLocale()) class="active" @endif>
                                    {!! language_flag($properties['lang_flag'], $properties['lang_name']) !!}
                                    <span>{{ $properties['lang_name'] }}</span>
                                </a> &nbsp;
                            @endforeach
                        </p>
                    </footer>
                @endif
            @endif
        @endif
        </div>

        @if (session()->has('status') ||
                session()->has('success_msg') ||
                session()->has('error_msg') ||
                (isset($errors) && $errors->count() > 0) ||
                isset($error_msg))
            <script type="text/javascript">
                window.noticeMessages = [];
                @if (session()->has('success_msg'))
                    noticeMessages.push({
                        'type': 'success',
                        'message': "{!! addslashes(session('success_msg')) !!}"
                    });
                @endif
                @if (session()->has('status'))
                    noticeMessages.push({
                        'type': 'success',
                        'message': "{!! addslashes(session('status')) !!}"
                    });
                @endif
                @if (session()->has('error_msg'))
                    noticeMessages.push({
                        'type': 'error',
                        'message': "{!! addslashes(session('error_msg')) !!}"
                    });
                @endif
                @if (isset($error_msg))
                    noticeMessages.push({
                        'type': 'error',
                        'message': "{!! addslashes($error_msg) !!}"
                    });
                @endif
                @if (isset($errors))
                    @foreach ($errors->all() as $error)
                        noticeMessages.push({
                            'type': 'error',
                            'message': "{!! addslashes($error) !!}"
                        });
                    @endforeach
                @endif
            </script>
        @endif

        <!-- Scripts -->
        <script src="{{ asset('vendor/core/plugins/job-board/js/app.js') }}"></script>

        {!! Assets::renderFooter() !!}
        @stack('scripts')
        @stack('footer')
    </body>

@stop
