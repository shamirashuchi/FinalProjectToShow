<style>
    .left-side {
        border: 1px solid rgba(200, 200, 200, 0.5); /* Softer gray for a modern touch */
        border-radius: 8px; /* Rounded corners for a premium feel */
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); /* Softer shadow for depth */
        background-color: #ffffff; /* Clean white background for contrast */
        padding: 15px; /* Add padding for better content spacing */
        transition: transform 0.3s ease, box-shadow 0.3s ease; /* Smooth transitions */
    }

    .left-side:hover {
        transform: translateY(-2px); /* Slight lift effect on hover */
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2); /* Enhanced shadow on hover */
    }
</style>

<div class="container" style="margin-top:80px;">
    <div class="row justify-content-center">

        <div class="col-md-3 text-center mb-3 mb-md-0">
            <div class="left-side mb-80">
                <img src="{{ $consultantdetails->avatar_url }}" alt="User Profile Picture" class="img-fluid">
                <p class="mt-10">Name: {{ $consultantdetails->first_name }} {{ $consultantdetails->last_name }}</p>
                <p class="mt-10">Gender: {{ $consultantdetails->gender }} </p>
               
   
  
                @foreach ($events as $event)
                    <button class="btn btn-primary m-1 event-button" data-id="{{ $event->id }}" data-date="{{ $event->date }}">
                        {{ $event->date }}
                    </button>
                @endforeach

                <!-- Book Appointment Button -->
                 
                <button id="book-appointment-btn" class="btn btn-secondary m-1"
                @if($jobseekerdetails->credits < 1) disabled @endif>
                    Book Appointment{{$jobseekerdetails->credits}}
                </button>




                <!-- <div>
                    <h6 class="btn rounded-pill fw-bold text-white mt-20 mb-10 px-4 py-2" style="background: rgba(5, 38, 78, 1);">
                        <a class="text-white" href="{{ route('consultantmeeting', ['id' => $consultantdetails->id]) }}"  target="_blank" rel="noopener noreferrer">
                            Set Meeting
                        </a>
                    </h6>
                </div> -->
            </div>
        </div>

        <div class="col-md-9">
            <div>
                <h2>Consultant Profile</h2>
                @foreach ($consultantdetails->consultantPackages as $pack)
                {{$pack->is_booked}}
                ${{ $pack->credits }}
                @endforeach
                <hr>
                <p class="mt-6 fw-bold">Introduction</p>
                <p style="text-align: justify;">{{ $consultantdetails->description }}</p>
                <p class="mt-6 fw-bold pt-10">Objectives</p>
                <p style="text-align: justify;">{!! $consultantdetails->bio !!}</p>
            </div>





            {{-- @php
                $averageRating = $consultantdetails->consultantReviews->avg('rating');
                $roundedRating = round($averageRating); // Rounded average rating for display
                $authUser = auth('account')->user();
            @endphp --}}

            {{-- @if ($authUser?->type == 'job-seeker')
                <form id="ratingForm" action="{{ route('consultant.reviewed', ['id' => $consultantdetails->id]) }}"
                    method="POST">
                    @csrf
                    <div class="rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <input type="radio" name="rating" value="{{ $i }}" id="rs{{ $i }}"
                                {{ $i == $roundedRating ? 'checked' : '' }}>
                            <label for="rs{{ $i }}"></label>
                        @endfor
                        <span id="rating-counter">{{ $roundedRating }}</span>
                    </div>
                    <div id="noteDiv" style="display: none;">
                        <div class="d-flex flex-column align-items-start">
                            <label for="note" class="form-label">Additional note</label>
                            <textarea name="note" id="note" class="form-input" style=" width:400px; margin: 0 auto;" rows="5"
                                cols="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-success rounded-pill px-2 py-2 mt-2"
                            data-confirm-delete="true">
                            <i class="fa-solid fa-check"></i>
                        </button>
                    </div>
                </form>
            @else
                <div class="rating-stars mx-auto">
                    {{-- @for ($i = 1; $i <= 5; $i++)
                        <label for="rs-{{ $i }}"
                            style="background-color: {{ $i <= $roundedRating ? 'orange' : '#000b' }};"></label>
                    @endfor --}}
                    {{-- @php
                        $filledStars = $roundedRating;
                        $totalStars = 5;
                        $emptyStars = $totalStars - $filledStars;
                    @endphp

                    @for ($i = 1; $i <= $filledStars; $i++)
                        <i class="fa fa-star" style="color: orange;"></i> <!-- Filled star -->
                    @endfor

                    @for ($i = 1; $i <= $emptyStars; $i++)
                        <i class="fa fa-star" style="color: lightgray;"></i> <!-- Empty star -->
                    @endfor
                    <span id="rating-counter">{{ $roundedRating }}</span>
                </div>
            @endif --}}

            {{-- <div class="row g-2 my-5">
                @forelse ($consultantdetails->consultantReviews as $item)
                    <div class="col-12 col-sm-6 col-md-4">
                        <div class="card">
                            <div class="card-body relative">
                                @if ($authUser?->id === $consultantdetails?->id)
                                    <form
                                        action="{{ route('consultant.review.delete', ['consultantReview' => $item->id]) }}"
                                        method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn-delete p-2 bg-white rounded position-absolute end-0 top-0 m-2 shadow-lg shadow-hover-sm">
                                            <i class="fa-solid fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                @endif
                                <p>{{ $item->note }}</p>
                                <img src="https://via.placeholder.com/60" class="rounded-circle" alt="">
                                <h5>{{ $item->reviewer->first_name . ' ' . $item->reviewer->last_name }}</h5>
                                <div>
                                    @php
                                        $filledStars = $item->rating;
                                        $totalStars = 5;
                                        $emptyStars = $totalStars - $filledStars;
                                    @endphp

                                    @for ($i = 1; $i <= $filledStars; $i++)
                                        <i class="fa fa-star" style="color: orange;"></i> <!-- Filled star -->
                                    @endfor

                                    @for ($i = 1; $i <= $emptyStars; $i++)
                                        <i class="fa fa-star" style="color: lightgray;"></i> <!-- Empty star -->
                                    @endfor

                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No reviews found</p>
                @endforelse

            </div> --}}

            {{-- @if ($consultantdetails->calendly != null)
                <a target="_blank" href="{{ $consultantdetails->calendly }}" class="btn btn-primary">Book on
                    Calendly</a>
            @endif --}}

            {{-- @if (count($consultantdetails->consultantPackages) > 0)
                <div class="row mt-4">
                    <div class="col-12 text-center mb-3 pb-1 border-bottom">
                        <h2>Get Consultency from</h2>
                        <p class="text-sm text-secondary">Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                            Aliquam,
                            voluptatibus!</p>
                    </div>




                    <div class="row gy-3">
                        @foreach ($consultantdetails->consultantPackages as $pack)
                            <div class="col-12 col-md-4 col-sm-6 ">
                                <div class="card pt-2 pb-4 px-2 position-relative" style="border-color: #072AC8;">
                                    <div class="card-header py-3 px-2 border-0 text-center position-relative"
                                        style="background: linear-gradient(113.99deg, #0E2CB1 4.67%, #06134B 93.96%);">
                                        <h5 class="d-block text-center pb-0 text-white">{{ $pack->name }}</h5>
                                        <span class=" text-center fw-bold " style="font-size: .70rem; gap: 13px;">
                                            <svg fill="#FFFE3A" version="1.1" id="Layer_1"
                                                xmlns="http://www.w3.org/2000/svg"
                                                xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512"
                                                xml:space="preserve" height="16px" width="auto">
                                                <g>
                                                    <g>
                                                        <g>
                                                            <path
                                                                d="M358.4,264.084h43.116c13.373,0,24.253-10.879,24.253-24.253c0-13.373-10.879-24.253-24.253-24.253H358.4     c-13.373,0-24.253,10.879-24.253,24.253C334.147,253.205,345.027,264.084,358.4,264.084z M358.4,231.747h43.116     c4.458,0,8.084,3.626,8.084,8.084c0,4.458-3.626,8.084-8.084,8.084H358.4c-4.458,0-8.084-3.626-8.084-8.084     C350.316,235.373,353.942,231.747,358.4,231.747z" />
                                                            <path
                                                                d="M467.898,54.398c-3.359-12.684-14.931-22.061-28.656-22.061h-45.811v-8.084C393.432,10.879,382.552,0,369.179,0     s-24.253,10.879-24.253,24.253v8.084h-64.674v-8.084C280.253,10.879,269.373,0,256,0c-13.373,0-24.253,10.879-24.253,24.253     v8.084h-64.674v-8.084C167.074,10.879,156.195,0,142.821,0c-13.373,0-24.253,10.879-24.253,24.253v8.084h-45.81     c-13.725,0-25.297,9.378-28.656,22.061C19.22,57.866,0,79.273,0,105.095V460.8C0,489.031,22.969,512,51.2,512h409.6     c28.231,0,51.2-22.969,51.2-51.2V105.095C512,79.273,492.78,57.866,467.898,54.398z M361.095,24.253     c0-4.458,3.626-8.084,8.084-8.084c4.458,0,8.084,3.626,8.084,8.084v32.337c0,4.458-3.626,8.084-8.084,8.084     c-4.458,0-8.084-3.626-8.084-8.084V24.253z M247.916,24.253c0-4.458,3.626-8.084,8.084-8.084c4.458,0,8.084,3.626,8.084,8.084     v32.337c0,4.458-3.626,8.084-8.084,8.084c-4.458,0-8.084-3.626-8.084-8.084V24.253z M134.737,24.253     c0-4.458,3.626-8.084,8.084-8.084c4.458,0,8.084,3.626,8.084,8.084v32.337c0,4.458-3.626,8.084-8.084,8.084     c-4.458,0-8.084-3.626-8.084-8.084V24.253z M495.832,460.8c0,19.316-15.716,35.032-35.032,35.032H51.2     c-19.316,0-35.032-15.716-35.032-35.032V105.095c0-16.534,11.517-30.419,26.947-34.08v368.227     c0,16.345,13.297,29.642,29.642,29.642h300.733c4.465,0,8.084-3.62,8.084-8.084s-3.62-8.084-8.084-8.084H72.758     c-7.43,0-13.474-6.044-13.474-13.474V123.958h369.179c4.465,0,8.084-3.62,8.084-8.084c0-4.465-3.62-8.084-8.084-8.084H59.284     V61.979c0-7.43,6.044-13.474,13.474-13.474h45.81v8.084c0,13.373,10.879,24.253,24.253,24.253     c13.373,0,24.253-10.879,24.253-24.253v-8.084h64.674v8.084c0,13.373,10.879,24.253,24.253,24.253     c13.373,0,24.253-10.879,24.253-24.253v-8.084h64.674v8.084c0,13.373,10.879,24.253,24.253,24.253s24.253-10.879,24.253-24.253     v-8.084h45.811c7.43,0,13.474,6.044,13.474,13.474v377.263c0,7.43-6.044,13.474-13.474,13.474h-32.337     c-4.465,0-8.084,3.62-8.084,8.084s3.62,8.084,8.084,8.084h32.337c16.345,0,29.642-13.297,29.642-29.642V71.015     c15.43,3.661,26.947,17.546,26.947,34.08V460.8z" />
                                                            <path
                                                                d="M425.768,390.737c0-13.373-10.879-24.253-24.253-24.253H358.4c-13.373,0-24.253,10.879-24.253,24.253     c0,13.373,10.879,24.253,24.253,24.253h43.116C414.889,414.989,425.768,404.11,425.768,390.737z M350.316,390.737     c0-4.458,3.626-8.084,8.084-8.084h43.116c4.458,0,8.084,3.626,8.084,8.084c0,4.458-3.626,8.084-8.084,8.084H358.4     C353.942,398.821,350.316,395.195,350.316,390.737z" />
                                                            <path
                                                                d="M358.4,339.537h43.116c13.373,0,24.253-10.879,24.253-24.253c0-13.373-10.879-24.253-24.253-24.253H358.4     c-13.373,0-24.253,10.879-24.253,24.253C334.147,328.658,345.027,339.537,358.4,339.537z M358.4,307.2h43.116     c4.458,0,8.084,3.626,8.084,8.084c0,4.458-3.626,8.084-8.084,8.084H358.4c-4.458,0-8.084-3.626-8.084-8.084     C350.316,310.826,353.942,307.2,358.4,307.2z" />
                                                            <path
                                                                d="M153.6,366.484h-43.116c-13.373,0-24.253,10.879-24.253,24.253c0,13.373,10.879,24.253,24.253,24.253H153.6     c13.373,0,24.253-10.879,24.253-24.253C177.853,377.363,166.973,366.484,153.6,366.484z M153.6,398.821h-43.116     c-4.458,0-8.084-3.626-8.084-8.084c0-4.458,3.626-8.084,8.084-8.084H153.6c4.458,0,8.084,3.626,8.084,8.084     C161.684,395.195,158.058,398.821,153.6,398.821z" />
                                                            <path
                                                                d="M153.6,215.579h-43.116c-13.373,0-24.253,10.879-24.253,24.253c0,13.373,10.879,24.253,24.253,24.253H153.6     c13.373,0,24.253-10.879,24.253-24.253C177.853,226.458,166.973,215.579,153.6,215.579z M153.6,247.916h-43.116     c-4.458,0-8.084-3.626-8.084-8.084c0-4.458,3.626-8.084,8.084-8.084H153.6c4.458,0,8.084,3.626,8.084,8.084     C161.684,244.29,158.058,247.916,153.6,247.916z" />
                                                            <path
                                                                d="M277.558,291.032h-43.116c-13.373,0-24.253,10.879-24.253,24.253c0,13.373,10.879,24.253,24.253,24.253h43.116     c13.373,0,24.253-10.879,24.253-24.253C301.811,301.911,290.931,291.032,277.558,291.032z M277.558,323.368h-43.116     c-4.458,0-8.084-3.626-8.084-8.084c0-4.458,3.626-8.084,8.084-8.084h43.116c4.458,0,8.084,3.626,8.084,8.084     C285.642,319.742,282.016,323.368,277.558,323.368z" />
                                                            <path
                                                                d="M153.6,291.032h-43.116c-13.373,0-24.253,10.879-24.253,24.253c0,13.373,10.879,24.253,24.253,24.253H153.6     c13.373,0,24.253-10.879,24.253-24.253C177.853,301.911,166.973,291.032,153.6,291.032z M153.6,323.368h-43.116     c-4.458,0-8.084-3.626-8.084-8.084c0-4.458,3.626-8.084,8.084-8.084H153.6c4.458,0,8.084,3.626,8.084,8.084     C161.684,319.742,158.058,323.368,153.6,323.368z" />
                                                            <path
                                                                d="M277.558,366.484h-43.116c-13.373,0-24.253,10.879-24.253,24.253c0,13.373,10.879,24.253,24.253,24.253h43.116     c13.373,0,24.253-10.879,24.253-24.253C301.811,377.363,290.931,366.484,277.558,366.484z M277.558,398.821h-43.116     c-4.458,0-8.084-3.626-8.084-8.084c0-4.458,3.626-8.084,8.084-8.084h43.116c4.458,0,8.084,3.626,8.084,8.084     C285.642,395.195,282.016,398.821,277.558,398.821z" />
                                                            <path
                                                                d="M320.674,161.684H191.326c-4.465,0-8.084,3.62-8.084,8.084s3.62,8.084,8.084,8.084h129.347     c4.465,0,8.084-3.62,8.084-8.084S325.138,161.684,320.674,161.684z" />
                                                            <path
                                                                d="M277.558,215.579h-43.116c-13.373,0-24.253,10.879-24.253,24.253c0,13.373,10.879,24.253,24.253,24.253h43.116     c13.373,0,24.253-10.879,24.253-24.253C301.811,226.458,290.931,215.579,277.558,215.579z M277.558,247.916h-43.116     c-4.458,0-8.084-3.626-8.084-8.084c0-4.458,3.626-8.084,8.084-8.084h43.116c4.458,0,8.084,3.626,8.084,8.084     C285.642,244.29,282.016,247.916,277.558,247.916z" />
                                                        </g>
                                                    </g>
                                                </g>
                                            </svg>

                                            <div class="price-info text-center">
                                                <span class="price-amount">${{ $pack->credits }}</span>
                                                <span class="price-period text-lowercase">/mo</span>
                                            </div>


                                            <div class="text-white text-center">
                                                {{ formatTime($pack->start_time) }} To
                                                {{ formatTime($pack->end_time) }}
                                            </div>
                                            <div class="bg-warning text-center position:absolute detailButton">
                                                <p>Save 70%</p>
                                            </div>
                                    </div>


                                    <div class="card-body">
                                        <div class="d-flex justify-content-start align-items-center">
                                            <svg width="17" height="18" viewBox="0 0 17 18" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M8.5 0.814453C10.1811 0.814453 11.8245 1.29451 13.2223 2.19391C14.6202 3.0933 15.7096 4.37166 16.353 5.8673C16.9963 7.36295 17.1646 9.00872 16.8367 10.5965C16.5087 12.1843 15.6992 13.6427 14.5104 14.7874C13.3217 15.9322 11.8071 16.7117 10.1583 17.0275C8.50943 17.3434 6.80036 17.1813 5.24719 16.5618C3.69402 15.9422 2.3665 14.8931 1.43251 13.5471C0.498516 12.201 0 10.6185 0 8.99964C0 6.82879 0.895533 4.74686 2.48959 3.21184C4.08365 1.67682 6.24566 0.814453 8.5 0.814453Z"
                                                    fill="#00A912" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.86202 7.70123L7.36861 9.07608L10.9296 5.59498C11.2243 5.30722 11.4097 5.07542 11.7736 5.43645L12.9536 6.60081C13.341 6.96984 13.3216 7.18699 12.9536 7.53337L8.04374 12.1855C7.27176 12.9129 7.40596 12.9569 6.6243 12.2108L3.87398 9.57833C3.71073 9.40781 3.72871 9.23595 3.90718 9.06676L5.27681 7.69856C5.48433 7.48807 5.65035 7.50672 5.86063 7.69856L5.86202 7.70123Z"
                                                    fill="white" />
                                            </svg>

                                            <p class="text-start">{{ $pack->description }}</p>
                                        </div>
                                    </div>
                                    @if ($pack->is_booked !== 1)
                                        <a href="{{ route('public.account.consultant-packages.purchase', ['consultantPackage' => $pack]) }}"
                                            class="btn btn-full rounded-pill shadow-lg shadow-hover-sm text-white"
                                            style="background: #072AC8">Buy Now</a>
                                    @else
                                        <span class="fw-bold text-center d-block">Booked</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>




            @endif

        </div> --}}

    </div>
    <hr>


    <style>
        #ratingForm {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .rating-stars {
            display: block;
            width: max-content;
            padding: .5rem 5rem .5rem .95rem;
            background: #e4e4e4;
            border-radius: 2rem;
            position: relative;
            overflow: hidden;
        }

        #rating-counter {
            font-size: 1.37rem;
            font-family: Arial, Helvetica, serif;
            color: #9aacc6;
            width: 3rem;
            text-align: center;
            background: #0006;
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            /* border-radius: 0 5vmin 5vmin 0; */
            line-height: normal;
            display: flex;
            align-items: center;
            justify-content: center;
        }



        /* Change content dynamically when a rating is selected */
        input:checked~.rating-counter:before {
            content: attr(value);
            /* Display the selected rating */
        }

        /* Change content dynamically on hover */
        .rating-stars label:hover~.rating-counter:before {
            content: attr(for);
            /* Display the hovered rating */
        }

        input {
            display: none;
        }

        .rating-stars label {
            width: 5vmin;
            height: 5vmin;
            background: #000b;
            display: inline-flex;
            cursor: pointer;
            margin: 0.5vmin 0.65vmin;
            transition: all 1s ease 0s;
            clip-path: polygon(50% 0%, 66% 32%, 100% 38%, 78% 64%, 83% 100%, 50% 83%, 17% 100%, 22% 64%, 0 38%, 34% 32%);
        }

        .rating-stars label[for=rs0] {
            display: none;
        }

        .rating-stars label:before {
            width: 90%;
            height: 90%;
            content: "";
            background: orange;
            z-index: -1;
            display: block;
            margin-left: 5%;
            margin-top: 5%;
            clip-path: polygon(50% 0%, 66% 32%, 100% 38%, 78% 64%, 83% 100%, 50% 83%, 17% 100%, 22% 64%, 0 38%, 34% 32%);
            background: linear-gradient(90deg, #ffb400, #ffe802 30% 50%, #184580 50%, 70%, #173a75 100%);
            background-size: 205% 100%;
            background-position: 0 0;
        }

        .rating-stars label:hover:before {
            transition: all 0.25s ease 0s;
        }

        input:checked+label~label:before {
            background-position: 100% 0;
            transition: all 0.25s ease 0s;
        }

        input:checked+label~label:hover:before {
            background-position: 0% 0
        }





        #rs1:checked~.rating-counter:before {
            content: "1";
        }

        #rs2:checked~.rating-counter:before {
            content: "2";
        }

        #rs3:checked~.rating-counter:before {
            content: "3";
        }

        #rs4:checked~.rating-counter:before {
            content: "4";
        }

        #rs5:checked~.rating-counter:before {
            content: "5";
        }

        label+input:checked~.rating-counter:before {
            color: #ffab00 !important;
            transition: all 0.25s ease 0s;
        }





        .rating-stars label:hover~.rating-counter:before {
            color: #9aacc6 !important;
            transition: all 0.5s ease 0s;
            animation: pulse 1s ease 0s infinite;
        }

        @keyframes pulse {
            50% {
                font-size: 6.25vmin;
            }
        }

        label[for=rs1]:hover~.rating-counter:before {
            content: "1" !important;
        }

        label[for=rs2]:hover~.rating-counter:before {
            content: "2" !important;
        }

        label[for=rs3]:hover~.rating-counter:before {
            content: "3" !important;
        }

        label[for=rs4]:hover~.rating-counter:before {
            content: "4" !important;
        }

        label[for=rs5]:hover~.rating-counter:before {
            content: "5" !important;
        }


        input:checked:hover~.rating-counter:before {
            animation: none !important;
            color: #ffab00 !important;
        }
    </style>
    <style>
        .price-info {
            display: flex;
            flex-direction: row;
            justify-content: center;
            margin-top: 8px;
        }

        .price-info .price-amount {
            color: #8692C9;
            font-size: 22px;
        }

        .price-info .price-period {
            margin-top: 6px;
            font-size: 8px;
            color: #000;
        }

        .detailButton {
            position: absolute;
            width: 91px;
            height: 30px;
            bottom: -15px;
            left: 0;
        }
    </style>
    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
