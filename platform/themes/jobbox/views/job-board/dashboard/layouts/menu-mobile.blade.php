<style>
    /* Custom CSS to show submenu on hover */
    .main-menu li.dropdown:hover .dropdown-menu {
        display: block;
        left: 0;
        top: 60%;
        min-width: 200px;
        /* Adjust the width as needed */
        white-space: nowrap;
    }

    /* Ensure submenus stay within the screen boundaries */
    @media (max-width: 768px) {
        .main-menu li {
            position: relative;
        }

        .main-menu {
            overflow-x: hidden;
            /* Hide horizontal overflow */
        }
    }
</style>






@php
    $account = auth('account')->user();
    $type = $account->type->getValue();
    //echo "Welcome, $type!";
    $userid = $account['id'];

@endphp



@if ($type == 'employer')
    @php
        // Establish a connection to the database

        $connection = mysqli_connect('127.0.0.1', 'u482122650_jobfynewadmin', '>Bgn;0XSC1', 'u482122650_jobfynew5');

        // Check the connection
        if ($connection === false) {
            die('ERROR: Could not connect. ' . mysqli_connect_error());
        }

        // Query the database
        $query = "SELECT company_id FROM jb_companies_accounts WHERE account_id = $userid";
        $result = mysqli_query($connection, $query);

        // if ($result) {
        //     $row = mysqli_fetch_assoc($result);
        //     $company_id = $row['company_id'];
        // } else {
        //     $company_id = null;
        // }

        // Close the connection
        mysqli_close($connection);
    @endphp
@endif



@if ($type == 'employer')
    @php

        $menus = collect([
            [
                'key' => 'public.account.dashboard',
                'icon' => 'imgs/page/dashboard/dashboard.svg',
                'name' => __('Dashboard'),
                'order' => 1,
                'enabled' => true,
            ],

            [
                'key' => 'public.account.settings',
                'icon' => 'imgs/page/dashboard/profile.svg',
                'name' => 'My Profile',
                'order' => 2,
                'enabled' => true,
                'routes' => ['public.account.settings'],
            ],

            [
                'key' => 'public.account.test',
                'icon' => 'imgs/page/dashboard/verified.svg',
                'name' => 'Get Verified',
                'order' => 3,
                'enabled' => true,
                'routes' => ['public.account.test'],
            ],

            [
                'key' => 'public.account.jobs.create',
                'icon' => 'imgs/page/dashboard/jobs.svg',
                'name' => __('Jobs'),
                'order' => 4,
                'enabled' => true,
                'submenus' => [
                    [
                        'key' => 'public.account.jobs.create',
                        'icon' => 'imgs/page/dashboard/jobs.svg',
                        'name' => 'Post a Job',
                        'order' => 1,
                        'enabled' => true,
                    ],
                    [
                        'key' => 'public.account.jobs.index',
                        'icon' => 'imgs/page/dashboard/jobs.svg',
                        'name' => 'All Jobs',
                        'order' => 2,
                        'enabled' => true,
                    ],
                    [
                        'key' => 'public.account.applicantslist',
                        'icon' => 'imgs/page/dashboard/jobs.svg',
                        'name' => 'All Applicants',
                        'order' => 3,
                        'enabled' => true,
                    ],
                    [
                        'key' => 'public.account.jobseekermatch',
                        'icon' => 'imgs/page/dashboard/jobs.svg',
                        'name' => 'Matched Profile',
                        'order' => 4,
                        'enabled' => true,
                    ],
                    // Add more submenu items here
                ],
            ],

            [
                'key' => 'public.account.packages',
                'icon' => 'imgs/page/dashboard/packages.svg',
                'name' => __('Packages'),
                'order' => 5,
                'enabled' => JobBoardHelper::isEnabledCreditsSystem(),
            ],

            [
                'key' => 'public.account.invoices.index',
                'icon' => 'imgs/page/dashboard/invoice.svg',
                'name' => __('Invoices'),
                'order' => 6,
                'enabled' => true,
                'routes' => ['public.account.invoices.show'],
            ],

            [
                'key' => 'public.account.security',
                'icon' => 'imgs/page/dashboard/settings.svg',
                'name' => __('Security'),
                'order' => 7,
                'enabled' => true,
                // 'submenus' => [
                //     [
                //         'key' => 'public.account.companies.index',
                //         'icon' => 'imgs/page/dashboard/jobs.svg',
                //         'name' => 'Company Profile',
                //         'order' => 1,
                //         'enabled' => true,
                //     ],
                //     [
                //         'key' => 'public.account.security',
                //         'icon' => 'imgs/page/dashboard/jobs.svg',
                //         'name' => 'Security',
                //         'order' => 2,
                //         'enabled' => true,
                //     ],
                //     [
                //         'key' => 'public.account.settings',
                //         'icon' => 'imgs/page/dashboard/jobs.svg',
                //         'name' => 'Overview',
                //         'order' => 3,
                //         'enabled' => true,
                //     ],
                //     // Add more submenu items here
                // ],
            ],

            [
                'key' => 'public.index',
                'icon' => 'imgs/page/dashboard/home.svg',
                'name' => __('Go Home'),
                'order' => 8,
                'enabled' => true,
                'routes' => ['public.account.invoices.show'],
            ],

            [
                'key' => 'public.account.logout',
                'icon' => 'imgs/page/dashboard/logout.svg',
                'name' => __('Logout'),
                'order' => 9,
                'enabled' => true,
                'routes' => ['public.account.logout'],
            ],
        ]);

        $currentRouteName = Route::currentRouteName();
    @endphp
