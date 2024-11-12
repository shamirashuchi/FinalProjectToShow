@switch($shortcode->style)
    @case('style-2')
        <div class="bg-homepage1"></div>
        <section class="section-box">
            <div class="banner-hero hero-2"
                @if ($shortcode->background_image) style="background: url({{ RvMedia::getImageUrl($shortcode->background_image) }}) no-repeat top center;" @endif>
                <div class="banner-inner">
                    <div class="block-banner">
                        <h1 class="text-42 color-white wow animate__animated animate__fadeInUp">
                            {!! BaseHelper::clean(
                                str_replace(
                                    $shortcode->highlight_text,
                                    '<span class="color-green">' . $shortcode->highlight_text . '</span>',
                                    $shortcode->title,
                                ),
                            ) !!}
                        </h1>
                        <div class="font-lg font-regular color-white mt-20 wow animate__animated animate__fadeInUp"
                            data-wow-delay=".1s">
                            {!! BaseHelper::clean($shortcode->description) !!}
                        </div>
                        {!! Theme::partial('job-search-box', [
                            'withCategories' => true,
                            'trendingKeywords' => $shortcode->trending_keywords,
                        ]) !!}
                    </div>
                    <div class="mt-60">
                        <div class="row">
                            @for ($i = 1; $i <= 4; $i++)
                                @if ($shortcode->{'counter_title_' . $i})
                                    <div class="col-lg-3 col-sm-3 col-6 text-center mb-20">
                                        <div class="d-inline-block text-start">
                                            <h4 class="color-white">
                                                <span class="count">
                                                    {!! BaseHelper::clean($shortcode->{'counter_number_' . $i}) !!}
                                                </span>
                                            </h4>
                                            <p class="font-sm color-text-mutted" style="color:#ffffff;">
                                                {{ $shortcode->{'counter_title_' . $i} }}</p>
                                        </div>
                                    </div>
                                @endif
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="list-brands mt-40 mb-30">
                    <div class="box-swiper">
                        <div class="swiper-container swiper-group-9 swiper">
                            <div class="swiper-wrapper">
                                @foreach ($featureCompanies as $featureCompany)
                                    <div class="swiper-slide">
                                        <a href="{{ $featureCompany->url }}">
                                            <img src="{{ RvMedia::getImageUrl($featureCompany->logo_thumb) }}"
                                                alt="{{ $featureCompany->name }}">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @break

    @case('style-3')
        <section class="section-box">
            <div class="banner-hero hero-2 hero-3" style="background-color: #05264E">
                <div class="banner-inner">
                    <div class="block-banner">
                        <h1 class="text-42 wow animate_animated animate_fadeInUp text-warning">
                            {{-- {!! BaseHelper::clean(
                                '<span class="text-warning">' .
                                    preg_replace(
                                        '/' . preg_quote($shortcode->highlight_text, '/') . '/',
                                        '<span class="text-white">' . $shortcode->highlight_text . '</span>',
                                        $shortcode->title,
                                    ) .
                                    '</span>',
                            ) !!} --}}
                            Find your <span class="text-white">Next Job </span>here
                        </h1>
                        <div class="font-lg font-regular color-white  mt-20 mb-30 wow animate_animated animate_fadeInUp"
                            data-wow-delay=".1s">
                            <span class="text-warning">
                                {{-- {!! BaseHelper::clean($shortcode->description) !!} --}}
                                When employers don’t respond, it’s natural to doubt yourself. However, it’s not about your skills or qualifications. It simply means the right opportunity hasn’t come along yet. Keep applying—there’s an employer out there looking for someone just like you.
                            </span>

                        </div>

                        {!! Theme::partial('job-search-box', [
                            'withCategories' => true,
                            'trendingKeywords' => $shortcode->trending_keywords,
                        ]) !!}
                    </div>
                </div>

                {{-- {{ $category->name }} --}}
                <div class="container mt-60">
                    <div class="box-swiper mt-50">
                        <div class="swiper-container swiper-group-5 swiper">
                            <div class="swiper-wrapper pb-25 pt-5">
                                @foreach ($categories as $category)
                                    <div class="swiper-slide hover-up">
                                        <a href="{{ $category->url }}">
                                            <div class="item-logo">
                                                <div class="image-left">
                                                    <img alt=""
                                                        src="{{ RvMedia::getImageUrl($category->getMetadata('icon_image', true)) }}">
                                                </div>
                                                <div class="text-info-right">
                                                    <h4>{!! BaseHelper::clean($category->name) !!}</h4>
                                                    <p class="font-xs">
                                                        {!! BaseHelper::clean(__(':count <span>Jobs Available</span>', ['count' => $category->jobs_count])) !!}
                                                    </p>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="swiper-pagination swiper-pagination-style-border"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @break

    @case('style-4')
        <section class="section-box mb-70">
            <div class="banner-hero hero-1 banner-homepage6">
                <div class="banner-inner">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="block-banner text-center pb-40 pt-40">
                                <h1 class="heading-banner pl-180 pr-180 wow animate__ animate__fadeInUp animated">
                                    {!! BaseHelper::clean(
                                        str_replace(
                                            $shortcode->highlight_text,
                                            '<span class="color-brand-2">' . $shortcode->highlight_text . '</span>',
                                            $shortcode->title,
                                        ),
                                    ) !!}
                                </h1>
                                <p class="font-lg color-text-paragraph mt-20">{!! BaseHelper::clean($shortcode->description) !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="box-search-2">
                        <div class="block-banner form-none-shadow">
                            {!! Theme::partial('job-search-box', [
                                'withCategories' => true,
                                'style' => $shortcode->style,
                                'trendingKeywords' => $shortcode->trending_keywords,
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @break

    @case('style-5')
        <section class="section-box mb-70">
            <div class="banner-hero hero-1 banner-homepage5">
                <div class="banner-inner">
                    <div class="row">
                        <div class="col-xl-7 col-lg-12">
                            <div class="block-banner">
                                <h1 class="heading-banner wow animate__animated animate__fadeInUp">
                                    {!! BaseHelper::clean($shortcode->title) !!}
                                </h1>
                                <div class="banner-description mt-20 wow animate__animated animate__fadeInUp"
                                    data-wow-delay=".1s">
                                    {!! BaseHelper::clean($shortcode->description) !!}
                                </div>
                                <div class="mt-30">
                                    @if ($shortcode->primary_button_url && $shortcode->primary_button_label)
                                        <a href="{{ $shortcode->primary_button_url }}"
                                            class="btn btn-default mr-15">{{ $shortcode->primary_button_label }}</a>
                                    @endif
                                    @if ($shortcode->secondary_button_url && $shortcode->secondary_button_label)
                                        <a href="{{ $shortcode->secondary_button_url }}"
                                            class="btn btn-border-brand-2">{{ $shortcode->secondary_button_label }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-12 d-none d-xl-block col-md-6">
                            <div class="banner-imgs">
                                @for ($i = 1; $i <= 6; $i++)
                                    <div class="banner-{{ $i }} shape-1">
                                        <img class="img-responsive" alt="{{ $i }}"
                                            src="{{ RvMedia::getImageUrl($shortcode->{'banner_image_' . $i}) }}">
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div class="box-search-2">
                        <div class="block-banner">
                            {!! Theme::partial('job-search-box', [
                                'withCategories' => true,
                                'trendingKeywords' => $shortcode->trending_keywords,
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @break

    @default
        <div class="bg-homepage1"></div>
        <section class="section-box">
            <div style="width: 100%; background: linear-gradient(rgba(48, 58, 105, 0.96), rgba(62, 131, 218, 0.85));"
                class="block-banner">
                <div class="banner-hero hero-1 color py-4">
                    <div class="row justify-content-center">
                        <div class="col-xl-10 col-lg-10 offset-xl-1 offset-lg-1">
                            <div class="text-center">
                                <div class="row">
                                    <div class="col pb-3">
                                        <h3 class="text-white" style="padding-top: 48px;">Millions of jobs are waiting - Find your dream jobs now</h3>
                                    </div>
                                </div>
                                <div>
                                    {!! Theme::partial('job-search-box', [
                                        'withCategories' => true,
                                        'trendingKeywords' => $shortcode->trending_keywords,
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div style="background: rgba(178, 213, 255, 0.71);" class="block-banner-bottom">
                <div class="banner-hero hero-1 color">
                    <div class="banner-inner">
                        <div class="row size align-items-center">
                            <div class="col-xl-7 col-lg-12 col-size">
                                <div class="block-banner" style="margin-top: 2.8125rem !important; margin-right: 0 !important; padding-right: 35px !important;">
                                    <h2 class="wow animate__animated animate__fadeInUp color-white">
                                        {!! BaseHelper::clean(
                                            'Excited to start your career? <span> Let our consultants guide you to your first job</span>',
                                        ) !!}
                                    </h2>
                                    {{-- <div class="banner-description mt-20 wow animate__animated animate__fadeInUp color-black"
                                        data-wow-delay=".1s">
                                        {!! BaseHelper::clean($shortcode->description) !!}
                                    </div> --}}
                                    <div class="d-flex flex-wrap justify-content-left mt-30" style="padding-right: 50px">
                                        <a href="{{ route('consultants') }}"
                                            class="btn rounded-pill text-white py-2 m-1  flex-fill text-center" style="background: rgba(5, 38, 78, 1)">
                                            Book Appointment
                                        </a>
                                        <a href="{{ route('consultants') }}"
                                            class="btn rounded-pill text-white py-2 m-1  flex-fill text-center" style="background: rgba(5, 38, 78, 1)">
                                            Skill Development
                                        </a>
                                        <a href="{{ route('consultants') }}"
                                            class="btn rounded-pill text-white py-2 m-1  flex-fill text-center" style="background: rgba(5, 38, 78, 1)">
                                            Hiring Assistance
                                        </a>
                                    </div>
                                    {{-- <div class="social-links d-flex justify-content-left mt-40">
                                        <a href="https://linkedin.com" class="mx-2">
                                            <img src="https://www.mamtaz.com/storage/covers/vector.png" class="img-fluid" style="width: 20px; height: 20px;">
                                        </a>
                                        <a href="https://google.com" class="mx-2">
                                            <img src="https://www.mamtaz.com/storage/covers/flat-color-icons-google.png" alt="Google" class="img-fluid" style="width: 24px; height: 24px;">
                                        </a>
                                        <a href="https://facebook.com" class="mx-2">
                                            <img src="https://www.mamtaz.com/storage/covers/logos-facebook.png" alt="Facebook" class="img-fluid" style="width: 24px; height: 24px;">
                                        </a>
                                    </div> --}}
                                </div>
                            </div>

                            <div class="col-xl-5 col-lg-12 d-none d-xl-block col-md-6 p-0">
                                <div style="margin-top: 7rem;">
                                    @if ($url = $shortcode->banner_image_1)
                                        <div class="block-1 shape-1 banner-top-image">
                                            <img style="width: 95%; height: auto; margin-top: -100px;" class="img-responsive img-fluid" alt="{{ $shortcode->banner_image_1 }}"
                                                src="{{ RvMedia::getImageUrl('https://www.mamtaz.com/storage/covers/group-39092.png') }}">
                                        </div>
                                    @endif
                                    @if ($url = $shortcode->banner_image_2)
                                        <div class="block-2 shape-2 banner-top-image">
                                            <img style="width: 95%; height: auto; margin-top: -100px;" class="img-responsive img-fluid" alt="{{ $shortcode->banner_image_2 }}"
                                                src="{{ RvMedia::getImageUrl('https://www.mamtaz.com/storage/covers/group-39092.png') }}">
                                        </div>
                                    @endif
                                    @if ($url = $shortcode->icon_top_banner)
                                        <div class="block-2 banner-top-image">
                                            <img style="width: 95%; height: auto; margin-top: -100px;" class="img-responsive img-fluid" alt="{{ $shortcode->icon_top_banner }}"
                                                src="{{ RvMedia::getImageUrl('https://www.mamtaz.com/storage/covers/group-39092.png') }}">
                                        </div>
                                    @endif
                                    @if ($url = $shortcode->icon_bottom_banner)
                                        <div class="block-4 shape-3 banner-top-image">
                                            <img style="width: 95%; height: auto; margin-top: -100px;" class="img-responsive img-fluid" alt="{{ $shortcode->icon_bottom_banner }}"
                                                src="{{ RvMedia::getImageUrl('https://www.mamtaz.com/storage/covers/group-39092.png') }}">
                                        </div>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>


        {{-- <section class="section-box top-companies" style="background-color: #AED1FD;">
            <div class="container">
                <div class="text-start mt-2">
                    <h4 class="section-title mb-10 wow animate__animated animate__fadeInUp">{!! BaseHelper::clean($shortcode->title) !!}</h4>
                </div>
            </div>
            <div class="container mt-1">
                <div class="row">
                    @foreach ($featureCompanies as $company)
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

            <div style="background: rgba(174, 209, 253, 0.36); padding-bottom: 40px !important;">
                <div class="container top-companies pt-2">
                    <div class="text-start">
                        <h4 class="section-title wow animate__animated animate__fadeInUp">Featured Company</h4>
                    </div>
                    <div class="container company">
                        <div class="row  g-2" style="margin-left: 181px; margin-right: -221px;">
                            @foreach ($featureCompanies as $company)
                                <div class="col-4 col-sm-3 col-md-2 col-lg-1 card-section">
                                    <div class="card" style="height: 100px; width: 100px;">
                                        <a href="{{ $company->url }}">
                                            <img src="{{ $company->logo_thumb }}" alt="{{ $company->name }}" class="card-img-top img-fluid"
                                                style="height: 50px; object-fit: cover;">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <style>
                @media (min-width: 991px) and (max-width: 1400px) {
                    .card-section{
                        width: 108px;
                        height: 80px;
                    }
                }

            </style>







            {{-- Consultant --}}
            <div class="container pt-100">
                <div class="text-center wow animate__animated animate__fadeInUp">
                    <h3 style="color: rgba(5, 38, 78, 1);">Consultant</h3>
                    <h5 class="py-4">Unlock top-tier consultancy from our highly experienced experts!</h5>
                </div>

                <div class="row">
                    @foreach ($consultants as $consultant)
                        @php
                            $averageRating = $consultant->consultantReviews->avg('rating');
                            $roundedRating = round($averageRating);
                        @endphp

                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 bg-white mt-1 mb-3">
                            <div class="card card-consultant border rounded-2 h-100 consultantbox" style="border-color: rgba(5, 38, 78, 1) !important">
                                <div class="row d-flex position-relative">
                                    <div class="col-md-4 profile-img-container position-relative">
                                        <img src="{{ $consultant->avatar_url }}" alt="Profile Photo"
                                            class="rounded-circle border border-white img-fluid image-controller w-100">
                                        <i class="bi bi-circle-fill text-success status-indicator position-absolute"></i>
                                    </div>
                                    <div class="col-md-8">
                                        <a href="{{ route('consultantdetails', ['id' => $consultant->id]) }}">
                                            <h5 class=" hover-text">
                                                {{ $consultant->first_name . ' ' . $consultant->last_name }}
                                            </h5>
                                        </a>
                                        <p class="py-2 hover-text">Designation- Consultant</p>
                                        {{-- <div class="rating-stars">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <label for="rs-{{ $i }}"
                                                    style="background-color: {{ $i <= $roundedRating ? 'orange' : '#000b' }};"></label>
                                            @endfor
                                            <span id="rating-counter">{{ $roundedRating }}</span>
                                        </div> --}}
                                        <div>
                                            @php
                                                $filledStars = $roundedRating;
                                                $totalStars = 5;
                                                $emptyStars = $totalStars - $filledStars;
                                            @endphp

                                            @for ($i = 1; $i <= $filledStars; $i++)
                                                <i class="fa fa-star" style="color: orange;"></i> <!-- Filled star -->
                                            @endfor

                                            @for ($i = 1; $i <= $emptyStars; $i++)
                                                <i class="fa fa-star" style="color: lightgray;"></i> <!-- Empty star -->
                                            @endfor
                                            ({{ $roundedRating }})
                                        </div>


                                        {{-- <span class="text-secondary">({{ number_format($averageRating, 1) }})</span> --}}
                                    </div>
                                </div>
                                <p class="py-2 text-truncate">{{ $consultant->description }}</p>
                                <div class="border-top">
                                    <span><i class="bi bi-geo-alt-fill"></i> {{ $consultant->address }}</span>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var stars = document.querySelectorAll('.rating-stars input[type="radio"]');
                                var counter = document.getElementById('rating-counter');
                                var initialRating = {{ $roundedRating }};

                                // Function to update the counter based on the current rating
                                function updateCounter(value) {
                                    counter.textContent = value;
                                }

                                // Set initial rating counter
                                updateCounter(initialRating);

                                stars.forEach(function(star) {
                                    star.addEventListener('change', function() {
                                        updateCounter(this.value);
                                    });

                                    star.nextElementSibling.addEventListener('mouseover', function() {
                                        updateCounter(this.previousElementSibling.value);
                                    });

                                    star.nextElementSibling.addEventListener('mouseleave', function() {
                                        var checkedStar = document.querySelector(
                                            '.rating-stars input[type="radio"]:checked');
                                        updateCounter(checkedStar ? checkedStar.value : initialRating);
                                    });
                                });
                            });
                        </script>
                    @endforeach
                    <style>
                        .consultantbox .rating-stars {
                            display: block;
                            width: max-content;
                            padding: .5rem 2rem .5rem .95rem;
                            background: transparent;
                            border-radius: 2rem;
                            position: relative;
                            margin: 0 auto;
                        }

                        #rating-counter {
                            font-size: 16px;
                            font-family: Arial, Helvetica, serif;
                            color: #ffffff;
                            width: 2rem;
                            text-align: center;
                            background: #0006;
                            position: absolute;
                            top: 0;
                            right: 0;
                            height: 100%;
                            border-radius: 0 5vmin 5vmin 0;
                            line-height: normal;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            transition: all 0.25s ease 0s;
                        }

                        input {
                            display: none;
                        }

                        label {
                            width: 1rem;
                            height: 1rem;
                            background: #000b;
                            display: inline-flex;
                            cursor: pointer;
                            margin: .05rem .1rem;
                            transition: all 1s ease 0s;
                            clip-path: polygon(50% 0%, 66% 32%, 100% 38%, 78% 64%, 83% 100%, 50% 83%, 17% 100%, 22% 64%, 0 38%, 34% 32%);
                        }

                        label[for^=rs][for$=_0] {
                            display: none;
                        }

                        label:before {
                            width: 90%;
                            height: 90%;
                            content: "";
                            background: orange;
                            z-index: -1;
                            display: block;
                            margin-left: 5%;
                            margin-top: 5%;
                            clip-path: polygon(50% 0%, 66% 32%, 100% 38%, 78% 64%, 83% 100%, 50% 83%, 17% 100%, 22% 64%, 0 38%, 34% 32%);
                            background: linear-gradient(90deg, #ffb400, #ffe802 30% 50%, #184580 50%, 70%, #173a75 100%);
                            background-size: 205% 100%;
                            background-position: 0 0;
                        }

                        label:hover:before {
                            transition: all 0.25s ease 0s;
                        }

                        input:checked+label~label:before {
                            background-position: 100% 0;
                            transition: all 0.25s ease 0s;
                        }

                        input:checked+label~label:hover:before {
                            background-position: 0% 0
                        }

                        /* Dynamically generated IDs for checked states */
                        input[id^=rs1]:checked~.rating-counter:before,
                        input[id^=rs2]:checked~.rating-counter:before,
                        input[id^=rs3]:checked~.rating-counter:before,
                        input[id^=rs4]:checked~.rating-counter:before,
                        input[id^=rs5]:checked~.rating-counter:before {
                            color: #ffab00 !important;
                            transition: all 0.25s ease 0s;
                        }

                        /* Hover states */
                        label[for^=rs1]:hover~.rating-counter:before,
                        label[for^=rs2]:hover~.rating-counter:before,
                        label[for^=rs3]:hover~.rating-counter:before,
                        label[for^=rs4]:hover~.rating-counter:before,
                        label[for^=rs5]:hover~.rating-counter:before {
                            color: #ffffff !important;
                            transition: all 0.5s ease 0s;
                            animation: pulse 1s ease 0s infinite;
                        }

                        /* Specific counter content based on ID suffix */
                        input[id$=_1]:checked~.rating-counter:before {
                            content: "1";
                        }

                        input[id$=_2]:checked~.rating-counter:before {
                            content: "2";
                        }

                        input[id$=_3]:checked~.rating-counter:before {
                            content: "3";
                        }

                        input[id$=_4]:checked~.rating-counter:before {
                            content: "4";
                        }

                        input[id$=_5]:checked~.rating-counter:before {
                            content: "5";
                        }

                        /* Hover counter content based on ID suffix */
                        label[for$=_1]:hover~.rating-counter:before {
                            content: "1" !important;
                        }

                        label[for$=_2]:hover~.rating-counter:before {
                            content: "2" !important;
                        }

                        label[for$=_3]:hover~.rating-counter:before {
                            content: "3" !important;
                        }

                        label[for$=_4]:hover~.rating-counter:before {
                            content: "4" !important;
                        }

                        label[for$=_5]:hover~.rating-counter:before {
                            content: "5" !important;
                        }

                        input:checked:hover~.rating-counter:before {
                            animation: none !important;
                            color: #ffab00 !important;
                        }

                        @keyframes pulse {
                            50% {
                                font-size: 18px;
                            }
                        }
                    </style>
                    {{-- <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 bg-white my-1">
                        <div class="card border border rounded-2 ">
                            <div class="row d-flex position-relative">
                                <div class="col-md-4 profile-img-container position-relative">
                                    <img src="https://via.placeholder.com/191x191" alt="Profile Photo"
                                        class="rounded-circle border border-white img-fluid">
                                    <i class="bi bi-circle-fill text-success status-indicator position-absolute"></i>
                                </div>
                                <div class="col-md-8">
                                    <h5 class="text-black">Jakob Corwin</h5>
                                    <p class="py-2">Designation- Consultant</p>
                                    <span class="text-warning">
                                        <i class="bi bi-star"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <span class="text-secondary">(5)</span>
                                    </span>
                                </div>
                            </div>
                            <p class="py-2">Turtle--we used to know. Let me see--how IS it to the Duchess: 'and the moral
                                of...</p>
                            <div class="border-top">
                                <span><i class="bi bi-geo-alt-fill"></i> 851 Block RuePort Wavaside, ID 80047…</span>
                            </div>
                        </div>
                    </div> --}}
                </div>


                <div class="text-center py-5">
                    <a type="button" href="{{ route('consultants') }}" class="btn text-white" style="background: rgba(5, 38, 78, 1)">View More</a>
                </div>


            </div>


            {{-- Our Training Types --}}
            <div style="background: rgba(255, 252, 234, 0.71); ">
                <div class="container pt-30">
                    <div class="py-5 text-center wow animate__animated animate__fadeInUp">
                        <h3 class="text-primary">Our Training Types </h3>
                    </div>

                    <div class="row mb-5 px-3 px-md-5">
                        <div class="col-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                            <button id="btn1" class="btn btn-outline-primary w-100" onclick="updateContent(1)">Career
                                Training</button>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                            <button id="btn2" class="btn btn-outline-primary w-100" onclick="updateContent(2)">HR
                                Professional</button>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                            <button id="btn3" class="btn btn-outline-primary w-100" onclick="updateContent(3)">CV
                                Writing Training</button>
                        </div>
                        <div class="col-12 col-sm-6 col-md-3 col-lg-3 mb-3">
                            <button id="btn4" class="btn btn-outline-primary w-100" onclick="updateContent(4)">Interview
                                Training</button>
                        </div>
                    </div>

                    <div class="row justify-content-between py-5" id="contentRow">
                        <div class="col-md-4">
                            <img id="contentImage" src="https://www.mamtaz.com/storage/covers/group-39064.png"
                                alt="Content Image" class="img-fluid">
                        </div>
                        <div class="col-md-8">
                            <div id="contentText" style="text-align: justify;">
                                <p>Our online training portal offers comprehensive programs designed to equip job seekers with the essential skills and knowledge needed to secure employment in today’s competitive job market. These training courses cover a wide range of areas, including resume writing, interview preparation, and job search strategies. Additionally, specialized modules focus on developing technical skills, such as coding, data analysis, and digital marketing, which are highly sought after by employers. By providing practical, industry-relevant training and personalized support, the portal helps individuals enhance their employability and confidently navigate the job search process.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Join Us Section --}}
            <div style="background: rgba(255, 252, 234, 0.71); ">
                <div class="container-fluid py-5">
                    <div class="custom-bg py-5">
                        <div class="container custom-container">
                            <div class="row align-items-center">
                                <div class="col-xl-6 col-md-6 col-12 mb-4 mb-md-0 wow animate__animated animate__fadeInUp custom-textcontent">
                                    <h3 class="text-white mb-3">Join us and land your dream job with expert consultancy</h3>
                                    <p class="text-white pt-4">
                                        Work Profile is a personality assessment that measures an individual's work personality
                                        through their workplace traits, social and emotional traits; as well as the values and
                                        aspirations that drive them forward.
                                    </p>
                                    <div class="mt-40 ">
                                        <a href="{{ route('consultants') }}"
                                            class="btn joinbtn btn-warning text-white fw-bold "
                                            style="display: inline-block;">Let's Start</a>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-md-6 d-flex justify-content-center">
                                    <img id="contentImage" src="https://www.mamtaz.com/storage/covers/section.png"
                                        alt="Content Image" class="custom-image img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            {{-- Feature job --}}
            {{-- <div style="background: rgba(255, 252, 234, 0.71); ">
    <div class="container py-2" >
        <div class="py-5 text-center">
            <h3 class="fw-bold" style="color: rgba(5, 38, 78, 1);">Featured Job </h3>
        </div>

            <div class="row mb-5 px-5 btn-container" style="margin-bottom: 1rem !important;">
                <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-4 flex-column">
                    <button id="btn1" class="btn border-primary w-100 bg-white text-start d-flex align-items-center" onclick="updateContents(1)">
                        <i class="bi bi-file-earmark-break btn-icon me-2"></i>
                        Content Writer
                    </button>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-4 flex-column">
                    <button id="btn2" class="btn border-primary w-100 bg-white text-start d-flex align-items-center" onclick="updateContents(2)">
                        <i class="bi bi-search btn-icon me-2"></i>
                        Market Research
                    </button>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-4 flex-column">
                    <button id="btn3" class="btn border-primary w-100 bg-white text-start d-flex align-items-center" onclick="updateContents(3)">
                        <i class="bi bi-headset btn-icon me-2"></i>
                        Customer Help
                    </button>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-4 flex-column">
                    <button id="btn4" class="btn border-primary w-100 bg-white text-start d-flex align-items-center" onclick="updateContents(4)">
                        <i class="bi bi-house-door-fill btn-icon me-2"></i>
                        Finance
                    </button>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-4 flex-column">
                    <button id="btn5" class="btn border-primary w-100 bg-white text-start d-flex align-items-center" onclick="updateContents(5)">
                        <i class="bi bi-person btn-icon me-2"></i>
                        Human Resource
                    </button>
                </div>
                <div class="col-12 col-sm-6 col-md-4 col-lg-2 mb-4 flex-column">
                    <button id="btn6" class="btn border-primary w-100 bg-white text-start d-flex align-items-center" onclick="updateContents(6)">
                        <i class="bi bi-pc-display-horizontal btn-icon me-2"></i>
                        Management
                    </button>
                </div>
            </div>


            <div class="row" id="contentRow">
                <div class="col-lg-3 col-md-6 col-sm-12 my-1">
                    <div class="card border rounded-2 py-2 px-2 bg-white">
                        <img class="contentImage" src="https://via.placeholder.com/291x185" alt="Profile Photo" class="rounded img-fluid">
                        <div class="contentText">
                            <h6 class="mt-2">Senior Enterprise Advocate, EMEA</h6>
                            <span class="d-flex align-items-center mb-2">
                                <span><i class="bi bi-geo-alt-fill"></i> Denmark, DN</span>
                                <span class="px-1"><i class="bi bi-geo-alt-fill"></i> 4 months ago</span>
                            </span>
                            <div class="py-1">
                                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">CakePHP</p>
                            </div>
                            <span class="d-flex align-items-center py-2">
                                <span class="fs-6 fw-bold text-primary">$9,500 - $11,900</span>
                                <span>/Yearly</span>
                            </span>
                            <p class="py-2">Magni itaque corrupti cupiditate. Quae fuga unde mollitia impedit. Minus error enim delectus repellendus harum accusamus…</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 my-1">
                    <div class="card border rounded-2 py-2 px-2 bg-white">
                        <img class="contentImage" src="https://via.placeholder.com/291x185" alt="Profile Photo" class="rounded img-fluid">
                        <div class="contentText">
                            <h6 class="mt-2">Senior Enterprise Advocate, EMEA</h6>
                            <span class="d-flex align-items-center mb-2">
                                <span><i class="bi bi-geo-alt-fill"></i> Denmark, DN</span>
                                <span class="px-1"><i class="bi bi-geo-alt-fill"></i> 4 months ago</span>
                            </span>
                            <div class="py-1">
                                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">CakePHP</p>
                            </div>
                            <span class="d-flex align-items-center py-2">
                                <span class="fs-6 fw-bold text-primary">$9,500 - $11,900</span>
                                <span>/Yearly</span>
                            </span>
                            <p class="py-2">Magni itaque corrupti cupiditate. Quae fuga unde mollitia impedit. Minus error enim delectus repellendus harum accusamus…</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 my-1">
                    <div class="card border border-primary rounded-2 py-2 px-2 bg-white custom-shadow">
                        <img class="contentImage" src="https://via.placeholder.com/291x185" alt="Profile Photo" class="rounded img-fluid">
                        <div class="contentText">
                            <h6 class="mt-2">Senior Enterprise Advocate, EMEA</h6>
                            <span class="d-flex align-items-center mb-2">
                                <span><i class="bi bi-geo-alt-fill"></i> Denmark, DN</span>
                                <span class="px-1"><i class="bi bi-geo-alt-fill"></i> 4 months ago</span>
                            </span>
                            <div class="py-1">
                                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">CakePHP</p>
                            </div>
                            <span class="d-flex align-items-center py-2">
                                <span class="fs-6 fw-bold text-primary">$9,500 - $11,900</span>
                                <span>/Yearly</span>
                            </span>
                            <p class="py-2">Magni itaque corrupti cupiditate. Quae fuga unde mollitia impedit. Minus error enim delectus repellendus harum accusamus…</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 my-1">
                    <div class="card border border-primary rounded-2 py-2 px-2 bg-white custom-shadow">
                        <img class="contentImage" src="https://via.placeholder.com/291x185" alt="Profile Photo" class="rounded img-fluid">
                        <div class="contentText">
                            <h6 class="mt-2">Senior Enterprise Advocate, EMEA</h6>
                            <span class="d-flex align-items-center mb-2">
                                <span><i class="bi bi-geo-alt-fill"></i> Denmark, DN</span>
                                <span class="px-1"><i class="bi bi-geo-alt-fill"></i> 4 months ago</span>
                            </span>
                            <div class="py-1">
                                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">CakePHP</p>
                            </div>
                            <span class="d-flex align-items-center py-2">
                                <span class="fs-6 fw-bold text-primary">$9,500 - $11,900</span>
                                <span>/Yearly</span>
                            </span>
                            <p class="py-2">Magni itaque corrupti cupiditate. Quae fuga unde mollitia impedit. Minus error enim delectus repellendus harum accusamus…</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row pb-5" id="contentRow" style="margin-bottom: 3rem !important;">
                <div class="col-lg-3 col-md-6 col-sm-12 my-1">
                    <div class="card border border-primary rounded-2 py-2 px-2 bg-white custom-shadow">
                        <img class="contentImage" src="https://via.placeholder.com/291x185" alt="Profile Photo" class="rounded img-fluid">
                        <div class="contentText">
                            <h6 class="mt-2">Senior Enterprise Advocate, EMEA</h6>
                            <span class="d-flex align-items-center mb-2">
                                <span><i class="bi bi-geo-alt-fill"></i> Denmark, DN</span>
                                <span class="px-1"><i class="bi bi-geo-alt-fill"></i> 4 months ago</span>
                            </span>
                            <div class="py-1">
                                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">CakePHP</p>
                            </div>
                            <span class="d-flex align-items-center py-2">
                                <span class="fs-6 fw-bold text-primary">$9,500 - $11,900</span>
                                <span>/Yearly</span>
                            </span>
                            <p class="py-2">Magni itaque corrupti cupiditate. Quae fuga unde mollitia impedit. Minus error enim delectus repellendus harum accusamus…</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 my-1">
                    <div class="card border rounded-2 py-2 px-2 bg-white">
                        <img class="contentImage" src="https://via.placeholder.com/291x185" alt="Profile Photo" class="rounded img-fluid">
                        <div class="contentText">
                            <h6 class="mt-2">Senior Enterprise Advocate, EMEA</h6>
                            <span class="d-flex align-items-center mb-2">
                                <span><i class="bi bi-geo-alt-fill"></i> Denmark, DN</span>
                                <span class="px-1"><i class="bi bi-geo-alt-fill"></i> 4 months ago</span>
                            </span>
                            <div class="py-1">
                                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">CakePHP</p>
                            </div>
                            <span class="d-flex align-items-center py-2">
                                <span class="fs-6 fw-bold text-primary">$9,500 - $11,900</span>
                                <span>/Yearly</span>
                            </span>
                            <p class="py-2">Magni itaque corrupti cupiditate. Quae fuga unde mollitia impedit. Minus error enim delectus repellendus harum accusamus…</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 my-1">
                    <div class="card border rounded-2 py-2 px-2 bg-white">
                        <img class="contentImage" src="https://via.placeholder.com/291x185" alt="Profile Photo" class="rounded img-fluid">
                        <div class="contentText">
                            <h6 class="mt-2">Senior Enterprise Advocate, EMEA</h6>
                            <span class="d-flex align-items-center mb-2">
                                <span><i class="bi bi-geo-alt-fill"></i> Denmark, DN</span>
                                <span class="px-1"><i class="bi bi-geo-alt-fill"></i> 4 months ago</span>
                            </span>
                            <div class="py-1">
                                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">CakePHP</p>
                            </div>
                            <span class="d-flex align-items-center py-2">
                                <span class="fs-6 fw-bold text-primary">$9,500 - $11,900</span>
                                <span>/Yearly</span>
                            </span>
                            <p class="py-2">Magni itaque corrupti cupiditate. Quae fuga unde mollitia impedit. Minus error enim delectus repellendus harum accusamus…</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-12 my-1">
                    <div class="card border rounded-2 py-2 px-2 bg-white">
                        <img class="contentImage" src="https://via.placeholder.com/291x185" alt="Profile Photo" class="rounded img-fluid">
                        <div class="contentText">
                            <h6 class="mt-2">Senior Enterprise Advocate, EMEA</h6>
                            <span class="d-flex align-items-center mb-2">
                                <span><i class="bi bi-geo-alt-fill"></i> Denmark, DN</span>
                                <span class="px-1"><i class="bi bi-geo-alt-fill"></i> 4 months ago</span>
                            </span>
                            <div class="py-1">
                                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">CakePHP</p>
                            </div>
                            <span class="d-flex align-items-center py-2">
                                <span class="fs-6 fw-bold text-primary">$9,500 - $11,900</span>
                                <span>/Yearly</span>
                            </span>
                            <p class="py-2">Magni itaque corrupti cupiditate. Quae fuga unde mollitia impedit. Minus error enim delectus repellendus harum accusamus…</p>
                        </div>
                    </div>
                </div>
            </div>

    </div>
</div> --}}




        </section>




        <style>
            body,
            h1,
            h2,
            h3,
            h4,
            p,
            span,
            button,
            .btn {
                font-family: 'Poppins', sans-serif;
            }

            .banner-top-image img {
                width: 250%;
                /* Adjust width percentage as needed */
                height: auto;
                /* Maintain aspect ratio */
            }

            @media (max-width: 1199.98px) {
                .col-size {}
            }






            @media (max-width: 991px) {
                .block-banner .color {
                    padding-top: 24px;
                    background: linear-gradient(rgba(48, 58, 105, 0.96), rgba(62, 131, 218, 0.85));
                }
            }

            @media (max-width: 767px) {
                .block-banner .color {
                    background: linear-gradient(rgba(48, 58, 105, 0.96), rgba(62, 131, 218, 0.85));
                }
            }

            @media (max-width: 991px) {
                .block-banner-bottom .color {
                    margin-top: -0.8125rem !important;
                    background: rgba(178, 213, 255, 0.71);
                }
            }

            @media (max-width: 767px) {
                .block-banner-bottom .color {
                    margin-top: -0.6125rem !important;
                    background: rgba(178, 213, 255, 0.71);
                }
            }


            @media (max-width: 767px) {
                .company {
                    margin-left: -211px;
                    margin-right: 188px;
                }

            }


            .joinbtn {
                width: 300px;
            }

            @media (max-width: 576px) {
                .joinbtn {
                    width: 200px;
                }
            }

            @media (max-width: 360px) {
                .joinbtn {
                    width: 200px;
                }

            }




            .job-buttons {
                margin: 1.25rem 0;
            }

            .job-btn {
                background: none;
                border: .125rem solid yellow;
                padding: .625rem 1.25rem;
                margin-right: .625rem;
                color: white;
                border-radius: 3.125rem;
                text-decoration: none;
                font-size: 1em;
            }

            .job-btn:hover {
                background-color: yellow;
                color: #3C65F5;
            }

            .social-links {
                margin-top: 1.25rem;
            }

            .social-links a {
                margin-right: .625rem;
            }

            .social-links img {
                width: 1.5rem;
                height: 1.5rem;
            }

            .custom-shadow {
                position: relative;
                box-shadow: -0.5rem 0 .5rem -0.25rem rgba(0, 0, 255, 0.7);
                /* Solid blue shadow only on the left */
            }

            .card {
                border: 1px solid #ddd;
                border-radius: 10px;
                overflow: hidden;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                /* Optional padding and margin */
                margin: 10px;
                padding: 20px;
            }

            .card:hover {
                transform: scale(1.05);
                /* Slightly enlarge the card */
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            }

            .card img {
                width: 100%;
                border-radius: 10px;
                transition: transform 0.3s ease;
            }

            .card:hover img {
                transform: scale(1.05);
                /* Slightly enlarge the image as well */
            }

            .card .contentText {
                transition: color 0.3s ease;
            }

            .card:hover .contentText {
                color: #007bff;
                /* Change the text color on hover */
            }


            /* Join us section */
            .custom-bg {
                background: rgba(5, 38, 78, 1);
                border-radius: 0 31.25rem 31.25rem 0;
            }

            .custom-container {
                border-radius: 1rem;
                padding: 3rem;
                position: relative;
                z-index: 1;
            }

            .custom-image {
                max-width: 100%;
                height: auto;
            }

            .joinbtn {
                width: 300px;
            }

            @media (max-width: 767.98px) {
                .custom-textcontent{
                    width: 89%
                }
                .custom-image {
                    width: 71%;
                    height: auto;
                    position: relative;
                    top: 33px;
                    right: 59px;
                }
                .joinbtn {
                    width: 200px;
                }
            }

            @media (max-width: 575.98px) {
                .custom-textcontent{
                    width: 85%
                }
                .custom-image {
                    width: 60%;
                    height: auto;
                    position: relative;
                    top: 33px;
                    right: 59px;
                }
                .joinbtn {
                    width: 200px;
                }
            }

            @media (max-width: 360px) {
                .custom-textcontent{
                    width: 89%
                }
                .custom-image {
                    display: none;
                }
                .joinbtn {
                    width: 160px;
                }
            }


            .btn-container {
                margin-bottom: 3rem;
            }

            .btn-icon {
                font-size: 1.5rem;
            }


            .profile-img-container {
                position: relative;
                display: inline-block;
            }


            /* Consultants */
            .status-indicator {
                top: 41px;
                right: 14px;
                z-index: 1;
            }

            .image-controller {
                width: 100%;
                height: 71px !important;
                object-fit: cover;
            }

            .card-consultant:hover {
                transform: scale(1.05);
                box-shadow: 0 3px 12px rgba(5, 38, 78, 1);
            }

            .hover-text:hover {
                color: rgb(62, 120, 192);
            }

            @media (max-width: 1599.98px) {
                .status-indicator {
                    top: 41px;
                    right: 14px;
                }

                .image-controller {
                    width: 100%;
                    height: 69px !important;
                    object-fit: cover;
                }
            }

            @media (max-width: 1400px) {
                .status-indicator {
                    top: 26px;
                    right: 12px;
                    font-size: 12px;
                }

                .image-controller {
                    width: 100%;
                    height: 52px !important;
                    object-fit: cover;
                }
            }

            @media (max-width: 1199.98px) {
                .status-indicator {
                    top: 35px;
                    right: 13px;
                }

                .image-controller {
                    width: 100%;
                    height: 63px !important;
                    object-fit: cover;
                }
            }

            @media (max-width: 991.98px) {
                .status-indicator {
                    top: 44px;
                    right: 13px;
                }

                .image-controller {
                    width: 100%;
                    height: 76px !important;
                    object-fit: cover;
                }
            }

            @media (max-width: 767.98px) {
                .status-indicator {
                    top: 47px;
                    right: 386px;
                }

                .image-controller {
                    width: 18% !important;
                    height: 79px !important;
                    object-fit: cover;
                }
            }

            @media (max-width: 575.98px) {
                .status-indicator {
                    top: 53px;
                    right: 403px;
                }

                .image-controller {
                    width: 19% !important;
                    height: 87px !important;
                    object-fit: cover;
                }
            }

            @media (max-width: 360px) {
                .status-indicator {
                    top: 52px;
                    right: 198px;
                }

                .image-controller {
                    width: 32% !important;
                    height: 86px !important;
                    object-fit: cover;
                }
            }
        </style>
    @break

@endswitch





<style>
.btn-services {
    background: linear-gradient(135deg, #f9f9f9, #e0e0e0); /* Subtle gradient for a premium feel */
    color: rgba(5, 38, 78, 1);
    padding: 12px 24px;
    border-radius: 50px; /* Rounded corners */
    font-weight: 600;
    box-shadow: 0px 4px 6px rgba(5, 38, 78, 1); /* Soft shadow for a polished look */
    transition: all 0.3s ease; /* Smooth transition for hover effects */
}

.btn-services:hover {
    background: linear-gradient(135deg, #ffffff, #d3d3d3); /* Brighter hover effect */
    color: #0a3b9a; /* Slightly darker color on hover */
    box-shadow: 0px 6px 12px rgb(10, 67, 138); /* More pronounced shadow on hover */
    transform: translateY(-2px); /* Slight lift effect */
}

</style>
@if (request()->is('jobs'))
    <div class="container-fluid d-flex flex-sm-column flex-md-row justify-content-between align-items-center consultantDesign"
        style="background-color: #153459; color: white;">
        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 text-center Design mt-40 mb-40" style="max-width: 100%;">
            <h2 style="color: white;margin-bottom: 40px;">Consultant</h2>
            <p style="color: white; margin-bottom: 50px;">Our expert career consultants can assist you in numerous ways to enhance your job search and professional growth.
            </p>
            <div class="d-flex gap-3 justify-content-md-between justify-content-sm-between flex-sm-column flex-md-row">
                <a href="{{ route('consultants') }}"
                    class="d-flex gap-3 justify-content-md-center justify-content-sm-center align-items-center"
                    style="text-decoration: none;"><button class="py-2 px-3 rounded-pill border-0 fw-bold btn-services"><i
                        class="fa fa-users me-lg-1 me-md-1 me-sm-0"></i>Take Consultancy</button></a>
                <a href="{{ route('consultants') }}"
                    class="d-flex gap-3 justify-content-md-center justify-content-sm-center align-items-center"
                    style="text-decoration: none;"><button class="py-2 px-3 rounded-pill border-0 fw-bold btn-services"><i
                        class="fa fa-calendar me-lg-1 me-md-1 me-sm-0"></i> Book Appointment</button></a>
                <a href="{{ route('consultants') }}"
                    class="d-flex gap-3 justify-content-md-center justify-content-sm-center align-items-center"
                    style="text-decoration: none;"><button class="py-2 px-3 rounded-pill border-0 fw-bold btn-services"><i
                        class="fa fa-briefcase me-lg-1 me-md-1 me-sm-0"></i> Take Services</button></a>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 imageDesign" style="">
            <img src="{{ asset('images/group.png') }}" alt="Consultant Image"
                style="max-width: 100%; height: auto;">

        </div>
    </div>
    <style>
        .consultantDesign {
            padding-left: 260px;
            padding-right: 260px;
        }

        .Design {
            padding-left: 60px;
            padding-right: 60px;
        }

        .imageDesign {
            margin-left: 0px;
        }

        @media (max-width: 1399.98px) {
            .consultantDesign {
                padding-left: 210px;
                padding-right: 260px;
            }

            .Design {
                padding-left: 60px;
                padding-right: 60px;
            }

            .imageDesign {
                margin-left: 0px;
            }
        }

        @media (max-width: 1199.98px) {
            .consultantDesign {
                padding-left: 90px;
                padding-right: 260px;
            }

            .Design {
                padding-left: 60px;
                padding-right: 60px;
            }

            .imageDesign {
                margin-left: 0px;
            }
        }

        @media (max-width: 991.98px) {
            .consultantDesign {
                padding-left: 55px;
                padding-right: 110px;
            }

            .Design {
                padding-left: 60px;
                padding-right: 60px;
            }

            .imageDesign {
                margin-left: 0px;
            }
        }

        @media (max-width: 767.98px) {
            .consultantDesign {
                padding-left: 0px;
                padding-right: 0px;
            }

            .Design {
                padding-left: 0px;
                padding-right: 0px;
            }

            .imageDesign {
                margin-left: 210px;
            }
        }
    </style>
@endif








<!-- JavaScript to Update Content -->
<script>
    function updateContent(buttonId) {
        var image = document.getElementById('contentImage');
        var text = document.getElementById('contentText');

        if (buttonId === 1) {
            image.src = 'https://www.mamtaz.com/storage/covers/group-39064.png';
            text.innerHTML =
                '<p>In todays rapidly evolving job market, career planning is more important than ever. It is not just about securing a job; it is about building a long-term, fulfilling career that aligns with your personal goals, skills, and passions. Our Career Planning program is designed to help you navigate this journey with confidence and clarity. Whether you are just starting your professional life, considering a career shift, or striving to grow in your current role, our program provides the tools and guidance necessary for long-term success. Career planning involves more than simply choosing a job or field of interest—it a thoughtful process of self-discovery and strategic decision-making. The first step in our program is helping you assess your current skills, strengths, and interests. Understanding what you naturally good at and what you enjoy doing is key to finding a career path that is not only successful but also satisfying. Our experienced career coaches will work closely with you to explore your unique talents and align them with potential career opportunities. Once you gained clarity on your strengths and interests, we move on to the critical phase of goal-setting. Setting realistic and achievable career goals is crucial in ensuring your career path is both purposeful and rewarding. Our program encourages you to think long-term—considering not only where you want to be in the next few months but also in the next five to ten years. With our guidance, you develop a detailed career roadmap that includes short-term milestones and long-term aspirations. This roadmap serves as a blueprint, guiding you through the various stages of your professional journey. An essential part of career planning is understanding the ever-changing demands of the job market. Our program provides you with up-to-date insights into industry trends and emerging career opportunities, allowing you to stay ahead in your field. We help you identify sectors with high growth potential, offering advice on the skills and qualifications needed to succeed in those areas. Whether you interested in technology, healthcare, finance, marketing, or any other industry, our career experts will ensure you are well-prepared for the future. Moreover, we believe that personal growth is just as important as professional growth. Our program emphasizes the development of soft skills—communication, leadership, adaptability, problem-solving, and emotional intelligence—traits that are increasingly valued by employers. We offer specialized training and workshops to help you hone these abilities, ensuring that you are not only technically proficient but also well-rounded as a professional.</p>';
        } else if (buttonId === 2) {
            image.src = 'https://www.mamtaz.com/storage/covers/group-39064.png';
            text.innerHTML =
                '<p>Human Resources (HR) plays a vital role in the success of any organization. From managing employee relations to ensuring compliance with employment laws, HR professionals are the backbone of a company workforce. Our HR Professional Training program is designed to equip individuals with the skills and knowledge they need to excel in this fast-paced and dynamic field. Whether you new to HR or looking to advance your career, our training offers a comprehensive understanding of key HR functions and best practices, preparing you for the challenges of today evolving workplace. Our program covers all critical areas of human resources, including recruitment, talent management, employee relations, compensation and benefits, compliance with labor laws, and workplace ethics. The goal is to provide you with a well-rounded skill set that enables you to manage the entire employee life cycle—from hiring to retirement. We focus on practical, real-world applications of HR theories and concepts, ensuring that you can apply what you learn immediately in your professional setting. Recruitment and talent acquisition are among the first critical topics we address in the training. You learn how to develop effective job postings, conduct interviews, and select the best candidates for various positions. We also cover talent retention strategies, ensuring that once employees are on board, they remain engaged and committed to the organization. You gain insights into onboarding best practices, employee engagement techniques, and the development of positive workplace cultures that contribute to long-term employee satisfaction. Another key component of our HR Professional Training is performance management. Effective performance management is crucial to helping employees grow and improve while aligning their goals with the company objectives. Our program provides you with strategies for conducting fair and objective performance appraisals, setting measurable performance goals, and providing constructive feedback that encourages continuous improvement. We also address the importance of coaching and mentoring, helping you develop skills to support and guide employees throughout their careers. Employee relations and conflict resolution are also integral parts of HR, and our program dedicates significant time to these areas. HR professionals are often the go-to people for addressing workplace conflicts, and it essential to handle these situations professionally and diplomatically. You learn techniques for mediating disputes, improving communication between teams, and fostering an inclusive and respectful work environment.</p>';
        } else if (buttonId === 3) {
            image.src = 'https://www.mamtaz.com/storage/covers/group-39064.png';
            text.innerHTML =
                '<p>A well-crafted CV is the first step toward securing your dream job. It’s more than just a summary of your work history; it’s your personal marketing document that highlights your skills, achievements, and experiences in a way that captures the attention of hiring managers. Our CV Writing Training program is designed to help you create a standout CV that showcases your strengths and aligns with the job you’re seeking. Whether you a fresh graduate entering the job market or a seasoned professional looking to transition to a new role, our training provides the tools and strategies needed to craft a CV that gets results. The job market is competitive, and employers often receive hundreds of applications for a single position. In such an environment, it’s critical that your CV makes a strong first impression. Our training begins with understanding the purpose and structure of a CV, helping you differentiate between what should and should not be included. We guide you through the various sections of a CV—such as personal details, professional summary, work experience, education, skills, and achievements—ensuring that each element works together to create a cohesive and compelling narrative of your career. One of the key areas we focus on is tailoring your CV to specific job opportunities. A one-size-fits-all approach no longer works in today’s job market. Employers are looking for candidates whose CVs align closely with the job description. We teach you how to analyze job postings and customize your CV to highlight the skills and experiences that match the requirements of the role. This targeted approach not only increases your chances of getting noticed but also demonstrates your genuine interest in the position. Another crucial aspect of our CV Writing Training is the creation of an impactful professional summary. The summary, located at the top of your CV, serves as your personal pitch to the employer. It should succinctly communicate who you are, what you bring to the table, and why you’re the perfect fit for the role. We provide you with strategies for crafting a powerful summary that immediately grabs the reader’s attention and compels them to learn more about you. Work experience is often the most important section of a CV, and we help you present your past roles in a way that highlights your achievements rather than just listing job duties. Employers want to know what you’ve accomplished in previous positions, not just what tasks you were responsible for. Our training emphasizes the use of quantifiable achievements—such as improving processes, increasing sales, or reducing costs—to demonstrate.</p>';
        } else if (buttonId === 4) {
            image.src = 'https://www.mamtaz.com/storage/covers/group-39064.png';
            text.innerHTML =
                '<p>Landing an interview is a huge milestone in your job search, but the real challenge lies in making the right impression when you’re in the room (or virtual meeting) with the hiring manager. Interviews are often the most critical stage of the hiring process, as they give employers a chance to assess not only your qualifications but also your personality, communication skills, and cultural fit within the company. Our Interview Training program is designed to help you excel in all types of interview situations, providing you with the skills, strategies, and confidence you need to succeed. The key to a successful interview is preparation. Our training begins by helping you understand the different types of interviews—whether it’s a traditional one-on-one interview, a panel interview, or even a video interview—and the best practices for each format. We cover everything from initial phone screenings to final in-person meetings, ensuring that you’re equipped to handle any scenario. We also provide detailed guidance on how to research the company and role beforehand, enabling you to tailor your responses and demonstrate your enthusiasm for the opportunity. One of the central components of our Interview Training is mastering the art of answering common interview questions. Many candidates struggle with how to respond to questions like “Tell me about yourself,” “What are your strengths and weaknesses?” or “Why should we hire you?” These questions may seem simple, but they require thoughtful answers that reflect both your professional background and your suitability for the role. Our program teaches you how to structure your responses using the STAR (Situation, Task, Action, Result) method, which helps you clearly communicate your skills and experiences in a concise and compelling way. In addition to common questions, we also focus on how to handle behavioral and situational interview questions. These types of questions require you to provide specific examples from your past work experience to demonstrate your problem-solving abilities, leadership skills, or how you handle challenges. We work with you to develop a bank of strong, relevant examples that you can draw upon during your interview, ensuring that you’re ready for even the toughest questions. Body language and non-verbal communication play a significant role in how you’re perceived during an interview. Our training includes tips on maintaining positive body language—such as making eye contact, sitting up straight, and using gestures to emphasize key points—so that you appear confident and engaged throughout the interview.</p>';
        }
    }

    function updateContents(buttonId) {
        var images = document.getElementsByClassName('contentImage');
        var texts = document.getElementsByClassName('contentText');

        var imageSrc, textContent;

        if (buttonId === 1) {
            imageSrc = 'https://via.placeholder.com/291x185';
            textContent = `
            <h6 class="mt-2">Content Writer</h6>
            <span class="d-flex align-items-center mb-2">
                <span><i class="bi bi-geo-alt-fill"></i> New York, NY</span>
                <span class="px-1"><i class="bi bi-clock-fill"></i> 2 months ago</span>
            </span>
            <div class="py-1">
                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">Copywriting</p>
            </div>
            <span class="d-flex align-items-center py-2">
                <span class="fs-6 fw-bold text-primary">$8,000 - $10,000</span>
                <span>/Yearly</span>
            </span>
            <p class="py-2">Responsible for creating engaging content for various platforms, ensuring the brand's voice is consistent...</p>
        `;
        } else if (buttonId === 2) {
            imageSrc = 'https://via.placeholder.com/291x185';
            textContent = `
            <h6 class="mt-2">Market Research</h6>
            <span class="d-flex align-items-center mb-2">
                <span><i class="bi bi-geo-alt-fill"></i> London, UK</span>
                <span class="px-1"><i class="bi bi-clock-fill"></i> 3 months ago</span>
            </span>
            <div class="py-1">
                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">Analytics</p>
            </div>
            <span class="d-flex align-items-center py-2">
                <span class="fs-6 fw-bold text-primary">$9,000 - $12,000</span>
                <span>/Yearly</span>
            </span>
            <p class="py-2">Conducting market research to gather data on consumer behavior, trends, and competitor analysis...</p>
        `;
        } else if (buttonId === 3) {
            imageSrc = 'https://via.placeholder.com/291x185';
            textContent = `
            <h6 class="mt-2">Customer Help</h6>
            <span class="d-flex align-items-center mb-2">
                <span><i class="bi bi-geo-alt-fill"></i> Sydney, AU</span>
                <span class="px-1"><i class="bi bi-clock-fill"></i> 1 month ago</span>
            </span>
            <div class="py-1">
                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">Support</p>
            </div>
            <span class="d-flex align-items-center py-2">
                <span class="fs-6 fw-bold text-primary">$7,000 - $9,000</span>
                <span>/Yearly</span>
            </span>
            <p class="py-2">Providing excellent customer service by addressing inquiries, resolving issues, and ensuring customer satisfaction...</p>
        `;
        } else if (buttonId === 4) {
            imageSrc = 'https://via.placeholder.com/291x185';
            textContent = `
            <h6 class="mt-2">Finance</h6>
            <span class="d-flex align-items-center mb-2">
                <span><i class="bi bi-geo-alt-fill"></i> Tokyo, JP</span>
                <span class="px-1"><i class="bi bi-clock-fill"></i> 5 months ago</span>
            </span>
            <div class="py-1">
                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">Accounting</p>
            </div>
            <span class="d-flex align-items-center py-2">
                <span class="fs-6 fw-bold text-primary">$10,000 - $13,000</span>
                <span>/Yearly</span>
            </span>
            <p class="py-2">Managing financial transactions, budgets, and reporting to ensure the company's financial health...</p>
        `;
        } else if (buttonId === 5) {
            imageSrc = 'https://via.placeholder.com/291x185';
            textContent = `
            <h6 class="mt-2">Human Resource</h6>
            <span class="d-flex align-items-center mb-2">
                <span><i class="bi bi-geo-alt-fill"></i> Berlin, DE</span>
                <span class="px-1"><i class="bi bi-clock-fill"></i> 4 months ago</span>
            </span>
            <div class="py-1">
                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">Recruitment</p>
            </div>
            <span class="d-flex align-items-center py-2">
                <span class="fs-6 fw-bold text-primary">$8,500 - $11,000</span>
                <span>/Yearly</span>
            </span>
            <p class="py-2">Overseeing recruitment processes, employee relations, and ensuring compliance with HR policies...</p>
        `;
        } else if (buttonId === 6) {
            imageSrc = 'https://via.placeholder.com/291x185';
            textContent = `
            <h6 class="mt-2">Management</h6>
            <span class="d-flex align-items-center mb-2">
                <span><i class="bi bi-geo-alt-fill"></i> Paris, FR</span>
                <span class="px-1"><i class="bi bi-clock-fill"></i> 6 months ago</span>
            </span>
            <div class="py-1">
                <p class="text-primary rounded py-1 px-3" style="background: rgba(81, 146, 255, 0.12); display: inline-block;">Leadership</p>
            </div>
            <span class="d-flex align-items-center py-2">
                <span class="fs-6 fw-bold text-primary">$12,000 - $15,000</span>
                <span>/Yearly</span>
            </span>
            <p class="py-2">Leading teams, overseeing projects, and ensuring organizational goals are met efficiently...</p>
        `;
        }

        for (var i = 0; i < images.length; i++) {
            images[i].src = imageSrc;
        }

        for (var j = 0; j < texts.length; j++) {
            texts[j].innerHTML = textContent;
        }
    }
</script>
