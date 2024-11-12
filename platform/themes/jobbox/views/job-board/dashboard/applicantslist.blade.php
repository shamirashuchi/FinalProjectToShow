@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))

@section('content')

    <style>
        thead tr {
            background-color: #0879EA;
            color: white;
        }
    </style>

    <h5><span style="color:#0879EA">All Applicants</span> who applied so far.</h5>
    <br>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th style="color: #ffffff;font-weight:bold">Applicant Name</th>
                    <th style="color: #ffffff;font-weight:bold">Job Title</th>
                    <th style="color: #ffffff;font-weight:bold">View Details</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($combinedResultArray as $row)
                    <tr>
                        <td>{{ $row->first_name }} {{ $row->last_name }}</td>
                        <td>{{ $row->name }}</td>
                        <td>
                            @if (isset($row->jb_application_id))
                                <a href="{{ route('public.account.applicants.edit', ['applicant' => $row->jb_application_id]) }}"
                                    class="btn btn-xs px-2">
                                    <i class="material-icons md-add"></i>
                                    <span>{{ __('View') }}</span>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- <td>
                    @php


                        $servername = "localhost";
                        $username = "root";
                        $password = '';
                        $dbname = "ready_force";


                        $conn = new mysqli($servername, $username, $password, $dbname);

                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }


                        $sql = "SELECT * FROM paytoseedetails WHERE company_id = $company_id AND job_id = $row->job_id AND applicant_id = $row->account_id";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            // Row data is found.
                            echo '<a target="_blank" href="'. route('public.account.applicants.edit', $row->jb_application_id) .'" class="btn btn-sm btn-primary">View Details</a>';
                        } else {
                            // No row data found.
                            echo '
                                <form action="   '. route('public.account.paytoseedetails') .'   " method="POST">
                                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                                    <input type="hidden" name="company_id" value="'. $company_id .'">
                                    <input type="hidden" name="job_id" value="'. $row->job_id .'">
                                    <input type="hidden" name="applicant_id" value="'. $row->account_id .'">
                                    <button type="submit" class="btn btn-sm btn-primary">Pay & See Details</button>
                                </form>
                            ';
                        }
                    @endphp
                </td> --}}
@stop
