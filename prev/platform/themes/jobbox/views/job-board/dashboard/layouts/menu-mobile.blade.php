@php
    $menus = collect([
        [
            'key'     => 'public.account.dashboard',
            'icon'    => 'imgs/page/dashboard/dashboard.svg',
            'name'    => __('Dashboard'),
            'order'   => 1,
            'enabled' => true,
        ],
        [
            'key'     => 'public.account.jobs.index',
            'icon'    => 'imgs/page/dashboard/jobs.svg',
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
            'icon'    => 'imgs/page/dashboard/recruiters.svg',
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
            'icon'    => 'imgs/page/dashboard/jobs.svg',
            'name'    => __('Applicants'),
            'routes'  => [
                'public.account.applicants.edit',
            ],
            'order'   => 3,
            'enabled' => true,
        ],
        [
            'key'     => 'public.account.packages',
            'icon'    => 'imgs/page/dashboard/tasks.svg',
            'name'    => __('Packages'),
            'order'   => 4,
            'enabled' => JobBoardHelper::isEnabledCreditsSystem(),
        ],
        [
            'key'     => 'public.account.invoices.index',
            'icon'    => 'imgs/page/dashboard/tasks.svg',
            'name'    => __('Invoices'),
            'order'   => 5,
            'enabled' => true,
            'routes'  => ['public.account.invoices.show']
        ],
        [
            'key'     => 'public.account.logout',
            'icon'    => 'imgs/page/dashboard/logout.svg',
            'name'    => __('Logout'),
            'order'   => 6,
            'enabled' => true,
            'routes'  => ['public.account.logout']
        ],
    ]);

    $currentRouteName = Route::currentRouteName();
@endphp

<div class="burger-icon burger-icon-white">
    <span class="burger-icon-top"></span>
    <span class="burger-icon-mid"></span>
    <span class="burger-icon-bottom"></span>
</div>

<div class="mobile-header-active mobile-header-wrapper-style perfect-scrollbar">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-content-area">
            <div class="perfect-scroll">
                <div class="mobile-menu-wrap mobile-header-border">
                    <nav>
                        <ul class="main-menu">
                            @foreach ($menus->where('enabled')->sortBy('order') as $item)
                                @if ($item['key'] === 'public.account.logout')
                                    <form action="{{ route($item['key']) }}" method="post" id="formLogout">
                                        @csrf
                                        <li>
                                            <a class="dashboard2" onclick="document.getElementById('formLogout').submit()">
                                                <img src="{{ Theme::asset()->url($item['icon']) }}" alt="{{ $item['key'] }}">
                                                <span class="name">{{ $item['name'] }}</span>
                                            </a>
                                        </li>
                                    </form>
                                @else
                                <li>
                                    <a class="dashboard2 @if ($currentRouteName == $item['key'] || in_array($currentRouteName, Arr::get($item, 'routes', []))) active @endif" href="{{ route($item['key']) }}">
                                        <img src="{{ Theme::asset()->url($item['icon']) }}" alt="{{ $item['name'] }}">
                                        <span class="name">{{ $item['name'] }}</span>
                                    </a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </nav>
                    <div class="site-copyright">{{ theme_option('copyright') }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
