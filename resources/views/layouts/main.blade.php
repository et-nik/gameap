<!doctype html>
<html lang="{{ (app()->getLocale() ?? app()->getFallbackLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="naive-ui-style">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title : "GameAP" }}</title>
    @yield('header-scripts')

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ URL::asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ URL::asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ URL::asset('favicon-96x96.png') }}">
</head>
<body>
    <script type="application/javascript">
        window.user = {
            login: "{{ Auth::user()->login }}",
            roles: {!! Auth::user()->getRoles() !!}
        };
    </script>

    @yield('page-data')

    <div id="app">
        <n-dialog-provider>
            <n-message-provider>
                    <main-navbar></main-navbar>
                    <content-view></content-view>
            </n-message-provider>
        </n-dialog-provider>

        <div id="main-section" class="mt-16 mr-5 flex">
            <div class="flex-none">
                <main-sidebar></main-sidebar>
            </div>

            <div class="flex-1">
                <div class="max-w-full">
                    <div class="pt-3 pb-5 content">
                        @yield('breadcrumbs')
                        @include('components.messages')
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="left-menu-tooltips" class="left-menu-tooltips"></div>

    <script src="{{ URL::asset('/js/lang/' . (app()->getLocale() ?? app()->getFallbackLocale()) . '.js') }}"></script>
    <script src="{{ URL::asset('/js/app.js') }}"></script>
    @yield('footer-scripts')
</body>
</html>
