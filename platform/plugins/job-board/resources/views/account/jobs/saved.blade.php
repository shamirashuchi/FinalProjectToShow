@extends('plugins/job-board::account.layouts.skeleton')
@section('content')
    <div class="main-dashboard-form">
        <div class="py-2 border-b border-gray-200 sm:px-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ __('Saved Jobs') }}
                </h3>
            </div>
        </div>
        <div class="flex flex-col">
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
                            @if ($jobs->count() > 0)
                                @foreach($jobs as $job)
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                            @if ($job->moderation_status == \Botble\JobBoard\Enums\ModerationStatusEnum::APPROVED)
                                                <a href="{{ $job->url }}" target="_blank" class="text-blue-500 hover:text-green-600">{{ $job->name }}</a>
                                            @else
                                                {{ $job->name }}
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                            {{ $job->created_at->toDateTimeString() }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                            <a href="{{ $job->url }}" target="_blank" class="text-blue-600 hover:text-green-600 focus:outline-none focus:underline">
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
    </div>
@stop
