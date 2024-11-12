@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))
<style>
    .giveBorder {
        border: 1px solid #05264E;
        border-radius: 10px;
        margin-bottom: 15px;
        padding: 15px;
    }

    .giveMargin {
        padding-bottom: -10px;
    }

    .custom-negative-margin {
        margin-left: 260px;
        margin-top: -16px;
        transform: translateX(100px) translateY(-10px);
    }

    .custom-negative-end {
        margin-left: -90px;
        margin-top: -1px;
        transform: translateX(0px) translateY(10px);
        color: white;
    }

    @media (min-width: 320px) and (max-width: 480px) {
        .giveBorder {
            border: 1px solid #05264E;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .giveMargin {
            margin-bottom: -10px;
            margin-top: 10px;

        }

        .custom-negative-margin {
            margin-left: 60px !important;
            margin-top: -26px !important;
            transform: translateX(100px) translateY(-10px);
        }


        .custom-negative-end {
            position: absolute;
            margin-left: -85px !important;
            margin-top: 0px !important;
            transform: translateX(0px) translateY(10px);
            color: white !important;
        }
    }


    @media (min-width: 481px) and (max-width: 768px) {
        .giveBorder {
            border: 1px solid #05264E;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .giveMargin {
            margin-bottom: -10px;
            margin-top: 10px;

        }

        .custom-negative-margin {
            margin-left: 230px !important;
            margin-top: -26px !important;
            transform: translateX(100px) translateY(-10px);

        }

        .custom-negative-end {
            position: absolute;
            margin-left: -85px !important;
            margin-top: -1px !important;
            transform: translateX(0px) translateY(10px);
            color: white !important;
        }
    }

    @media (min-width: 769px) and (max-width: 1024px) {
        .giveBorder {
            border: 1px solid #05264E;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .giveMargin {
            margin-bottom: -10px;
            margin-top: 10px;

        }

        .custom-negative-margin {
            margin-left: 140px !important;
            margin-top: -27px !important;
            transform: translateX(100px) translateY(-10px);

        }

        .custom-negative-end {
            position: absolute;
            margin-left: -85px !important;
            margin-top: 0px !important;
            color: white !important;
            transform: translateX(0px) translateY(10px);
        }


    }

    @media (min-width: 1025px) and (max-width: 1200px) {
        .giveBorder {
            border: 1px solid #05264E;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .giveMargin {
            margin-bottom: -10px;
            margin-top: 10px;

        }

        .custom-negative-margin {
            margin-left: 100px !important;
            margin-top: -27px !important;
            transform: translateX(100px) translateY(-10px);

        }

        .custom-negative-end {
            position: absolute;
            margin-left: -90px !important;
            margin-top: 0px !important;
            color: white !important;
            transform: translateX(0px) translateY(10px);
        }


    }

    @media (min-width: 1201px) and (max-width: 1400px) {
        .giveBorder {
            border: 1px solid #05264E;
            border-radius: 10px;
            margin-bottom: 20px;
            padding: 15px;
        }

        .giveMargin {
            margin-bottom: -10px;
            margin-top: 10px;

        }

        .custom-negative-margin {
            margin-left: 60px !important;
            margin-top: -27px !important;
            transform: translateX(100px) translateY(-10px);

        }

        .custom-negative-end {
            position: absolute;
            margin-left: -90px !important;
            margin-top: 0px !important;
            color: white !important;
            transform: translateX(0px) translateY(10px);
        }


    }
