<style>
    /* Consultants */
    .status-indicator {
        top: 44px;
        right: 14px;
        z-index: 1;
    }

    .image-controller {
        width: 100%;
        height: 76px !important;
        object-fit: cover;
    }

    .card-consultant:hover {
        transform: scale(1.05);
        box-shadow: 0 3px 12px rgba(5, 38, 78, 1);
    }

    .hover-text:hover {
                color: rgba(62, 120, 192);
            }

    @media (max-width: 1599.98px) {
        .status-indicator {
            top: 44px;
            right: 15px;
        }

        .image-controller {
            width: 100%;
            height: 75px !important;
            object-fit: cover;
        }
    }

    @media (max-width: 1400px) {
        .status-indicator {
            top: 31px;
            right: 12px;
        }
        .image-controller {
            width: 100%;
            height: 60px !important;
            object-fit: cover;
        }
    }

    @media (max-width: 1199.98px) {
        .status-indicator {
            top: 41px;
            right: 14px;
        }

        .image-controller {
            width: 100%;
            height: 72px !important;
            object-fit: cover;
        }
    }

    @media (max-width: 991.98px) {
        .status-indicator {
            top: 51px;
            right: 16px;
        }

        .image-controller {
            width: 100%;
            height: 82px !important;
            object-fit: cover;
        }
    }

    @media (max-width: 767.98px) {
        .status-indicator {
            top: 51px;
            right: 408px;
        }

        .image-controller {
            width: 18% !important;
            height: 85px !important;
            object-fit: cover;
        }
    }

    @media (max-width: 575.98px) {
        .status-indicator {
            top: 56px;
            right: 433px;
        }

        .image-controller {
            width: 19% !important;
            height: 92px !important;
            object-fit: cover;
        }
    }

    @media (max-width: 360px) {
        .status-indicator {
            top: 57px;
            right: 221px;
        }

        .image-controller {
            width: 32% !important;
            height: 90px !important;
            object-fit: cover;
        }
    }
</style>

<section class="section-box mt-40 mb-30">
    <div class=container>
        <div class=text-center>
            <h2 class="section-title mb-10 wow animate__ animate__fadeInUp animated"
                style="visibility:visible;animation-name:fadeInUp; color: rgba(5, 38, 78, 1)">Consultants</h2>
            <p class="font-lg color-text-paragraph-2 wow animate__ animate__fadeInUp animated"
                style=visibility:visible;animation-name:fadeInUp>We are ready to provide our best to make you the best!
            </p>
        </div>
    </div>
    <div class=container>
        <div class=mt-40>
            <div class="row">
                @foreach ($consultants as $consultant)
                    @php
                        $averageRating = $consultant->consultantReviews->avg('rating');
                        $roundedRating = round($averageRating); // Rounded average rating for comparison
                    @endphp
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 bg-white my-1 pb-3">
                        <div class="card card-consultant border border rounded-2 p-3 h-100 consultantbox" style="border-color: rgba(5, 38, 78, 1) !important">
                            <div class="row d-flex position-relative">
                                <div class="col-md-4 profile-img-container position-relative">
                                    <img src="{{ $consultant->avatar_url }}" alt="Profile Photo"
                                        class="rounded-circle border border-white img-fluid image-controller w-100">
                                    <i class="bi bi-circle-fill text-success status-indicator position-absolute"></i>
                                </div>
                                <div class="col-md-8">
                                    <a href="{{ route('consultantdetails', [$consultant->id]) }}">
                                        <h5 class="hover-text">{{ $consultant->first_name }}</h5>
                                    </a>
                                    <p class="py-2 hover-text">Designation- Consultant</p>
                                    {{-- <span class="text-warning">
                                        <i class="bi bi-star"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <span class="text-secondary">(5)</span>
                                    </span> --}}
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
                                    {{-- <div class="rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <label for="rs-{{ $i }}"
                                                style="background-color: {{ $i <= $roundedRating ? 'orange' : '#000b' }};"></label>
                                        @endfor
                                        <span id="rating-counter">{{ $roundedRating }}</span>
                                    </div> --}}
                                </div>
                            </div>
                            <p class="py-2 text-truncate">{{ $consultant->description }}</p>
                            <div class="border-top">
                                <span><i class="bi bi-geo-alt-fill"></i> {{ $consultant->address }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

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
            {{-- <div class=row>
                @foreach ($consultants as $consultant)
                    <div class="col-lg-3 col-md-6 col-sm-12 col-xs-12" style="margin-bottom:30px;">
                        <div class="box-step step-1"
                            style="background-color:#fff;box-shadow:0 2px 5px rgba(0,0,0,.3);padding:50px 20px;border-radius:12px;height:auto">
                            <h2 style=padding-bottom:18px;font-size:26px> {{ $consultant->first_name }}</h2>
                            <img style=max-width:100%;height:auto;border-radius:5px
                                src="https://drchain.dev/storage/background/propic.jpg" alt="">

                            <button
                                style="background-color:#3C65F5;border:none;display:block;margin:0 auto;padding:15px;margin-top:10px;border-radius:6px;width:100%">

                                <a style="color:#fff;" href="{{ route('consultantdetails', [$consultant->id]) }}">Check
                                    Now</a>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div> --}}



        </div>
    </div>
</section>

<section class="section-box mt-30 mb-0" style="background: rgba(168, 187, 255, 0.84);">
    <div class="container">
        <div class="box-newsletter p-0">
            <div class="row full-content">

                <!-- Image Section -->
                <div class="col-xl-5 col-lg-6 col-md-6 col-12 text-center d-none d-md-block mb-4 mb-md-0">
                    <img src="{{ RvMedia::getImageUrl('https://www.mamtaz.com/storage/covers/group-38979.png') }}"
                        alt="{{ theme_option('site_title') }}" class="img-fluid responsive-img">
                </div>

                <!-- Text Section -->
                <div class="col-xl-7 col-lg-6 col-md-6 col-12 mt-50 text-area">
                    {{-- <h3 class="text-md-newsletterr fw-bold text-white">
                        {!! BaseHelper::clean($config['title']) !!}
                    </h3>
                    <h3 class="text-md-newsletterr fw-bold pt-35" style="color: rgba(5, 38, 78, 1);">
                        Create Your Personal Account Profiles
                    </h3> --}}
                    <div class="mt-80 text-content">
                        <div
                            style="font-size: 16px; margin-top: 10px; margin-bottom: 20px; margin-right: 50px; color: #ffffff">
                            Work Profile is a personality assessment that measures an individual's work personality
                            through their workplace traits, social and emotional traits; as well as the values and
                            aspirations that drive them forward.
                        </div>
                        <a style="background: rgba(249, 166, 32, 1); padding: 13px 60px; border: none; border-radius: 4px; font-size: 16px;"
                            class="btn text-white mt-30 mb-30" href="{{ route('consultants') }}">Create Profile</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<script defer>
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
