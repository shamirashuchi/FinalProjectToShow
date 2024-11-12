@php
    $account = auth('account')->user();
    $profileCompletedPercent = 0;

    if ($account->first_name || $account->last_name) {
        $profileCompletedPercent += 50/3;
    }

    if ($account->phone) {
        $profileCompletedPercent += 50/3;
    }

    if ($account->email) {
        $profileCompletedPercent += 50/3;
    }

    if (!empty($account->avatar_id)) {
        $profileCompletedPercent += 20;
    }

    if ($account->companies->count() > 0) {
        $profileCompletedPercent += 30;
    }
@endphp

@if ($profileCompletedPercent < 100 )
    <div class=" mb-20 mt-20"></div>
    <div class="box-profile-completed text-center mb-30">
        <div  id="circle-staticstic-profile" data-percent-completed="{{ $profileCompletedPercent }}"></div>
        <h6 class="mb-10">{{ __('Profile Completed') }}</h6>
    </div>
@endif
@if ($type == 'employer')
<script>
        $(document).ready(function() {
    const percentage = $("#circle-staticstic-profile").data('percent-completed');
    $("#circle-staticstic-profile").circliful({
        foregroundColor: '#0879EA',
        animation: 1,
        foregroundBorderWidth: 20,
        backgroundBorderWidth: 20,
        percent: percentage,
        percentageTextSize: 20,
        textStyle: "font-size: 20px; font-weight: bold; font-family: 'Plus Jakarta Sans', sans-serif",
        fontColor: "#05264E",
        fillColor: "#FFFFFF",
        backgroundColor: "#DFDFDF",
        multiPercentage: 0,
        targetTextSize: 20,
    });
});

    </script>
    @endif
    @if ($type == 'job-seeker')
<script>
        $(document).ready(function() {
    const percentage = $("#circle-staticstic-profile").data('percent-completed');
    $("#circle-staticstic-profile").circliful({
        foregroundColor: '#FFA500',
        animation: 1,
        foregroundBorderWidth: 20,
        backgroundBorderWidth: 20,
        percent: percentage,
        percentageTextSize: 20,
        textStyle: "font-size: 20px; font-weight: bold; font-family: 'Plus Jakarta Sans', sans-serif",
        fontColor: "#05264E",
        fillColor: "#FFFFFF",
        backgroundColor: "#DFDFDF",
        multiPercentage: 0,
        targetTextSize: 20,
    });
});

    </script>
    @endif
    @if ($type == 'consultant')
<script>
        $(document).ready(function() {
    const percentage = $("#circle-staticstic-profile").data('percent-completed');
    $("#circle-staticstic-profile").circliful({
        foregroundColor: 'rgba(5, 38, 78, 1)',
        animation: 1,
        foregroundBorderWidth: 20,
        backgroundBorderWidth: 20,
        percent: percentage,
        percentageTextSize: 20,
        textStyle: "font-size: 20px; font-weight: bold; font-family: 'Plus Jakarta Sans', sans-serif",
        fontColor: "#05264E",
        fillColor: "#FFFFFF",
        backgroundColor: "#DFDFDF",
        multiPercentage: 0,
        targetTextSize: 20,
    });
});

    </script>
    @endif

