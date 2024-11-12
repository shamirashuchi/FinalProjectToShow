<!-- @extends(JobBoardHelper::viewPath('dashboard.layouts.master'))

 -->


@section('content')


<style>
    .main {
        margin-top: 54px !important;
    }
    
    .btn-expanded {
       
        top: 0px !important;

    }
    
    .nav-item {
        max-width: 140px !important;

    }
    
    
    
</style>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Day</th>
            <th>Start Time</th>
            <th>End Time</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($events as $event)
        <tr>
            <td>{{ $event->id }}</td>
            <td>{{ $event->date}}</td>
            <td>{{ $event->day}}</td>
            <td>{{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') }}</td>
            <td>{{ \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</td>
            <td>
                <a href="{{ route('getToken')}}" class="btn btn-primary">
                    Join Meeting
                </a>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select all elements with the 'join-meeting' class and add click event listeners
        document.querySelectorAll('.join-meeting').forEach(function(button) {
            button.addEventListener('click', function() {
                // Use Fetch API to make an AJAX request
                fetch("{{ route('getToken') }}") // Add the missing closing quote
                    .then(response => response.json())
                    .then(data => {
                        if (data.token) {
                            console.log("AJAX request succeeded.");
                            window.location.href = "http://127.0.0.1:8000/account/index";
                            alert("Token received: " + data.token);
                        } else {
                            alert("Failed to get token. Please try again.");
                        }
                    })
                    .catch(error => {
                        console.error("Error fetching token:", error);
                        alert("Failed to get token. Please try again.");
                    });
            });
        });
    });
</script> -->



@endsection
