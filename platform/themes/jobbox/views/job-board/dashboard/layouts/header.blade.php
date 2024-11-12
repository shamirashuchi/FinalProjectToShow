@php
    $account = auth('account')->user();
@endphp
{!! Assets::renderHeader(['core']) !!}
@if (BaseHelper::siteLanguageDirection() == 'rtl')
    <link rel="stylesheet" href="{{ Theme::asset()->url('plugins/bootstrap/bootstrap.rtl.min.css') }}">
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/style-dashboard-rtl.css') }}">
@else
    <link rel="stylesheet" href="{{ Theme::asset()->url('plugins/bootstrap/bootstrap.min.css') }}">
@endif

<link rel="stylesheet" href="{{ Theme::asset()->url('css/style-dashboard.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/core/core/base/css/themes/default.css') }}?v={{ get_cms_version() }}">

@if (BaseHelper::siteLanguageDirection() == 'rtl')
    <link rel="stylesheet" href="{{ asset('vendor/core/core/base/css/rtl.css') }}?v={{ get_cms_version() }}">
@endif
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">


@php
    $account = auth('account')->user();
    $type = $account->type->getValue();
@endphp
@php
    Theme::asset()->container('footer')->usePath()->add('candidates-filter', 'js/candidates-filter.js');
@endphp
@php
    use Illuminate\Support\Facades\DB;

    $search = request()->input('search');

    $query = DB::table('jb_accounts');

    $talents = $query->where('type', 'job-seeker')->get();

