
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
                        <span class="font-sm">Meeting Booked With Job Seeker</span>
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
                        <span class="font-sm">Verification Request</span>
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
                        <span class="font-sm">Meeting Booked With Employers</span>
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
                <h5>Order Placed</h5>
            </header>
            <article class="panel-body">
                <div class="new-member-list">
                    <a href="{{ url('/jobs') }}" class="text-muted">0 new orders</a>
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
                            <a href="{{ route('public.account.jobseekermatch') }}" class="text-muted">{{ __('No Activites') }}</a>
                        </li>
                    @endforelse
                </ul>
            </article>
        </div>
    </div>
</div>
<div class="panel-white">
    <header class="panel-head">
        <h4>Work Orders</h4>
    </header>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table align-middle table-nowrap mb-0">

                <thead class="table-light">
                    <tr>
                        <th class="align-middle" scope="col">Orders Title</th>
                        <th class="align-middle" scope="col">Company Name</th>
                        <th class="align-middle" scope="col">Expire date</th>
                        <th class="align-middle" scope="col">Status</th>
                        <th class="align-middle" scope="col">Total Orders</th>
                        <th class="align-middle" scope="col">View Details</th>
                    </tr>
                </thead>

                <tbody>
                        <tr>
                            <td class="fw-bold"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                </tbody>

            </table>
        </div>
    </div>
</div>
@endsection
