<nav class="navbar navbar-expand-md navbar-light bg-white bb b--black-10">
    <div class="container">

        @if (theme_option('logo'))
            <a href="{{ route('public.index') }}"><img src="{{ RvMedia::getImageUrl(theme_option('logo')) }}"
                alt="{{ theme_option('site_title') }}" height="35"></a>
        @else
            <div class="brand-container tc mr2 br2">
                <a class="navbar-brand b white ma0 pa0 dib w-100" href="{{ route('public.index') }}"
                    title="{{ theme_option('site_title') }}">
                    {{ ucfirst(mb_substr(theme_option('site_title'), 0, 1, 'utf-8')) }}</a>
            </div>
        @endif

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto my-2">
                <!-- Authentication Links -->
                @guest ('account')
                    <li>
                        <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db"
                            style="text-decoration: none; line-height: 32px;" href="{{ route('public.account.login') }}">
                            <i class="fas fa-sign-in-alt"></i> {{ trans('plugins/job-board::dashboard.login-cta') }}
                        </a>
                    </li>
                    <li>
                        <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db"
                            style="text-decoration: none; line-height: 32px;" href="{{ route('public.account.register') }}">
                            <i class="fas fa-user-plus"></i> {{ trans('plugins/job-board::dashboard.register-cta') }}
                        </a>
                    </li>
                @else
                    @php
                        $account = $account ?? auth('account')->user();
                    @endphp
                    <li>
                        <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db mr2"
                            style="text-decoration: none; line-height: 32px;" href="{{ $account->isEmployer() ? route('public.account.dashboard') : route('public.account.overview') }}"
                            title="{{ trans('plugins/job-board::dashboard.header_profile_link') }}">
                            <span>
                                <img src="{{ $account->avatar->url ? RvMedia::getImageUrl($account->avatar->url, 'thumb') : $account->avatar_url }}"
                                    class="br-100 v-mid mr1" alt="{{ $account->name }}" style="width: 30px;">
                                <span>{{ $account->name }}</span>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db mr2"
                            style="text-decoration: none; line-height: 32px;" href="{{ route('public.account.settings') }}"
                            title="{{ trans('plugins/job-board::dashboard.header_settings_link') }}">
                            <i class="fas fa-cogs mr1"></i>{{ trans('plugins/job-board::dashboard.header_settings_link') }}
                        </a>
                    </li>
                    {!! apply_filters(ACCOUNT_TOP_MENU_FILTER, null) !!}

                    @if ($account->isEmployer())
                        @if (JobBoardHelper::isEnabledCreditsSystem())
                            <li>
                                <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db mr2"
                                    style="text-decoration: none; line-height: 32px;" href="{{ route('public.account.packages') }}"
                                    title="{{ trans('plugins/job-board::account.credits') }}">
                                    <i class="far fa-credit-card mr1"></i>{{ trans('plugins/job-board::account.buy_credits') }}
                                    <span class="badge badge-info">{{ $account->credits }} {{
                                        trans('plugins/job-board::account.credits') }}</span>
                                </a>
                            </li>
                        @endif

                        <li>
                            <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db mr2"
                                style="text-decoration: none; line-height: 32px;"
                                href="{{ route('public.account.jobs.index') }}"
                                title="{{ trans('plugins/job-board::dashboard.jobs') }}">
                                <i class="far fa-newspaper mr1"></i>{{ trans('plugins/job-board::dashboard.jobs') }}
                            </a>
                        </li>

                        @if ($account->canPost())
                            <li>
                                <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db mr2"
                                    style="text-decoration: none; line-height: 32px;"
                                    href="{{ route('public.account.jobs.create') }}"
                                    title="{{ trans('plugins/job-board::dashboard.post_a_job') }}">
                                    <i class="far fa-edit mr1"></i>{{ trans('plugins/job-board::dashboard.post_a_job') }}
                                </a>
                            </li>
                        @endif
                    @endif
                    <li>
                        <a class="no-underline mr2 black-50 hover-black-70 pv1 ph2 db"
                            style="text-decoration: none; line-height: 32px;" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            title="{{ trans('plugins/job-board::dashboard.header_logout_link') }}">
                            <i class="fas fa-sign-out-alt mr1"></i><span class="dn-ns">{{
                                trans('plugins/job-board::dashboard.header_logout_link') }}</span>
                        </a>
                        <form id="logout-form" action="{{ route('public.account.logout') }}" method="POST"
                            style="display: none;">
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
