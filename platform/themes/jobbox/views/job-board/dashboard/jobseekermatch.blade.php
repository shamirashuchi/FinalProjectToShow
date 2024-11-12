@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))

@section('content')

<style>
    thead tr {
  background-color: #0879EA;
  color: white;
}



</style>

<h5>Here are some <span style="color: #0879EA">Matched Jobseekers</span> for you!</h5>
<br>

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th style="color: #ffffff;font-weight:bold">Job Title</th>
                <th style="color: #ffffff;font-weight:bold">Company</th>
                <th style="color: #ffffff;font-weight:bold">Jobseeker Name</th>
                <th style="color: #ffffff;font-weight:bold">View Details & Schedule Interview</th>
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


                    <a target="_blank" href="" class="btn btn-sm btn-primary">View</a>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@stop
