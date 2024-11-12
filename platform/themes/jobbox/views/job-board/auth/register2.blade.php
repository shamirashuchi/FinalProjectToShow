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

    .input-group-text {
        display: flex;
        align-items: center;
        padding: .375rem 1.25rem;
        font-size: 1rem;
        font-weight: 400;
        line-height: 1.5;
        color: #212529;
        text-align: center;
        white-space: nowrap;
        background-color: #ffffff;
        border: 1px solid #ced4da;
        border-left: none;
    }

    @media(max-width:1399.98px) {
        .form-group i {
            left: 500px;
        }
    }

    @media(max-width:1199.98px) {
        .form-group i {
            left: 410px;
        }
    }

    @media(max-width:991.98px) {
        .form-group i {
            left: 408px;
        }
    }

    @media(max-width:767.98px) {
        .form-group i {
            left: 456px;
        }
    }

    @media(max-width:575.98px) {
        .form-group i {
            left: 490px;
        }
    }

    @media(max-width:430px) {
        .form-group i {
            left: 350px;
        }
    }

    @media(max-width:412px) {
        .form-group i {
            left: 332px;
        }
    }

    @media(max-width:360px) {
        .form-group i {
            left: 280px;
        }
    }
</style>

<section class="pt-70 login-register">
    <div class="container">
        <div class="row login-register-cover align-items-center">

            <div class="col-lg-6 col-md-8 col-sm-12 mx-auto pt-5">
                <div class="text-center mb-4">
                    <h4 class="mt-10 mb-5 text-brand-1">{{ __('Create account of employer') }}</h4>
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

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form class="login-register text-start mt-20" action="{{ route('public.account.register2') }}"
                    method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label" for="first_name"></label>
                            <input class="form-control" id="first_name" type="text" name="first_name"
                                placeholder="{{ __('Name') }}" value="{{ old('first_name') }}">
                            @error('first_name')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label" for="last_name"></label>
                            <input class="form-control" id="last_name" type="text" name="last_name"
                                placeholder="{{ __('User Name') }}" value="{{ old('last_name') }}">
                            @error('last_name')
                                <span class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="email"></label>
                        <input class="form-control" id="email" type="email" name="email"
                            placeholder="{{ __('Email Address') }}" value="{{ old('email') }}">
                        @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="password"></label>
                        <div class="input-group">
                            <input class="form-control" id="password" type="password" name="password"
                                placeholder="{{ __('Password') }}">
                        </div>
                        @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label" for="password_confirmation"></label>
                        <div class="input-group">
                            <input class="form-control passfield" id="password_confirmation" type="password"
                                name="password_confirmation" placeholder="{{ __('Confirm Password') }}">
                            <span class="input-group-text" onclick="togglePasswordVisibility('password_confirmation')">
                                <i class="fa fa-eye" id="togglePasswordConfirmation" style="cursor: pointer;"></i>
                            </span>
                        </div>
                        @error('password_confirmation')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    @if (is_plugin_active('captcha') &&
                            setting('enable_captcha') &&
                            setting('job_board_enable_recaptcha_in_register_page', 0))
                        <div class="form-group">
                            {!! Captcha::display() !!}
                        </div>
                    @endif

                    <div class="mb-25 mt-2">
                        <a class="text-primary" href="#">{{ __('Forgot password?') }}</a>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-brand-1 hover-up w-100" type="submit" style="background-color: #0879EA">
                            {{ __('Create Account') }}
                        </button>
                    </div>
                    <div class=" text-center">
                        {{ __('Already have an account?') }}
                        <a class="text-primary" href="{{ route('public.account.login') }}">{{ __('Login') }}</a>
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
                        <div class="carousel-item active" data-bs-interval="10000" style="height: 750px;">
                            <img src="https://www.mamtaz.com/storage/covers/group-36.png" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover;">
                            <div class="carousel-caption">
                                <p class="py-5 text-start fw-bold text-white">Sarah Rahman</p>
                                <p class="text-white">“Thanks to this job portal website, I quickly found my dream job!
                                    Easy to navigate, countless opportunities, and excellent results. Highly
                                    recommended.”</p>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000" style="height: 750px;">
                            <img src="https://www.mamtaz.com/storage/covers/group-36.png" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover;">
                            <div class="carousel-caption">
                                <p class="py-5 text-start fw-bold text-white">Sarah Rahman</p>
                                <p class="text-white">“Thanks to this job portal website,I quickly found my dream
                                    job!Easy to navigate,countless opportunities,and excellent results.Highly
                                    recommended ”</p>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000" style="height: 750px;">
                            <img src="https://www.mamtaz.com/storage/covers/group-36.png" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover;">
                            <div class="carousel-caption">
                                <p class="py-5 text-start fw-bold text-white">Sarah Rahman</p>
                                <p class="text-white">“Thanks to this job portal website,I quickly found my dream
                                    job!Easy to navigate,countless opportunities,and excellent results.Highly
                                    recommended ”</p>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000" style="height: 750px;">
                            <img src="https://www.mamtaz.com/storage/covers/group-36.png" class="d-block w-100 h-100"
                                alt="..." style="object-fit: cover;">
                            <div class="carousel-caption">
                                <p class="py-5 text-start fw-bold text-white">Sarah Rahman</p>
                                <p class="text-white">“Thanks to this job portal website,I quickly found my dream
                                    job!Easy to navigate,countless opportunities,and excellent results.Highly
                                    recommended ”</p>
                            </div>
                        </div>
                        <div class="carousel-item" data-bs-interval="2000" style="height: 750px;">
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


            <script>
                // Define routes in JavaScript
                const routes = {
                    jobSeeker: "{{ route('public.account.register') }}",
                    employer: "{{ route('public.account.register2') }}",
                    consultant: "{{ route('public.account.register3') }}"
                };

                function redirectUser() {
                    const accountType = document.querySelector('input[name="accountType"]:checked').value;
                    window.location.href = routes[accountType];
                }

                // Remember selected radio button
                document.addEventListener('DOMContentLoaded', function() {
                    const selectedType = "{{ old('accountType') }}";
                    if (selectedType) {
                        document.getElementById(selectedType).checked = true;
                    }
                });

                document.getElementById("employer").checked = true;


                function togglePasswordVisibility(fieldId) {
                    var passwordField = document.getElementById(fieldId);
                    var toggleIcon = passwordField.nextElementSibling.querySelector('i');

                    if (passwordField.type === "password") {
                        passwordField.type = "text";
                        toggleIcon.classList.remove("fa-eye");
                        toggleIcon.classList.add("fa-eye-slash");
                    } else {
                        passwordField.type = "password";
                        toggleIcon.classList.remove("fa-eye-slash");
                        toggleIcon.classList.add("fa-eye");
                    }
                }
            </script>
</section>
