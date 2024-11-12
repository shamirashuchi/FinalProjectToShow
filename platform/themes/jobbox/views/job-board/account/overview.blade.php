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


        .drag-drop-area {
            border: 1px dashed #6c757d;
            border-radius: 0.25rem;
            padding: 20px;
            text-align: center;
            background-color: #f8f9fa;
            transition: background-color 0.2s ease-in-out;
        }

        .drag-drop-area.dragging {
            background-color: #e9ecef;
        }

        .textarea-container {
            display: flex;
            justify-content: center;
            /* Horizontally center the textarea */
            height: 150px;
            /* Set the height as needed */
        }

        #introduce_yourself {
            width: 100%;
            height: 100%;
            resize: none;
            /* Prevent resizing if not needed */
            text-align: center;
            /* Center the text inside the textarea */
            padding-top: 60px;
            /* Adjust padding for horizontal alignment */
        }

        #introduce_yourself::placeholder {
            text-align: left;
            /* Align the placeholder text to the left */
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
                /* Adjust for smaller screens */
                max-width: 120px;
                bottom: -9%;
                /* Adjust for smaller screens */
                left: 13%;
            }

            .verification-badge {
                font-size: 1.25rem;
                /* Smaller badge for smaller screens */
                bottom: 72px;
                right: 10px;
            }
        }

        @media (max-width: 430px) {
            .profile-photo-wrapper {
                width: 13%;
                /* Adjust for smaller screens */
                max-width: 120px;
                bottom: -9%;
                /* Adjust for smaller screens */
                left: 13%;
            }

            .verification-badge {
                font-size: .65rem;
                /* Smaller badge for smaller screens */
                bottom: 38px;
                right: 5px;
            }
        }
    </style>



    {{-- start --}}
    <div class="px-4">
        <div class="container bg-light rounded-3 px-3">

            <form action="" method="">
                @foreach ($jobseekeraccounts as $jobseekeraccount)


                <div class="row py-3">
                    <!-- Cover Photo -->
                    <div class="col-12 cover-photo">
                        <img src="https://via.placeholder.com/1248x263" alt="Cover Photo" class="img-fluid w-100">
                        <!-- Profile Photo -->
                        <div class="profile-photo-wrapper">
                            <div class="position-relative">
                                <img src="{{ $jobseekeraccount->avatar_id }}" alt="Profile Photo"
                                    class="profile-photo rounded-circle">
                                <i class="bi bi-patch-check-fill verification-badge"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="first_name" style="font-weight: 700;">First Name</label>
                        <input class="form-control bg-light" id="first_name" type="text" name="first_name" required
                            value="{{ $jobseekeraccount->first_name }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="last_name" style="font-weight: 700;">Last Name</label>
                        <input class="form-control bg-light" id="last_name" type="text" name="last_name" required
                        value="{{ $jobseekeraccount->last_name }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="form-label" for="first_name" style="font-weight: 700;">DOB</label>
                        <input class="form-control bg-light" id="dob" type="text" name="dob" required
                        value="{{ $jobseekeraccount->dob }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label" for="last_name" style="font-weight: 700;">Gender</label>
                        <input class="form-control bg-light" id="gender" type="text" name="gender" required
                        value="{{ $jobseekeraccount->gender }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label" for="last_name" style="font-weight: 700;">Cell Number</label>
                        <input class="form-control bg-light" id="phone" type="text" name="phone" required
                        value="{{ $jobseekeraccount->phone }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="first_name" style="font-weight: 700;">Address 1</label>
                        <input class="form-control bg-light" id="address" type="text" name="address" required
                        value="{{ $jobseekeraccount->address }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="first_name" style="font-weight: 700;">Address 2</label>
                        <input class="form-control bg-light" id="address_line_2" type="text" name="address_line_2" required
                        value="{{ $jobseekeraccount->address_line_2 }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label class="form-label" for="first_name" style="font-weight: 700;">City</label>
                        <input class="form-control bg-light" id="city" type="text" name="city" required
                        value="{{ $jobseekeraccount->city }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label" for="last_name" style="font-weight: 700;">Province</label>
                        <input class="form-control bg-light" id="province" type="text" name="province" required
                        value="{{ $jobseekeraccount->province }}">
                    </div>
                    <div class="form-group col-md-4">
                        <label class="form-label" for="last_name" style="font-weight: 700;">Permanent Residence</label>
                        <input class="form-control bg-light" id="permanent_resident" type="text"
                            name="permanent_resident" required value="{{ $jobseekeraccount->permanent_resident }}">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6">
                        <label class="form-label" for="first_name" style="font-weight: 700;">Favorite job tag</label>
                        <input class="form-control bg-light" id="favorite_job_tag" type="text"
                            name="favorite_job_tag" required value="{{ $jobseekeraccount->job_tag }}">
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label" for="last_name" style="font-weight: 700;">Job Skill</label>
                        <input class="form-control bg-light" id="job_skill" type="text" name="job_skill" required
                        value="{{ $jobseekeraccount->job_skill }}">
                    </div>
                </div>

                <div class="container mt-5">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="last_name" style="font-weight: 700;">Attactment CV</label>
                                <input class="form-control bg-light" id="permanent_resident" type="file"
                                    name="permanent_resident" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group col-md-6">
                                <label class="form-label" for="last_name" style="font-weight: 700;">Cover Letter</label>
                                <input class="form-control bg-light" id="permanent_resident" type="file"
                                    name="permanent_resident" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container mt-5 px-2 py-3">
                    <div class="row align-items-center border border-1 rounded py-2">
                        <div class="col-md-3">
                            <p>Legally entitled to work in Canada?</p>
                        </div>
                        <div class="col-md-9">
                            <button type="button" class="btn btn-outline-danger px-5">No</button>
                            <button type="button" class="btn btn-outline-success px-5">Yes</button>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-12">
                        <label class="form-label" for="last_name" style="font-weight: 700;">Introduce Yourself</label>
                        <div class="textarea-container">
                            <textarea id="introduce_yourself" name="introduce_yourself" class="form-control bg-light" required
                            value="{{ $jobseekeraccount->bio }}"></textarea>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-center">
                    <button type="submit" class="btn btn-primary fw-bold px-5 my-3">Save all the changes</button>
                </div>
                @endforeach
            </form>
        </div>
    </div>





    <script>
        function setupDragDrop(dragDropAreaId, fileInputId) {
            const dragDropArea = document.getElementById(dragDropAreaId);
            const fileInput = document.getElementById(fileInputId);

            dragDropArea.addEventListener('click', () => {
                fileInput.click();
            });

            dragDropArea.addEventListener('dragover', (e) => {
                e.preventDefault();
                dragDropArea.classList.add('dragging');
            });

            dragDropArea.addEventListener('dragleave', () => {
                dragDropArea.classList.remove('dragging');
            });

            dragDropArea.addEventListener('drop', (e) => {
                e.preventDefault();
                dragDropArea.classList.remove('dragging');
                const files = e.dataTransfer.files;
                handleFiles(files, dragDropAreaId);
            });

            fileInput.addEventListener('change', (e) => {
                const files = e.target.files;
                handleFiles(files, dragDropAreaId);
            });
        }

        function handleFiles(files, areaId) {
            console.log('Files uploaded in', areaId, ':', files);
            // Handle files here (e.g., upload them to the server)
        }

        setupDragDrop('drag-drop-area-1', 'fileInput1');
        setupDragDrop('drag-drop-area-2', 'fileInput2');
    </script>
@endsection
