@section('content')
@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))
@include(JobBoardHelper::viewPath('dashboard.layouts.menu'))







<style>
    /* .main {
        margin-top: 54px !important;
    }
    
    .btn-expanded {
       
        top: 0px !important;

    }
    
    .nav-item {
        max-width: 140px !important;

    } */
    
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
    // Get the current date and time
    const currentDate = document.getElementById('current-date').textContent.trim();
    const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    // Get the specific event's date and start time
    const eventDate = document.getElementById('event-date').textContent.trim();
    const eventStartTime = document.getElementById('event-start-time').textContent.trim();

    // Get the Join Meeting button for the specific event
    const joinMeetingButton = document.getElementById('join-meeting-btn');

    // Compare the current date and time with the event's date and start time
    if (currentDate === eventDate && currentTime === eventStartTime) {
        console.log("Date and start time match for the event!");
        // Enable the Join Meeting button if conditions match
        joinMeetingButton.style.display = 'inline-block';
        joinMeetingButton.classList.remove('disabled');
    } else {
        console.log("Date and/or start time don't match for the event.");
        // Optionally hide or disable the button if conditions don't match
        joinMeetingButton.style.display = 'none';
    }
});


</script>
<table class="table table-bordered" style="margin-top:200px;">
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
            <td id="event-date">{{ $event->date }}</td>
            <td>{{ $event->day }}</td>
            <td id="event-start-time">{{ \Carbon\Carbon::parse($event->shedulestarttime)->format('H:i') }}</td>
            <td>{{ \Carbon\Carbon::parse($event->sheduleendtime)->format('H:i') }}</td>
            <td id="current-date" style="display:none;">{{ now()->format('Y-m-d') }}</td>
            <td>
                <a href="{{ route('getToken', ['channelname' => $event->channelname]) }}" 
                   class="btn btn-primary disabled" 
                   id="join-meeting-btn" 
                   style="display:none;">
                    Join Meeting
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>





@endsection
