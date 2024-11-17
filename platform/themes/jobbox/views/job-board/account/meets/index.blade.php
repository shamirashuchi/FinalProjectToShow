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
    
    #current-date {
        display: none;
    }

    /* Hide the Join Meeting button by default */
    .join-meeting-btn {
        display: none;
    }
    
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get the content of the 'current-date' and 'event-date' cells
        const currentDate = document.getElementById('current-date').textContent.trim();
        const eventDate = document.getElementById('event-date').textContent.trim();
        
        // Get the Join Meeting button
        const joinMeetingButton = document.getElementById('join-meeting-btn');

        // Compare the dates
        if (currentDate === eventDate) {
            console.log("The dates match!");
            // Show the Join Meeting button if dates match
            joinMeetingButton.style.display = 'inline-block';
        } else {
            console.log("The dates don't match.");
            // Optionally hide the button if dates don't match
            joinMeetingButton.style.display = 'none';
        }
    });
</script>
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
            <td id="event-date">{{ $event->date}}</td>
            <td>{{ $event->day}}</td>
            <td>{{ \Carbon\Carbon::parse($event->shedulestarttime)->format('h:i A') }}</td>
            <td>{{ \Carbon\Carbon::parse($event->sheduleendtime)->format('h:i A') }}</td>
            <td id="current-date">{{ now()->format('Y-m-d') }}</td>
            <td>
                <a href="{{ route('getToken', ['channelname' => $event->channelname]) }}" class="btn btn-primary" id="join-meeting-btn">
                    Join Meeting
                </a>
                
            </td>
        </tr>
        @endforeach
    </tbody>
</table>





@endsection
