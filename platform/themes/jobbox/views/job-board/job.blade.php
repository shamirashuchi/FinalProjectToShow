@php
    Theme::asset()->usePath()->add('leaflet-css', 'plugins/leaflet/leaflet.css');
    Theme::asset()->container('footer')->usePath()->add('leaflet-js', 'plugins/leaflet/leaflet.js');
@endphp

<section class="section-box-2">
    <div class="container">
        <div class="banner-hero banner-image-single">
            @if(! $job->hide_company && $company->id)
                <img src="{{ $company->cover_image_url }}" alt="{{ $company->name }}">
            @else
                <img src="{{ RvMedia::getImageUrl(theme_option('default_company_cover_image'), null, false, RvMedia::getDefaultImage()) }}" alt="{{ $company->name }}">
            @endif
        </div>
        <div class="row mt-10">
            <div class="col-lg-8 col-md-12">
                <h3>{{ $job->name }}
                    @if ($job->canShowSavedJob() && auth('account')->check())
                        <span @class(['ml-5', 'job-bookmark-saved', 'save-job-active' => $job->is_saved != 0])>
                            <a class="job-bookmark-action align-middle" href="{{ route('public.account.jobs.saved.action') }}" data-job-id="{{ $job->id }}">
                                <div class="d-inline-block favorite-icon">
                                    <span class="fi-rr-heart"></span>
                                </div>
                            </a>
                        </span>
                    @endif
                </h3>
                <div class="mt-0 mb-15">
                    @foreach($job->jobTypes as $jobType)
                        <span class="card-briefcase">{{ $jobType->name }}</span>
                    @endforeach
                    <span class="card-time">{{ $job->created_at->diffForHumans() }}</span>
                </div>
            </div>
            
           
           @if($job->apply_url == null)
           
            @php($classButtonApply = 'btn btn-apply-icon btn-apply btn-apply-big hover-up')
            {!! Theme::partial('apply-button', [
                'job' => $job,
                'class' => $classButtonApply,
             ]) !!}
             
           @else
             
             <div class="row align-items-center">
                        <div class="col-md-5">
                            <a target="_blank" href="{{ $job->apply_url }}" class="btn btn-default mr-15">Apply on Indeed</a>
                        </div>
                    </div>
             
           @endif     
             
             
             
             
             
        </div>
        <div class="border-bottom pt-10 pb-10"></div>
    </div>
</section>

