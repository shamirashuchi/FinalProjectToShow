<style>
    .center {
    margin-left: auto;
    margin-right: auto;
}
.form-input {
            display: block;
        }
        input[type=text]{
            padding-left: 0px;
            height: 45px;
            font-size: 15px;
        }

        .setSearch{
            margin-left: 25px;
            margin-right: 15px;
        }
        .setBtn{
            margin-top:10px;
            margin-bottom:10px;
        }
        .setLocation{
            margin-left: 20px;
            margin-right: -35px;
        }
        .setIndustry{
            margin-left: 20px;
            margin-right: -35px;
        }

        @media (max-width: 1599.98px) {
                .setLocation{
                    margin-left: 17px;
                    margin-right: -31px;
                }
                .setIndustry{
                    margin-left: 17px;
                    margin-right: -31px;
                }
            }

            @media (max-width: 1400px) {
                .setLocation{
                    margin-left: 10px;
                    margin-right: -18px;
                }
                .setIndustry{
                    margin-left: 10px;
                    margin-right: -18px;
                }
            }

            @media (max-width: 1300px) {
                .setLocation{
                    margin-left: 5px;
                    margin-right: -9px;
                }
                .setIndustry{
                    margin-left: 5px;
                    margin-right: -9px;
                }
            }

            @media (max-width: 1199.98px) {
                .setSearch{
                    margin-left: 31px;
                }

                .setLocation{
                    margin-left: 21px;
                    margin-right: -62px;
                }
                .setIndustry{
                    margin-left: 21px;
                    margin-right: -62px;
                }
            }

            @media (max-width: 991px) {
                    .wrap{
                        padding-left: 24px;
                        padding-right: 24px;
                    }
                    .setSearch{
                        margin-left: 15px;
                    }
                }

                @media (max-width: 767.98px) {
                    .setLocation{
                        margin-left: 6px;
                        margin-right: -12px;
                    }
                    .setIndustry{
                        margin-left: 6px;
                        margin-right: -12px;
                    }
                }
</style>


@if (is_plugin_active('job-board'))
@if (request()->is('/'))
<div class="wrap center" style="width: {{ request()->is('/') ? '70%' : '110%' }};">
    <div class="p-5 rounded" style="background-color: rgba(255, 255, 255, 0.5);">
        {!! Form::open(['url' => JobBoardHelper::getJobsPageURL(), 'method' => 'GET']) !!}
        <div class="row g-3 d-flex align-items-center">

            <div class="col-12 col-sm-6 col-md-6 col-xl-3">
                <div class="bg-white rounded h-70 align-items-center">
                @if (!isset($style))
                    <div class="d-flex justify-content-center   align-items-center w-100 ">
                        <i class="bi bi-search setSearch" style=" width:15; height:15"></i>
                        <input id="search-input"  class="form-input w-100" name="keyword"  type="text" value="{{ BaseHelper::stringify(request()->query('keyword')) }}" placeholder="{{ __('Search...') }}" style="border: none;">
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-xl-3">
                <div class="bg-light rounded p-2 h-100 align-items-center">
                    @if (is_plugin_active('location'))
                    <div class="d-flex align-items-center">
                        <i class="bi bi-geo-alt fs-5 mr-2 setLocation" style=" width:15; height:15"></i>
                        <select class="form-input select-location w-100" name="city_id">
                            <option value="">{{ __('Location') }}</option>
                        </select>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-xl-3">
                <div class="bg-light rounded p-2 h-100 align-items-center">
                    @if (is_plugin_active('job-board'))
                    <div class="d-flex align-items-center">
                        <i class="bi bi-briefcase fs-5 setIndustry" style=" width:15; height:15"></i>
                        <select class="form-input select-active input-industry job-category w-100" name="job_categories[]">
                            <option value="">{{ __('Industry') }}</option>
                        </select>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-12 col-sm-6 col-md-6 col-xl-3">
                <div class="px-2 d-flex align-items-center justify-content-center h-100">
                    <button class="btn btn-default font-sm w-100 setBtn" style="background-color: #F9A620">{{ __('Search') }}</button>
                </div>
        </div>

        </div>
        {!! Form::close() !!}
    </div>
</div>

<script>
    function updatePlaceholder() {
        const input = document.getElementById('search-input');
        console.log(input);
        const screenWidth = window.innerWidth;

        if (screenWidth >= 560 && screenWidth <= 1600) {
            input.placeholder = "Search";
        } else {
            input.placeholder = "{{ __('Search...') }}";
        }
    }

    window.addEventListener('resize', updatePlaceholder);
</script>

@endif


