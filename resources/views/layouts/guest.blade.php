<!DOCTYPE html>
<html lang="{{ (app()->getLocale() ?? app()->getFallbackLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="naive-ui-style">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title : "GameAP" }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body class="dark:bg-stone-800">
    <div id="app">
        <app />
    </div>

    <!-- Scripts -->
    <script src="{{ URL::asset('/js/lang/' . (app()->getLocale() ?? app()->getFallbackLocale()) . '.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('footer-scripts')
</body>
</html>