@elseif($type == 'consultant')
    @php

        $menus = collect([
            [
                'key' => 'public.account.consultanthome',
                'icon' => 'imgs/page/dashboard/dashboard.svg',
                'name' => 'Dashboard',
                'routes' => ['public.account.consultanthome'],
                'order' => 1,
                'enabled' => true,
            ],
            [
                'key' => 'public.account.settings',
                'icon' => 'imgs/page/dashboard/profile.svg',
                'active_icon' => 'imgs/page/dashboard/profile3-active.svg',
                'name' => 'My Profile',
                'routes' => ['public.account.settings'],
                'order' => 2,
                'enabled' => true,
            ],
            [
                'key' => 'public.account.test',
                'icon' => 'imgs/page/dashboard/verified.svg',
                'active_icon' => 'imgs/page/dashboard/verified3-active.svg',
                'name' => 'Get Verified',
                'order' => 3,
                'enabled' => true,
                'routes' => ['public.account.test'],
            ],
            [
                'key' => 'public.account.packages',
                'icon' => 'imgs/page/dashboard/packages.svg',
                'active_icon' => 'imgs/page/dashboard/packages3-active.svg',
                'name' => 'Package',
                // 'routes' => ['public.account.consultant-packages.index', 'public.account.consultant-packages.create'],
                'order' => 4,
                'enabled' => true,
            ],
            [
                'key' => 'public.account.invoices.index',
                'icon' => 'imgs/page/dashboard/invoice.svg',
                'active_icon' => 'imgs/page/dashboard/invoice3_active.svg',
                'name' => __('Invoices'),
                'order' => 5,
                'enabled' => true,
                'routes' => ['public.account.invoices.show'],
            ],
            [
                'key' => 'public.account.security',
                'icon' => 'imgs/page/dashboard/settings.svg',
                'active_icon' => 'imgs/page/dashboard/settings3_active.svg',
                'name' => 'Security',
                'order' => 6,
                'enabled' => true,
            ],
            [
                'key' => 'public.index',
                'icon' => 'imgs/page/dashboard/jobs.svg',
                'active_icon' => 'imgs/page/dashboard/jobs3-active.svg',
                'name' => 'Go Home',
                'order' => 7,
                'enabled' => true,
                'routes' => ['public.index'],
            ],

            [
                'key' => 'public.account.logout',
                'icon' => 'imgs/page/dashboard/logout.svg',
                'active_icon' => 'imgs/page/dashboard/logout6-active.svg',
                'name' => __('Logout'),
                'order' => 8,
                'enabled' => true,
                'routes' => ['public.account.logout'],
            ],
        ]);

        $currentRouteName = Route::currentRouteName();
    @endphp