</div>
<script defer>
    document.addEventListener('DOMContentLoaded', function() {
        var stars = document.querySelectorAll('.rating-stars input[type="radio"]');
        var counter = document.getElementById('rating-counter');
        const note = $('#noteDiv');

        // Function to update the counter based on the current rating
        function updateCounter(value) {
            counter.textContent = value;
        }

        // Set initial rating counter
        updateCounter(initialRating);

        stars.forEach(function(star) {
            star.addEventListener('change', function() {
                const selectedValue = $(this).val();
                updateCounter(
                    selectedValue
                ); // Display the note element with animation if a star rating is selected
                if (selectedValue > 0) {
                    note.stop().slideDown('fast'); // Slide down animation for showing the note
                } else {
                    note.stop().slideUp('fast'); // Slide up animation for hiding the note
                }
            });

            star.nextElementSibling.addEventListener('mouseover', function() {
                updateCounter(this.previousElementSibling.value);
            });

            star.nextElementSibling.addEventListener('mouseleave', function() {
                var checkedStar = document.querySelector(
                    '.rating-stars input[type="radio"]:checked');
                updateCounter(checkedStar ? checkedStar.value : initialRating);
            });
        });
    });
</script>
<script>
    document.querySelectorAll('.delete-form').forEach(function(form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting

            // Use SweetAlert for confirmation
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you really want to delete this review?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>


{{-- <script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript" async></script>
<script type="text/javascript">
    window.onload = function() {
        Calendly.initBadgeWidget({
            url: 'https://calendly.com/mdmasumbillah-se',
            text: 'Schedule time with me',
            color: '#0069ff',
            textColor: '#ffffff',
            branding: true
        });
    }
</script> --}}

<script>
document.querySelectorAll('.event-button').forEach(button => {
    button.addEventListener('click', function() {
        // Check if the button is already selected
        const isSelected = this.classList.contains('btn-warning');
        
        if (isSelected) {
            // Unselect the button and reset Book Appointment button
            this.classList.remove('btn-warning');
            this.classList.add('btn-primary');
            
            // Disable the Book Appointment button
            const bookButton = document.getElementById('book-appointment-btn');
            bookButton.disabled = true;
            bookButton.style.background = 'rgba(5, 38, 78, 1)'; // Default background color
            bookButton.classList.remove('btn-success');
            bookButton.classList.add('btn-secondary');
            delete bookButton.dataset.eventId;
            delete bookButton.dataset.eventDate;
        } else {
            if ({{ $jobseekerdetails->credits }} > 1) {
            // Show alert if insufficient balance
            alert('Insufficient balance');
            return;
            }
            else{
            this.classList.add('btn-warning');
            this.classList.remove('btn-primary');
            // Select the button and enable Book Appointment button
            
            // Enable the Book Appointment button and update its appearance
            const bookButton = document.getElementById('book-appointment-btn');
            bookButton.disabled = false;
        
            bookButton.classList.remove('btn-secondary');
            bookButton.classList.add('btn-success'); // Adding success class for green color
            
            // Set the correct background color when active
            bookButton.style.background = 'RGB(5, 38, 78)'; // Active state background color
            
            // Store the selected event's data (e.g., event id and date)
            bookButton.dataset.eventId = this.dataset.id;
            bookButton.dataset.eventDate = this.dataset.date;
         
            }
            
        }
    });
});

const bookButton = document.getElementById('book-appointment-btn');
    bookButton.addEventListener('click', function() {
        if (!bookButton.disabled) {
            bookButton.disabled = true;
            const eventButton = document.querySelector(`[data-id="${bookButton.dataset.eventId}"]`);
            if (eventButton) {
                eventButton.classList.remove('btn-warning');
                eventButton.classList.add('btn-primary');
            }
            fetch(`/appointment/${bookButton.dataset.eventId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Include CSRF token for security
                },
                body: JSON.stringify({
                    event_date: bookButton.dataset.eventDate, // Only send the event_date in the body
                }),
            })
            .then(response => response.json())
            .then(data => {
                // Handle success (you can display a success message here)
                console.log('Success:', data);
                alert('Appointment booked successfully!');
            })
            .catch((error) => {
                // Handle error
                console.error('Error:', error);
            });
        }
    });

</script>