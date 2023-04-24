<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title : "GameAP" }}</title>
    @yield('header-scripts')

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/customstyles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/gameap.css') }}">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
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
        @include("components.navbar")
        <div id="main-section" class="main-section small-menu">

            <div id="left-menu" class="collapse navbar-collapse left-menu d-md-block">
                <div id="left-menu-content" class="left-menu-content">
                    @include("components.sidebar")
                </div>
            </div>

            <div class="content-wrapper">
                <div class="container-fluid">
                    <div class="pt-3 content">
                        @yield('breadcrumbs')
                        @include('components.messages')
                        @yield('content')
                        <div class="copyright">
                            Game AdminPanel {{ Config::get('constants.AP_VERSION') }} [{{ Config::get('constants.AP_DATE') }}]<br>
                            Developer: <a href="https://github.com/et-nik" target="_blank">knik</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="left-menu-tooltips" class="left-menu-tooltips"></div>

    <script type="application/javascript">
        if (localStorage.getItem('leftMenuState') !== 'small') {
            document.getElementById('main-section').classList.remove("small-menu");
        } else {
            document.getElementById('brand-link').classList.remove('navbar-brand');

            document.getElementById('brand-logo').classList.remove('logo');
            document.getElementById('brand-logo').classList.add('logo-mini');

            document.getElementById('brand-logo').setAttribute('src', '{{ URL::asset('/images/gap_logo_white_mini.png') }}');
        }
    </script>

    <script src="{{ URL::asset('/js/lang/' . app()->getLocale() . '.js') }}"></script>
    <script src="{{ URL::asset('/js/app.js') }}"></script>

{{--    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>--}}
{{--    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>--}}
    @yield('footer-scripts')
</body>
</html>
