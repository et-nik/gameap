<nav id="top-menu" class="navbar navbar-expand-md navbar-dark fixed-top bg-black">
    <a id="brand-link" class="navbar-brand" href="/">
        <img id="brand-logo" src="{{ URL::asset('/images/gap_logo_white.png') }}" class="logo">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-target="#left-menu" aria-controls="left-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse bg-black" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto">
            <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">{{ __('navbar.main') }}</a></li>
            @can('admin roles & permissions')
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ __('navbar.admin') }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.dedicated_servers.index') }}">{{ __('navbar.dedicated_servers') }}</a></li>
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.servers.index') }}">{{ __('navbar.game_servers') }}</a></li>
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.games.index') }}">{{ __('navbar.games') }}</a></li>
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.gdaemon_tasks.index') }}">{{ __('navbar.gdaemon_tasks') }}</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">{{ __('navbar.users') }}<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.users.index') }}">{{ __('navbar.users') }}</a></li>
                        <li class="dropdown-item"><a class="dropdown-item" href="{{ route('admin.users.create') }}">{{ __('navbar.add_user') }}</a></li>
                    </ul>
                </li>
            @endcan
        </ul>

        <ul class="navbar-nav">
            <li class="nav-item me-1">
                <a class="btn btn-dark navbar-btn" href="{{ route('profile') }}"><i class="fas fa-user"></i>&nbsp;{{ Auth::user()->name }}</a>
            </li>

            <li class="nav-item">
                {{ Form::open(['id' => 'logout-form', 'url' => route('logout'), 'style'=>'display:inline']) }}
                    {{ csrf_field() }}
                    {{ Form::button( '<i class="fas fa-sign-out-alt"></i>&nbsp;' . __('navbar.sign_out') ,
                    [
                        'class' => 'btn btn-danger navbar-btn',
                        'v-on:click' => $destroyConfirmAction
                            ?? 'confirmAction($event, \'' . __('main.confirm_message'). '\')',
                        'type' => 'submit'
                    ]
                    ) }}
                {{ Form::close() }}
            </li>
        </ul>
    </div>
</nav>
