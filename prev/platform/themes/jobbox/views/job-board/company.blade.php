@php
    Theme::asset()->usePath()->add('leaflet-css', 'plugins/leaflet/leaflet.css');
    Theme::asset()->container('footer')->usePath()->add('leaflet-js', 'plugins/leaflet/leaflet.js');
    Theme::asset()->container('footer')->usePath()->add('markercluster-src-js', 'plugins/leaflet/leaflet.markercluster-src.js');
    Theme::asset()->container('footer')->usePath()->add('slider-js', 'js/company-detail.js');
    Theme::asset()->usePath()->add('css-bar-rating', 'css/rating/css-stars.css');
    Theme::asset()->container('footer')->usePath()->add('jquery-bar-rating-js', 'plugins/jquery-bar-rating/jquery.barrating.min.js');
    Theme::set('pageTitle', $company->name);
@endphp

<section class="section-box-2 company-detail">
    <div class="container">
        <div class="banner-hero banner-image-single">
            <img src="{{ $company->cover_image_url }}" alt="{{ $company->name }}"></div>
        <div class="box-company-profile">
            <div class="image-company">
                <img src="{{ $company->logo_thumb }}" class="img-fluid" alt="{{ $company->name }}">
            </div>
            <div class="row mt-10">
                <div class="col-lg-8 col-md-12">
                    <h5 class="f-18">
                        {{ $company->name }}
                        <span class="card-location font-regular ml-20">{{ $company->state_name }}, {{ $company->country_name }}</span>
                    </h5>
                    <p class="mt-5 font-md color-text-paragraph-2 mb-15">{{ $company->description }}</p>
                </div>
                <div class="col-lg-4 col-md-12 text-lg-end">
                    @if($company->phone)
                        <a class="btn btn-call-icon btn-apply btn-apply-big" href="tel:{{ $company->phone }}">
                            {{ __('Contact Us') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <div class="border-bottom pt-10 pb-10"></div>
    </div>
</section>
<section class="section-box mt-50 company-detail-job-list">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12 col-12">
                <div class="content-single">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-about" role="tabpanel" aria-labelledby="tab-about">
                            <h4>{{ __('Welcome to :company_name', ['company_name' => $company->name]) }}</h4>
                            {!! BaseHelper::clean($company->content) !!}
                        </div>
                    </div>
                </div>

                <div class="box-related-job content-page box-list-jobs">
                    @include(Theme::getThemeNamespace('views.job-board.partials.company-job-items'), ['jobs' => $jobs])
                </div>

                @if($company->reviews_count > 0)
                    <div class="mt-4 pt-3 position-relative review-listing">
                        <h6 class="fs-17 fw-semibold mb-3">{{ __(":company's Reviews", ['company' => $company->name]) }}</h6>
                        <div class="spinner-overflow"></div>
                        <div class="half-circle-spinner" style="display: none;position: absolute;top: 70%;left: 50%;">
                            <div class="circle circle-1"></div>
                            <div class="circle circle-2"></div>
                        </div>
                        <div class="review-list">
                            @include(Theme::getThemeNamespace('views.job-board.partials.review-load'), ['reviews' => $company->reviews])
                        </div>
                    </div>
                @endif

                <form action="{{ route('public.reviews.create') }}" method="post" class="company-review-form mt-4 pt-3">
                    @csrf
                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                    <h6 class="fs-17 fw-semibold mb-2">{{ __('Reviews for :company', ['company' => $company->name]) }}</h6>
                    @guest('account')
                        <p class="text-danger my-3">
                            {!! BaseHelper::clean(__('Please <a href=":route">login</a> to write review!', ['route' => route('public.account.login')])) !!}
                        </p>
                    @endguest
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <select name="star" class="rating" data-read-only="false">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5" selected>5</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="review" class="form-label">{{ __('Review') }}</label>
                                <textarea class="form-control" id="review" name="review" @disabled(! $canReviewCompany) rows="5" placeholder="{{ __('Add your review') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-hover" @disabled(! $canReviewCompany)>
                            {{ __('Submit Review') }}
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 col-12 pl-40 pl-lg-15 mt-lg-30">
                <div class="sidebar-border">
                    <div class="sidebar-heading">
                        <div class="avatar-sidebar">
                            <div class="sidebar-info pl-0">
                                <span class="sidebar-company mb-2">{{ $company->name }}</span>
                                {!! Theme::partial('rating-star', ['star' => round($company->reviews_avg_star)]) !!}
                                <span class="font-xs color-text-mutted ml-10">
                                    <span>(</span>
                                    <span>{{ $company->reviews_count }}</span>
                                    <span>)</span>
                                </span>
                                <span class="card-location">{{ $company->location }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="sidebar-list-job">
                        @if($company->latitude && $company->longitude)
                            <div class="box-map job-board-street-map-container">
                                <div class="job-board-street-map"
                                     data-popup-id="#street-map-popup-template"
                                     data-center="{{ json_encode([$company->latitude, $company->longitude]) }}"
                                     data-map-icon="{{ $company->name }}"
                                     style="height: 150px"
                                ></div>
                            </div>
                            <div class="d-none" id="street-map-popup-template">
                                <div>
                                    <table width="100%">
                                        <tr>
                                            <td width="40" class="image-company-sidebar">
                                                <div>
                                                    <img src="{{ $company->logo_thumb }}" width="40" alt="{{ $company->name }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="infomarker">
                                                    <h5>
                                                        <a href="{{ $company->url }}" target="_blank">{{ $company->name }}</a>
                                                    </h5>
                                                    <div class="text-info">
                                                        <i class="mdi mdi-account"></i>
                                                        <span>{{ __(':number Employees', ['number' => $company->number_of_employees])}}</span>
                                                    </div>
                                                    @if ($company->full_address)
                                                        <div class="text-muted">
                                                            <i class="uil uil-map"></i>
                                                            <span>{{ $company->full_address }}</span>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="sidebar-list-job">
                        <ul>
                            <li>
                                <div class="sidebar-icon-item">
                                    <i class="fi-rr-clock"></i>
                                </div>
                                <div class="sidebar-text-info">
                                    <span class="text-description">{{ __('Year founded') }}</span>
                                    <strong class="small-heading">{{ $company->year_founded }}</strong>
                                </div>
                            </li>
                            @if($company->website)
                                <li>
                                    <div class="sidebar-icon-item"><i class="fi-rr-globe"></i></div>
                                    <div class="sidebar-text-info">
                                        <span class="text-description">{{ __('Website') }}
                                        </span>
                                        <a href="{{ $company->website }}">
                                            <strong class="small-heading">{{ $company->website }}</strong>
                                        </a>
                                    </div>
                                </li>
                            @endif
                            @if(count($jobs) > 0)
                                <li>
                                    <div class="sidebar-icon-item">
                                        <i class="fi-rr-time-fast"></i>
                                    </div>
                                    <div class="sidebar-text-info">
                                        <span class="text-description">{{ __('Last Jobs Posted') }}</span>
                                        <strong class="small-heading">{{ $jobs->first()->created_at->diffForHumans() }}</strong>
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="sidebar-list-job">
                        <ul class="ul-disc">
                            <li>{{ $company->address }}</li>
                            @if($company->phone)
                                <li>{{ __('Phone: :phone', ['phone' => $company->phone]) }}</li>
                            @endif
                            @if($company->email)
                                <li>{{ __('Email: :email', ['email' => $company->email]) }}</li>
                            @endif

                        </ul>
                        <div class="text-center mt-30">
                            @if($company->facebook)
                                <a href="{{ $company->facebook }}" class="share-facebook social-share-link"></a>
                            @endif
                            @if($company->twitter)
                                <a href="{{ $company->twitter }}" class="share-twitter social-share-link"></a>
                            @endif
                            @if($company->linkedin)
                                <a href="{{ $company->linkedin }}" class="share-linkedin social-share-link"></a>
                            @endif
                            @if($company->instagram)
                                <a href="{{ $company->instagram }}" class="share-instagram social-share-link"></a>
                            @endif
                        </div>

                        <div class="mt-30">
                            @if($company->email)
                                <a class="btn btn-send-message" href="mailto:{{ $company->email }}">{{ __('Send Message') }}</a>
                            @endif
                        </div>
                    </div>
                </div>
                {!! dynamic_sidebar('company_sidebar') !!}
            </div>
        </div>
    </div>

    {!! Form::open(['url' => $company->url, 'method' => 'GET', 'id' => 'job-pagination-form']) !!}
    <input type="hidden" name="page" value="{{ BaseHelper::stringify(request()->query('page')) }}">
    {!! Form::close() !!}
</section>
