
<!-- @extends(JobBoardHelper::viewPath('dashboard.layouts.master')) -->
<!-- <style>
    .main {
        margin-top: 54px !important;
    }
    
    .btn-expanded {
       
        top: 0px !important;

    }
    
    .nav-item {
        max-width: 140px !important;

    }
    
    
    
</style> -->
@section('content')
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
            <td>{{ \Carbon\Carbon::parse($event->shedulestarttime)->format('h:i A') }}</td>
            <td>{{ \Carbon\Carbon::parse($event->sheduleendtime)->format('h:i A') }}</td>
            <td>
                <a href="#" 
                   class="btn btn-primary approve-btn" 
                   data-id="{{ $event->id }}">
                    Approve
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<form id="time-fields" action="" method="POST" style="display: none; margin-top: 10px;">
    @csrf <!-- Add this for CSRF protection -->

    <label for="start-time">Start Time:</label>
    <input type="time" id="start-time" class="form-control" name="start_time" required>

    <label for="end-time" style="margin-top: 10px;">End Time:</label>
    <input type="time" id="end-time" class="form-control" name="end_time" required>

    <button type="submit" class="btn btn-success" style="margin-top: 10px;">
        Submit
    </button>
</form>

<script>
    document.querySelectorAll('.approve-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default link behavior

            const eventId = this.getAttribute('data-id'); // Get the event ID from data-id attribute
            const form = document.getElementById('time-fields');

            // Update the form's action URL with the event ID
            form.action = `submitTimes/${eventId}`;
            
            // Display the form
            form.style.display = 'block';
        });
    });
</script>

@endsection




