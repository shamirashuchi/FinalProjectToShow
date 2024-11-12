@extends(Theme::getThemeNamespace('views.job-board.account.partials.layout-settings'))

@section('content')
    <div>
        <h3 class="mt-0 mb-15 color-brand-1">{{ __('My Account') }}</h3>
        {!! Form::open(['route' => 'public.account.post.settings', 'method' => 'POST', 'files' => true]) !!}
        <div class="mt-35 mb-40 box-info-profie avatar-view">
            <div class="image-profile">
                <img src="{{ $account->avatar_url }}" id="profile-img" alt="{{ $account->name }}">
            </div>
            <a class="btn btn-apply">{{ __('Upload Avatar') }}</a>
        </div>
        <div class="row form-contact">
            <div class="col-lg-12 col-md-12">
                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="first_name">{{ __('First Name') }}</label>
                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" id="first_name"
                           name="first_name" value="{{ old('first_name', $account->first_name) }}" required placeholder="{{ __('Enter First Name') }}"/>
                    @error('first_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="middle_name">Middle Name</label>
                    <input type="text" class="form-control @error('middle_name') is-invalid @enderror" id="middle_name"
                           name="middle_name" value="" required placeholder="Enter Middle Name"/>
                    @error('middle_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="last_name" >{{ __('Last Name') }}</label>
                    <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                           id="last_name" name="last_name" value="{{ old('last_name', $account->last_name) }}" required placeholder="{{ __('Enter Last Name') }}"/>
                    @error('last_name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="phone">Cell</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                           name="phone" id="phone" value="{{ old('phone', $account->phone) }}" placeholder="{{ __('Enter Cell') }}"/>
                    @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="dob">{{ __('Date of Birth') }}</label>
                    <input type="date" class="form-control @error('dob') is-invalid @enderror"
                           name="dob" id="dob" value="{{ old('dob', $account->dob ? $account->dob->format('Y-m-d') : '') }}"
                           max="{{ now()->format('Y-m-d') }}" pattern="\d{4}-\d{2}-\d{2}"/>
                    @error('dob')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @if (! $account->type->getKey())
                    <div class="col-lg-6">
                        <div class="mb-3">
                            <label for="type" class="form-label required">{{ __('Type') }}</label>
                            {!! Form::select('type', ['' => __('-- select --')] + Botble\JobBoard\Enums\AccountTypeEnum::labels(), old('type', $account->type), [
                                'class' => 'form-select',
                                'required' => true,
                            ]) !!}
                        </div>
                    </div>
                @endif
                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="gender">{{ __('Gender') }}</label>
                    {!! Form::select('gender', ['' => __('-- select --')] + Botble\JobBoard\Enums\AccountGenderEnum::labels(), old('gender', $account->gender), [
                            'class' => 'form-select'
                        ]) !!}
                </div>
                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="address">{{ __('Address') }}</label>
                    <input type="text" class="form-control @error('description') is-invalid @enderror"
                           name="address" id="address" value="{{ old('address', $account->address) }}" placeholder="{{ __('Enter Address') }}"/>
                    @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="address2">Address Line 2</label>
                    <input type="text" class="form-control @error('address2') is-invalid @enderror" id="address2"
                            name="address2" value="" required placeholder="Enter Address Line 2"/>
                    @error('address2')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="city">City</label>
                    <input type="text" class="form-control @error('city') is-invalid @enderror" id="city"
                            name="city" value="" required placeholder=""/>
                    @error('city')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="province">Province/State/Division</label>
                    <input type="text" class="form-control @error('province') is-invalid @enderror" id="province"
                            name="province" value="" required placeholder=""/>
                    @error('province')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="canada">Legally entitled to work in Canada? (Type Yes/No)</label>
                    <input type="text" class="form-control @error('canada') is-invalid @enderror" id="canada"
                            name="canada" value="" required placeholder=""/>
                    @error('canada')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="font-sm color-text-mutted mb-10" for="experience">Length of Experience</label>
                    <input type="text" class="form-control @error('experience') is-invalid @enderror" id="experience"
                            name="experience" value="" required placeholder=""/>
                    @error('experience')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                

                @if ($account->isJobSeeker())
                    @if (count($jobSkills) || count($selectedJobSkills))
                        <div class="form-group mb-3">
                            <label for="favorite_skills" class="font-sm color-text-mutted mb-10">{{ __('Favorite Job Skills') }}</label>
                            <input type="text" class="tags form-control list-tagify" id="favorite_skills" name="favorite_skills" value="{{ implode(',', $selectedJobSkills) }}" data-keep-invalid-tags="false" data-list="{{ $jobSkills }}" data-user-input="false" placeholder="{{ __('Select from the list.') }}"/>
                            @error('favorite_skills')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    @endif

                    @if (count($jobTags) || count($selectedJobTags))
                        <div class="form-group mb-3">
                            <label for="favorite_tags" class="form-label">{{ __('Favorite Job Tags') }}</label>
                            <input type="text" class="tags form-control list-tagify" id="favorite_tags" name="favorite_tags" value="{{ implode(',', $selectedJobTags) }}" data-keep-invalid-tags="false" data-list="{{ $jobTags }}" data-user-input="false" placeholder="{{ __('Select from the list.') }}"/>
                            @error('favorite_tags')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    @endif
                @endif
                public
                <div class="mt-4">
                    <h5 class="fs-17 fw-semibold mb-3">{{ __('Profile') }}</h5>
                    <div class="row">
                        @if ($account->isJobSeeker())
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="is_public_profile" value="0">
                                        <input class="form-check-input" name="is_public_profile" value="1" type="checkbox"
                                               role="switch" id="is_public_profile" @checked(old('is_public_profile', $account))>
                                        <label class="font-sm color-text-mutted mb-10" for="is_public_profile">{{ __('Is public profile?') }}</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="available_for_hiring" value="0">
                                        <input class="form-check-input" name="available_for_hiring" value="1" type="checkbox"
                                               role="switch" id="available_for_hiring" @checked(old('available_for_hiring', $account))>
                                        <label class="font-sm color-text-mutted mb-10" for="available_for_hiring">{{ __('Available for hiring?') }}</label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="description" class="font-sm color-text-mutted mb-10">{{ __('Introduce Yourself') }}</label>
                                <textarea  @class(['form-control', 'is-invalid' => $errors->has('description')]) name="description"
                                           id="description" placeholder="{{ __('Enter Description') }}"
                                           rows="2">{!! BaseHelper::clean(old('description', $account->description)) !!}</textarea>
                                @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="bio"
                                       class="font-sm color-text-mutted mb-10">{{ __('BIO') }}</label>
                                {!! Form::customEditor('bio', old('bio', $account->bio)) !!}
                                @error('bio')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!--end col-->
                        @if ($account->isJobSeeker())
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="attachments-cv" class="font-sm color-text-mutted mb-10">{{ __('Attachments CV') }}</label>
                                    <input type="file" class="form-control @error('resume') is-invalid @enderror"
                                           id="attachments-cv" name="resume" accept=".pdf,.doc,.docx,.ppt,.pptx" />
                                    @if ($account->resume)
                                        <div class="mb-4 mt-2">
                                            <p class="job-apply-resume-info"><i class="mdi mdi-information"></i> {!! BaseHelper::clean(__('Your current resume :resume. Just upload a new resume if you want to change it.', ['resume' => Html::link(RvMedia::url($account->resume), $account->resume, ['target' => '_blank'])->toHtml()])) !!}</p>
                                        </div>
                                    @endif
                                    @error('resume')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->
                            <!--end col-->
                            <div class="col-lg-12">
                                <div class="mb-3">
                                    <label for="attachments-cover-letter" class="form-label">Upload Licence / Certificate</label>
                                    <input type="file" @class(['form-control', 'is-invalid' => $errors->has('cover_letter')])
                                    id="attachments-cover-letter" name="cover_letter" accept=".pdf,.doc,.docx,.ppt,.pptx" />
                                    @if ($account->cover_letter)
                                        <div class="mb-4 mt-2">
                                            <p class="job-apply-resume-info"><i class="mdi mdi-information"></i> {!! BaseHelper::clean(__('Your current cover_letter :cover_letter. Just upload a new resume if you want to change it.', ['cover_letter' => Html::link(RvMedia::url($account->cover_letter), $account->cover_letter, ['target' => '_blank'])->toHtml()])) !!}</p>
                                        </div>
                                    @endif
                                    @error('cover_letter')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                            <!--end col-->
                        @endif
                    </div>
                    <!--end row-->
                </div>
                <div class="border-bottom pt-10 pb-10 mb-30"></div>
                <div class="box-button mt-15">
                    <button class="btn btn-apply-big font-md font-bold">{{ __('Save All Changes') }}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    {!! Form::close() !!}
@endsection