@endphp
<!-- @if ($account->type == 'job-seeker')
-->
<style>
    .premium-btn {
        background: linear-gradient(45deg, #F9A620, #FFB300);
        border: none;
        color: white;
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 30px;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
        display: inline-block;
        text-align: center;
    }

    .premium-btn:hover {
        background: linear-gradient(45deg, #FFB300, #F9A620);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
        transform: translateY(-3px);
        color: #fff;
    }

    .premium-btn:active {
        transform: translateY(0);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    }


    .premium-blue-btn:hover {
        background: linear-gradient(45deg, #0A9BFF, #0879EA);
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
        transform: translateY(-3px);
        color: #fff;
    }

    .premium-blue-btn:active {
        transform: translateY(0);
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    }


    .premium-dark-btn:hover {
        background: linear-gradient(45deg, #1F3C5A, #05264E);
        box-shadow: 0px 7px 20px rgba(0, 0, 0, 0.5);
        transform: translateY(-3px);
    }


    .bgtalent a {
        color: white;
    }

    .bgtalent a:hover {
        background-color: white;
        color: #F9A620;
        padding: 5px 5px;
    }

    /* header responsive fixing */
    @media (max-width: 1199.98px) {
        .header-sizefix {
            padding: 18px 0 !important;
        }
    }


    @media (max-width: 567px) {
        .setHeader {
            margin-top: 0px;
            margin-bottom: 0px;
        }
    }

    /* Hide the dropdown by default */
    #dropdownMenu {
        display: none; /* Hides the dropdown initially */
    }
    #dropdownMenu.show {
        display: block; /* Shows the dropdown when 'show' class is added */
    }


    /* Default styling */
    .header.header-sizefix {
        padding: 8px 0px;
    }

    /* Styling for specific routes */
    .header.header-sizefix.account-home {
        padding: 8px 0px !important;
    }

    .header.header-sizefix.account-dashboard {
        padding: 23px 0px !important;
    }

    /* Responsive styling for screens smaller than 1199px */
    @media (max-width: 1199px) {
        .header.header-sizefix {
            padding: 10px 0px;
        }
        .header.header-sizefix.account-home {
            padding: 18px 0px !important;
        }
        .header.header-sizefix.account-dashboard {
            padding: 18px 0px !important;
        }
    }

</style>
<!--
@endif
@if ($account->type == 'employer')
<style>
    .setHeader{
        margin-top:40px;
    }
    .bgtalent a{
        color: white;
    }
    .header .main-header .header-left {
    align-items: center;
    display: flex;
   min-width: 1370px;
}

    .bgtalent a:hover{
         background-color: white;
         color:#F9A620;
         padding: 5px 5px;
    }
    @media (min-width: 1200px) and (max-width: 1299px) {
        .header .main-header .header-left {
    align-items: center;
    display: flex;
   min-width: 650px;
}
    .header .main-header .header-right {
    align-items: center;
    display: flex;
   min-width: 60px;
   margin-right:0px;
}
}
@media (min-width: 1300px) and (max-width: 1400px) {
        .header .main-header .header-left {
    align-items: center;
    display: flex;
   min-width: 850px;
}
    .header .main-header .header-right {
    align-items: center;
    display: flex;
   min-width: 60px;
   margin-right:0px;
}
}

    @media (max-width: 567px) {
        .setHeader{
            margin-top:0px;
            margin-bottom: 0px;
        }
    }
</style>
@endif
@if ($account->type == 'consultant')
<style>
    .setHeader{
        margin-top:40px;
    }
    .bgtalent a{
        color: white;
    }
    .header .main-header .header-left {
    align-items: center;
    display: flex;
   min-width: 1300px;
}

    .bgtalent a:hover{
         background-color: white;
         color:#F9A620;
         padding: 5px 5px;
    }
    @media (min-width: 1200px) and (max-width: 1299px) {
        .header .main-header .header-left {
    align-items: center;
    display: flex;
   min-width: 600px;
}
    .header .main-header .header-right {
    align-items: center;
    display: flex;
   min-width: 60px;
   margin-right:0px;
}
}
@media (min-width: 1300px) and (max-width: 1400px) {
        .header .main-header .header-left {
    align-items: center;
    display: flex;
   min-width: 750px;
}
    .header .main-header .header-right {
    align-items: center;
    display: flex;
   min-width: 60px;
   margin-right:0px;
}
}

    @media (max-width: 567px) {
        .setHeader{
            margin-top:0px;
            margin-bottom: 0px;
        }
    }
</style>
@endif -->

<header class="header header-sizefix
    @if (request()->is('account/home') || request()->is('account/settings') || request()->is('account/educations') || request()->is('account/experiences') || request()->is('account/security') || request()->is('account/consultanthome'))
        account-home
    @elseif (request()->is('account/test') || request()->is('account/packages') || request()->is('account/invoices') || request()->is('account/dashboard') || request()->is('account/jobs') || request()->is('account/applicantslist') || request()->is('account/packages/*/subscribe'))
        account-dashboard
    @endif
">
    <div class="container">

        <div class="main-header" style="padding-left: 74px; padding-right: 30px;">
            <div class="header-left d-flex justify-content-between">
                <div class="header-logo">
                    <p class="d-flex" href="#">
                        {{-- @if ($logo = theme_option('logo_employer_dashboard', theme_option('logo')))
                            <img style="max-height:17px;" src="{{ RvMedia::getImageUrl($logo) }}" class="logo"
                                alt="{{ theme_option('site_title') }}">
                        @endif --}}
                        <img src="https://www.mamtaz.com/storage/covers/allthejobsca.png" alt="logo" style="height: auto; width: 214px;">
                    </p>
                </div>
            </div>
            <div class="header-right ">

                <div class="block-signin d-flex align-items-center gap-3 justify-content-end">

                     {{-- @if ($account->canPost())
                            <ul class="nav">
                                <a class="btn btn-default" href="{{ route('public.account.jobs.create') }}">
                                    <li class="fa fa-edit mr-5"></li>
                                    {{ trans('plugins/job-board::dashboard.post_a_job') }}</a>
                            </ul>
                    @endif --}}

                    <ul class="nav">
                        @if (JobBoardHelper::isEnabledCreditsSystem() && $type === 'jobseeker')
                            <a class="" href="{{ route('public.account.test') }}">
                                Get Verified
                            </a>
                        @endif
                    </ul>
                    <ul class="nav">
                        @if (JobBoardHelper::isEnabledCreditsSystem())
                            @if ($account->type == 'job-seeker')
                                <a href="{{ route('public.account.packages') }}"
                                    class="btn nav-link btn-icon premium-btn" style="display: block;">
                                    {!! __('Buy') . '&nbsp;&nbsp;' . __('Credits') !!}
                                </a>

                                </li>
                            @elseif($account->type == 'employer')
                                <a href="{{ route('public.account.packages') }}"
                                    class="btn nav-link btn-icon premium-blue-btn"
                                    style="background: linear-gradient(45deg, #0879EA, #0A9BFF); border: none; color: white; padding: 12px 25px; font-size: 16px; font-weight: 600; border-radius: 30px; box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">
                                    {!! __('Buy') . '&nbsp;&nbsp;' . __('Credits') !!}
                                </a>

                                </li>
                            @elseif($account->type == 'consultant')
                                <a href="{{ route('public.account.packages') }}"
                                    class="btn nav-link btn-icon premium-dark-btn"
                                    style="background: linear-gradient(45deg, #05264E, #1F3C5A); border: none; color: white; padding: 12px 30px; font-size: 16px; font-weight: 600; border-radius: 30px; box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3); transition: all 0.3s ease;">
                                    {!! __('Buy') . '&nbsp;&nbsp;' . __('Credits') !!}
                                </a>
                            @endif
                        @endif
                    </ul>
                    <!-- <span class="mr-2 badge badge-danger">{{ $account->credits }}</span> -->
                    @if ($account->type == 'job-seeker')
                        <ul class="nav">


                            <a class="btn premium-btn" href="{{ route('consultants') }}" style="display: block;">
                                {!! __('Book') . '&nbsp;&nbsp;' . __('Consultant') !!}
                            </a>
                        </ul>
                    @elseif($account->type == 'employer')
                        <ul class="nav">
                            <a class="btn nav-link btn-icon premium-blue-btn" href="{{ route('public.account.jobs.create') }}"
                                style="background: linear-gradient(45deg, #0879EA, #0A9BFF); border: none; color: white; padding: 12px 25px; font-size: 16px; font-weight: 600; border-radius: 30px; box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">
                                {!! __('Post') . '&nbsp;&nbsp;' . __('a job') !!}
                            </a>
                        </ul>
                        @elseif($account->type == 'consultant')
                            {{-- @foreach ($accountsinformations as $accountsinformation) --}}
                                <a href="{{ route('consultants') }}"
                                    class="btn nav-link btn-icon premium-dark-btn"
                                    style="background: linear-gradient(45deg, #05264E, #1F3C5A); border: none; color: white; padding: 12px 30px; font-size: 16px; font-weight: 600; border-radius: 30px; box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3); transition: all 0.3s ease;">
                                    {!! __('Join') . '&nbsp;&nbsp;' . __('Meeting') !!}
                                </a>
                            {{-- @endforeach --}}
                    @endif
                    </ul>

                    <ul class="nav">
                        @if ($account->type == 'job-seeker')
                            <a class="btn premium-btn" href="{{ url('/jobs') }}" style="display: block;">
                                {!! __('Job') . '&nbsp;&nbsp;' . __('Search') !!}
                            </a>
                            @elseif($account->type == 'employer')
                            <a href="{{ route('consultants') }}"
                                class="btn nav-link btn-icon premium-blue-btn"
                                style="background: linear-gradient(45deg, #0879EA, #0A9BFF); border: none; color: white; padding: 12px 25px; font-size: 16px; font-weight: 600; border-radius: 30px; box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2); transition: all 0.3s ease;">
                                {!! __('Hiring') . '&nbsp;&nbsp;' . __('Assistance') !!}
                            </a>
                        @elseif($account->type == 'consultant')
                            <a href="{{ url('/candidates') }}" class="btn nav-link btn-icon premium-dark-btn"
                                style="background: linear-gradient(45deg, #05264E, #1F3C5A); border: none; color: white; padding: 12px 30px; font-size: 16px; font-weight: 600; border-radius: 30px; box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3); transition: all 0.3s ease;">
                                {!! __('Talent') . '&nbsp;&nbsp;' . __('Search') !!}
                            </a>
                        @endif

                    </ul>
                    <!-- <ul class="nav">
                            @if (is_plugin_active('language'))
@include(JobBoardHelper::viewPath('dashboard.partials.language-switcher'))
@endif
                        </ul> -->

                    <div class="member-login">
                        <img alt="" src="{{ $account->avatar_thumb_url }}">
                        <div class="info-member">
                            <strong class="color-brand-1">{{ $account->name }}</strong>
                            <div class="dropdown" id="accountDropdown">
                                <a class="font-xs color-text-paragraph-2 icon-down" id="dropdownProfile" type="button"
                                   data-bs-toggle="dropdown" aria-expanded="false" data-bs-display="static">
                                   {{ __('My Account') }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-light dropdown-menu-end" aria-labelledby="dropdownProfile" id="dropdownMenu">
                                    <li><a class="dropdown-item" href="{{ route('public.account.settings') }}">{{ __('My Account') }}</a></li>
                                    <li>
                                        <form action="{{ route('public.account.logout') }}" method="POST">
                                            @csrf
                                            <button class="dropdown-item">{{ __('Logout') }}</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.getElementById('accountDropdown');
        const dropdownMenu = document.getElementById('dropdownMenu');
        let timer;

        dropdown.addEventListener('mouseenter', function () {
            timer = setTimeout(() => {
                dropdownMenu.classList.add('show'); // Show dropdown
            }, 2000); // 2 seconds delay
        });

        dropdown.addEventListener('mouseleave', function () {
            clearTimeout(timer); // Clear the timer if mouse leaves
            dropdownMenu.classList.remove('show'); // Hide dropdown
        });
    });
</script>

<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const suggestionsContainer = document.getElementById('suggestions');

        searchInput.addEventListener('input', function() {
            const query = searchInput.value;

            if (query.length < 2) {
                suggestionsContainer.innerHTML = '';
                return;
            }

            // Fetch suggestions from the current route
            fetch(`{{ url()->current() }}?search=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    suggestionsContainer.innerHTML = '';
                    for (const suggestion of data) {
                        const suggestionItem = document.createElement('a');
                        suggestionItem.className = 'list-group-item list-group-item-action';
                        suggestionItem.textContent = suggestion;
                        suggestionItem.href =
                            `{{ url()->current() }}?search=${encodeURIComponent(query)}`;
                        suggestionsContainer.appendChild(suggestionItem);
                    }
                });
        });
    });
</script> -->
<!-- <script>
    function fetchResults() {
        const searchTerm = document.getElementById('search').value;

        fetch(`/search?search=${encodeURIComponent(searchTerm)}`)
            .then(response => response.json())
            .then(data => {
                const resultsDiv = document.getElementById('results');
                resultsDiv.innerHTML = '';

                if (data.length > 0) {
                    data.forEach(talent => {
                        resultsDiv.innerHTML += `<p>${talent.first_name} ${talent.last_name}</p>`;
                    });
                } else {
                    resultsDiv.innerHTML = '<p>No results found</p>';
                }
            })
            .catch(error => console.error('Error fetching results:', error));
    }
</script> -->
<!-- <script>
    // Ensure that the DOM is fully loaded before accessing elements
    document.addEventListener('DOMContentLoaded', function() {
        if ($talents - > isNotEmpty()) {
            const suggestionsDiv = document.getElementById('suggestions');
            if (suggestionsDiv) {
                suggestionsDiv.style.display = 'block';
            }
        }
    });
</script> -->

<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Function to remove a query parameter
        function removeQueryParam(param) {
            const url = new URL(window.location.href);
            url.searchParams.delete(param);
            window.history.replaceState({}, '', url);
        }

        // Remove 'search' query parameter
        removeQueryParam('search');

        const Toptalents =
        @json($talents); // You can use `@json($talents)` as a cleaner alternative

        console.log(Toptalents);

        // Ensure the input field is available in the DOM
        const searchInput = document.getElementById('search');

        if (!searchInput) {
            console.error('Element with ID "search" not found');
            return;
        }

        // Add input event listener
        searchInput.addEventListener('input', function() {


            const searchQuery = this.value.toLowerCase();
            console.log("searchquery", searchQuery);
            const talentListContainer = document.getElementById('talentListContainer');
            talentListContainer.innerHTML = '';

            if (searchQuery.length > 0) {
                const filteredTalents = talents.filter(talent =>
                    talent.first_name.toLowerCase().includes(searchQuery) ||
                    talent.last_name.toLowerCase().includes(searchQuery)
                );

                if (filteredTalents.length > 0) {
                    filteredTalents.forEach(talent => {
                        const talentItem = document.createElement('div');
                        talentItem.classList.add('mb-3', 'bgtalent');
                        talentItem.innerHTML =
                            `<a href="/candidates/${talent.first_name.toLowerCase()}-${talent.last_name.toLowerCase()}">${talent.first_name} ${talent.last_name}</a>`;
                        talentListContainer.appendChild(talentItem);
                    });
                    talentListContainer.classList.remove('d-none');
                } else {
                    talentListContainer.classList.add('d-none');
                }
            } else {
                talentListContainer.classList.add('d-none');
            }
        });
    });
</script>
