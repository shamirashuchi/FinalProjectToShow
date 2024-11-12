@switch($shortcode->style)

    @case('style-2')
        <section class="section-box mt-50">
            <div class="container">
                <div class="text-start">
                    <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                    <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">{!! BaseHelper::clean($shortcode->description) !!}</p>
                </div>
                <div class="container">
                    <div class="row mt-50">
                        @foreach($cities->chunk(3) as $cityLists)
                            @foreach($cityLists as $city)
                                @php($cityUrl = JobBoardHelper::getJobsPageURL() . '?city_id=' . $city->id)
                                <div class="col-xl-{{ 3 + $loop->index }} col-lg-{{ 3 + $loop->index }} col-md-5 col-sm-12 col-12">
                                    <div class="card-image-top hover-up">
                                        <a href="{{ $cityUrl }}" aria-label="{{ $city->name }}">
                                            <div class="image" style="background-image: url({{ $city->getMetaData('city_image', true) ? RvMedia::getImageUrl($city->getMetaData('city_image', true)) : Theme::asset()->url('imgs/page/homepage1/location1.png')}});"></div>
                                        </a>
                                        <div class="informations">
                                            <a href="{{ $cityUrl }}">
                                                <div class="h5 fw-bold">{{ ($city->name) }}, {{ $city->country->name }}</div>
                                            </a>
                                            <div class="row">
                                                <div class="col-lg-6 col-6">
                                                    <span class="text-14 color-text-paragraph-2">
                                                        @if($city->companies_count > 1)
                                                            {{ __(':count companies', ['count' => $city->companies_count]) }}
                                                        @elseif($city->companies_count === 1)
                                                            {{ __(':count company', ['count' => $city->companies_count]) }}
                                                        @else
                                                            {{ __('No company') }}
                                                        @endif
                                                    </span>
                                                </div>
                                                <div class="col-lg-6 col-6 text-end">
                                                    <span class="color-text-paragraph-2 text-14">
                                                        @if($city->jobs_count > 1)
                                                            {{ __(':count jobs', ['count' => $city->jobs_count]) }}
                                                        @elseif($city->jobs_count === 1)
                                                            {{ __(':count job', ['count' => $city->jobs_count]) }}
                                                        @else
                                                            {{ __('No job') }}
                                                        @endif
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
        @break
    @default
        <section class="section-box mt-50 job-by-location">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title mb-10 wow animate__animated animate__fadeInUp">{!! BaseHelper::clean($shortcode->title) !!}</h2>
                    <p class="font-lg color-text-paragraph-2 wow animate__animated animate__fadeInUp">{!! BaseHelper::clean($shortcode->description) !!}</p>
                </div>
            </div>
            <div class="container">
                <div class="row mt-50">
                    @php($gridClasses = [[3, 4, 5, 4, 5, 3], [5, 7, 7, 5, 7, 5]])
                    @foreach($cities as $city)
                        <div class="col-xl-{{  $gridClasses[0][$loop->index] }} col-lg-{{ $gridClasses[0][$loop->index] }} col-md-{{ $gridClasses[1][$loop->index] }} col-sm-12 col-12">
                            <div class="card-image-top hover-up">
                                <a href="{{ JobBoardHelper::getJobsPageURL() . '?city_id=' . $city->id }}" aria-label="{{ $city->name }}">
                                    <div class="image" style="background-image: url({{ $city->getMetaData('city_image', true) ? RvMedia::getImageUrl($city->getMetaData('city_image', true)) : Theme::asset()->url('imgs/page/homepage1/location1.png')}});"></div>
                                </a>
                                <div class="informations">
                                    <a href="{{ JobBoardHelper::getJobsPageURL() . '?city_id=' . $city->id }}">
                                        <div class="h5 fw-bold">{{ ($city->name) }}, {{ $city->country->name }}</div>
                                    </a>
                                    <div class="row">
                                        <div class="col-lg-6 col-6">
                                            <span class="text-14 color-text-paragraph-2">
                                                @if($city->companies_count > 1)
                                                    {{ __(':count companies', ['count' => $city->companies_count]) }}
                                                @elseif($city->companies_count === 1)
                                                    {{ __(':count company', ['count' => $city->companies_count]) }}
                                                @else
                                                    {{ __('No company') }}
                                                @endif
                                            </span>
                                        </div>
                                        <div class="col-lg-6 col-6 text-end">
                                            <span class="color-text-paragraph-2 text-14">
                                                @if($city->jobs_count > 1)
                                                    {{ __(':count jobs', ['count' => $city->jobs_count]) }}
                                                @elseif($city->jobs_count === 1)
                                                    {{ __(':count job', ['count' => $city->jobs_count]) }}
                                                @else
                                                    {{ __('No job') }}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        @break
@endswitch
