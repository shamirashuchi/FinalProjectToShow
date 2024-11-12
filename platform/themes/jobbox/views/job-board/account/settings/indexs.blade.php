@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))

@section('content')
    <style>
        .main {
            margin-top: 42px !important;
        }

        .btn-expanded {

            top: 0px !important;

        }

        .nav-item {
            max-width: 140px !important;

        }

        .custom-dropdown {
            position: relative;
            display: inline-block;
        }

        .custom-dropdown .dropdown-options {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1;
            list-style: none;
            padding: 0;
            margin: 0;
            background-color: #fff;
            border: 1px solid #ccc;
        }

        .custom-dropdown.open .dropdown-options {
            display: block;
        }

        .custom-dropdown .dropdown-options li {
            padding: 5px;
            cursor: pointer;
        }

        .custom-dropdown .dropdown-options li:hover {
            background-color: #f5f5f5;
        }

        .tags.form-control.list-tagify option:checked {
            background-color: blue;
            margin-bottom: 10px;
            color: white;
        }


        .cover-photo {
            position: relative;
            width: 100%;
            height: auto;
        }

        .profile-photo-wrapper {
            position: absolute;
            bottom: -8%;
            /* Adjust as needed */
            left: 10%;
            transform: translateX(-50%);
            width: 45%;
            /* Responsive width */
            max-width: 150px;
            /* Maximum size */
            z-index: 1;
        }

        .profile-photo {
            width: 100%;
            height: auto;
            border: 3px solid white;
        }

        .verification-badge {
            position: absolute;
            bottom: 123px;
            right: 14px;
            transform: translate(50%, 50%);
            font-size: 2.5rem;
            /* Adjust size */
            color: #008b46;
            /* Primary color */
        }

        .naming {
            background: white;
            font-size: 12px;
            color: black;
            position: relative;
            padding: 0px 3px;
            top: 19px;
            left: 28px;
        }

        @media (max-width: 1024px) {
            .profile-photo-wrapper {
                width: 13%;
                /* Adjust for smaller screens */
                max-width: 120px;
                bottom: -9%;
                /* Adjust for smaller screens */
                left: 13%;
            }

            .verification-badge {
                font-size: 1.25rem;
                /* Smaller badge for smaller screens */
                bottom: 97px;
                right: 13px;
            }
        }

        @media (max-width: 768px) {
            .profile-photo-wrapper {
                width: 13%;
                max-width: 120px;
                bottom: -9%;
                left: 13%;
            }

            .verification-badge {
                font-size: 1.25rem;
                bottom: 72px;
                right: 10px;
            }
        }

        @media (max-width: 430px) {
            .profile-photo-wrapper {
                width: 13%;
                max-width: 120px;
                bottom: -9%;
                left: 13%;
            }

            .verification-badge {
                font-size: .65rem;
                bottom: 38px;
                right: 5px;
            }
        }
    </style>

    @if ($account->type == 'job-seeker')
        {{-- start --}}
        <div class="px-4">
            <div class="container bg-light rounded-3 px-3">

                <form action="{{ route('public.account.updatesettings') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @foreach ($accountsinformations as $accountsinformation)
                    <div class="row py-3">
                        <!-- Cover Photo -->
                        <div class="col-12 cover-photo">
                            <img src="https://via.placeholder.com/1248x263" alt="Cover Photo" class="img-fluid w-100">
                            <!-- Profile Photo -->
                            <div class="profile-photo-wrapper">
                                <div class="position-relative">
                                    <img src="https://via.placeholder.com/191x191" alt="Profile Photo"
                                        class="profile-photo rounded-circle">
                                    <i class="bi bi-patch-check-fill verification-badge"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-5">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Personal Information</h3>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">First Name</label>
                                    <input class="form-control" id="first_name" type="text" name="first_name" required
                                    value="{{ $accountsinformation->first_name ?? '' }}" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Last Name</label>
                                    <input class="form-control" id="last_name" type="text" name="last_name" required
                                    value="{{ $accountsinformation->last_name ?? '' }}" placeholder="Last Name">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">Date of Birth</label>
                                    <input class="form-control" id="dob" type="text" name="dob" required value="{{ $accountsinformation->dob ?? '' }}" placeholder="yyyy-mm-dd" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ (isset($accountsinformation) && $accountsinformation->gender == 'Male') ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ (isset($accountsinformation) && $accountsinformation->gender == 'Female') ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ (isset($accountsinformation) && $accountsinformation->gender == 'Other') ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">Email Address</label>
                                    <input class="form-control" id="email" type="email" name="email"
                                        required value="{{ $accountsinformation->email }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Cell Number</label>
                                    <input class="form-control" id="phone" type="text" name="phone" required
                                    value="{{ $accountsinformation->phone ?? '' }}" placeholder="Cell Number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Address</h3>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">Present Address</label>
                                    <input class="form-control" id="address" type="text" name="address"
                                        required value="{{ $accountsinformation->address ?? '' }}" placeholder="Present Address">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Permanent Address</label>
                                    <input class="form-control" id="address_line_2" type="text"
                                        name="address_line_2" required value="{{ $accountsinformation->address_line_2 ?? '' }}" placeholder="Permanent Address">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">City</label>
                                    <input class="form-control" id="city" type="text" name="city" required
                                    value="{{ $accountsinformation->city ?? '' }}" placeholder="City">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="province">Province</label>
                                    <select class="form-control" id="province" name="province" required>
                                        <option value="" disabled selected>Select your province</option>
                                        <option value="AB" {{ $accountsinformation->province == 'AB' ? 'selected' : '' }}>Alberta</option>
                                        <option value="BC" {{ $accountsinformation->province == 'BC' ? 'selected' : '' }}>British Columbia</option>
                                        <option value="MB" {{ $accountsinformation->province == 'MB' ? 'selected' : '' }}>Manitoba</option>
                                        <option value="NB" {{ $accountsinformation->province == 'NB' ? 'selected' : '' }}>New Brunswick</option>
                                        <option value="NL" {{ $accountsinformation->province == 'NL' ? 'selected' : '' }}>Newfoundland and Labrador</option>
                                        <option value="NS" {{ $accountsinformation->province == 'NS' ? 'selected' : '' }}>Nova Scotia</option>
                                        <option value="ON" {{ $accountsinformation->province == 'ON' ? 'selected' : '' }}>Ontario</option>
                                        <option value="PE" {{ $accountsinformation->province == 'PE' ? 'selected' : '' }}>Prince Edward Island</option>
                                        <option value="QC" {{ $accountsinformation->province == 'QC' ? 'selected' : '' }}>Quebec</option>
                                        <option value="SK" {{ $accountsinformation->province == 'SK' ? 'selected' : '' }}>Saskatchewan</option>
                                        <option value="NT" {{ $accountsinformation->province == 'NT' ? 'selected' : '' }}>Northwest Territories</option>
                                        <option value="NU" {{ $accountsinformation->province == 'NU' ? 'selected' : '' }}>Nunavut</option>
                                        <option value="YT" {{ $accountsinformation->province == 'YT' ? 'selected' : '' }}>Yukon</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Work Eligibility and Residency Status in Canada</h3>
                            <div class="row mt-2">
                                <div class="form-group col-md-6">
                                    <label class="form-label" for="permanent_resident">{{ __('Permanent Resident / Citizen of Canada?') }}</label>
                                    <select class="form-select" id="permanent_resident" name="permanent_resident">
                                        <option value="" disabled>Select an option</option>
                                        <option value="1" {{ $accountsinformation->permanent_resident == 1 ? 'selected' : '' }}>Permanent Resident</option>
                                        <option value="2" {{ $accountsinformation->permanent_resident == 2 ? 'selected' : '' }}>Citizen of Canada</option>
                                        <option value="3" {{ $accountsinformation->permanent_resident == 3 ? 'selected' : '' }}>Others</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-6">
                                    <label class="form-label" for="legally_entitled">{{ __('Legally entitled to work in Canada?') }}</label>
                                    <select class="form-select" id="legally_entitled" name="legally_entitled">
                                        <option value="" disabled>Select an option</option>
                                        <option value="1" {{ $accountsinformation->legally_entitled == 1 ? 'selected' : '' }}>Yes</option>
                                        <option value="2" {{ $accountsinformation->legally_entitled == 2 ? 'selected' : '' }}>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Job Skills and Preferences</h3>
                            <div class="row mt-2">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">My Job Skills</label>
                                    <input class="form-control" id="job_skill" type="text"
                                        name="job_skill" required value="{{ $accountsinformation->job_skill ?? '' }}" placeholder="example: php, laravel, js,react">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Favorite Job Tags</label>
                                    <input class="form-control" id="job_tag" type="text"
                                        name="job_tag" required value="{{ $accountsinformation->job_tag ?? '' }}" placeholder="example: php, laravel, js,react">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Profile</h3>
                            <div class="row mt-2">
                                <div class="form-group">
                                    <label class="form-label" for="bio">{{ __('Introduce Yourself') }}</label>
                                    <textarea class="form-control" id="bio" name="bio" required placeholder="Introduce Yourself" rows="3">{{ $accountsinformation->bio ?? '' }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="bio">{{ __('Career Objectives') }}</label>
                                    <textarea class="form-control" id="description" name="description" required placeholder="Career Objectives" rows="5">{{ $accountsinformation->description ?? '' }}</textarea>
                                </div>
                                {{-- <div class="row">
                                    <!-- Full Editor -->
                                    <div class="col-12">
                                        <label class="form-label" for="description">{{ __('Career Objectives') }}</label>
                                        <div class="card">
                                            <div id="full-editor">
                                                <input class="form-control" id="description" type="text"
                                                    name="description" required value="{{ old('description', $accountsinformation->description ?? '') }}" placeholder="Career Objectives">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Full Editor -->
                                </div> --}}
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Upload Your Application Materials</h3>
                            <div class="row mt-2">
                                <div class="form-group">
                                    <label class="form-label" for="last_name">{{ __('Attachments CV') }}</label>
                                    <input class="form-control" id="resume" type="file" name="resume"
                                        accept=".pdf,.doc,.docx,.ppt,.pptx" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="last_name">{{ __('Cover letter') }}</label>
                                    <input class="form-control" id="cover_letter" type="file" name="cover_letter"
                                        accept=".pdf,.doc,.docx,.ppt,.pptx" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <button class="btn btn-warning w-100 text-white fw-bold" type="submit">Save all the
                            changes</button>
                    </div>

                    @endforeach
                </form>

            </div>
        </div>
    @elseif($account->type == 'employer')
        {{-- start --}}
        <div class="px-4">
            <div class="container bg-light rounded-3 px-3">

                <form action="{{ route('public.account.updatesettingsemployer') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @foreach ($accountsinformations as $accountsinformation)
                    <div class="row py-3">
                        <!-- Cover Photo -->
                        <div class="col-12 cover-photo">
                            <img src="https://via.placeholder.com/1248x263" alt="Cover Photo" class="img-fluid w-100">
                            <!-- Profile Photo -->
                            <div class="profile-photo-wrapper">
                                <div class="position-relative">
                                    <img src="https://via.placeholder.com/191x191" alt="Profile Photo"
                                        class="profile-photo rounded-circle">
                                    <i class="bi bi-patch-check-fill verification-badge"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-5">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Personal Information</h3>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">First Name</label>
                                    <input class="form-control" id="first_name" type="text" name="first_name" required
                                    value="{{ $accountsinformation->first_name ?? '' }}" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Last Name</label>
                                    <input class="form-control" id="last_name" type="text" name="last_name" required
                                    value="{{ $accountsinformation->last_name ?? '' }}" placeholder="Last Name">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">Date of Birth</label>
                                    <input class="form-control" id="dob" type="text" name="dob" required value="{{ $accountsinformation->dob ?? '' }}" placeholder="yyyy-mm-dd" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ (isset($accountsinformation) && $accountsinformation->gender == 'Male') ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ (isset($accountsinformation) && $accountsinformation->gender == 'Female') ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ (isset($accountsinformation) && $accountsinformation->gender == 'Other') ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">Email Address</label>
                                    <input class="form-control" id="email" type="email" name="email"
                                        required value="{{ $accountsinformation->email }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Cell Number</label>
                                    <input class="form-control" id="phone" type="text" name="phone" required
                                    value="{{ $accountsinformation->phone ?? '' }}" placeholder="Cell Number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Address</h3>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">Present Address</label>
                                    <input class="form-control" id="address" type="text" name="address"
                                        required value="{{ $accountsinformation->address ?? '' }}" placeholder="Present Address">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Permanent Address</label>
                                    <input class="form-control" id="address_line_2" type="text"
                                        name="address_line_2" required value="{{ $accountsinformation->address_line_2 ?? '' }}" placeholder="Permanent Address">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">City</label>
                                    <input class="form-control" id="city" type="text" name="city" required
                                    value="{{ $accountsinformation->city ?? '' }}" placeholder="City">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="province">Province</label>
                                    <select class="form-control" id="province" name="province" required>
                                        <option value="" disabled selected>Select your province</option>
                                        <option value="AB" {{ $accountsinformation->province == 'AB' ? 'selected' : '' }}>Alberta</option>
                                        <option value="BC" {{ $accountsinformation->province == 'BC' ? 'selected' : '' }}>British Columbia</option>
                                        <option value="MB" {{ $accountsinformation->province == 'MB' ? 'selected' : '' }}>Manitoba</option>
                                        <option value="NB" {{ $accountsinformation->province == 'NB' ? 'selected' : '' }}>New Brunswick</option>
                                        <option value="NL" {{ $accountsinformation->province == 'NL' ? 'selected' : '' }}>Newfoundland and Labrador</option>
                                        <option value="NS" {{ $accountsinformation->province == 'NS' ? 'selected' : '' }}>Nova Scotia</option>
                                        <option value="ON" {{ $accountsinformation->province == 'ON' ? 'selected' : '' }}>Ontario</option>
                                        <option value="PE" {{ $accountsinformation->province == 'PE' ? 'selected' : '' }}>Prince Edward Island</option>
                                        <option value="QC" {{ $accountsinformation->province == 'QC' ? 'selected' : '' }}>Quebec</option>
                                        <option value="SK" {{ $accountsinformation->province == 'SK' ? 'selected' : '' }}>Saskatchewan</option>
                                        <option value="NT" {{ $accountsinformation->province == 'NT' ? 'selected' : '' }}>Northwest Territories</option>
                                        <option value="NU" {{ $accountsinformation->province == 'NU' ? 'selected' : '' }}>Nunavut</option>
                                        <option value="YT" {{ $accountsinformation->province == 'YT' ? 'selected' : '' }}>Yukon</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Company Information</h3>
                            <div class="row mt-2">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Company Name</label>
                                    <input class="form-control" id="company_name" type="text"
                                        name="company_name" required value="{{ $accountsinformation->company_name ?? '' }}" placeholder="Company Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Your Designation</label>
                                    <input class="form-control" id="designation" type="text"
                                        name="designation" required value="{{ $accountsinformation->designation ?? '' }}" placeholder="Your Designation">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Profile</h3>
                            <div class="row mt-2">
                                <div class="form-group">
                                    <label class="form-label" for="bio">{{ __('Introduce Yourself') }}</label>
                                    <textarea class="form-control" id="bio" name="bio" required placeholder="Introduce Yourself" rows="3">{{ $accountsinformation->bio ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <button class="btn btn-primary w-100 text-white fw-bold" type="submit">Save all the
                            changes</button>
                    </div>

                    @endforeach
                </form>

            </div>
        </div>
    @elseif($account->type == 'consultant')
        {{-- start --}}
        <div class="px-4">
            <div class="container bg-light rounded-3 px-3">

                <form action="{{ route('public.account.updatesettingsconsultant') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    @foreach ($accountsinformations as $accountsinformation)
                    <div class="row py-3">
                        <!-- Cover Photo -->
                        <div class="col-12 cover-photo">
                            <img src="https://via.placeholder.com/1248x263" alt="Cover Photo" class="img-fluid w-100">
                            <!-- Profile Photo -->
                            <div class="profile-photo-wrapper">
                                <div class="position-relative">
                                    <img src="https://via.placeholder.com/191x191" alt="Profile Photo"
                                        class="profile-photo rounded-circle">
                                    <i class="bi bi-patch-check-fill verification-badge"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="py-5">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Personal Information</h3>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">First Name</label>
                                    <input class="form-control" id="first_name" type="text" name="first_name" required
                                    value="{{ $accountsinformation->first_name ?? '' }}" placeholder="First Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Last Name</label>
                                    <input class="form-control" id="last_name" type="text" name="last_name" required
                                    value="{{ $accountsinformation->last_name ?? '' }}" placeholder="Last Name">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">Date of Birth</label>
                                    <input class="form-control" id="dob" type="text" name="dob" required value="{{ $accountsinformation->dob ?? '' }}" placeholder="yyyy-mm-dd" >
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="gender">Gender</label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ (isset($accountsinformation) && $accountsinformation->gender == 'Male') ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ (isset($accountsinformation) && $accountsinformation->gender == 'Female') ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ (isset($accountsinformation) && $accountsinformation->gender == 'Other') ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">Email Address</label>
                                    <input class="form-control" id="email" type="email" name="email"
                                        required value="{{ $accountsinformation->email }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Cell Number</label>
                                    <input class="form-control" id="phone" type="text" name="phone" required
                                    value="{{ $accountsinformation->phone ?? '' }}" placeholder="Cell Number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Address</h3>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">Present Address</label>
                                    <input class="form-control" id="address" type="text" name="address"
                                        required value="{{ $accountsinformation->address ?? '' }}" placeholder="Present Address">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Permanent Address</label>
                                    <input class="form-control" id="address_line_2" type="text"
                                        name="address_line_2" required value="{{ $accountsinformation->address_line_2 ?? '' }}" placeholder="Permanent Address">
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="first_name">City</label>
                                    <input class="form-control" id="city" type="text" name="city" required
                                    value="{{ $accountsinformation->city ?? '' }}" placeholder="City">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="province">Province</label>
                                    <select class="form-control" id="province" name="province" required>
                                        <option value="" disabled selected>Select your province</option>
                                        <option value="AB" {{ $accountsinformation->province == 'AB' ? 'selected' : '' }}>Alberta</option>
                                        <option value="BC" {{ $accountsinformation->province == 'BC' ? 'selected' : '' }}>British Columbia</option>
                                        <option value="MB" {{ $accountsinformation->province == 'MB' ? 'selected' : '' }}>Manitoba</option>
                                        <option value="NB" {{ $accountsinformation->province == 'NB' ? 'selected' : '' }}>New Brunswick</option>
                                        <option value="NL" {{ $accountsinformation->province == 'NL' ? 'selected' : '' }}>Newfoundland and Labrador</option>
                                        <option value="NS" {{ $accountsinformation->province == 'NS' ? 'selected' : '' }}>Nova Scotia</option>
                                        <option value="ON" {{ $accountsinformation->province == 'ON' ? 'selected' : '' }}>Ontario</option>
                                        <option value="PE" {{ $accountsinformation->province == 'PE' ? 'selected' : '' }}>Prince Edward Island</option>
                                        <option value="QC" {{ $accountsinformation->province == 'QC' ? 'selected' : '' }}>Quebec</option>
                                        <option value="SK" {{ $accountsinformation->province == 'SK' ? 'selected' : '' }}>Saskatchewan</option>
                                        <option value="NT" {{ $accountsinformation->province == 'NT' ? 'selected' : '' }}>Northwest Territories</option>
                                        <option value="NU" {{ $accountsinformation->province == 'NU' ? 'selected' : '' }}>Nunavut</option>
                                        <option value="YT" {{ $accountsinformation->province == 'YT' ? 'selected' : '' }}>Yukon</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Consultancy Information</h3>
                            <div class="row mt-2">
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Company Name</label>
                                    <input class="form-control" id="company_name" type="text"
                                        name="company_name" required value="{{ $accountsinformation->company_name ?? '' }}" placeholder="Company Name">
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label naming" for="last_name">Your Designation</label>
                                    <input class="form-control" id="designation" type="text"
                                        name="designation" required value="{{ $accountsinformation->designation ?? '' }}" placeholder="Your Designation">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <div class="div pt-5 px-4 py-4 bg-white rounded-3">
                            <h3 class="mt-3">Profile</h3>
                            <div class="row mt-2">
                                <div class="form-group">
                                    <label class="form-label" for="bio">{{ __('Introduce Yourself') }}</label>
                                    <textarea class="form-control" id="bio" name="bio" required placeholder="Introduce Yourself" rows="3">{{ $accountsinformation->bio ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-3">
                        <button class="btn w-100 text-white fw-bold" type="submit" style="background: rgba(5, 38, 78, 1)">Save all the
                            changes</button>
                    </div>

                    @endforeach
                </form>

            </div>
        </div>
    @endif



    <!-- Initialize Quill editors -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Snow Theme
            var snowEditor = new Quill('#snow-editor', {
                theme: 'snow',
                modules: {
                    toolbar: '#snow-toolbar'
                }
            });

            // Bubble Theme
            var bubbleEditor = new Quill('#bubble-editor', {
                theme: 'bubble',
                modules: {
                    toolbar: '#bubble-toolbar'
                }
            });

            // Full Editor (with Snow Theme)
            var fullEditor = new Quill('#full-editor', {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{
                            'font': []
                        }, {
                            'size': []
                        }],
                        [{
                            'header': '1'
                        }, {
                            'header': '2'
                        }, 'blockquote', 'code-block'],
                        [{
                            'list': 'ordered'
                        }, {
                            'list': 'bullet'
                        }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{
                            'color': []
                        }, {
                            'background': []
                        }],
                        [{
                            'align': []
                        }],
                        ['link', 'image']
                    ]
                }
            });
        });
    </script>
@endsection
