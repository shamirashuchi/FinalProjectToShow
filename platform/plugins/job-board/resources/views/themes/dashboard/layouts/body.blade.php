@php
    $account = auth('account')->user();
@endphp
<div class="screen-overlay"></div>
<aside class="navbar-aside" id="offcanvas_aside">
    <div class="aside-top">
        <a href="{{ route('public.account.dashboard') }}" class="brand-wrap">
            @if ($logo = theme_option('logo_employer_dashboard', theme_option('logo')))
                <img src="{{ RvMedia::getImageUrl($logo) }}" class="logo" alt="{{ theme_option('site_title') }}">
            @endif
        </a>
        <div>
            <button class="btn btn-icon btn-aside-minimize">
                <i class="text-muted material-icons md-menu_open"></i>
            </button>
        </div>
    </div>
    @include(JobBoardHelper::viewPath('dashboard.layouts.menu'))
</aside>

<main class="main-wrap">
    <header class="main-header navbar">
        <div class="col-search">
        </div>
        <div class="col-nav">
            <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside">
                <i class="material-icons md-apps"></i>
            </button>
            <ul class="nav">
                @if (JobBoardHelper::isEnabledCreditsSystem())
                    <li class="nav-item me-5">
                        <a href="{{ route('public.account.packages') }}" class="nav-link btn-icon">
                            <span>{{ __('Buy credits') }}</span>
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ $account->credits }}
                                <span class="visually-hidden">{{ trans('plugins/job-board::account.credits') }}</span>
                            </span>
                        </a>
                    </li>
                @endif
                @if ($account->canPost())
                    <li class="nav-item">
                        <a href="{{ route('public.account.jobs.create') }}" class="nav-link btn-icon">
                            <i class="far fa-edit mr1"></i>
                            <span>{{ trans('plugins/job-board::dashboard.post_a_job') }}</span>
                        </a>
                    </li>
                @endif
                @if (is_plugin_active('language'))
                    @include(JobBoardHelper::viewPath('dashboard.partials.language-switcher'))
                @endif

                <li class="nav-item">
                    <a href="#" class="requestfullscreen nav-link btn-icon">
                        <i class="material-icons md-cast"></i>
                    </a>
                </li>
                <li class="dropdown nav-item">
                    <a class="dropdown-toggle" data-bs-toggle="dropdown" href="#" id="dropdownAccount" aria-expanded="false">
                        <img class="img-xs rounded-circle" src="{{ $account->avatar_url }}" alt="{{ $account->name }}" />
                    </a>
                    <div class="dropdown-menu dropdown-menu-end float-end" aria-labelledby="dropdownAccount">
                        <a class="dropdown-item" href="{{ route('public.account.overview') }}">
                            <i class="material-icons md-perm_identity"></i>
                            <span>{{ __('My Account') }}</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" href="#">
                            <i class="material-icons md-exit_to_app"></i>
                            <span>{{ __('Sign out') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('public.account.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </header>
    <section class="content-main" id="app-job-board">
        <div class="content-header">
            <div class="header-left">
                <h2 class="content-title card-title">{{ page_title()->getTitle(false) }}</h2>
            </div>

            @yield('header-right')
        </div>

        <div id="main">
            @yield('content')
        </div>
    </section>

    <footer class="font-xs px-4">
        <div class="row pb-15 pt-15">
            <div class="col-sm-6">
                {{ theme_option('copyright') }}
            </div>
        </div>
    </footer>
</main>
