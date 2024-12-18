<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    @if (theme_option('favicon'))
        <link rel="shortcut icon" href="{{ RvMedia::getImageUrl(theme_option('favicon')) }}">
    @endif

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ page_title()->getTitle(false) }}</title>

    @yield('header', view(JobBoardHelper::viewPath('dashboard.layouts.header')))

    <!-- Put translation key to translate in VueJS -->
    <script type="text/javascript">
        'use strict';
        window.trans = Object.assign(window.trans || {}, JSON.parse('{!! addslashes(json_encode(trans('plugins/job-board::job-board.themes'))) !!}'));

        var BotbleVariables = BotbleVariables || {};
        BotbleVariables.languages = {
            tables: {!! json_encode(trans('core/base::tables'), JSON_HEX_APOS) !!},
            notices_msg: {!! json_encode(trans('core/base::notices'), JSON_HEX_APOS) !!},
            pagination: {!! json_encode(trans('pagination'), JSON_HEX_APOS) !!},
            system: {
                character_remain: '{{ trans('core/base::forms.character_remain') }}'
            }
        };
    </script>
</head>

<body @if (BaseHelper::siteLanguageDirection() == 'rtl') dir="rtl" @endif>

    @include('core/base::layouts.partials.svg-icon')

    <div id="app">
        @yield('body', view(JobBoardHelper::viewPath('dashboard.layouts.body')))
    </div>

    @stack('pre-footer')

    @if (session()->has('status') || session()->has('success_msg') || session()->has('error_msg') || (isset($errors) && $errors->count() > 0) || isset($error_msg))
        <script type="text/javascript">
            'use strict';
            window.noticeMessages = [];
            @if (session()->has('success_msg'))
                noticeMessages.push({'type': 'success', 'message': "{!! addslashes(session('success_msg')) !!}"});
            @endif
            @if (session()->has('status'))
                noticeMessages.push({'type': 'success', 'message': "{!! addslashes(session('status')) !!}"});
            @endif
            @if (session()->has('error_msg'))
                noticeMessages.push({'type': 'error', 'message': "{!! addslashes(session('error_msg')) !!}"});
            @endif
            @if (isset($error_msg))
                noticeMessages.push({'type': 'error', 'message': "{!! addslashes($error_msg) !!}"});
            @endif
            @if (isset($errors))
                @foreach ($errors->all() as $error)
                    noticeMessages.push({'type': 'error', 'message': "{!! addslashes($error) !!}"});
                @endforeach
            @endif
        </script>
    @endif

    {!! Assets::renderFooter() !!}
    @yield('footer', view(JobBoardHelper::viewPath('dashboard.layouts.footer')))

    @stack('scripts')
    @stack('footer')
</body>
</html>
