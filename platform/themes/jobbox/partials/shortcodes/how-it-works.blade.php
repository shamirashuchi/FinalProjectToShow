<section class="section-box mt-70 mb-40">
    <div class="container pt-20">
        {{-- <div class="text-start">
            <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">
                {!! BaseHelper::clean($shortcode->title) !!}
            </h2>
            <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">
                {!! BaseHelper::clean($shortcode->description) !!}
            </p>
        </div>
        <div class="mt-70">
            <div class="row">
                @for($i = 1; $i <= 3; $i++)
                    @php
                        $label = $shortcode->{'step_label_' . $i};
                        $help = $shortcode->{'step_help_' . $i}
                    @endphp
                    @if($label && $help)
                        <div class="col-lg-4">
                            <div class="box-step step-{{ $i }}">
                                <h1 class="number-element">{{ $i }}</h1>
                                <h4 class="mb-20">{!! BaseHelper::clean($label) !!}</h4>
                                <p class="font-lg color-text-paragraph-2">{!! BaseHelper::clean($help) !!}</p>
                            </div>
                        </div>
                    @endif
                @endfor
            </div>
        </div>
        @if($shortcode->button_label && $shortcode->button_url)
            <div class="mt-50 text-center">
                <a href="{{ $shortcode->button_url }}" class="btn btn-default">{{ $shortcode->button_label }}</a>
            </div>
        @endif --}}




            <div>
                <h2 class="text-center wow animate__animated animate__fadeInUp">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                <p class="text-center pt-40 text-justify-custom wow animate__animated animate__fadeInUp" style="text-align: justify;">{!! BaseHelper::clean($shortcode->description) !!}</p>
            </div>

            <div class="row pt-50 px-5">
                <div class="card-group hole-card">
                    <h1 class="card-one-first">1</h1>
                    <div class="card no-hover rounded-4 card-color-range-first"
                        style="border: none; background: rgba(167, 218, 231, 1);">
                        <div class="card-body">
                            <h5 class="text-center card-one-second">Get Registered</h5>
                            <p class="text-center card-one-third">Register quick and login with your details.</p>
                        </div>
                    </div>
                    <h1 class="card-two-first">2</h1>
                    <div class="card no-hover rounded-4 card-color-range-second"
                        style="border: none; background: rgba(167, 218, 231, 1);">
                        <div class="card-body">
                            <h5 class="text-center card-two-second">Update Profile</h5>
                            <p class="text-center card-two-third">Employer, Jobseekers or Consultants, go to dashboard and
                                update your profile with appropriate details.</p>
                        </div>
                    </div>
                    <h1 class="card-three-first">3</h1>
                    <div class="card no-hover rounded-4 card-color-range-third"
                        style="border: none; background: rgba(167, 218, 231, 1);">
                        <div class="card-body">
                            <h5 class="text-center card-three-second">Unlock Opportunities</h5>
                            <p class="text-center card-three-third">Dive in to the sea of opportunities - we will guide you to
                                your destined position.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <img src="https://mamtaz.com/storage/covers/freepik-character-1-inject-26.png" alt=""
                    class="corner-image img-fluid">
            </div>
        </div>

        <style>
            .corner-image {
                width: 11%;
                height: auto;
                margin-top: -162px;
                margin-left: 70px;
                transform: translateX(-1%);
            }

            .card-group {
                display: flex;
                gap: 30px;
            }

            .no-hover {
                border: none;
                box-shadow: none;
                transition: none;
            }

            .no-hover:hover {
                box-shadow: none;
                transform: none;
                background-color: inherit;
            }

            .card-one-first {
                position: relative;
                top: -25px;
                right: -75px;
                z-index: 1;
            }

            .card-one-second {
                position: relative;
                top: 0px;
                right: 10px;
                z-index: 1;
            }

            .card-one-third {
                position: relative;
                top: 25px;
                right: 10px;
                z-index: 1;
            }

            .card-color-range-first {
                height: 150px;
                width: auto;
            }

            .card-two-first {
                position: relative;
                top: -25px;
                right: -87px;
                z-index: 1;
            }

            .card-two-second {
                position: relative;
                top: 0px;
                right: 10px;
                z-index: 1;
            }

            .card-two-third {
                position: relative;
                top: 25px;
                right: 10px;
                z-index: 1;
            }

            .card-color-range-second {
                height: 270px;
                width: auto;
            }

            .card-three-first {
                position: relative;
                top: -25px;
                right: -90px;
                z-index: 1;
            }

            .card-three-second {
                position: relative;
                top: 0px;
                right: 10px;
                z-index: 1;
            }

            .card-three-third {
                position: relative;
                top: 25px;
                right: 10px;
                z-index: 1;
            }

            .card-color-range-third {
                height: 180px;
                width: auto;
            }


            @media (max-width: 1399.98px) {
                .corner-image {
                    margin-top: -155px;
                    margin-left: 77px;
                }

                .card-color-range-third {
                    height: 225px;
                    width: auto;
                }
            }

            @media (max-width: 1199.98px) {
                .corner-image {
                    margin-top: -200px;
                    margin-left: 83px;
                }

                .card-color-range-first {
                    height: 200px;
                    width: auto;
                }

                .card-color-range-second {
                    height: 370px;
                    width: auto;
                }

                .card-color-range-third {
                    height: 320px;
                    width: auto;
                }
            }

            @media (max-width: 991.98px) {
                .corner-image {
                    display: none;
                }

                .hole-card {
                    margin-top: -90px;
                    display: flex;
                    flex-direction: column;
                    justify-content: center;
                }

                .card-group {
                    gap: 0px;
                }

                .card-one-first {
                    top: 47px;
                    right: -75px;
                }

                .card-two-first {
                    top: 47px;
                    right: -75px;
                }

                .card-three-first {
                    top: 47px;
                    right: -75px;
                }

                .card-color-range-second {
                    height: 335px !important;
                    width: auto;
                    background-color: lightblue;
                }

                .card-color-range-third {
                    height: 335px !important;
                    width: auto;
                    background-color: lightblue;
                }
            }

            @media (max-width: 767.98px) {
                .card-color-range-second {
                    height: 380px !important;
                    width: auto;
                }
            }

            @media (max-width: 575.98px) {
                .card-color-range-second {
                    height: 215px !important;
                    width: auto;
                }

                .card-color-range-third {
                    height: 215px !important;
                    width: auto;
                }
            }



        </style>
    </div>
</section>