@if (request()->is('jobs'))
<div class="wrap center" style="margin-top:10px;">
    <div class="rounded customBox">
        {!! Form::open(['url' => JobBoardHelper::getJobsPageURL(), 'method' => 'GET']) !!}
        <div class="row d-flex align-items-center" style="padding-left: 1.5rem !important">

            <div class="col-3 col-sm-3 col-md-3 col-xl-3">
                <div class="bg-white rounded h-90 align-items-center">
                    @if (!isset($style))
                    <div class="d-flex justify-content-center align-items-center w-100">

                        <svg class="bg-white" width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g clip-path="url(#clip0_1_604)">
                            <mask id="mask0_1_604" style="mask-type:luminance" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                            <path d="M14.73 0.5H0.72998V14.5H14.73V0.5Z" fill="white"/>
                            </mask>
                            <g mask="url(#mask0_1_604)">
                            <path d="M2.73003 4.49998C1.6272 4.49998 0.72998 3.60298 0.72998 2.50005C0.72998 1.397 1.6272 0.5 2.73003 0.5C3.83275 0.5 4.72996 1.397 4.72996 2.50005C4.72996 3.60298 3.83275 4.49998 2.73003 4.49998ZM2.73003 1.49997C2.17845 1.49997 1.72995 1.94879 1.72995 2.50005C1.72995 3.0513 2.17845 3.50002 2.73003 3.50002C3.28149 3.50002 3.73 3.0513 3.73 2.50005C3.73 1.94879 3.28149 1.49997 2.73003 1.49997Z" fill="#A0ABB8"/>
                            <path d="M7.73 4.49998C6.62717 4.49998 5.72995 3.60298 5.72995 2.50005C5.72995 1.397 6.62717 0.5 7.73 0.5C8.83282 0.5 9.73004 1.397 9.73004 2.50005C9.73004 3.60298 8.83282 4.49998 7.73 4.49998ZM7.73 1.49997C7.17853 1.49997 6.73003 1.94879 6.73003 2.50005C6.73003 3.0513 7.17853 3.50002 7.73 3.50002C8.28146 3.50002 8.72996 3.0513 8.72996 2.50005C8.72996 1.94879 8.28146 1.49997 7.73 1.49997Z" fill="#A0ABB8"/>
                            <path d="M12.73 4.49998C11.6272 4.49998 10.73 3.60298 10.73 2.50005C10.73 1.397 11.6272 0.5 12.73 0.5C13.8328 0.5 14.73 1.397 14.73 2.50005C14.73 3.60298 13.8328 4.49998 12.73 4.49998ZM12.73 1.49997C12.1785 1.49997 11.73 1.94879 11.73 2.50005C11.73 3.0513 12.1785 3.50002 12.73 3.50002C13.2815 3.50002 13.73 3.0513 13.73 2.50005C13.73 1.94879 13.2815 1.49997 12.73 1.49997Z" fill="#A0ABB8"/>
                            <path d="M2.73003 9.5001C1.6272 9.5001 0.72998 8.60309 0.72998 7.50005C0.72998 6.39701 1.6272 5.5 2.73003 5.5C3.83275 5.5 4.72996 6.39701 4.72996 7.50005C4.72996 8.60309 3.83275 9.5001 2.73003 9.5001ZM2.73003 6.50008C2.17845 6.50008 1.72995 6.9488 1.72995 7.50005C1.72995 8.0513 2.17845 8.50002 2.73003 8.50002C3.28149 8.50002 3.73 8.0513 3.73 7.50005C3.73 6.9488 3.28149 6.50008 2.73003 6.50008Z" fill="#A0ABB8"/>
                            <path d="M7.73 9.5001C6.62717 9.5001 5.72995 8.60309 5.72995 7.50005C5.72995 6.39701 6.62717 5.5 7.73 5.5C8.83282 5.5 9.73004 6.39701 9.73004 7.50005C9.73004 8.60309 8.83282 9.5001 7.73 9.5001ZM7.73 6.50008C7.17853 6.50008 6.73003 6.9488 6.73003 7.50005C6.73003 8.0513 7.17853 8.50002 7.73 8.50002C8.28146 8.50002 8.72996 8.0513 8.72996 7.50005C8.72996 6.9488 8.28146 6.50008 7.73 6.50008Z" fill="#A0ABB8"/>
                            <path d="M12.73 9.5001C11.6272 9.5001 10.73 8.60309 10.73 7.50005C10.73 6.39701 11.6272 5.5 12.73 5.5C13.8328 5.5 14.73 6.39701 14.73 7.50005C14.73 8.60309 13.8328 9.5001 12.73 9.5001ZM12.73 6.50008C12.1785 6.50008 11.73 6.9488 11.73 7.50005C11.73 8.0513 12.1785 8.50002 12.73 8.50002C13.2815 8.50002 13.73 8.0513 13.73 7.50005C13.73 6.9488 13.2815 6.50008 12.73 6.50008Z" fill="#A0ABB8"/>
                            <path d="M2.73003 14.5C1.6272 14.5 0.72998 13.603 0.72998 12.5C0.72998 11.397 1.6272 10.5 2.73003 10.5C3.83275 10.5 4.72996 11.397 4.72996 12.5C4.72996 13.603 3.83275 14.5 2.73003 14.5ZM2.73003 11.5C2.17845 11.5 1.72995 11.9487 1.72995 12.5C1.72995 13.0512 2.17845 13.5 2.73003 13.5C3.28149 13.5 3.73 13.0512 3.73 12.5C3.73 11.9487 3.28149 11.5 2.73003 11.5Z" fill="#A0ABB8"/>
                            <path d="M7.73 14.5C6.62717 14.5 5.72995 13.603 5.72995 12.5C5.72995 11.397 6.62717 10.5 7.73 10.5C8.83282 10.5 9.73004 11.397 9.73004 12.5C9.73004 13.603 8.83282 14.5 7.73 14.5ZM7.73 11.5C7.17853 11.5 6.73003 11.9487 6.73003 12.5C6.73003 13.0512 7.17853 13.5 7.73 13.5C8.28146 13.5 8.72996 13.0512 8.72996 12.5C8.72996 11.9487 8.28146 11.5 7.73 11.5Z" fill="#A0ABB8"/>
                            <path d="M12.73 14.5C11.6272 14.5 10.73 13.603 10.73 12.5C10.73 11.397 11.6272 10.5 12.73 10.5C13.8328 10.5 14.73 11.397 14.73 12.5C14.73 13.603 13.8328 14.5 12.73 14.5ZM12.73 11.5C12.1785 11.5 11.73 11.9487 11.73 12.5C11.73 13.0512 12.1785 13.5 12.73 13.5C13.2815 13.5 13.73 13.0512 13.73 12.5C13.73 11.9487 13.2815 11.5 12.73 11.5Z" fill="#A0ABB8"/>
                            </g>
                            </g>
                            <defs>
                            <clipPath id="clip0_1_604">
                            <rect width="24" height="24" fill="white" transform="translate(0.72998 0.5)"/>
                            </clipPath>
                            </defs>
                        </svg>

                        <input class="w-100" name="keyword" value="{{ BaseHelper::stringify(request()->query('keyword')) }}" type="text" placeholder="{{ __('Your keyword...') }}" style="border: none;padding-left:0px;">
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-3 col-sm-3 col-md-3 col-xl-3 ">
                <div class="rounded  align-items-center">
                    @if (is_plugin_active('location'))
                    <div class="d-flex justify-content-center align-items-center">
                        <i class="bi bi-geo-alt mr-2"></i>
                        <select class="form-input select-location w-70" name="city_id">
                            <option value="">{{ __('Location') }}</option>
                        </select>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-3 col-sm-3 col-md-3 col-xl-3 ">
                <div class=" rounded  h-100 align-items-center ">
                    @if (is_plugin_active('job-board'))
                    <div class="d-flex justify-content-center align-items-center giveJobMargin">
                        <i class="bi bi-briefcase ms-lg-2 ms-md-2 ms-sm-0 "></i>
                        <select class="form-input select-active input-industry job-category w-70" name="job_categories[]">
                            <option value="">{{ __('Industry') }}</option>
                        </select>
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-3 col-sm-3 col-md-3 col-xl-3">
                    <div class="px-2 d-flex align-items-center justify-content-center h-50 ">
                        <button class="btn btn-default font-sm py-lg-2 py-md-2 py-sm-0 px-3 mt-2" style="background-color: #F9A620"> <i class="bi bi-search btnSearch" ></i>{{ __('Search') }}</button>
                    </div>
            </div>

        </div>
        {!! Form::close() !!}
    </div>
