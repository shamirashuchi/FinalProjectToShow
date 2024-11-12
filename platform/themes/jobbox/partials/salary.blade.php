@if ($job->hide_salary)
    <span class="text-muted">/{{ __('Attractive') }}</span>
@elseif ($job->salary_from && $job->salary_to)
    <span class="card-text-price" title="{{ format_price($job->salary_from) }} - {{ format_price($job->salary_to) }}">
        {{ format_price($job->salary_from) }} - {{ format_price($job->salary_to) }}
    </span>
    <span class="text-muted">/{{ $job->salary_range->label() }}</span>
@elseif ($job->salary_to) {
    <span class="card-text-price" title="{{ __('Upto :price', ['price' => format_price($job->salary_to)]) }}">
        {{ __('Upto :price', ['price' => format_price($job->salary_to)]) }}
    </span>
    <span class="text-muted">/{{ $job->salary_range->label() }}</span>
@else
    <span class="text-muted">/{{ __('Attractive') }}</span>
@endif
