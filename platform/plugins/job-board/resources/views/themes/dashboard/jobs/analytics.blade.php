@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))
@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-primary-light">
                        <i class="text-primary material-icons md-work"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">{{ __('Total views') }}</h6>
                        <span>{{ $job->views }}</span>
                        <span class="text-sm">{{ __('All status included') }}</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light">
                        <i class="text-success fas fa-clock"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">{{ __('Views today') }}</h6>
                        <span>{{ $viewsToday }}</span>
                        <span class="text-sm">{{ __('All status included') }}</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light">
                        <i class="text-success far fa-heart"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">{{ __('Number of favorites') }}</h6>
                        <span>{{ $numberSaved }}</span>
                        <span class="text-sm">{{ __('All status included') }}</span>
                    </div>
                </article>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card card-body mb-4">
                <article class="icontext">
                    <span class="icon icon-sm rounded-circle bg-success-light">
                        <i class="text-success fas fa-users"></i>
                    </span>
                    <div class="text">
                        <h6 class="mb-1 card-title">{{ __('Applicants') }}</h6>
                        <span>{{ $applicants }}</span>
                        <span class="text-sm">{{ __('All status included') }}</span>
                    </div>
                </article>
            </div>
        </div>
    </div>
    <div class="card mb-4">
        <header class="card-header">
            <h4 class="card-title">{{ __('Top Referrers') }}</h4>
        </header>
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle" scope="col">#</th>
                                <th class="align-middle" scope="col">{{ __('URL') }}</th>
                                <th class="align-middle" scope="col">{{ __('Views') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($referrers->count() > 0)
                                @foreach($referrers as $referrer)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $referrer->referer }}</td>
                                        <td>{{ $referrer->total }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="bg-white">
                                    <td colspan="4" class="text-center text-sm text-gray-500 py-4">{{ __('No data') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- table-responsive end// -->
        </div>
    </div>

    <div class="card mb-4">
        <header class="card-header">
            <h4 class="card-title">{{ __('Top Countries') }}</h4>
        </header>
        <div class="card-body">
            <div class="table-responsive">
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="align-middle" scope="col">#</th>
                                <th class="align-middle" scope="col">{{ __('Country') }}</th>
                                <th class="align-middle" scope="col">{{ __('Views') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($countries->count() > 0)
                                @foreach($countries as $country)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $country->country_full }}</td>
                                        <td>{{ $country->total }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr class="bg-white">
                                    <td colspan="4" class="text-center text-sm text-gray-500 py-4">{{ __('No data') }}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- table-responsive end// -->
        </div>
    </div>
@stop
