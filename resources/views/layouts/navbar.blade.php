<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">GameAP</a>
        </div>

        <ul class="nav navbar-nav">
            <li><a href="#">{{ __('navbar.main') }}</a></li>
            <li><a href="#">{{ __('navbar.files') }}</a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ __('navbar.servers') }}<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="{{ route('admin.dedicated_servers.index') }}">{{ __('navbar.dedicated_servers') }}</a></li>
                    <li><a href="{{ route('admin.servers.index') }}">{{ __('navbar.game_servers') }}</a></li>
                    <li><a href="{{ route('admin.games.index') }}">{{ __('navbar.games') }}</a></li>
                    <li><a href="#">{{ __('navbar.gdaemon_tasks') }}</a></li>
                </ul>
            </li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ __('navbar.users') }}<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">{{ __('navbar.users') }}</a></li>
                    <li><a href="#">{{ __('navbar.add_user') }}</a></li>
                </ul>
            </li>

            <li><a href="#">{{ __('navbar.profile') }}</a></li>

            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ __('navbar.gameap') }}<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="#">{{ __('navbar.panel_logs') }}</a></li>
                    <li><a href="http://docs.gameap.ru/">{{ __('navbar.documentation') }}</a></li>
                    <li><a href="#">{{ __('navbar.update') }}</a></li>
                    <li><a href="#">{{ __('navbar.error_report') }}</a></li>
                    <li><a href="#">{{ __('navbar.help') }}</a></li>
                </ul>
            </li>
        </ul>

        <button class="btn btn-danger navbar-btn" href="{site_url}auth/out">{{ __('navbar.sign_out') }}</button>
    </div>
</nav>