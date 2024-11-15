{!! Assets::renderHeader(['core']) !!}

<link rel="stylesheet" href="{{ asset('vendor/core/core/base/css/themes/default.css') }}?v={{ get_cms_version() }}">
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/job-board/css/vendors/normalize.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/job-board/css/vendors/material-icon-round.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/job-board/css/vendors/perfect-scrollbar.css') }}">
<link rel="stylesheet" href="{{ asset('vendor/core/plugins/job-board/css/main.css') }}?v={{ JobBoardHelper::getAssetVersion() }}">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

@if (BaseHelper::siteLanguageDirection() == 'rtl')
    <link rel="stylesheet" href="{{ asset('vendor/core/core/base/css/rtl.css') }}?v={{ get_cms_version() }}">
@endif
