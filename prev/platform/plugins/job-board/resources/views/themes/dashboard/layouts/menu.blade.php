@php
    $menus = collect([
        [
            'key'     => 'public.account.dashboard',
            'icon'    => 'icon material-icons md-home',
            'name'    => __('Dashboard'),
            'order'   => 1,
            'enabled' => true,
        ],
        [
            'key'     => 'public.account.jobs.index',
            'icon'    => 'icon material-icons md-work',
            'name'    => __('Jobs'),
            'routes'  => [
                'public.account.jobs.create',
                'public.account.jobs.edit',
                'public.account.jobs.analytics',
            ],
            'order'   => 2,
            'enabled' => true,
        ],
        [
            'key'     => 'public.account.companies.index',
            'icon'    => 'icon material-icons md-business',
            'name'    => __('Companies'),
            'routes'  => [
                'public.account.companies.create',
                'public.account.companies.edit',
            ],
            'order'   => 3,
            'enabled' => true,
        ],
        [
            'key'     => 'public.account.applicants.index',
            'icon'    => 'icon material-icons md-supervised_user_circle',
            'name'    => __('Applicants'),
            'routes'  => [
                'public.account.applicants.edit',
            ],
            'order'   => 3,
            'enabled' => true,
        ],
        [
            'key'     => 'public.account.packages',
            'icon'    => 'icon material-icons md-money',
            'name'    => __('Packages'),
            'order'   => 4,
            'enabled' => JobBoardHelper::isEnabledCreditsSystem(),
        ],
        [
            'key'     => 'public.account.invoices.index',
            'icon'    => 'icon material-icons md-receipt',
            'name'    => __('Invoices'),
            'order'   => 5,
            'enabled' => true,
            'routes'  => ['public.account.invoices.show']
        ],
    ]);

    $currentRouteName = Route::currentRouteName();
@endphp

<nav>
    <ul class="menu-aside">
        @foreach ($menus->where('enabled')->sortBy('order') as $item)
            <li class="menu-item @if ($currentRouteName == $item['key'] || in_array($currentRouteName, Arr::get($item, 'routes', []))) active @endif">
                <a class="menu-link" href="{{ route($item['key']) }}">
                    <i class="{{ $item['icon'] }}"></i>
                    <span class="text">{{ $item['name'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
    <br />
    <br />
</nav>
