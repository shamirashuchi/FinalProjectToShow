@php
    Theme::asset()->usePath()
                ->add('custom-scrollbar-css', 'plugins/mcustom-scrollbar/jquery.mCustomScrollbar.css');
    Theme::asset()->container('footer')->usePath()
                ->add('custom-scrollbar-js', 'plugins/mcustom-scrollbar/jquery.mCustomScrollbar.js', ['jquery']);
@endphp
<div class="col-lg-3 col-md-12 filter-section col-sm-12 col-12">
    <div class="sidebar-shadow none-shadow mb-30">
        <div class="sidebar-filters">
            {!! Form::open(['url' => route('public.ajax.jobs'), 'method' => 'GET', 'id' => 'jobs-filter-form']) !!}
                <input type="hidden" name="page" data-value="{{ $jobs->currentPage() }}">
                <input type="hidden" name="keyword" value="{{ BaseHelper::stringify(request()->query('keyword')) }}">
                <input type="hidden" name="per_page">
                <input type="hidden" name="layout">
                <input type="hidden" name="sort_by"/>
                @if (isset($jobTags))
                    @foreach($jobTags as $jobTag)
                        <input type="hidden" name="job_tags[]" value="{{ $jobTag }}">
                    @endforeach
                @endif
                <input type="hidden" name="page">
                <div class="filter-block head-border mb-30">
                    <h5>
                        {{ __('Advanced Filters') }}
                        <a class="link-reset" href="{{ request()->url() }}">{{ __('Reset') }}</a>
                    </h5>
                </div>
                <div class="filter-block mb-30">
                    <div class="form-group select-style select-style-icon">
                        @if (is_plugin_active('location'))
                            <select
                                class="form-control submit-form-filter form-icons select-active select-location"
                                form="jobs-filter-form" id="selectCity"
                                name="city_id"
                            >
                            </select>
                            <i class="fi-rr-marker"></i>
                        @endif
                    </div>
                </div>
                <div class="filter-block mb-20">
                    <h5 class="medium-heading mb-15">{{ __('Industry') }}</h5>
                    <div class="form-group ps-custom-scrollbar">
                        <ul class="list-checkbox">
                            @foreach($jobCategories as $jobCategory)
                                <li>
                                    <label class="cb-container">
                                        <input
                                            type="checkbox"
                                            class="submit-form-filter"
                                            name="job_categories[]"
                                            form="jobs-filter-form"
                                            @checked(in_array($jobCategory->id, (array) request()->input('job_categories', [])))
                                            value="{{ $jobCategory->id }}"
                                        >
                                        <span class="text-small">{{ $jobCategory->name }}</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <span class="number-item">{{ $jobCategory->jobs_count ?: 0 }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="filter-block mb-20">
                    <h5 class="medium-heading mb-25">{{ __('Salary range') }}</h5>
                    <div class="list-checkbox pb-20">
                        <div class="row position-relative mt-10 mb-20">
                            <div class="col-sm-12 box-slider-range">
                                <div
                                    id="slider-range"
                                    data-current-range="{{ request()->query('offered_salary_to') > 0 ? BaseHelper::stringify(request()->query('offered_salary_to')) : 0 }}"
                                    data-max-salary-range="{{ $maxSalaryRange }}"
                                ></div>
                            </div>
                            <div class="box-input-money">
                                <input class="input-disabled form-control min-value-money  submit-form-filter" id="minValueMoney" name="offered_salary_to" type="hidden" value="">
                                <input class="form-control max-value" form="jobs-filter-form" type="hidden">
                            </div>
                        </div>
                        <div class="box-number-money">
                            <div class="row mt-30">
                                <div class="col-sm-6 col-6">
                                    <span class="font-sm color-brand-1">{{ format_price(0) }}</span>
                                </div>
                                <div class="col-sm-6 col-6 text-end">
                                    <span class="font-sm color-brand-1">{{ $maxSalaryRange }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="filter-block mb-30">
                    <h5 class="medium-heading mb-10">{{ __('Experience Level') }}</h5>
                    <div class="form-group ps-custom-scrollbar">
                        <ul class="list-checkbox">
                            @foreach($jobExperiences as $jobExperience)
                                <li>
                                    <label class="cb-container">
                                        <input
                                            type="checkbox"
                                            name="job_experiences[]"
                                            class="submit-form-filter"
                                            id="check-job-experience-{{ $jobExperience->id }}" value="{{ $jobExperience->id }}"
                                            form="jobs-filter-form"
                                            @checked(in_array($jobExperience->id, (array) request()->input('job_experiences', [])))
                                        >
                                        <span class="text-small">{{ $jobExperience->name }}</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <span class="number-item">{{ $jobExperience->jobs_count ?: 0 }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="filter-block mb-30">
                    <h5 class="medium-heading mb-10">{{ __('Job Posted') }}</h5>
                    <div class="form-group">
                        <ul class="list-checkbox">
                            @foreach(JobBoardHelper::postedDateRanges() as $key => $item)
                                <li>
                                    <label class="cb-container">
                                        <input
                                            type="checkbox"
                                            class="submit-form-filter"
                                            name="date_posted"
                                            value="{{ $key }}"
                                            id="date-posted-{{ $key }}"
                                            form="jobs-filter-form"
                                            @checked($key == request()->input('date_posted'))
                                        >
                                        <span class="text-small">{{ $item['name'] }}</span>
                                        <span class="checkmark"></span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="filter-block mb-20">
                    <h5 class="medium-heading mb-15">{{ __('Job type') }}</h5>
                    <div class="form-group ps-custom-scrollbar">
                        <ul class="list-checkbox">
                            @foreach($jobTypes as $jobType)
                                <li>
                                    <label class="cb-container">
                                        <input
                                            type="checkbox"
                                            class="submit-form-filter"
                                            value="{{ $jobType->id }}"
                                            name="job_types[]"
                                            id="check-job-type-{{ $jobType->id }}"
                                            form="jobs-filter-form"
                                            @checked(in_array($jobType->id, (array) request()->input('job_types', [])))
                                        >
                                        <span class="text-small">{{ $jobType->name }}</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <span class="number-item">{{ $jobType->jobs_count ?: 0 }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="filter-block mb-20">
                    <h5 class="medium-heading mb-15">{{ __('Skill') }}</h5>
                    <div class="form-group ps-custom-scrollbar">
                        <ul class="list-checkbox">
                            @foreach($jobSkills as $skill)
                                <li>
                                    <label class="cb-container">
                                        <input
                                            type="checkbox"
                                            class="submit-form-filter"
                                            name="job_skills[]"
                                            id="btn-check-outlined-{{ $skill->id }}"
                                            autocomplete="off"
                                            form="jobs-filter-form"
                                            value="{{ $skill->id }}"
                                            @checked(in_array($skill->id, (array) request()->input('job_skills', [])))
                                        >
                                        <span class="text-small">{{ $skill->name }}</span>
                                        <span class="checkmark"></span>
                                    </label>
                                    <span class="number-item">{{ $skill->jobs_count ?: 0 }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
