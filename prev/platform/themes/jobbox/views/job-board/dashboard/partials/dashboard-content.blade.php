<div class="row">
    <div class="col-lg-4">
        <div class="card-style-1 hover-up">
            <div class="card-image">
                <img src="{{ Theme::asset()->url('imgs/page/dashboard/computer.svg') }}" alt="{{ __('Total Jobs') }}">
            </div>

            <div class="card-info">
                <div class="card-title">
                    <h3>{{ $totalJobs }}
                        <span class="font-sm">{{ __('Total Jobs') }}</span>
                    </h3>
                </div>
                <p class="color-text-paragraph-2">{{ __('All status included') }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-style-1 hover-up">
            <div class="card-image">
                <img src="{{ Theme::asset()->url('imgs/page/dashboard/computer.svg') }}" alt="{{ __('Total Companies') }}">
            </div>

            <div class="card-info">
                <div class="card-title">
                    <h3>{{ $totalCompanies }}
                        <span class="font-sm">{{ __('Total Companies') }}</span>
                    </h3>
                </div>
                <p class="color-text-paragraph-2">{{ __('All status included') }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-style-1 hover-up">
            <div class="card-image">
                <img src="{{ Theme::asset()->url('imgs/page/dashboard/computer.svg') }}" alt="{{ __('Total Applicants') }}">
            </div>

            <div class="card-info">
                <div class="card-title">
                    <h3>{{ $totalApplicants }}
                        <span class="font-sm">{{ __('Total Applicants') }}</span>
                    </h3>
                </div>
                <p class="color-text-paragraph-2">{{ __('In :total Jobs', ['total' => $totalJobs]) }}</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="panel-white">
            <header class="panel-head">
                <h5>{{ __('New Applicants') }}</h5>
            </header>
            <article class="panel-body">
                <div class="new-member-list">
                    @forelse ($newApplicants as $item)
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center">
                                <div>
                                    <h6>{{ $item->full_name }}</h6>
                                    <p class="text-muted font-xs">{{ $item->email }}</p>
                                </div>
                            </div>
                            <a href="{{ route('public.account.applicants.edit', $item->id) }}" class="btn btn-xs px-2">
                                <i class="material-icons md-add"></i>
                                <span>{{ __('View') }}</span>
                            </a>
                        </div>
                    @empty
                        <p class="text-muted">{{ __('No new applicants') }}</p>
                    @endforelse
                </div>
            </article>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel-white">
            <header class="panel-head">
                <h5>{{ __('Recent activities') }}</h5>
            </header>
            <article class="panel-body">
                <ul class="verti-timeline list-unstyled font-sm">
                    @forelse ($activities as $activity)
                        <li class="event-list">
                            <div class="event-timeline-dot">
                                <i class="fa-solid fa-clock"></i>
                            </div>
                            <div class="media">
                                <div class="me-3">
                                    <h6 class="text-nowrap">
                                        <span>{{ $activity->created_at->diffForHumans() }} <i class="fa-solid fa-arrow-right-long icon-arrow"></i></span>
                                    </h6>
                                </div>
                                <div class="media-body">
                                    <div>{!! BaseHelper::clean($activity->getDescription(false)) !!}</div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <li>
                            <p class="text-muted">{{ __('No activities') }}</p>
                        </li>
                    @endforelse
                </ul>
            </article>
        </div>
    </div>
</div>
<div class="panel-white">
    <header class="panel-head">
        <h4>{{ __('Jobs are about to expire') }}</h4>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="align-middle" scope="col">{{ __('Job Name') }}</th>
                            <th class="align-middle" scope="col">{{ __('Company') }}</th>
                            <th class="align-middle" scope="col">{{ __('Expire date') }}</th>
                            <th class="align-middle" scope="col">{{ __('Status') }}</th>
                            <th class="align-middle" scope="col">{{ __('Total applicants') }}</th>
                            <th class="align-middle" scope="col">{{ __('View Details') }}</th>
                            <th class="align-middle" scope="col">{{ __('Renew') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($expiredJobs as $job)
                            <tr>
                                <td>
                                    <a href="{{ route('public.account.jobs.edit', $job->id) }}" class="fw-bold">{{ $job->name }}</a>
                                </td>
                                <td>{{ $job->company->name }}</td>
                                <td>{{ BaseHelper::formatDate($job->expire_date) }}</td>
                                <td>{!! $job->status->toHtml() !!}</td>
                                <td>{{ $job->applicants_count }}</td>
                                <td>
                                    <a href="{{ route('public.account.jobs.edit', $job->id) }}" class="btn btn-xs">{{ __('View') }}</a>
                                </td>
                                <td>
                                    @if (auth('account')->user()->canPost())
                                        {!! Form::open([
                                                'url'      => route('public.account.jobs.renew', $job->id),
                                                'id'       => 'form-renew-job-' . $job->id,
                                                'onsubmit' => 'return confirm("' . __('Do you really want to submit the form?') . '");'
                                            ]) !!}
                                        <button type="submit" class="btn btn-xs btn-success">{{ __('Renew') }}</button>
                                        {!! Form::close() !!}
                                    @else
                                        <a href="{{ route('public.account.packages') }}" class="text-info" disabled data-bs-toggle="tooltip" title="{{ __('Please purchase credits to renew this job') }}">{{ __('Buy credits') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
