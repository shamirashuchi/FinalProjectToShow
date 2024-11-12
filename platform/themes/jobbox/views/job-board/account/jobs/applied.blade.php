@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))


@section('content')
    <style>
        .main {
            margin-top: 54px !important;
        }

        .btn-expanded {

            top: 0px !important;

        }

        .nav-item {
            max-width: 140px !important;

        }
    </style>

    <div class="px-5">
        <div class="container py-4 px-5" style="background-color: #f8f9fa; border-radius: 10px;">
            <div class="row align-items-center px-5">
                <div class="col-lg-6">
                    <div>
                        <h6 class="fs-16 mb-0">{{ SeoHelper::getTitle() }}</h6>
                    </div>
                </div>
                <div class="col-lg-6">
                    {{-- <form action="{{ URL::current() }}" method="GET">
                        <div class="candidate-list-widgets">
                            <div class="row justify-content-end">
                                <div class="col-lg-5">
                                    <div class="selection-widget form-group select-style mt-3 mt-lg-0">
                                        <select class="form-control select-active rounded px-3 py-2 shadow-sm h-100"
                                            data-trigger name="order_by" id="choices-single-filter-order_by"
                                            aria-label="Default select example">
                                            <option value="">{{ __('Default') }}</option>
                                            <option value="newest">{{ __('Newest') }}</option>
                                            <option value="oldest">{{ __('Oldest') }}</option>
                                            <option value="random">{{ __('Random') }}</option>
                                        </select>
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-5">
                                    <div class="selection-widget form-group select-style mt-3 mt-lg-0">
                                        <select class="form-control select-active rounded px-3 py-2 shadow-sm h-100"
                                            data-trigger name="order_by" id="choices-single-filter-order_by"
                                            aria-label="Default select example">
                                            <option value="">{{ __('All') }}</option>
                                            <option value="newest">{{ __('data 1') }}</option>
                                            <option value="oldest">{{ __('data 2') }}</option>
                                            <option value="random">{{ __('data 3') }}</option>
                                        </select>
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-2 px-2">
                                    <button
                                        class="btn btn-primary w-100 btn-search-filter d-flex align-items-center justify-content-center h-100 rounded shadow-sm"
                                        style="background-color: #007bff;">
                                        <i class="fi-rr-search me-2"></i> Search
                                    </button>
                                </div>
                            </div><!--end row-->
                        </div><!--end candidate-list-widgets-->
                    </form> --}}
                </div>
            </div>


            {{-- <div class="row">
            <div class="col-lg-12">
                @forelse ($applications as $application)
                    <div class="job-box card mt-4">
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-lg-1">
                                    @if ($application->job->hide_company)
                                        @if (theme_option('logo'))
                                            <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}" width="55"
                                                alt="{{ theme_option('site_title') }}" class="logo-dark" />
                                        @endif
                                    @else
                                        <a href="{{ $application->job->company->url }}">
                                            <img src="{{ $application->job->company->logo_thumb }}" alt="{{ $application->job->company->name }}"
                                                width="55" class="img-fluid rounded-3">
                                        </a>
                                    @endif
                                </div><!--end col-->
                                <div class="col-lg-9">
                                    <div class="mt-3 mt-lg-0">
                                        <h5 class="fs-17 mb-1">
                                            @if ($application->job_url)
                                                <a href="{{ $application->job_url }}" class="text-dark">{{ $application->job->name }}</a>
                                            @else
                                                <span class="text-decoration-line-through">{{ $application->job->name }}</span>
                                            @endif
                                            <small class="text-muted fw-normal">({{ $application->job->jobExperience->name }})</small>
                                        </h5>
                                        <ul class="list-inline mb-0">
                                            @if (!$application->job->hide_company)
                                                <li class="list-inline-item">
                                                    <p class="text-muted fs-14 mb-0">{{ $application->job->company->name }}</p>
                                                </li>
                                            @endif
                                            <li class="list-inline-item">
                                                <p class="text-muted fs-14 mb-0">
                                                    <i class="mdi mdi-map-marker"></i>
                                                    <span>{{ $application->job->full_address }}</span>
                                                </p>
                                            </li>
                                            <li class="list-inline-item">
                                                <p class="text-muted fs-14 mb-0">
                                                    <i class="uil uil-wallet"></i>
                                                    <span>{{ $application->job->salary_text }}</span>
                                                </p>
                                            </li>
                                        </ul>
                                        @if ($application->job->jobTypes->count())
                                            <div class="mt-2">
                                                @foreach ($application->job->jobTypes as $jobType)
                                                    <span class="badge bg-soft-danger mt-1">{{ $jobType->name }}@if (!$loop->last), @endif</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div><!--end col-->
                                <div class="col-lg-2 align-self-center">
                                    <ul class="list-inline mt-3 mb-0">
                                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('View Detail') }}">
                                            @if ($application->job_url)
                                                <a href="{{ $application->job_url }}" class="avatar-sm bg-soft-success d-inline-block text-center rounded-circle fs-18">
                                                    <i class="fi-rr-eye"></i>
                                                </a>
                                            @else
                                                <span class="avatar-sm bg-soft-secondary d-inline-block text-center rounded-circle fs-18">
                                                    <i class="fi-rr-eye"></i>
                                                </span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                            </div><!--end row-->
                        </div>
                    </div><!--end job-box-->
                @empty
                    <div class="alert alert-warning my-2">
                        {{ __('No applied jobs found.') }}
                    </div>
                @endforelse
            </div><!--end col-->
        </div><!--end row--> --}}


            <div class="px-5 py-3">
                <div class="pb-4">
                    <div class="col-md-12 pt-3 pb-4 px-3 mb-5 border border-1 rounded-3 shadow-sm">
                        @forelse ($applications as $application)
                            <div>
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-6 ">
                                        <div class="row align-items-center">

                                            <div class="col-md-1">
                                                @if ($application->job->hide_company)
                                                    @if (theme_option('logo'))
                                                        <img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}"
                                                            width="55" alt="{{ theme_option('site_title') }}"
                                                            class="logo-dark img-fluid" />
                                                    @endif
                                                @else
                                                    <a href="{{ $application->job->company->url }}">
                                                        <img src="{{ $application->job->company->logo_thumb }}"
                                                            alt="{{ $application->job->company->name }}" width="55"
                                                            class="img-fluid rounded-3">
                                                    </a>
                                                @endif
                                            </div>

                                            <div class="col-md-11">
                                                @if (!$application->job->hide_company)
                                                    <h5>{{ $application->job->company->name }}</h5>
                                                @endif
                                                <span class="text-muted"><i
                                                        class="bi bi-geo-alt"></i>{{ $application->job->full_address }}</span>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end d-flex justify-content-end align-items-center">
                                        <span
                                            class="bg-light rounded px-3 py-1">({{ $application->job->jobExperience->name }})</span>
                                    </div>
                                </div>

                                @if ($application->job_url)
                                    <a class="h3 pt-2" href="{{ $application->job_url }}">{{ $application->job->name }}</a>
                                @else
                                    <h3 class="pt-2">{{ $application->job->name }}</h3>
                                @endif

                                <span class="text-muted">
                                    @foreach ($application->job->jobTypes as $jobType)
                                        <span><i class="bi bi-bag-dash px-1"></i>{{ $jobType->name }}@if (!$loop->last)
                                                ,
                                            @endif
                                        </span>
                                    @endforeach
                                    <span><i class="bi bi-clock px-1"></i>6 days ago</span>
                                </span>

                                <p class="my-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt modi ex
                                    nisi eos
                                    eius quas nam numquam culpa dolor, nostrum vero ipsum deserunt iste saepe? Amet dolor
                                    eum
                                    incidunt velit.</p>

                                <span class="d-flex align-items-center justify-content-between w-100">
                                    <span>
                                        <span class="fw-bold text-primary fs-3">{{ $application->job->salary_text }}</span>
                                    </span>
                                    @if ($application->job_url)
                                        <a href="{{ $application->job_url }}" class="btn btn-primary">View Details</a>
                                    @else
                                        <a class="btn btn-primary">View Details</a>
                                    @endif
                                </span>

                            </div>
                            @empty
                                <div class="alert alert-warning my-2">
                                    {{ __('No applied jobs found.') }}
                                </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- <div class="pb-4">
                    <div class="col-md-12 pt-3 pb-4 px-3 mb-5 border border-1 rounded-3 shadow-sm">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-md-1">
                                        <img src="https://via.placeholder.com/52x52" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-md-11">
                                        <h5>Linkedin</h5>
                                        <span class="text-muted"><i class="bi bi-geo-alt"></i>Paris France, FRA</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-end d-flex justify-content-end align-items-center">
                                <span class="bg-light rounded px-3 py-1">Adobe XD</span>
                                <span class="bg-light rounded px-3 py-1">PHP</span>
                            </div>
                        </div>
                        <h3 class="pt-2">UI/UX Designer full-time</h3>
                        <span class="text-muted">
                            <span><i class="bi bi-bag-dash px-1"></i>Freelance</span>
                            <span><i class="bi bi-clock px-1"></i>6 days ago</span>
                        </span>
                        <p class="my-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt modi ex nisi eos
                            eius quas nam numquam culpa dolor, nostrum vero ipsum deserunt iste saepe? Amet dolor eum
                            incidunt velit.</p>
                        <span class="d-flex align-items-center justify-content-between w-100">
                            <span>
                                <span class="fw-bold text-primary fs-3">$5,200 - $900</span>
                                <span>/Yearly</span>
                            </span>
                            <a class="btn btn-primary">View Details</a>
                        </span>

                    </div>
                </div> --}}

                </div>


                <div class="row">
                    <div class="col-lg-12 mt-4 pt-2">
                        {!! $applications->withQueryString()->links(Theme::getThemeNamespace('partials.pagination')) !!}
                    </div><!--end col-->
                </div><!--end row-->
            </div><!--end container-->
        </div><!--end container-->
    @endsection
