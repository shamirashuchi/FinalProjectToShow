@switch($shortcode->style)
    @case('style-2')
        {{-- <section class="section-box top-companies" style="background-color: #AED1FD;">
            <div class="container">
                <div class="text-start mt-2">
                    <h4 class="section-title mb-10 wow animate__animated animate__fadeInUp">{!! BaseHelper::clean($shortcode->title) !!}</h4>
                </div>
            </div>
            <div class="container mt-1">
                <div class="row">
                    @foreach($companies as $company)
                        <div class="col-4 col-sm-3 col-md-2 col-lg-1">
                            <div class="card w-100 h-50">
                                <a href="{{ $company->url }}">
                                    <img src="{{ $company->logo_thumb }}" alt="{{ $company->name }}" class="card-img-top" style="width: 100%; height: 50px; object-fit: cover;">
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section> --}}
        @break
    @case('style-3')
        <section class="section-box mt-50 top-companies">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                    <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">{!! BaseHelper::clean($shortcode->description) !!}</p>
                </div>
            </div>
            <div class="container">
                <div class="box-swiper mt-50">
                    <div class="swiper-container swiper-group-1 swiper-style-2 swiper">
                        <div class="swiper-wrapper pt-5">
                            <div class="swiper-slide">
                                @foreach($companies as $company)
                                    <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                        <div class="item-logo">
                                            <a href="{{ $company->url }}">
                                                <div class="image-left">
                                                    <img alt="{{ $company->name }}" src="{{ $company->logo_thumb }}">
                                                </div>
                                                <div class="text-info-right">
                                                    <h4>{{ $company->name }}</h4>
                                                    @if(JobBoardHelper::isEnabledReview())
                                                        {!! Theme::partial('rating-star', ['star' => round($company->reviews_avg_star)]) !!}
                                                        <span class="font-xs color-text-mutted ml-10">
                                                            <span>
                                                                (</span><span>{{ $company->reviews_count }}</span><span>)
                                                            </span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </a>
                                            <div class="text-info-bottom mt-5">
                                                <span class="font-xs color-text-mutted icon-location location-label" title="{{ $company->state_name ? $company->state_name . ', ' : '' }} {{ $company->country->code }}">
                                                    {{ $company->state_name ? $company->state_name . ', ' : '' }} {{ $company->country->code }}
                                                </span>
                                                <span class="font-xs color-text-mutted float-end mt-5">
                                                    @include(Theme::getThemeNamespace('partials.job-count'), ['company' => $company])
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-next swiper-button-next-1"></div>
                    <div class="swiper-button-prev swiper-button-prev-1"></div>
                </div>
            </div>
        </section>
        @break
    @default
        <section class="section-box mt-50 top-companies">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                    <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">{!! BaseHelper::clean($shortcode->description) !!}</p>
                </div>
            </div>
            <div class="container">
                <div class="box-swiper mt-50">
                    <div class="swiper-container swiper-group-1 swiper-style-2 swiper">
                        <div class="swiper-wrapper pt-5">
                            <div class="swiper-slide">
                                @foreach($companies as $company)
                                    <div class="item-5 hover-up wow animate__animated animate__fadeIn">
                                        <div class="item-logo">
                                            <a href="{{ $company->url }}">
                                                <div class="image-left">
                                                    <img alt="{{ $company->name }}" src="{{ $company->logo_thumb }}">
                                                </div>
                                                <div class="text-info-right">
                                                    <h4>{{ $company->name }}</h4>
                                                    @if(JobBoardHelper::isEnabledReview())
                                                        {!! Theme::partial('rating-star', ['star' => round($company->reviews_avg_star)]) !!}
                                                        <span class="font-xs color-text-mutted ml-10">
                                                        <span>
                                                            (</span><span>{{ $company->reviews_count }}</span><span>)
                                                        </span>
                                                    </span>
                                                    @endif
                                                </div>
                                            </a>
                                            <div class="text-info-bottom mt-5">
                                                <span class="font-xs color-text-mutted icon-location location-label" title="{{ $company->state_name ? $company->state_name . ', ' : '' }} {{ $company->country->code }}">
                                                    {{ $company->state_name ? $company->state_name . ', ' : '' }} {{ $company->country->code }}
                                                </span>
                                                <span class="font-xs color-text-mutted float-end mt-5">
                                                    @include(Theme::getThemeNamespace('partials.job-count'), ['company' => $company])
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if($companies->count() > 15)
                        <div class="swiper-button-next swiper-button-next-1"></div>
                        <div class="swiper-button-prev swiper-button-prev-1"></div>
                    @endif
                </div>

            </div>


        </section>
        @break
@endswitch
