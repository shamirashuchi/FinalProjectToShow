@extends(JobBoardHelper::viewPath('dashboard.layouts.master'))

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
<form action="{{ route('public.account.meets.create.store') }}" method="POST">
    <div class="row">
        <div class="col-12">
            @csrf
            <div class="row">
                <!-- Day Select Field -->
                <div class="col-4 d-none">
                    <div class="form-group">
                        <label class="font-sm color-text-mutted mb-10" for="day">{{ __('Day') }}</label>
                        <select class="form-control @error('day') is-invalid @enderror" id="day" name="day">
                            <option value="">{{ __('Select Day') }}</option>
                            <option value="Monday" {{ old('day') == 'Monday' ? 'selected' : '' }}>Monday</option>
                            <option value="Tuesday" {{ old('day') == 'Tuesday' ? 'selected' : '' }}>Tuesday</option>
                            <option value="Wednesday" {{ old('day') == 'Wednesday' ? 'selected' : '' }}>Wednesday</option>
                            <option value="Thursday" {{ old('day') == 'Thursday' ? 'selected' : '' }}>Thursday</option>
                            <option value="Friday" {{ old('day') == 'Friday' ? 'selected' : '' }}>Friday</option>
                            <option value="Saturday" {{ old('day') == 'Saturday' ? 'selected' : '' }}>Saturday</option>
                            <option value="Sunday" {{ old('day') == 'Sunday' ? 'selected' : '' }}>Sunday</option>
                        </select>
                        @error('day')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Start Time Field -->
                <div class="col-4">
                    <div class="form-group">
                        <label class="font-sm color-text-mutted mb-10" for="start_time">{{ __('Start Time') }}</label>
                        <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="start_time"
                               name="start_time" value="{{ old('start_time') }}" />
                        @error('start_time')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- End Time Field -->
                <div class="col-4">
                    <div class="form-group">
                        <label class="font-sm color-text-mutted mb-10" for="end_time">{{ __('End Time') }}</label>
                        <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="end_time"
                               name="end_time" value="{{ old('end_time') }}" />
                        @error('end_time')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <!-- Date Field -->
                <div class="col-12">
                    <div class="form-group">
                        <label class="font-sm color-text-mutted mb-10" for="date">{{ __('Date') }}</label>
                        <input type="date" class="form-control @error('date') is-invalid @enderror" id="date"
                               name="date" value="{{ old('date') }}" onchange="updateDay()" />
                        @error('date')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="border-bottom pt-10 pb-10 mb-30"></div>
            <div class="box-button mt-15">
                <button class="btn btn-apply-big font-md font-bold">{{ __('Save') }}</button>
            </div>
        </div>
    </div>
</form>

<script>
    function updateDay() {
        const dateInput = document.getElementById('date').value;
        const daySelect = document.getElementById('day');
        
        if (dateInput) {
            const date = new Date(dateInput);
            const daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const dayName = daysOfWeek[date.getUTCDay()];

            // Set the day in the dropdown
            for (let i = 0; i < daySelect.options.length; i++) {
                if (daySelect.options[i].value === dayName) {
                    daySelect.options[i].selected = true;
                    break;
                }
            }
        } else {
            // Clear the day dropdown if no date is selected
            daySelect.selectedIndex = 0;
        }
    }
</script>


@endsection
