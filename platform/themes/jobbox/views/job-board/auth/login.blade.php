<style>
    .custom-radio label {
        display: flex;
        align-items: center;
        cursor: pointer;
        padding: 10px 20px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .custom-radio input[type="radio"] {
        display: none;
    }

    .custom-radio input[type="radio"]+label::before {
        content: '';
        display: inline-block;
        width: 16px;
        height: 16px;
        margin-right: 10px;
        border: 2px solid #1e3a8a;
        border-radius: 50%;
        background-color: #fff;
        transition: all 0.3s ease;
    }

    .custom-radio input[type="radio"]:checked+label {
        color: #1e3a8a;
        font-weight: bold;
    }

    .custom-radio input[type="radio"]:checked+label::before {
        background-color: #1e3a8a;
        border-color: #1e3a8a;
    }

    .carousel-indicators [data-bs-target] {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #1e3a8a;
    }

    .carousel-indicators .active {
        background-color: #1e3a8a;
    }

    /* right image fixing */
    .carousel-item {
        height: 400px;
    }

    .carousel-item img {
        object-fit: cover;
        height: 100%;
        width: 100%;
    }

    .form-group i {
        color: #777f87;
        font-size: 18px;
        left: 603px;
        position: absolute;
        top: 50%;
        transform: translateY(-50%)
    }

    .form-control {
        border: 1px solid #ced4da;
        border-radius: 5px;
        box-sizing: border-box;
        padding: .375rem .75rem;
    }

    .form-control.is-invalid {
        border-color: #ced4da !important;
    }

    .form-control.is-valid {
        border-color: #ced4da !important;
    }

    .input-group .passfield {
        border-right: none;
    }

    /* login btn color */
    .premium-btn {
        background: linear-gradient(45deg, #0879EA, rgba(5, 38, 78, 1), #F9A620);
        border: none;
        color: white;
        padding: 12px 20px;
        border-radius: 30px;
        font-size: 16px;
        font-weight: bold;
        transition: all 0.3s ease-in-out;
    }

    .premium-btn:hover {
        color: white;
        transform: translateY(-3px);
    }

    .premium-btn:active {
        transform: translateY(0);
    }

</style>

<section class="pt-70 login-register">
    <div class="container">
        <div class="row login-register-cover align-items-center">

            <div class="col-lg-6 col-md-8 col-sm-12 mx-auto pt-5">
                <div class="text-center mb-4">
                    <p class="font-sm text-brand-2">{{ __('Welcome Back!') }}</p>
                    <h2 class="mt-10 mb-5 text-brand-1">{{ __('Member Login') }}</h2>
                    <p class="font-sm text-muted mb-30">{{ __('Sign in to continue.') }}</p>
                </div>

                {{-- <div class="text-center mb-4">
                    <div class="custom-radio d-inline-block">
                        <input type="radio" id="jobSeeker" name="accountType" value="jobSeeker" onclick="redirectUser()" {{ old('accountType') == 'jobSeeker' ? 'checked' : '' }}>
                        <label for="jobSeeker">Job Seeker</label>
                    </div>
                    <div class="custom-radio d-inline-block">
                        <input type="radio" id="employer" name="accountType" value="employer" onclick="redirectUser()" {{ old('accountType') == 'employer' ? 'checked' : '' }}>
                        <label for="employer">Employer</label>
                    </div>
                    <div class="custom-radio d-inline-block">
                        <input type="radio" id="consultant" name="accountType" value="consultant" onclick="redirectUser()" {{ old('accountType') == 'consultant' ? 'checked' : '' }}>
                        <label for="consultant">Consultant</label>
                    </div>
                </div> --}}

                <form class="login-register text-start mt-20" action="{{ route('public.account.login') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label class="form-label" for="email"></label>
                        <input @class(['form-control', 'is-invalid' => $errors->has('email')]) id="email" type="text" name="email" required placeholder="{{ __('Email') }}" value="{{ old('email') }}">
                        @error('email')
                        <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password"></label>
                        <input @class(['form-control', 'is-invalid' => $errors->has('password')]) id="password" type="password" name="password" required placeholder="{{ __('Password') }}">
                        @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="login_footer form-group d-flex justify-content-between">
                        <label class="cb-container">
                            <input type="checkbox" name="remember" value="1" @checked(old('remember', 1))>
                            <span class="text-small">{{ __('Remember me') }}</span>
                            <span class="checkmark"></span>
                        </label>
                        <a class="text-primary" href="{{ route('public.account.password.request') }}">{{ __('Forgot Password') }}</a>
                    </div>
                    <div class="form-group">
                        <button class="btn premium-btn hover-up w-100" type="submit">
                            {{ __('Login') }}
                        </button>
                    </div>
                    <div class="text-center">
                        {{ __('Don\'t have an account?') }}
                        <a class="text-primary" href="{{ route('public.account.register2') }}">{{ __('Sign Up') }}</a>
                    </div>
                </form>

                <div class="text-center text-muted">
                    {!! apply_filters(BASE_FILTER_AFTER_LOGIN_OR_REGISTER_FORM, null, \Botble\JobBoard\Models\Account::class) !!}
                </div>
            </div>

            <!-- Right side Image Section -->
            <div class="col-lg-6 d-none d-lg-block mb-30">
                <div id="carouselExampleDark" class="carousel carousel-dark slide">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                            aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="3"
                            aria-label="Slide 4"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="4"
                            aria-label="Slide 5"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active" data-bs-interval="10000" style="height: 620px;">
                            <img src="https://www.mamtaz.com/storage/covers/group-36.png" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover;">
                            <div class="carousel-caption">
                                <p class="py-5 text-start fw-bold text-white">Sarah Rahman</p>
                                <p class="text-white">“Thanks to this job portal website, I quickly found my dream job!
                                    Easy to navigate, countless opportunities, and excellent results. Highly
                                    recommended.”</p>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000" style="height: 620px;">
                            <img src="https://www.mamtaz.com/storage/covers/group-36.png" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover;">
                            <div class="carousel-caption">
                                <p class="py-5 text-start fw-bold text-white">Sarah Rahman</p>
                                <p class="text-white">“Thanks to this job portal website,I quickly found my dream
                                    job!Easy to navigate,countless opportunities,and excellent results.Highly
                                    recommended ”</p>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000" style="height: 620px;">
                            <img src="https://www.mamtaz.com/storage/covers/group-36.png" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover;">
                            <div class="carousel-caption">
                                <p class="py-5 text-start fw-bold text-white">Sarah Rahman</p>
                                <p class="text-white">“Thanks to this job portal website,I quickly found my dream
                                    job!Easy to navigate,countless opportunities,and excellent results.Highly
                                    recommended ”</p>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000" style="height: 620px;">
                            <img src="https://www.mamtaz.com/storage/covers/group-36.png" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover;">
                            <div class="carousel-caption">
                                <p class="py-5 text-start fw-bold text-white">Sarah Rahman</p>
                                <p class="text-white">“Thanks to this job portal website,I quickly found my dream
                                    job!Easy to navigate,countless opportunities,and excellent results.Highly
                                    recommended ”</p>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000" style="height: 620px;">
                            <img src="https://www.mamtaz.com/storage/covers/group-36.png" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover;">
                            <div class="carousel-caption">
                                <p class="py-5 text-start fw-bold text-white">Sarah Rahman</p>
                                <p class="text-white">“Thanks to this job portal website,I quickly found my dream
                                    job!Easy to navigate,countless opportunities,and excellent results.Highly
                                    recommended ”</p>
                            </div>
                        </div>
                    </div>

                    {{-- <div class="img-2">
                <img src="{{ RvMedia::getImageUrl(theme_option('auth_background_image_2')) }}" alt="{{ theme_option('site_name') }}">
            </div> --}}
                </div>
            </div>


</section>
