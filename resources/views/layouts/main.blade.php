<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title : "GameAP" }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('header-scripts')

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/customstyles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('/css/gameap.css') }}">
</head>
<body>

@yield('page-data')

<div id="app">
    <div class="container-fluid">
        <div class="row">
            @include("components.navbar")
        </div>

        <div class="row content-wrapper mt-5">
            <div class="col-md-2 col-lg-2 left-menu">
                @include("components.sidebar")
            </div>
            <div class="col-sm-12 col-md-10 col-lg-10 p-3 content">

                @yield('breadclumbs')

                @include('components.messages')

                @yield('content')
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <p class="copyright">Game AdminPanel {{ Config::get('constants.AP_VERSION') }} [{{ Config::get('constants.AP_DATE') }}]<br> Developer: knik</p>
            </div>
        </div>
    </div>
</div>

<script src="{{ URL::asset('/js/lang/' . app()->getLocale() . '.js') }}"></script>
<script src="{{ URL::asset('/js/app.js') }}"></script>
@yield('footer-scripts')
</body>

</html>