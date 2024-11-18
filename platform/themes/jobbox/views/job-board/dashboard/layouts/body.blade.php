
@include(JobBoardHelper::viewPath('dashboard.layouts.menu-mobile'))
<style>
    .setMainContent{
        margin-top:-800px;
        margin-left:400px;
        margin-bottom:200px;
        margin-right:80px;
        width:75%;
    }
    .setNav{
        margin-left: 80px;
        margin-top: 120px;
        margin-bottom: 100px;
        background-Color: white;
        width:250px;
        border-radius: 8px;
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
    }

</style>

<main class="main" id="mainClose">

    <div class="nav setNav"><a class="btn btn-expanded "></a>
        <nav class="nav-main-menu" style="margin-left: -35px;">
            @include(JobBoardHelper::viewPath('dashboard.layouts.menu'))
        </nav>
    </div>
 
        <div class="content">
{{--            @include(JobBoardHelper::viewPath('dashboard.layouts.breadcrumb'))--}}

            <div id="app" class="setMainContent">
                @yield('content')
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