</div>
    <style>
        .customBox{
            background-color: white; height: 60px;
        }
        .giveJobMargin{
            margin-bottom:0px;
        }
        .btnSearch{
            margin-left: 9px; height:3px; width:3px; margin-right: 3px
        }

        @media (max-width: 1199px) {
    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
    }
}

@media (max-width: 767px) {
    .col-md-6 {
        flex: 0 0 100%;
        max-width: 100%;
    }
}
        /* @media (max-width: 576px) {
            .customBox {
                height: 100px;
            }
            .giveJobMargin{
                margin-bottom:10px;
            }
            .btnSearch{
                margin-left: 0px; height:3px; width:3px; margin-right: 3px
            }
        } */
    </style>
@endif








    @if ($trendingKeywords)
        <div class="list-tags-banner mt-10 wow animate__animated animate__fadeInUp text-white" data-wow-delay=".3s">
            <strong class="color-white">{{ __('Popular Searches') }}: </strong>
            @if ($keywords = array_map('trim', array_filter(explode(',', $trendingKeywords))))

                @foreach ($keywords as $item)
                    <a class="color-white" href="{{ JobBoardHelper::getJobsPageURL() . '?keyword=' . $item }}">{{ $item }}</a> {{ !$loop->last ? ',' : '' }}
                @endforeach
            @endif
        </div>
    @endif

@endif
