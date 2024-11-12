@extends('plugins/job-board::account.layouts.skeleton')
@section('content')
    <div class="crop-avatar bg-white p-4">
        <div class="main-dashboard-form">
            <h4 class="mb-2">{{ trans('plugins/job-board::dashboard.account_field_title') }}</h4>
            <hr>
            <div class="mt-4 md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <form id="avatar-upload-form" enctype="multipart/form-data" action="javascript:void(0)"
                          onsubmit="return false">
                        <div class="avatar-upload-container">
                            <div>
                                <div id="account-avatar mt-2">
                                    <div class="profile-image">
                                        <div class="avatar-view mt-card-avatar">
                                            <img class="br2" src="{{ $user->avatar_url }}" style="width: 200px;" alt="avatar">
                                            <div class="mt-overlay br2">
                                                <span><i class="fa fa-edit"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="md:col-span-2">
                    <form action="{{ route('public.account.post.settings') }}" id="setting-form" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="block text-sm font-medium leading-5 text-gray-700" for="first_name">{{ trans('plugins/job-board::dashboard.first_name') }}</label>
                            <input type="text" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="first_name" id="first_name" required
                                   value="{{ old('first_name') ?: $user->first_name }}">
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium leading-5 text-gray-700" for="last_name">{{ trans('plugins/job-board::dashboard.last_name') }}</label>
                            <input type="text" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="last_name" id="last_name" required
                                   value="{{ old('last_name') ?: $user->last_name }}">
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium leading-5 text-gray-700" for="phone">{{ trans('plugins/job-board::dashboard.phone') }}</label>
                            <input type="text" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="phone" id="phone" required
                                   value="{{ old('phone') ?: $user->phone }}">
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium leading-5 text-gray-700" for="description">{{ trans('plugins/job-board::dashboard.description') }}</label>
                            <textarea class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="description" id="description" rows="3" maxlength="300"
                                      placeholder="{{ trans('plugins/job-board::dashboard.description_placeholder') }}">{{ old('description') ?: $user->description }}</textarea>
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium leading-5 text-gray-700" for="email">{{ trans('plugins/job-board::dashboard.email') }}</label>
                            <input type="email" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="email" id="email" disabled="disabled"
                                   placeholder="{{ trans('plugins/job-board::dashboard.email') }}" required
                                   value="{{ old('email') ?: $user->email }}">
                            @if (false)
                                @if ($user->confirmed_at)
                                    <small class="text-green-600">{{ trans('plugins/job-board::dashboard.verified') }}<i
                                            class="ml-1 far fa-check-circle"></i></small>
                                @else
                                    <small>{{ trans('plugins/job-board::dashboard.verify_require_desc') }}<a
                                            href="{{ route('public.account.resend_confirmation', ['email' => $user->email]) }}"
                                            class="ml-1">{{ trans('plugins/job-board::dashboard.resend') }}</a></small>
                                @endif
                            @endif
                        </div>
                        @if ($user->isJobSeeker())
                            @include('plugins/job-board::account.settings.upload-resume', compact('user'))
                        @endif
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-600 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-green-600 transition duration-150 ease-in-out">{{ trans('plugins/job-board::dashboard.save') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    @include('plugins/job-board::account.partials.avatar', ['url' => route('public.account.avatar')])
    {!! JsValidator::formRequest(\Botble\JobBoard\Http\Requests\SettingRequest::class); !!}
@endpush
