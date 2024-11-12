@include(JobBoardHelper::viewPath('dashboard.layouts.header'))
@include(JobBoardHelper::viewPath('dashboard.layouts.menu-mobile'))
<style>
    .setMainContent{
        margin-top:100px;
        margin-left:0px;
    }
    .setNav{
        margin-left: 40px;
        margin-bottom: 100px;
        border-radius: 12px
    }
    .main-margin{
        margin-top: 0px;
    }
    .box-content {
        display: inline-block;
        overflow: hidden;
        padding: 0px 38px;
        width: 100%
    }
    @media (min-width: 320px) and (max-width: 575px) {

    }

    @media (min-width: 320px) and (max-width: 575px) {
        .setNav{
        margin-left: 0px;
        margin-top: 0px;
        margin-bottom: 0px;
    }
        }
    @media (min-width: 576px) and (max-width: 767.98px) {
        .setMainContent{
            margin-top:0px;
            margin-left:0px;
            background-color: #EFF6F9;
        }
        .setNav{
            margin-left: 0px;
            margin-top: 0px
        }
        .box-content{
            margin-top: 0px !important;
        }
    }
    @media (min-width: 768px) and (max-width: 991.98px) {
        .setMainContent{
            margin-top:0px;
            margin-left:0px;
            background-color: #EFF6F9;
        }
        .setNav{
            margin-left: 0px;
            margin-top: 0px
        }
        .box-content{
            margin-top: 0px !important;
        }
    }


    .mt-negative-50 {
        margin-top: -50px;
    }

    .mt-negative-60 {
        margin-top: -60px;
    }

    .mt-negative-70 {
        margin-top: -70px;
    }

    .mt-27 {
        margin-top: 27px;
    }

    @media (max-width: 991px) {
        .mt-27 {
            margin-top: 90px !important;
        }
    }

    @media (max-width: 575px) {
        .mt-27 {
            margin-top: 0px !important;
        }
    }


</style>

<main class="main main-margin" id="mainClose">

    <div class="nav setNav" style="
            @if (request()->is('account/home'))
                margin-top: 50px;
            @elseif (request()->is('account/test'))
                margin-top: 127px;
            @elseif (request()->is('account/settings'))
                margin-top: 50px;
            @elseif (request()->is('account/educations'))
                margin-top: 20px;
            @elseif (request()->is('account/experiences'))
                margin-top: 20px;
            @elseif (request()->is('account/packages'))
                margin-top: 127px;
            @elseif (request()->is('account/invoices'))
                margin-top: 127px;
            @elseif (request()->is('account/security'))
                margin-top: 40px;
            @elseif (request()->is('account/dashboard'))
                margin-top: 127px;
            @elseif (request()->is('account/jobs'))
                margin-top: 127px;
            @elseif (request()->is('account/jobs/create'))
                margin-top: 127px;
            @elseif (request()->is('account/applicantslist'))
                margin-top: 127px;
            @elseif (request()->is('account/applicants'))
                margin-top: 127px;
            @elseif (request()->is('account/applicants/edit/*'))
                margin-top: 127px;
            @elseif (request()->is('account/consultanthome'))
                margin-top: 50px;
            @elseif (request()->is('account/packages/*/subscribe'))
                margin-top: 127px;
            @endif
        ">
        <nav class="nav-main-menu">
            @include(JobBoardHelper::viewPath('dashboard.layouts.menu'))
        </nav>
    </div>
    <div class="box-content
        @if (request()->is('account/home') || request()->is('account/settings') || request()->is('account/consultanthome'))
            mt-negative-50
        @elseif (request()->is('account/test') || request()->is('account/packages') || request()->is('account/invoices') || request()->is('account/dashboard') || request()->is('account/jobs') || request()->is('account/jobs/create') || request()->is('account/applicantslist') || request()->is('account/applicants') || request()->is('account/applicants/edit/*') || request()->is('account/packages/*/subscribe'))
            mt-27
        @elseif (request()->is('account/educations') || request()->is('account/experiences'))
            mt-negative-70
        @elseif (request()->is('account/security'))
            mt-negative-60
        @endif
    ">

        <div class="content">
{{--            @include(JobBoardHelper::viewPath('dashboard.layouts.breadcrumb'))--}}

            <div id="app" class="setMainContent">
                @yield('content')
            </div>
        </div>

        @include(JobBoardHelper::viewPath('dashboard.layouts.footer'))
    </div>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        var mainClose = document.getElementById('mainClose');
        if (mainClose) {
            var currentUrl = window.location.href;
            var baseUrl = window.location.origin;
            if (currentUrl === baseUrl + "/account/home") {
                mainClose.style.backgroundColor = '#05264E';
            } else if (currentUrl === baseUrl + "/account/packages") {
                mainClose.style.backgroundColor = '#EFF6F9';
            } else if (currentUrl === baseUrl + "/account/settings") {
                mainClose.style.backgroundColor = '#05264E';
            }
        }
    });
</script>

</main>