<section class="section-box mt-50 job-detail-section">
    <div class="container">
        <div class="row">
            <div @class(['col-md-12 col-sm-12 col-12', 'col-lg-8' => (! $job->hide_company && $company->id)])>
                <div class="job-overview">
                    <h5 class="border-bottom pb-15 mb-30">{{ __('Employment Information') }}</h5>
                    <div class="row">
                        @if($job->categories->isNotEmpty())
                            <div class="col-md-6 d-flex mt-15">
                                <div class="sidebar-icon-item">
                                    <img src="{{ Theme::asset()->url('/imgs/page/job-single/industry.svg') }}" alt="{{ __('Industry') }}">
                                </div>
                                <div class="sidebar-text-info ml-10">
                                    <span class="text-description industry-icon mb-10">{{ __('Industry') }}</span>
                                    <span class="small-heading">
                                        @foreach ($job->categories as $category)
                                            {{ $category->name }} @if (! $loop->last) / @endif
                                        @endforeach
                                    </span>
                                </div>
                            </div>
                        @endif

                        @if($job->careerLevel->name)
                            <div class="col-md-6 d-flex mt-15">
                                <div class="sidebar-icon-item">
                                    <img src="{{ Theme::asset()->url('imgs/page/job-single/job-level.svg') }}" alt="{{ __('Job level') }}">
                                </div>
                                <div class="sidebar-text-info ml-10">
                                    <span class="text-description joblevel-icon mb-10">{{ __('Job level') }}</span>
                                    <strong class="small-heading">{{ $job->careerLevel->name }}</strong>
                                </div>
                            </div>
                        @endif

                        @if($job->salary_from || $job->salary_to)
                            <div class="col-md-6 d-flex mt-15">
                                <div class="sidebar-icon-item">
                                    <img src="{{ Theme::asset()->url('imgs/page/job-single/salary.svg') }}" alt="{{ __('Salary') }}">
                                </div>
                                <div class="sidebar-text-info ml-10">
                                    <span class="text-description salary-icon mb-10">{{ __('Salary') }}</span>
                                    <strong class="small-heading text-primary fw-bold">{{ $job->salary_text }}</strong>
                                </div>
                            </div>
                        @endif

                        @if($job->jobExperience->name)
                            <div class="col-md-6 d-flex mt-15">
                                <div class="sidebar-icon-item">
                                    <img src="{{ Theme::asset()->url('imgs/page/job-single/experience.svg') }}" alt="{{ __('Experience') }}">
                                </div>
                                <div class="sidebar-text-info ml-10">
                                    <span class="text-description experience-icon mb-10">{{ __('Experience') }}</span>
                                    <strong class="small-heading">{{ $job->jobExperience->name }}</strong>
                                </div>
                            </div>
                        @endif

                        @if($job->jobTypes->isNotEmpty())
                            <div class="col-md-6 d-flex mt-15">
                                <div class="sidebar-icon-item">
                                    <img src="{{ Theme::asset()->url('imgs/page/job-single/job-type.svg') }}" alt="{{ __('Job type') }}">
                                </div>
                                <div class="sidebar-text-info ml-10">
                                    <span class="text-description jobtype-icon mb-10">{{ __('Job type') }}</span>
                                    @foreach($job->jobTypes as $jobType)
                                        <strong class="small-heading">{{ $jobType->name }} @if(!$loop->last), @endif</strong>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($job->full_address)
                            <div class="col-md-6 d-flex mt-15">
                                <div class="sidebar-icon-item">
                                    <img src="{{ Theme::asset()->url('imgs/page/job-single/location.svg') }}" alt="{{ __('Location') }}">
                                </div>
                                <div class="sidebar-text-info ml-10">
                                    <span class="text-description mb-10">{{ __('Location') }}</span>
                                    <strong class="small-heading">{{ $job->full_address }}</strong>
                                </div>
                            </div>
                        @endif

                        @if ($job->application_closing_date)
                                <div class="col-md-6 d-flex mt-15">
                                    <div class="sidebar-icon-item">
                                        <img src="{{ Theme::asset()->url('imgs/page/job-single/deadline.svg') }}" alt="{{ __('Apply Before') }}">
                                    </div>
                                <div class="sidebar-text-info ml-10">
                                    <span class="text-description mb-10">{{ __('Apply Before') }}</span>
                                    <strong class="small-heading text-danger">{{ $job->application_closing_date->translatedFormat('d M, Y') }}</strong>
                                </div>
                            </div>
                        @endif

                        @foreach($job->customFields as $customField)
                            <div class="col-md-6 d-flex mt-15">
                                <div class="sidebar-icon-item">
                                    <img src="{{ Theme::asset()->url('imgs/page/job-single/updated.svg') }}" alt="{{ $customField->name }}">
                                </div>
                                <div class="sidebar-text-info ml-10">
                                    <span class="text-description mb-10">{{ $customField->name }}</span>
                                    <strong class="small-heading">{{ $customField->value }}</strong>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="content-single">
                    {!! BaseHelper::clean($job->content) !!}
                </div>

                @if ($job->skills->isNotEmpty())
                    <div class="mt-4">
                        <h5 class="mb-3">{{ __('Skills') }}</h5>
                        <div class="job-details-desc">
                            <div class="mt-4">
                                @foreach ($job->skills as $skill)
                                    <span class="badge bg-primary me-1">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if ($job->tags->isNotEmpty())
                    <div class="mt-4">
                        <h5 class="mb-3">{{ __('Tags') }}</h5>
                        <div class="job-details-desc">
                            <div class="mt-4">
                                @foreach ($job->tags as $tag)
                                    <a href="{{ $tag->url }}">
                                        <span class="badge bg-info me-1">{{ $tag->name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if ($job->latitude && $job->longitude)
                    <div class="mt-4">
                        <h6 class="fs-16 mb-3">{{ __('Job location') }}</h6>
                        <div class="job-board-street-map-container">
                            <div
                                class="job-board-street-map"
                                data-popup-id="#street-map-popup-template"
                                data-center="{{ json_encode([$job->latitude, $job->longitude]) }}"
                                data-map-icon="{{ $job->salary_text }}"
                            ></div>
                        </div>
                        <div class="d-none" id="street-map-popup-template">
                            <div>
                                <table width="100%">
                                    <tr>
                                        <td width="60" class="image-company">
                                            <div>
                                                <img src="{{ $job->company_logo_thumb }}" width="40" alt="{{ $job->hide_company ? $job->company_name : $job->name }}">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="infomarker">
                                                @if ($job->has_company)
                                                    <h5>
                                                        <a href="{{ $company->url }}" target="_blank">{{ $company->name }}</a>
                                                    </h5>
                                                @endif
                                                <div class="text-info">
                                                    <strong>{{ $job->name }}</strong>
                                                </div>
                                                <div class="text-info">
                                                    <i class="mdi mdi-account"></i>
                                                    <span>{{ __(':number Vacancy', ['number' => $job->number_of_positions])}}</span>
                                                    @if ($job->jobTypes->isNotEmpty())
                                                        <span>-</span>
                                                        @foreach($job->jobTypes as $jobType)
                                                            <span>{{ $jobType->name }}@if (! $loop->last), @endif</span>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                @if ($job->full_address)
                                                    <div class="text-muted">
                                                        <i class="uil uil-map"></i>
                                                        <span>{{ $job->full_address }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="single-apply-jobs">
                    
                    
                    @if($job->apply_url == null)
                    
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            @php($classButtonApplyBottom = 'btn btn-default mr-15')
                            {!! Theme::partial('apply-button', [
                                'job' => $job,
                                'class' => $classButtonApplyBottom
                            ]) !!}
                        </div>

                        @include(Theme::getThemeNamespace('views.job-board.partials.share'), ['job' => $job])
                    </div>
                    
                    @else
                    
                    <div class="row align-items-center">
                        <div class="col-md-5">
                            <a target="_blank" href="{{ $job->apply_url }}" class="btn btn-default mr-15">Apply on Indeed</a>
                        </div>
                    </div>
                    
                    @endif
                    
                    
                    
                    
                </div>
                
                
                
                
                
            </div>
            @if(! $job->hide_company && $company->id)
                <div class="col-lg-4 col-md-12 col-sm-12 col-12 pl-40 pl-lg-15 mt-lg-30">
                    <div class="sidebar-border">
                        <div class="sidebar-heading">
                            <div class="avatar-sidebar">
                                <figure>
                                    <img alt="{{ $company->name }}" src="{{ $company->logo_thumb }}">
                                </figure>
                                <div class="sidebar-info">
                                    <span class="sidebar-company">{{ $company->name }}</span>
                                    <a class="link-underline mt-15" href="{{ $company->url }}">{{ __(':jobs Open Jobs', ['jobs' => $company->jobs_count]) }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="sidebar-list-job">
                            <ul class="ul-disc">
                                <li>{{ $company->address }}</li>
                                <li>{{ __('Website') }}: {{ $company->website }}</li>
                                <li>{{ __('Phone') }}: {{ $company->phone }}</li>
                            </ul>
                        </div>
                    </div>
                    @if(!$job->hide_company && $companyJobs->count())
                        <div class="sidebar-border">
                            <h6 class="f-18">{{ __('Similar jobs') }}</h6>
                            <div class="sidebar-list-job">
                                <ul>
                                    @foreach ($companyJobs as $companyJob)
                                        <li>
                                            <div class="card-list-4 wow animate__ animate__fadeIn hover-up animated" style="visibility: visible; animation-name: fadeIn;">
                                                <div class="image">
                                                    <a href="{{ $companyJob->company->url }}">
                                                        <img src="{{ $companyJob->company->logo_thumb }}" width="50" alt="{{ $companyJob->company->name }}">
                                                    </a>
                                                </div>
                                                <div class="info-text">
                                                    <h5 class="font-md font-bold color-brand-1">
                                                        <a href="{{ $companyJob->url }}">{{ $companyJob->name }}</a>
                                                    </h5>
                                                    <div class="d-flex align-items-center gap-3 font-xs color-text-mutted mt-0">
                                                        <span class="fi-icon"><i class="fi-rr-briefcase"></i>
                                                            @if($job->jobTypes->isNotEmpty())
                                                                @foreach($job->jobTypes as $jobType)
                                                                    {{ $jobType->name }}
                                                                    @if (!$loop->last)
                                                                        ,
                                                                    @endif
                                                                @endforeach
                                                            @endif
                                                        </span>
                                                        <span class="fi-icon"><i class="fi-rr-clock"></i>
                                                            <time datetime="{{ $companyJob->created_at->format('Y/m/d') }}">
                                                                {{ $companyJob->created_at->translatedFormat('M d, Y') }}
                                                            </time>
                                                        </span>
                                                    </div>
                                                    <div class="mt-6">
                                                        <div class="row align-items-center">
                                                            <div class="col-6">
                                                                <h6 class="card-price mb-0">
                                                                    {!! Theme::partial('salary', ['job' => $companyJob]) !!}
                                                                </h6>
                                                            </div>
                                                            <div class="col-6 text-end">
                                                                <span class="card-location">{{ $companyJob->location }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</section>
