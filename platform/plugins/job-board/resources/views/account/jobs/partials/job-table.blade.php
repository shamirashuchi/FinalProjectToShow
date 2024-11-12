<table class="min-w-full" id="job-table">
    <thead>
        <tr>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-start text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Job title') }}
            </th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-start text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Expire date') }}
            </th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50 text-start text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">
                {{ __('Status') }}
            </th>
            <th class="px-6 py-3 border-b border-gray-200 bg-gray-50"></th>
        </tr>
    </thead>
    <tbody>
        @if ($jobs->count() > 0)
            @foreach($jobs as $job)
                <tr class="bg-white">
                    <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                        @if ($job->moderation_status == \Botble\JobBoard\Enums\ModerationStatusEnum::APPROVED)
                            <a href="{{ $job->url }}" target="_blank" class="text-blue-500 hover:text-green-600">{{ $job->name }}</a>
                        @else
                            {{ $job->name }}
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                        @if ($job->expire_date)
                            @if ($job->expire_date->isPast())
                                <span class="text-yellow-700">{{ $job->expire_date->toDateString() }}</span>
                            @elseif (now()->diffInDays($job->expire_date) < 3)
                                <span class="text-yellow-700">{{ $job->expire_date->toDateString() }}</span>
                            @else
                                <span>{{ $job->expire_date->toDateString() }}</span>
                            @endif
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm leading-5 text-gray-500">
                        {{ $job->status->label() }}
                        @if ($job->moderation_status != \Botble\JobBoard\Enums\ModerationStatusEnum::APPROVED) (<span class="text-yellow-700">{{ $job->moderation_status->label() }} by admin</span>) @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-end text-sm leading-5 font-medium">
                        @if ($job->expire_date && $job->expire_date->isPast())
                            <a href="{{ route('public.account.jobs.renew', $job->id) }}" class="text-blue-600 hover:text-green-600 focus:outline-none focus:underline button-renew">
                                {{ __('Renew') }}
                            </a>
                            |
                        @endif
                        <a href="{{ route('public.account.jobs.analytics', $job->id) }}" class="text-blue-600 hover:text-green-600 focus:outline-none focus:underline">
                            {{ __('Analytics') }}
                        </a>
                        |
                        <a href="{{ route('public.account.jobs.edit', $job->id) }}" class="text-blue-600 hover:text-green-600 focus:outline-none focus:underline">
                            {{ __('Edit') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        @else
            <tr class="bg-white">
                <td colspan="4" class="text-center text-sm text-gray-500 py-4">{{ __('No data') }}</td>
            </tr>
        @endif
    </tbody>
</table>

@push('scripts')
    <div class="modal fade modal-confirm-renew" tabindex="-1" role="dialog" aria-modal="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <h4 class="modal-title p-4 bg-yellow-100 text-yellow-700 font-bold">{{ __('Renew confirmation') }}</h4>

                <div class="modal-body p-4">
                    <div>{{ __('Are you sure you want to renew this job, it will takes 1 credit from your credits') }}</div>
                </div>

                <div class="modal-footer p-4">
                    <button class="py-2 px-4 border border-gray-300 rounded-md text-sm leading-5 font-medium text-gray-700 hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring-blue active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button class="inline-flex justify-center py-2 px-4 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-green-600 hover:bg-green-600 focus:outline-none focus:border-indigo-700 focus:ring-indigo active:bg-green-600 transition duration-150 ease-in-out button-confirm-renew">{{ __('Yes') }}</button>
                </div>
            </div>
        </div>
    </div>
@endpush
