<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-black">
    <a class="navbar-brand" href="#">GameAP</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ __('navbar.main') }}</a></li>
            @can('admin roles & permissions')
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ __('navbar.admin') }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.dedicated_servers.index') }}">{{ __('navbar.dedicated_servers') }}</a></li>
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.servers.index') }}">{{ __('navbar.game_servers') }}</a></li>
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.games.index') }}">{{ __('navbar.games') }}</a></li>
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.gdaemon_tasks.index') }}">{{ __('navbar.gdaemon_tasks') }}</a></li>
                    </ul>
                </li>
    
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ __('navbar.users') }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.users.index') }}">{{ __('navbar.users') }}</a></li>
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.users.create') }}">{{ __('navbar.add_user') }}</a></li>
                    </ul>
                </li>
            @endcan
    
            <li class="nav-item"><a class="nav-link" href="{{ route('profile') }}">{{ __('navbar.profile') }}</a></li>
    
            <li class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">{{ __('navbar.gameap') }}<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class="dropdown-item"><a class="dropdown-item" href="https://docs.gameap.ru/">{{ __('navbar.documentation') }}</a></li>

                    @can('admin roles & permissions')
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('modules') }}">{{ __('navbar.modules') }}</a></li>
                    @endcan

                    <li class="dropdown-item"><a class="dropdown-item" href="{{ route('update') }}">{{ __('navbar.update') }}</a></li>
                    <li class="dropdown-item"><a class="dropdown-item" href="{{ route('report_bug') }}">{{ __('navbar.error_report') }}</a></li>
                    <li class="dropdown-item"><a class="dropdown-item" href="{{ route('help') }}">{{ __('navbar.help') }}</a></li>
                </ul>
            </li>
        </ul>
    
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    
        <button
                class="btn btn-danger navbar-btn"
                href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
            {{ __('navbar.sign_out') }}
        </button>
    </div>
</nav>