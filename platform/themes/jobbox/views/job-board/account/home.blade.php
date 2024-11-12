
@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))

@section('content')
<div class="row">
    <div class="col-lg-4">
        <div class="card-style-1 hover-up">
            <div class="card-image">
            <img src="{{ Theme::asset()->url('imgs/page/dashboard/computer.svg') }}" alt="Total Jobs">
            </div>

            <div class="card-info">
                <div class="card-title">
                    <h3>0
                        <span class="font-sm">Applied Jobs</span>
                    </h3>
                </div>
                <p class="color-text-paragraph-2">All status included</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-style-1 hover-up">
            <div class="card-image">
            <img src="{{ Theme::asset()->url('imgs/page/dashboard/computer.svg') }}" alt="Total Jobs">
            </div>

            <div class="card-info">
                <div class="card-title">
                    <h3>0
                        <span class="font-sm">Saved Jobs</span>
                    </h3>
                </div>
                <p class="color-text-paragraph-2">All status included</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card-style-1 hover-up">
            <div class="card-image">
            <img src="{{ Theme::asset()->url('imgs/page/dashboard/computer.svg') }}" alt="Total Jobs">
            </div>

            <div class="card-info">
                <div class="card-title">
                    <h3>0
                        <span class="font-sm">Matched Jobs</span>
                    </h3>
                </div>
                <p class="color-text-paragraph-2">All status included</p>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6">
        <div class="panel-white">
            <header class="panel-head">
                <h5>New Jobs</h5>
            </header>
            <article class="panel-body">
                <div class="new-member-list">
                    <a href="{{ url('/jobs') }}" class="text-muted">0 new Jobs</a>
                </div>
            </article>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="panel-white">
            <header class="panel-head">
                <h5>Recent activities</h5>
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
                            <a href="{{ route('public.account.jobseekermatch') }}" class="text-muted">{{ __('0 matched profile') }}</a>
                        </li>
                    @endforelse
                </ul>
            </article>
        </div>
    </div>
</div>
<div class="panel-white">
    <header class="panel-head">
        <h4>Matched Jobs</h4>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table align-middle table-nowrap mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="align-middle" scope="col">Job Title</th>
                        <th class="align-middle" scope="col">Company Name</th>
                        <th class="align-middle" scope="col">Job Description</th>
                        <th class="align-middle" scope="col">Salary</th>
                        <th class="align-middle" scope="col">Range</th>
                        <th class="align-middle" scope="col">Expire Date</th>
                        <th class="align-middle" scope="col">Apply</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($resultArray as $row)
                        <tr>
                            <td class="fw-bold">{{ $row->name }}</td>
                            <td>{{ $row->company_name }}</td>
                            <td>{{ $row->description }}</td>
                            <td>{{ $row->salary_from }}</td>
                            <td>{{ $row->salary_range }}</td>
                            <td>{{ $row->expire_date }}</td>
                            <td>
                                <a target="_blank" href="{{ url('jobs/' . Str::slug($row->name, '-')) }}"
                                    class="btn btn-primary">Apply</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