@elseif($type == 'job-seeker')
    @php

        $menus = collect([
            [
                'key' => 'public.account.home',
                'icon' => 'imgs/page/dashboard/dashboard.svg', // Ensure this path is correct
                'name' => __('Dashboard'),
                'order' => 1,
                'enabled' => true,
                'routes' => ['public.account.home'], // Route name for the home page
            ],
            [
                'key' => 'public.account.settings',
                'icon' => 'imgs/page/dashboard/profile.svg',
                'name' => __('My profile'),
                'order' => 2,
                'enabled' => true,
                'submenus' => [
                    [
                        'key' => 'public.account.settings',
                        'icon' => 'imgs/page/dashboard/profile.svg',
                        'name' => 'Overview',
                        'order' => 1,
                        'enabled' => true,
                    ],
                    [
                        'key' => 'public.account.educations.index',
                        'icon' => 'imgs/page/dashboard/profile.svg',
                        'name' => 'Education',
                        'order' => 2,
                        'enabled' => true,
                    ],
                    [
                        'key' => 'public.account.experiences.index',
                        'icon' => 'imgs/page/dashboard/profile.svg',
                        'name' => 'Experience',
                        'order' => 3,
                        'enabled' => true,
                    ],
                    // Add more submenu items here
                ],
            ],

            // [
            //     'key' => 'public.account.test',
            //     'icon' => 'imgs/page/dashboard/jobs.svg',
            //     'name' => __('Jobs'),
            //     'order' => 3,
            //     'enabled' => true,
            //     'submenus' => [
            //         [
            //             'key' => 'public.account.jobs.saved',
            //             'icon' => 'imgs/page/dashboard/jobs.svg',
            //             'name' => 'Saved Jobs',
            //             'order' => 1,
            //             'enabled' => true,
            //         ],
            //         [
            //             'key' => 'public.account.jobs.applied-jobs',
            //             'icon' => 'imgs/page/dashboard/jobs.svg',
            //             'name' => 'Applied Jobs',
            //             'order' => 2,
            //             'enabled' => true,
            //         ],
            //         [
            //             'key' => 'public.account.jobmatch',
            //             'icon' => 'imgs/page/dashboard/jobs.svg',
            //             'name' => 'Matched Jobs',
            //             'order' => 3,
            //             'enabled' => true,
            //         ],

            //         // Add more submenu items here
            //     ],
            // ],

            [
                'key' => 'public.account.test',
                'icon' => 'imgs/page/dashboard/verified.svg',
                'active_icon' => 'imgs/page/dashboard/verified1_active.svg',
                'name' => 'Get Verified',
                'order' => 3,
                'enabled' => true,
            ],

            [
                'key' => 'public.account.packages',
                'icon' => 'imgs/page/dashboard/packages.svg',
                'name' => __('Packages'),
                'order' => 4,
                'enabled' => JobBoardHelper::isEnabledCreditsSystem(),
            ],

            [
                'key' => 'public.account.invoices.index',
                'icon' => 'imgs/page/dashboard/invoice.svg',
                'name' => __('Invoices'),
                'order' => 5,
                'enabled' => true,
                'routes' => ['public.account.invoices.show'],
            ],
            [
                'key' => 'public.account.security',
                'icon' => 'imgs/page/dashboard/settings.svg',
                'name' => __('Security'),
                'order' => 6,
                'enabled' => true,
                'routes' => ['public.account.settings'],
            ],

            [
                'key' => 'public.index',
                'icon' => 'imgs/page/dashboard/jobs.svg',
                'name' => 'Go Home',
                'order' => 7,
                'enabled' => true,
                'routes' => ['public.index'],
            ],

            [
                'key' => 'public.account.logout',
                'icon' => 'imgs/page/dashboard/logout.svg',
                'name' => __('Logout'),
                'order' => 8,
                'enabled' => true,
                'routes' => ['public.account.logout'],
            ],
        ]);

        $currentRouteName = Route::currentRouteName();
    @endphp
@endif

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
                                            <a class="dashboard2"
                                                onclick="document.getElementById('formLogout').submit()">
                                                <img src="{{ Theme::asset()->url($item['icon']) }}"
                                                    alt="{{ $item['key'] }}">
                                                <span class="name">{{ $item['name'] }}</span>
                                            </a>
                                        </li>
                                    </form>
                                @else
                                    <li class="main-menu-item @if (isset($item['submenus']) && count($item['submenus']) > 0) dropdown @endif">
                                        <a class="dashboard2 @if ($currentRouteName == $item['key'] || in_array($currentRouteName, Arr::get($item, 'routes', []))) active @endif"
                                            href="{{ route($item['key']) }}">
                                            <img src="{{ Theme::asset()->url($item['icon']) }}"
                                                alt="{{ $item['name'] }}">
                                            <span class="name">{{ $item['name'] }}</span>
                                        </a>
                                        @if (isset($item['submenus']) && count($item['submenus']) > 0)
                                            <ul class="dropdown-menu"> <!-- Dropdown sub-menu -->
                                                @foreach ($item['submenus'] as $submenu)
                                                    @if ($submenu['name'] == 'Company Profile')
                                                        <a
                                                            href="https://readyforce.ca/account/companies/edit/{{ $company_id }}">
                                                            <img src="{{ Theme::asset()->url($submenu['icon']) }}"
                                                                alt="{{ $submenu['key'] }}">
                                                            <span class="name">{{ $submenu['name'] }}</span>
                                                        </a>
                                                    @else
                                                        <a href="{{ route($submenu['key']) }}">
                                                            <img src="{{ Theme::asset()->url($submenu['icon']) }}"
                                                                alt="{{ $submenu['key'] }}">
                                                            <span class="name">{{ $submenu['name'] }}</span>
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </ul>
                                        @endif
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