</style>
@section('content')

    <div class="card-body setwidth">
        <div class=" position-relative row ">
            @foreach ($packages as $package)
                <div class="col-lg-4  col-md-6 col-sm-12">
                    <div class="giveBorder">
                        <div class="col giveMargin">
                            <div class="card">
                                @if ($package->percent_save)
                                    <div class="position-absolute  custom-negative-margin badge   z-index-9">
                                        <svg class="position-relative" width="100" height="33" viewBox="0 0 165 33"
                                            fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 0H165L134 16.5L165 33H0V0Z" fill="#FA0202" />
                                        </svg>
                                        <span class="position-absolute custom-negative-end   z-index-10">
                                            {{ $package->percent_save_text }}
                                            <span
                                                class="visually-hidden">{{ trans('plugins/job-board::dashboard.save') }}</span>
                                        </span>
                                    </div>
                                @endif





                                <div class="panel-head background-header-packages justify-content-center align-items-center"
                                    style="background-image: linear-gradient(to right, #153ce7, #0E2DB5, #031562);padding: 80px 0;text-align: center;">
                                    <h4 class="card-title text-white">Basic</h4>
                                    <h4 class="card-title" style="color: #FFFE3A">{{ $package->name }}</h4>
                                    @if ($package->price)
                                        <p class="mt-5" style="color: #99A8E9">{{ $package->price_per_job_text }}</p>
                                    @else
                                        <p class="mt-5" style="color: #99A8E9">{{ $package->number_jobs_free }}</p>
                                    @endif
                                </div>
                                <div class="panel-body text-center">
                                    <div class="card-text text-muted">
                                        {{-- <p>{{ $package->price_text_with_sale_off }}</p> --}}
                                        <div style="background-color: #F0F8FF; padding: 20px; border-radius: 8px;">
                                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                <span style="color: green; margin-right: 10px;">&#x2714;</span>
                                                <span style="font-size: 1rem; color: #0E2DB5; font-weight: bold;">Verified
                                                    profile
                                                    placement</span>
                                            </div>
                                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                <span style="color: green; margin-right: 10px;">&#x2714;</span>
                                                <span style="font-size: 1rem; color: #0E2DB5; font-weight: bold;">Resume
                                                    review by
                                                    expert</span>
                                            </div>
                                            <div style="display: flex; align-items: center; margin-bottom: 10px;">
                                                <span style="color: green; margin-right: 10px;">&#x2714;</span>
                                                <span style="font-size: 1rem; color: #0E2DB5; font-weight: bold;">Job Match
                                                    algorithm</span>
                                            </div>
                                            <div style="display: flex; align-items:center;">
                                                <span style="color: green; margin-right: 5px;">&#x2714;</span>
                                                <span style="color: #0E2DB5;font-weight: bold;">Automated job
                                                    apply(Limited)</span>
                                            </div>
                                        </div>
                                        {!! Form::open([
                                            'route' => 'public.account.package.subscribe.put',
                                            'method' => 'PUT',
                                        ]) !!}
                                        {!! Form::hidden('id', $package->id) !!}
                                        <button type="submit" class="btn w-100 btn-primary rounded-5  mt-15"
                                            style="width:100%" {{ $package->isPurchased() ? 'disabled' : '' }}>
                                            {{ $package->isPurchased() ? __('Buy Now') : __('Buy Now') }}
                                        </button>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- col.// -->
            @endforeach

            <!-- row.// -->
        </div>
    </div>








    {{-- thank you for choosing our services pages --}}
    <!-- <div class="container py-5 border border-1" style="background-color: #EFF6F9;">
            <div class="text-center py-4">
                <h2 class="text-primary">Thank you for choosing our services!</h2>
                <p class="text-black"> Please complete your payment below to continue.</p>
            </div>

            <form action="">
                <div class="row px-5">
                    <div class="col-sm-6 mb-3 mb-sm-0" >
                      <div class="card" style="background-color: #F1F3F9;">
                        <div class="card-body">
                          <h5 class="card-title text-center fw-bold">Select Payment Method</h5>

                          <div class="px-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                                <label class="form-check-label text-black" for="flexRadioDefault1">
                                    Payment With Card
                                    <div class="row row-cols-1 row-cols-md-3 g-4 mt-2">
                                        <div class="col">
                                            <div class="card">
                                                <img src="https://via.placeholder.com/210x124" class="img-fluid" alt="...">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card">
                                                <img src="https://via.placeholder.com/210x124" class="img-fluid" alt="...">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="card">
                                                <img src="https://via.placeholder.com/210x124" class="img-fluid" alt="...">
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                          </div>

                          <div class="py-2">
                            <div class="form-check bg-white rounded">
                                <div class="bg-white rounded d-flex align-items-center px-2">
                                    <input class="form-check-input me-2" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                    <label class="form-check-label w-100" for="flexRadioDefault2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center text-black">
                                                Paypal
                                            </div>
                                            <div class="text-end">
                                                <img src="https://via.placeholder.com/142x58" class="img-fluid" alt="Paypal">
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="py-2">
                            <div class="form-check bg-white rounded">
                                <div class="bg-white rounded d-flex align-items-center px-2">
                                    <input class="form-check-input me-2" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked>
                                    <label class="form-check-label w-100" for="flexRadioDefault2">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="d-flex align-items-center text-black">
                                                Bank Transfer
                                            </div>
                                            <div class="text-end">
                                                <img src="https://via.placeholder.com/142x58" class="img-fluid" alt="Paypal">
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-sm-6">
                      <div class="card" style="background-color: #F1F3F9;">
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
                    </div>

                    <div class="d-grid gap-2 col-2 mx-auto py-3">
                        <button class="btn btn-primary rounded-pill" type="button">Proceed <i class="bi bi-arrow-right"></i></button>
                      </div>

                  </div>
            </form>

        </div> -->







    @if (auth('account')->user()->transactions()->exists())
        <h4 class="with-actions my-3">{{ trans('plugins/job-board::dashboard.transactions_title') }}</h4>
        <payment-history-component url="{{ route('public.account.ajax.transactions') }}"></payment-history-component>
    @endif
@stop
