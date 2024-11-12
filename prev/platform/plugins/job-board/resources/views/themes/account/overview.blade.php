@extends('plugins/job-board::account.layouts.skeleton')
@section('content')
    <div class="crop-avatar bg-white p-4">
        <div class="main-dashboard-form">
            <h4 class="mb-2">{{ trans('plugins/job-board::dashboard.account_field_title') }}</h4>
            <hr>
            <div class="mt-4 md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="avatar-upload-container">
                        <div id="account-avatar mt-2">
                            <div class="profile-image">
                                <div class="avatar-view mt-card-avatar">
                                    <img class="br2" src="{{ $account->avatar_url }}" style="width: 200px;" alt="avatar">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <div class="card-body p-4">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="overview" role="tabpanel"
                                aria-labelledby="overview-tab">
                                <div>
                                    <h5 class="fs-18 fw-bold">{{ __('About') }}</h5>
                                    <p class="text-muted mt-4">
                                        {!! BaseHelper::clean($account->description) !!}
                                    </p>
                                </div>
                                @if ($countEducation = $educations->count())
                                    <div class="candidate-education-details mt-4 pt-3">
                                        <h4 class="fs-17 fw-bold mb-0">{{ __('Education') }}</h4>
                                        @foreach($educations as $education)
                                            <div class="candidate-education-content mt-4 d-flex">
                                                <div class="circle flex-shrink-0 bg-soft-primary">{{ $education->specialized ? strtoupper(substr($education->specialized, 0, 1)) : 'E' }}</div>
                                                <div class="ms-4">
                                                    @if ($education->specialized)
                                                        <h6 class="fs-16 mb-1">{{ $education->specialized }}</h6>
                                                    @endif
                                                    <p class="mb-2 text-muted">{{ $education->school }} -
                                                        ({{ $education->started_at->format('Y') }} -
                                                        {{ $education->ended_at ? $education->ended_at->format('Y'): __('Now') }})
                                                    </p>
                                                    <p class="text-muted">{!! BaseHelper::clean($education->description) !!}</p>
                                                </div>
                                                @if ($countEducation > 1 && ! $loop->last)
                                                    <span class="line"></span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if($countExperience = $experiences->count())
                                    <div class="candidate-education-details mt-4 pt-3">
                                        <h4 class="fs-17 fw-bold mb-0">{{ __('Experience') }}</h4>
                                        @foreach( $experiences as $experience)
                                            <div class="candidate-education-content mt-4 d-flex">
                                                <div class="circle flex-shrink-0 bg-soft-primary"> {{ $experience->position ? strtoupper(substr($experience->position, 0, 1)) : '' }} </div>
                                                <div class="ms-4">
                                                    @if ($experience->position)
                                                        <h6 class="fs-16 mb-1">{{ $experience->position }}</h6>
                                                    @endif
                                                    <p class="mb-2 text-muted">{{ $experience->company }} -
                                                        ({{  $experience->started_at->format('Y') }} -
                                                        {{ $experience->ended_at ? $experience->ended_at->format('Y'): __('Now')}})
                                                    </p>
                                                    <p class="text-muted">{!! BaseHelper::clean($experience->description) !!}</p>
                                                </div>
                                                @if ($countExperience > 1 && ! $loop->last)
                                                    <span class="line"></span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <!--end tab-pane-->
                        </div>
                        <!--end tab-content-->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
