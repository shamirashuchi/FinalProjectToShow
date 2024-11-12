<div class="row">
    <div class="col-lg-4">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-primary-light">
                    <i class="text-primary material-icons md-work"></i>
                </span>
                <div class="text">
                    <h6 class="mb-1 card-title">{{ __('Total Jobs') }}</h6>
                    <span>{{ $totalJobs }}</span>
                    <span class="text-sm">{{ __('All status included') }}</span>
                </div>
            </article>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-success-light">
                    <i class="text-success material-icons md-business"></i>
                </span>
                <div class="text">
                    <h6 class="mb-1 card-title">{{ __('Total Companies') }}</h6>
                    <span>{{ $totalCompanies }}</span>
                    <span class="text-sm">{{ __('All status included') }}</span>
                </div>
            </article>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card card-body mb-4">
            <article class="icontext">
                <span class="icon icon-sm rounded-circle bg-warning-light"><i class="text-warning material-icons md-qr_code"></i></span>
                <div class="text">
                    <h6 class="mb-1 card-title">{{ __('Total Applicants') }}</h6>
                    <span>{{ $totalApplicants }}</span>
                    <span class="text-sm">{{ __('In :total Jobs', ['total' => $totalJobs]) }}</span>
                </div>
            </article>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="card mb-4">
            <article class="card-body">
                <h5 class="card-title">{{ __('New Applicants') }}</h5>
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
        <div class="card mb-4">
            <article class="card-body">
                <h5 class="card-title">{{ __('Recent activities') }}</h5>
                <ul class="verti-timeline list-unstyled font-sm">
                    @forelse ($activities as $item)
                        <li class="event-list">
                            <div class="event-timeline-dot">
                                <i class="material-icons md-play_circle_outline font-xxl"></i>
                            </div>
                            <div class="media">
                                <div class="me-3">
                                    <h6>
                                        <span>{{ $item->created_at->diffForHumans() }}</span>
                                        <i class="material-icons md-trending_flat text-brand ml-15 d-inline-block"></i>
                                    </h6>
                                </div>
                                <div class="media-body">
                                    <div>{!! BaseHelper::clean($item->getDescription(false)) !!}</div>
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
<div class="card mb-4">
    <header class="card-header">
        <h4 class="card-title">{{ __('Jobs are about to expire') }}</h4>
    </header>
    <div class="card-body">
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
                                        <a href="{{ route('public.account.packages') }}" class="text-info"
                                            disabled data-bs-toggle="tooltip" title="{{ __('Please purchase credits to renew this job') }}">{{ __('Buy credits') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- table-responsive end// -->
    </div>
</div>
