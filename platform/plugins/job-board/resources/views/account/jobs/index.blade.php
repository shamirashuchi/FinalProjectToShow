@extends('plugins/job-board::account.layouts.skeleton')
@section('content')
    <div class="main-dashboard-form">
        <div class="py-2 border-b border-gray-200 sm:px-6">
            <div class="-ml-4 -mt-2 flex items-center justify-between flex-wrap sm:flex-nowrap">
                <h3 class="text-lg leading-6 font-medium text-gray-900">
                    {{ __('Jobs') }}
                </h3>
            </div>
        </div>
        <div class="flex flex-col">
            <div class="-my-2 py-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div class="align-middle inline-block min-w-full shadow overflow-hidden sm:rounded-lg border-b border-gray-200">
                    @include('plugins/job-board::account.jobs.partials.job-table', compact('jobs'))
                </div>
            </div>
        </div>
    </div>
@stop
