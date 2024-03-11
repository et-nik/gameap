<!DOCTYPE html>
<html lang="{{ (app()->getLocale() ?? app()->getFallbackLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title : "GameAP" }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/login.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="relative flex flex-wrap items-center content-between py-3 px-4  text-white bg-gray-900">
            <div class="container mx-auto sm:px-4 max-w-full mx-auto sm:px-4">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="py-1 px-2 text-md leading-normal bg-transparent border border-transparent rounded collapsed" data-bs-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="px-5 py-1 border border-gray-600 rounded"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="inline-block pt-1 pb-1 mr-4 text-lg whitespace-no-wrap" href="{{ url('/') }}">
                        {{ isset($title) ? $title : "GameAP" }}
                    </a>
                </div>

                <div class="hidden flex-grow items-center" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="flex flex-wrap list-reset pl-0 mb-0 ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class=""><a class="inline-block py-2 px-4 no-underline" href="{{ route('login') }}">{{ __('auth.sign_in') }}</a></li>
                            @if(config('app.allow_registration'))
                                <li class=""><a class="inline-block py-2 px-4 no-underline" href="{{ route('register') }}">{{ __('auth.sign_up') }}</a></li>
                            @endif
                        @else
                            <li class="relative">
                                <a href="#" class=" inline-block w-0 h-0 ml-1 align border-b-0 border-t-1 border-r-1 border-l-1" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class=" absolute left-0 z-50 float-left hidden list-reset	 py-2 mt-1 text-base bg-white border border-gray-300 rounded" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        @yield('content')

        <div class="container mx-auto sm:px-4">
            <div class="flex flex-wrap ">
                <div class="md:w-full pr-4 pl-4">
                    <p class="copyright">
                        Game AdminPanel {{ Config::get('constants.AP_VERSION') }} [{{ Config::get('constants.AP_DATE') }}]<br>
                        Developer: <a href="https://github.com/et-nik" target="_blank">knik</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ URL::asset('/js/lang/' . (app()->getLocale() ?? app()->getFallbackLocale()) . '.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('footer-scripts')
</body>
</html>
