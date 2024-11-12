@extends('plugins/job-board::account.layouts.skeleton')
@section('content')
    <h3 class="text-lg leading-6 font-medium text-green-600">
        {{ $title }}
    </h3>
    <div>
        <div class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4 mb-10">
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3 text-center">
                            <i class="far fa-eye h-6 w-6 text-white"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                    {{ __('Total views') }}
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl leading-8 font-semibold text-gray-900">
                                        {{ $job->views }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3 text-center">
                            <i class="fas fa-clock h-6 w-6 text-white"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                    {{ __('Views today') }}
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl leading-8 font-semibold text-gray-900">
                                        {{ $viewsToday }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3 text-center">
                            <i class="far fa-heart h-6 w-6 text-white"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                    {{ __('Number of favorites') }}
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl leading-8 font-semibold text-gray-900">
                                        {{ $numberSaved }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white overflow-hidden shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-md p-3 text-center">
                            <i class="fas fa-users h-6 w-6 text-white"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm leading-5 font-medium text-gray-500 truncate">
                                    {{ __('Applicants') }}
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl leading-8 font-semibold text-gray-900">
                                        {{ $applicants }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="py-2 sm:px-6">
        <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
            <h3 class="text-lg leading-6 font-medium text-gray-900">
                {{ __('Top Referrers') }}
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
                            #
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-start text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('URL') }}
                        </th>
                        <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-start text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                            {{ __('Views') }}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @if ($referrers->count() > 0)
                        @foreach($referrers as $referrer)
                            <tr class="bg-white">
                                <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                    {{ $loop->index + 1 }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                    {{ $referrer->referer }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                    {{ $referrer->total }}
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

        <div class="mt-10">
            <div class="py-2 sm:px-6">
                <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ __('Top Countries') }}
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
                                    #
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-start text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Country') }}
                                </th>
                                <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-start text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                                    {{ __('Views') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($countries->count() > 0)
                                @foreach($countries as $country)
                                    <tr class="bg-white">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                            {{ $loop->index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                            {{ $country->country_full }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                                            {{ $country->total }}
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
