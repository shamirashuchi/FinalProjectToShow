<style>
    /* Custom CSS to trigger dropdown on hover */
    .dropdown:hover .dropdown-menu {
        display: block;
    }

    .dropdown.active .dropdown-menu {
        display: block;
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
        //     $company_id = 1;
        // }

        // Close the connection
        mysqli_close($connection);
    @endphp
@endif





@if ($type == 'employer')
<style>
       .main-menu li a {
    color: #66789c;
    display: block;
    font-family: var(--primary-font), sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 700;
    line-height: 24px;
    padding: 15px 25px;
    position: relative;
    text-decoration: none;
}
.main-menu li a.active{
    background-color: #fff !important;
    border-radius: 8px;
    color: #0879EA !important;
}
    .main-menu li a:hover{
    background-color: #fff !important;
    border-radius: 8px;
    color: #0879EA !important;
}

.main-menu li a.active span {
    color: #0879EA !important;
}
    .main-menu li a:hover span{
    color: #0879EA !important;
}
.main-menu li a img{
    display: inline-block;
    vertical-align: middle;
}
.main-menu li a.active img{
    display: inline-block;
    width: 24px;
    height: 24px;
    filter: none !important;
}

.main-menu li a:hover img{
    display: inline-block;
    width: 24px;
    height: 24px;
    filter: none !important;
}



.dropdown.active .dropdown-menu,
.dropdown:hover .dropdown-menu {
    display: block;
}




</style>
    @php

        $menus = collect([
            [
                'key' => 'public.account.dashboard',
                'icon' => 'imgs/page/dashboard/dashboard.svg',
                'active_icon' => 'imgs/page/dashboard/dashboard-active.svg',
                'name' => __('Dashboard'),
                'order' => 1,
                'enabled' => true,
                'routes' => ['public.account.dashboard'],
            ],
            [
                'key' => 'public.account.settings',
                'icon' => 'imgs/page/dashboard/profile.svg',
                'active_icon' => 'imgs/page/dashboard/profile2_active.svg',
                'name' => 'My Profile',
                'order' => 2,
                'enabled' => true,
                'routes' => ['public.account.settings'],
            ],
            [
                'key' => 'public.account.test',
                'icon' => 'imgs/page/dashboard/verified.svg',
                'active_icon' => 'imgs/page/dashboard/verified-active.svg',
                'name' => 'Get Verified',
                'order' => 3,
                'enabled' => true,
                'routes' => ['public.account.test'],
            ],

            [
                'key' => 'public.account.employer',
                'icon' => 'imgs/page/dashboard/jobs.svg',
                'active_icon' => 'imgs/page/dashboard/jobs2_active.svg',
                'name' => __('Jobs'),
                'order' => 4,
                'enabled' => true,
                'submenus' => [
                    // [
                    //     'key' => 'public.account.jobs.create',
                    //     'icon' => 'imgs/page/dashboard/jobs.svg',
                    //     'active_icon' => 'imgs/page/dashboard/jobs2_active.svg',
                    //     'name' => 'Post a Job',
                    //     'order' => 1,
                    //     'enabled' => true,
                    // ],
                    [
                        'key' => 'public.account.jobs.index',
                        'icon' => 'imgs/page/dashboard/jobs.svg',
                        'active_icon' => 'imgs/page/dashboard/jobs2_active.svg',
                        'name' => 'All Jobs',
                        'order' => 1,
                        'enabled' => true,
                    ],
                    [
                        'key' => 'public.account.applicantslist',
                        'icon' => 'imgs/page/dashboard/jobs.svg',
                        'active_icon' => 'imgs/page/dashboard/jobs2_active.svg',
                        'name' => 'All Applicants',
                        'order' => 2,
                        'enabled' => true,
                    ],
                    // [
                    //     'key' => 'public.account.jobseekermatch',
                    //     'icon' => 'imgs/page/dashboard/jobs.svg',
                    //     'active_icon' => 'imgs/page/dashboard/jobs2_active.svg',
                    //     'name' => 'Matched Profile',
                    //     'order' => 3,
                    //     'enabled' => true,
                    // ],
                    // Add more submenu items here
                ],
            ],

            [
                'key' => 'public.account.packages',
                'icon' => 'imgs/page/dashboard/packages.svg',
                'active_icon' => 'imgs/page/dashboard/packages2_active.svg',
                'name' => __('Package'),
                'order' => 5,
                'enabled' => JobBoardHelper::isEnabledCreditsSystem(),
            ],

            [
                'key' => 'public.account.invoices.index',
                'icon' => 'imgs/page/dashboard/invoice.svg',
                'active_icon' => 'imgs/page/dashboard/invoice2_active.svg',
                'name' => __('Invoices'),
                'order' => 6,
                'enabled' => true,
                'routes' => ['public.account.invoices.show'],
            ],

            [
                'key' => 'public.account.security',
                'icon' => 'imgs/page/dashboard/settings.svg',
                'active_icon' => 'imgs/page/dashboard/settings2_active.svg',
                'name' => __('Security'),
                'order' => 7,
                'enabled' => true,
                // 'submenus' => [
                //     [
                //         'key' => 'public.account.companies.index',
                //         'icon' => 'imgs/page/dashboard/settings.svg',
                //         'active_icon' => 'imgs/page/dashboard/settings2_active.svg',
                //         'name' => 'Company Profile',
                //         'order' => 1,
                //         'enabled' => true,
                //     ],

                //     [
                //         'key' => 'public.account.security',
                //         'icon' => 'imgs/page/dashboard/settings.svg',
                //         'active_icon' => 'imgs/page/dashboard/settings2_active.svg',
                //         'name' => 'Security',
                //         'order' => 2,
                //         'enabled' => true,
                //     ],

                //     // Add more submenu items here
                // ],
            ],

            [
                'key' => 'public.index',
                'icon' => 'imgs/page/dashboard/home.svg',
                'active_icon' => 'imgs/page/dashboard/home2-active.svg',
                'name' => __('Go Home'),
                'order' => 8,
                'enabled' => true,
                'routes' => ['public.account.invoices.show'],
            ],

            [
                'key' => 'public.account.logout',
                'icon' => 'imgs/page/dashboard/logout.svg',
                'active_icon' => 'imgs/page/dashboard/logout2_active.svg',
                'name' => __('Logout'),
                'order' => 9,
                'enabled' => true,
                'routes' => ['public.account.logout'],
            ],
        ]);

        $currentRouteName = Route::currentRouteName();
    @endphp
@elseif($type == 'consultant')

<style>
       .main-menu li a {
    color: #66789c;
    display: block;
    font-family: var(--primary-font), sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 700;
    line-height: 24px;
    padding: 15px 25px;
    position: relative;
    text-decoration: none;
}
.main-menu li a.active{
    background-color: #fff !important;
    border-radius: 8px;
    color: rgb(5, 38, 78) !important;
}
    .main-menu li a:hover{
    background-color: #fff !important;
    border-radius: 8px;
    color: rgb(69, 125, 194) !important;
}

    .main-menu li a.active span {
    color: rgb(69, 125, 194) !important;
}
    .main-menu li a:hover span{
    color: rgb(69, 125, 194) !important;
}
.main-menu li a img{
    display: inline-block;
    vertical-align: middle;
}
.main-menu li a.active img{
    display: inline-block;
    width: 24px;
    height: 24px;
    filter: none !important;
}

.main-menu li a:hover img{
    display: inline-block;
    width: 24px;
    height: 24px;
    filter: none !important;
}

.dropdown.active .dropdown-menu,
.dropdown:hover .dropdown-menu {
    display: block;
}




</style>
    @php

        $menus = collect([
            [
                'key' => 'public.account.consultanthome',
                'icon' => 'imgs/page/dashboard/dashboard.svg',
                'active_icon' => 'imgs/page/dashboard/dashboard3-active.svg',
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
                'key' => 'public.account.shedule',
                'icon' => 'imgs/page/dashboard/tasks.svg',
                'active_icon' => 'imgs/page/dashboard/tasks-active.svg',
                'name' => 'Shedule',
                'order' => 7,
                'enabled' => true,
                'routes' => ['public.account.meets.create'],
            ],
            [
                'key' => 'public.account.index',
                'icon' => 'imgs/page/dashboard/tasks.svg',
                'active_icon' => 'imgs/page/dashboard/tasks-active.svg',
                'name' => 'index',
                'order' => 8,
                'enabled' => true,
                'routes' => ['public.account.meets.index'],
            ],
            [
                'key' => 'public.index',
                'icon' => 'imgs/page/dashboard/jobs.svg',
                'active_icon' => 'imgs/page/dashboard/jobs3-active.svg',
                'name' => 'Go Home',
                'order' => 9,
                'enabled' => true,
                'routes' => ['public.index'],
            ],

            [
                'key' => 'public.account.logout',
                'icon' => 'imgs/page/dashboard/logout.svg',
                'active_icon' => 'imgs/page/dashboard/logout6-active.svg',
                'name' => __('Logout'),
                'order' => 10,
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
                'icon' => 'imgs/page/dashboard/dashboard.svg',
                'active_icon' => 'imgs/page/dashboard/download-new.svg',
                'name' => __('Dashboard'),
                'order' => 1,
                'enabled' => true,
            ],
            [
                'key' => 'public.account.employer',
                'icon' => 'imgs/page/dashboard/profile.svg',
                'active_icon' => 'imgs/page/dashboard/profile_active.svg',
                'name' => __('My profile'),
                'order' => 2,
                'enabled' => true,
                'submenus' => [
                    [
                        'key' => 'public.account.settings',
                        'icon' => 'imgs/page/dashboard/profile.svg',
                        'active_icon' => 'imgs/page/dashboard/profile_active.svg',
                        'name' => 'Overview',
                        'order' => 1,
                        'enabled' => true,
                    ],
                    [
                        'key' => 'public.account.educations.index',
                        'icon' => 'imgs/page/dashboard/profile.svg',
                        'active_icon' => 'imgs/page/dashboard/profile_active.svg',
                        'name' => 'Education',
                        'order' => 2,
                        'enabled' => true,
                    ],
                    [
                        'key' => 'public.account.experiences.index',
                        'icon' => 'imgs/page/dashboard/profile.svg',
                        'active_icon' => 'imgs/page/dashboard/profile_active.svg',
                        'name' => 'Experience',
                        'order' => 3,
                        'enabled' => true,
                    ],
                    // Add more submenu items here
                ],
            ],

            [
                        'key' => 'public.account.test',
                        'icon' => 'imgs/page/dashboard/verified.svg',
                        'active_icon' => 'imgs/page/dashboard/verified1_active.svg',
                        'name' => 'Get Verified',
                        'order' => 3,
                        'enabled' => true,
                    ],

            // [
            //     'key' => 'public.account.employer',
            //     'icon' => 'imgs/page/dashboard/jobs.svg',
            //     'active_icon' => 'imgs/page/dashboard/jobs_active.svg',
            //     'name' => __('Jobs'),
            //     'order' => 3,
            //     'enabled' => true,
            //     'submenus' => [
            //         [
            //             'key' => 'public.account.jobs.saved',
            //             'icon' => 'imgs/page/dashboard/jobs.svg',
            //             'active_icon' => 'imgs/page/dashboard/jobs_active.svg',
            //             'name' => 'Saved Jobs',
            //             'order' => 1,
            //             'enabled' => true,
            //         ],
            //         [
            //             'key' => 'public.account.jobs.applied-jobs',
            //             'icon' => 'imgs/page/dashboard/jobs.svg',
            //             'active_icon' => 'imgs/page/dashboard/jobs_active.svg',
            //             'name' => 'Applied Jobs',
            //             'order' => 2,
            //             'enabled' => true,
            //         ],
            //         [
            //             'key' => 'public.account.jobmatch',
            //             'icon' => 'imgs/page/dashboard/jobs.svg',
            //             'active_icon' => 'imgs/page/dashboard/jobs_active.svg',
            //             'name' => 'Matched Jobs',
            //             'order' => 3,
            //             'enabled' => true,
            //         ],

            //         // Add more submenu items here
            //     ],
            // ],

            [
                'key' => 'public.account.packages',
                'icon' => 'imgs/page/dashboard/packages.svg',
                'active_icon' => 'imgs/page/dashboard/packages_active.svg',
                'name' => __('Package'),
                'order' => 4,
                'enabled' => JobBoardHelper::isEnabledCreditsSystem(),
            ],

            [
                'key' => 'public.account.invoices.index',
                'icon' => 'imgs/page/dashboard/invoice.svg',
                'active_icon' => 'imgs/page/dashboard/invoice_active.svg',
                'name' => __('Invoices'),
                'order' => 5,
                'enabled' => true,
                'routes' => ['public.account.invoices.show'],
            ],


            // adding Settings
            [
                'key' => 'public.account.security',
                'icon' => 'imgs/page/dashboard/settings.svg',
                'active_icon' => 'imgs/page/dashboard/settings_active.svg',
                'name' => 'Security',
                'order' => 6,
                'enabled' => true,
            ],
            // [
            //     'key' => 'public.account.employer',
            //     'icon' => 'imgs/page/dashboard/settings.svg',
            //     'active_icon' => 'imgs/page/dashboard/settings_active.svg',
            //     'name' => __('Settings'),
            //     'order' => 6,
            //     'enabled' => true,
            //     'routes' => ['public.account.settings'],
            //     'submenus' => [
            //         [
            //             'key' => 'public.account.security',
            //             'icon' => 'imgs/page/dashboard/settings.svg',
            //             'active_icon' => 'imgs/page/dashboard/settings_active.svg',
            //             'name' => 'Security',
            //             'order' => 1,
            //             'enabled' => true,
            //         ],
            //         [
            //             'key' => 'public.account.settings',
            //             'icon' => 'imgs/page/dashboard/settings.svg',
            //             'active_icon' => 'imgs/page/dashboard/settings_active.svg',
            //             'name' => 'Overview',
            //             'order' => 2,
            //             'enabled' => true,
            //         ],
            // ],
            // ],

            [
                'key' => 'public.index',
                'icon' => 'imgs/page/dashboard/home.svg',
                'active_icon' => 'imgs/page/dashboard/home-active.svg',
                'name' => 'Go Home',
                'order' => 7,
                'enabled' => true,
                'routes' => ['public.index'],
            ],

            [
                'key' => 'public.account.logout',
                'icon' => 'imgs/page/dashboard/logout.svg',
                'active_icon' => 'imgs/page/dashboard/logout-active.svg',
                'name' => __('Logout'),
                'order' => 8,
                'enabled' => true,
                'routes' => ['public.account.logout'],
            ],
        ]);

        $currentRouteName = Route::currentRouteName();
    @endphp
    <style>
       .main-menu li a {
    color: #66789c;
    display: block;
    font-family: var(--primary-font), sans-serif;
    font-size: 16px;
    font-style: normal;
    font-weight: 700;
    line-height: 24px;
    padding: 15px 25px;
    position: relative;
    text-decoration: none;
}
.main-menu li a.active{
    background-color: #fff !important;
    border-radius: 8px;
    color: #F9A620 !important;
}
    .main-menu li a:hover{
    background-color: #fff !important;
    border-radius: 8px;
    color: #F9A620 !important;
}

    .main-menu li a.active span {
    color: #F9A620 !important;
}
    .main-menu li a:hover span{
    color: #F9A620 !important;
}
.main-menu li a img{
    display: inline-block;
    vertical-align: middle;
}
.main-menu li a.active img{
    display: inline-block;
    width: 24px;
    height: 24px;
    filter: none !important;
}

.main-menu li a:hover img{
    display: inline-block;
    width: 24px;
    height: 24px;
    filter: none !important;
}




.dropdown.active .dropdown-menu,
.dropdown:hover .dropdown-menu {
    display: block;
}




</style>
@endif

<nav class="nav-main-menu">
    <ul class="main-menu">
        @php
        $currentRouteName = Route::currentRouteName();
        @endphp
        @foreach ($menus->where('enabled')->sortBy('order') as $item)
            @php
            $isActive = $currentRouteName == $item['key'] || in_array($currentRouteName, Arr::get($item, 'routes', []));

            $hasActiveSubmenu = isset($item['submenus']) && collect($item['submenus'])->contains(function ($submenu) use ($currentRouteName) {
                return $currentRouteName == $submenu['key'] || in_array($currentRouteName, Arr::get($submenu, 'routes', []));
            });

            $isActive = $isActive || $hasActiveSubmenu;
            @endphp

            @if ($item['key'] === 'public.account.logout')
                <li class="menu-item">
                    <form action="{{ route($item['key']) }}" method="POST" id="formLogout">
                        @csrf
                        <a class="dashboard2" onclick="document.getElementById('formLogout').submit()">
                            <img
                                src="{{ Theme::asset()->url($isActive ? $item['active_icon'] : $item['icon']) }}"
                                alt="{{ $item['key'] }}"
                                class="menu-icon"
                                data-icon="{{ Theme::asset()->url($item['icon']) }}"
                                data-active-icon="{{ Theme::asset()->url($item['active_icon']) }}"
                            >
                            <span class="name">{{ $item['name'] }}</span>
                        </a>
                    </form>
                </li>
            @else






                @if (isset($item['submenus']) && count($item['submenus']) > 0)
                    <li class="menu-item dropdown {{ $isActive ? 'active' : '' }}">
                        <a class="dropdown-toggle {{ $isActive ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="{{ $isActive || $hasActiveSubmenu? 'true' : 'false' }}">
                            <img
                                src="{{ Theme::asset()->url($isActive ? $item['active_icon'] : $item['icon']) }}"
                                alt="{{ $item['key'] }}"
                                class="menu-icon"
                                data-icon="{{ Theme::asset()->url($item['icon']) }}"
                                data-active-icon="{{ Theme::asset()->url($item['active_icon']) }}"
                            >
                            <span class="name">{{ $item['name'] }}</span>
                        </a>
                        <ul class="dropdown-menu {{ $isActive || $hasActiveSubmenu ? 'show' : '' }}" aria-labelledby="navbarDropdown">
                            @foreach ($item['submenus'] as $submenu)
                                @php
                                $isSubmenuActive = $currentRouteName == $submenu['key'] || in_array($currentRouteName, Arr::get($submenu, 'routes', []));
                                @endphp
                                @if ($submenu['name'] == 'Company Profile')
                                    <a class="dashboard2 submenu-toggle   submenuchange {{ $isSubmenuActive ? 'active' : '' }}" href="https://readyforce.ca/account/companies/edit/{{ $company_id }}">
                                        <img src="{{ Theme::asset()->url($isSubmenuActive ? $submenu['active_icon'] : $submenu['icon']) }}" alt="{{ $submenu['key'] }}" class="menu-icon-done"
                                        data-icon="{{ Theme::asset()->url($submenu['icon']) }}"
                                        data-active-icon="{{ Theme::asset()->url($submenu['active_icon']) }}">
                                        @if($type == 'job-seeker')
                                        <span class="name" style="{{ $isSubmenuActive ? 'color: #F9A620;' : '' }}">{{ $submenu['name'] }}</span>
                                        @elseif($type == 'employer')
                                        <span class="name" style="{{ $isSubmenuActive ? 'color: #0879EA;' : '' }}">{{ $submenu['name'] }}</span>
                                        @endif
                                    </a>
                                @else
                                    <a class="dashboard2 submenu-toggle submenuchange {{ $isSubmenuActive ? 'active' : '' }}" href="{{ route($submenu['key']) }}">
                                        <img src="{{ Theme::asset()->url($isSubmenuActive ? $submenu['active_icon'] : $submenu['icon']) }}" alt="{{ $submenu['key'] }}" class="menu-icon-done"
                                        data-icon="{{ Theme::asset()->url($submenu['icon']) }}"
                                        data-active-icon="{{ Theme::asset()->url($submenu['active_icon']) }}">
                                        @if($type == 'job-seeker')
                                        <span class="name" style="{{ $isSubmenuActive ? 'color: #F9A620;' : '' }}">{{ $submenu['name'] }}</span>
                                        @elseif($type == 'employer')
                                        <span class="name" style="{{ $isSubmenuActive ? 'color: #0879EA;' : '' }}">{{ $submenu['name'] }}</span>
                                        @endif
                                    </a>
                                @endif
                                <script>
                                    $(document).ready(function() {

    $('.submenu-toggle').hover(
        function() {

            var icon = $(this).find('.menu-icon-done');
            var activeIcon = icon.data('active-icon');
            console.log($(this));
console.log($(this).hasClass('active'));
            if (!$(this).hasClass('active')) {
                icon.attr('src', activeIcon);
            }
        },
        function() {
            var icon = $(this).find('.menu-icon-done');
            var activeIcon = icon.data('active-icon');
            var defaultIcon = icon.data('icon');


            if ($(this).hasClass('active')) {

                icon.attr('src', activeIcon);
            } else {

                icon.attr('src', defaultIcon);
            }
        }
    );
});
                                    </script>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li class="menu-item {{ $isActive ? 'active' : '' }}">
                        <a class="dashboard2 {{ $isActive ? 'active' : '' }}" href="{{ route($item['key']) }}">
                            <img
                                src="{{ Theme::asset()->url($isActive ? $item['active_icon'] : $item['icon']) }}"
                                alt="{{ $item['key'] }}"
                                class="menu-icon"
                                data-icon="{{ Theme::asset()->url($item['icon']) }}"
                                data-active-icon="{{ Theme::asset()->url($item['active_icon']) }}"
                            >
                            <span class="name">{{ $item['name'] }}</span>
                        </a>
                    </li>
                @endif
            @endif
        @endforeach
    </ul>
</nav>

@include(JobBoardHelper::viewPath('dashboard.partials.profile-completed'))

<script>
    document.querySelectorAll('.menu-item').forEach(item => {
        const img = item.querySelector('.menu-icon');
        const link = item.querySelector('a');
        item.addEventListener('mouseover', () => {
            if (!link.classList.contains('active')) {
                img.src = img.getAttribute('data-active-icon');
            }
        });
        item.addEventListener('mouseout', () => {
            if (!link.classList.contains('active')) {
                img.src = img.getAttribute('data-icon');
            }
        });

});


</script>
