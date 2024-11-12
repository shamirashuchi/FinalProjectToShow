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
                                            <img class="br2" src="{{ $account->avatar_url }}" style="width: 200px;" alt="avatar">
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
                        @if (! $account->type->getKey())
                            <div class="alert alert-warning mt-2">
                                <span>{{ __('Please select an account type first!') }}</span>
                            </div>
                        @endif
                        <div class="mb-2">
                            <label class="block text-sm font-medium leading-5 text-gray-700" for="first_name">{{ trans('plugins/job-board::dashboard.first_name') }}</label>
                            <input type="text" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="first_name" id="first_name" required
                                value="{{ old('first_name') ?: $account->first_name }}">
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium leading-5 text-gray-700" for="last_name">{{ trans('plugins/job-board::dashboard.last_name') }}</label>
                            <input type="text" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="last_name" id="last_name" required
                                value="{{ old('last_name') ?: $account->last_name }}">
                        </div>
                        @if (! $account->type->getKey())
                            <div class="mb-2">
                                <label class="block text-sm font-medium leading-5 text-gray-700" for="type">{{ trans('plugins/job-board::dashboard.type') }}</label>
                                {!! Form::select('type', ['' => __('-- select --')] + Botble\JobBoard\Enums\AccountTypeEnum::labels(), old('type', $account->type), [
                                    'class' => 'mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5',
                                    'required' => true,
                                ]) !!}
                            </div>
                        @endif
                        <div class="mb-2">
                            <label class="block text-sm font-medium leading-5 text-gray-700" for="gender">{{ trans('plugins/job-board::dashboard.gender') }}</label>
                            {!! Form::select('gender', ['' => __('-- select --')] + Botble\JobBoard\Enums\AccountGenderEnum::labels(), old('gender', $account->gender), [
                                'class' => 'mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5'
                            ]) !!}
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium leading-5 text-gray-700" for="phone">{{ trans('plugins/job-board::dashboard.phone') }}</label>
                            <input type="text" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="phone" id="phone"
                                value="{{ old('phone') ?: $account->phone }}">
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium leading-5 text-gray-700" for="description">{{ trans('plugins/job-board::dashboard.description') }}</label>
                            <textarea class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="description" id="description" rows="3" maxlength="300"
                                placeholder="{{ trans('plugins/job-board::dashboard.description_placeholder') }}">{{ old('description') ?: $account->description }}</textarea>
                        </div>
                        <div class="mb-2">
                            <label class="block text-sm font-medium leading-5 text-gray-700" for="email">{{ trans('plugins/job-board::dashboard.email') }}</label>
                            <input type="email" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="email" id="email" disabled="disabled"
                                placeholder="{{ trans('plugins/job-board::dashboard.email') }}" required
                                value="{{ $account->email }}">
                            @if ($account->confirmed_at)
                                <small class="text-green-600">
                                    {{ trans('plugins/job-board::dashboard.verified') }}
                                    <i class="ml-1 far fa-check-circle"></i>
                                </small>
                            @else
                                <small>
                                    {{ trans('plugins/job-board::dashboard.verify_require_desc') }}
                                    <a href="{{ route('public.account.resend_confirmation', ['email' => $account->email]) }}"
                                        class="ml-1">{{ trans('plugins/job-board::dashboard.resend') }}</a>
                                </small>
                            @endif
                        </div>
                        @if ($account->isJobSeeker())
                            <div class="mb-2">
                                <label class="block text-sm font-medium leading-5 text-gray-700" for="resume">{{ trans('plugins/job-board::dashboard.resume') }}</label>
                                <input type="file" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="resume" id="resume" />
                                @if ($account->resume)
                                    <div class="mb-4 mt-2">
                                        <p class="job-apply-resume-info">{!! BaseHelper::clean(__('Your current resume :resume. Just upload a new resume if you want to change it.', ['resume' => Html::link(RvMedia::url($account->resume), $account->resume, ['target' => '_blank'])->toHtml()])) !!}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="mb-2">
                                <label class="block text-sm font-medium leading-5 text-gray-700" for="cover_letter">{{ trans('plugins/job-board::dashboard.cover_letter') }}</label>
                                <input type="file" class="mt-1 form-input block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue focus:border-blue-300 transition duration-150 ease-in-out sm:text-sm sm:leading-5" name="cover_letter" id="cover_letter" />
                                @if ($account->cover_letter)
                                    <div class="mb-4 mt-2">
                                        <p class="job-apply-cover-letter-info">{!! BaseHelper::clean(__('Your current cover letter :cover_letter. Just upload a new cover letter if you want to change it.', ['cover_letter' => Html::link(RvMedia::url($account->cover_letter), $account->cover_letter, ['target' => '_blank'])->toHtml()])) !!}</p>
                                    </div>
                                @endif
                            </div>
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
    {!! JsValidator::formRequest(\Botble\JobBoard\Http\Requests\SettingRequest::class, '#setting-form'); !!}
@endpush
