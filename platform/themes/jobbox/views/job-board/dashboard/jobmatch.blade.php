@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))

@section('content')

    <style>
        thead tr {
            background-color: blue;
            color: white;
        }
    </style>


    {{-- <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="color: #ffffff;font-weight:bold">Job Title</th>
                    <th style="color: #ffffff;font-weight:bold">Description</th>
                    <th style="color: #ffffff;font-weight:bold">Company</th>
                    <th style="color: #ffffff;font-weight:bold">View Details & Apply</th>
                </tr>
            </thead>
            <tbody>

                @php
                    use Illuminate\Support\Str;
                @endphp

                @foreach ($resultArray as $row)
                <tr>
                    <td>{{ $row->name }}</td>
                    <td>{{ $row->description }}</td>
                    <td>{{ $row->company_name }}</td>
                    <td>


                        <a target="_blank" href="{{ url('jobs/' . Str::slug($row->name, '-')) }}" class="btn btn-sm btn-primary">View</a>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div> --}}



    <div class="px-5">
        <div class="container py-4 px-5" style="background-color: #f8f9fa; border-radius: 10px;">
            <div class="row align-items-center px-5">
                <div class="col-lg-6">
                    <div>
                        <h6 class="fs-16 mb-0">Matched Job</h6>
                    </div>
                </div>

            </div>


            <div class="px-5 py-3">

                <div class="pb-4">
                    <div class="col-md-12 pt-3 pb-4 px-3 mb-5 border border-1 rounded-3 shadow-sm">
                        @forelse ($resultArray as $row)
                            <div>
                                <div class="row d-flex align-items-center">
                                    <div class="col-md-6 ">
                                        <div class="row align-items-center">
                                            <div class="col-md-1">
                                                <img src="https://via.placeholder.com/52x52" alt=""
                                                    class="img-fluid">
                                            </div>
                                            <div class="col-md-11">
                                                <h5>{{ $row->company_name }}</h5>
                                                <span class="text-muted"><i class="bi bi-geo-alt"></i> Paris France,
                                                    FRA</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-end text-warning fs-1">
                                        <span>
                                            <i class="bi bi-star-fill m-3"></i>
                                            <i class="bi bi-star-fill m-3"></i>
                                            <i class="bi bi-star-fill m-3"></i>
                                        </span>
                                    </div>
                                </div>
                                <h3 class="pt-2">{{ $row->name }}</h3>
                                <span class="text-muted">
                                    <span><i class="bi bi-bag-dash px-1"></i>Freelance</span>
                                    <span><i class="bi bi-clock px-1"></i>6 days ago</span>
                                </span>
                                <p class="my-3">{{ $row->description }}</p>
                                <span class="d-flex align-items-center justify-content-between w-100">
                                    <span>
                                        <span class="fw-bold text-primary fs-3">$5,200 - $900</span>
                                        <span>/Yearly</span>
                                    </span>

                                    <a target="_blank" href="{{ url('jobs/' . Str::slug($row->name, '-')) }}"
                                        class="btn btn-primary">View Job</a>
                                </span>
                            </div>
                        @empty
                            <div class="alert alert-warning my-2">
                                {{ __('No matched jobs found.') }}
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="pb-4">
                    <div class="col-md-12 pt-3 pb-4 px-3 mb-5 border border-1 rounded-3 shadow-sm">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-6 ">
                                <div class="row align-items-center">
                                    <div class="col-md-1">
                                        <img src="https://via.placeholder.com/52x52" alt="" class="img-fluid">
                                    </div>
                                    <div class="col-md-11">
                                        <h5>Linkedin</h5>
                                        <span class="text-muted"><i class="bi bi-geo-alt"></i> Paris France, FRA</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-end text-warning fs-1">
                                <span>
                                    <i class="bi bi-star-fill m-3"></i>
                                    <i class="bi bi-star-fill m-3"></i>
                                    <i class="bi bi-star-fill m-3"></i>
                                </span>
                            </div>
                        </div>
                        <h3 class="pt-2">UI/UX Designer full-time</h3>
                        <span class="text-muted">
                            <span><i class="bi bi-bag-dash px-1"></i>Freelance</span>
                            <span><i class="bi bi-clock px-1"></i>6 days ago</span>
                        </span>
                        <p class="my-3">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt modi ex nisi eos
                            eius quas nam numquam culpa dolor, nostrum vero ipsum deserunt iste saepe? Amet dolor eum
                            incidunt velit.</p>
                        <span class="d-flex align-items-center justify-content-between w-100">
                            <span>
                                <span class="fw-bold text-primary fs-3">$5,200 - $900</span>
                                <span>/Yearly</span>
                            </span>
                            <button class="btn btn-primary">View Job</button>
                        </span>
                    </div>
                </div>

            </div>

        </div><!--end container-->
    </div><!--end container-->


@stop
