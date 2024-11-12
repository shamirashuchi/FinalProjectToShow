@extends('plugins/job-board::account.layouts.skeleton')
@section('content')
    @if ($account->isEmployer())
        <div class="mt-4 grid gap-5 max-w-lg mx-auto lg:grid-cols-3 lg:max-w-none">
            <div class="flex flex-col">
                <div class="white">
                    <div class="br2 p-6 bg-light-blue mb3" style="box-shadow: 0 1px 1px #ccc;">
                        <div class="media-body">
                            <div class="f3">
                                <span
                                    class="fw6">{{ $account->jobs()->where(JobBoardHelper::getJobDisplayQueryConditions())->count() }}</span>
                                <span class="fr"><i class="far fa-check-circle"></i></span>
                            </div>
                            <p>{{ trans('plugins/job-board::dashboard.active_jobs') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="white">
                    <div class="br2 p-6 bg-light-red mb3" style="box-shadow: 0 1px 1px #ccc;">
                        <div class="media-body">
                            <div class="f3">
                                <span
                                    class="fw6">{{ $account->jobs()->expired()->count() }}</span>
                                <span class="fr"><i class="fas fa-user-clock"></i></span>
                            </div>
                            <p>{{ trans('plugins/job-board::dashboard.expired_jobs') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-col">
                <div class="white">
                    <div class="br2 p-6 bg-light-silver mb3" style="box-shadow: 0 1px 1px #ccc;">
                        <div class="media-body">
                            <div class="f3">
                                <span
                                    class="fw6">{{ $account->jobs()->where('status', \Botble\Base\Enums\BaseStatusEnum::DRAFT)->count() }}</span>
                                <span class="fr"><i class="far fa-edit"></i></span>
                            </div>
                            <p>{{ trans('plugins/job-board::dashboard.draft_jobs') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($account->isEmployer())
        <div class="flex flex-col mb-10 mt-10">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    @include('plugins/job-board::account.jobs.partials.job-table', compact('jobs'))
                </div>
            </div>
        </div>
    @else
        <div class="py-2 sm:px-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ __('Applied jobs') }}
                </h3>
            </div>
        </div>
        <div class="flex flex-col mb-10">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full" id="job-table">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-start text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Job title') }}
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-start text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Applied date') }}
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($applications->count() > 0)
                            @foreach($applications as $application)
                                <tr class="bg-white">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                        @if ($application->job->moderation_status == \Botble\JobBoard\Enums\ModerationStatusEnum::APPROVED)
                                            <a href="{{ $application->job->url }}" target="_blank" class="text-blue-500 hover:text-green-600">{{ $application->job->name }}</a>
                                        @else
                                            {{ $application->job->name }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                        {{ $application->created_at->toDateTimeString() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                        <a href="{{ route('public.account.applicants.edit', $application->id) }}" class="text-blue-600 hover:text-green-600 focus:outline-none focus:underline">
                                            {{ __('View application') }}
                                        </a>
                                    </td>
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
        </div>

        <div class="py-2 sm:px-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ __('Saved jobs') }}
                </h3>
            </div>
        </div>
        <div class="flex flex-col mb-10">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    <table class="min-w-full" id="job-table">
                        <thead>
                        <tr>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-start text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Job title') }}
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-start text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                {{ __('Created date') }}
                            </th>
                            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
                        </tr>
                        </thead>
                        <tbody>
                        @if ($savedJobs->count() > 0)
                            @foreach($savedJobs as $savedJob)
                                <tr class="bg-white">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                        @if ($savedJob->moderation_status == \Botble\JobBoard\Enums\ModerationStatusEnum::APPROVED)
                                            <a href="{{ $savedJob->url }}" target="_blank" class="text-blue-500 hover:text-green-600">{{ $savedJob->name }}</a>
                                        @else
                                            {{ $savedJob->name }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                        {{ $savedJob->created_at->toDateTimeString() }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                        <a href="{{ $savedJob->url }}" target="_blank" class="text-blue-600 hover:text-green-600 focus:outline-none focus:underline">
                                            {{ __('View') }}
                                        </a>
                                    </td>
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
        </div>
    @endif

    <activity-log-component default-active-tab="activity-logs"></activity-log-component>

@endsection
